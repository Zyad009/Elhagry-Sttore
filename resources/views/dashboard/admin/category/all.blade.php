@extends('layouts.app')
@section('admin-title', 'All Masters Categories')
@section('admin-content')
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold mb-0">All Masters Categories</h2>
                <a href="{{ route('admin-dashboard.category.new') }}" class="btn btn-primary">
                    <i class='bx bx-plus bx-tada'></i> Create
                </a>
            </div>
            <x-error></x-error>

            <x-table.index :items="$categories">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">Code</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Has Sub-Category</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($categories as $category)
                        <tr>
                            <td class="text-center">{{ $category->id }} || </td>
                            <td class="text-center"><i class="fab fa-angular fa-lg text-danger me-3 text-center"></i>
                                <strong>{{
                                    $category->name
                                    }}</strong>
                            </td>
                            <td class="text-center">
                                @if ($category->children_count > 0)
                                <a href="{{ route('admin-dashboard.category.view', $category) }}">
                                    Show <i class="bi bi-eye"></i>
                                </a>
                                @else
                                <p class="text-secondary">No</p>
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($category ->images->first()?->main_image))
                                <img src="{{ asset($category ->images->first()?->main_image) }}" class="product-image"
                                    alt="product">
                                @else
                                <x-special-text.danger-text title="No Image"></x-special-text.danger-text>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 align-items-center">
                                    <a href="{{ route('admin-dashboard.category.edit', $category) }}"
                                        class="btn btn-icon btn-outline-warning">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin-dashboard.category.delete', $category) }}"
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
                    <h5 class="text-center">Total: {{ $categories->total() }}</h5>
                </table>

            </x-table.index>

            <div class="text-center p-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection