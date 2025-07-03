@extends('layouts.app')
@section("admin-title" , "Add Details For Product")
@section("admin-title" , "Create Product")
@push("admin-cdn")
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush
@section('admin-content')

<x-form.create title="Add New Product">
    <form method="post" action="{{ route('admin-dashboard.product.store') }}" enctype="multipart/form-data">
        @csrf
        <x-error></x-error>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{old('name')}}" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Type Size <span class="text-danger">*</span></label>
                <select name="type_size" class="form-control">
                    <option value="">Select Type Size</option>
                    <option value="letter">Alphabetic</option>
                    <option value="number">Numeric</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Price <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="price" value="{{old('price')}}" class="form-control"
                    required>
            </div>

            <div class="col-12">
                <label class="form-label">Description <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control" rows="4">{{old('description')}}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Main Image <span class="text-danger">*</span></label>
                <input type="file" name="main_image" id="main_image" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Hover Image <span class="text-danger">*</span></label>
                <input type="file" name="hover_image" id="hover_image" class="form-control">
            </div>

            <div class="col-12">
                <label class="form-label">Additional Images <span class="text-danger">*</span></label>
                <input type="file" name="images[]" id="images" class="form-control" multiple>
            </div>
        </div>

        <x-button.submit.create></x-button.submit.create>
    </form>
</x-form.create>
@endsection

@push('admin-js')
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

<script>
    // Get a reference to the file input element
        const inputElement = document.querySelectorAll('input[type=file]');

        // console.log(inputElement)
        FilePond.registerPlugin(FilePondPluginImagePreview);
        // Create a FilePond instance
        const mainIMagePond = FilePond.create(document.querySelector('#main_image'), {
            allowImagePreview: true,
            imagePreviewHeight: 200,
            storeAsFile: true,
            allowMultiple: false,
            acceptedFileTypes: ['image/*'],
        });

        const hoverIMagePond = FilePond.create(document.querySelector('#hover_image'), {
            allowImagePreview: true,
            imagePreviewHeight: 200,
            storeAsFile: true,
            allowMultiple: false,
            acceptedFileTypes: ['image/*'],
        });

        const imagesPond = FilePond.create(document.querySelector('#images'), {
            allowImagePreview: true,
            imagePreviewHeight: 200,
            storeAsFile: true,
            allowMultiple: true,
            acceptedFileTypes: ['image/*'],
        });

//for work 
        // FilePond.setOptions({
        //     server: {
        //         process: '{{ route('admin-dashboard.product.set.image') }}',
        //         revert: './image-delete',
        //         headers: {
        //             "X-CSRF-TOKEN": "{{ csrf_token() }}"
        //         }
        //     },
        // });
</script>
@endpush