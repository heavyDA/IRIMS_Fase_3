@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/risk/profile/index.js'])
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
                    <div class="col-12 col-md-3 col-lg-2 align-self-end">
                        {{-- @if (in_array(session()->get('current_role')?->name, ['risk analis', 'risk otorisator'])) --}}
                        <button type="button" class="btn btn-primary" id="worksheet-submit-button">
                            <i class="ti ti-send align-middle"></i> Submit Top Riks
                        </button>
                        {{-- @endif --}}
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
                        <th rowspan="3">
                            <input type="checkbox" id="worksheet-check-all">
                        </th>
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
