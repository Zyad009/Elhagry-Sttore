<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\Shop\ShopController;
use App\Http\Controllers\Front\Shop\SingleProductController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [HomeController::class, "index"])->name("home");
Route::get('/about', [AboutController::class, "index"])->name("about");

Route::name("cart.")->prefix("cart")->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::get('/', "index")->name("view");
        Route::put('/update', "update")->name(name: "update");
        Route::delete('/delete', "destroy")->name("delete");
    });
});

Route::get('/checkout', [CheckoutController::class, "index"])->name("checkout")->middleware("auth");
Route::get('/single-product/{product}', [SingleProductController::class, "index"])->name("single.product");
Route::get('/shop', [ShopController::class, "index"])->name("shop");

Route::name('contact.')->prefix("contact")->group(function () {
    Route::controller(ContactController::class)->group(function () {
        Route::get('/', "index")->name("index");
        Route::post('/', "store")->name("store");
    });
});