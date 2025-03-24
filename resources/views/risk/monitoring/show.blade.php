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
    @vite(['resources/js/pages/risk/monitoring/detail.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">{{ $title }} </h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Risk Process</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('risk.monitoring.index') }}">Risk
                            Monitoring</a></li>
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
                            <i class="fs-3 ti ti-clipboard-text"></i>&nbsp;&nbsp;History Log
                        </button>
                    </h2>
                    <div id="listRiskMonitoring" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#riskMonitoringAccordion">
                        <div class="accordion-body">
                            <div class="d-flex justify-content-center px-4">
                                <ul class="timeline">
                                    @foreach ($monitoring->histories as $history)
                                        <li class="{{ $loop->odd ? '' : 'timeline-inverted' }}">
                                            <div class="timeline-badge info"><i class="ti ti-history"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading d-flex flex-column gap-1">
                                                    <div class="d-flex gap-2">
                                                        <h6 class="text-secondary">
                                                            {{ $history?->user?->employee_name ?? 'Nama Pekerja' }}</h6>
                                                        |
                                                        <span class="text-capitalize">{{ $history->created_role }}</span>
                                                    </div>
                                                    <div class="mt-0 pt-0">
                                                        {{ $history->created_at->setTimezone(session()->get('current_timezone'))->format('d F Y H:i') }}
                                                    </div>
                                                </div>
                                                <div class="timeline-body pt-4 text-dark">
                                                    <p>
                                                        {!! $history->status_badge !!}
                                                        {!! $history->note !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
