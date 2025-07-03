<?php

namespace App\Http\Controllers\Dashboard\Admin\Shepping\City;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Shepping\City\CityRequest;
use App\Models\City;
use Illuminate\Http\Request;

class AdminSheppingCityController extends Controller
{
    private const DIR_VIEW = "admin.pages.shepping.city";


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(SELF::DIR_VIEW . ".add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request)
    {
        $data = $request->validated();
        City::create($data);
        alert()->success("Success!", "Created has been successfully");

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $cities = City::orderBy("id", "desc")
        ->paginate(config("pagination.count"));
        $title = 'Delete This City!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view(SELF::DIR_VIEW . ".all" , compact("cities"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        return view(SELF::DIR_VIEW . '.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, City $city)
    {
        $data = $request->validated();
        $city->update($data);
        alert()->success("Success!", "city updated successfully");

        return to_route("admin-dashboard.city.all");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();
        alert()->success("Deleted", "deleted has been successfully");

        return back();
    }

    //========= view ======== //
    public function archiveCity()
    {
        $cities = City::onlyTrashed()->paginate(config("pagination.count"));

        $title = 'Delete Branch!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view(SELF::DIR_VIEW . ".archive", compact("cities"));
    }

    //========= Restore ======== //
    public function archiveRestore($id)
    {
        $city = City::withTrashed()->findOrFail($id);
        $city->restore();

        alert()->success("Success!", "restored has been successfully");
        return back();
    }

    //========= Remove ======== //
    public function archiveRemove($id)
    {
        $city = City::withTrashed()->findOrFail($id);
        $city->forceDelete();

        alert()->success("Success!", "removed has been successfully");
        return back();
    }
}
