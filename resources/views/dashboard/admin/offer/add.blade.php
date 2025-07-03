@extends('layouts.app')
@section("admin-title" , "Create Main Discount")
@section('admin-content')

<x-form.create title="Add New Main Discount">

    <form method="post" action="{{route('admin-dashboard.offer.store')}}" novalidate class="">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Name <span class="text-danger">*</label>
                <input type="text" name="name" id="" value="{{old('name')}}" class="form-control">
                <x-message.error name="name"></x-message.error>
            </div>

            <div class="col-md-6">
                <label for=""> Discount Type <span class="text-danger">*</label>
                <select name="discount_type" class="form-control">
                    <option value="">Select Discount Type</option>
                    <option value="percentage">Percentage</option>
                    <option value="value">Value</option>
                </select>
                <x-message.error name="discount_type"></x-message.error>
            </div>

        </div>
        <div class="row mb-3">

            <div class="col-md-4">
                <label>Start Date <span class="text-danger">*</label>
                <input type="datetime-local" value="{{old('start_date')}}" name="start_date" class="form-control">
                <x-message.error name="start_date"></x-message.error>
            </div>

            <div class="col-md-4">
                <label>End Date <span class="text-danger">*</label>
                <input type="datetime-local" name="end_date" value="{{old('end_date')}}" class="form-control">
                <x-message.error name="end_date"></x-message.error>
            </div>

            <div class="col-md-4">
                <label>Discount <span class="text-danger">*</label>
                <input type="number" min="1" name="discount" value="{{old('discount')}}" class="form-control">
                <x-message.error name="discount"></x-message.error>
            </div>
        </div>
        <x-button.submit.create></x-button.submit.create>
    </form>
</x-form.create>

@endsection