<?php

namespace App\Livewire\Front\Cart;

use App\Models\Product;
use Livewire\Component;

class AddCartButton extends Component
{
    public $productSlug , $finalPrice;
    public $quantity = 1 , $color = null, $size = null;


    public function addCart(){
        try {
            //validate for product slug
            $this->validate([
                'productSlug' => 'required|string|exists:products,slug',
            ]);

            $dataProduct = Product::findBySlug($this->productSlug);
            //Create session 
            $cart = session()->get('cart', []);

            $key = $dataProduct->slug . "&$this->color&$this->size";

            //Check if the product already exists in cart
            if(isset($cart[$key])){
                // $cart[$this->productSlug]['quantity'] = $this->quantity;
                // $color = $cart[$this->productSlug]['color'] = $this->color ?? null;
                // $size =  $cart[$this->productSlug]['size'] = $this->size ?? null;
                // if ($color == null && $size == null) {
                    // }
                    $this->dispatch("productAlreadyInCart");
                    return;
            }else{
                $priceDetails = $dataProduct->getFinalPriceDetails();
                $cart[$key] = [
                    "quantity" => $this->quantity,
                    "max_quantity" => null,
                    "color" => null,
                    "size" =>  null ,
                    "price" => $priceDetails['original'],
                    "name" => $dataProduct->name,
                    "slug" => $dataProduct->slug,
                    "image" => $dataProduct->images->first()?->main_image,
                    "discount" => $priceDetails['discount'] ?? null,
                    "discount_type" => $priceDetails['discountType'] ?? null,
                    "final_price" => $priceDetails['final'],
                    "key" => $key,
                ];
            }
            //Update the cart session
            session()->put('cart', $cart);
            $this->dispatch("successCart");
            $this->dispatch("viewCart", $key);

        } catch (\Throwable) {
            $this->dispatch("errorIdCart");
        }
    } 
    public function render()
    {
        return view('livewire.front.cart.add-cart-button');
    }
}
