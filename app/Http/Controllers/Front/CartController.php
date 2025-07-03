<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        return view("front.pages.cart");
    }

    public function update(Request $request)
    {
        $key = $request->key;
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $quantity;
            session()->put('cart', $cart);
            return response()->json(['status' => true, 'message' => 'Cart updated']);
        }

        return response()->json(['status' => false, 'message' => 'Item not found']);
    }

    public function destroy(Request $request)
    {
        $key = $request->key;

        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
            return response()->json(['status' => true, 'message' => 'Item removed from cart']);
        }

        return response()->json(['status' => false, 'message' => 'Item not found']);
    }
}
