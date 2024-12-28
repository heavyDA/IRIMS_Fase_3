@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/RBAC/users/index.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">{{ $title }} </h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Pengguna</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="btn-list">
        @can('rbac.user.create')
            <a href="{{ route('rbac.user.create') }}" class="btn btn-primary-light btn-wave me-2 waves-effect waves-light">
                <i class="ti ti-plus align-middle"></i> Buat Baru
            </a>
        @endcan
        <button class="btn btn-secondary-light btn-wave me-0 waves-effect waves-light">
            <i class="ti ti-file-excel align-middle"></i> Export Excel
        </button>
    </div>
@endsection

@section('main-content')
    <x-card>
        <x-slot name="body">
            <table class="table table-striped display responsive nowrap" style="width: 100%;"></table>
        </x-slot>
    </x-card>
@endsection
