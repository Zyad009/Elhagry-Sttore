<?php

namespace App\Livewire\Front\Home;

use Livewire\Component;

class SelectCategoryComponent extends Component
{
    public $categorySlug , $categoryName;

    public function showCategoryShop(){
        
    }
    public function render()
    {
        return view('livewire.front.home.select-category-component');
    }
}
