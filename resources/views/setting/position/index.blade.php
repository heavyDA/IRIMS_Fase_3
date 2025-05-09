@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/setting/position/index.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Posisi</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan</li>
                    <li class="breadcrumb-item active" aria-current="page">Posisi</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="btn-list">
        @if (role()->checkPermission('setting.positions.create'))
            <a href="{{ route('setting.positions.create') }}"
                class="btn btn-primary-light btn-wave me-2 waves-effect waves-light">
                <i class="ti ti-plus align-middle"></i> Tambah Posisi
            </a>
        @endif
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
            <table id="position-table" class="table table-bordered table-hover display nowrap" style="width: 100%;">
                <thead class="table-dark">
                    <tr>
                        <th class="table-dark-custom text-center">Nama Posisi</th>
                        <th class="table-dark-custom text-center">Cabang</th>
                        <th class="table-dark-custom text-center">Unit</th>
                        <th class="table-dark-custom text-center">Role</th>
                        <th class="table-dark-custom text-center">Aksi</th>
                    </tr>
                </thead>
            </table>
        </x-slot>
    </x-card>
@endsection
