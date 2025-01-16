<form id="residualForm">
    <div class="row w-75 mx-auto">
        <div class="col">
            <div class="row mb-1">
                <div class="col-3">Unit Kerja</div>
                <div class="col">
                    <input disabled type="text" name="unit_name" class="form-control not-allowed"
                        value="{{ $worksheet->unit_name }}">
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-3">Tahun</div>
                <div class="col">
                    <input disabled type="text" name="period_year" class="form-control not-allowed"
                        placeholder="Tahun" value="{{ $worksheet->period_year }}">
                </div>

            </div>
            <div class="row mb-1">
                <div class="col-3">Tanggal</div>
                <div class="col">
                    <input type="date" name="period_date" class="form-control"
                        value="{{ isset($monitoring) ? $monitoring->period_date : date('Y-m-d') }}">
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-3">No. Risiko</div>
                <div class="col">
                    <input type="text" value="{{ $worksheet->worksheet_number }}" name="risk_number" disabled
                        class="not-allowed form-control" value="{{ $worksheet->worksheet_number }}">
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-3">No. Penyebab Risiko</div>
                <div class="col">
                    <select name="risk_cause_number" class="form-select">
                    </select>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-3">
                    Peristiwa Risiko
                </div>
                <div class="col">
                    <div id="risk_chronology_body-editor" class="textarea not-allowed"></div>
                    <textarea type="text" name="risk_chronology_body" class="d-none"></textarea>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-3">Kategori Dampak</div>
                <div class="col">
                    <input type="text" name="risk_impact_category" class="form-control not-allowed" disabled
                        value="{{ ucwords($worksheet->target->identification->risk_impact_category) }}">
                </div>
            </div>
        </div>
    </div>
    <div class="w-75 my-4 mx-auto border-bottom border-success border-3"></div>
    <div class="row w-75 mx-auto">
        <div class="col">
            <div class="row mb-1">
                <div class="col-3">
                    {{ $isQuantitative ? 'Asumsi Perhitungan Dampak Kuantitatif' : 'Penjelasan Dampak Kualitatif' }}
                </div>
                <div class="col">
                    <div id="inherent_body-editor" class="textarea not-allowed"></div>
                    <textarea type="text" name="inherent_body" class="d-none">{!! isset($worksheet) ? html_entity_decode($worksheet->target->body) : '' !!}</textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Nilai Dampak Residual {{ $isQuantitative ? 'Kuantitatif' : 'Kualitatif' }}
                </div>
                <div class="col row">
                    @for ($quarter = 1; $quarter < 5; $quarter++)
                        <div class="col-12 col-md-6 col-lg-3">
                            <label>Q{{ $quarter }}</label>
                            <input type="text" class="not-allowed form-control" disabled
                                name="residual[{{ $quarter }}][impact_value]">
                        </div>
                    @endfor
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Skala Dampak Residual {{ $isQuantitative ? 'Kuantitatif' : 'Kualitatif' }}
                </div>
                <div class="col row">
                    @for ($quarter = 1; $quarter < 5; $quarter++)
                        <div class="col-12 col-md-6 col-lg-3">
                            <label>Q{{ $quarter }}</label>
                            <select disabled data-custom class="not-allowed form-select w-100"
                                name="residual[{{ $quarter }}][impact_scale]">
                                <option>Pilih</option>
                            </select>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Nilai Probabilitas Residual {{ $isQuantitative ? 'Kuantitatif' : 'Kualitatif' }}
                </div>
                <div class="col row">
                    @for ($quarter = 1; $quarter < 5; $quarter++)
                        <div class="col-12 col-md-6 col-lg-3">
                            <label>Q{{ $quarter }}</label>
                            <input disabled type="number" max=100 class="not-allowed form-control"
                                name="residual[{{ $quarter }}][impact_probability]">
                        </div>
                    @endfor
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Skala Probabilitas {{ $isQuantitative ? 'Kuantitatif' : 'Kualitatif' }}</div>
                <div class="col row">
                    @for ($quarter = 1; $quarter < 5; $quarter++)
                        <div class="col-12 col-md-6 col-lg-3">
                            <label>Q{{ $quarter }}</label>
                            <select disabled data-custom class="not-allowed form-select w-100"
                                name="residual[{{ $quarter }}][impact_probability_scale]">
                                <option>Pilih</option>
                            </select>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Eksposur Risiko {{ $isQuantitative ? 'Kuantitatif' : 'Kualitatif' }}
                </div>
                <div class="col row">
                    @for ($quarter = 1; $quarter < 5; $quarter++)
                        <div class="col-12 col-md-6 col-lg-3">
                            <label>Q{{ $quarter }}</label>
                            <input disabled type="text" class="not-allowed form-control"
                                name="residual[{{ $quarter }}][risk_exposure]">
                        </div>
                    @endfor
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Skala Risiko Residual {{ $isQuantitative ? 'Kuantitatif' : 'Kualitatif' }}
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
                <div class="col-3">Level Risiko Residual {{ $isQuantitative ? 'Kuantitatif' : 'Kualitatif' }}
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
            <div class="row mb-3">
                <div class="col-3">Efektifitas Perlakuan Risiko</div>
                <div class="col">
                    <select class="form-select w-100" name="risk_mitigation_effectiveness">
                        <option value="">Pilih</option>
                        <option value="0">Tidak Efektif</option>
                        <option value="1">Efektif</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-3"></div>
                <div class="col">
                    <div class="d-flex">
                        <button type="button" form="residualForm" class="btn btn-success"
                            id="residualFormButton">Simpan Realisasi Risiko Residual</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
