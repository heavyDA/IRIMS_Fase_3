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
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="btn-list">
        @if (auth()->user()->can('risk.worksheet.index') && auth()->user()->can('risk.worksheet.store'))
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
            <form id="worksheet-table-filter" class="mb-4">
                <div class="row">
                    <div class="col-12 col-md-3 col-lg-2">
                        <label for="length" class="form-label">Jumlah</label>
                        <select name="length" class="form-select">
                            <option value="-1">Semua</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 col-lg-2">
                        <label for="year" class="form-label">Tahun</label>
                        <select name="year" class="form-select">
                            @foreach ($years as $year)
                                <option {{ $year == date('Y') ? 'selected' : '' }} value={{ $year }}>
                                    {{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-4">
                        <label for="unit" class="form-label">Unit Kerja</label>
                        <select name="unit" class="form-select">
                            <option value="">Semua</option>
                            @foreach ($units as $item)
                                <option value="{{ $item->sub_unit_code }}">
                                    [{{ $item->personnel_area_code }}] {{ $item->sub_unit_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="document_status" class="form-label">Status Dokumen</label>
                        <select name="document_status" class="form-select">
                            <option value="">Semua</option>
                            <option value="draft">Draft</option>
                            <option value="on progress">On Progress</option>
                            <option value="approved">Profil Risiko</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <button style="width: 120px;" id="worksheet-reset" form="worksheet-table-filter" type="reset"
                            class="btn btn-block btn-light">Reset</button>
                        <button style="width: 120px;" id="worksheet-export"
                            data-url="{{ route('risk.report.risk_profile.export') }}"
                            class="btn btn-block btn-success mx-2"><i class="ti ti-file-export"></i> Export Excel</button>
                    </div>
                </div>
            </form>
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
