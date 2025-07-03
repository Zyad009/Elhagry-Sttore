@extends('layouts.app')
@section("admin-title" , "Edit City")
@section('admin-content')

<x-form.edit title="Edit City" :name="$city->name">

    <form method="post" action="{{route(" admin-dashboard.city.update" , $city)}}" novalidate class="">
        <x-error></x-error>
        <x-success></x-success>
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="">Name</label>
            <input type="text" name="name" value="{{$city->name}}" id="" class="form-control">
        </div>

        <x-button.submit.edit></x-button.submit.edit>
    </form>
</x-form.edit>

@endsection