<div class="row mt-2">
    <div class="col py-2" style="overflow-x: scroll;">
        <table id="residualTable" class="table table-stripped table-bordered w-100">
            <thead class="table-dark">
                <tr>
                    <th rowspan="2">No. Risiko</th>
                    <th rowspan="2">Peristiwa Risiko</th>
                    <th rowspan="2">No. Penyebab Risiko</th>
                    <th rowspan="2">Penyebab Risiko</th>
                    <th rowspan="2">Asumsi Perhitungan Dampak</th>
                    <th colspan="4">Nilai Dampak</th>
                    <th colspan="4">Skala Dampak</th>
                    <th colspan="4">Nilai Probabilitas</th>
                    <th colspan="4">Skala Probabilitas </th>
                    <th colspan="4">Nilai Eksposur Risiko</th>
                    <th colspan="4">Skala Nilai Risiko</th>
                    <th colspan="4">Level Risiko</th>
                    <th rowspan="2">Efektifitas Perlakuan Risiko</th>
                </tr>
                <tr>
                    @for ($i = 0; $i < 7; $i++)
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q4</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @isset($monitoring)
                    @foreach ($monitoring->residuals as $residual)
                        <tr>
                            <td>{{ $worksheet->worksheet_number }}</td>
                            <td>{!! html_entity_decode($worksheet->target?->identification?->inherent?->body) !!}</td>
                            <td>{{ $residual->incident->risk_cause_number }}</td>
                            <td>{!! html_entity_decode($residual->incident->risk_chronology_body) !!}</td>
                            <td>{{ $residual->quarter }}</td>
                            @for ($i = 1; $i <= 4; $i++)
                                @if ($i == $residual->quarter)
                                    <td>{{ $residual?->impact_value ? money_format((int) $residual->impact_value) : '-' }}
                                    </td>
                                @else
                                    <td>-</td>
                                @endif
                            @endfor
                            @for ($i = 1; $i <= 4; $i++)
                                @if ($i == $residual->quarter)
                                    <td>{{ $residual->impact_scale?->scale }}</td>
                                @else
                                    <td>-</td>
                                @endif
                            @endfor
                            @for ($i = 1; $i <= 4; $i++)
                                @if ($i == $residual->quarter)
                                    <td>{{ $residual->impact_probability }}</td>
                                @else
                                    <td>-</td>
                                @endif
                            @endfor
                            @for ($i = 1; $i <= 4; $i++)
                                @if ($i == $residual->quarter)
                                    <td>{{ $residual->impact_probability_scale?->risk_scale }}</td>
                                @else
                                    <td>-</td>
                                @endif
                            @endfor
                            @for ($i = 1; $i <= 4; $i++)
                                @if ($i == $residual->quarter)
                                    <td>{{ $residual?->risk_exposure ? money_format((int) $residual->risk_exposure) : '-' }}
                                    </td>
                                @else
                                    <td>-</td>
                                @endif
                            @endfor
                            @for ($i = 1; $i <= 4; $i++)
                                @if ($i == $residual->quarter)
                                    <td>{{ $residual->risk_scale }}</td>
                                @else
                                    <td>-</td>
                                @endif
                            @endfor
                            @for ($i = 1; $i <= 4; $i++)
                                @if ($i == $residual->quarter)
                                    <td>{{ $residual->risk_level }}</td>
                                @else
                                    <td>-</td>
                                @endif
                            @endfor
                            <td>{{ $residual->risk_mitigation_effectiveness ? 'Ya' : 'Tidak' }}</td>
                    @endforeach
                @endisset

            </tbody>
        </table>

    </div>
</div>
