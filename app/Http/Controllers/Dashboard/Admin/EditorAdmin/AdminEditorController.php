<?php

namespace App\Http\Controllers\Dashboard\Admin\EditorAdmin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Editor\EditorRequest;
use App\Http\Controllers\Admin\Traits\UploadImage;
use App\Http\Requests\Admin\CustomerService\CustomerServiceRequest;
use App\Http\Requests\Admin\Editor\UpdateEditorRequest;

class AdminEditorController extends Controller
{
    use UploadImage;
    private const DIR_VIEW = "dashboard.admin.editors";


    // Display a listing of the resource.
    public function index()
    {
        return view(SELF::DIR_VIEW . ".index");
    }

    // Show the form for creating a new admin.
    public function create()
    {
        return view(SELF::DIR_VIEW . ".add", );
    }

    // Store a newly created admin in DB.
    public function store(EditorRequest $request)
    {
        $data = $request->validated();
        $admin = Admin::create($data);

        $mainImage = $request->file("main_image");
        $adminName = $request->name;
        $adminId = $admin->id;
        
        if (isset($mainImage)) {
            $this->saveImages("Admin", $adminId, $adminName, $mainImage);
        }

        alert()->success("Success!", "Created has been successfully");
        return back();
    }


    // Display the specified or all admin.
    public function show()
    {
        $editors = Admin::with("images")
            ->orderBy("id", "desc")
            ->paginate(config("pagination.count"));

        $title = 'Delete This Admin!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view(SELF::DIR_VIEW . ".all", compact("editors"));
    }

    // Show the form for editing the specified admin.
    public function edit(Admin $editor)
    {
        return view(SELF::DIR_VIEW . ".edit", compact("editor"));
    }

    // Update the specified admin in DB.
    public function update(EditorRequest $request, Admin $editor)
    {
        $data = $request->validated();
        $mainImage = $request->file("main_image");
        $editor->update($data);

        if (isset($mainImage)) {

            if ($editor->images->first()?->main_image) {
                $dirFromAnyImage = dirName($editor->images->first()?->main_image);
                Storage::deleteDirectory($dirFromAnyImage);
            }

            $editorId = $editor->id;
            $nameEditor = $request->name;
            $this->saveImages("Admin", $editorId, $nameEditor, $mainImage);
        } else {

            if ($editor->images->first()?->main_image) {
                $dirFromAnyImage = dirName($editor->images->first()?->main_image);
                Storage::deleteDirectory($dirFromAnyImage);
            }

            $editor->images()->update(["main_image" => null]);
        }
        alert()->success("Updated", "editor updated successfully");
        return to_route("admin-dashboard.editors.all");
    }

    // Remove the specified admin from DB.
    public function destroy(Admin $editor)
    {
        $editor->delete();
        alert()->success("Success!", "deleted has been successfully");
        return back();
    }
    //========= view ======== //
    public function archiveEditor()
    {
        $editors = Admin::onlyTrashed()
            ->with( "images")
            ->paginate(config("pagination.count"));

        $title = 'Delete This Admin!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view(SELF::DIR_VIEW . ".archive", compact("editors"));
    }

    //========= Restore ======== //
    public function archiveRestore($id)
    {
        $editor = Admin::withTrashed()->findOrFail($id);
        $editor->restore();

        alert()->success("Success!", "restored has been successfully");
        return back();
    }

    //========= Remove ======== //
    public function archiveRemove($id)
    {
        $editor = Admin::withTrashed()->findOrFail($id);

        if ($editor->images->first()?->main_image) {
            $dirFromAnyImage = dirName($editor->images->first()?->main_image);
            Storage::deleteDirectory($dirFromAnyImage);
            $editor->images()->delete();
        }

        $editor->forceDelete();

        alert()->success("Success!", "removed has been successfully");
        return back();
    }
}
