@extends('layouts.app')

@push('bottom-script')
    @vite(['resources/js/pages/report/risk_monitoring/index.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">{{ $title }} </h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Risk Report</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
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
                            @for ($i = 5; $i >= 3; $i--)
                                <option {{ date('Y') == 2020 + $i ? 'selected' : '' }} value="{{ 2020 + $i }}">
                                    {{ 2020 + $i }}</option>
                            @endfor
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
                            <option value="on monitoring">On Monitoring</option>
                            <option value="on progress monitoring">on Progress Monitoring</option>
                            <option value="approved">Approved</option>
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
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Status</th>
                        <th rowspan="2">Organisasi</th>
                        <th rowspan="2">Semuaan Sasaran</th>
                        <th rowspan="2">Peristiwa Risiko</th>
                        <th rowspan="2">Rencana Pengendalian</th>
                        <th rowspan="2">Realisasi Rencana Perlakuan</th>
                        <th colspan="2">Risiko Inheren</th>
                        <th colspan="3">Risiko Residual</th>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <th>Skala Risiko</th>
                        <th>Kuartal</th>
                        <th>Level</th>
                        <th>Skala Risiko</th>
                    </tr>
                </thead>
            </table>
        </x-slot>
    </x-card>
@endsection
