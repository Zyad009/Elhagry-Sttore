@extends('layouts.app')
@section('admin-title', 'Archive Cities')
@section('admin-content')
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold mb-0">All Deleted Cities</h2>
                <a href="{{ route('admin-dashboard.city.all') }}" class="btn btn-primary">
                    <i class='bx bx-collection'></i> All Cities
                </a>
            </div>
            <x-error></x-error>

            <x-table.index :items="$cities">
                <table class="table">
                    <thead>
                        <tr>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Deleted-At</th>
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
                                <b class="badge bg-label-danger me-1 fw-bold">
                                    {{ $city->deleted_at }}
                                </b>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <form action="{{ route(" admin-dashboard.city.restore", $city->id) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="bx bx-undo"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route(" admin-dashboard.city.remove", $city->id) }}" method="post"
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