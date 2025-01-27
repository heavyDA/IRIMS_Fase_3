@extends('layouts.app')

@push('bottom-script')
    @vite(['resources/js/pages/risk/monitoring/index.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">{{ $title }} </h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Risk Process</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
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
                            <input type="text" name="search" class="form-control max-w-50" placeholder="Pencarian">
                        </div>
                        <button style="min-width: 128px;" class="btn btn-light" type="reset"
                            form="worksheet-table-filter">
                            <span><i class="me-1 ti ti-refresh"></i>Reset</span>
                        </button>
                        <button style="min-width: 128px;" class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#worksheet-table-offcanvas" aria-controls="worksheet-table-offcanvas">
                            <span><i class="me-1 ti ti-filter"></i>Filter</span>
                        </button>
                    </div>
                </div>

            </div>
            <table id="worksheet-table" class="table table-bordered table-stripped display nowrap" style="width: 100%;">
                <thead class="table-dark">
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Status</th>
                        <th rowspan="2">Organisasi</th>
                        <th rowspan="2">Pilihan Sasaran</th>
                        <th rowspan="2">Peristiwa Risiko</th>
                        <th rowspan="2">Rencana Pengendalian</th>
                        <th rowspan="2">Realisasi Rencana Perlakuan</th>
                        <th colspan="2">Risiko Inheren</th>
                        <th colspan="2">Risiko Residual</th>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <th>Skala Risiko</th>
                        <th>Level</th>
                        <th>Skala Risiko</th>
                    </tr>
                </thead>
            </table>
        </x-slot>
    </x-card>
@endsection


@push('element')
    <div class="offcanvas offcanvas-end" tabindex="-1" id="worksheet-table-offcanvas"
        aria-labelledby="offcanvasRightLabel1">
        <div class="offcanvas-header border-bottom border-block-end-dashed">
            <h5 class="offcanvas-title" id="offcanvasRightLabel1">Filter</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body py-2 px-4">
            <form id="worksheet-table-filter" class="mb-4">
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
                        <label for="year" class="form-label">Tahun</label>
                        <select name="year" class="form-select">
                            @foreach ($worksheet_years as $year)
                                <option {{ $year->year == date('Y') ? 'selected' : '' }} value={{ $year->year }}>
                                    {{ $year->year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 d-flex flex-column">
                        <label for="unit" class="form-label">Unit Kerja</label>
                        <select name="unit" class="form-select">
                            @if ($units->count() > 1)
                                <option value="">Semua</option>
                            @endif
                            @foreach ($units as $unit)
                                <option value="{{ $unit->sub_unit_code }}">
                                    [{{ $unit->personnel_area_code }}] {{ $unit->sub_unit_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 d-flex flex-column">
                        <label for="document_status" class="form-label">Status Dokumen</label>
                        <select name="document_status" class="form-select">
                            <option value="">Semua</option>
                            <option value="on monitoring">On Monitoring</option>
                            <option value="on progress monitoring">On Progress Monitoring</option>
                        </select>
                    </div>
                    <div class="col-12 d-grid">
                        <button form="worksheet-table-filter" type="submit" class="btn btn-block btn-primary-light"><i
                                class="ti ti-filter"></i> Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush
