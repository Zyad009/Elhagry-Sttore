@extends('layouts.app')
@section('admin-title', 'All Areas For Cities')

@section('admin-content')
<section class="section dashboard">
  <div class="row g-4">
    @forelse ($cities as $city)
    <div class="col-lg-4 col-md-6 col-12">
      <div class="card info-card sales-card shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">Areas for {{ $city->name }}</h5>
          <h4 class="fw-bold">All Areas In {{ $city->name }}</h4>
          <p class="text-muted small">Edit & Delete & View All & Create</p>
          <a href="{{ route('admin-dashboard.area.all', $city) }}" class="btn btn-primary ">
            <i class="bx bx-list-ul fs-4"></i>
          </a>
        </div>
      </div>
    </div>
    @empty
    <div class="col-12">
      <div class="alert alert-danger text-center" role="alert">
        No City Found
      </div>
    </div>
    @endforelse
  </div>
</section>
@endsection