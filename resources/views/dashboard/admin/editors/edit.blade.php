@extends('layouts.app')
@section("admin-title" , "Edit Editor")
@push("admin-cdn")
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush
@section('admin-content')

<x-form.edit title="Edit Editor" :name="$editor->name">

    <form method="post" action="{{route('admin-dashboard.editors.update', $editor)}}" class=""
        enctype="multipart/form-data">
        <x-error></x-error>
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{$editor->name}}" class="form-control">
            </div>

            <div class="col-md-6">
                <label for="">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" value="{{$editor->email}}" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Phone <span class="text-danger">*</span></label>
                <input type="tel" name="phone" value="{{$editor->phone}}" class="form-control" pattern="^\+?[0-9-]+$">
            </div>

            <div class="col-md-6">
                <label for="">Whatsapp <span class="text-danger">*</span></label>
                <input type="tel" name="whatsapp" value="{{$editor->whatsapp}}" class="form-control"
                    pattern="^\+?[0-9-]+$">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Gender <span class="text-danger">*</span></label>
                <select name="gender" class="form-control mb-3">
                    <option value="{{$editor->gender}}">{{ucfirst($editor->gender)}}</option>
                    @if ($editor->gender == "male")
                    <option value="female">Female</option>
                    @else
                    <option value="male">Male</option>
                    @endif
                </select>
            </div>
            <div class="col-md-6">
                <label for="">Role <span class="text-danger">*</span></label>
                <select name="role" class="form-control mb-3">
                    <option value="{{$editor->role}}">{{ucfirst(str()->replace("_"," ",$editor->role)) }}</option>
                    @if ($editor->role == "editor_admin")
                    <option value="super_admin">Super Admin</option>
                    @else
                    <option value="editor_admin">Editor Admin</option>
                    @endif
                </select>
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Address <span class="text-danger">*</span></label>
                <textarea name="address" class="form-control"> {{$editor->address}}</textarea>
            </div>

            <div class="col-md-6">

                <label class="form-label">Main Image</label>
                <input type="file" name="main_image" id="main_image" class="form-control">
                @if($editor->images->first()?->main_image)
                <input style="display: none" type="image" src="{{ asset($editor->images->first()?->main_image) }}"
                    name="imagePreviewMainImage" id="imagePreviewMainImage" class="form-control">
                @endif

            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" id="" class="form-control">
            </div>

            <div class="col-md-6">
                <label for="">Confirm Password <span class="text-danger">*</span></label>
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