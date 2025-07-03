<?php

namespace App\Http\Controllers\Dashboard\Admin\Product;

use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\Traits\UploadImage;
use App\Http\Requests\Admin\Product\ProductRequest;

class AdminProductController extends Controller
{
    use UploadImage;

    private const DIR_VIEW = "dashboard.admin.products";

    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
            return view(SELF::DIR_VIEW . '.index');
        
    }

    public function create()
    {
        $selected = ["id", "name"];
        $categories = Category::select($selected)
            ->doesntHave("children")
            ->get();
        return view(SELF::DIR_VIEW . '.add', compact("categories"));
    }
    /**
     * Store a newly created resource in storage.
     */

    public function store(ProductRequest $request)
    {
        $mainImage = $request->file('main_image');
        $hoverImage = $request->file('hover_image');
        $images = $request->file('images');
        $categoryId = $request->category_id;
        $nameProduct = $request->name;

        $dataProduct = $request->validated();
        $singleProduct = Product::create($dataProduct);
        $productId = $singleProduct->id;


        $this->saveImages("Product", $productId, $nameProduct, $mainImage, $hoverImage , $images, $categoryId);
        alert()->success("Success!", "Created has been successfully");

        return to_route("admin-dashboard.single-product.add" , $singleProduct);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

        $title = 'Delete This Product!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view(SELF::DIR_VIEW . ".all");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load("category");
        if(isset($product->category)){
            $nameCategory = $product->category->name;
            unset($product->category);
        }

        if($product->type_size == "number"){
            $nameSize = "Numeric";
        }else{  
            $nameSize = "Alphabetic";
        }

        $categories = Category::doesntHave("children")->select("id", "name")
            ->get();
        return view(SELF::DIR_VIEW . '.edit', compact('product', 'categories' , 'nameSize'));
    }

    /**
     * Remove the specified resource from storage.
     */


    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $dirFromAnyImage= dirName($product->images->first()?->main_image);
        Storage::deleteDirectory($dirFromAnyImage);

        $product->update($data);

        $mainImage = $request->file('main_image');
        $hoverImage = $request->file('hover_image');
        $images = $request->file('images');
        $categoryId = $request->category_id;
        $nameProduct = $request->name;
        $productId = $product->id;

        $this->saveImages("Product", $productId, $nameProduct, $mainImage, $hoverImage, $images, $categoryId);
        alert()->success("Success!", "Updated has been successfully");

        return to_route('admin-dashboard.product.all');
    }





    public function destroy(Product $product)
    {
        $product->delete();
        alert()->success("Deleted", "deleted has been successfully");

        return back();
    }

    //========= view ======== //
    public function archiveProduct()
    {
        $products = Product::onlyTrashed()->paginate(config("pagination.count"));

        $title = 'Delete Branch!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view(SELF::DIR_VIEW . ".archive", compact("products"));
    }

    //========= Restore ======== //
    public function archiveRestore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        alert()->success("Success!", "restored has been successfully");
        return back();
    }

    //========= Remove ======== //
    public function archiveRemove($id)
    {
        
        $product = Product::withTrashed()->findOrFail($id);
        $dirFromAnyImage = dirName($product->images->first()?->main_image);
        Storage::deleteDirectory($dirFromAnyImage);
        $product->images()->delete();

        $product->forceDelete();

        alert()->success("Success!", "removed has been successfully");
        return back();
    }
}
