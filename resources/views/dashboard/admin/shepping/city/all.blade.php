@extends('layouts.app')
@section('admin-title', 'All Cities')
@section('admin-content')
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold mb-0">All Cities</h2>
                <a href="{{ route('admin-dashboard.city.new') }}" class="btn btn-primary">
                    <i class='bx bx-plus bx-tada'></i> Create
                </a>
            </div>
            <x-error></x-error>

            <x-table.index :items="$cities">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($cities as $city)
                        <tr>
                            <td class="text-center">{{ $city->id }} || </td>
                            <td class="text-center"><i class="f ab fa-angular fa-lg text-danger me-3 text-center"></i>
                                <strong>{{
                                    $city->name
                                    }}</strong>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 align-items-center">
                                    <a href="{{ route('admin-dashboard.city.edit', $city) }}"
                                        class="btn btn-icon btn-outline-warning">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin-dashboard.city.delete', $city) }}" method="post"
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
                    <h5 class="text-center">Total: {{ $cities->total() }}</h5>
                </table>

            </x-table.index>

            <div class="text-center p-3">
                {{ $cities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection