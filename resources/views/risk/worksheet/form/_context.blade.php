<form id="contextForm">
    <div class="row w-75 mx-auto">
        <div class="col">
            <div class="row mb-1">
                <div class="col-3">Unit Kerja</div>
                <div class="col">
                    <input disabled type="text" name="unit_name" class="form-control not-allowed"
                        value="{{ isset($worksheet) ? $worksheet->worksheet_code : session()->get('current_unit')->sub_unit_name }}">
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
                <div class="col-3">
                    <span>No. Risiko<span class="text-danger">*</span></span>
                    <a tabindex="0"
                        class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                        role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                        title="Information" data-bs-html="true"
                        data-bs-content="<p>No. Risiko adalah nomor unik untuk setiap risiko yang diidentifikasikan.</p><p>Ditulis sebagai berikut AREA-SUB_UNIT-NO_URUT</p><p>Contoh: PST-OPP-1</p>">
                        <i class="ti ti-info-circle h5 text-secondary"></i>
                    </a>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="risk_number" value=""
                        placeholder="AREA-SUB_UNIT-NO_URUT">
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-3">
                    <span>Pilihan Sasaran <span class="text-danger">*</span></span>
                    <a tabindex="0"
                        class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                        role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                        title="Information" data-bs-html="true"
                        data-bs-content="
                    <p>Diisi dengan berbagai pilihan sasaran yang menjadi dinamika dalam perencanaan penyusunan rancangan/pencapaian RKAP.</p>
                    <p><strong>Sasaran</strong> adalah tujuan yang akan dicapai meliputi tingkat pertumbuhan dan kesehatan perusahaan serta sasaran bidang/unit kegiatan secara kuantitatif dan spesifik setiap tahunnya.</p>
                    <p>Note: Sasaran disusun secara lengkap. </p>
                    <p>Sebagai contoh: <strong>Peningkatan market share segmen corporate dari 20% menjadi 30% pada akhir tahun 2024</strong></p>
                    "><i
                            class="ti ti-info-circle h5 text-secondary"></i>
                    </a>
                </div>
                <div class="col">
                    <div id="target_body-editor" class="textarea"></div>
                    <textarea type="text" name="target_body" class="d-none">{!! isset($worksheet) ? html_entity_decode($worksheet->target_body) : '' !!}</textarea>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-secondary-light" id="strategyModalButton">
        <i class="ti ti-plus"></i>Tambah Pilihan Strategi Bisnis
    </button>

    <div class="row mt-2">
        <div class="col py-2" style="overflow-x: scroll;">
            <table id="worksheetStrategyTable" class="table table-bordered table-hover" style="width:100%">
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
        <div class="modal-dialog" style="max-width: 100% !important;">
            <div class="modal-content mx-auto" style="width: 80vw !important">
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
                                <a tabindex="0"
                                    class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                                    role="button" data-bs-toggle="popover" data-bs-trigger="focus"
                                    data-bs-placement="right" title="Information" data-bs-html="true"
                                    data-bs-content='
                                        <p>Diisi dengan berbagai pilihan strategi yang menjadi dinamika dalam perencanaan penyusunan rancangan/pencapaian RKAP.</p>
                                        <p><strong>Strategi</strong> adalah cara yang digunakan untuk mencapai sasaran, meliputi strategi korporasi sesuai posisi perusahaan, strategi bisnis, dan strategi fungsional tiap bidang/unit kegiatan.</p>
                                    '><i
                                        class="ti ti-info-circle h5 text-secondary"></i>
                                </a>
                            </div>
                            <div>
                                <div id="strategy_body-editor" class="textarea"></div>
                                <textarea name="strategy_body" class="d-none"></textarea>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Hasil yang diharapkan dapat diterima perusahaan
                                <a tabindex="0"
                                    class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                                    role="button" data-bs-toggle="popover" data-bs-trigger="focus"
                                    data-bs-placement="right" title="Information" data-bs-html="true"
                                    data-bs-content='
                                        <p>Diisi dengan nilai kuantitatif dalam mata uang rupiah/mata uang fungsional pembukuan atas hasil yang diharapkan dari pelaksanaan sasaran dan strategi yang akan dijalankan pada tahun berjalan.<br>(satuan dalam rupiah/mata uang fungsional pembukuan).</p>
                                    '><i
                                        class="ti ti-info-circle h5 text-secondary"></i>
                                </a>
                            </div>
                            <div>
                                <div id="strategy_expected_feedback-editor" class="textarea"></div>
                                <textarea name="strategy_expected_feedback" class="d-none"></textarea>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Nilai Risiko Yang Akan Timbul
                                <a tabindex="0"
                                    class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                                    role="button" data-bs-toggle="popover" data-bs-trigger="focus"
                                    data-bs-placement="right" title="Information" data-bs-html="true"
                                    data-bs-content='
                                        <p>Diisi dengan nilai risiko yang akan timbul sebagai konsekuensi dari suatu sasaran dan strategi yang akan dijalankan.</p>
                                    '><i
                                        class="ti ti-info-circle h5 text-secondary"></i>
                                </a>
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
                                <a tabindex="0"
                                    class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                                    role="button" data-bs-toggle="popover" data-bs-trigger="focus"
                                    data-bs-placement="right" title="Information" data-bs-html="true"
                                    data-bs-content='
                                        <p>Diisi dengan batasan risiko / limit risiko sesuai dengan parameter risiko dalam metrik strategi risiko.</p>
                                        <ol>
                                            <li>Limit Korporasi</li>
                                            <li>Limit Kantor Pusat</li>
                                            <li>Limit Unit Atau Kantor Cabang</li>
                                        </ol>
                                        <p>(satuan dalam rupiah/mata uang fungsional pembukuan).</p>
                                    '><i
                                        class="ti ti-info-circle h5 text-secondary"></i>
                                </a>
                            </div>
                            <div>
                                <input type="text" class="not-allowed form-control" name="strategy_risk_value_limit"
                                    disabled>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Keputusan Penetapan
                                <a tabindex="0"
                                    class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                                    role="button" data-bs-toggle="popover" data-bs-trigger="focus"
                                    data-bs-placement="right" title="Information" data-bs-html="true"
                                    data-bs-content='
                                        <p>Diisi dengan pilihan:</p>
                                        <ul>
                                            <li>Accept: apabila sasaran dan strategi diterima menjadi sasaran dan strategi yang akan dijalankan dalam rancangan RKAP.</li>
                                            <li>Avoid: apabila sasaran dan strategi tidak dapat diterima dan tidak dapat dimasukkan dalam sasaran dan strategi yang akan dijalankan di dalam rancangan RKAP.</li>
                                        </ul>
                                    '><i
                                        class="ti ti-info-circle h5 text-secondary"></i>
                                </a>
                            </div>
                            <div>
                                <select class="form-select" name="strategy_decision">
                                    <option value="">Pilih</option>
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
