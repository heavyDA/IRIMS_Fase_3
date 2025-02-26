<!-- app-header -->
<header class="app-header sticky" id="header">

    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid">

        <!-- Start::header-content-left -->
        <div class="header-content-left">
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="index.html" class="header-logo">
                        <img src="{{ asset('assets/images/brand/favicon.ico') }}" alt="logo" class="desktop-logo">
                        <img src="{{ asset('assets/images/brand/favicon.ico') }}" alt="logo" class="toggle-logo">
                        <img src="{{ asset('assets/images/brand/favicon.ico') }}" alt="logo" class="desktop-dark">
                        <img src="{{ asset('assets/images/brand/favicon.ico') }}" alt="logo" class="toggle-dark">
                    </a>
                </div>
            </div>
            <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link -->
                <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link" data-bs-toggle="sidebar"
                    href="javascript:void(0);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon menu-btn" width="32"
                        height="32" fill="#000000" viewBox="0 0 256 256">
                        <path
                            d="M224,128a8,8,0,0,1-8,8H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,128ZM40,72H216a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16ZM216,184H40a8,8,0,0,0,0,16H216a8,8,0,0,0,0-16Z">
                        </path>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon menu-btn-close" width="32"
                        height="32" fill="#000000" viewBox="0 0 256 256">
                        <path
                            d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z">
                        </path>
                    </svg>
                </a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->


        </div>
        <!-- End::header-content-left -->

        <!-- Start::header-content-right -->
        <ul class="header-content-right">
            <!-- Start::header-element -->
            <li class="header-element header-theme-mode">
                <!-- Start::header-link|layout-setting -->
                <a href="javascript:void(0);" class="header-link layout-setting d-none">
                    <span class="light-layout">
                        <!-- Start::header-link-icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" viewBox="0 0 256 256">
                            <rect width="256" height="256" fill="none" />
                            <path d="M108.11,28.11A96.09,96.09,0,0,0,227.89,147.89,96,96,0,1,1,108.11,28.11Z"
                                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                        </svg>
                        <!-- End::header-link-icon -->
                    </span>
                    <span class="dark-layout">
                        <!-- Start::header-link-icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" viewBox="0 0 256 256">
                            <rect width="256" height="256" fill="none" />
                            <line x1="128" y1="40" x2="128" y2="32" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <circle cx="128" cy="128" r="56" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                            <line x1="64" y1="64" x2="56" y2="56" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <line x1="64" y1="192" x2="56" y2="200" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <line x1="192" y1="64" x2="200" y2="56" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <line x1="192" y1="192" x2="200" y2="200" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <line x1="40" y1="128" x2="32" y2="128" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <line x1="128" y1="216" x2="128" y2="224" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                            <line x1="216" y1="128" x2="224" y2="128" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="16" />
                        </svg>
                        <!-- End::header-link-icon -->
                    </span>
                </a>
                <!-- End::header-link|layout-setting -->
            </li>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <li class="header-element dropdown">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle pr-2" id="mainHeaderProfile"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-2 me-0">
                            <img loading="lazy"
                                src="{{ auth()->user()->image_url ?: asset('assets/images/media/user_blank.jpg') }}"
                                alt="img" style="height:  42px; width: 42px;"
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/media/user_blank.jpg') }}'"
                                class="avatar avatar-sm avatar-rounded">
                        </div>
                        <div class="d-inline-block lh-1 flex-shrink-1" style="max-width: 320px; !important">
                            <span class="fw-bold lh-1">{{ auth()->user()->employee_name }}</span><br>
                            <span class="fs-12 text-muted text-capitalize text-wrap">
                                [{{ auth()->user()->personnel_area_code }}] {{ auth()->user()->position_name }}<br>
                                {{ session()->get('current_role')?->name ?? '' }}
                            </span>
                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                    style="min-width: 296px !important;" aria-labelledby="mainHeaderProfile">
                    <li>
                        <div class="py-2 d-flex flex-column gap-1 px-3 align-items-top text-muted">
                            <div class="d-flex align-self-top p-0">
                                <i class="ti ti-id-badge me-2 fs-16"></i> {{ auth()->user()->employee_id }}
                            </div>
                            <div class="d-flex align-self-top p-0">
                                <i class="ti ti-buildings me-2 fs-16"></i> {{ auth()->user()->sub_unit_name }} <br>
                                {{ auth()->user()->personnel_area_name }}
                            </div>
                        </div>
                    </li>
                    <li><a href="javascript:void(0);" onclick="document.querySelector('#signoutForm').submit()"
                            class="dropdown-item d-flex align-items-center"><i class="ti ti-logout me-2 fs-16"></i>Log
                            out</a>
                    </li>
                </ul>
            </li>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <li class="header-element d-none">
                <!-- Start::header-link|switcher-icon -->
                <a href="javascript:void(0);" class="header-link switcher-icon" data-bs-toggle="offcanvas"
                    data-bs-target="#switcher-canvas">
                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" viewBox="0 0 256 256">
                        <rect width="256" height="256" fill="none" />
                        <circle cx="128" cy="128" r="40" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                        <path
                            d="M41.43,178.09A99.14,99.14,0,0,1,31.36,153.8l16.78-21a81.59,81.59,0,0,1,0-9.64l-16.77-21a99.43,99.43,0,0,1,10.05-24.3l26.71-3a81,81,0,0,1,6.81-6.81l3-26.7A99.14,99.14,0,0,1,102.2,31.36l21,16.78a81.59,81.59,0,0,1,9.64,0l21-16.77a99.43,99.43,0,0,1,24.3,10.05l3,26.71a81,81,0,0,1,6.81,6.81l26.7,3a99.14,99.14,0,0,1,10.07,24.29l-16.78,21a81.59,81.59,0,0,1,0,9.64l16.77,21a99.43,99.43,0,0,1-10,24.3l-26.71,3a81,81,0,0,1-6.81,6.81l-3,26.7a99.14,99.14,0,0,1-24.29,10.07l-21-16.78a81.59,81.59,0,0,1-9.64,0l-21,16.77a99.43,99.43,0,0,1-24.3-10l-3-26.71a81,81,0,0,1-6.81-6.81Z"
                            fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="16" />
                    </svg>
                </a>
                <!-- End::header-link|switcher-icon -->
            </li>
            <!-- End::header-element -->

        </ul>
        <!-- End::header-content-right -->

    </div>
    <!-- End::main-header-container -->

</header>
<!-- /app-header -->

@push('element')
    {{ html()->form('delete', route('auth.unauthenticate'))->id('signoutForm')->open() }}
    @csrf
    {{ html()->form()->close() }}
@endpush
