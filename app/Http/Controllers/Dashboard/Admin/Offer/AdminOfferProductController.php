<?php

namespace App\Http\Controllers\Dashboard\Admin\Offer;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Offer\OfferRequest;

class AdminOfferProductController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('dashboard.admin.offer.product.all');
    }

}
