<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $title ?? 'Dolfin Brain' }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" type="image/png" href="{{ asset('dist/images/logos/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('dist/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">

    {{-- CSS Tema Utama --}}
    <link id="themeColors" rel="stylesheet" href="{{ asset('dist/css/style.min.css') }}" />

    {{-- CSS untuk Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @stack('styles')
    @livewireStyles
</head>

<body>
    <div class="preloader">
        <img src="{{ asset('dist/images/logos/favicon.ico') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>

    <div class="page-wrapper" id="main-wrapper" data-theme="blue_theme" data-layout="vertical" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <x-partials.sidebar />

        <div class="body-wrapper">
            <x-partials.header />
            <div class="container-fluid">
                {{ $slot }}
            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{--                  AREA SCRIPT                    --}}
    {{-- =============================================== --}}

    <script src="{{ asset('dist/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('dist/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.init.js') }}"></script>
    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('dist/js/custom.js') }}"></script>
    <script src="{{ asset('dist/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('dist/js/dashboard.js') }}"></script>

    {{-- Baris script AlpineJS telah dihapus dari sini --}}

    @livewireScripts
    @stack('scripts')
</body>

</html>
