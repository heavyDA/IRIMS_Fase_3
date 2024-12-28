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

</head>

<body>
    @include('layouts.partials.switcher')

    <div class="container">
        <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="d-flex justify-content-center auth-logo">
                    <img src="{{ asset('assets/images/brand/logo.webp') }}" style="height: 160px;" alt="logo"
                        class="desktop-logo">
                </div>
                <div class="card custom-card my-4 border z-3 position-relative">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <p class="h4 fw-semibold mb-4 text-center">{{ config('app.name', 'IRIMS') }}</p>
                            {{ html()->form('POST', route('auth.authenticate'))->id('signinForm')->open() }}
                            @session('validation')
                                <x-elements.alert :type="$value['type']->value" :message="$value['message']" />
                            @endsession
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <div class="position-relative">
                                        {{ html()->email('email')->class(['form-control', 'form-control-lg'])->id('signinEmail')->placeholder('Email')->autofocus() }}
                                    </div>
                                    @error('email')
                                        <x-forms.error>{{ $message }}</x-forms.error>
                                    @enderror
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <div class="position-relative">
                                        {{ html()->password('password')->class(['form-control', 'form-control-lg'])->id('signinPassword')->placeholder('Password') }}
                                        <a href="javascript:void(0);" class="show-password-button text-muted"
                                            onclick="createpassword('signinPassword',this)" id="signinShowPassword"><i
                                                class="ri-eye-off-line align-middle"></i></a>
                                    </div>
                                    @error('password')
                                        <x-forms.error>{{ $message }}</x-forms.error>
                                    @enderror
                                </div>
                            </div>
                            {{ html()->form()->close() }}
                            <div class="d-grid mt-4">
                                <button type="submit" form="signinForm" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-2 text-center d-flex flex-column justify-content-center">
                    <p style="height:8px">INTEGRATED RISK MANAGEMENT SYSTEM (IRIMS)</p>
                    <p style="height:8px">2024 © PT ANGKASA PURA II</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
