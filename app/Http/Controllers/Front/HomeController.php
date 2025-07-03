<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bestSellingIds = Product::orderByDesc('sold')
            ->take(8)
            ->whereNull('deleted_at')
            // ->whereNull('QTY')
            ->pluck('id');

        $newestIds = Product::orderByDesc('created_at')
            ->take(8)
            ->whereNull('deleted_at')
            // ->whereNull('QTY')
            ->pluck('id');

        $products = Product::with(['category', 'offer', 'images'])
            ->whereIn('id', $bestSellingIds->merge($newestIds)->unique())
            ->get();

        $productsBest = $products->whereIn('id', $bestSellingIds)
            ->sortByDesc('sold');

        $productsNew = $products->whereIn('id', $newestIds)
            ->sortByDesc('created_at');



        return view("front.pages.home", compact("productsBest", "productsNew"));
    }
}
