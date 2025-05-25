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
                        @include('risk.worksheet.table')

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
