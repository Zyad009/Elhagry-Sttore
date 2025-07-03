{{-- <livewire:front.layouts.nav /> --}}
<nav class="main-nav">
    <ul class="menu sf-arrows">
        <li class="megamenu-container {{request()->routeIs('home') ? " active" : "" }}">
            <a href="{{ route('home') }}">Home</a>
        </li>

        <li class="megamenu-container {{request()->routeIs('shop') ? " active" : "" }}">
            <a href="{{ route('shop') }}" >Shop</a>
        </li>

        <li class="megamenu-container {{request()->routeIs('about') ? " active" : "" }}">
            <a href="{{ route('about') }}" >About</a>
        </li>

        <li class="megamenu-container {{request()->routeIs('contact.index') ? " active" : "" }}">
            <a href="{{ route('contact.index') }}" >Contact</a>
        </li>

        @auth("admin")
        <li>
            <a href="{{ route('admin-dashboard.home') }}">
                <i class="fas fa-cog"></i> Dashboard
            </a>
        </li>
        @endauth

        @auth("web")
        <li>
            <a href="{{route('account.info' , auth()->guard('web')->user())}}">
                <i class="fas fa-cog"></i> Profile
            </a>
        </li>
        @endauth

    </ul><!-- End .menu -->
</nav><!-- End .main-nav -->