<div class="d-flex flex-column">
    <ul class="nav nav-tabs mb-3 nav-justified tab-style-6 d-sm-flex d-block" id="worksheetTab" role="tablist">
        <li class="nav-item not-allowed" role="presentation">
            <div class="d-flex flex-column flex-lg-row gap-2 align-items-center justify-content-center">
                <h2 style="width: 48px !important; height: 48px;"
                    class="bg-success rounded-circle d-flex px-4 py-1 align-items-center justify-content-center text-white">
                    1
                </h2>
                <a class="not-allowed active py-1" role="tab" href="#stepperContext" aria-selected="true"
                    tabindex="-1">
                    Penetapan Lingkup, Konteks, & Kriteria
                </a>
            </div>
        </li>
        <li class="not-allowed nav-item" role="presentation">
            <div class="d-flex flex-column flex-lg-row gap-2 align-items-center justify-content-center">
                <h2 style="width: 48px !important; height: 48px;"
                    class="bg-light rounded-circle d-flex px-4 py-1 align-items-center justify-content-center">2</h2>
                <a class="not-allowed py-1" role="tab" href="#stepperIdentification" aria-selected="false"
                    tabindex="-1">Risk
                    Assessment</a>
            </div>
        </li>
        <li class="not-allowed nav-item" role="presentation">
            <div class="d-flex flex-column flex-lg-row gap-2 align-items-center justify-content-center">
                <h2 style="width: 48px !important; height: 48px;"
                    class="bg-light rounded-circle d-flex px-4 py-1 align-items-center justify-content-center">3</h2>
                <a class="not-allowed" role="tab" href="#stepperTreatment" aria-selected="false">Risk
                    Treatment</a>
            </div>
        </li>
        <li class="not-allowed nav-item" role="presentation">
            <div class="d-flex flex-column flex-lg-row gap-2 align-items-center justify-content-center">
                <h2 style="width: 48px !important; height: 48px;"
                    class="bg-light rounded-circle d-flex px-4 py-1 align-items-center justify-content-center">4</h2>
                <a class="not-allowed" role="tab" href="#stepperMonitoring" aria-selected="false"
                    tabindex="-1">Risk
                    Monitoring & Review</a>
            </div>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane border-0 p-2 show active" id="stepperContext" role="tabpanel">
            @include('risk.assessment.worksheet._context')
        </div>
        <div class="tab-pane border-0 p-2" id="stepperIdentification" role="tabpanel">
            @include('risk.assessment.worksheet._identification')
        </div>
        <div class="tab-pane border-0 p-2" id="stepperTreatment" role="tabpanel">
            @include('risk.assessment.worksheet._treatment')
        </div>
        <div class="tab-pane border-0 p-2" id="stepperMonitoring" role="tabpanel">
            @include('risk.assessment.worksheet._monitoring')
        </div>
        <div class="row mt-2">
            <div class="col d-flex justify-content-center">
                <button type="button" id="worksheetTabPreviousButton" class="d-none btn btn-light">Sebelumnya</button>
                <button type="button" id="worksheetTabNextButton" class="btn btn-primary">Selanjutnya</button>
                <button type="button" id="worksheetTabSubmitButton" class="d-none btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
