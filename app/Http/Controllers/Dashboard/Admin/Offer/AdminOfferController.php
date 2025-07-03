<?php

namespace App\Http\Controllers\Dashboard\Admin\Offer;

use App\Models\Offer;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Offer\OfferRequest;

class AdminOfferController extends Controller
{
    private const DIR_VIEW = "dashboard.admin.offer";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::withCount("products", "categories")->paginate(config("pagination.count"));
        $title = 'Delete This Offer!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view(self::DIR_VIEW . '.index', compact("offers"));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.pages.offer.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OfferRequest $request)
    {
        $data = $request->validated();
        Offer::create($data);

        alert()->success("Success!", "Created has been successfully");
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        return view(self::DIR_VIEW . ".edit", compact("offer"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OfferRequest $request, Offer $offer)
    {
        $data = $request->validated();
        $offer->update($data);

        alert()->success("Success", "supdated has been successfully");
        return to_route('admin-dashboard.offer.admin');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {

        $offer->delete();
        alert()->success("Success!", "deleted has been successfully");
        return back();
    }
}
