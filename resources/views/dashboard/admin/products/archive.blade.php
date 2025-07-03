@extends('layouts.app')
@section('admin-title', 'Archive Products')
@section('admin-content')
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="fw-bold mb-0">All Deleted Products</h2>
                <a href="{{ route('admin-dashboard.product.all') }}" class="btn btn-primary">
                    <i class='bx bx-collection'></i> All Products
                </a>
            </div>
            <x-error></x-error>

            <x-table.index :items="$products">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">category</th>
                            <th class="text-center" tyle="min-width: 300px; white-space: nowrap;">Description</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">QTY</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Deleted-At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($products as $product)
                        <tr>
                            <td class="text-center">{{ $product->id }} || </td>
                            <td class="text-center"><i class="f ab fa-angular fa-lg text-danger me-3 text-center"></i>
                                <strong>{{
                                    $product->name
                                    }}</strong>
                            </td>
                            <td class="text-center">
                                @if (isset($product->category))
                                {{$product->category->name}}
                                @else
                                <b class="badge bg-label-danger me-1">No Category</b>
                                @endif
                            </td>
                            <td class="text-center" style="min-width: 300px;">
                                <textarea class="form-control" rows="3"
                                    style="width: 100%; height: 100px; resize: none;"
                                    readonly>{{ $product->description }}</textarea>
                            </td>
                            <td class="text-center">{{ $product->price }} <span>EGP</span></td>
                            <td class="text-center">
                                @if($product->QTY == 0)
                                <b class="badge bg-label-danger me-1">{{ $product->QTY }}</b>
                                @elseif($product->QTY <= 5) <b class="badge bg-label-warning me-1">{{ $product->QTY
                                    }}</b>
                                    @else
                                    {{ $product->QTY }}
                                    @endif
                            </td>
                            <td class="text-center">
                                <img src="{{ asset($product ->images->first()?->main_image) }}" class="product-image"
                                    alt="product">
                            </td>
                            <td class="text-center">
                                <b class="badge bg-label-danger me-1 fw-bold">
                                    {{ $product->deleted_at }}
                                </b>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <form action="{{ route('admin-dashboard.product.restore', $product->id) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="bx bx-undo"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin-dashboard.product.remove', $product->id) }}"
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
                    <h5 class="text-center">Total: {{ $products->total() }}</h5>
                </table>

            </x-table.index>

            <div class="text-center p-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection