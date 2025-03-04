<div class="row mt-2">
    <div class="col py-2" style="overflow-x: scroll;">
        <table id="residualTable" class="table table-stripped table-bordered w-100">
            <thead class="table-dark">
                <tr>
                    <th rowspan="2">No. Risiko</th>
                    <th rowspan="2">Peristiwa Risiko</th>
                    <th rowspan="2">Asumsi Perhitungan Dampak</th>
                    <th rowspan="2">Kuartal</th>
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
                    <tr>
                        <td>{{ $worksheet->worksheet_number }}</td>
                        <td>{!! html_entity_decode($worksheet->identification->risk_chronology_body) !!}</td>
                        <td>{!! html_entity_decode($worksheet->identification->inherent_body) !!}</td>
                        <td>{{ $monitoring->residual->quarter }}</td>
                        @for ($i = 1; $i <= 4; $i++)
                            @if ($i == $monitoring->residual->quarter)
                                <td>{{ $monitoring->residual?->impact_value ? money_format((float) $monitoring->residual->impact_value) : '-' }}
                                </td>
                            @else
                                <td>-</td>
                            @endif
                        @endfor
                        @for ($i = 1; $i <= 4; $i++)
                            @if ($i == $monitoring->residual->quarter)
                                <td>{{ $monitoring->residual->impact_scale?->scale }}</td>
                            @else
                                <td>-</td>
                            @endif
                        @endfor
                        @for ($i = 1; $i <= 4; $i++)
                            @if ($i == $monitoring->residual->quarter)
                                <td>{{ $monitoring->residual->impact_probability }}</td>
                            @else
                                <td>-</td>
                            @endif
                        @endfor
                        @for ($i = 1; $i <= 4; $i++)
                            @if ($i == $monitoring->residual->quarter)
                                <td>{{ $monitoring->residual->impact_probability_scale?->impact_probability }}</td>
                            @else
                                <td>-</td>
                            @endif
                        @endfor
                        @for ($i = 1; $i <= 4; $i++)
                            @if ($i == $monitoring->residual->quarter)
                                <td>{{ $monitoring->residual?->risk_exposure ? money_format((float) $monitoring->residual->risk_exposure) : '-' }}
                                </td>
                            @else
                                <td>-</td>
                            @endif
                        @endfor
                        @for ($i = 1; $i <= 4; $i++)
                            @if ($i == $monitoring->residual->quarter)
                                <td>{{ $monitoring->residual?->impact_probability_scale?->risk_scale }}</td>
                            @else
                                <td>-</td>
                            @endif
                        @endfor
                        @for ($i = 1; $i <= 4; $i++)
                            @if ($i == $monitoring->residual->quarter)
                                <td><x-heatmap-badge :color="$monitoring->residual?->impact_probability_scale?->color" :label="$monitoring->residual?->impact_probability_scale?->risk_level" />
                                </td>
                            @else
                                <td>-</td>
                            @endif
                        @endfor
                        <td>{{ $monitoring->residual->risk_mitigation_effectiveness ? 'Ya' : 'Tidak' }}</td>
                    @endisset

            </tbody>
        </table>

    </div>
</div>
