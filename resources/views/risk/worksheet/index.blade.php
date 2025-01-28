@extends('layouts.app')

@push('top-script')
    <style>
        .popover {
            width: 418px !important;
            max-width: 418px !important;
        }

        .popover-body {
            overflow-y: auto;
            max-height: 512px !important;
        }

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
    @vite(['resources/js/pages/risk/worksheet/table_view.js'])
    @if (str_contains(request()->route()->getName(), 'edit'))
        @vite(['resources/js/pages/risk/worksheet/edit.js'])
    @else
        @vite(['resources/js/pages/risk/worksheet/index.js'])
    @endif
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">{{ $title }} </h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Risk Assessment</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="btn-list"></div>
@endsection

@section('main-content')
    <div class="row mb-3">
        <div class="col">
            <div class="accordion accordion-solid-primary">
                <div class="accordion-item">
                    <h2 class="accordion-header " id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#riskAssessmentReview" aria-expanded="true"
                            aria-controls="riskAssessmentReview">
                            <i class="fs-3 ti ti-clipboard-text"></i>&nbsp;&nbsp;Risk Assessment
                        </button>
                    </h2>
                    <div id="riskAssessmentReview" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @include('risk.worksheet.table')
                            <div class="mt-4">
                                <div class="d-flex gap-2">
                                    @if (str_contains(request()->route()->getName(), 'edit'))
                                        <a href="{{ route('risk.worksheet.show', $worksheet->getEncryptedId()) }}"
                                            style="min-width: 128px;" class="btn btn-light">
                                            <span><i class="ti ti-arrow-back"></i></span>&nbsp;Kembali
                                        </a>
                                    @else
                                        <a href="{{ route('risk.assessment.index') }}" style="min-width: 128px;"
                                            class="btn btn-light">
                                            <span><i class="ti ti-arrow-back"></i></span>&nbsp;Kembali
                                        </a>
                                    @endif
                                    @isset($worksheet)
                                        @if (
                                            ($worksheet->status == 'draft' &&
                                                in_array(session()->get('current_role')?->name, ['risk admin', 'risk owner', 'risk analis'])) ||
                                                ($worksheet->status == 'on review' &&
                                                    in_array(session()->get('current_role')?->name, ['risk owner', 'risk analis'])))
                                            <form action="{{ route('risk.worksheet.destroy', $worksheet->getEncryptedId()) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button style="min-width: 128px;" type="submit" class="btn btn-danger">
                                                    <span><i class="ti ti-x"></i></span>&nbsp;Hapus
                                                </button>
                                            </form>
                                        @endif
                                        @if (!str_contains(request()->route()->getName(), 'edit'))
                                            @if (
                                                (session()->get('current_role')?->name == 'risk admin' && $worksheet->last_history->status == 'draft') ||
                                                    (session()->get('current_role')?->name == 'risk owner' &&
                                                        in_array($worksheet->last_history->status, ['draft', 'on review'])) ||
                                                    session()->get('current_role')?->name == 'risk analis')
                                                <a href="{{ route('risk.worksheet.edit', $worksheet->getEncryptedId()) }}"
                                                    style="min-width: 128px;" class="btn btn-success">
                                                    <span><i class="ti ti-edit"></i></span>&nbsp;Update
                                                </a>
                                            @endif
                                            @if (session()->get('current_role')?->name == 'risk admin' && $worksheet->last_history->status == 'draft')
                                                @include('risk.worksheet.partials._risk_admin')
                                            @elseif (session()->get('current_role')?->name == 'risk owner' && $worksheet->last_history->status == 'on review')
                                                @include('risk.worksheet.partials._risk_owner')
                                            @elseif (session()->get('current_role')?->name == 'risk otorisator' && $worksheet->last_history->status == 'on confirmation')
                                                @include('risk.worksheet.partials._risk_otorisator')
                                            @endif
                                        @endif
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (isset($worksheet) && str_contains(request()->route()->getName(), 'show'))
        <div class="row">
            <div class="col">
                <div class="accordion accordion-solid-info">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#riskAssessmentForm" aria-expanded="true"
                                aria-controls="riskAssessmentForm">
                                <i class="fs-3 ti ti-pencil-plus"></i>&nbsp;&nbsp;History Logs
                            </button>
                        </h2>
                        <div id="riskAssessmentForm" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="d-flex justify-content-center px-4">
                                    <ul class="timeline">
                                        @foreach ($worksheet->histories as $history)
                                            <li class="{{ $loop->odd ? '' : 'timeline-inverted' }}">
                                                <div class="timeline-badge info"><i class="ti ti-history"></i></div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading d-flex flex-column gap-1">
                                                        <div class="d-flex gap-2">
                                                            <h6 class="text-secondary">
                                                                {{ $history?->user?->employee_name ?? 'Nama Pekerja' }}</h6>
                                                            |
                                                            <span
                                                                class="text-capitalize">{{ $history->created_role }}</span>
                                                        </div>
                                                        <div class="mt-0 pt-0">
                                                            {{ $history->created_at->format('d F Y H:i') }}
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
    @endif

    @if (str_contains(request()->route()->getName(), 'edit') || str_contains(request()->route()->getName(), 'index'))
        <div class="row">
            <div class="col">
                <div class="accordion accordion-primary">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#riskAssessmentForm" aria-expanded="true"
                                aria-controls="riskAssessmentForm">
                                <i class="fs-3 ti ti-pencil-plus"></i>&nbsp;&nbsp;Risk Assessment Form
                            </button>
                        </h2>
                        <div id="riskAssessmentForm" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="tab-content">
                                    <div class="tab-pane border-0" role="tabpanel" id="worksheet-summary">
                                        <table class="table table-bordered display nowrap" style="width: 100%;"></table>
                                    </div>
                                    <div class="tab-pane active show border-0" role="tabpanel" id="worksheet-form">
                                        @include('risk.worksheet.form')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
