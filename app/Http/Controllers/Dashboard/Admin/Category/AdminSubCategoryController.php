<?php

namespace App\Http\Controllers\Dashboard\Admin\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Admin\Traits\UploadImage;
use App\Http\Requests\Admin\Category\SubCategoryRequest;

class AdminSubCategoryController extends Controller
{
    use UploadImage;
    private const DIR_VIEW = "dashboard.admin.category.sub-category";

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $parentCategory = null)
    {
        $parentCategories = Category::whereNull('parent_id')
            ->select('id', 'name')
            ->get();
        $subCategories = Category::whereNotNull('parent_id')
            ->select('id', 'name', 'parent_id')
            ->get();

            if (isset($parentCategory->parent_id) && $parentCategory->parent_id !== null) {
                $restoredSubCategory = $parentCategory ;
                return view(SELF::DIR_VIEW . ".add", compact("parentCategories", "subCategories" , "restoredSubCategory"));
            }
            return view(SELF::DIR_VIEW . ".add", compact("parentCategories", "subCategories" , "parentCategory"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryRequest $request)
    {
        $mainImage = $request->file("main_image");
        $nameCategory = $request->name;
        $data = $request->validated();
        $subCategory = Category::create($data);
        $subCategoryId = $subCategory->id;
        
        if(isset($mainImage)){
            $this->saveImages("Category", $subCategoryId, $nameCategory, $mainImage);
        }

        alert()->success("Success!", "Created has been successfully");

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $selected = ['id', 'name', "slug", 'parent_id'];
        $subCategories = Category::select($selected)
            ->whereNotNull("parent_id")
            ->with("parent" , "images")
            ->orderBy("id", "desc")
            ->paginate(config("pagination.count"));

        $title = 'Delete This Sub-Category!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view(SELF::DIR_VIEW . ".all", compact("subCategories"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $subCategory)
    {
        if ($subCategory->parent !== null) {

            $selected = ['id', 'name', 'slug', 'parent_id'];
            $subCategory->loadMissing("parent");
            
            $mainCategories = Category::select($selected)
                ->whereNull('parent_id')
                ->get();

            $subCategories = Category::select($selected)
                ->whereNotNull('parent_id')
                ->with("parent") // تحميل العلاقة فقط عند الحاجة
                ->get();

            return view(SELF::DIR_VIEW . ".edit", compact("subCategory", "subCategories", "mainCategories"));
        }

        alert()->warning('Warning', 'You Must Be Add This Sub-Category For Any (Main Category / Sub-Category).');
        return to_route("admin-dashboard.subcategory.new", $subCategory);
    }


    public function editSub(Category $editCategory)
    {
        $editCategory = $editCategory->load("parent");
        $selected = ['id', 'name', "slug", 'parent_id'];
        
        $mainCategories = Category::select($selected)
            ->whereNull('parent_id')
            ->get();

        $subCategories = Category::select($selected)
            ->whereNotNull("parent_id")
            ->with("parent")
            ->get();

        $isMainCategory = $editCategory->parent->parent_id == null;

        if (!$isMainCategory) {
            $status = 1;
            return view(SELF::DIR_VIEW . ".edit", compact("editCategory", "subCategories", "mainCategories", "status"));
        } else {
            $status = 2;
            return view(SELF::DIR_VIEW . ".edit", compact("editCategory", "subCategories", "mainCategories", "status"));
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(SubCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $mainImage = $request->file("main_image");
        $category->update($data);

        if (isset($mainImage)) {

            if ($category->images->first()?->main_image) {
                $dirFromAnyImage = dirName($category->images->first()?->main_image);
                Storage::deleteDirectory($dirFromAnyImage);
            }
            
            $categoryId = $category->id;
            $nameCategory = $request->name;
            $this->saveImages("Category", $categoryId, $nameCategory, $mainImage);
        } else {

            if ($category->images->first()?->main_image) {
                $dirFromAnyImage = dirName($category->images->first()?->main_image);
                Storage::deleteDirectory($dirFromAnyImage);
            }

            $category->images()->update(["main_image" => null]);
        }


        alert()->success("Updated", "sub-category updated successfully");
        return to_route("admin-dashboard.subcategory.all");
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $subCategory)
    {
        $subCategory->delete();
        alert()->success("Deleted", "deleted has been successfully");

        return back();
    }
    //========= view ======== //
    public function archiveSubCategory()
    {
        $subCategories = Category::onlyTrashed()
        ->with("images")
        ->whereNotNull("parent_id")
        ->paginate(config("pagination.count"));

        $title = 'Delete This Sub-Category!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view("admin.pages.category.sub-category.archive", compact("subCategories"));
    }

    //========= Restore ======== //
    public function archiveRestore($id)
    {
        $category = Category::withTrashed()
        ->findOrFail($id);
        $category->restore();

        alert()->success("Success!", "restored has been successfully");
        return back();
    }

    //========= Remove ======== //
    public function archiveRemove($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        if ($category->images->first()?->main_image) {
            $dirFromAnyImage = dirName($category->images->first()?->main_image);
            Storage::deleteDirectory($dirFromAnyImage);
            $category->images()->delete();
        }

        $category->forceDelete();

        alert()->success("Success!", "removed has been successfully");
        return back();
    }
}
