<?php

namespace App\Livewire\Front\Cart;

use Livewire\Component;

class ViewCartComponent extends Component
{

    public $productKey , $totalPrice = 0, $count = 0 , $data ; 
    protected $listeners = ["viewCart" , "updateCart" , "updateDataCart"];

    public function mount(){
                $this->updateCart();
    }

    public function updateDataCart($oldKey , $newKey){
        $this->productKey = $newKey;
    }

    public function viewCart($productKey){
        $cart = session()->get('cart' , []);
        $this->data = $cart;

        $this->totalPrice += $cart[$productKey]['final_price'] * $cart[$productKey]['quantity'];
        $this->count = count($cart);
        
        $this->updateCart();
    }

    public function removeProduct($productKey ){
        $cart = session()->get('cart' , []);

        if(isset($cart[$productKey])){
            unset($cart[$productKey]);
            session()->put('cart', $cart);
        }
        $this->dispatch('updateCart');
    }
        
    public function updateCart(){
        $cart = session()->get('cart' , []);
        $this->data = $cart;
        $this->totalPrice = 0;
        foreach ($cart as $item) {
            $this->totalPrice += ($item['final_price'] * $item['quantity']);
        }
        $this->count = count($cart);
    }

    public function render()
    {
        return view('livewire.front.cart.view-cart-component');
    }
}
