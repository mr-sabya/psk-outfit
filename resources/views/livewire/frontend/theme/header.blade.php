<header class="header_2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2">
                <div class="header_logo_area">
                    <a href="{{ route('home') }}" wire:navigate class="header_logo">
                        <img
                            src="{{ isset($settings['logo']) && $settings['logo'] 
        ? asset('storage/' . $settings['logo']) 
        : asset('assets/frontend/images/logo_2.png') 
    }}"
                            alt="{{ $settings['website_name'] }}"
                            class="img-fluid w-100" />
                    </a>
                    <div class="mobile_menu_icon d-block d-lg-none" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                        <span class="mobile_menu_icon"><i class="far fa-stream menu_icon_bar"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-xxl-10 col-xl-10 col-lg-10 d-none d-lg-flex">
                <div class="header_support_user d-flex flex-wrap justify-contents-end">
                    <div class="header_support">
                        <span class="icon">
                            <i class="far fa-phone-alt"></i>
                        </span>
                        <h3>
                            Hotline:
                            <a href="tel:{{ isset($settings['phone']) && $settings['phone'] ? $settings['phone'] : '1234567890' }}">
                                <span>
                                    {{ isset($settings['phone']) && $settings['phone'] ? $settings['phone'] : '+(402) 763 282 46' }}
                                </span>
                            </a>

                        </h3>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>