@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/risk/assessment/index.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">{{ $title }} </h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="btn-list">
        @if (auth()->user()->can('risk.worksheet.store') && auth()->user()->can('risk.worksheet.create'))
            <a href="{{ route('risk.worksheet.index') }}"
                class="btn btn-primary-light btn-wave me-2 waves-effect waves-light">
                <i class="ti ti-plus align-middle"></i> Tambah Kertas Kerja
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
            <table id="worksheet-table" class="table table-bordered table-stripped display nowrap" style="width: 100%;">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" rowspan="3">No.</th>
                        <th class="text-center" rowspan="3">Status</th>
                        <th class="text-center" rowspan="3">Organisasi</th>
                        <th class="text-center" rowspan="3">Pilihan Sasaran</th>
                        <th class="text-center" rowspan="3">Peristiwa Risiko</th>
                        <th class="text-center" rowspan="3">Penyebab Risiko</th>
                        <th class="text-center" rowspan="3">Dampak</th>
                        <th class="text-center" colspan="2">Risiko Inheren</th>
                        <th class="text-center" colspan="8">Risiko Residual</th>
                    </tr>
                    <tr>
                        <th class="text-center" rowspan="2">Level</th>
                        <th class="text-center" rowspan="2">Skala Risiko</th>
                        <th class="text-center" colspan="4">Level</th>
                        <th class="text-center" colspan="4">Skala Risiko</th>
                    </tr>
                    <tr>
                        <th class="text-center">Q1</th>
                        <th class="text-center">Q2</th>
                        <th class="text-center">Q3</th>
                        <th class="text-center">Q4</th>
                        <th class="text-center">Q1</th>
                        <th class="text-center">Q2</th>
                        <th class="text-center">Q3</th>
                        <th class="text-center">Q4</th>
                    </tr>
                </thead>
            </table>
        </x-slot>
    </x-card>
@endsection

@push('element')
    <div class="offcanvas offcanvas-end" tabindex="-1" id="worksheet-table-offcanvas"
        aria-labelledby="worksheet-table-offcanvas-label">
        <div class="offcanvas-header border-bottom border-block-end-dashed">
            <h5 class="offcanvas-title" id="worksheet-table-offcanvas-label">Filter</h5>
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
                            <option value="draft">Draft</option>
                            <option value="on progress">On Progress</option>
                            <option value="approved">Approved</option>
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
