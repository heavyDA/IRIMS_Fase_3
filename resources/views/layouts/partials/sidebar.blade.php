<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="/" class="header-logo">
            <img src="{{ asset('assets/images/brand/logo.webp') }}" alt="logo" class="desktop-logo"
                style="height: 96px;" />
            <img src="{{ asset('assets/images/brand/favicon.ico') }}" alt="logo" class="toggle-dark">
            <img src="{{ asset('assets/images/brand/logo.webp') }}" alt="logo" class="desktop-dark"
                style="height: 96px;" />
            <img src="{{ asset('assets/images/brand/favicon.ico') }}" alt="logo" class="toggle-logo">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">
        <div class="d-flex justify-content-center">
            <select id="role-select" name="role" style="width: 80%;" class="form-select"
                aria-label="Default select example">
                @foreach (session()->get('current_roles') ?? [] as $role)
                    <option {{ session()->get('current_role')?->id == $role->id ? 'selected' : '' }}
                        value="{{ $role->id }}">{{ ucwords($role->name) }}</option>
                @endforeach
            </select>
        </div>
        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            {!! $menus !!}
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->
