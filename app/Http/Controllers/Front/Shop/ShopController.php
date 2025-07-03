<?php

namespace App\Http\Controllers\Front\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Shop\CategoryRequest;

class ShopController extends Controller
{
    public function index(CategoryRequest $request)
    {
        $request->validated();
        $request->query('category');

        return view("front.pages.shop.products");
    }
}
