            <nav class="main-nav">
                <ul class="menu sf-arrows">
                    <li class="megamenu-container {{request()->routeIs('home') ? "active" : "" }}">
                        <a href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="megamenu-container {{request()->routeIs('shop') ? "active" : "" }}">
                        <a href="{{ route('shop') }}" wire:navigate.hover>Shop</a>
                    </li>

                    {{-- <li>
                        <a class="sf-with-ul">Categories</a>
                        <ul>
                            <li>
                                <a href="about.html" class="sf-with-ul" wire:navigate.hover>About</a>
                            </li>
                        </ul>
                    </li> --}}

                    <li class="megamenu-container {{request()->routeIs('about') ? "active" : "" }}">
                        <a href="{{ route('about') }}" wire:navigate.hover>About</a>
                    </li>

                    <li class="megamenu-container {{request()->routeIs('contact') ? "active" : "" }}">
                        <a href="{{ route('contact') }}" wire:navigate.hover>Contact</a>
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