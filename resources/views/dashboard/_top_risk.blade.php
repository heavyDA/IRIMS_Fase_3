<!-- Top Risk -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between border-bottom-0">
                <div class="card-title">
                    Top Risk
                </div>
                <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#top-risk-collapse"
                    aria-expanded="false" aria-controls="collapseExample">
                    <i class="ri-arrow-down-s-line fs-18 collapse-open"></i>
                    <i class="ri-arrow-up-s-line collapse-close fs-18"></i>
                </a>
            </div>
            <div class="collapse show border-top" id="top-risk-collapse">
                <div class="card-body overflow-scroll">
                    <div class="row mb-4 justify-content-end">
                        <div class="col-12 col-xl-7">
                            <div class="d-flex gap-2">
                                <div class="input-group">
                                    <span class="input-group-text" id="inputGroup-sizing-default"><i
                                            class="ti ti-search"></i></span>
                                    <input type="text" name="search" class="form-control" placeholder="Pencarian"
                                        id="toprisk-table-search">
                                </div>
                                <button style="min-width: 32px;" class="btn btn-light" type="reset"
                                    id="toprisk-table-refresh" data-bs-toggle="tooltip" title="Reset">
                                    <span><i class="me-1 ti ti-refresh"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <table id="top-risk-table" class="table table-bordered table-hover display nowrapr">
                        <thead class="table-dark">
                            <tr>
                                <th class="table-dark-custom" rowspan="3">No.</th>
                                <th class="table-dark-custom" rowspan="3">Organisasi</th>
                                <th class="table-dark-custom" rowspan="3">Peristiwa Risiko</th>
                                <th class="table-dark-custom" rowspan="3">Penyebab Risiko</th>
                                <th class="table-dark-custom" rowspan="3">Rencana Perlakuan Risiko</th>
                                <th class="table-dark-custom" style="text-align: center !important;" colspan="2">
                                    Inheren</th>
                                <th class="table-dark-custom" style="text-align: center !important;" colspan="8">
                                    Target Residual</th>
                                <th class="table-dark-custom" style="text-align: center !important;" colspan="2">
                                    Residual</th>
                            </tr>
                            <tr>
                                <th class="table-dark-custom" style="text-align: center !important;" rowspan="2">
                                    Level</th>
                                <th class="table-dark-custom" style="text-align: center !important;" rowspan="2">
                                    Skala Risiko</th>
                                <th class="table-dark-custom" style="text-align: center !important;" colspan="4">
                                    Level</th>
                                <th class="table-dark-custom" style="text-align: center !important;" colspan="4">
                                    Skala Risiko</th>
                                <th class="table-dark-custom" style="text-align: center !important;" rowspan="2">
                                    Level</th>
                                <th class="table-dark-custom" style="text-align: center !important;" rowspan="2">
                                    Skala Risiko</th>
                            </tr>
                            <tr>
                                <td class="table-dark-custom" style="text-align: center !important;">Q1</td>
                                <td class="table-dark-custom" style="text-align: center !important;">Q2</td>
                                <td class="table-dark-custom" style="text-align: center !important;">Q3</td>
                                <td class="table-dark-custom" style="text-align: center !important;">Q4</td>
                                <td class="table-dark-custom" style="text-align: center !important;">Q1</td>
                                <td class="table-dark-custom" style="text-align: center !important;">Q2</td>
                                <td class="table-dark-custom" style="text-align: center !important;">Q3</td>
                                <td class="table-dark-custom" style="text-align: center !important;">Q4</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Top Risk -->
