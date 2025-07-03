@extends('layouts.app')
@section('admin-title', 'All Pickup Points')
@section('admin-content')
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold mb-0">All Pickup Points</h2>
                <a href="{{ route('admin-dashboard.pickup_point.new') }}" class="btn btn-primary">
                    <i class='bx bx-plus bx-tada'></i> Create
                </a>
            </div>
            <x-error></x-error>

            <x-table.index :items="$pickupPoints">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Manager</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($pickupPoints as $pickupPoint)
                        <tr>
                            <td>{{ $pickupPoint->id }} || </td>
                            <td class="text-center"><i class="fab fa-angular fa-lg text-danger me-3 text-center"></i>
                                <strong>{{
                                    $pickupPoint->name
                                    }}</strong></td>
                            <td class="text-center">
                                <textarea class="form-control" rows="3"
                                    style="width: 100%; height: 100px; resize: none;"
                                    readonly>{{ $pickupPoint->address }}</textarea>
                            </td>
                            <td class="text-center">{{ $pickupPoint->phone }}</td>
                            <td class="text-center">
                                @if ($pickupPoint->saleOfficer)
                                {{ $pickupPoint->saleOfficer->name }}
                                @else
                                <b class="badge bg-label-danger me-1">No Sale Officer</b>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex flex-row gap-2 align-items-center">
                                    <a href="{{ route('admin-dashboard.pickup_point.edit', $pickupPoint) }}"
                                        class="btn btn-icon btn-outline-warning">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin-dashboard.pickup_point.delete', $pickupPoint) }}" method="post"
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
                    <h5 class="text-center">Total: {{ $pickupPoints->total() }}</h5>
                </table>

            </x-table.index>

            <div class="text-center p-3">
                {{ $pickupPoints->links() }}
            </div>
        </div>
    </div>
</div>
@endsection