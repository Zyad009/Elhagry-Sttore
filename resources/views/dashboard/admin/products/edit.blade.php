@extends('layouts.app')
@section("admin-title" , "Edit Product")
@push("admin-cdn")
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush
@section('admin-content')

<x-form.edit title="Edit Product" :name="$product->name">

    <form method="post" action="{{ route('admin-dashboard.product.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <x-error></x-error>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                    @if (isset($product->category))
                    <option value="{{$product->category->id}}">{{$product->category->name}}</option>
                    @else
                    <option value="">Select Category</option>
                    @endif
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Type Size</label>
                <select name="type_size" class="form-control">
                    <option value="letter" {{ $product->type_size == 'letter' ? 'selected' : ''
                        }}>Alphabetic</option>
                    <option value="number" {{ $product->type_size == 'number' ? 'selected' : ''
                        }}>Numeric</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ $product->price }}"
                    required>
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Main Image</label>
                <input type="file" name="main_image" id="main_image" class="form-control">
                <input type="image" style="display: none" src="{{ asset($product->images->first()?->main_image) }}"
                    name="imagePreviewMainImage" id="imagePreviewMainImage" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Hover Image</label>

                <input type="file" name="hover_image" id="hover_image" class="form-control">

                <input type="image" style="display: none" src="{{ asset($product->images->first()?->hover_image) }}"
                    name="imagePreviewHoverImage" id="imagePreviewHoverImage" class="form-control">
            </div>


            <div class="col-12">
                <label class="form-label">Additional Images</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple>


                @php
                $images = $product->images->first()?->images;
                $images = json_decode($images);
                @endphp

                @foreach ($images as $image )
                <input type="image" style="display: none" src="{{ asset($image) }}" name="imagePreviewImages"
                    id="imagePreviewImages" class="form-control" multiple>
                @endforeach
            </div>
        </div>
        <x-button.submit.edit></x-button.submit.edit>
    </form>
</x-form.edit>

@endsection

@push('admin-js')
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Register FilePond plugins
    FilePond.registerPlugin(FilePondPluginImagePreview);
    
    var imagePreviewMainImage = document.querySelector('#imagePreviewMainImage').src;
    // Initialize FilePond
    const pond = FilePond.create(document.querySelector('#main_image'), {
    allowImagePreview: true,
    imagePreviewMaxHeight: 200,
    storeAsFile: true,
    allowMultiple: false,
    acceptedFileTypes: ['image/*'],
    });
    if (imagePreviewMainImage != null) {
    pond.addFile(imagePreviewMainImage);
      }
    
            });

        document.addEventListener('DOMContentLoaded', function() {
        // Register FilePond plugins
        FilePond.registerPlugin(FilePondPluginImagePreview);
        
        var imagePreviewHoverImage = document.querySelector('#imagePreviewHoverImage').src;
        // Initialize FilePond
        const pond = FilePond.create(document.querySelector('#hover_image'), {
        allowImagePreview: true,
        imagePreviewMaxHeight: 200,
        storeAsFile: true,
        allowMultiple: false,
        acceptedFileTypes: ['image/*'],
        });
        if (imagePreviewHoverImage != null) {
        pond.addFile(imagePreviewHoverImage);
          }  
        
                });

        document.addEventListener('DOMContentLoaded', function() { 

        // Register FilePond plugins
        FilePond.registerPlugin(FilePondPluginImagePreview);
        
        var imagePreviewImages = document.querySelectorAll('#imagePreviewImages');
        console.log(imagePreviewImages);
        // Initialize FilePond
        const pond = FilePond.create(document.querySelector('#images'), {
        allowImagePreview: true,
        imagePreviewMaxHeight: 200,
        storeAsFile: true,
        allowMultiple: true,
        acceptedFileTypes: ['image/*'],
        });
        if (imagePreviewImages != null) {
            imagePreviewImages.forEach(function(image){

                pond.addFile(image.src);
            })
          }  
        
                });

      
</script>
@endpush