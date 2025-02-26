<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-nav-layout="vertical"
    data-theme-mode="light" data-header-styles="light" data-width="fullwidth" data-menu-styles="light" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IRIMS') }}</title>

    <link rel="icon" href="{{ asset('assets/images/brand/favicon.ico') }}" type="image/x-icon">

    @vite(['resources/js/app.js'])
    @vite(['resources/css/app.css', 'resources/css/icons.css'])
    @stack('top-script')

</head>

<body>
    {{-- @include('layouts.partials.switcher') --}}
    <!-- Loader -->
    <div id="loader">
        <img src="{{ asset('assets/images/media/loader.svg') }}" alt="">
    </div>
    <!-- Loader -->
    <!-- Page  -->
    <div class="page">
        @include('layouts.partials.header')

        @include('layouts.partials.sidebar')

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">
                <!-- Start::header-content -->
                <div
                    class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
                    @yield('header-content')
                </div>
                <!-- End::header-content -->

                <!-- Start::main-content -->
                <div class="my-2">
                    @yield('main-content')
                </div>
                <!-- End::main-content -->
            </div>
        </div>
        <!-- End::app-content -->

        @include('layouts.partials.footer')
    </div>
    <!-- Page  -->

    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow lh-1"><i class="ti ti-arrow-big-up fs-16"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <!-- Scroll To Top -->

    @stack('element')
    @stack('bottom-script')

    @if (session()->has('flash_message'))
        <script defer>
            document.addEventListener('DOMContentLoaded', () => {
                const message = @json(session('flash_message'));
                if (typeof window.alert_message === 'function') {
                    window.alert_message(message.type, '', message.message);
                }
            });
        </script>
    @endif
</body>

</html>
