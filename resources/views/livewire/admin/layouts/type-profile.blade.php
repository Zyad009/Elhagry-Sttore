<li>
  @if (auth()->guard('admin')->check())
  <a class="dropdown-item" href="{{route('admin-dashboard.account')}}">
      <i class="bx bx-user me-2"></i>
      <span class="align-middle">My Profile</span>
  </a>
  @elseif (auth()->guard('saleOfficer')->check())
  <a class="dropdown-item" href="{{route('pickup_orders.account')}}">
      <i class="bx bx-user me-2"></i>
      <span class="align-middle">My Profile</span>
  </a>
  @elseif (auth()->guard('customerService')->check())
  <a class="dropdown-item" href="{{route('delivery_orders.account')}}">
      <i class="bx bx-user me-2"></i>
      <span class="align-middle">My Profile</span>
  </a>
  @endif
</li>