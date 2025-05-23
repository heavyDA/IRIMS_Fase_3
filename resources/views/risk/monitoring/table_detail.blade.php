<div class="row mb-3">
    <div class="col">
        <div class="accordion accordion-solid-primary">
            <div class="accordion-item">
                <h2 class="accordion-header " id="riskMonitoringReviewHeader">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#riskMonitoringReview" aria-expanded="true" aria-controls="riskMonitoringReview">
                        <i class="fs-3 ti ti-clipboard-text"></i>&nbsp;&nbsp;Risk Monitoring Input Review
                    </button>
                </h2>
                <div id="riskMonitoringReview" class="accordion-collapse collapse show"
                    aria-labelledby="riskMonitoringReviewHeader" data-bs-parent="#riskMonitoringAccordion">
                    <div class="accordion-body">
                        <div class="d-flex flex-column" style="min-height: 300px">
                            <ul class="nav nav-tabs mb-3 d-sm-flex d-block" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link py-1 active" role="tab" data-bs-toggle="tab"
                                        href="#tableResidual" aria-selected="true" tabindex="-1">
                                        Realisasi Risiko Residual
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link py-1" role="tab" data-bs-toggle="tab"
                                        href="#tableActualization" aria-selected="false" tabindex="-1">Risk
                                        Realisasi Pelaksanaan Perlakuan Risiko dan Biaya</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane border-0 p-2 show active" id="tableResidual" role="tabpanel">
                                    @include('risk.monitoring.table_detail._residual')
                                </div>
                                <div class="tab-pane border-0 p-2" id="tableActualization" role="tabpanel">
                                    @include('risk.monitoring.table_detail._actualization')
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="d-flex gap-2">
                                @if (str_contains(request()->route()->getName(), 'create') || str_contains(request()->route()->getName(), 'show'))
                                    <a href="{{ route('risk.monitoring.show', $worksheet->getEncryptedId()) }}"
                                        style="min-width: 128px;" class="btn btn-light">
                                        <span><i class="ti ti-arrow-back"></i></span>&nbsp;Kembali
                                    </a>
                                @elseif(str_contains(request()->route()->getName(), 'edit'))
                                    <a href="{{ route('risk.monitoring.show_monitoring', $monitoring->getEncryptedId()) }}"
                                        style="min-width: 128px;" class="btn btn-light">
                                        <span><i class="ti ti-arrow-back"></i></span>&nbsp;Kembali
                                    </a>
                                @else
                                    <a href="{{ route('risk.monitoring.index') }}" style="min-width: 128px;"
                                        class="btn btn-light">
                                        <span><i class="ti ti-arrow-back"></i></span>&nbsp;Kembali
                                    </a>
                                @endif

                                @if (!str_contains(request()->route()->getName(), 'edit'))
                                    @if (
                                        ($monitoring->status == 'draft' && (role()->isRiskAdmin() || role()->isRiskOwner() || role()->isRiskAnalis())) ||
                                            ($monitoring->status == 'on review' && role()->isRiskOwner()) ||
                                            (role()->isAdministrator() || role()->isRiskAnalis()))
                                        <a href="{{ route('risk.monitoring.edit_monitoring', $monitoring->getEncryptedId()) }}"
                                            style="min-width: 128px;" class="btn btn-success">
                                            <span><i class="ti ti-edit"></i></span>&nbsp;Update
                                        </a>
                                    @endif
                                @endif

                                @if (
                                    (in_array(App\Enums\DocumentStatus::tryFrom($monitoring->status), [
                                        App\Enums\DocumentStatus::DRAFT,
                                        App\Enums\DocumentStatus::ON_REVIEW,
                                    ]) &&
                                        (role()->isRiskAdmin() || role()->isRiskOwner())) ||
                                        role()->isRiskAnalis() ||
                                        role()->isAdministrator())
                                    <form method="POST"
                                        action="{{ route('risk.monitoring.destroy_monitoring', $monitoring->getEncryptedId()) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Hapus data ini?')">
                                            <span><i class="ti ti-trash"></i></span>&nbsp;Hapus
                                        </button>
                                    </form>
                                @endif

                                @isset($monitoring)
                                    @include('risk.monitoring.history._history', [
                                        'monitoring' => $monitoring,
                                    ])
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
