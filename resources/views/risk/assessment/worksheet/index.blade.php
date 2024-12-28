@extends('layouts.app')

@push('top-script')
    @vite(['resources/js/pages/risk/assessment/worksheet/index.js'])
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

@section('header-content')
    <div>
        <h1 class="page-title fw-medium fs-18 mb-2">{{ $title }} </h1>
        <div class="">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
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
            <div class="accordion accordion-secondary">
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
                            @include('risk.assessment.worksheet.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="accordion accordion-primary">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#riskAssessmentForm" aria-expanded="true" aria-controls="riskAssessmentForm">
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
                                    @include('risk.assessment.worksheet.form')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
