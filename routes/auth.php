<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\CustomAuth\LoginController;
use App\Http\Controllers\CustomAuth\LogoutController;
use App\Http\Controllers\CustomAuth\RegisterController;
use App\Http\Controllers\CustomAuth\ResetPasswordController;
use App\Http\Controllers\CustomAuth\SocialiteAuthController;
use App\Http\Controllers\CustomAuth\VerfiyAccountController;
use App\Http\Controllers\OrderManagement\Pickup\LoginController as PickupLoginController;
use App\Http\Controllers\OrderManagement\Delivery\LoginController as DeliveryLoginController;

Route::name("login.")->prefix("login")->middleware('guest:web')->group(function(){
  Route::controller(LoginController::class)->group(function(){
    Route::get('/',"index")->name("index");
    Route::post('/',"store")->name("store");
  });
});

Route::name("auth.social.")->prefix("auth")->group(function(){
  Route::controller(SocialiteAuthController::class)->group(function(){
    Route::get('/{driver}/redirect',"redirect")->name("redirect");
    Route::get('/{driver}/callback',"callback")->name("callback");
  });
});

Route::name('sale-officer.')->prefix('sale-officer')->group(function () {
  Route::controller(PickupLoginController::class)->group(function () {
    Route::get("/login", "login")->middleware(['guest:saleOfficer' , 'prevent-back' ])->name("login");
    Route::post("/", "store")->name("store");
  });
});

Route::name('customer-service.')->prefix('customer-service')->group(function () {
  Route::controller(DeliveryLoginController::class)->group(function () {
    Route::get("/login", "login")->middleware(['guest:customerService' , 'prevent-back' ])->name("login");
    Route::post("/", "store")->name("store");
  });
});

Route::post('/register',[RegisterController::class ,"store"])->name("store");
Route::post('/logout',[LogoutController::class ,"out"])->name("logout");






