@extends('layouts.app')
@section("admin-title" , "Create City")
@section('admin-content')

<x-form.create title="Add New City">

    <form method="post" action="{{route(" admin-dashboard.city.store")}}" novalidate class=""
        enctype="multipart/form-data">
        <x-error></x-error>
        <x-success></x-success>
        @csrf

        <div class="mb-3">
            <label for="">Name</label>
            <input type="text" name="name" id="" class="form-control">
        </div>

        <x-button.submit.create></x-button.submit.create>
    </form>
</x-form.create>
@endsection