@extends('layouts.app')
@section('admin-title', 'All Users')
@section("users-active", "active")
@section('admin-content')

<div class="d-flex justify-content-between align-items-center">
    <h1 class="fw-bold ">All Users</h1>
</div>

<livewire:user.search-user>
    @endsection