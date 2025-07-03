@extends('layouts.app')
@section('admin-title', 'Set Offers (Categories)')
@section('admin-content')
@push("admin-cdn")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

<div class="d-flex justify-content-between align-items-center">
    <h1 class="fw-bold ">All Offers Categoriess</h1>
</div>
<x-error></x-error>

<livewire:admin.offer.category.all-categories>

    @push("admin-js")

    <script>
        window.addEventListener("errorOffer", () => {
    Swal.fire({
    icon: "error",
    title: "Error!",
    text: "you must be selected offer",
    showConfirmButton: false,
    timer: 2000
    });
    });

window.addEventListener("successOffer", () => {
    Swal.fire({
    icon: "success",
    title: "Success!",
    text: "offer add successfully",
    showConfirmButton: false,
    timer: 1500
    });
    });

window.addEventListener("warningOffer", (event) => {
    const countError = event.detail;
    Swal.fire({
    icon: "warning",
    title: "Warning!",
    text: `The offer was added successfully! Number of products that do not contain an offer: ${countError} "because the product price is higher
    than the offer price"`,
    showConfirmButton: true,
    timer: 20000
});
});

window.addEventListener("deletedOffer", () => {
    Swal.fire({
    icon: "success",
    title: "Success!",
    text: "deleted successfully",
    showConfirmButton: false,
    timer: 1500
    });
    });

    </script>

    @endpush

    @endsection