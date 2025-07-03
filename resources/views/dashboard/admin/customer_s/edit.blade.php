@extends('layouts.app')
@push("admin-cdn")
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush
@section("admin-title", "Edit Customer Service")
@section('admin-content')


<x-form.edit title="Edit" :name="$customerService->name">

    <form method="post" action="{{route('admin-dashboard.customer_s.update' , $customerService)}}" novalidate class=""
        enctype="multipart/form-data">
        <x-error></x-error>
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{$customerService->name}}" class="form-control">
            </div>

            <div class="col-md-6">
                <label for="">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" value="{{$customerService->email}}" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Phone <span class="text-danger">*</span></label>
                <input type="tel" name="phone" value="{{$customerService->phone}}" class="form-control">
            </div>

            <div class="col-md-6">
                <label for="">Whatsapp <span class="text-danger">*</span></label>
                <input type="tel" name="whatsapp" value="{{$customerService->whatsapp}}" class="form-control"
                    pattern="^\+?[0-9-]+$">
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Gender <span class="text-danger">*</span></label>
                <select name="gender" class="form-control mb-3">
                    <option value="{{$customerService->gender}}">{{ucfirst($customerService->gender)}}</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Main Image</label>
                <input type="file" name="main_image" id="main_image" class="form-control">
                @if($customerService->images->first()?->main_image)
                <input style="display: none" type="image"
                    src="{{ asset($customerService->images->first()?->main_image) }}" name="imagePreviewMainImage"
                    id="imagePreviewMainImage" class="form-control">
                @endif
            </div>
        </div>
        <div class="row mb-3">

            <div class="col-md-12">
                <label for="">Address <span class="text-danger">*</span></label>
                <textarea name="address" class="form-control"> {{$customerService->address}}</textarea>
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Password<span class="text-danger">*</span></label>
                <input type="password" name="password" id="" class="form-control">
            </div>

            <div class="col-md-6">
                <label for="">Confirm Password<span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" id="" class="form-control">
            </div>
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