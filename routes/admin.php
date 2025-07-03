<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Admin\AdminHomeController;
use App\Http\Controllers\Dashboard\Admin\User\AdminUserController;
use App\Http\Controllers\Dashboard\Admin\Offer\AdminOfferController;
use App\Http\Controllers\Dashboard\Admin\Account\AdminAccountController;
use App\Http\Controllers\Dashboard\Admin\Message\AdminMessageController;
use App\Http\Controllers\Dashboard\Admin\Product\AdminProductController;
use App\Http\Controllers\Dashboard\Admin\Archives\AdminArchiveController;
use App\Http\Controllers\Dashboard\Admin\Category\AdminCategoryController;
use App\Http\Controllers\Dashboard\Admin\EditorAdmin\AdminEditorController;
use App\Http\Controllers\Dashboard\Admin\Offer\AdminOfferProductController;
use App\Http\Controllers\Dashboard\Admin\Offer\AdminOfferCategoryController;
use App\Http\Controllers\Dashboard\Admin\Category\AdminSubCategoryController;
use App\Http\Controllers\Dashboard\Admin\Product\AdminProductSingleController;
use App\Http\Controllers\Dashboard\Admin\Shepping\Home\AdminSheppingController;
use App\Http\Controllers\Dashboard\Admin\PickupPoint\AdminPickupPointController;
use App\Http\Controllers\Dashboard\Admin\SaleOfficer\AdminSaleOfficerController;
use App\Http\Controllers\Dashboard\Admin\Shepping\Area\AdminSheppingAreaController;
use App\Http\Controllers\Dashboard\Admin\Shepping\City\AdminSheppingCityController;
use App\Http\Controllers\Dashboard\Admin\CustomerService\AdminCustomerServiceController;

// Route::get("/admin-home",[AdminHomeController::class,"index"])->name('admin-home');

Route::name("dashboard.")->prefix("dashboard")->middleware('admin.auth')->group(function () {
  Route::get("/home", [AdminHomeController::class, "index"])->name('home');
  Route::get("/account", [AdminAccountController::class, "index"])->name("account");
  
  Route::name("category.")->prefix("category")->group(function () {
    Route::controller(AdminCategoryController::class)->group(function () {
      Route::get("/", "index")->name("admin");
      Route::get("/create", "create")->name("new");
      Route::post("/store", "store")->name("store");
      Route::get("/all", "show")->name("all");
      Route::get("/{category}/view", "view")->name("view");
      Route::get("/{category}/edit", "edit")->name("edit");
      Route::put("/update/{category}", "update")->name("update");
      Route::delete("/{category}", "destroy")->name("delete");
      //soft delete
      Route::get("/archive", "archiveCategory")->name("archive");
      Route::post("/{id}/restore", "archiveRestore")->name("restore");
      Route::delete("/{id}/confirm-delete", "archiveRemove")->name("remove");
    });
  });

  Route::name("subcategory.")->prefix("sub-category")->group(function () {
    Route::controller(AdminSubCategoryController::class)->group(function () {
      // Route::get("/","index")->name("admin.subcategory");
      Route::get("/create/{parentCategory?}", "create")->name("new");
      Route::post("/store", "store")->name("store");
      Route::get("/all", "show")->name("all");
      Route::get("/edit/{subCategory?}", "edit")->name("edit");
      Route::get("/edit-trans/{editCategory?}", "editSub")->name("edit.2");
      Route::put("/update/{category}", "update")->name("update");
      Route::delete("/{subCategory}", "destroy")->name("delete");
      //soft delete
      Route::get("/archive", "archiveSubCategory")->name("archive");
      Route::post("/{id}/restore", "archiveRestore")->name("restore");
      Route::delete("/{id}/confirm-delete", "archiveRemove")->name("remove");
    });
  });

  Route::name("offer.")->prefix("offer")->group(function () {
    Route::controller(AdminOfferController::class)->group(function () {
      Route::get("/","index")->name("admin");
      Route::get("/create", "create")->name("new");
      Route::post("/", "store")->name("store");
      Route::get("/{offer}/edit", "edit")->name("edit");
      Route::put("/{offer}/update", "update")->name("update");
      Route::delete("/{offer}/delete", "destroy")->name("delete");
      
    });
    Route::get("/product/all", [AdminOfferProductController::class,"show"])->name("product.all");
    
    Route::get("/category/all",[AdminOfferCategoryController::class ,"show"])->name( "category.all");

    });

    


  Route::name("product.")->prefix("product")->middleware('auth:admin')->group(function () {
    Route::controller(AdminProductController::class)->group(function () {
      Route::get("/", "index")->name("admin");
      Route::get("/create", "create")->name("new");
      Route::post("/", "store")->name("store");
      
      
      /////////////////
      Route::post("/image-upload", "imageUpload")->name("set.image");
      Route::delete("/image-delete", "imageDelete")->name("remove.image");
      ////////////////
      Route::get("/all", "show")->name("all");
      Route::get("/{product}/edit", "edit")->name("edit");
      Route::put("/{product}", "update")->name("update");
      Route::delete("/{product}", "destroy")->name("delete");
      //soft delete
      Route::get("/archive", "archiveProduct")->name("archive");
      Route::post("/{id}/restore", "archiveRestore")->name("restore");
      Route::delete("/{id}/confirm-delete", "archiveRemove")->name("remove");
    });
  });

  Route::name("message.")->prefix("message")->group(function () {
    Route::controller(AdminMessageController::class)->group(function () {
      Route::get("/", "index")->name("admin");
      Route::delete("/{message}", "destroy")->name("delete");
      Route::get("/{notification}/markAsRead", "markAsRead")->name("markAsRead");
    });
  });

  Route::name("user.")->prefix("user")->group(function () {
    Route::controller(AdminUserController::class)->group(function () {
      Route::get("/", "index")->name("admin");
      Route::get("/search", "search")->name("search");
    });
  });

  Route::name("editors.")->prefix("editors")->group(function () {
    Route::controller(AdminEditorController::class)->group(function () {
      Route::get("/", "index")->name("admin");
      Route::get("/create", "create")->name("new");
      Route::get("/all", "show")->name("all");
      Route::post("/", "store")->name("store");
      Route::get("/{editor}/edit", "edit")->name("edit");
      Route::put("/{editor}", "update")->name("update");
      Route::delete("/{editor}", "destroy")->name("delete");
      //soft delete
      Route::get("/archive", "archiveEditor")->name("archive");
      Route::post("/{id}/restore", "archiveRestore")->name("restore");
      Route::delete("/{id}/confirm-delete", "archiveRemove")->name("remove");
    });
  });

  Route::name("pickup_point.")->prefix("pickup_point")->group(function () {
    Route::controller(AdminPickupPointController::class)->group(function () {
      Route::get("/", "index")->name("admin");
      Route::get("/create", "create")->name("new");
      Route::post("/", "store")->name("store");
      Route::get("/all", "show")->name("all");
      Route::get("/{pickupPoint}/edit", "edit")->name("edit");
      Route::put("/{pickupPoint}", "update")->name("update");
      Route::delete("/{pickupPoint}", "destroy")->name("delete");
      //soft delete
      Route::get("/archive", "archiveBranch")->name("archive");
      Route::post("/{id}/restore", "archiveRestore")->name("restore");
      Route::delete("/{id}/confirm-delete", "archiveRemove")->name("remove");
    });
  });

  Route::name("customer_s.")->prefix("customer-service")->group(function () {
    Route::controller(AdminCustomerServiceController::class)->group(function () {
      Route::get("/", "index")->name("admin");
      Route::get("/create", "create")->name("new");
      Route::post("/", "store")->name("store");
      Route::get("/all", "show")->name("all");
      Route::get("/{customerService}/edit", "edit")->name("edit");
      Route::put("/{customerService}", "update")->name("update");
      Route::delete("/{customerService}", "destroy")->name("delete");
      //soft delete
      Route::get("/archive", "archiveCustomerService")->name("archive");
      Route::post("/{id}/restore", "archiveRestore")->name("restore");
      Route::delete("/{id}/confirm-delete", "archiveRemove")->name("remove");
    });
  });

  Route::name("sale_officer.")->prefix("sale_officer")->group(function () {
    Route::controller(AdminSaleOfficerController::class)->group(function () {
      Route::get("/", "index")->name("admin");
      Route::get("/create", "create")->name("new");
      Route::post("/", "store")->name("store");
      Route::get("/all", "show")->name("all");
      Route::get("/{saleOfficer}/edit", "edit")->name("edit");
      Route::put("/{saleOfficer}", "update")->name("update");
      Route::delete("/{saleOfficer}", "destroy")->name("delete");
      //soft delete
      Route::get("/archive", "archiveEmployee")->name("archive");
      Route::post("/{id}/restore", "archiveRestore")->name("restore");
      Route::delete("/{id}/confirm-delete", "archiveRemove")->name("remove");
    });
  });

  Route::prefix("shepping")->group(function () {
    Route::get("/", [AdminSheppingController::class, "index"])->name("shepping.admin");

    Route::name("city.")->prefix("city")->group(function () {
      Route::controller(AdminSheppingCityController::class)->group(function () {
        Route::get("/create", "create")->name("new");
        Route::post("/city", "store")->name("store");
        Route::get("/all", "show")->name("all");
        Route::get("/edit/{city}", "edit")->name("edit");
        Route::put("/update/{city}", "update")->name("update");
        Route::delete("/delete/{city}", "destroy")->name("delete");
        //soft delete
        Route::get("/archive-city", "archiveCity")->name("archive");
        Route::post("/{id}/restore-city", "archiveRestore")->name("restore");
        Route::delete("/{id}/confirm-delete-city", "archiveRemove")->name("remove");
      });
    });

    Route::name("area.")->prefix("area")->group(function () {
      Route::controller(AdminSheppingAreaController::class)->group(function () {
        Route::get("/for-city", "index")->name("admin");
        Route::get("/create/{city}", "create")->name("new");
        Route::post("/", "store")->name("store");
        Route::get("/all/{city}", "show")->name("all");
        Route::get("/edit/{area}", "edit")->name("edit");
        Route::put("/{area}", "update")->name("update");
        Route::delete("/{area}", "destroy")->name("delete");
        //soft delete
        Route::get("/archive-city_for_area", "archiveCitiesForAreas")->name("index");
        Route::get("/archive-area/{city}", "archiveArea")->name("archive");
        Route::post("/{id}/restore", "archiveRestore")->name("restore");
        Route::delete("/{id}/confirm-delete", "archiveRemove")->name("remove");
      });
    });
  });

  Route::get("/archives", [AdminArchiveController::class, "index"])->name("archives");

});
