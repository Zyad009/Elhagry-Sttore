@extends('layouts.app')
@section("admin-title" , "Edit Area")
@section('admin-content')

<x-form.edit title="Edit Area" :name="$area->name">
    <form method="post" action="{{route(" admin-dashboard.area.update" , $area)}}" novalidate class="">
        <x-error></x-error>
        <x-success></x-success>
        @csrf
        @method("PUT")

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="">City</label>
                <select name="city_id" id="city_id" class="form-control">
                    @foreach($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="">Name</label>
                <input type="text" name="name" value="{{$area->name}}" class="form-control">
            </div>
        </div>
        <div class="row mb-3">

            <div class="col-md-6">
                <label for="">Price Regular</label>
                <input type="number" step="0.01" min="0" name="delivery_price_regular"
                    value="{{$area->delivery_price_regular}}" id="" class="form-control">
            </div>

            <div class="col-md-6">
                <label for="">Price Super</label>
                <input type="number" step="0.01" min="0" name="delivery_price_super"
                    value="{{$area->delivery_price_super}}" id="" class="form-control">
            </div>

        </div>

        <x-button.submit.edit></x-button.submit.edit>
    </form>
</x-form.edit>


@endsection