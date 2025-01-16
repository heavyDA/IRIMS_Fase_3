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
        @if (auth()->user()->can('risk.assessment.worksheet.index') && auth()->user()->can('risk.assessment.worksheet.store'))
            <a href="{{ route('risk.assessment.worksheet.index') }}"
                class="btn btn-primary-light btn-wave me-2 waves-effect waves-light">
                <i class="ti ti-plus align-middle"></i> Tambah Kertas Kerja
            </a>
        @endif
    </div>
@endsection

@section('main-content')
    <x-card>
        <x-slot name="body">
            <div class="w-100" style="overflow-x: auto;">
                <table class="table table-bordered table-stripped display nowrap" style="width: 100%;">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Status</th>
                            <th>Organisasi</th>
                            <th>Pilihan Sasaran</th>
                            <th>Peristiwa Risiko</th>
                            <th>Penyebab Risiko</th>
                            <th>Dampak</th>
                            <th>Level</th>
                            <th>Skala Risiko</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-slot>
    </x-card>
@endsection
