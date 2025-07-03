<?php

namespace App\Http\Controllers\Front\Shop;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SingleProductController extends Controller
{
    public function index(Product $product)
    {
        $details = $product->getDetails();

        $productsBest = Product::with("category", "offer", "images", "reviews")
            ->where("id", "!=", $product->id)
            // ->whereNull("deleted_at")
            // ->whereNull("QTY")
            ->orderByDesc("sold")
            ->take(4)
            ->get();

        return view("front.pages.shop.singl-product", compact("product", "details", "productsBest"));
    }
}
