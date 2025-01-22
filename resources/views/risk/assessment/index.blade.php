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
