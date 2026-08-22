<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="{{ asset('new-template/img/favicon.png') }}" type="image/png" />
    <title>@yield('title', __('store.app_name'))</title>

    <link rel="stylesheet" href="{{ asset('new-template/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/vendors/linericon/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/css/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/css/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/vendors/owl-carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/vendors/lightbox/simpleLightbox.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/vendors/nice-select/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/vendors/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/vendors/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/css/rtl.css') }}" />
    @stack('styles')
</head>

<body class="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    @include('layouts.navbar')

    @yield('content')

    @include('layouts.footer')

    <script src="{{ asset('new-template/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('new-template/js/popper.js') }}"></script>
    <script src="{{ asset('new-template/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('new-template/js/stellar.js') }}"></script>
    <script src="{{ asset('new-template/vendors/lightbox/simpleLightbox.min.js') }}"></script>
    <script src="{{ asset('new-template/vendors/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('new-template/vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('new-template/vendors/isotope/isotope-min.js') }}"></script>
    <script src="{{ asset('new-template/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('new-template/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('new-template/vendors/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('new-template/vendors/counter-up/jquery.counterup.js') }}"></script>
    <script src="{{ asset('new-template/js/mail-script.js') }}"></script>
    <script src="{{ asset('new-template/js/theme.js') }}"></script>
    <script src="{{ asset('new-template/js/main.js') }}"></script>
    <script src="{{ asset('new-template/js/cart.js') }}"></script>

    @stack('scripts')
</body>

</html>
