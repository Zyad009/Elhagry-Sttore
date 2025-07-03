@extends('layouts.app')
@section("admin-title" , "Edit Sub-Category")
@push("admin-cdn")
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush
@section('admin-content')

<x-form.edit title="Edit sub-Category" :name="$subCategory->name ?? $editCategory->name">

    <form method="post" action="{{ route('admin-dashboard.subcategory.update', $subCategory ?? $editCategory) }}"
        class="" enctype="multipart/form-data">
        <x-error></x-error>
        @csrf
        @method("PUT")


        @if (!isset($editCategory))
        @php
        $isMainCategory = $subCategory->parent->parent_id == null;
        if ($isMainCategory) {
        $mainId = $subCategory->parent->id;
        $mainName = $subCategory->parent->name;
        $editCategory= $subCategory;
        } else {
        $subId = $subCategory->parent->id;
        $subName = $subCategory->parent->name;
        $editCategory = $subCategory ;
        }
        $status = null
        @endphp

        @endif

        <div class="mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ $subCategory->name ?? $editCategory->name}}" id="name"
                class="form-control" required>
        </div>


        @if ($status == 1 || isset($mainId))
        <!-- Main Category Dropdown -->
        <div class="mb-3" id="mainCategorySection">
            <label for="mainCategory">Main Category</label>
            <select name="parent_id" id="mainCategory" class="form-control">
                <option value="{{ $mainId ?? '' }}">{{ $mainName ?? 'Select Main Category' }}</option>
                @foreach ($mainCategories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        @if(!$status == 1)
        <a class="btn btn-link" href="{{route(" admin-dashboard.subcategory.edit.2" , $editCategory)}}">Do You Want
            Change To Selected "Sub Category" </a>
        @endif

        @elseif($status == 2 || isset($subId))

        <!-- Sub Category Dropdown -->
        <div class="mb-3" id="subCategorySection">
            <label for="subCategory">Sub Category</label>
            <select name="parent_id" id="subCategory" class="form-control">
                <option value="{{ $subId ?? '' }}">{{ $subName ?? 'Select Sub Category' }}</option>
                @foreach ($subCategories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        @if(!$status == 2)
        <a class="btn btn-link" href="{{route(" admin-dashboard.subcategory.edit.2" , $editCategory)}}">Do You Want
            Change To Selected "Main Category" </a>
        @endif

        @endif

        <div class="col-md-12">
            <label class="form-label">Main Image</label>

            <input type="file" name="main_image" id="main_image" class="form-control">

            {{-- @if(isset($editCategory) && $editCategory->images->first()?->main_image)
            <input style="display: none" type="image" src="{{ asset($editCategory->images->first()?->main_image) }}"
                name="imagePreviewMainImage" id="imagePreviewMainImage" class="form-control">

            @elseif(isset($subCategory) && $subCategory->images->first()?->main_image)
            <input style="display: none" type="image" src="{{ asset($subCategory->images->first()?->main_image) }}"
                name="imagePreviewMainImage" id="imagePreviewMainImage" class="form-control">
            @endif --}}

            @if(isset($editCategory) && $editCategory->images->first()?->main_image || isset($subCategory) &&
            $subCategory->images->first()?->main_image)
            <input style="display: none" type="image"
                src="{{ asset($editCategory->images->first()?->main_image ?? $subCategory->images->first()?->main_image) }}"
                name="imagePreviewMainImage" id="imagePreviewMainImage" class="form-control">
            @endif

        </div>

        <x-button.submit.edit></x-button.submit.edit>
    </form>
</x-form.edit>

@push('admin-js')
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
FilePond.registerPlugin(FilePondPluginImagePreview);

// الحصول على العنصر الخاص بالصورة
var imagePreviewMainImageElement = document.querySelector('#imagePreviewMainImage');
var imagePreviewMainImage = imagePreviewMainImageElement?.src || null;

// تهيئة FilePond
const pond = FilePond.create(document.querySelector('#main_image'), {
allowImagePreview: true,
imagePreviewMaxHeight: 200,
storeAsFile: true,
allowMultiple: false,
acceptedFileTypes: ['image/*'],
});

// إضافة الصورة لو كانت موجودة فقط
if (imagePreviewMainImage) {
pond.addFile(imagePreviewMainImage);
}
});
</script>
@endpush

@endsection