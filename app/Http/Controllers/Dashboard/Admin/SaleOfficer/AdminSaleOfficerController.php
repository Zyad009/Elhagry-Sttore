<?php

namespace App\Http\Controllers\Dashboard\Admin\SaleOfficer;
use App\Models\SaleOfficer;
use  App\Models\PickupPoint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\Traits\UploadImage;
use App\Http\Requests\Admin\Employee\EmployeeRequest;
use App\Http\Requests\Admin\SaleOfficer\SaleOfficerRequest;

class AdminSaleOfficerController extends Controller
{
    use UploadImage;
    private const DIR_VIEW = "admin.pages.sale_officer";

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pickupPoints = PickupPoint::all();
        return view(SELF::DIR_VIEW . ".add" , compact("pickupPoints"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleOfficerRequest $request)
    {
        $data = $request->validated();
        $saleOfficer = SaleOfficer::create($data);
        $mainImage = $request->file("main_image");
        $saleOfficerName = $request->name;
        $saleOfficerId = $saleOfficer->id;

        if (isset($mainImage)) {
            $this->saveImages("SaleOfficer", $saleOfficerId, $saleOfficerName, $mainImage);
        }

        alert()->success("Success!", "Created has been successfully");
        return back();
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show()
    {
        $saleOfficers = SaleOfficer::with("images" , "pickupPoint")
        ->orderBy("id", "desc")
        ->paginate(config("pagination.count"));
        $title = 'Delete This Sale Officer!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view(SELF::DIR_VIEW . ".all", compact("saleOfficers"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleOfficer $saleOfficer)
    {
        $pickupPoints = PickupPoint::all();
        return view(SELF::DIR_VIEW . ".edit", compact("saleOfficer", "pickupPoints"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaleOfficerRequest $request , SaleOfficer $saleOfficer)
    {
        $data = $request->validated();
        $mainImage = $request->file("main_image");
        $saleOfficer->update($data);

        if (isset($mainImage)) {

            if ($saleOfficer->images->first()?->main_image) {
                $dirFromAnyImage = dirName($saleOfficer->images->first()?->main_image);
                Storage::deleteDirectory($dirFromAnyImage);
            }

            $saleOfficerId = $saleOfficer->id;
            $nameSaleOfficer = $request->name;
            $this->saveImages("SaleOfficer", $saleOfficerId, $nameSaleOfficer, $mainImage);
        } else {

            if ($saleOfficer->images->first()?->main_image) {
                $dirFromAnyImage = dirName($saleOfficer->images->first()?->main_image);
                Storage::deleteDirectory($dirFromAnyImage);
            }

            $saleOfficer->images()->update(["main_image" => null]);
        }

        alert()->success("Updated", "SaleOfficer updated successfully");
        return to_route('admin-dashboard.sale_officer.all');   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleOfficer $saleOfficer)
    {
        $saleOfficer->delete();
        alert()->success("Deleted", "deleted has been successfully");

        return back();
    }

    // //========= view ======== //
    public function archiveEmployee()
    {
        $saleOfficers = SaleOfficer::onlyTrashed()
        ->with("pickupPoint", "images")
        ->paginate(config("pagination.count"));

        $title = 'Delete This';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view(SELF::DIR_VIEW . ".archive", compact("saleOfficers"));
    }

    // //========= Restore ======== //
    public function archiveRestore($id)
    {
        $saleOfficer = SaleOfficer::withTrashed()->findOrFail($id);
        $saleOfficer->restore();

        alert()->success("Success!", "restored has been successfully");
        return back();
    }
    
    // //========= Remove ======== //
    public function archiveRemove($id)
    {
        $saleOfficer = SaleOfficer::withTrashed()->findOrFail($id);

        if ($saleOfficer->images->first()?->main_image) {
            $dirFromAnyImage = dirName($saleOfficer->images->first()?->main_image);
            Storage::deleteDirectory($dirFromAnyImage);
            $saleOfficer->images()->delete();
        }
        
        $saleOfficer->forceDelete();

        alert()->success("Success!", "removed has been successfully");
        return back();
    }
}
