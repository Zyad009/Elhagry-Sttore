<li class="menu-header small text-uppercase">
  <span class="menu-header-text">Pick-up Order Management</span>
</li>

<li class="menu-item {{request()->routeIs('pickup_orders.account') ? " active" : "" }}">
        <a href="{{ route('pickup_orders.account') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Analytics">Account</div>
        </a>
</li>

<li class="menu-item {{request()->routeIs('pickup_orders.index') ? " active" : "" }}">
  <a href="{{ route('pickup_orders.index') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-package"></i>
    <div>Pick-up Orders</div>
  </a>
</li>