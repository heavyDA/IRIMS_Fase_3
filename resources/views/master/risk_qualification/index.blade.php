@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/master/risk_qualification/index.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Kualifikasi Risiko</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item active" aria-current="page">Kualifikasi Risiko</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="btn-list">
        @canany('master.risk_qualifications.store', 'master.risk_qualifications.create')
            <a href="{{ route('master.risk_qualifications.create') }}"
                class="btn btn-primary-light btn-wave me-2 waves-effect waves-light">
                <i class="ti ti-plus align-middle"></i> Tambah Kualifikasi Risiko
            </a>
        @endcanany
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
            <table id="risk-qualification-table" class="table table-bordered table-hover display nowrap"
                style="width: 100%;">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Diperbarui Oleh</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
            </table>
        </x-slot>
    </x-card>
@endsection
