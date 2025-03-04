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
    @vite(['resources/js/pages/risk/monitoring/detail.js', 'resources/js/pages/risk/worksheet/table_view.js'])
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">{{ $title }} </h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Risk Process</a></li>
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
    @include('risk.monitoring.table')
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
                            <div class="mb-4">
                                @if ($worksheet->status == \App\Enums\DocumentStatus::APPROVED->value)
                                    @hasanyrole('risk admin|risk owner|risk analis')
                                        <a href="{{ route('risk.monitoring.create', $worksheet->getEncryptedId()) }}"
                                            style="min-width: 128px;" class="btn btn-primary-light">
                                            <span><i class="ti ti-plus"></i></span>&nbsp;Laporan Monitoring
                                        </a>
                                    @endhasanyrole
                                @endif
                            </div>

                            <table id="riskMonitoringTable" class="table table-bordered table-stripped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="table-dark-custom">No.</th>
                                        <th class="table-dark-custom">Status</th>
                                        <th class="table-dark-custom">Bulan</th>
                                        <th class="table-dark-custom">Organisasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($worksheet->monitorings as $monitoring)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{!! $monitoring->status_table_action !!}</td>
                                            <td>{{ $monitoring->period_date_format->translatedFormat('F') }}</td>
                                            <td>[{{ $worksheet->personnel_area_code }}] {{ $worksheet->organization_name }}
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
