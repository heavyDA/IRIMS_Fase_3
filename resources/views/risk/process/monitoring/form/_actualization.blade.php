<div class="row">
    <div class="col overflow-x-scroll">
        <table id="actualizationFormTable" class="table table-stripped table-bordered w-100">
            <thead class="table-dark">
                <tr>
                    <th rowspan="2">Aksi</th>
                    <th rowspan="2" style="width: 100px;">No. Penyebab Risiko</th>
                    <th rowspan="2" style="width: 240px;">Rencana Perlakuan Risiko</th>
                    <th rowspan="2" style="width: 240px;">Realisasi Perlakuan Risiko</th>
                    <th rowspan="2" style="width: 240px;">Realisasi Output Perlakuan Risiko</th>
                    <th rowspan="2" style="width: 140px;">Realisasi Biaya Perlakuan Risiko</th>
                    <th rowspan="2" style="width: 100px;">Presentase Serapan Biaya</th>
                    <th rowspan="2" style="width: 180px;">PIC</th>
                    <th rowspan="2" style="width: 180px;">PIC Terkait</th>
                    <th rowspan="2" style="width: 180px;">Key Risk Indicators</th>
                    <th colspan="2" style="width: 180px;">Realisasi KRI Threshold</th>
                    <th rowspan="2" style="width: 100px;">Status Rencana Perlakuan Risiko</th>
                    <th rowspan="2">Penjelasan Status Rencana Perlakuan Risiko</th>
                    <th colspan="4">Progress Pelaksanaan Rencana Perlakuan Risiko</th>
                </tr>
                <tr>
                    <th>Threshold</th>
                    <th>Skor</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($worksheet->target->identification->incidents as $incident)
                    @foreach ($incident->mitigations as $key => $mitigation)
                        <tr>
                            <td>
                                <button id="actualization-{{ $key }}" type="button"
                                    class="actualization-button btn btn-sm btn-info-light">
                                    <span>
                                        <div class="ti ti-edit"></div>
                                    </span>
                                </button>
                            </td>
                            <td class="d-none" data-name="mitigation_id">{{ $mitigation->id }}</td>
                            <td class="d-none" data-name="quarter">{{ ceil((int) date('m') / 4) }}</td>
                            <td data-name="risk_cause_number">{{ $incident->risk_cause_number }}</td>
                            <td data-name="actualization_mitigation_plan">{!! html_entity_decode($mitigation->mitigation_plan) !!}</td>
                            <td data-name="actualization_plan_body"></td>
                            <td data-name="actualization_output"></td>
                            <td data-name="actualization_cost">Rp.0</td>
                            <td data-name="actualization_percentage" class="text-center">0</td>
                            <td data-name="actualization_pic">{{ $mitigation->mitigation_pic }}</td>
                            <td data-name="actualization_pic_related"></td>
                            <td data-name="actualization_kri"></td>
                            <td data-name="actualization_kri_threshold"></td>
                            <td data-name="actualization_kri_score"></td>
                            <td data-name="actualization_status"></td>
                            <td data-name="actualization_explanation"></td>
                            <td data-name="actualization_progress[1]"></td>
                            <td data-name="actualization_progress[2]"></td>
                            <td data-name="actualization_progress[3]"></td>
                            <td data-name="actualization_progress[4]"></td>
                        </tr>
                    @endforeach
                @endforeach --}}
            </tbody>
        </table>
    </div>
</div>


@push('element')
    <div class="modal fade" id="actualizationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 100% !important;">
            <div class="modal-content mx-auto" style="width: 80vw !important">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Pilihan Strategi Bisnis</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="actualizationForm">
                        <input type="hidden" name="id">
                        <input type="hidden" name="key">
                        <input type="hidden" name="quarter">
                        <input type="hidden" name="actualization_mitigation_id">
                        <div class="row mb-2">
                            <div class="col-3">
                                No. Penyeybab Risiko
                            </div>
                            <div class="col">
                                <input type="text" disabled class="not-allowed form-control" name="risk_cause_number">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                Rencana Perlakuan Risiko
                            </div>
                            <div class="col">
                                <div id="actualization_mitigation_plan-editor" class="textarea"></div>
                                <textarea class="form-control d-none" name="actualization_mitigation_plan" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                Realisasi Perlakuan Risiko<span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <div id="actualization_plan_body-editor" class="textarea"></div>
                                <textarea class="form-control d-none" name="actualization_plan_body" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                Realisasi Output Perlakuan Risiko<span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <div id="actualization_plan_output-editor" class="textarea"></div>
                                <textarea class="form-control d-none" name="actualization_plan_output" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                Dokumen Pendukung<span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <input type="file" class="form-control" name="actualization_document">
                                <div id="actualization_document_wrapper" class="row d-none gap-2 mt-1 px-4"></div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                Realisasi Biaya Perlakuan Risiko<span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="actualization_cost">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                Presentase Serapan Biaya<span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <input type="number" max=100 class="form-control" name="actualization_cost_absorption">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                PIC
                            </div>
                            <div class="col">
                                <input type="text" class="form-control not-allowed" disabled name="actualization_pic">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                PIC Terkait
                            </div>
                            <div class="col">
                                <select name="actualization_pic_related" class="form-select">
                                    <option>Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                Key Risk Indicators<span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control not-allowed" disabled name="actualization_kri">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                Kategori Threshold KRI<span class="text-danger">*</span>
                            </div>
                            <div class="col row">
                                <div class="col">
                                    <label class="badge bg-success">Threshold</label>
                                    <select name="actualization_kri_threshold" class="form-select">
                                        <option>Pilih</option>
                                        <option value="hijau">hijau</option>
                                        <option value="kuning">kuning</option>
                                        <option value="merah">merah</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="badge bg-secondary">Skor</label>
                                    <input type="number" class="form-control" name="actualization_kri_threshold_score">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                Status Rencana Perlakuan Risiko<span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <select name="actualization_plan_status" class="form-select">
                                    <option>Pilih</option>
                                    <option value="discontinue">Discontinue</option>
                                    <option value="continue">Continue</option>
                                    <option value="revisi">Revisi</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                Penjelasan Status Rencana Perlakuan<span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <div id="actualization_plan_explanation-editor" class="textarea"></div>
                                <textarea class="form-control d-none" name="actualization_plan_explanation" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3">
                                Progress Pelaksanaan Rencana Perlakuan<span class="text-danger">*</span>
                            </div>
                            <div class="col row">
                                @for ($i = 1; $i <= 4; $i++)
                                    <div class="col">
                                        <label
                                            for="actualization_plan_progress[{{ $i }}]">Q{{ $i }}</label>
                                        <input type="number" class="form-control not-allowed"
                                            name="actualization_plan_progress[{{ $i }}]" disabled>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" form="actualizationForm">Batal</button>
                    <button type="submit" form="actualizationForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endpush
