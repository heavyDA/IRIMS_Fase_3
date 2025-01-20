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
