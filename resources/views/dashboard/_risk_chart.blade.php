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
                <div class="card-title">
                    <div class="d-flex gap-1 align-items-center">
                        <label>Skala Risiko&nbsp;</label>
                        <select class="form-select" id="risk-level-select">
                            <option value="residual">Residual</option>
                            <option value="target-residual">Target Residual</option>
                        </select>
                    </div>
                </div>
                <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#risk-level-collapse"
                    aria-expanded="false" aria-controls="risk-level-collapse">
                    <i class="ri-arrow-down-s-line fs-18 collapse-open"></i>
                    <i class="ri-arrow-up-s-line collapse-close fs-18"></i>
                </a>
            </div>
            <div class="collapse show border-top" id="risk-level-collapse">
                <div class="card-body">
                    <div id="risk-level-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
