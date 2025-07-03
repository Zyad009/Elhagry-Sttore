@extends("admin.layouts.app")
@section("title", "Archived Records")
@section("admin-content")

<h2 class="mb-4 text-center">Archived Records</h2>
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-body">
      <div class="list-group">
        <!-- Categories -->
        <a href="{{ route('admin-dashboard.category.archive') }}"
          class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bx bx-grid-alt me-2"></i> Categories
        </a>

        <!-- Sub-Categories -->
        <a href="{{ route('admin-dashboard.subcategory.archive') }}"
          class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bx bx-grid me-2"></i> Sub-Categories
        </a>

        <!-- Products -->
        <a href="{{ route('admin-dashboard.product.archive') }}"
          class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bx bx-box me-2"></i> Products
        </a>
        <br>
        <!-- Admins -->
        <a href="{{ route('admin-dashboard.editors.archive') }}"
          class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bx bx-user me-2"></i> Admins
        </a>

        <!-- Branches -->
        <a href="{{ route('admin-dashboard.pickup_point.archive') }}"
          class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bx bx-building me-2"></i> Pickup Points
        </a>

        <!-- Customer Service -->
        <a href="{{ route('admin-dashboard.customer_s.archive') }}"
          class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bx bx-headphone me-2"></i> Customer Service
        </a>

        <!-- Sale Officer -->
        <a href="{{ route('admin-dashboard.sale_officer.archive') }}"
          class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bx bx-id-card"></i> Sale Officer
        </a>

        <br>
        <!-- City -->
        <a href="{{ route('admin-dashboard.city.archive') }}"
          class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bx bx-map me-2"></i> City
        </a>

        <!-- Area -->
        <a href="{{ route('admin-dashboard.area.index') }}"
          class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="bx bx-map-pin me-2"></i> Area
        </a>
      </div>
    </div>
  </div>
</div>

@endsection