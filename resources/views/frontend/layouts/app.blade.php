<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <title>Zenis- Multipurpose eCommerce HTML Template</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/frontend/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/mobile_menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/scroll_button.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/jquery.pwstabs.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/range_slider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/multiple-image-video.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animated_barfiller.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/custom_spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}">
    @livewireStyles
</head>

<body class="default_home">

    <!--=========================
        HEADER START
    ==========================-->
    <livewire:frontend.theme.header />
    <!--=========================
        HEADER END
    ==========================-->


    <!--=========================
        MENU 2 START
    ==========================-->
    <livewire:frontend.theme.menu />

    <livewire:frontend.theme.minicart />
    <!--=========================
        MENU 2 END
    ==========================-->


    <!--============================
        MOBILE MENU START
    ==============================-->
    <livewire:frontend.theme.mobile-menu />
    <!--============================
        MOBILE MENU END
    ==============================-->
    @yield('content')

    <!--=========================
        FOOTER 2 START
    ==========================-->
    <livewire:frontend.theme.footer />
    <!--=========================
        FOOTER 2 END
    ==========================-->


    <!--==========================
        SCROLL BUTTON START
    ===========================-->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!--==========================
        SCROLL BUTTON END
    ===========================-->


    <!--jquery library js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/jquery-3.7.1.min.js') }}"></script>
    <!--bootstrap js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('assets/frontend/js/Font-Awesome.js') }}"></script>
    <!--counter js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/jquery.waypoints.min.js') }}"></script>
    <script data-navigate-once src="{{ asset('assets/frontend/js/jquery.countup.min.js') }}"></script>
    <!--nice select js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/jquery.nice-select.min.js') }}"></script>
    <!--select 2 js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/select2.min.js') }}"></script>
    <!--simply countdown js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/simplyCountdown.js') }}"></script>
    <!--slick slider js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/slick.min.js') }}"></script>
    <!--venobox js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/venobox.min.js') }}"></script>
    <!--wow js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/wow.min.js') }}"></script>
    <!--marquee js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/jquery.marquee.min.js') }}"></script>
    <!--pws tabs js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/jquery.pwstabs.min.js') }}"></script>
    <!--scroll button js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/scroll_button.js') }}"></script>
    <!--youtube background js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/jquery.youtube-background.min.js') }}"></script>
    <!--range slider js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/range_slider.js') }}"></script>
    <!--sticky sidebar js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/sticky_sidebar.js') }}"></script>
    <!--multiple image upload js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/multiple-image-video.js') }}"></script>
    <!--animated barfiller js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/animated_barfiller.js') }}"></script>
    <!--main/custom js-->
    <script data-navigate-once src="{{ asset('assets/frontend/js/custom.js') }}"></script>

    <script>
        document.querySelectorAll("[data-bg]").forEach(el => {
            const bg = el.getAttribute("data-bg");
            el.style.backgroundImage = `url('${bg}')`;
            el.style.backgroundSize = "cover";
            el.style.backgroundPosition = "center";
            el.style.backgroundRepeat = "no-repeat";
        });
    </script>
    @livewireScripts

</body>


</html>