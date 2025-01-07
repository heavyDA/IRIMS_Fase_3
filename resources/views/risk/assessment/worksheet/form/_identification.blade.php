<form id="identificationForm">
    <div class="row w-75 mx-auto">
        <div class="col">
            <div class="row mb-3">
                <div class="col-3">Nama Perusahaan</div>
                <div class="col">
                    <input value="PT Aviasi Pariwisata Indonesia (Persero)" type="text" name="company_name"
                        class="form-control not-allowed" disabled>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Kode Perusahaan</div>
                <div class="col">
                    <input value="API" type="text" name="company_code" class="form-control not-allowed" disabled>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Sasaran Perusahaan</div>
                <div class="col">
                    <div id="target_body-editor" class="textarea"></div>
                    <textarea disabled class="form-control not-allowed resize-none d-none" name="target_body" rows="4"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Sasaran KBUMN</div>
                <div class="col">
                    <select class="form-select" name="kbumn_target">
                        <option>Pilih</option>
                        @foreach ($kbumn_targets as $target)
                            <option value="{{ $target->id }}">{{ $target->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Kategori Risiko BUMN</div>
                <div class="col">
                    <select data-custom class="form-select not-allowed" disabled name="kbumn_risk_category">
                        <option>Pilih</option>
                        @foreach ($kbumn_risk_categories['T3'] as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Kategori Risiko T3</div>
                <div class="col">
                    <select class="form-select" name="kbumn_risk_category_t3">
                        <option>Pilih</option>
                        @foreach ($kbumn_risk_categories['T3'] as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Kategori Risiko T2</div>
                <div class="col">
                    <select class="form-select" name="kbumn_risk_category_t2">
                        <option>Pilih</option>
                        @foreach ($kbumn_risk_categories['T2'] as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Jenis Existing Control</div>
                <div class="col">
                    <select class="form-select" name="existing_control_type">
                        <option>Pilih</option>
                        @foreach ($existing_control_types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Existing Control</div>
                <div class="col">
                    <div class="mb-2">
                        <div id="existing_control_body-editor" class="textarea"></div>
                        <textarea class="d-none form-control" name="existing_control_body" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Penilaian Efektivitas Kontrol</div>
                <div class="col">
                    <select class="form-select" name="control_effectiveness_assessment">
                        <option>Pilih</option>
                        @foreach ($control_effectiveness_assessments as $assessment)
                            <option value="{{ $assessment->id }}">{{ $assessment->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Kategori Dampak</div>
                <div class="col">
                    <select class="form-select" name="risk_impact_category">
                        <option>Pilih</option>
                        <option value="kuantitatif">Kuantitatif</option>
                        <option value="kualitatif">Kualitatif</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Deskripsi Dampak</div>
                <div class="col">
                    <div class="mb-2">
                        <div id="risk_impact_body-editor" class="textarea"></div>
                        <textarea class="d-none form-control" name="risk_impact_body" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Perkiraan Waktu Terpapar Risiko</div>
                <div class="col">
                    <input type="hidden" name="risk_impact_start_date" value="2024-01-01">
                    <input type="hidden" name="risk_impact_end_date" value="2024-06-30">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                        <input type="text" class="form-control" id="risk_impact_date-picker">
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs mb-3 nav-justified tab-style-5 d-sm-flex d-block" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#identificationInherentTab"
                        aria-selected="true">Inheren</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" role="tab" href="#identificationResidualTab"
                        aria-selected="false" tabindex="-1">Residual</a>
                </li>
            </ul>

            <div class="tab-content" id="identificationTabs">
                <div class="tab-pane border-0 p-2 show active" id="identificationInherentTab">
                    <div class="row mb-3">
                        <div data-kualitatif="Penjelasan Dampak Kualitatif"
                            data-kuantitatif="Asumsi Perhitungan Dampak Kuantitatif"
                            class="col-3 label-category-risk">
                            Dampak</div>
                        <div class="col">
                            <div class="mb-2">
                                <div id="inherent_body-editor" class="textarea"></div>
                                <textarea class="d-none form-control" name="inherent_body" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Nilai Dampak Inheren <span
                                class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="inherent_impact_value">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Skala Dampak Inheren <span
                                class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col">
                            <select data-placeholder="Pilih" disabled data-custom class="form-select"
                                name="inherent_impact_scale">
                                <option>Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Nilai Probabilitas Inheren <span class="label-category-risk"></span></div>
                        <div class="col">
                            <div class="input-group">
                                <input type="text" class="form-control" name="inherent_impact_probability">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Skala Probabilitas Inheren <span class="label-category-risk"></span></div>
                        <div class="col">
                            <select data-placeholder="Pilih" disabled data-custom class="form-select"
                                name="inherent_impact_probability_scale">
                                <option>Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Eksposur Risiko <span class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col">
                            <input type="text" disabled class="form-control not-allowed"
                                name="inherent_risk_exposure">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Skala Risiko Inheren <span
                                class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col">
                            <input type="text" disabled class="form-control not-allowed"
                                name="inherent_risk_scale">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Level Risiko Inheren <span
                                class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col">
                            <input type="text" disabled class="form-control not-allowed"
                                name="inherent_risk_level">
                        </div>
                    </div>
                </div>
                <div class="tab-pane border-0 p-2" id="identificationResidualTab">
                    <div class="row mb-3">
                        <div class="col-3">Nilai Dampak Residual <span
                                class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <input type="text" class="form-control" disabled
                                        name="residual[{{ $quarter }}][impact_value]">
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Skala Dampak Residual <span
                                class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <select disabled data-custom class="form-select w-100"
                                        name="residual[{{ $quarter }}][impact_scale]">
                                        <option>Pilih</option>
                                    </select>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Nilai Probabilitas Residual <span
                                class="label-category-risk text-capitalize"></span></div>
                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <input type="text" class="form-control"
                                        name="residual[{{ $quarter }}][impact_probability]">
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Skala Probabilitas <span
                                class="label-category-risk text-capitalize"></span></div>
                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <select disabled data-custom class="form-select w-100"
                                        name="residual[{{ $quarter }}][impact_probability_scale]">
                                        <option>Pilih</option>
                                    </select>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Eksposur Risiko <span class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <input disabled type="text" class="form-control"
                                        name="residual[{{ $quarter }}][risk_exposure]">
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Skala Risiko Residual <span
                                class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <input disabled type="text" class="not-allowed form-control"
                                        name="residual[{{ $quarter }}][risk_scale]">
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Level Risiko Inheren <span
                                class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <input disabled type="text" class="not-allowed form-control"
                                        name="residual[{{ $quarter }}][risk_level]">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-secondary-light" data-bs-toggle="modal" data-bs-target="#incidentModal">
        <i class="ti ti-plus"></i>Tambah Peristiwa Risiko
    </button>

    <div class="row mt-2">
        <div class="col py-2" style="overflow-x: scroll;">
            <table id="worksheetIncidentTable" class="table table-bordered table-stripped" style="width:100%">
                <thead class="table-dark">
                    <tr style="vertical-align: bottom;">
                        <th rowspan="2">Aksi</th>
                        <th style="width: 220px !important;" rowspan="2">Peristiwa Risiko</th>
                        <th style="width: 220px !important;" rowspan="2">Deskripsi Peristiwa Risiko</th>
                        <th style="" rowspan="2">No. Penyebab Risiko</th>
                        <th style="" rowspan="2">Kode Penyebab risiko</th>
                        <th style="width: 220px !important;" rowspan="2">Penyebab risiko</th>
                        <th style="" rowspan="2">Key Risk Indicators</th>
                        <th style="" rowspan="2">Unit Satuan KRI</th>
                        <th style="" colspan="3">Kategori Threshold KRI</th>
                    </tr>
                    <tr style="vertical-align: bottom;">
                        <th rowspan="2">Aman</th>
                        <th rowspan="2">Hati-Hati</th>
                        <th rowspan="2">Bahaya</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</form>


@push('element')
    <div class="modal fade" id="incidentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 100% !important;">
            <div class="modal-content mx-auto" style="width: 80vw !important">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Tambah Peristiwa Risiko</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="incidentForm">
                        <div id="incidentFormAlert" class="alert alert-danger alert-dismissible hide fade mb-2">
                            <p></p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                                    class="bi bi-x"></i></button>
                        </div>
                        <input type="hidden" name="key">
                        <input type="hidden" name="id" value>
                        <div class="row mb-3">
                            <div class="col-3">No. Risiko</div>
                            <div class="col">
                                <input type="text" class="form-control" name="risk_number"
                                    value="{{ $worksheet_number }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Peristiwa Risiko</div>
                            <div class="col">
                                <div class="mb-2">
                                    <div id="risk_chronology_body-editor" class="textarea"></div>
                                    <textarea class="d-none form-control" name="risk_chronology_body" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Deskripsi Peristiwa Risiko</div>
                            <div class="col">
                                <div class="mb-2">
                                    <div id="risk_chronology_description-editor" class="textarea"></div>
                                    <textarea class="d-none form-control" name="risk_chronology_description" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">No. Penyebab Risiko</div>
                            <div class="col">
                                <input type="text" disabled class="not-allowed form-control" name="risk_cause_number"
                                    value="a">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Kode Penyebab Risiko</div>
                            <div class="col">
                                <input type="text" class="form-control" disabled name="risk_cause_code"
                                    value="{{ $worksheet_number }}.a">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Penyebab Risiko</div>
                            <div class="col">
                                <div class="mb-2">
                                    <div id="risk_cause_body-editor" class="textarea"></div>
                                    <textarea class="d-none form-control" name="risk_cause_body" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Key Risk Indicators</div>
                            <div class="col">
                                <input type="text" class="form-control" name="kri_body">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Unit Satuan KRI</div>
                            <div class="col">
                                <select name="kri_unit" class="form-select">
                                    <option>Pilih</option>
                                    @foreach ($kri_units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Kategori Threshold KRI</div>
                            <div class="col">
                                <div class="d-flex flex-column">
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <div class="d-flex flex-column gap-1">
                                                <div class="badge bg-success-transparent">Aman</div>
                                                <input type="text" class="form-control" name="kri_threshold_safe">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="d-flex flex-column gap-1">
                                                <div class="badge bg-warning-transparent">Hati-Hati</div>
                                                <input type="text" class="form-control" name="kri_threshold_caution">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="d-flex flex-column gap-1">
                                                <div class="badge bg-danger-transparent">Bahaya</div>
                                                <input type="text" class="form-control" name="kri_threshold_danger">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="reset" form="incidentForm" class="btn btn-secondary">Batal</button>
                    <button type="submit" form="incidentForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endpush
