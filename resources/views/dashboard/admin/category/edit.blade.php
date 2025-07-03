@extends('layouts.app')
@section("admin-title" , "Edit Category")
@push("admin-cdn")
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush
@section('admin-content')
<x-form.edit title="Edit category" :name="$category->name">
    <form method="post" action="{{route(" admin-dashboard.category.update" , $category)}}" class=""
        enctype="multipart/form-data">
        <x-error></x-error>
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="">Name</label>
            <input type="text" name="name" id="" value="{{ $category->name }}" class="form-control">
        </div>

        <div class="col-md-12">
            <label class="form-label">Main Image</label>

            <input type="file" name="main_image" id="main_image" class="form-control">

            @if($category->images->first()?->main_image)
            <input style="display: none" type="image" src="{{ asset($category->images->first()?->main_image) }}"
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

var imagePreviewMainImageElement = document.querySelector('#imagePreviewMainImage');
var imagePreviewMainImage = imagePreviewMainImageElement?.src || null;

const pond = FilePond.create(document.querySelector('#main_image'), {
allowImagePreview: true,
imagePreviewMaxHeight: 200,
storeAsFile: true,
allowMultiple: false,
acceptedFileTypes: ['image/*'],
});

if (imagePreviewMainImage) {
pond.addFile(imagePreviewMainImage);
}
});
</script>
@endpush

@endsection