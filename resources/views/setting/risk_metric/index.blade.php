@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/setting/risk_metric/index.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Matrik Strategi Risiko</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan</li>
                    <li class="breadcrumb-item active" aria-current="page">Matrik Strategi Risiko</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="btn-list">
        @canany('setting.risk_metrics.store', 'setting.risk_metrics.create')
            <a href="{{ route('setting.risk_metrics.create') }}"
                class="btn btn-primary-light btn-wave me-2 waves-effect waves-light">
                <i class="ti ti-plus align-middle"></i> Tambah Matrik Strategi Risiko
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
                            <input type="text" name="search" id="search-table" class="form-control"
                                placeholder="Pencarian">
                        </div>
                        <button style="min-width: 32px;" class="btn btn-light" type="reset" id="reset-table"
                            data-bs-toggle="tooltip" title="Reset">
                            <span><i class="me-1 ti ti-refresh"></i></span>
                        </button>
                        <button style="min-width: 32px;" class="btn btn-primary" type="button" id="filter-button"
                            data-bs-toggle="tooltip" title="Filter" aria-controls="table-offcanvas">
                            <span><i class="me-1 ti ti-filter"></i></span>
                        </button>
                    </div>
                </div>
            </div>
            <table id="risk-metric-table" class="table table-bordered table-hover display nowrap" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="table-dark-custom text-center">Unit</th>
                        <th class="table-dark-custom text-center">Kapasitas</th>
                        <th class="table-dark-custom text-center">Appetite</th>
                        <th class="table-dark-custom text-center">Toleransi</th>
                        <th class="table-dark-custom text-center">Limit</th>
                        <th class="table-dark-custom text-center">Diperbarui Oleh</th>
                        <th class="table-dark-custom text-center">Status</th>
                        <th class="table-dark-custom text-center">Tanggal</th>
                    </tr>
                </thead>
            </table>
        </x-slot>
    </x-card>
@endsection

@push('element')
    <div class="offcanvas offcanvas-end" tabindex="-1" id="table-offcanvas" aria-labelledby="table-offcanvas-label">
        <div class="offcanvas-header border-bottom border-block-end-dashed">
            <h5 class="offcanvas-title" id="table-offcanvas-label">Filter</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body py-2 px-4">
            <form id="table-filter" class="mb-4">
                <div class="row gap-2">
                    <div class="col-12 d-flex flex-column">
                        <label for="length" class="form-label">Jumlah</label>
                        <select name="length" class="form-select">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="-1">Semua</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex flex-column">
                        <label for="unit" class="form-label">Unit</label>
                        <select name="unit" class="form-select">
                            @if ($units->count() > 1)
                                <option value="">Semua</option>
                            @endif
                            @foreach ($units as $unit)
                                <option {{ request('unit') == $unit->sub_unit_code ? 'selected' : null }}
                                    value="{{ $unit->sub_unit_code }}">
                                    {{ "[{$unit->branch_code}] $unit->sub_unit_name" }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 d-flex flex-column">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="with_history"
                                name="with_history">
                            <label class="form-check-label" for="with_history">
                                Tampilkan Riwayat
                            </label>
                        </div>
                    </div>
                    <div class="col-12 d-grid">
                        <button form="table-filter" type="submit" class="btn btn-block btn-primary-light"><i
                                class="ti ti-filter"></i> Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush
