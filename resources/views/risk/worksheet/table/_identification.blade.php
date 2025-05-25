<div>
    <table id="identificationTable" class="table table-bordered table-hover" style="width: 100%;">
        <thead class="table-dark">
            <tr style="vertical-align: bottom;">
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Nama Perusahaan</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Kode Perusahaan</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Sasaran Perusahaan
                </th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Kategori Risiko T2 &
                    T3</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Peristiwa Risiko</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Deskripsi Peristiwa
                    Risiko</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">No. Penyebab Risiko
                </th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Kode Penyebab Risiko
                </th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Penyebab Risiko</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Key Risk Indicators
                </th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Unit Satuan KRI</th>
                <th class="table-dark-custom" style="text-align:center !important;" colspan="3">Kategori Threshold
                    KRI</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Jenis Existing
                    Control</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Existing Control</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Penilaian Efektivitas
                    Kontrol</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Kategori Dampak</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Deskripsi Dampak</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Perkiraan Waktu
                    Terpapar Risiko</th>
                <th class="table-dark-custom" style="text-align:center !important;" colspan="8">Risiko Inheren</th>
                <th class="table-dark-custom" style="text-align:center !important;" colspan="28">Target Risiko
                    Residual</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="3">Kualifikasi Risiko
                </th>
            </tr>
            <tr style="vertical-align: bottom;">
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="2">Aman</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="2">Hati-Hati</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="2">Bahaya</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="2">Asumsi Perhitungan
                    Dampak</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="2">Nilai Dampak</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="2">Skala Dampak</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="2">Nilai Probabilitas
                    (%)</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="2">Skala Probabilitas
                </th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="2">Eksposur Risiko</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="2">Skala Risiko</th>
                <th class="table-dark-custom" style="text-align:center !important;" rowspan="2">Level Risiko</th>
                <th class="table-dark-custom" style="text-align:center !important;" colspan="4">Nilai Dampak</th>
                <th class="table-dark-custom" style="text-align:center !important;" colspan="4">Skala Dampak</th>
                <th class="table-dark-custom" style="text-align:center !important;" colspan="4">Nilai Probabilitas
                    (%)</th>
                <th class="table-dark-custom" style="text-align:center !important;" colspan="4">Skala Probabilitas
                </th>
                <th class="table-dark-custom" style="text-align:center !important;" colspan="4">Eksposur Risiko
                </th>
                <th class="table-dark-custom" style="text-align:center !important;" colspan="4">Skala Risiko</th>
                <th class="table-dark-custom" style="text-align:center !important;" colspan="4">Level Risiko</th>
            </tr>
            <tr style="vertical-align: bottom;">
                @for ($i = 0; $i < 7; $i++)
                    @for ($q = 1; $q <= 4; $q++)
                        <th class="table-dark-custom" style="text-align:center !important;">Q{{ $q }}</th>
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
                        <td>{!! $worksheet->target_body !!}</td>
                        <td>
                            {{ $worksheet->identification->risk_category_t2_name . ' & ' . $worksheet->identification->risk_category_t3_name }}
                        </td>
                        <td>{!! $worksheet->identification->risk_chronology_body !!}</td>
                        <td>{!! $worksheet->identification->risk_chronology_description !!}</td>
                        <td>{{ $incident->risk_cause_number }}</td>
                        <td>{{ $incident->risk_cause_code }}</td>
                        <td>{!! $incident->risk_cause_body !!}</td>
                        <td>{!! $incident->kri_body !!}</td>
                        <td>{{ $incident?->kri_unit?->name }}</td>
                        <td>{!! $incident?->kri_threshold_safe !!}</td>
                        <td>{!! $incident?->kri_threshold_caution !!}</td>
                        <td>{!! $incident?->kri_threshold_danger !!}</td>
                        <td>{{ $worksheet->identification->existing_control_type_name }}</td>
                        <td>{!! $worksheet->identification->existing_control_body !!}</td>
                        <td>{{ $worksheet->identification->control_effectiveness_assessment_name }}</td>
                        <td>{{ $worksheet->identification->risk_impact_category }}</td>
                        <td>{!! $worksheet->identification->risk_impact_body !!}</td>
                        <td>{{ format_date($worksheet->identification->risk_impact_start_date)->translatedFormat('d F Y') . ' s.d. ' . format_date($worksheet->identification->risk_impact_end_date)->translatedFormat('d F Y') }}
                        </td>
                        <td>{!! $worksheet->identification->inherent_body !!}</td>
                        <td>
                            @if ($worksheet->identification->inherent_impact_value)
                                Rp.{{ number_format((float) $worksheet->identification->inherent_impact_value, 2, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $worksheet->identification->inherent_impact_scale }}</td>
                        <td>{{ $worksheet->identification->inherent_impact_probability }}</td>
                        <td>{{ $worksheet->identification->inherent_impact_probability_probability_scale }}
                        </td>
                        <td>Rp.{{ number_format((float) $worksheet->identification->inherent_risk_exposure, 2, ',', '.') }}
                        </td>
                        <td>{{ $worksheet->identification->inherent_impact_probability_scale }}
                        </td>
                        <td data-color="{{ $worksheet->identification->inherent_impact_probability_color }}">
                            {{ $worksheet->identification->inherent_risk_level }}
                        </td>
                        @foreach (['impact_value', 'impact_scale', 'impact_probability', 'impact_probability_probability_scale', 'risk_exposure', 'risk_scale', 'risk_level'] as $key)
                            @php
                                for ($i = 1; $i <= 4; $i++) {
                                    $property = "residual_{$i}_{$key}";
                                    $value = $worksheet->identification->$property;
                                    $color = '';

                                    if ($key == 'risk_level') {
                                        $property = "residual_{$i}_impact_probability_color";
                                        $color = 'data-color="' . $worksheet->identification->$property . '"';
                                    }

                                    if ($value) {
                                        if (in_array($key, ['impact_value', 'risk_exposure'])) {
                                            echo '<td>' . money_format((float) $value) . '</td>';
                                        } else {
                                            echo "<td {$color}>{$value}</td>";
                                        }
                                    } else {
                                        echo "<td {$color}>-</td>";
                                    }
                                }
                            @endphp
                        @endforeach
                        <td>{{ $worksheet?->qualification?->name ?? '' }}</td>
                    </tr>
                @endforeach
            @endisset
        </tbody>
    </table>
</div>
