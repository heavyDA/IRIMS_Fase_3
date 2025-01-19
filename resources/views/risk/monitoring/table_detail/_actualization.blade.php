<div class="row mt-2">
    <div class="col py-2" style="overflow-x: scroll;">
        <table id="actualizationTable" class="table table-stripped table-bordered w-100">
            <thead class="table-dark">
                <tr>
                    <th rowspan="2" style="width: 100px;">No. Penyebab Risiko</th>
                    <th rowspan="2" style="width: 240px;">Realisasi Perlakuan Risiko</th>
                    <th rowspan="2" style="width: 240px;">Realisasi Output atas masing-masing Breakdown Perlakuan
                        Risiko</th>
                    <th rowspan="2" style="width: 140px;">Realisasi Biaya Perlakuan Risiko</th>
                    <th rowspan="2" style="width: 100px;">Persentase Serapan Biaya</th>
                    <th rowspan="2" style="width: 180px;">PIC</th>
                    <th rowspan="2" style="width: 180px;">PIC Terkait</th>
                    <th colspan="12">Realisasi Timeline</th>
                    <th rowspan="2" style="width: 180px;">Key Risk Indicators</th>
                    <th colspan="2" style="width: 180px;">Realisasi KRI Threshold</th>
                    <th rowspan="2" style="width: 100px;">Status Rencana Perlakuan Risiko</th>
                    <th rowspan="2">Penjelasan Status Rencana Perlakuan Risiko</th>
                    <th colspan="4">Progress Pelaksanaan Rencana Perlakuan Risiko</th>
                </tr>
                <tr>
                    @for ($i = 1; $i <= 12; $i++)
                        <th>{{ $i }}</th>
                    @endfor
                    <th>Threshold</th>
                    <th>Skor</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                </tr>
            </thead>
            <tbody>
                @isset($monitoring)
                    @foreach ($monitoring->actualizations as $actualization)
                        <tr>
                            <td>{{ $actualization->mitigation->incident->risk_cause_number }}</td>
                            <td>{!! html_entity_decode($actualization->actualization_plan_body) !!}</td>
                            <td>{!! html_entity_decode($actualization->actualization_plan_output) !!}</td>
                            <td>{{ money_format((int) $actualization->actualization_cost ?? 0) }}</td>
                            <td>{{ $actualization->actualization_cost_absorption ? $actualization->actualization_cost_absorption . '%' : '' }}
                            </td>
                            <td>{{ $actualization->mitigation->mitigation_pic }}</td>
                            @if ($actualization->unit_code)
                                <td>[{{ $actualization->personnel_area_code }}] {{ $actualization->position_name }}</td>
                            @else
                                <td></td>
                            @endif
                            @for ($i = 1; $i <= 12; $i++)
                                @if ($monitoring->period_date_format->month == $i)
                                    <td>1</td>
                                @else
                                    <td>0</td>
                                @endif
                            @endfor
                            <td>{{ $actualization->mitigation->incident->kri_body }}</td>
                            <td>{{ $actualization->kri_threshold }}</td>
                            <td>{{ $actualization->kri_threshold_score ? $actualization->kri_threshold_score . '%' : '' }}
                            </td>
                            <td>{{ $actualization->actualization_plan_status }}</td>
                            <td>{!! html_entity_decode($actualization->actualization_plan_explanation) !!}</td>
                            @for ($i = 1; $i <= 4; $i++)
                                @if ($i == $actualization->quarter)
                                    <td>{{ $actualization->actualization_plan_progress ? $actualization->actualization_plan_progress . '%' : '' }}
                                    </td>
                                @else
                                    <td>-</td>
                                @endif
                            @endfor
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
    </div>
</div>
