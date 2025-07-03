<li class="menu-header small text-uppercase">
  <span class="menu-header-text">Delivery Order Management</span>
</li>

<li class="menu-item {{request()->routeIs('delivery_orders.account') ? " active" : "" }}">
  <a href="{{ route('delivery_orders.account') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-user"></i>
    <div data-i18n="Analytics">Account</div>
  </a>
</li>

<li class="menu-item {{request()->routeIs('delivery_orders.index') ? " active" : "" }}">
  <a href="{{ route('delivery_orders.index') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-send"></i>
    <div>Delivery Orders</div>
  </a>
</li>

