<form id="treatmentForm">
    <div class="row w-75 mx-auto">
        <div class="col">
            <div class="row mb-1">
                <div class="col-3">No. Risiko</div>
                <div class="col">
                    <input type="text" class="form-control" disabled name="risk_number" value="{{ $worksheet_number }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">No. Penyebab Risiko</div>
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
                <div class="col-3">Opsi Perlakuan Risiko</div>
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
                <div class="col-3">Jenis Rencana Perlakuan Risiko</div>
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

    <button type="button" class="btn btn-secondary-light" data-bs-toggle="modal" data-bs-target="#treatmentModal">
        <i class="ti ti-plus"></i> Tambah Rencana Mitigasi
    </button>
    <div class="row mt-2">
        <div class="col" style="overflow-x: scroll;">
            <table id="worksheetTreatmentTable" class="table table-bordered table-stripped" style="width:100%">
                <thead class="table-dark">
                    <tr style="vertical-align: bottom;">
                        <th style="">Aksi</th>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Pilihan Strategi Bisnis</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="treatmentMitigationForm">
                        <input type="hidden" name="id" value>
                        <input type="hidden" name="key">
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Rencana Perlakuan Risiko
                            </div>
                            <div>
                                <div id="mitigation_plan-editor" class="textarea"></div>
                                <textarea class="form-control d-none" name="mitigation_plan" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Output Perlakuan Risiko
                            </div>
                            <div>
                                <div id="mitigation_output-editor" class="textarea"></div>
                                <textarea class="form-control d-none" name="mitigation_output" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Tanggal Mitigasi
                            </div>
                            <div>
                                <input type="hidden" name="mitigation_start_date" value="2024-01-01">
                                <input type="hidden" name="mitigation_end_date" value="2024-06-30">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                                    <input type="text" class="form-control" id="mitigation_date-picker">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Biaya Mitigasi
                            </div>
                            <div>
                                <input type="text" class="form-control" name="mitigation_cost">
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Jenis Program Dalam RKAP
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
                                PIC (Unit Kerja)
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
