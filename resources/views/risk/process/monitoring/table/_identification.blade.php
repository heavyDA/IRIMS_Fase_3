    <div class="row mt-2">
        <div class="col py-2" style="overflow-x: scroll;">
            <table id="identificationTable" class="table table-bordered table-stripped" style="width:100%">
                <thead class="table-dark">
                    <tr style="vertical-align: bottom;">
                        <th rowspan="3">Nama Perusahaan</th>
                        <th rowspan="3">Kode Perusahaan</th>
                        <th rowspan="3">Sasaran Perusahaan</th>
                        <th rowspan="3">Kategori Risiko T2 & T3</th>
                        <th style="width: 220px !important;" rowspan="3">Peristiwa Risiko</th>
                        <th style="width: 220px !important;" rowspan="3">Deskripsi Peristiwa Risiko</th>
                        <th style="" rowspan="3">No. Penyebab Risiko</th>
                        <th style="" rowspan="3">Kode Penyebab risiko</th>
                        <th style="width: 220px !important;" rowspan="3">Penyebab risiko</th>
                        <th style="" rowspan="3">Key Risk Indicators</th>
                        <th style="" rowspan="3">Unit Satuan KRI</th>
                        <th style="" colspan="3">Kategori Threshold KRI</th>
                        <th style="" rowspan="3">Jenis Existing Control</th>
                        <th style="" rowspan="3">Existing Control</th>
                        <th style="" rowspan="3">Penilaian Efektivitas Kontrol</th>
                        <th style="" rowspan="3">Kategori Dampak</th>
                        <th style="" rowspan="3">Deskripsi Dampak</th>
                        <th style="" rowspan="3">Perkiraan Waktu Terpapar Risiko</th>
                        <th style="" colspan="8">Risiko Inheren</th>
                        <th style="" colspan="28">Target Risiko Residual</th>
                    </tr>
                    <tr style="vertical-align: bottom;">
                        <th rowspan="2">Aman</th>
                        <th rowspan="2">Hati-Hati</th>
                        <th rowspan="2">Bahaya</th>
                        <th rowspan="2" style="">Asumsi Perhitungan Dampak</th>
                        <th rowspan="2" style="">Nilai Dampak</th>
                        <th rowspan="2" style="">Skala Dampak</th>
                        <th rowspan="2" style="">Nilai Probabilitas (%)</th>
                        <th rowspan="2" style="">Skala Probabilitas</th>
                        <th rowspan="2" style="">Eksposur Risiko</th>
                        <th rowspan="2" style="">Skala Risiko</th>
                        <th rowspan="2" style="">Level Risiko</th>
                        <th colspan="4">Nilai Dampak</th>
                        <th colspan="4">Skala Dampak</th>
                        <th colspan="4">Nilai Probabilitas (%)</th>
                        <th colspan="4">Skala Probabilitas</th>
                        <th colspan="4">Eksposur Risiko</th>
                        <th colspan="4">Skala Risiko</th>
                        <th colspan="4">Level Risiko</th>
                    </tr>
                    <tr style="vertical-align: bottom;">
                        @for ($i = 0; $i < 7; $i++)
                            @for ($q = 1; $q <= 4; $q++)
                                <th>Q{{ $q }}</th>
                            @endfor
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @isset($worksheet)

                        @foreach ($worksheet->target->identification->incidents as $incident)
                            <tr>
                                <td>{{ $worksheet->unit_name }}</td>
                                <td>{{ $worksheet->unit_code }}</td>
                                <td>{!! html_entity_decode($worksheet->target->body) !!}</td>
                                <td>{{ $worksheet->target->identification->risk_category_t2->name . ' & ' . $worksheet->target->identification->risk_category_t3->name }}
                                </td>
                                <td>{!! html_entity_decode($incident->risk_chronology_body) !!}</td>
                                <td>{!! html_entity_decode($incident->risk_chronology_description) !!}</td>
                                <td>{{ $incident->risk_cause_number }}</td>
                                <td>{{ $incident->risk_cause_code }}</td>
                                <td>{!! html_entity_decode($incident->risk_cause_body) !!}</td>
                                <td>{{ $incident->kri_body }}</td>
                                <td>{{ $incident?->kri_unit?->name }}</td>
                                <td>{{ $incident?->kri_threshold_safe }}</td>
                                <td>{{ $incident?->kri_threshold_caution }}</td>
                                <td>{{ $incident?->kri_threshold_danger }}</td>
                                <td>{{ $worksheet->target->identification->existing_control_type->name }}</td>
                                <td>{!! html_entity_decode($worksheet->target->identification->existing_control_body) !!}</td>
                                <td>{{ $worksheet->target->identification->control_effectiveness_assessment->name }}</td>
                                <td>{{ $worksheet->target->identification->risk_impact_category }}</td>
                                <td>{!! html_entity_decode($worksheet->target->identification->risk_impact_body) !!}</td>
                                <td>{{ $worksheet->target->identification->format_risk_start_date->format('d F Y') . ' s.d. ' . $worksheet->target->identification->format_risk_end_date->format('d F Y') }}
                                </td>
                                <td>{!! html_entity_decode($worksheet->target->identification->inherent->body) !!}</td>
                                <td>Rp.{{ number_format((float) $worksheet->target->identification->inherent->impact_value, 2, ',', '.') }}
                                </td>
                                <td>{{ $worksheet->target->identification->inherent->impact_scale->scale }}</td>
                                <td>{{ $worksheet->target->identification->inherent->impact_probability }}</td>
                                <td>{{ $worksheet->target->identification->inherent->impact_probability_scale->impact_probability }}
                                </td>
                                <td>Rp.{{ number_format((float) $worksheet->target->identification->inherent->risk_exposure, 2, ',', '.') }}
                                </td>
                                <td>{{ $worksheet->target->identification->inherent->impact_probability_scale->risk_scale }}
                                </td>
                                <td>{{ $worksheet->target->identification->inherent->impact_probability_scale->risk_level }}
                                </td>
                                @for ($i = 0; $i < 7; $i++)
                                    @for ($j = 0; $j < count($worksheet->target->identification->residuals); $j++)
                                        @if ($i == 0 || $i == 4)
                                            <td>Rp.{{ number_format((float) $worksheet->target->identification->residuals[$j][$i], 2, ',', '.') }}
                                            </td>
                                        @else
                                            <td>{{ $worksheet->target->identification->residuals[$j][$i] }}</td>
                                        @endif
                                    @endfor
                                @endfor
                            </tr>
                        @endforeach
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
