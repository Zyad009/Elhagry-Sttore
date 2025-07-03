@extends('layouts.app')
@section('admin-title', 'All Areas')
@section('admin-content')
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold mb-0">All Areas ({{ $city->name }})</h2>
                <a href="{{ route('admin-dashboard.area.new' , $city) }}" class="btn btn-primary">
                    <i class='bx bx-plus bx-tada'></i> Create
                </a>
            </div>
            <x-error></x-error>

            <x-table.index :items="$areas">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th class="text-center">Name Area</th>
                            <th class="text-center">Price Regular</th>
                            <th class="text-center">Price Super</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($areas as $area)
                        <tr>
                            <td class="text-center">{{ $area->id }} || </td>
                            <td class="text-center"><i class="f ab fa-angular fa-lg text-danger me-3 text-center"></i>
                                <strong>{{
                                    $area->name
                                    }}</strong>
                            </td>
                            <td class="text-center">{{ $area->delivery_price_regular }} <span>EGP</span></td>
                            <td class="text-center">{{ $area->delivery_price_super }} <span>EGP</span></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 align-items-center">
                                    <a href="{{ route('admin-dashboard.area.edit', $area) }}"
                                        class="btn btn-icon btn-outline-warning">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin-dashboard.area.delete', $area) }}" method="post"
                                        data-confirm-delete="true">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-outline-danger confirm-delete">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <h5 class="text-center">Total: {{ $areas->total() }}</h5>
                </table>

            </x-table.index>

            <div class="text-center p-3">
                {{ $areas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection