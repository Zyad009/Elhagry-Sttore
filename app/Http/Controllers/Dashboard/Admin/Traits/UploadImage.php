<?php

namespace App\Http\Controllers\Admin\Traits;

use App\Models\Image;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;


trait UploadImage
{
  private function buildStoragePath($entityName, $folderName, $categoryId = null)
  {
    $basePath = "public/admin/$entityName/";
    $startPath = [];
    if ($categoryId) {
      $category = Category::find($categoryId);
      while ($category) {
        array_unshift($startPath, Str::slug($category->name, '-'));
        $category = Category::find($category->parent_id);
      }
      return $basePath . implode('/', $startPath) . "/$folderName";
    }
    return  $basePath . $folderName;
  }

  private function saveMainImage($mainImage, $path)
  {
    $extension = strtolower($mainImage->getClientOriginalExtension());
    $imageName = 'main_'.time() . '_' . Str::random(10) . '.' . $extension;
    $mainImage->storeAs($path, $imageName);
    return "$path/$imageName";
  }

  private function saveHoverImage($hoverImage = null, $path)
  {
    if ($hoverImage) {
      $extension = strtolower($hoverImage->getClientOriginalExtension());
      $imageName = 'hover_'.time() . '_' . Str::random(10) . '.' . $extension;
      $hoverImage->storeAs($path, $imageName);
      return "$path/$imageName";
    }
    return null;
  }

  private function saveFilesImages($images, $path)
  {
    if (!$images) {
      return [];
    }
    $nameOfImages = [];
    foreach ($images as $image) {
      $extension = strtolower($image->getClientOriginalExtension());
      $imageName = time() . '_' . Str::random(10) . '.' . $extension;
      $image->storeAs($path, $imageName);
      $nameOfImages[] = "$path/$imageName";
    }
    return $nameOfImages;
  }

  public function saveImages($entityName, $requestId, $requestName, $mainImage, $hoverImage = null, array $images = null, $categoryId = null)
  {
    $folderName = Str::slug($requestName, '-') . "_" . Str::uuid();

    $path = $this->buildStoragePath($entityName, $folderName, $categoryId);

    $mainImageName = $this->saveMainImage($mainImage, $path);
    $hoverImageName = $this->saveHoverImage($hoverImage, $path);
    $nameImages = $this->saveFilesImages($images, $path);

    $modelClass = "App\Models\\$entityName";
    Image::updateOrCreate(
      [
        "imageable_id" => $requestId,
        "imageable_type" => $modelClass,
      ],
      [
        "folder" => $folderName,
        "main_image" => $mainImageName,
        "hover_image" => $hoverImageName,
        "images" => json_encode($nameImages),
      ]
    );
  }
}
