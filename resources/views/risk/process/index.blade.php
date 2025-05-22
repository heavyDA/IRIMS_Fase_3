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
                        <button style="min-width: 32px;" class="btn btn-light" type="reset" form="worksheet-table-filter"
                            data-bs-toggle="tooltip" title="Reset">
                            <span><i class="me-1 ti ti-refresh"></i></span>
                        </button>
                        <button style="min-width: 32px;" class="btn btn-primary" type="button" id="worksheet-filter-button"
                            data-bs-toggle="tooltip" title="Filter" aria-controls="worksheet-table-offcanvas">
                            <span><i class="me-1 ti ti-filter"></i></span>
                        </button>
                    </div>
                </div>

            </div>
            <table id="worksheet-table" class="table table-bordered table-stripped display"
                style="width: 100%;table-layout: fixed;border-collapse: collapse;">
                <thead class="table-dark">
                    <tr>
                        <th class="table-dark-custom" style="text-align: center !important;" rowspan="2">No.</th>
                        <th class="table-dark-custom" style="text-align: center !important;" rowspan="2">Status</th>
                        <th class="table-dark-custom" style="text-align: center !important;" rowspan="2">Unit</th>
                        <th class="table-dark-custom" style="text-align: center !important;" rowspan="2">Pilihan Sasaran
                        </th>
                        <th class="table-dark-custom" style="text-align: center !important;" rowspan="2">Peristiwa Risiko
                        </th>
                        <th class="table-dark-custom" style="text-align: center !important;" rowspan="2">Rencana
                            Pengendalian</th>
                        <th class="table-dark-custom" style="text-align: center !important;" rowspan="2">Realisasi
                            Rencana Perlakuan</th>
                        <th class="table-dark-custom" style="text-align: center !important;" colspan="2">Inheren</th>
                        <th class="table-dark-custom" style="text-align: center !important;" colspan="2">Target Residual
                        </th>
                    </tr>
                    <tr>
                        <th class="table-dark-custom" style="text-align: center !important;">Level</th>
                        <th class="table-dark-custom" style="text-align: center !important;">Skala Risiko</th>
                        <th class="table-dark-custom" style="text-align: center !important;">Level</th>
                        <th class="table-dark-custom" style="text-align: center !important;">Skala Risiko</th>
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
                        <label for="month" class="form-label">Bulan</label>
                        <select name="month" class="form-select">
                            <option value="">Semua</option>
                            @foreach ($worksheet_months as $month => $name)
                                <option value={{ $month + 1 }}>
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 d-flex flex-column">
                        <label for="location" class="form-label">Lokasi</label>
                        <select name="location" class="form-select">
                            @if ($units->count() > 1)
                                <option value="">Semua</option>
                            @endif
                            @foreach ($units as $unit)
                                <option value="{{ $unit->sub_unit_code }}">
                                    [{{ $unit->branch_code }}] {{ $unit->branch_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 d-flex flex-column">
                        <label for="unit" class="form-label">Unit Kerja</label>
                        <select name="unit" class="form-select">
                            <option value>Semua</option>
                            @foreach ($units as $unit)
                                @foreach ($unit->children as $child)
                                    <option data-custom-properties='@json(['parent' => $child->parent_id])'
                                        value="{{ $child->sub_unit_code }}">
                                        [{{ $child->sub_unit_code_doc }}] {{ $child->sub_unit_name }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 d-flex flex-column">
                        <label for="risk_qualification" class="form-label">Kualifikasi Risiko</label>
                        <select name="risk_qualification" class="form-select">
                            <option value="">Semua</option>
                            @foreach ($risk_qualifications as $risk_qualification)
                                <option value="{{ $risk_qualification->id }}">
                                    {{ $risk_qualification->name }}
                                </option>
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
