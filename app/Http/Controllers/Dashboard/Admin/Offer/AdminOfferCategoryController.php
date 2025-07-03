<?php

namespace App\Http\Controllers\Dashboard\Admin\Offer;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminOfferCategoryController extends Controller

  {

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('dashboard.admin.offer.category.all');
    }
}
