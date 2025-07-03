@extends('layouts.app')
@section('admin-title', 'Add New Sale Officer')
@push("admin-cdn")
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush
@section('admin-content')

<x-form.create title="Add New Employee">

    <form method="post" action="{{route('admin-dashboard.sale_officer.store')}}" novalidate class=""
        enctype="multipart/form-data">
        <x-error></x-error>
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{old(" name")}}"class="form-control">
            </div>

            <div class="col-md-6">
                <label for="">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" value="{{old(" email")}}"class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Phone <span class="text-danger">*</span></label>
                <input type="tel" name="phone" value="{{old(" phone")}}"class="form-control">
            </div>

            <div class="col-md-6">
                <label for="">Whatsapp <span class="text-danger">*</span></label>
                <input type="tel" name="whatsapp" value="{{old(" whatsapp")}}"class="form-control"
                    pattern="^\+?[0-9-]+$">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Gender <span class="text-danger">*</span></label>
                <select name="gender" class="form-control mb-3">
                    <option value="">Select Your Gander</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="">Pickup Point <span class="text-danger">*</span></label>
                <select name="pickup_point_id" class="form-control mb-3">
                    <option value="">Select Your Pickup Point</option>
                    @foreach ($pickupPoints as $pickupPoint )
                    <option value="{{$pickupPoint->id}}">{{$pickupPoint->name}}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Address <span class="text-danger">*</span></label>
                <textarea name="address" class="form-control"> {{old("address")}}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Main Image</label>
                <input type="file" name="main_image" id="main_image" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Password<span class="text-danger">*</span></label>
                <input type="password" name="password" id="" class="form-control">
            </div>

            <div class="col-md-6">
                <label for="">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" id="" class="form-control">
            </div>
        </div>

        <x-button.submit.create></x-button.submit.create>
    </form>
</x-form.create>

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

@endsection