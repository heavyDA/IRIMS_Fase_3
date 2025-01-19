@extends('layouts.app')

@push('top-script')
    <style>
        .table {
            th {
                vertical-align: bottom;
            }

            td {
                vertical-align: top;
            }
        }
    </style>
@endpush

@push('bottom-script')
    @vite(['resources/js/pages/risk/monitoring/edit.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">{{ $title }} </h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Risk Process</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="btn-list"></div>
@endsection

@section('main-content')
    @include('risk.monitoring.table_detail')
    <div class="row mb-3">
        <div class="col">
            <div class="accordion accordion-solid-info">
                <div class="accordion-item">
                    <h2 class="accordion-header " id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#listRiskMonitoring" aria-expanded="true" aria-controls="listRiskMonitoring">
                            <i class="fs-3 ti ti-clipboard-text"></i>&nbsp;&nbsp;List Risk Monitoring
                        </button>
                    </h2>
                    <div id="listRiskMonitoring" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#riskMonitoringAccordion">
                        <div class="accordion-body">
                            @include('risk.monitoring.form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
