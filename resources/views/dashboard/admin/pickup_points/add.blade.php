@extends('layouts.app')
@section("admin-title" , "Create Pickup Point")
@section('admin-content')


<x-form.create title="Add New Pickup Point">
    <form method="post" action="{{ route('admin-dashboard.pickup_point.store') }}" novalidate>
        <x-error></x-error>
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Address <span class="text-danger">*</span></label>
            <textarea type="text" name="address" class="form-control"></textarea> 
        </div>

        <div class="mb-3 text-center">
            <input type="submit" value="Create" class="btn btn-primary w-50 text-white">
        </div>

    </form>
</x-form.create>

@endsection