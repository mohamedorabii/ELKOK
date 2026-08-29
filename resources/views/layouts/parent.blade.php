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
    <link rel="stylesheet" href="{{ asset('new-template/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('new-template/css/rtl.css') }}" />
    @stack('styles')
</head>
{{-- WhatsApp Floating Button --}}
<a href="https://wa.me/201040522867" target="_blank" rel="noopener" class="whatsapp-float" aria-label="Chat on WhatsApp">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="#fff">
        <path d="M16.001 3C9.373 3 4 8.373 4 15c0 2.393.688 4.623 1.877 6.5L4 29l7.688-1.834C13.44 27.688 14.688 28 16.001 28 22.628 28 28 22.628 28 16S22.628 3 16.001 3zm7.11 18.32c-.303.85-1.51 1.56-2.463 1.756-.66.14-1.52.25-4.42-.95-3.71-1.53-6.1-5.27-6.29-5.52-.18-.25-1.51-2.01-1.51-3.83 0-1.82.95-2.72 1.29-3.09.34-.37.74-.46.99-.46.25 0 .49 0 .71.01.23.01.53-.09.83.63.3.72 1.03 2.49 1.12 2.67.09.18.15.4.03.65-.12.25-.18.4-.36.62-.18.22-.38.49-.54.66-.18.19-.37.4-.16.77.21.37.94 1.55 2.02 2.51 1.39 1.24 2.56 1.63 2.93 1.81.37.18.59.15.81-.09.22-.24.94-1.09 1.19-1.47.25-.37.5-.31.83-.19.34.12 2.14 1.01 2.51 1.19.37.19.61.28.7.44.09.15.09.86-.21 1.71z"/>
    </svg>
</a>
<body class="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    @include('layouts.navbar')

    @yield('content')

    @include('layouts.footer')

    <script src="{{ asset('new-template/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('new-template/js/popper.js') }}"></script>
    <script src="{{ asset('new-template/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('new-template/js/theme.js') }}"></script>
    <script src="{{ asset('new-template/js/main.js') }}"></script>
    <script src="{{ asset('new-template/js/cart.js') }}"></script>

    @stack('scripts')
</body>

</html>