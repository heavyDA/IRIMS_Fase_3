@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/dashboard/index.js'])
    @if (session()->get('current_role')?->name == 'risk otorisator' ||
            session()->get('current_role')?->name == 'risk analis' ||
            session()->get('current_role')?->name == 'risk reviewer')
        @vite(['resources/js/pages/dashboard/_top_risk.js', 'resources/js/pages/dashboard/_monitoring_progress.js'])
    @endif
    <style>
        ::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 12px;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 4px;
            background-color: rgba(0, 0, 0, .5);
            -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
        }
    </style>
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
                    <option>2024</option>
                </select>
            </div>
        </form>
    </div>
@endsection

@section('main-content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <div>
                                    <span class="avatar avatar-lg bg-dark text-white">
                                        <i class="ti ti-pencil-bolt fs-24"></i>
                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <span class="d-block mb-1">Draft</span>
                                    <h3 class="fw-semibold mb-0 lh-1">{{ $count_worksheet?->draft ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <div>
                                    <span class="avatar avatar-lg bg-secondary text-white">
                                        <i class="ti ti-progress fs-24"></i>
                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <span class="d-block mb-1">On Progress</span>
                                    <h3 class="fw-semibold mb-0 lh-1">{{ $count_worksheet?->progress ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <div>
                                    <span class="avatar avatar-lg bg-success text-white">
                                        <i class="ti ti-checks fs-24"></i>
                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <span class="d-block mb-1">Profil Risiko</span>
                                    <h3 class="fw-semibold mb-0 lh-1">{{ $count_worksheet?->approved ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <div>
                                    <span class="avatar avatar-lg bg-info text-white">
                                        <i class="ti ti-file-search fs-24"></i>
                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <span class="d-block mb-1">Rencana Mitigasi</span>
                                    <h3 class="fw-semibold mb-0 lh-1">{{ $count_mitigation }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <div>
                                    <span class="avatar avatar-lg bg-warning text-white">
                                        <i class="ti ti-file-report fs-24"></i>
                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <span class="d-block mb-1">Progress Mitigasi</span>
                                    <h3 class="fw-semibold mb-0 lh-1">{{ $count_mitigation_monitoring?->progress ?? 0 }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <div>
                                    <span class="avatar avatar-lg bg-primary text-white">
                                        <i class="ti ti-file-check fs-24"></i>
                                    </span>
                                </div>
                                <div class="flex-fill">
                                    <span class="d-block mb-1">Penyelesaian Mitigasi</span>
                                    <h3 class="fw-semibold mb-0 lh-1">{{ $count_mitigation_monitoring?->finished ?? 0 }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard._risk_chart')

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
                        <table id="risk-map-inherent-table"
                            class="table table-bordered table-hover table-stripped display nowrap" style="width: 100%;">
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
                        <table id="risk-map-residual-table"
                            class="table table-bordered table-hover table-stripped display nowrap" style="width: 100%;">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
