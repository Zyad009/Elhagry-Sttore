<?php

namespace App\Livewire\Admin\Offer\Product;

use App\Models\Offer;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Cache;

class AllProduct extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search;
    // public $offers;
    public $selectedOffer = [];
    protected $listeners = ["refreshData" => '$refresh'];

    // public function mount()
    // {
    //     // $this->offers = Cache::remember('offers_with_code', now()->addMinutes(10), function () {
    //     //     return Offer::whereNotNull("name")->get();
    //     // }) ?? collect();
    // }
    #[Computed]
    public function offers(){
            return Offer::whereNotNull("name")->get();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function rules()
    {
        return [
            "selectedOffer" => "required|exists:offers,id", 
        ];
    }

    public function setOffer($id){

        if (!isset($this->selectedOffer[$id])) {
            $this->dispatch("errorOffer");
            return;
        }

        $this->validate([
            "selectedOffer.$id" => "required|exists:offers,id"
        ]);

        $product = Product::find($id);

        $offer = Offer::find($this->selectedOffer[$id]);
        if($offer->discount_type == 'value'){
            if($offer->discount >= $product->price){
                $this->dispatch("errorOfferPrice");
                return;
            }
        }


        $offer = $product->offer;
        if ($offer && $offer->name === null) {
            Offer::where("id", $offer->id)->delete();
        }

        $product->update(["offer_id" => $this->selectedOffer[$id] ]);
        unset($this->selectedOffer[$id]);
        $this->dispatch("successOffer");

    }

    public function cancelle($id)
    {
        $product = Product::with("offer")->find($id);

        $offer = $product->offer; 

        $product->update(["offer_id" => null]);

        if ($offer && $offer->name === null) {
            Offer::where("id", $offer->id)->delete();
        }

        $this->dispatch("deletedOffer");
    }


    public function render()
    {
        // $products = Product::where("name", "LIKE", "%" . $this->search . "%")
        //     ->orWhereHas("category", fn($query) => $query->where("name", "LIKE", "%" . $this->search . "%"))
        //     ->with("category" , "offer")
        //     ->paginate(config("pagination.count"));

        $products = Product::with('category', 'offer')
            ->withCount(['category as has_offer_in_category' => function ($query) {
                $query->whereHas('products', function ($q) {
                    $q->whereNotNull('offer_id');
                });
            }]) // Count products with offers in the category
            ->where(function ($query) {
                $query->where("name", "LIKE", "%" . $this->search . "%")
                    ->orWhereHas("category", function ($q) {
                        $q->where("name", "LIKE", "%" . $this->search . "%");
                    });
            }) //search by name and category
            ->orderByRaw('
                            CASE 
                                WHEN offer_id IS NULL AND has_offer_in_category > 0 THEN 0 
                                ELSE 1 
                            END
                        ') // Order by products with dosenot have offers in the category first
            ->paginate(config("pagination.count"));



        // return view('livewire.admin.offer.product.all-product' , ["products" => $products , "offers" => $this->offers ] ) ;
        return view('livewire.admin.offer.product.all-product' , ["products" => $products ] ) ;
    }
}
