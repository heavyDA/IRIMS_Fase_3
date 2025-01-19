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
