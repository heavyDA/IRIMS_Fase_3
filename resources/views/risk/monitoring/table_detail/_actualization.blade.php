<div class="row mt-2">
    <div class="col py-2" style="overflow-x: scroll;">
        <table id="actualizationTable" class="table table-stripped table-bordered w-100">
            <thead class="table-dark">
                <tr>
                    <th rowspan="2" style="width: 100px;">No. Penyebab Risiko</th>
                    <th rowspan="2" style="width: 240px !important;">Penyebab Risiko</th>
                    <th rowspan="2" style="width: 240px !important;">Rencana Perlakuan Risiko</th>
                    <th rowspan="2" style="width: 140px !important;">Biaya Mitigasi</th>
                    <th rowspan="2" style="width: 240px !important;">Realisasi Perlakuan Risiko</th>
                    <th rowspan="2" style="width: 240px !important;">Realisasi Output atas masing-masing Breakdown
                        Perlakuan
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
                    <th rowspan="2">Progress Pelaksanaan Rencana Perlakuan Risiko</th>
                    <th rowspan="2">Dokumen Pendukung</th>
                </tr>
                <tr>
                    @for ($i = 1; $i <= 12; $i++)
                        <th>{{ $i }}</th>
                    @endfor
                    <th>Threshold</th>
                    <th>Skor</th>
                </tr>
            </thead>
            <tbody>
                @isset($monitoring)
                    @foreach ($monitoring->actualizations as $actualization)
                        <tr>
                            <td>{{ $actualization->mitigation->incident->risk_cause_number }}</td>
                            <td>{!! html_entity_decode($actualization->mitigation->incident->risk_cause_body) !!}</td>
                            <td>{!! html_entity_decode($actualization->mitigation->mitigation_plan) !!}</td>
                            <td>{{ money_format((float) $actualization->mitigation->mitigation_cost ?? 0) }}</td>
                            <td>{!! html_entity_decode($actualization->actualization_plan_body) !!}</td>
                            <td>{!! html_entity_decode($actualization->actualization_plan_output) !!}</td>
                            <td>{{ money_format((float) $actualization->actualization_cost ?? 0) }}</td>
                            <td>{{ $actualization->actualization_cost_absorption ? $actualization->actualization_cost_absorption . '%' : '' }}
                            </td>
                            <td>{{ $actualization->mitigation->mitigation_pic }}</td>
                            @if ($actualization->unit_code)
                                <td>[{{ $actualization->personnel_area_code }}] {{ $actualization->position_name }}</td>
                            @else
                                <td></td>
                            @endif
                            @for ($i = 1; $i <= 12; $i++)
                                @if ($monitoringMonths[$i - 1] ?? false)
                                    <td class="bg-success">1</td>
                                @else
                                    <td>0</td>
                                @endif
                            @endfor
                            <td>{{ $actualization->mitigation->incident->kri_body }}</td>
                            <td>
                                @if ($actualization->kri_threshold)
                                    <x-badge :color="$actualization->kri_threshold_color" :label="ucwords($actualization->kri_threshold)" />
                                @endif
                            </td>
                            <td>
                                {{ $actualization->kri_threshold_score }}
                            </td>
                            <td>{{ $actualization->actualization_plan_status }}</td>
                            <td>{!! html_entity_decode($actualization->actualization_plan_explanation) !!}</td>
                            <td>
                                {{ $actualization->actualization_plan_progress ? $actualization->actualization_plan_progress . '%' : '0%' }}
                            </td>
                            @if ($actualization->documents)
                                <td>
                                    <div class="d-flex flex-column gap-2">
                                        @foreach ($actualization->documents as $document)
                                            <a style="max-width: 164px;" class="badge bg-success-transparent text-truncate"
                                                target="_blank"
                                                href="{{ route('file.serve', $document['url']) }}">{{ $document['name'] }}</a>
                                        @endforeach
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
    </div>
</div>
