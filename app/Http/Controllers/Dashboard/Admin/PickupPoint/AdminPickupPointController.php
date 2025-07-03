<?php

namespace App\Http\Controllers\Dashboard\Admin\PickupPoint;

use App\Models\Admin;
use App\Models\PickupPoint;
use App\Models\SaleOfficer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PickupPoint\PickupPointRequest;

class AdminPickupPointController extends Controller
{
    private const DIR_VIEW = "dashboard.admin.pickup_points";

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(SELF::DIR_VIEW . ".index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
        return view(SELF::DIR_VIEW . ".add" );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PickupPointRequest $request)
    {
        $data=$request->validated();
        PickupPoint::create($data);
        alert()->success("Success!" , "created has been successfully");

        return back();
    }

    /**
     * Display the specified or all branch.
     */
    public function show()
    {
        $pickupPoints = PickupPoint::with("saleOfficer")
        ->orderBy("id", "desc")
        ->paginate(config("pagination.count"));
        $title = 'Delete Pickup Point!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view(SELF::DIR_VIEW . ".all", compact("pickupPoints"));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PickupPoint $pickupPoint)
    {
        $saleOfficers = SaleOfficer::select("id", "name")->get();
        return view(SELF::DIR_VIEW . ".edit" , compact("pickupPoint" , "saleOfficers"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PickupPointRequest $request , PickupPoint $pickupPoint)
    {
        $data=$request->validated();
        $pickupPoint->update($data);
        alert()->success("Success!", "ubdated has been successfully");

        return to_route('admin-dashboard.pickup_point.all');

        // return back()->with("success" , "branch updated successfully"); 
    }

    /**
     * Remove the specified resource from storage.
     */
    //========= Soft Delete ======== //
    public function destroy(PickupPoint $pickupPoint)
    {
        $pickupPoint->delete();
        alert()->success("Success!" , "deleted has been successfully");
        return back();
    }
    
    //========= view ======== //
    public function archiveBranch()
    {
        $pickupPoints = PickupPoint::onlyTrashed()->paginate(config("pagination.count"));

        $title = 'Delete Pickup Point!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view(SELF::DIR_VIEW . ".archive" , compact("pickupPoints"));
    }

    //========= Restore ======== //
    public function archiveRestore($id)
    {
        $pickupPoint = PickupPoint::withTrashed()->findOrFail($id);
        $pickupPoint->restore();
        
        alert()->success("Success!" , "restored has been successfully");
        return back();
    }

    //========= Remove ======== //
    public function archiveRemove($id)
    {
        $pickupPoint = PickupPoint::withTrashed()->findOrFail($id);
        $pickupPoint->forceDelete();

        alert()->success("Success!", "removed has been successfully");
        return back();  
    }
}
