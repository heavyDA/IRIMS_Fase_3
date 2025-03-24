<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-nav-layout="vertical"
    data-theme-mode="light" data-header-styles="light" data-width="fullwidth" data-menu-styles="light" data-toggled="close">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIERINA') }}</title>

    <link rel="icon" href="{{ asset('assets/images/brand/favicon.ico') }}" type="image/x-icon">

    @vite(['resources/js/app.js'])
    @vite(['resources/css/app.css', 'resources/css/icons.css'])

</head>

<body>
    {{-- @include('layouts.partials.switcher') --}}

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
                            <form id="signinForm" method="POST" action="{{ route('auth.authenticate') }}">
                                @csrf
                                <input type="hidden" name="timezone" id="timezone">
                                @session('validation')
                                    <x-elements.alert :type="$value['type']->value" :message="$value['message']" />
                                @endsession
                                <div class="row gy-3">
                                    <div class="col-xl-12">
                                        <div class="position-relative">
                                            <input type="text" name="username" id="signinUsername"
                                                class="form-control form-control-lg" placeholder="username" autofocus
                                                required />
                                        </div>
                                        @error('username')
                                            <x-forms.error>{{ $message }}</x-forms.error>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12 mb-2">
                                        <div class="position-relative">
                                            <input type="password" name="password" id="signinPassword"
                                                class="form-control form-control-lg" placeholder="Password" required />
                                            <a href="javascript:void(0);" class="show-password-button text-muted"
                                                id="signinShowPassword"><i class="ri-eye-off-line align-middle"></i></a>
                                        </div>
                                        @error('password')
                                            <x-forms.error>{{ $message }}</x-forms.error>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                            <div class="d-grid mt-4">
                                <button type="submit" form="signinForm" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-2 text-center d-flex flex-column justify-content-center">
                    <p style="height:8px" style="text-center">
                        <strong>Sistem Informasi Enterprise Risk Management<br>
                            Injourney Airport (SIERINA)</strong><br>
                        Powered by <strong>MR</strong><br>
                        {{ date('Y') }} © PT ANGKASA PURA INDONESIA<br>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const showPasswordButton = document.getElementById('signinShowPassword');
        const passwordInput = document.getElementById('signinPassword');

        showPasswordButton.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            showPasswordButton.innerHTML = type === 'password' ?
                `<i class="ri-eye-off-line align-middle">` : `<i class="ri-eye-line align-middle">`;
        });

        document.getElementById('timezone').value = Intl.DateTimeFormat().resolvedOptions().timeZone;
    })
</script>

</html>
