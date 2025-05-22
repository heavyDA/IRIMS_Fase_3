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
@endpush

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">{{ $title }} </h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Risk Process</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Risk Assessment</a></li>
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
                                            ($worksheet->status == \App\Enums\DocumentStatus::DRAFT->value &&
                                                (role()->isRiskAdmin() || role()->isRiskOwner())) ||
                                                ($worksheet->status == 'on review' && role()->isRiskOwner()) ||
                                                role()->isAdministrator() ||
                                                role()->isRiskAnalis())
                                            <form action="{{ route('risk.worksheet.destroy', $worksheet->getEncryptedId()) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="confirm('Hapus kertas kerja ini?') ? true : event.preventDefault()"
                                                    style="min-width: 128px;" type="submit" class="btn btn-danger">
                                                    <span><i class="ti ti-x"></i></span>&nbsp;Hapus
                                                </button>
                                            </form>
                                        @endif
                                        @include('risk.worksheet.partials._history', compact('worksheet'))
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (isset($worksheet) && str_contains(request()->route()->getName(), 'worksheet.show'))
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
                                                            {{ $history->created_at->setTimezone(session()->get('current_timezone'))->translatedFormat('d F Y H:i') }}
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

    @if (str_contains(request()->route()->getName(), 'worksheet.edit') ||
            str_contains(request()->route()->getName(), 'worksheet.index'))
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
