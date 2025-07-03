@extends('layouts.app')
@section("admin-title" , "Create Category")
@push("admin-cdn")
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush
@section('admin-content')

<x-form.create title="Add New Category">
    <form method="post" action="{{route(" admin-dashboard.category.store")}}" class="" enctype="multipart/form-data">
        <x-error></x-error>

        @csrf

        <div class="mb-3">
            <label for="">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="" class="form-control">
        </div>

        <div class="mb-3">
            <label for="">Main Image</label>
            <input type="file" name="main_image" id="main_image" class="form-control">
        </div>
        <x-button.submit.create></x-button.submit.create>


        @if(session('parentCategory'))
        @php
        $parentCategory = session('parentCategory');
        @endphp
        <a class="btn btn-link" href="{{route(" admin-dashboard.subcategory.new" , $parentCategory)}}">Do You Want Add
            Sub-Category For "{{$parentCategory["name"]}}" </a>
        @endif
    </form>
</x-form.create>



@endsection
@push('admin-js')
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

<script>
    // Get a reference to the file input element
        const inputElement = document.querySelectorAll('input[type=file]');

        console.log(inputElement)
        FilePond.registerPlugin(FilePondPluginImagePreview);
        // Create a FilePond instance
        const mainIMagePond = FilePond.create(document.querySelector('#main_image'), {
            allowImagePreview: true,
            imagePreviewHeight: 200,
            storeAsFile: true,
            allowMultiple: false,
            acceptedFileTypes: ['image/*'],
        });
</script>
@endpush