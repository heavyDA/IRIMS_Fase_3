<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-nav-layout="vertical"
    data-theme-mode="light" data-header-styles="light" data-width="fullwidth" data-menu-styles="light" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IRIMS') }}</title>

    <link rel="icon" href="{{ asset('assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    @vite(['resources/js/app.js'])
    @vite(['resources/css/app.css', 'resources/css/icons.css'])

</head>

<body>
    @include('layouts.partials.switcher')

    <div class="container">
        <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="mb-3 d-flex justify-content-center auth-logo">
                    <a href="index.html">
                        <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
                    </a>
                </div>
                <div class="card custom-card my-4 border z-3 position-relative">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <span class="auth-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" id="password">
                                        <path fill="#6446fe"
                                            d="M59,8H5A1,1,0,0,0,4,9V55a1,1,0,0,0,1,1H59a1,1,0,0,0,1-1V9A1,1,0,0,0,59,8ZM58,54H6V10H58Z"
                                            class="color1d1f47 svgShape"></path>
                                        <path fill="#6446fe"
                                            d="M36,35H28a3,3,0,0,1-3-3V27a3,3,0,0,1,3-3h8a3,3,0,0,1,3,3v5A3,3,0,0,1,36,35Zm-8-9a1,1,0,0,0-1,1v5a1,1,0,0,0,1,1h8a1,1,0,0,0,1-1V27a1,1,0,0,0-1-1Z"
                                            class="color0055ff svgShape"></path>
                                        <path fill="#6446fe"
                                            d="M36 26H28a1 1 0 0 1-1-1V24a5 5 0 0 1 10 0v1A1 1 0 0 1 36 26zm-7-2h6a3 3 0 0 0-6 0zM32 31a1 1 0 0 1-1-1V29a1 1 0 0 1 2 0v1A1 1 0 0 1 32 31z"
                                            class="color0055ff svgShape"></path>
                                        <path fill="#6446fe"
                                            d="M59 8H5A1 1 0 0 0 4 9v8a1 1 0 0 0 1 1H20.08a1 1 0 0 0 .63-.22L25.36 14H59a1 1 0 0 0 1-1V9A1 1 0 0 0 59 8zm-1 4H25l-.21 0a1.09 1.09 0 0 0-.42.2L19.73 16H6V10H58zM50 49H14a1 1 0 0 1-1-1V39a1 1 0 0 1 1-1H50a1 1 0 0 1 1 1v9A1 1 0 0 1 50 49zM15 47H49V40H15z"
                                            class="color1d1f47 svgShape"></path>
                                        <circle cx="19.5" cy="43.5" r="1.5" fill="#6446fe"
                                            class="color0055ff svgShape"></circle>
                                        <circle cx="24.5" cy="43.5" r="1.5" fill="#6446fe"
                                            class="color0055ff svgShape"></circle>
                                        <circle cx="29.5" cy="43.5" r="1.5" fill="#6446fe"
                                            class="color0055ff svgShape"></circle>
                                        <circle cx="34.5" cy="43.5" r="1.5" fill="#6446fe"
                                            class="color0055ff svgShape"></circle>
                                        <circle cx="39.5" cy="43.5" r="1.5" fill="#6446fe"
                                            class="color0055ff svgShape"></circle>
                                        <circle cx="44.5" cy="43.5" r="1.5" fill="#6446fe"
                                            class="color0055ff svgShape"></circle>
                                        <path fill="#6446fe"
                                            d="M60 9a1 1 0 0 0-1-1H28.81l2.37-2.37A19.22 19.22 0 0 1 60 31zM35.19 56l-2.37 2.37A19.22 19.22 0 0 1 4 33V55a1 1 0 0 0 1 1z"
                                            opacity=".3" class="color0055ff svgShape"></path>
                                    </svg>
                                </span>
                            </div>
                            <p class="h4 fw-semibold mb-4 text-center">{{ config('app.name', 'IRIMS') }}</p>
                            {{ html()->form('POST', route('auth.authenticate'))->id('signinForm')->open() }}
                            @session ('validation')
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
            </div>
        </div>
    </div>
</body>

</html>
