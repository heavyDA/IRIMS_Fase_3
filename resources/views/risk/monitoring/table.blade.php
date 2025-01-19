<div class="row mb-3">
    <div class="col">
        <div class="accordion accordion-solid-primary">
            <div class="accordion-item">
                <h2 class="accordion-header " id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#riskAssessmentReview" aria-expanded="true" aria-controls="riskAssessmentReview">
                        <i class="fs-3 ti ti-clipboard-text"></i>&nbsp;&nbsp;Risk Assessment
                    </button>
                </h2>
                <div id="riskAssessmentReview" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#riskAssessmentAccordion">
                    <div class="accordion-body">
                        <div class="d-flex flex-column" style="min-height: 300px">
                            <ul class="nav nav-tabs mb-3 d-sm-flex d-block" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link py-1 active" role="tab" data-bs-toggle="tab"
                                        href="#tableContext" aria-selected="true" tabindex="-1">
                                        Penetapan Lingkup, Konteks, & Kriteria
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link py-1" role="tab" data-bs-toggle="tab"
                                        href="#tableIdentification" aria-selected="false" tabindex="-1">Risk
                                        Assessment</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link py-1" role="tab" data-bs-toggle="tab" href="#tableTreatment"
                                        aria-selected="false">Risk
                                        Treatment</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane border-0 p-2 show active" id="tableContext" role="tabpanel">
                                    <div class="col py-2" style="overflow-x: scroll;">
                                        @include('risk.monitoring.table._context')
                                    </div>
                                </div>
                                <div class="tab-pane border-0 p-2" id="tableIdentification" role="tabpanel">
                                    <div class="col py-2" style="overflow-x: scroll;">
                                        @include('risk.monitoring.table._identification')
                                    </div>
                                </div>
                                <div class="tab-pane border-0 p-2" id="tableTreatment" role="tabpanel">
                                    <div class="col py-2" style="overflow-x: scroll;">
                                        @include('risk.monitoring.table._treatment')
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="d-flex gap-2">
                                @if (str_contains(request()->route()->getName(), 'edit'))
                                    <a href="{{ route('risk.monitoring.show', $worksheet->getEncryptedId()) }}"
                                        style="min-width: 128px;" class="btn btn-light">
                                        <span><i class="ti ti-arrow-back"></i></span>&nbsp;Kembali
                                    </a>
                                @else
                                    <a href="{{ route('risk.monitoring.index') }}" style="min-width: 128px;"
                                        class="btn btn-light">
                                        <span><i class="ti ti-arrow-back"></i></span>&nbsp;Kembali
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
