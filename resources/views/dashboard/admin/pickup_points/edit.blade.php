@extends('layouts.app')
@section("admin-title" , "Edit Pickup Point")
@section('admin-content')



<x-form.edit title="Edit Pickup Point" :name="$pickupPoint->name">

    <form method="post" action="{{route("admin-dashboard.pickup_point.update" , $pickupPoint )}}" novalidate class=""
        enctype="multipart/form-data">
        <x-error></x-error>
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Name </label>
                <input type="text" name="name" value="{{$pickupPoint->name}}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="{{$pickupPoint->phone}}" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="">Address</label>
                <textarea type="text" name="address" class="form-control">
                    {{$pickupPoint->address}}
                </textarea>
            </div>
{{-- 
            <div class="col-md-6">
                <label for="">Sale Officer</label>
                <select name="sale_officer_id" class="form-control">
                    @foreach($editors as $editor)
                    <option value="{{ $editor->id }}">{{ $editor->name }}</option>
                    @endforeach
                </select>
            </div> --}}
        </div>
        <x-button.submit.edit></x-button.submit.edit>
    </form>
</x-form.edit>


@endsection