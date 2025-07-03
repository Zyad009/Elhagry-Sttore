<?php
namespace App\Livewire\OrderManagement\DeliveryOrder;

use App\Models\Area;
use App\Models\City;
use App\Models\Order;
use Illuminate\Validation\Rule;
use Livewire\Component;


    use function PHPUnit\Framework\directoryExists;

    class ShowDetailsOrder extends Component
    {
        public $phone, $whatsapp , $name, $mainPrice, $discount, $deliveryPrice, $finallyTotal, $orderCode, $status , $nameCity , $nameArea , $deliveryType;
        public $selectedCity, $selectedArea, $selectedDelivery , $selectedDeliveryprice;
        public $priceDeliveryServiceRegular, $priceDeliveryServiceSuper;
        public $cities = [] , $areas  = [] , $cityName, $areaName ;
        public $orderCityId, $orderAreaId, $address , $floor , $apartment, $building ;

        protected $listeners = ['showDetailsOrderEvent'];

        public function mount()
        {
            $this->cityName = null;
            $this->areaName = null;
            $this->selectedCity = null;
            $this->selectedArea = null;
            $this->selectedDelivery = null;
            $this->priceDeliveryServiceRegular = null;
            $this->priceDeliveryServiceSuper = null;
            $this->cities = City::select('id', 'name')
                ->get();
        }

        public function showDetailsOrderEvent(
            $orderId
            // $phone,$whatsapp ,$name, $address, $mainPrice, $discount, $deliveryPrice, $finallyTotal, $orderCode, $status , $nameCity, $nameArea , $deliveryType
            )
        {
            $this->selectedDelivery = null;
            $this->priceDeliveryServiceRegular = null;
            $this->priceDeliveryServiceSuper = null;

            $order = Order::find($orderId);

            $this->phone = $order->phone;
            $this->whatsapp = $order->user->whatsapp;
            $this->name = $order->name;
            $this->address = $order->address->address;
            $this->mainPrice = $order->total;
            $this->discount = $order->total_discount;
            $this->deliveryPrice = $order->delivery_price;
            $this->finallyTotal = $order->finally_total;
            $this->orderCode = $order->follow_up_code;
            $this->status = $order->status_order;
            $this->deliveryType = $order->delivery_type;
            $this->nameCity = $order->city;
            $this->nameArea = $order->area;
            $this->orderCityId = $order->address->city_id;
            $this->orderAreaId = $order->address->area_id;
            $this->building = $order->address->building;
            $this->floor = $order->address->floor;
            $this->apartment = $order->address->apartment;
            $this->selectedCity = $order->address->city_id; 
            $this->selectedArea = $order->address->area_id; 
            $this->selectedDelivery = $order->delivery_type ;
            $this->areaName = $order->area;
            $this->cityName = $order->city;
            $this->areas = Area::where('city_id', $this->orderCityId)->select('id', 'name', 'delivery_price_regular', 'delivery_price_super')->get();
            if ($this->deliveryType == 'regular') {
                $this->priceDeliveryServiceSuper = $order->address->area->delivery_price_super;
            } elseif ($this->deliveryType == 'super') {
                $this->priceDeliveryServiceRegular = $order->address->area->delivery_price_regular;
            } else {
                $this->selectedDeliveryprice = null;
            }
            $this->dispatch('showModelToggle');
        }
        
        
        public function updatedSelectedCity($cityId)
        {
            $this->priceDeliveryServiceSuper = null;
            $this->priceDeliveryServiceRegular = null; 
            $this->selectedArea = null;
            $this->selectedDeliveryprice = null;
            $this->selectedDelivery = null;
            $this->priceDeliveryServiceRegular = null;
            $this->priceDeliveryServiceSuper = null;
            $this->building = null;
            $this->floor = null;
            $this->apartment = null;
            $this->areas = Area::where('city_id', $cityId)->select('id', 'name', 'delivery_price_regular', 'delivery_price_super')->get();
            $city = City::where('id', $cityId)->first();
            $this->cityName = $city->name;
        }

    public function updatedSelectedArea($areaId)
    {
        $this->priceDeliveryServiceSuper = null;
        $this->priceDeliveryServiceRegular = null;
        $this->selectedDeliveryprice = null;
        $this->selectedDelivery = null;
        $this->priceDeliveryServiceRegular = null;
        $this->priceDeliveryServiceSuper = null;
        $this->building = null;
        $this->floor = null;
        $this->apartment = null;
        $this->selectedDelivery = null;
        $this->address = null;

        $area = Area::where('id' , $areaId)->first();

        $this->areaName = $area->name;

        if ($area) {
            $this->deliveryPrice = $area->delivery_price_regular;
            $this->deliveryType = 'regular';
            $this->finallyTotal = $this->mainPrice + $area->delivery_price_regular;
            $this->priceDeliveryServiceRegular = $area->delivery_price_regular;
            $this->priceDeliveryServiceSuper = $area->delivery_price_super;
        }
    }


    public function updatedSelectedDeliveryPrice($deliveryType)
    {
        if ($deliveryType == 'regular') {
            $this->selectedDeliveryprice = $this->priceDeliveryServiceRegular;
            $this->deliveryType = 'regular';
            $this->deliveryPrice = $this->priceDeliveryServiceRegular;
            $this->finallyTotal = $this->mainPrice + $this->deliveryPrice;
            $this->selectedDelivery = 'regular';
        } elseif ($deliveryType == 'super') {
            $this->selectedDeliveryprice = $this->priceDeliveryServiceSuper;
            $this->deliveryType = 'super';
            $this->deliveryPrice = $this->priceDeliveryServiceSuper;
            $this->finallyTotal = $this->mainPrice + $this->deliveryPrice;
            $this->selectedDelivery = 'super';
        } else {
            $this->selectedDeliveryprice = null;
        }
    }


        public function updateAddress()
        {
        $this->validate([
            'selectedCity' => 'required|exists:cities,id',
            'selectedArea' => ['required' ,
                Rule::exists('areas' , 'id')
                ->where(function($q){
                    $q->where('city_id', $this->selectedCity);
                })
        ],
            'selectedDelivery' => 'required|in:regular,super',
        ]);

            $order = Order::where('follow_up_code', $this->orderCode)->first();
            $address = $order->address;
            $deliveryAddress = $this->address . ', [' . $this->areaName . '], [' . $this->cityName . ']';


        $order->update([
                'city' => $this->cityName,
                'area' => $this->areaName,
                'address' => $deliveryAddress,
                'delivery_price' => $this->deliveryPrice,
                'finally_total' => $this->finallyTotal,
                'delivery_type' => $this->deliveryType,
            ]);
        $address->update([
                'city_id' => $this->selectedCity,
                'area_id' => $this->selectedArea,
                'address' => $deliveryAddress,
                'building' => $this->building,
                'floor' => $this->floor,
                'apartment' => $this->apartment,
            ]);

                $this->dispatch('showModelToggle');
                $this->dispatch('addressUpdated');
        }

        public function render()
        {
            return view('livewire.order-management.delivery-order.show-details-order');
        }
    }
