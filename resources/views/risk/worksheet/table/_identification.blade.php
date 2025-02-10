<div class="table-container" style="height: 40vh;">
    <table id="identificationTable" class="table table-bordered table-hover" style="width: 100%;">
        <thead class="table-dark" style="position: sticky;top: 0;">
            <tr style="vertical-align: bottom;">
                <th class="freeze" style="width: 180px" rowspan="3">Nama Perusahaan</th>
                <th rowspan="3">Kode Perusahaan</th>
                <th style="width: 180px" rowspan="3">Sasaran Perusahaan</th>
                <th rowspan="3">Kategori Risiko T2 & T3</th>
                <th style="width: 320px" rowspan="3">Peristiwa Risiko</th>
                <th style="width: 320px" rowspan="3">Deskripsi Peristiwa Risiko</th>
                <th rowspan="3">No. Penyebab Risiko</th>
                <th rowspan="3">Kode Penyebab risiko</th>
                <th style="width: 320px" rowspan="3">Penyebab risiko</th>
                <th style="width: 320px" rowspan="3">Key Risk Indicators</th>
                <th rowspan="3">Unit Satuan KRI</th>
                <th colspan="3">Kategori Threshold KRI</th>
                <th rowspan="3">Jenis Existing Control</th>
                <th rowspan="3">Existing Control</th>
                <th style="width: 320px" rowspan="3">Penilaian Efektivitas Kontrol</th>
                <th rowspan="3">Kategori Dampak</th>
                <th style="width: 320px" rowspan="3">Deskripsi Dampak</th>
                <th rowspan="3">Perkiraan Waktu Terpapar Risiko</th>
                <th colspan="8">Risiko Inheren</th>
                <th colspan="28">Target Risiko Residual</th>
            </tr>
            <tr style="vertical-align: bottom;">
                <th rowspan="2">Aman</th>
                <th rowspan="2">Hati-Hati</th>
                <th rowspan="2">Bahaya</th>
                <th rowspan="2">Asumsi Perhitungan Dampak</th>
                <th rowspan="2">Nilai Dampak</th>
                <th rowspan="2">Skala Dampak</th>
                <th rowspan="2">Nilai Probabilitas (%)</th>
                <th rowspan="2">Skala Probabilitas</th>
                <th rowspan="2">Eksposur Risiko</th>
                <th rowspan="2">Skala Risiko</th>
                <th rowspan="2">Level Risiko</th>
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
                @foreach ($worksheet->incidents as $incident)
                    <tr>
                        <td class="col-width-180 freeze">{{ $worksheet->company_name }}</td>
                        <td>{{ $worksheet->company_code }}</td>
                        <td>{!! html_entity_decode($worksheet->target_body) !!}</td>
                        <td>
                            {{ $worksheet->identification->risk_category_t2_name . ' & ' . $worksheet->identification->risk_category_t3_name }}
                        </td>
                        <td>{!! html_entity_decode($worksheet->identification->risk_chronology_body) !!}</td>
                        <td>{!! html_entity_decode($worksheet->identification->risk_chronology_description) !!}</td>
                        <td>{{ $incident->risk_cause_number }}</td>
                        <td>{{ $incident->risk_cause_code }}</td>
                        <td>{!! html_entity_decode($incident->risk_cause_body) !!}</td>
                        <td>{{ $incident->kri_body }}</td>
                        <td>{{ $incident?->kri_unit?->name }}</td>
                        <td>{{ $incident?->kri_threshold_safe }}</td>
                        <td>{{ $incident?->kri_threshold_caution }}</td>
                        <td>{{ $incident?->kri_threshold_danger }}</td>
                        <td>{{ $worksheet->identification->existing_control_type_name }}</td>
                        <td>{!! html_entity_decode($worksheet->identification->existing_control_body) !!}</td>
                        <td>{{ $worksheet->identification->control_effectiveness_assessment_name }}</td>
                        <td>{{ $worksheet->identification->risk_impact_category }}</td>
                        <td>{!! html_entity_decode($worksheet->identification->risk_impact_body) !!}</td>
                        <td>{{ format_date($worksheet->identification->risk_impact_start_date)->translatedFormat('d F Y') . ' s.d. ' . format_date($worksheet->identification->risk_impact_end_date)->translatedFormat('d F Y') }}
                        </td>
                        <td>{!! html_entity_decode($worksheet->identification->inherent_body) !!}</td>
                        <td>
                            @if ($worksheet->identification->inherent_impact_value)
                                Rp.{{ number_format((float) $worksheet->identification->inherent_impact_value, 2, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $worksheet->identification->inherent_impact_scale }}</td>
                        <td>{{ $worksheet->identification->inherent_impact_probability }}</td>
                        <td>{{ $worksheet->identification->inherent_impact_probability_scale }}
                        </td>
                        <td>Rp.{{ number_format((float) $worksheet->identification->inherent_risk_exposure, 2, ',', '.') }}
                        </td>
                        <td>{{ $worksheet->identification->inherent_risk_scale }}
                        </td>
                        <td>{{ $worksheet->identification->inherent_risk_level }}
                        </td>
                        @foreach (['impact_value', 'impact_scale', 'impact_probability', 'impact_probability_scale', 'risk_exposure', 'risk_scale', 'risk_level'] as $key)
                            @php
                                for ($i = 1; $i <= 4; $i++) {
                                    $property = "residual_{$i}_{$key}";
                                    $value = $worksheet->identification->$property;
                                    if ($value) {
                                        if (in_array($key, ['impact_value', 'risk_exposure'])) {
                                            echo '<td>' . money_format((float) $value) . '</td>';
                                        } else {
                                            echo "<td>{$value}</td>";
                                        }
                                    } else {
                                        echo '<td>-</td>';
                                    }
                                }
                            @endphp
                        @endforeach
                    </tr>
                @endforeach
            @endisset
        </tbody>
    </table>
</div>
