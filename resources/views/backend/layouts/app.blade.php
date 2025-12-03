<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Admin Panel -</title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport" />
    <link
        rel="icon"
        href="{{ asset('assets/img/kaiadmin/favicon.ico') }}"
        type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/backend/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('assets/backend/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/css/plugins.min.css') }}" />

    <!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/backend/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/css/custom.css') }}" />
    @livewireStyles

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <livewire:backend.theme.sidebar />
        <!-- End Sidebar -->

        <div class="main-panel">
            <!-- navbar -->
            <livewire:backend.theme.header />
            <!-- navbar -->

            <div class="container">
                <div class="page-inner">


                    @yield('content')

                </div>
            </div>

            <livewire:backend.theme.footer />
        </div>


    </div>
    <!--   Core JS Files   -->
    <script data-navigate-once src="{{ asset('assets/backend/js/core/jquery-3.7.1.min.js') }}"></script>
    <script data-navigate-once src="{{ asset('assets/backend/js/core/popper.min.js') }}"></script>
    <script data-navigate-once src="{{ asset('assets/backend/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script data-navigate-once src="{{ asset('assets/backend/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script data-navigate-once src="{{ asset('assets/backend/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script data-navigate-once src="{{ asset('assets/backend/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script data-navigate-once src="{{ asset('assets/backend/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script data-navigate-once src="{{ asset('assets/backend/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script data-navigate-once src="{{ asset('assets/backend/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script data-navigate-once src="{{ asset('assets/backend/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script data-navigate-once src="{{ asset('assets/backend/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <!-- Sweet Alert -->
    <script data-navigate-once src="{{ asset('assets/backend/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Kaiadmin JS -->
    <script data-navigate-once src="{{ asset('assets/backend/js/kaiadmin.min.js') }}"></script>

    
    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script>
    @livewireScripts
    @stack('scripts')
</body>

</html>