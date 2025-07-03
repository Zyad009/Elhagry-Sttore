<?php

namespace App\Livewire\Front;

use App\Models\Area;
use App\Models\City;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use Livewire\Component;
use App\Models\PickupPoint;
use App\Models\OrderDetails;
use App\Mail\Order\PendingMail;
use Illuminate\Validation\Rule;
use App\Models\ProductColorSize;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Order\AcceptedPickupMail;

class CheckOut extends Component
{
    public $deliveryMethod, $deliveryType, $deliveryAddress;
    public $cities = [], $areas = [], $selectedCity, $selectedArea, $area = null, $city = null , $addresses , $selectedDeliveryAddress , $addressId ;
    public $apartment , $floor , $building ;
    public $selectedDeliveryService, $priceDeliveryServiceSuper, $priceDeliveryServiceRegular, $priceDelivery;
    public $pickupLocation = null, $pickupPoints;
    public $order;
    public $cart, $total, $paymentMethod, $subTotal = 0 , $totalDiscount = 0;
    public $user, $first_name, $last_name, $address, $notes, $phone, $whatsapp, $email , $finalAddressId;
    public function mount()
    {
        $cart = session()->get("cart", []);
        $this->cart = $cart;

        
        if (count($cart) == 0) {
            alert()->error("Error", "Your cart is empty");
            return back();
        }

        foreach ($cart as $key => $item) {
            if ($item["color"] == null || $item["size"] == null) {
                alert()->error("Error", "Please select color and size for all items in your cart");
                return to_route("cart.view");
            }

            if ($item['max_quantity'] < $item['quantity']) {
                $cart[$key]['quantity'] = 1;
                session()->put('cart', $cart);

                alert()->error("Error", "Please Do Not Play ,The specified quantity is not available.");
                return to_route("cart.view");
            }
        }

        if (!auth()->check()) {
            alert()->error("Error", "Please login to checkout");
            return to_route('login.index');
        }

        $guards = ['admin', 'customerService', 'saleOfficer'];
        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                alert()->error("Error", "You cannot transact with this account.");
                return to_route('login.index');
            }
        }

        // $this->user = User::find(auth()->guard('web')->user()->id)->first();
        $this->user = auth()->guard('web')->user();

        $this->cart = $cart;
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
        $this->phone = $this->user->phone;
        $this->whatsapp = $this->user->whatsapp;
        $this->email = $this->user->email;

        foreach ($cart as $index => $item) {
            $this->subTotal += $item["final_price"] * $item["quantity"];
            $this->totalDiscount  += $item["discount"] * $item["quantity"];
        }
        $this->total = $this->subTotal;
    }

    public function updatedDeliveryMethod($value)
    {
        $this->validate([
            'deliveryMethod' => 'required|string|max:255|in:delivery,pickup',
        ]);

        if ($value === 'pickup') {
            $this->pickupPoints = PickupPoint::all();
            $this->cities = [];
            $this->resetDeliveryDetails();
        } else {
            $this->cities = City::all();
            $this->addresses = Address::where('user_id', $this->user->id)->get();
            $this->pickupPoints = [];
        }
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'deliveryMethod' => 'required|string|max:255|in:delivery,pickup',
            'paymentMethod' => 'required|string|max:255|in:cash,card',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedSelectedCity($cityId)
    {
        if (!$cityId) {
            $this->areas = [];
            $this->selectedArea = null;
            $this->area = null;
            $this->resetDeliveryDetails();
            return;
        }

        $this->city = City::find($cityId);
        $this->areas = Area::where('city_id', $cityId)->get();
    }

    public function updatedPickupLocation($pickupLocation)
    {
        $this->validate([
            'pickupLocation' => 'required|exists:pickup_points,id',
        ]);
    }

    public function updatedSelectedArea($areaId)
    {
        // if (!$areaId) {
        //     $this->resetDeliveryDetails();
        //     return;
        // }

        $this->area = Area::find($areaId);
        $this->priceDeliveryServiceRegular = $this->area->delivery_price_regular;
        $this->priceDeliveryServiceSuper = $this->area->delivery_price_super;
    }

    public function updatedSelectedDeliveryService($value)
    {
        if (!$this->area) {
            $this->resetDeliveryDetails();
            return;
        }

        $this->validate([
            'selectedDeliveryService' => 'required|string|max:255|in:regular,super',
        ]);

        if ($this->deliveryType === 'regular') {
            $this->priceDelivery = $this->priceDeliveryServiceRegular;
            $this->deliveryType = "regular";
        } else {
            $this->priceDelivery = $this->priceDeliveryServiceSuper;
            $this->deliveryType = "super";
        }

        if ($this->priceDelivery !== null) {
            $this->total = $this->subTotal + $this->priceDelivery;
        } else {
            $this->priceDelivery = null;
            $this->total = $this->subTotal;
        }
    }

    public function updatedSelectedDeliveryAddress($addressId)
    {
        if (empty($addressId)) {
            $this->resetDeliveryDetails();
            $this->selectedDeliveryAddress = null;
            return;
        }

        if ($addressId === 'new') {
            $this->selectedDeliveryAddress = 'new';
            $this->resetDeliveryDetails();
            return;
        }


        // $this->addressId = $addressId;
        // $address = Address::select('area_id')->find($this->selectedDeliveryAddress);
        $areaId = Address::where('id' , $addressId)->value('area_id');
       
        if ($areaId) {
            $this->area = Area::find($areaId);
            if (!$this->area) {
                $this->dispatch('errorPlay');
                $this->resetDeliveryDetails();
                $this->selectedDeliveryAddress = null;
                $this->address = null;
                return;
            }

            $this->priceDeliveryServiceRegular = $this->area->delivery_price_regular;
            $this->priceDeliveryServiceSuper = $this->area->delivery_price_super;
        } else {
            $this->resetDeliveryDetails();
            $this->selectedDeliveryAddress = null;
            $this->dispatch('errorPlay');
        }
    }

    public function submit()
    {

        $this->validate();

        if ($this->deliveryMethod === 'delivery') {

            if ($this->selectedDeliveryAddress !== 'new') {
                $this->validate([
                    'selectedDeliveryAddress' => [
                        'required',
                        Rule::exists('addresses', 'id')->where(function ($q) {
                            $q->where('user_id', $this->user->id);
                        }),
                    ],
                ]);
                $this->finalAddressId = $this->selectedDeliveryAddress;
            }else{
                $this->validate([
                    'selectedCity' => 'required|exists:cities,id',
                    'selectedArea' => [
                        'required',
                        Rule::exists('areas', 'id')
                            ->where(function ($q) {
                                $q->where('city_id', $this->selectedCity);
                            })
                    ],
                    'selectedDeliveryService' => 'required|string|in:regular,super',
                    'building' => 'required|integer|min:0|max:9999',
                    'floor' => 'required|integer|min:0|max:999',
                    'apartment' => 'required|integer|min:0|max:9999',
                    'address' => 'required|string|max:500',
                ]);
            }
        }

        if ($this->deliveryMethod === 'pickup') {
            $this->validate([
                'pickupLocation' => 'required|exists:pickup_points,id',
            ]);
        }
        
        try {
            DB::transaction(function () {
                if ($this->deliveryMethod === 'pickup') {
                    $followUpCode = null;
                    $pickupPoint = $this->pickupPoints->find($this->pickupLocation);
                    $pickupCode = $this->generatePickupCode();
                    $this->deliveryAddress = $pickupPoint->name;
                    $this->resetDeliveryDetails();
                } else {
                    $pickupCode = null;
                    if($this->selectedDeliveryAddress === 'new'){
                        $this->deliveryAddress = $this->address . ', [' . $this->area->name . '], [' . $this->area->city->name . ']';
                        $address = Address::create([
                            'user_id' => $this->user->id,
                            'city_id' => $this->selectedCity,
                            'area_id' => $this->selectedArea,
                            'building' => $this->building,
                            'floor' => $this->floor,
                            'apartment' => $this->apartment,
                            'address' => $this->deliveryAddress,
                        ]);
                        $this->finalAddressId = $address->id;
                    }else{
                        $address = Address::find($this->selectedDeliveryAddress);
                    }

                    $followUpCode = time();
                }

                $statusOrder = $this->deliveryMethod === 'delivery' ? 'pending' : 'accepted';
                
                $order = Order::create([
                    "user_id" => $this->user->id,
                    "pickup_points_id" => $this->pickupLocation,
                    "payment_method" => $this->paymentMethod ?? "cash",
                    "payment_status" => $this->paymentMethod == "cash" ? true : false,
                    "delivery_method" => $this->deliveryMethod,
                    "delivery_type" => $this->deliveryType,
                    "city" => $address->city->name ?? null,
                    "area" => $address->area->name ?? null,
                    "pickup_code" => $pickupCode,
                    "follow_up_code" => $followUpCode,
                    "total" => $this->subTotal,
                    "total_discount"=> $this->totalDiscount,
                    "delivery_price" => $this->priceDelivery,
                    "finally_total" => $this->total,
                    "name" => $this->first_name . ' ' . $this->last_name,
                    "phone" => $this->phone,
                    "email" => $this->email,
                    "address_id" => $this->finalAddressId,
                    "status_order" => $statusOrder,
                    "status" => false,
                    "order_date" => now(),
                    "notes" => $this->notes,
                ]);

                $this->order = $order;

                $arr = []; 
                foreach ($this->cart as $item) {

                    // $product = Product::findBySlug($item['slug']);
                    $finalPrice = $item['final_price'] * $item['quantity'];
                    OrderDetails::create([
                        'order_id' => $order->id,
                        'product_name' => $item['name'],
                        'QTY' => $item['quantity'],
                        'color' => $item['color'],
                        'size' => $item['size'],
                        'price' => $item['price'],
                        'discount' => $item['discount'],
                        'discount_type' => $item['discount_type'],
                        'final_price' => $finalPrice,
                        'slug' => $item['slug'],
                    ]);

                    $arr[$item['slug']] = ($arr[$item['slug']] ?? 0) + $item['quantity'];

                    ProductColorSize::whereHas("product", function ($q) use ($item) {
                            $q->where("slug" , $item['slug']);
                        })
                        ->whereHas("color", function ($q) use ($item) {
                            $q->where("name", $item['color']);
                        })
                        ->whereHas("size", function ($q) use ($item) {
                            $q->where("name", $item['size']);
                        })
                        ->decrement('QTY', $item['quantity']);
                }
                foreach ($arr as $slug => $qty) {
                    Product::where('slug', $slug)->update([
                        'QTY' => DB::raw("QTY - $qty") ,
                        'sold' => DB::raw("sold + $qty") ,
                    ]);
                }
            });

            $this->order->load('orderDetails');
                    if ($this->deliveryMethod === 'delivery') {
                        Mail::to($this->email)->send(new PendingMail($this->order));
                    }elseif($this->deliveryMethod === 'pickup'){
                        Mail::to($this->email)->send(new AcceptedPickupMail($this->order));
                    }

            session()->forget('cart');
            alert()->success('Success', 'Order has been placed successfully!');
            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error('Order Submit Error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            dd($e->getMessage());
            alert()->error('Error', 'Something went wrong. Please try again.');
            return back();
        }
    }

    private function generatePickupCode()
    {
        $letters = ["z", "x", "a", "s", "f", "r", "t", "k", "g", "b", "h"];
        $randomLetter = $letters[rand(0, count($letters) - 1)];
        return strtoupper($randomLetter . rand(1000, 9999));
    }

    private function resetDeliveryDetails()
    {
        if(isset($this->city->name)){
            $this->city->name = null;
        }
        if(isset($this->area->name)){
            $this->area->name = null;
        }
        $this->priceDeliveryServiceRegular = null;
        $this->priceDeliveryServiceSuper = null;
        $this->priceDelivery = null;
        $this->selectedDeliveryService = null;
        $this->deliveryType = null;
        $this->total = $this->subTotal;
        $this->deliveryAddress = null ; 
        $this->selectedCity = null;
        $this->selectedArea = null;
        // $this->selectedDeliveryAddress = null;
        // $this->addressId = null;
        $this->apartment = null;
        $this->floor = null;
        $this->building = null;
    }


    public function render()
    {
        return view('livewire.front.check-out');
    }
}
