@extends('layouts.app')
@section('admin-title', 'Archive Categories')
@section('admin-content')
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold mb-0">All Deleted Masters Categories</h2>
                <a href="{{ route('admin-dashboard.category.all') }}" class="btn btn-primary">
                    <i class='bx bx-collection'></i> All Categories
                </a>
            </div>
            <x-error></x-error>

            <x-table.index :items="$categories">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Has Sub-Category</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Deleted-At</th>
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
                                <p class="text-secondary">Show</p> <i class="bi bi-eye"></i>
                                </a>
                                @else
                                <p class="text-secondary">No</p>
                                @endif
                            </td>
                            <td class="text-center">
                                @if (isset($category ->images->first()?->main_image))
                                <img src="{{ asset($category->images->first()?->main_image) }}" class="product-image"
                                    alt="product">
                                @else
                                <b class="badge bg-label-danger me-1">No Image</b>
                                @endif
                            </td>

                            <td class="text-center">
                                <b class="badge bg-label-danger me-1 fw-bold">
                                    {{ $category->deleted_at }}
                                </b>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <form action="{{ route('admin-dashboard.category.restore', $category->id) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="bx bx-undo"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin-dashboard.category.remove', $category->id) }}"
                                        method="post" data-confirm-delete="true">
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