@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/dashboard/index.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">Dashboard </h1>
    </div>
    <div>
        <form id="dashboard-filter" action="" method="get" class="d-flex" style="min-width:256px;">
            <div class="d-flex gap-2 align-items-center flex-grow-1 w-100">
                <label for="year">Periode</label>
                <select name="year" class="form-select flex-grow-1 w-100">
                    @foreach ($worksheet_years as $year)
                        <option {{ $year->year == date('Y') ? 'selected' : '' }} value={{ $year->year }}>
                            {{ $year->year }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
@endsection

@section('main-content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="row gy-2 justify-content-between">
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="h-100 card custom-card overflow-hidden card-bg-primary">
                        <div class="card-body h-100">
                            <div class="d-flex flex-column justify-content-between flex-wrap gap-2 h-100 px-3">
                                <label class="fs-20 fw-lighter d-block mb-1">Draft</label>
                                <h1 class="text-end lh-1">{{ $count_worksheet?->draft ?? 0 }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="h-100 card custom-card overflow-hidden card-bg-secondary">
                        <div class="card-body h-100">
                            <div class="d-flex flex-column justify-content-between flex-wrap gap-2 h-100 px-3">
                                <label class="fs-20 fw-lighter d-block mb-1">On Progress</label>
                                <h1 class="text-end lh-1">{{ $count_worksheet?->progress ?? 0 }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="h-100 card custom-card overflow-hidden card-bg-success">
                        <div class="card-body h-100">
                            <div class="d-flex flex-column justify-content-between flex-wrap gap-2 h-100 px-3">
                                <label class="fs-20 fw-lighter d-block mb-1">Profil Risiko</label>
                                <h1 class="text-end lh-1">{{ $count_worksheet?->approved ?? 0 }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="h-100 card custom-card overflow-hidden card-bg-info">
                        <div class="card-body h-100">
                            <div class="d-flex flex-column justify-content-between flex-wrap gap-2 h-100 px-3">
                                <label class="fs-20 fw-lighter d-block mb-1">Rencana Mitigasi</label>
                                <h1 class="text-end lh-1">{{ $count_mitigation }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="h-100 card custom-card overflow-hidden card-bg-light">
                        <div class="card-body h-100">
                            <div class="d-flex flex-column justify-content-between flex-wrap gap-2 h-100 px-3">
                                <label class="fs-20 fw-lighter d-block mb-1">Progress Mitigasi</label>
                                <h1 class="text-end lh-1">
                                    {{ $count_mitigation_monitoring?->progress ?? 0 }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="h-100 card custom-card overflow-hidden card-bg-success">
                        <div class="card-body h-100">
                            <div class="d-flex flex-column justify-content-between flex-wrap gap-2 h-100 px-3">
                                <label class="fs-20 fw-lighter d-block mb-1">Penyelesaian Mitigasi</label>
                                <h1 class="text-end lh-1">
                                    {{ $count_mitigation_monitoring?->finished ?? 0 }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard._risk_map')
    @includeWhen(session()->get('current_role')?->name != 'risk admin', 'dashboard._monitoring')
    @if (session()->get('current_role')?->name == 'risk otorisator' ||
            session()->get('current_role')?->name == 'risk analis' ||
            session()->get('current_role')?->name == 'risk reviewer')
        @include('dashboard._top_risk')
    @endif
@endsection

@push('element')
    <div class="modal fade" id="risk-map-inherent-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 100% !important;">
            <div class="modal-content mx-auto" style="width: 80vw !important">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Risk Map Inheren</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="risk-map-inherent-table-wrapper">
                        <table id="risk-map-inherent-table" class="table table-bordered table-stripped display nowrap"
                            style="width: 100%;">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="risk-map-residual-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 100% !important;">
            <div class="modal-content mx-auto" style="width: 80vw !important">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Risk Map Residual</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="risk-map-residual-table-wrapper">
                        <table id="risk-map-residual-table" class="table table-bordered table-stripped display nowrap"
                            style="width: 100%;">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
