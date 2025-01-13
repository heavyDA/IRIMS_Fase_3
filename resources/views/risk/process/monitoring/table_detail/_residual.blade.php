<div class="row mt-2">
    <div class="col py-2" style="overflow-x: scroll;">
        <table id="residualTable" class="table table-stripped table-bordered w-100">
            <thead class="table-dark">
                <tr>
                    <th rowspan="3">No Risiko</th>
                    <th rowspan="3">Peristiwa Risiko</th>
                    <th rowspan="3">Asumsi Perhitungan Dampak</th>
                    <th rowspan="2" colspan="4">Nilai Dampak</th>
                    <th colspan="8">Skala Dampak</th>
                    <th rowspan="2" colspan="4">Nilai Probabilitas</th>
                    <th colspan="8">Skala Probabilitas </th>
                    <th rowspan="2" colspan="4">Nilai Eksposur Risiko</th>
                    <th colspan="8">Skala Nilai Risiko</th>
                    <th colspan="8">Level Risiko</th>
                    <th rowspan="3">Efektifitas Perlakuan Risiko</th>
                </tr>
                <tr>
                    <th colspan="4">BUMN</th>
                    <th colspan="4">KBUMN</th>
                    <th colspan="4">BUMN</th>
                    <th colspan="4">KBUMN</th>
                    <th colspan="4">BUMN</th>
                    <th colspan="4">KBUMN</th>
                    <th colspan="4">BUMN</th>
                    <th colspan="4">KBUMN</th>
                </tr>
                <tr>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                </tr>
            </thead>
            <tbody>
                @isset($monitoring)

                    <tr>
                        <td>{{ $worksheet->worksheet_number }}</td>

                        <td>{!! html_entity_decode($worksheet->target?->identification?->inherent?->body) !!}</td>
                        @for ($i = 1; $i <= 4; $i++)
                            @if ($i == $monitoring->residual->quarter)
                                <td>{{ $monitoring->residual->impact_value }}</td>
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
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>

                    </tr>
                @endisset

            </tbody>
        </table>

    </div>
</div>
