<?php

namespace App\Livewire\Admin\Offer\Category;

use App\Models\Offer;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class AllCategories extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search;
    // public $offers;
    public $selectedOffer = [];

    // public function mount()
    // {
    //     $this->offers = Offer::whereNotNull("name")->get();
    // }

    #[Computed]
    public function offers()
    {
        return Offer::whereNotNull("name")->get();
    }

    public function rules()
    {
        return [
            "selectedOffer" => "required|exists:offers,id",
        ];
    }

    public function setOffer($id)
    {
        if (!isset($this->selectedOffer[$id])) {
            $this->dispatch("errorOffer");
            return;
        }

        $this->validate();

        $offerId = $this->selectedOffer[$id];
        $offer = Offer::find($offerId);

        Category::where("id", $id)->update(["offer_id" => $offerId]);

        if ($offer->discount_type == "value") {
            $products = Product::where("category_id", $id)->get();

            $successProducts = $products->where("price", ">", $offer->discount);
            $countErrorProducts = $products->where("price", "<=", $offer->discount)->count();

            Product::whereIn('id', $successProducts->pluck('id'))
            ->update(["offer_id" => $offerId]);
            
            if($countErrorProducts > 0){
                $this->dispatch("warningOffer" ,$countErrorProducts); 
            }else{
                 $this->dispatch("successOffer");
            }

        }else{
            Product::where("category_id", $id)->update(["offer_id" => $this->selectedOffer[$id]]);
            $this->dispatch("successOffer");
        }

    }


    public function cancelle($id)
    {

        Category::where("id", $id)->update(["offer_id" => null]);

        Product::where("category_id", $id)->update(["offer_id" => null]);


        $this->dispatch("deletedOffer");
        return;
    }

    public function render()
    {
        $categories = Category::where("name", "LIKE", "%" . $this->search . "%")
            ->doesntHave("children")
            ->withCount("products")
            ->with("offer")
            ->paginate(config("pagination.count"));
        return view('livewire.admin.offer.category.all-categories', ["categories" => $categories, "offers" => $this->offers]);
    }
}
