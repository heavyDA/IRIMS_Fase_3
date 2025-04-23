@extends('layouts.app')

@push('bottom-script')
    @vite(['resources/js/pages/report/alteration/index.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Ikhtisar Perubahan Profil dan Strategi Risiko</h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Risk Report</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ikhtisar Perubahan Profil dan Strategi Risiko</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="btn-list">
        @if (session()->get('current_unit')->can('create', App\Models\Risk\WorksheetAlteration::class))
            <a href="{{ route('risk.report.alterations.create') }}"
                class="btn btn-primary-light btn-wave me-2 waves-effect waves-light">
                <i class="ti ti-plus align-middle"></i> Tambah Ikhtisar Perubahan
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
                        <button style="min-width: 32px;" class="btn btn-light" type="reset" form="alteration-table-filter"
                            data-bs-toggle="tooltip" title="Reset">
                            <span><i class="me-1 ti ti-refresh"></i></span>
                        </button>
                        <button style="min-width: 32px;" class="btn btn-primary" type="button"
                            id="alteration-filter-button" data-bs-toggle="tooltip" title="Filter"
                            aria-controls="alteration-table-offcanvas">
                            <span><i class="me-1 ti ti-filter"></i></span>
                        </button>
                        <a style="min-width: 120px;" id="alteration-export" target="_blank"
                            data-url="{{ route('risk.report.alterations.export') }}" data-bs-toggle="tooltip"
                            title="Export To Excel" class="btn btn-block btn-success"><i class="ti ti-file-export"></i>
                            Export Excel</a>
                    </div>
                </div>
            </div>
            <table id="alteration-table" class="table table-bordered table-stripped display "
                style="width: 100%;table-layour: fixed;border-collapse: collapse;">
                <thead class="table-dark">
                    <tr>
                        <th class="table-dark-custom" style="text-align: center !important;">No.</th>
                        <th class="table-dark-custom" style="text-align: center !important;">Organisasi</th>
                        <th class="table-dark-custom" style="text-align: center !important;">Pilihan Sasaran</th>
                        <th class="table-dark-custom" style="text-align: center !important;">Jenis Perubahan</th>
                        <th class="table-dark-custom" style="text-align: center !important;">Peristiwa Risiko yang Terdampak
                            atas Perubahan</th>
                        <th class="table-dark-custom" style="text-align: center !important;">Penjelasan</th>
                        <th class="table-dark-custom" style="text-align: center !important;">Dibuat Oleh</th>
                    </tr>
                </thead>
            </table>
        </x-slot>
    </x-card>
@endsection

@push('element')
    <div class="offcanvas offcanvas-end" tabindex="-1" id="alteration-table-offcanvas"
        aria-labelledby="alteration-table-offcanvas-label">
        <div class="offcanvas-header border-bottom border-block-end-dashed">
            <h5 class="offcanvas-title" id="alteration-table-offcanvas-label">Filter</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body py-2 px-4">
            <form id="alteration-table-filter" class="mb-4">
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
                                    [{{ $unit->sub_unit_code_doc }}] {{ $unit->sub_unit_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 d-grid">
                        <button form="alteration-table-filter" type="submit" class="btn btn-block btn-primary-light"><i
                                class="ti ti-filter"></i> Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush
