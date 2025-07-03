@extends('layouts.app')
@section("admin-title" , "All Main Offers")
@section('admin-content')
<div class="card-body">
  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0">All Main Offers</h2>
        <div class="d-flex gap-2 mb-3">

          <a href="{{ route('admin-dashboard.offer.category.all') }}" class="btn btn-warning">
            Set Discount (Categories)
          </a>

          <a href="{{ route('admin-dashboard.offer.product.all') }}" class="btn btn-warning">
            Set Discount (Products)
          </a>

          <a href="{{ route('admin-dashboard.offer.new') }}" class="btn btn-primary">
            <i class='bx bx-plus bx-tada'></i> Create Main Offer
          </a>
        </div>
      </div>
      <x-error></x-error>

      <x-table.index :items="$offers">
        <table class="table">
          <thead>
            <tr>
              <th style="width: 10px">ID</th>
              <th class="text-center">Name</th>
              <th class="text-center">Discount</th>
              <th class="text-center">QTY Categories</th>
              <th class="text-center">QTY Product</th>
              <th class="text-center">Start Date</th>
              <th class="text-center">End Date</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach ($offers as $offer)
            <tr>
              <td>{{ $offer->id }} || </td>
              <td class="text-center"><i class="fab fa-angular fa-lg text-danger me-3 text-center"></i>
                @if ($offer->name == null)
                <x-special-text.primary-text title="(Special)" />
                @endif
                <strong>{{$offer->name}}</strong>
              </td>
              <td class="text-center">
                @if ($offer->discount_type == "percentage")
                %{{$offer->discount}}
                @else
                EGP {{$offer->discount}}
                @endif
              </td>
              <td class="text-center">{{ $offer->categories_count }}</td>
              <td class="text-center">{{ $offer->products_count }}</td>
              <td class="text-center">{{$offer->start_date }}</td>
              <td class="text-center">{{$offer->end_date }}</td>

              <td class="text-center">
                <div class="d-flex flex-row gap-2 align-items-center">
                  <a href="{{ route('admin-dashboard.offer.edit', $offer) }}" class="btn btn-icon btn-outline-warning">
                    <i class="bx bx-pencil"></i>
                  </a>
                  <form action="{{ route('admin-dashboard.offer.delete', $offer) }}" method="post"
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
          <h5 class="text-center">Total: {{ $offers->total() }}</h5>
        </table>

      </x-table.index>

      <div class="text-center p-3">
        {{ $offers->links() }}
      </div>
    </div>
  </div>
</div>
@endsection