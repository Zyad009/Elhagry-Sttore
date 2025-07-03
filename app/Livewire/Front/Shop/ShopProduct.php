<?php

namespace App\Livewire\Front\Shop;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class ShopProduct extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search;

    #[Url(except: '')]
    public $category;

    public $title , $categoryName;

    public function mount()
    {
        if (isset($this->category) && $this->category != null) {
            $category = Category::where("slug", $this->category)->first();
            $this->title = $category->name;
        }else{
            $this->title = "All Products";
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function selectCategory($slug , $name)
    {
        $this->resetPage();
        $this->category = $slug;
        $this->categoryName = Null;
        $this->title = $name;
    }
    
    public function resetFilters()
    {
        $this->title = "All Products";
        $this->category = null;
        $this->categoryName = null;
        $this->search = '';
    }


    public function render()
    {
        $products = Product::with("offer", "category", "images", "reviews")
            ->when($this->category, function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->where('slug', $this->category);
                });
            })
            ->where("name", "LIKE", "%" . $this->search . "%")
            ->paginate(config("pagination.count"));
            
        $categories = Category::withCount(relations: "products")
            ->doesntHave("children")
            ->get();
        return view('livewire.front.shop.shop-product', compact("categories", "products"));
    }
}
