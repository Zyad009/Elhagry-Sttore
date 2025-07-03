<?php

namespace App\Http\Controllers\Dashboard\Admin\Shepping\Area;

use App\Models\Area;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Shepping\Area\AreaRequest;

class AdminSheppingAreaController extends Controller
{
    private const DIR_VIEW = "admin.pages.shepping.area";

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::select("id", "name","slug")
        ->get();

        return view(SELF::DIR_VIEW . ".index" , compact("cities"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(City $city)
    {
        // $cities = City::with("areas")
        // ->select("id", "name")
        // ->get();
        return view(SELF::DIR_VIEW . ".add" , compact("city")); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaRequest $request)
    {
        $data = $request->validated();
        Area::create($data);
        alert()->success("Success!", "Created has been successfully");
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        $areas = $city->areas()
        ->orderBy("id", "desc")
        ->paginate(config("pagination.count"));
        $title = 'Delete This City!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view(SELF::DIR_VIEW . ".all" , compact("areas" , "city"));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        $cities = City::select("id" , "name")
        ->get();
        return view(SELF::DIR_VIEW . ".edit" , compact("area" , "cities"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaRequest $request , Area $area )
    {
        $data = $request->validated();
        $area->update($data);
        $area = $area->load("city");
        $cityOfArea = $area->city->slug;

        // dd($area);
        alert()->success("Success!", "area updated successfully");
        return to_route("admin-dashboard.area.all" , $cityOfArea);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        $area->delete();
        alert()->success("Deleted", "deleted has been successfully");

        return back();
    }

    //========= view Cities======== //
    public function archiveCitiesForAreas()
    {
        $cities = City::select("id", "name", "slug")
        ->get();

        return view(SELF::DIR_VIEW . ".archive.index", compact("cities"));
    }

    //========= view Areas======== //
    public function archiveArea(City $city)
    {
        $areas = $city->areas()
            ->onlyTrashed()
            ->orderBy("id", "desc")
            ->paginate(config("pagination.count"));

        $title = 'Delete This Area!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view(SELF::DIR_VIEW . ".archive.archive", compact("areas", "city"));
    }


    //========= Restore ======== //
    public function archiveRestore($id)
    {
        $area = Area::withTrashed()->findOrFail($id);
        $area->restore();

        alert()->success("Success!", "restored has been successfully");
        return back();
    }

    //========= Remove ======== //
    public function archiveRemove($id)
    {
        $area = Area::withTrashed()->findOrFail($id);
        $area->forceDelete();

        alert()->success("Success!", "removed has been successfully");
        return back();
    }
}
