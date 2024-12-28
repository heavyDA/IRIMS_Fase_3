@extends('layouts.app')

@section('header-content')
<div>
    <h1 class="page-title fw-medium fs-18 mb-2">Profile</h1>
    <div class="">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
    </div>
</div>
<div class="btn-list">
    <button class="btn btn-primary-light btn-wave me-2">
        <i class="bx bx-crown align-middle"></i> Plan Upgrade
    </button>
    <button class="btn btn-secondary-light btn-wave me-0">
        <i class="ri-upload-cloud-line align-middle"></i> Export Report
    </button>
</div>
@endsection

@section('main-content')
    CONTENT
@endsection