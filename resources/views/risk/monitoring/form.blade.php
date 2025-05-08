<div class="d-flex flex-column">
    <ul class="nav nav-tabs mb-3 nav-justified tab-style-6 d-flex" style="overflow-x: auto;" id="monitoringTab"
        role="tablist">
        <li class="nav-item not-allowed" role="presentation">
            <div class="d-flex flex-column gap-2 align-items-center justify-content-center">
                <h2 style="width: 72px !important; height: 72px;"
                    class="bg-success rounded-circle d-flex px-4 py-1 align-items-center justify-content-center text-white">
                    1
                </h2>
                <a class="not-allowed active py-1" role="tab" href="#stepperResidual" aria-selected="true"
                    tabindex="-1">
                    Realisasi Risiko Residual
                </a>
            </div>
        </li>
        <li class="not-allowed nav-item" role="presentation">
            <div class="d-flex flex-column gap-2 align-items-center justify-content-center">
                <h2 style="width: 72px !important; height: 72px;"
                    class="bg-light rounded-circle d-flex px-4 py-1 align-items-center justify-content-center">2
                </h2>
                <a class="not-allowed py-1" role="tab" href="#stepperActualization" aria-selected="false"
                    tabindex="-1">Realisasi Pelaksanaan Perlakuan Risiko dan Biaya</a>
            </div>
        </li>
        <li class="not-allowed nav-item" role="presentation">
            <div class="d-flex flex-column gap-2 align-items-center justify-content-center">
                <h2 style="width: 72px !important; height: 72px;"
                    class="bg-light rounded-circle d-flex px-4 py-1 align-items-center justify-content-center">3
                </h2>
                <a class="not-allowed" role="tab" href="#stepperMap" aria-selected="false">Peta Risiko
                    Residual</a>
            </div>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane border-0 p-2 show active" id="stepperResidual" role="tabpanel">
            @include('risk.monitoring.form._residual')
        </div>
        <div class="tab-pane border-0 p-2" id="stepperActualization" role="tabpanel">
            @include('risk.monitoring.form._actualization')
        </div>
        <div class="tab-pane border-0 p-2" id="stepperMap" role="tabpanel">
            @include('risk.monitoring.form._map')
        </div>
        <div class="row mt-2">
            <div class="col d-flex justify-content-center">
                <button type="button" id="monitoringTabPreviousButton" class="d-none btn btn-light">Sebelumnya</button>
                <button type="button" id="monitoringTabNextButton" class="btn btn-primary">Selanjutnya</button>
                <button type="button" id="monitoringTabSubmitButton" class="d-none btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
