@push('top-script')
    @vite('resources/js/pages/dashboard/_monitoring_progress.js')
@endpush
<!-- Top Risk -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between border-bottom-0">
                <div class="card-title">
                    Progress Monitoring
                </div>
                <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#progress-monitoring-collapse"
                    aria-expanded="false" aria-controls="collapseExample">
                    <i class="ri-arrow-down-s-line fs-18 collapse-open"></i>
                    <i class="ri-arrow-up-s-line collapse-close fs-18"></i>
                </a>
            </div>
            <div class="collapse show border-top" id="progress-monitoring-collapse">
                <div class="card-body">
                    <table id="progress-monitoring-table" class="table text-nowrap table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="table-dark-custom" rowspan="2" style="width: 256px;">Unit</th>
                                <th colspan="12" class="table-dark-custom" style="text-align: center !important;">
                                    Timeline</th>
                            </tr>
                            <tr>
                                @for ($i = 1; $i <= 12; $i++)
                                    <th style="text-align: center !important;">
                                        {{ format_date(request('year', date('Y') . sprintf('-%02d', $i) . '-01'))->translatedFormat('M') }}
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Top Risk -->
<div class="modal fade" id="monitoring-progress-chid-modal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 100% !important;">
        <div class="modal-content mx-auto" style="width: 80vw !important">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Monitoring Progress</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="monitoring-progress-chid-table-wrapper" style="max-height: 72vh;">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
