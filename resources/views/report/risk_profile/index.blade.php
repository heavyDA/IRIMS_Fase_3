@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/report/risk_profile/index.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">{{ $title }} </h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Risk Report</li>
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
                        <th rowspan="3">No.</th>
                        <th rowspan="3">Status</th>
                        <th rowspan="3">Organisasi</th>
                        <th rowspan="3">Pilihan Sasaran</th>
                        <th rowspan="3">Peristiwa Risiko</th>
                        <th rowspan="3">Penyebab Risiko</th>
                        <th rowspan="3">Dampak</th>
                        <th colspan="2">Risiko Inheren</th>
                        <th colspan="8">Risiko Residual</th>
                    </tr>
                    <tr>
                        <th rowspan="2">Level</th>
                        <th rowspan="2">Skala Risiko</th>
                        <th colspan="4">Level</th>
                        <th colspan="4">Skala Risiko</th>
                    </tr>
                    <tr>
                        <td>Q1</td>
                        <td>Q2</td>
                        <td>Q3</td>
                        <td>Q4</td>
                        <td>Q1</td>
                        <td>Q2</td>
                        <td>Q3</td>
                        <td>Q4</td>
                    </tr>
                </thead>
            </table>
        </x-slot>
    </x-card>
@endsection
