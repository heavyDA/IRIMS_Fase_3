<div class="d-flex flex-column" style="min-height: 300px">
    <ul class="nav nav-tabs mb-3 d-sm-flex d-block" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link py-1 active" role="tab" data-bs-toggle="tab" href="#tableContext" aria-selected="true"
                tabindex="-1">
                Penetapan Lingkup, Konteks, & Kriteria
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link py-1" role="tab" data-bs-toggle="tab" href="#tableIdentification"
                aria-selected="false" tabindex="-1">Risk
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
            <div class="row mt-2">
                <div class="col py-2" style="overflow-x: scroll;">
                    @include('risk.assessment.worksheet.table._context')
                </div>
            </div>
        </div>
        <div class="tab-pane border-0 p-2" id="tableIdentification" role="tabpanel">
            <div class="row mt-2">
                <div class="col py-2" style="overflow-x: scroll;">
                    @include('risk.assessment.worksheet.table._identification')
                </div>
            </div>
        </div>
        <div class="tab-pane border-0 p-2" id="tableTreatment" role="tabpanel">
            <div class="row mt-2">
                <div class="col py-2" style="overflow-x: scroll;">
                    @include('risk.assessment.worksheet.table._treatment')
                </div>
            </div>
        </div>
    </div>
</div>
