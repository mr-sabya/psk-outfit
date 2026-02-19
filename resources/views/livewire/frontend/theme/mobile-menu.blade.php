<div class="mobile_menu_area">
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i
                class="fal fa-times"></i></button>
        <div class="offcanvas-body">



            <ul class="mobile_menu_header d-flex flex-wrap">

                <livewire:frontend.theme.compare-icon />

                <livewire:frontend.theme.cart-icon />

                @auth
                <li>
                    <a href="{{ route('user.dashboard') }}" wire:navigate>
                        <b><img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="cart" class="img-fluid"></b>
                    </a>
                </li>
                
                @else
                <li>
                    <a href="{{ route('login') }}" wire:navigate>
                        <b><img src="{{ url('assets/frontend/images/user_icon_black.svg') }}" alt="cart" class="img-fluid"></b>
                    </a>
                </li>
                @endauth
            </ul>

            <form class="mobile_menu_search">
                <input type="text" placeholder="Search">
                <button type="submit"><i class="far fa-search"></i></button>
            </form>

            <div class="mobile_menu_item_area">
                <livewire:frontend.theme.menu-item className="main_mobile_menu" />
            </div>
        </div>
    </div>
</div>