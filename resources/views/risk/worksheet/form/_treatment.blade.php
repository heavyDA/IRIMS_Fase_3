<form id="treatmentForm">
    <div class="row w-75 mx-auto">
        <div class="col">
            <div class="row mb-1">
                <div class="col-3">No. Risiko</div>
                <div class="col">
                    <input type="text" class="form-control" disabled name="risk_number">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">No. Penyebab Risiko<span class="text-danger">*</span></div>
                <div class="col">
                    <select class="form-control" name="risk_cause_number" data-custom>
                        <option>Pilih</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Penyebab Risiko</div>
                <div class="col">
                    <div id="risk_cause_body-editor" class="textarea"></div>
                    <textarea class="form-control d-none" name="risk_cause_body" rows="4"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Opsi Perlakuan Risiko<span class="text-danger">*</span>
                    <a tabindex="0"
                        class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                        role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                        title="Information" data-bs-html="true"
                        data-bs-content='<ol><li><b>Accept/monitor&nbsp;</b>yaitu menerima Risiko dengan melakukan kegiatan perlakuan Risiko sesual existing control berdasarkan pengendalian internal yang sudah ada tanpa melakukan upaya tambahan untuk mengurangi, mentransfer atau membagi Risiko. Kegiatan perlakuannya adalah memonitor efektivitas pelaksanaan pengendalian internal.</li><li><b>Reduce/mitigate</b>&nbsp;yaitu melakukan perlakuan Risiko dengan mengurangiDampak dan/atau Probabilitas Risiko terhadap perusahaan, di mana Risiko tetap melekat dan menjadi tanggung jawab perusahaan. <b>Contoh</b> dari perlakuan Risiko ini adalah penyusunan kebijakan, pelatihan dan implementasi business continuity management (BCM).</li><li><b>Transfer/sharing</b> yaitu melakukan perlakuan Risiko dengan mengalihkan sebagian Risiko ke entitas lain (misalnya, pihak ketiga atau mitra) yang dapat mengontrol atau menyerap Risiko. Langkah ini akan mengurangi Dampak dan/atau Probabilitas Risiko. Tanggung jawab Risiko menjadi tanggungan bersama/dibagi bersama pihak eksternal. <b>Contoh</b> dari perlakuan Risiko ini adalah pembelian asuransi, pembelian produk&nbsp; lindung nilai/hedging, dan&nbsp; outsourcing.&nbsp;</li><li><b>Avoid/ hindari</b>&nbsp; yaitu melakukan perlakuan Risiko dengan tidak memulai atau melanjutkan aktivitas yang menimbulkan Risiko di atas pernyataan Selera Risiko atau biaya yang timbul di luar ambang batas yang dapat diterima oleh perusahaan.</li></ol>'><i
                            class="ti ti-info-circle h5 text-secondary"></i>
                    </a>
                </div>
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-database"></i>
                        </span>
                        <select class="form-select" name="risk_treatment_option">
                            <option>Pilih</option>
                            @foreach ($risk_treatment_options as $option)
                                <option value="{{ $option->id }}">{{ $option->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Jenis Rencana Perlakuan Risiko<span class="text-danger">*</span>
                    <a tabindex="0"
                        class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                        role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                        title="Information" data-bs-html="true"
                        data-bs-content='<p>Diisi dengan pilihan jenis rencana perlakuan risiko:<br><ol><li>Peningkatan
  Kecukupan Desain Kontrol</li><li>Peningkatan Efektivitas Pelaksanaan
  Kontrol</li><li>Perbaikan Melalui Breakthrough Project</li><li>Peningkatan
  Kecukupan Desain Kontrol dan Peningkatan Efektivitas Pelaksanaan Kontrol</li><li>Peningkatan
  Kecukupan Desain Kontrol dan Perbaikan Melalui Breakthrough Project</li><li>Peningkatan
  Efektivitas Pelaksanaan Kontrol dan Perbaikan Melalui Breakthrough
  Project
 
 
  Peningkatan
  Kecukupan Desain Kontrol,</li><li>Peningkatan Efektivitas Pelaksanaan Kontrol, dan
  Pebaikan Melalui Breakthrough Project&nbsp;</li><li>
 Lainnya</li></ol>
  </p>'><i
                            class="ti ti-info-circle h5 text-secondary"></i>
                    </a>
                </div>
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-database"></i>
                        </span>
                        <select class="form-select" name="risk_treatment_type">
                            <option>Pilih</option>
                            @foreach ($risk_treatment_types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-secondary-light" id="treatmentModalButton">
        <i class="ti ti-plus"></i> Tambah Rencana Mitigasi
    </button>
    <div class="row mt-2">
        <div class="col" style="overflow-x: scroll;">
            <table id="worksheetTreatmentTable" class="table table-bordered table-hover" style="width:100%">
                <thead class="table-dark">
                    <tr style="vertical-align: bottom;">
                        <th style="">Aksi</th>
                        <th style="">No. Penyebab Risiko</th>
                        <th style="">Opsi Perlakuan Risiko</th>
                        <th style="">Jenis Rencana Perlakuan Risiko</th>
                        <th style="">Rencana Perlakuan Risiko</th>
                        <th style="width: 220px !important;">Ouput Perlakuan Risiko</th>
                        <th style="">Tanggal Mulai</th>
                        <th style="">Tanggal Selesai</th>
                        <th style="">Biaya Mitigasi</th>
                        <th style="">Jenis Program Dalam RKAP</th>
                        <th style="">PIC (Unit Kerja)</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</form>


@push('element')
    <div class="modal fade" id="treatmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 100% !important;">
            <div class="modal-content mx-auto" style="width: 80vw !important">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Pilihan Rencana Perlakuan Risiko</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="treatmentMitigationForm">
                        <input type="hidden" name="id" value>
                        <input type="hidden" name="key">
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Rencana Perlakuan Risiko<span class="text-danger">*</span>
                            </div>
                            <div>
                                <div id="mitigation_plan-editor" class="textarea"></div>
                                <textarea class="form-control d-none" name="mitigation_plan" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Output Perlakuan Risiko<span class="text-danger">*</span>
                            </div>
                            <div>
                                <div id="mitigation_output-editor" class="textarea"></div>
                                <textarea class="form-control d-none" name="mitigation_output" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Tanggal Mitigasi<span class="text-danger">*</span>
                            </div>
                            <div>
                                <input type="hidden" name="mitigation_start_date" value="{{ date('Y') . '-01-01' }}">
                                <input type="hidden" name="mitigation_end_date" value="{{ date('Y') . '-12-31' }}">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                                    <input type="text" class="form-control" id="mitigation_date-picker">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Biaya Mitigasi<span class="text-danger">*</span>
                            </div>
                            <div>
                                <input type="text" class="form-control" name="mitigation_cost">
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Jenis Program Dalam RKAP<span class="text-danger">*</span>
                            </div>
                            <div>
                                <select name="mitigation_rkap_program_type" class="form-select">
                                    <option>Pilih</option>
                                    @foreach ($rkap_program_types as $parent)
                                        <optgroup label="{{ $parent->name }}">
                                            @foreach ($parent->children as $child)
                                                <option value="{{ $child->id }}">{{ $child->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                PIC (Unit Kerja)<span class="text-danger">*</span>
                            </div>
                            <div>
                                <input type="text" class="form-control not-allowed" name="mitigation_pic" disabled>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" form="treatmentMitigationForm">Batal</button>
                    <button type="submit" form="treatmentMitigationForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endpush
