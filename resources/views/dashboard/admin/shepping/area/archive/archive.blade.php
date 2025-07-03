@extends('layouts.app')
@section('admin-title', 'Archive Areas')
@section('admin-content')
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold mb-0">All Deleted Areas</h2>
                <a href="{{ route('admin-dashboard.area.all' , $city) }}" class="btn btn-primary">
                    <i class='bx bx-collection'></i> All Areas
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
                            <th class="text-center">Deleted-At</th>
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
                                <b class="badge bg-label-danger me-1 fw-bold">
                                    {{ $area->deleted_at }}
                                </b>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <form action="{{ route('admin-dashboard.area.restore', $area->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="bx bx-undo"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin-dashboard.area.remove', $area->id) }}" method="post"
                                        data-confirm-delete="true">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
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