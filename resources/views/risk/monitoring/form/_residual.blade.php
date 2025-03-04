<form id="residualForm">
    <div class="row w-75 mx-auto">
        <div class="col">
            <div class="row mb-1">
                <div class="col-3">Unit Kerja</div>
                <div class="col">
                    <input disabled type="text" name="unit_name" class="form-control not-allowed"
                        value="[{{ $worksheet->personnel_area_code }}] {{ $worksheet->sub_unit_name }}">
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
                <div class="col-3"><span>Tanggal<span class="text-danger">*</span></span></div>
                <div class="col">
                    <input type="date" name="period_date" class="form-control"
                        value="{{ isset($monitoring) ? $monitoring->period_date : date('Y-m-d') }}">
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-3">
                    <span>No. Risiko</span>
                </div>
                <div class="col">
                    <input type="text" value="{{ $worksheet->worksheet_number }}" name="risk_number" disabled
                        class="not-allowed form-control" value="{{ $worksheet->worksheet_number }}">
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-3">
                    <span>Peristiwa Risiko</span>
                </div>
                <div class="col">
                    <div id="risk_chronology_body-editor" class="textarea not-allowed"></div>
                    <textarea type="text" name="risk_chronology_body" class="d-none">{!! $worksheet->identification->risk_chronology_body !!}</textarea>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-3">Kategori Dampak</div>
                <div class="col">
                    <input type="text" name="risk_impact_category" class="form-control not-allowed" disabled
                        value="{{ ucwords($worksheet->identification->risk_impact_category) }}">
                </div>
            </div>
        </div>
    </div>
    <div class="w-75 my-4 mx-auto border-bottom border-success border-3"></div>
    <div class="row w-75 mx-auto">
        <div class="col">
            <div class="row mb-1">
                <div class="col-3">
                    <span>{{ $isQuantitative ? 'Asumsi Perhitungan Dampak Kuantitatif' : 'Penjelasan Dampak Kualitatif' }}</span>
                </div>
                <div class="col">
                    <div id="inherent_body-editor" class="textarea not-allowed"></div>
                    <textarea type="text" name="inherent_body" class="d-none">{!! isset($worksheet) ? html_entity_decode($worksheet->target_body) : '' !!}</textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Level Target Risiko Residual {{ $isQuantitative ? 'Kuantitatif' : 'Kualitatif' }}
                </div>
                <div class="col row">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label>Q1</label>
                        <label style="background-color: #F7F8FA"
                            class="form-control not-allowed text-center">{{ $worksheet?->identification?->residual_1_impact_probability_level ?? '' }}<br>{{ $worksheet?->identification?->residual_1_impact_probability_scale }}</label>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label>Q2</label>
                        <label style="background-color: #F7F8FA"
                            class="form-control not-allowed text-center">{{ $worksheet?->identification?->residual_2_impact_probability_level ?? '' }}<br>{{ $worksheet?->identification?->residual_2_impact_probability_scale }}</label>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label>Q3</label>
                        <label style="background-color: #F7F8FA"
                            class="form-control not-allowed text-center">{{ $worksheet?->identification?->residual_3_impact_probability_level ?? '' }}<br>{{ $worksheet?->identification?->residual_3_impact_probability_scale }}</label>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label>Q4</label>
                        <label style="background-color: #F7F8FA"
                            class="form-control not-allowed text-center">{{ $worksheet?->identification?->residual_4_impact_probability_level ?? '' }}<br>{{ $worksheet?->identification?->residual_4_impact_probability_scale }}</label>
                    </div>
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
                <div class="col-3">
                    @if ($isQuantitative)
                        <span>Skala Dampak Residual Kuantitatif<i class="text-danger">*</i></span>
                        <a tabindex="0"
                            class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                            role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                            title="Information" data-bs-html="true"
                            data-bs-content='
                                
                                    <p>Diisi dengan penilaian dampak Risiko Inheren dengan skala 1 s.d. 5
                                    <br><strong>Reference to Table Skala KBUMN</strong></p><br>
                                    <img class="w-100" src="{{ asset('assets/images/pendukung/tabel_skala_bumn.png') }}"/>
                                    <p>
                                        Keterangan: <br>
                                        Nilai Batasan Risiko merupakan nilai Risk Limit di level enterprise sebagaimana yang telah ditetapkan dalam Strategi Risiko BUMN.
                                    </p>
                                '><i
                                class="ti ti-info-circle h5 text-secondary"></i>
                        </a>
                    @else
                        <span>Skala Dampak Residual Kualitatif<i class="text-danger">*</i></span>
                        <a tabindex="0"
                            class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                            role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                            title="Information" data-bs-html="true"
                            data-bs-content='
                                
                                    <p>Diisi dengan penilaian dampak Risiko Inheren dengan skala 1 s.d. 5
                                    <br><strong>Reference to Table Skala KBUMN</strong></p><br>
                                    <img class="w-100" src="{{ asset('assets/images/pendukung/tabel_skala_kualitatif_bumn.png') }}"/>
                                    <p>Catatan:<br>
Apabila acuan kriteria dampak tidak tersedia pada tabel di atas, BUMN dapat menggunakan acuan tabel kriteria dampak 
kualitatif lainnya sesuai dengan pedoman masing-masing dan menyampaikannya dalam buku RKAP.</p>
                                '><i
                                class="ti ti-info-circle h5 text-secondary"></i>
                        </a>
                    @endif
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
                <div class="col-3">
                    <span>Nilai Probabilitas Residual {{ $isQuantitative ? 'Kuantitatif' : 'Kualitatif' }} <i
                            class="text-danger">*</i></span>
                    <a tabindex="0"
                        class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                        role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                        title="Information" data-bs-html="true"
                        data-bs-content='<img class="w-100" src="{{ asset('assets/images/pendukung/tabel_probabilitas.png') }}"/>
                            '><i
                            class="ti ti-info-circle h5 text-secondary"></i>
                    </a>
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
                <div class="col-3"><span>Efektifitas Perlakuan Risiko <i class="text-danger">*</i></span></div>
                <div class="col">
                    <select class="form-select w-100" name="risk_mitigation_effectiveness">
                        <option value="">Pilih</option>
                        <option value="0">Tidak Efektif</option>
                        <option value="1">Efektif</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>
