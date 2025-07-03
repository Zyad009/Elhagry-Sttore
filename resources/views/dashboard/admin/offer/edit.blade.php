@extends('layouts.app')
@section("admin-title" , "Edit Main Discount")
@section('admin-content')

<x-form.edit title="Add New Main Discount" :name="$offer->code">

    <form method="post" action="{{route('admin-dashboard.offer.update', $offer)}}" novalidate class="">
        @csrf
        @method("PUT")

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">Name <span class="text-danger">*</label>
                <input type="text" name="name" id="" value="{{$offer->code}}" class="form-control">
                <x-message.error name="name"></x-message.error>
            </div>

            <div class="col-md-6">
                <label for=""> Discount Type <span class="text-danger">*</label>
                <select name="discount_type" class="form-control">
                    <option value="{{$offer->discount_type}}">{{ucfirst($offer->discount_type)}}</option>
                    @if ($offer->discount_type == "percentage")
                    <option value="value">Value</option>
                    @else
                    <option value="percentage">Percentage</option>
                    @endif
                </select>
                <x-message.error name="discount_type"></x-message.error>
            </div>

        </div>
        <div class="row mb-3">

            <div class="col-md-4">
                <label>Start Date <span class="text-danger">*</label>
                <input type="datetime-local" value="{{$offer->start_date}}" name="start_date" class="form-control">
                <x-message.error name="start_date"></x-message.error>
            </div>

            <div class="col-md-4">
                <label>End Date <span class="text-danger">*</label>
                <input type="datetime-local" name="end_date" value="{{$offer->end_date}}" class="form-control">
                <x-message.error name="end_date"></x-message.error>
            </div>

            <div class="col-md-4">
                <label>Discount <span class="text-danger">*</label>
                <input type="number" min="1" name="discount" value="{{$offer->discount}}" class="form-control">
                <x-message.error name="discount"></x-message.error>
            </div>
        </div>
        <x-button.submit.edit></x-button.submit.edit>
    </form>
    </x-form.create>

    @endsection