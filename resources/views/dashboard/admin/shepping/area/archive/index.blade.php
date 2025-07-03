@extends('layouts.app')
@section('admin-title', 'Archive Areas For City')
@section('admin-content')
<h2 class="mb-4 text-center">Archive Areas For City</h2>
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="list-group">
                @forelse ( $cities as $city )
                <a href="{{ route('admin-dashboard.area.archive', $city) }}"
                    class="list-group-item list-group-item-action">
                    <i class="bi bi-map-fill"></i> {{ $city->name }}
                </a>
                @empty
                <div class="col-12">
                    <div class="alert alert-danger text-center" role="alert">
                        No City Found
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @endsection