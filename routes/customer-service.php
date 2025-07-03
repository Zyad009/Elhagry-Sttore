<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderManagement\Delivery\CustomerServiceAccountController;
use App\Http\Controllers\OrderManagement\Delivery\DeliveryOrderController;

Route::name("delivery_orders.")->prefix("delivery_orders")->middleware('customerService.auth')->group(function () {
  Route::get("/account", [CustomerServiceAccountController::class, "index"])->name("account");
  Route::controller(DeliveryOrderController::class)->group(function () {
    Route::get("/", "index")->name("index");
  });
});
