@extends('layouts.app')
@section('admin-title', 'All Sale Officers')
@section('admin-content')

<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold mb-0">All Sale Officers</h2>
                <a href="{{ route('admin-dashboard.sale_officer.new') }}" class="btn btn-primary">
                    <i class='bx bx-plus bx-tada'></i> Create
                </a>
            </div>
            <x-error></x-error>

            <x-table.index :items="$saleOfficers">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Pickup Point</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Whatsapp</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center" style="width: 200px;">Address</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($saleOfficers as $saleOfficer)
                        <tr>
                            <td class="text-center">
                                @php
                                if($saleOfficer->gender == "male"){
                                $defaultImage = config("default-image.male-image");
                                }else{
                                $defaultImage = config("default-image.female-image");
                                }
                                @endphp
                                <div class="d-flex align-items-center">
                                    {{ $saleOfficer->id }} ||
                                    <img src="{{ asset($saleOfficer->images->first()?->main_image ?? $defaultImage ) }}"
                                        class="rounded-circle ms-2" alt="avatar"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            </td>
                            <td class="text-center"><i class="fab fa-angular fa-lg text-danger me-3 text-center"></i>
                                <strong>{{
                                    $saleOfficer->name
                                    }}</strong>
                            </td>

                            <td class="text-center">{{ $saleOfficer->email }}</td>
                            <td class="text-center">
                                @if ($saleOfficer->pickupPoint)
                                <b class="badge bg-label-primary me-1 fw-bold">
                                    {{ $saleOfficer->pickupPoint->name }}
                                </b>
                                @else
                                <b class="badge bg-label-danger me-1">No Pickup Point</b>
                                @endif
                            </td>
                            <td class="text-center">{{ $saleOfficer->phone }}</td>
                            <td class="text-center">{{ $saleOfficer->whatsapp }}</td>
                            <td class="text-center">{{ $saleOfficer->gender }}</td>
                            <td class="text-center">
                                <textarea class="form-control" rows="3"
                                    style="width: 100%; min-width: 200px; resize: none;" readonly>
                                    {{ $saleOfficer->address }}
                                </textarea>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <a href="{{ route('admin-dashboard.sale_officer.edit', $saleOfficer) }}"
                                        class="btn btn-icon btn-outline-warning">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin-dashboard.sale_officer.delete', $saleOfficer) }}"
                                        method="post" data-confirm-delete="true">
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
                    <h5 class="text-center">Total: {{ $saleOfficers->total() }}</h5>
                </table>

            </x-table.index>

            <div class="text-center p-3">
                {{ $saleOfficers->links() }}
            </div>
        </div>
    </div>
</div>

@endsection