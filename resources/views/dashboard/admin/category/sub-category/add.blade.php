@extends('layouts.app')
@section("admin-title" , "Create Sub-Category")
@push("admin-cdn")
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush
@section('admin-content')

<x-form.create title="Add New sub-Category">

    <form method="post"
        action="{{ isset($restoredSubCategory) ? route('admin-dashboard.subcategory.update', $restoredSubCategory) : route('admin-dashboard.subcategory.store') }}"
        class="" novalidate enctype="multipart/form-data">
        @csrf

        @if (isset($restoredSubCategory))
        @method('PUT')
        @endif


        <x-error></x-error>

        <div class="mb-3">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" value="{{ $restoredSubCategory->name ?? '' }}" class="form-control" required>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">

                <label for="mainCategory">Main Category</label>
                <select name="parent_id" id="mainCategory" class="form-control mb-3" onchange="handleCategoryChange()">
                    <option value="{{ $parentCategory->id ?? '' }}">
                        {{ $parentCategory->name ?? 'Select Main Category' }}</option>
                    @foreach ($parentCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            @if (isset($restoredSubCategory) || !isset($parentCategory))
            <div class="col-md-6">
                <label for="subCategory">Sub Category</label>
                <select name="parent_id" id="subCategory" class="form-control mb-3" onchange="handleCategoryChange()">
                    <option value="">Select Sub Category</option>
                    @foreach ($subCategories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-3">
            <button type="button" class="btn btn-secondary" onclick="resetSelections()">Reset Selected</button>
        </div>
        @endif

        <div class="col-md-12">
            <label class="form-label">Main Image</label>
            <input type="image" name="main_image" id="main_image" class="form-control">
        </div>

        <x-button.submit.create></x-button.submit.create>

    </form>
</x-form.create>


@push('admin-js')
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

<script>
    // Get a reference to the file input element
        const inputElement = document.querySelectorAll('input[type=image]');

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

<script>
    function handleCategoryChange() {
            const mainCategory = document.getElementById('mainCategory');
            const subCategory = document.getElementById('subCategory');

            if (mainCategory.value) {
                subCategory.disabled = true;
            } else {
                subCategory.disabled = false;
            }

            if (subCategory.value) {
                mainCategory.disabled = true;
            } else {
                mainCategory.disabled = false;
            }
        }

        function resetSelections() {
            document.getElementById('mainCategory').value = "";
            document.getElementById('subCategory').value = "";
            document.getElementById('mainCategory').disabled = false;
            document.getElementById('subCategory').disabled = false;
        }
</script>
@endsection