@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/master/bumn_scale/index.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Skala</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Master</li>
                    <li class="breadcrumb-item active" aria-current="page">Skala</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="btn-list">
        @if (role()->checkPermission('master.bumn_scales.create'))
            <a href="{{ route('master.bumn_scales.create') }}"
                class="btn btn-primary-light btn-wave me-2 waves-effect waves-light">
                <i class="ti ti-plus align-middle"></i> Tambah Skala
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
            <table id="bumn-scale-table" class="table table-bordered table-hover display nowrap" style="width: 100%;">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Kategori Dampak</th>
                        <th class="text-center">Skala</th>
                        <th class="text-center">Kriteria</th>
                        <th class="text-center">Deskripsi</th>
                        <th class="text-center">Min</th>
                        <th class="text-center">Maks</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </x-slot>
    </x-card>
@endsection
