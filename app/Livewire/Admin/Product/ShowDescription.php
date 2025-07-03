<?php

namespace App\Livewire\Admin\Product;

use Livewire\Component;
use Livewire\Attributes\On;

class ShowDescription extends Component
{
    public $text , $title;
    protected $listeners = ['showDescriptionEvent' ];

    public function showDescriptionEvent($description){
        $this->text = $description;
        $this->title = "Description";
        $this->dispatch("showDescriptionModal");
    }

    public function render()
    {
        return view('livewire.admin.product.show-description');
    }
}
