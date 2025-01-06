<form id="contextForm">
    <div class="row w-75 mx-auto">
        <div class="col">
            <div class="row mb-1">
                <div class="col-3">Unit Kerja</div>
                <div class="col">
                    <input disabled type="text" name="unit_name" class="form-control not-allowed"
                        value="{{ isset($worksheet) ? $worksheet->unit_name : auth()->user()->unit_name }}">
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-3">Tahun</div>
                <div class="col">
                    <input disabled type="text" name="period_year" class="form-control not-allowed"
                        placeholder="Tahun" value="{{ isset($worksheet) ? $worksheet->period_year : date('Y') }}">
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-3">Tanggal</div>
                <div class="col">
                    <input disabled type="text" name="period_date" class="form-control not-allowed"
                        value="{{ isset($worksheet) ? $worksheet->period_date : now()->format('F d, Y') }}">
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-3">Pilihan Sasaran</div>
                <div class="col">
                    <input type="hidden" class="form-control" name="risk_number" value="{{ $worksheet_number }}"
                        readonly>
                    <div id="target_body-editor" class="textarea"></div>
                    <textarea type="text" name="target_body" class="d-none">{!! isset($worksheet) ? html_entity_decode($worksheet->target->body) : '' !!}</textarea>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-secondary-light" id="strategyModalButton">
        <i class="ti ti-plus"></i>Tambah Pilihan Strategi Bisnis
    </button>

    <div class="row mt-2">
        <div class="col py-2" style="overflow-x: scroll;">
            <table id="worksheetStrategyTable" class="table table-bordered table-stripped" style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th style="width:100px;"></th>
                        <th style="width: 240px;">Pilihan Strategi</th>
                        <th style="width: 240px;">Hasil yang diharapkan dapat diterima perusahaan</th>
                        <th style="width: 240px;">Nilai Risiko Yang Akan Timbul</th>
                        <th style="width: 240px;">Nilai limit risiko sesuai dengan parameter risiko dalam Metrik
                            Strategi Risiko</th>
                        <th style="width: 100px;">Keputusan Penetapan</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</form>

@push('element')
    <div class="modal fade" id="strategyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Pilihan Strategi Bisnis</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="strategyForm">
                        <div id="strategyFormAlert" class="alert alert-danger alert-dismissible hide fade mb-2">
                            <p></p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                                    class="bi bi-x"></i></button>
                        </div>
                        <input type="hidden" name="key">
                        <input type="hidden" name="id" value>

                        <div class="d-flex flex-column mb-2">
                            <div>
                                Pilihan Strategi<span class="text-danger">*</span>
                            </div>
                            <div>
                                <div id="strategy_body-editor" class="textarea"></div>
                                <textarea name="strategy_body" class="d-none"></textarea>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Hasil yang diharapkan dapat diterima perusahaan<span class="text-danger">*</span>
                            </div>
                            <div>
                                <div id="strategy_expected_feedback-editor" class="textarea"></div>
                                <textarea name="strategy_expected_feedback" class="d-none"></textarea>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Nilai Risiko Yang Akan Timbul<span class="text-danger">*</span>
                            </div>
                            <div>
                                <div id="strategy_risk_value-editor" class="textarea"></div>
                                <textarea name="strategy_risk_value" class="d-none"></textarea>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Nilai limit risiko sesuai dengan parameter risiko dalam Metrik Strategi Risiko<span
                                    class="text-danger">*</span>
                            </div>
                            <div>
                                <input required type="text" class="form-control" name="strategy_risk_value_limit">
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Keputusan Penetapan<span class="text-danger">*</span>
                            </div>
                            <div>
                                <select required class="form-select" name="strategy_decision">
                                    <option>Pilih</option>
                                    <option value="accept">Accept</option>
                                    <option value="avoid">Avoid</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="strategyForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endpush
