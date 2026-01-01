<nav class="main_menu_2 main_menu d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex flex-wrap">
                <div class="main_menu_area">
                    <div class="menu_category_area">
                        <a href="{{ route('home') }}" wire:navigate class="menu_logo d-none">
                            <img
                                src="{{ isset($settings['logo']) && $settings['logo'] 
        ? asset('storage/' . $settings['logo']) 
        : asset('assets/frontend/images/logo_2.png') 
    }}"
                                alt="{{ $settings['website_name'] }}"
                                class="img-fluid w-100" />
                        </a>
                    
                    </div>
                    <!-- ?menu item -->
                    <livewire:frontend.theme.menu-item className="menu_item" />
                    <!-- ?menu item -->
                    <ul class="menu_icon">
                        <livewire:frontend.theme.compare-icon />
                        <livewire:frontend.theme.wishlist-icon />
                        <livewire:frontend.theme.cart-icon />
                        @auth
                        <li>
                            <a class="user"href="{{ route('user.dashboard') }}" wire:navigate>
                                <b>
                                    <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="cart" class="img-fluid">
                                </b>
                                <h5> {{ Auth::user()->name }}</h5>
                            </a>
                            <ul class="user_dropdown">
                                <li>
                                    <a href="{{ route('user.dashboard') }}" wire:navigate>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                                        </svg>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('user.profile') }}" wire:navigate>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        my account
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('user.orders') }}" wire:navigate>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                        </svg>
                                        my order
                                    </a>
                                </li>
                                <!-- logout -->
                                 <livewire:frontend.auth.logout />
                            </ul>
                        </li>
                        @else
                        <li>
                            <a class="user" href="{{ route('login') }}" wire:navigate>
                                <b>
                                    <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="cart" class="img-fluid">
                                </b>
                                <h5> Login </h5>
                            </a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>