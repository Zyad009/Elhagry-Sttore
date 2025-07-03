@extends('layouts.app')

@section('admin-title', 'View Sub For Master')

@section('admin-content')
<div class="card-body">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0">All Sub Categories For ({{$category->name}})</h2>
      </div>

      <x-success></x-success>
      <x-error></x-error>

      <x-table.index :items="$categories">
        <table class="table">
          <thead>
            <tr>
              <th style="width: 10px">ID</th>
              <th class="text-center">Name</th>
              <th class="text-center">Image</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach ($categories as $subCategory)
            <tr>
              <td class="text-center">{{ $subCategory->id }}</td>
              <td class="text-center">
                <i class="fab fa-angular fa-lg text-danger me-3"></i>
                <strong>{{$subCategory->name}}</strong>
              </td>
              <td class="text-center">
                @if (isset($subCategory->images->first()?->main_image))
                <img src="{{ asset($subCategory->images->first()?->main_image) }}" class="product-image" alt="product">
                @else
                <b class="badge bg-label-danger me-1 fw-bold">No Image</b>
                @endif
              </td>
              <td class="text-center">
                <div class="d-flex justify-content-center gap-2 align-items-center">
                  <a href="{{ route('admin-dashboard.subcategory.edit', $subCategory) }}"
                    class="btn btn-outline-warning">
                    <i class="bx bx-pencil"></i>
                  </a>
                  <form action="{{ route('admin-dashboard.subcategory.delete', $subCategory) }}" method="post"
                    data-confirm-delete="true">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger confirm-delete">
                      <i class="bx bx-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
          <h5 class="text-center mt-3">Total: {{ $categories->total() }}</h5>
        </table>
      </x-table.index>

      <div class="text-center p-3">
        {{ $categories->links() }}
      </div>
    </div>
  </div>
</div>
@endsection