<?php

use App\Http\Controllers\OrderManagement\Pickup\PickupHomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderManagement\Pickup\LoginController;
use App\Http\Controllers\OrderManagement\Pickup\PickupOrderController;
use App\Http\Controllers\OrderManagement\Pickup\SaleOfficerAccountController;

Route::name("pickup_orders.")->prefix("pickup_orders")->middleware('saleOfficer.auth')->group(function () {
  Route::get("/account", [SaleOfficerAccountController::class, "index"])->name("account");
  Route::controller(PickupOrderController::class)->group(function () {
    Route::get("/", "index")->name("index");
  });
});

