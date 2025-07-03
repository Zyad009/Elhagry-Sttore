@extends('layouts.app')
@section('admin-title', 'All sub-Categories')
@section('admin-content')
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold mb-0">All sub-Categories</h2>
                <a href="{{ route('admin-dashboard.subcategory.new') }}" class="btn btn-primary">
                    <i class='bx bx-plus bx-tada'></i> Create
                </a>
            </div>
            <x-error></x-error>

            <x-table.index :items="$subCategories">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Belongs To</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($subCategories as $subCategory)
                        <tr>
                            <td class="text-center">{{ $subCategory->id }} || </td>
                            <td class="text-center"><i class="fab fa-angular fa-lg text-danger me-3 text-center"></i>
                                <strong>{{
                                    $subCategory->name
                                    }}</strong>
                            </td>
                            <td class="text-center text-secondary">
                                @if ($subCategory->parent)
                                {{ $subCategory->parent->parent_id > 0 ? $subCategory->parent->name . ' (SUB)' :
                                $subCategory->parent->name . ' (MAIN)' }}
                                @else
                                <span class="text-muted">No Parent</span>
                                @endif

                            </td>
                            <td class="text-center">
                                @if (isset($subCategory->images->first()?->main_image))
                                <img src="{{ asset($subCategory->images->first()?->main_image) }}" class="product-image"
                                    alt="product">
                                @else
                                <b class="badge bg-label-danger me-1">No Image</b>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 align-items-center">
                                    <a href="{{ route('admin-dashboard.subcategory.edit', $subCategory) }}"
                                        class="btn btn-icon btn-outline-warning">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin-dashboard.subcategory.delete', $subCategory) }}"
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
                    <h5 class="text-center">Total: {{ $subCategories->total() }}</h5>
                </table>

            </x-table.index>

            <div class="text-center p-3">
                {{ $subCategories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection