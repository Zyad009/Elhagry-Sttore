<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get("cart", []);

        if (count($cart) == 0) {
            alert()->error("Error", "Your cart is empty");
            return back();
        }

        if (!auth()->check()) {
            alert()->error("Error", "Please login to checkout");
            return to_route('login.index');
        }

        return view("front.pages.checkout");
    }
}

