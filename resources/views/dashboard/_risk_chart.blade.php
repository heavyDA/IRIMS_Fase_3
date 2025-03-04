<div class="row">
    <div class="col-12 col-xxl-6">
        <div class="card custom-card">
            <div class="card-header justify-content-between border-bottom-0">
                <div class="card-title">
                    Skala Risiko Inheren
                </div>
                <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#inherent-risk-level-collapse"
                    aria-expanded="false" aria-controls="inherent-risk-level-collapse">
                    <i class="ri-arrow-down-s-line fs-18 collapse-open"></i>
                    <i class="ri-arrow-up-s-line collapse-close fs-18"></i>
                </a>
            </div>
            <div class="collapse show border-top" id="inherent-risk-level-collapse">
                <div class="card-body">
                    <div id="inherent-risk-level-chart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xxl-6">
        <div class="card custom-card">
            <div class="card-header justify-content-between border-bottom-0">
                <div class="card-title flex-grow-1">
                    <div class="row gap-1 align-items-center">
                        <label class="col">Skala Risiko&nbsp;</label>
                        <div class="col">
                            <select class="form-select" id="residual-risk-level-select">
                                <option value="target-residual">Target Residual</option>
                                <option value="residual">Residual</option>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-select" id="residual-risk-level-quarter">
                                @for ($i = 1; $i <= 4; $i++)
                                    <option {{ month_quarter() == $i ? 'selected' : '' }} value="{{ $i }}">
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#residual-risk-level-collapse"
                    aria-expanded="false" aria-controls="residual-risk-level-collapse">
                    <i class="ri-arrow-down-s-line fs-18 collapse-open"></i>
                    <i class="ri-arrow-up-s-line collapse-close fs-18"></i>
                </a>
            </div>
            <div class="collapse show border-top" id="residual-risk-level-collapse">
                <div class="card-body">
                    <div id="residual-risk-level-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
