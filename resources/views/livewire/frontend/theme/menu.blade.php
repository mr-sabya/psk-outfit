<nav class="main_menu_2 main_menu d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex flex-wrap">
                <div class="main_menu_area">
                    <div class="menu_category_area">
                        <a href="index.html" class="menu_logo d-none">
                            <img src="{{ url('assets/frontend/images/logo_2.png') }}" alt="Zenis" class="img-fluid w-100">
                        </a>
                        <div class="menu_category_bar">
                            <p>
                                <span>
                                    <img src="{{ url('assets/frontend/images/bar_icon_white.svg') }}" alt="category icon">
                                </span>
                                Browse Categories
                            </p>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <livewire:frontend.theme.menu-category />
                    </div>
                    <!-- ?menu item -->
                    <livewire:frontend.theme.menu-item className="menu_item" />
                    <!-- ?menu item -->
                    <ul class="menu_icon">
                        <li>
                            <a href="compare.html">
                                <b>
                                    <img src="{{ url('assets/frontend/images/compare_black.svg') }}" alt="Wishlist" class="img-fluid">
                                </b>
                                <span>2</span>
                            </a>
                        </li>
                        <li>
                            <a href="wishlist.html">
                                <b>
                                    <img src="{{ url('assets/frontend/images/love_black.svg') }}" alt="Wishlist" class="img-fluid">
                                </b>
                                <span>5</span>
                            </a>
                        </li>
                        <li>
                            <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                aria-controls="offcanvasRight">
                                <b>
                                    <img src="{{ url('assets/frontend/images/cart_black.svg') }}" alt="cart" class="img-fluid">
                                </b>
                                <span>3</span>
                            </a>
                        </li>
                        <li>
                            <a class="user" href="dashboard.html">
                                <b>
                                    <img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="cart" class="img-fluid">
                                </b>
                                <h5> Smith Jhon</h5>
                            </a>
                            <ul class="user_dropdown">
                                <li>
                                    <a href="dashboard.html">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                                        </svg>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="dashboard_profile.html">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        my account
                                    </a>
                                </li>
                                <li>
                                    <a href="dashboard_order.html">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                        </svg>
                                        my order
                                    </a>
                                </li>
                                <li>
                                    <a href="dashboard_wishlist.html">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                        </svg>
                                        wishlist
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                        </svg>
                                        logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>