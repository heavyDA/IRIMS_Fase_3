@extends('layouts.app')

@push('bottom-script')
    @vite(['resources/js/pages/RBAC/users/index.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Daftar Pengguna</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Manajemen Pengguna</a></li>
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
    </div>
@endsection

@section('main-content')
    <x-card>
        <x-slot name="body">
            <div class="row mb-4 justify-content-end">
                <div class="col-12 col-xl-7">
                    <div class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroup-sizing-default"><i
                                    class="ti ti-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Pencarian">
                        </div>
                        <button style="min-width: 32px;" class="btn btn-light" type="reset" data-bs-toggle="tooltip"
                            title="Reset">
                            <span><i class="me-1 ti ti-refresh"></i></span>
                        </button>
                    </div>
                </div>
            </div>
            <table id="user-table" class="table table-bordered table-stripped display nowrap" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="table-dark-custom">Nama Lengkap</th>
                        <th class="table-dark-custom">Email</th>
                        <th class="table-dark-custom">Unit</th>
                        <th class="table-dark-custom">Posisi</th>
                        <th class="table-dark-custom">Status</th>
                        <th class="table-dark-custom">Roles</th>
                        <th class="table-dark-custom">Aksi</th>
                    </tr>
                </thead>
            </table>
        </x-slot>
    </x-card>
@endsection
