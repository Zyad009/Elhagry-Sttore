<?php

namespace App\Livewire\Front\Shop;

use App\Models\Product;
use App\Models\ProductColorSize;
use Livewire\Component;

class SingleProduct extends Component
{
    public $details, $product, $finalPrice;
    public $selectedSize = null, $selectedColor = null, $QTY = 1;

    public function addToCart()
    {
        $nameSize = $this->details[$this->selectedSize]["name"] ?? null;
        $nameColor = $this->details[$this->selectedSize]["colors"][$this->selectedColor]["name"] ?? null;

        $this->validate([
            'selectedSize' => 'required|integer|exists:product_color_sizes,size_id',
            'selectedColor' => 'required|integer|exists:product_color_sizes,color_id',
            'QTY' => 'required|integer|min:1',
        ]);

        $exists = ProductColorSize::where('size_id', $this->selectedSize)
            ->where('color_id', $this->selectedColor)
            ->where("QTY", ">=", $this->QTY)
            ->first();

        $maxQuantity = $exists->QTY ?? 0;

        if (!$exists) {
            $this->dispatch("errorStock");
            $this->QTY = 1;
            return;
        }

        $dataProduct = $this->product;

        // Create session
        $cart = session()->get('cart', []);

        // Generate a unique key based on product, size, and color
        $key = $dataProduct->slug . "&$nameColor&$nameSize";
        $oldKey = $this->product->slug . "&&";
        // Check if the product already exists in the cart
        $priceDetails = $dataProduct->getFinalPriceDetails();
        if (isset($cart[$oldKey])) {
            $cart[$key] = [
                "quantity" => $this->QTY,
                "max_quantity" => $maxQuantity,
                "color" => $nameColor ?? null,
                "size" => $nameSize ?? null,
                "price" => $priceDetails['original'],
                "name" => $dataProduct->name,
                "slug" => $dataProduct->slug,
                "image" => $dataProduct->images->first()?->main_image,
                "discount" => $priceDetails['discount'] ?? null,
                "discount_type" => $priceDetails['discountType'] ?? null,
                "final_price" => $priceDetails['final'],
                "key" => $key, // Store the key internally
            ];
            unset($cart[$oldKey]);
        } else {
            // If the product is not in the cart, add it
            $cart[$key] = [
                "quantity" => $this->QTY,
                "max_quantity" => $maxQuantity,
                "color" => $nameColor ?? null,
                "size" => $nameSize ?? null,
                "price" => $priceDetails['original'],
                "name" => $dataProduct->name,
                "slug" => $dataProduct->slug,
                "image" => $dataProduct->images->first()?->main_image,
                "discount" => $priceDetails['discount'] ?? null,
                "discount_type" => $priceDetails['discountType'] ?? null,
                "final_price" => $priceDetails['final'],
                "key" => $key, // Store the key internally
            ];
        }
        
        // Update the cart session
        session()->put('cart', $cart);
        $this->dispatch("successCart");
        $this->dispatch("viewCart", $key);
        $this->reset("selectedSize", "selectedColor", "QTY");
    }

    public function render()
    {
        return view('livewire.front.shop.single-product');
    }
}


