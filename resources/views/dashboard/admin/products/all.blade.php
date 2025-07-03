@extends('layouts.app')
@section('admin-title', 'All Products')
@section('admin-content')

@push("admin-cdn")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

<div class="d-flex justify-content-between align-items-center">
    <h1 class="fw-bold ">All Products</h1>
</div>

<x-error></x-error>

<livewire:admin.product.table-product />
<livewire:admin.product.show-product />
<livewire:admin.product.show-description />


@endsection

@push("admin-js")
<script>
    window.addEventListener("showDescriptionModal", () => {
    $("#descriptionModal").modal("toggle");
    });

    window.addEventListener("showModelToggle" , event =>{
                $("#showModel").modal("toggle");
                })
</script>
@endpush