    <div class="row mt-2">
        <div class="col" style="overflow-x: scroll;">
            <table class="table table-bordered table-stripped" style="width:100%">
                <thead class="table-dark">
                    <tr style="vertical-align: bottom;">
                        <th style="">No. Risiko</th>
                        <th style="">No. Penyebab Risiko</th>
                        <th style="">Penyebab Risiko</th>
                        <th style="">Opsi Perlakuan Risiko</th>
                        <th style="">Jenis Rencana Perlakuan Risiko</th>
                        <th style="">Rencana Perlakuan Risiko</th>
                        <th style="width: 220px !important;">Ouput Perlakuan Risiko</th>
                        <th style="">Tanggal Mulai</th>
                        <th style="">Tanggal Selesai</th>
                        <th style="">Biaya Mitigasi</th>
                        <th style="">Jenis Program Dalam RKAP</th>
                        <th style="">PIC (Unit Kerja)</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($worksheet)
                        @forelse ($worksheet->target->identification->incidents as $incident)
                            @foreach ($incident->mitigations as $mitigation)
                                <tr>
                                    <td>{{ $worksheet->worksheet_number }}</td>
                                    <td>{{ $incident->risk_cause_number }}</td>
                                    <td>{!! $incident->risk_chronology_body !!}</td>
                                    <td>{{ $mitigation->risk_treatment_option->name }}</td>
                                    <td>{{ $mitigation->risk_treatment_type->name }}</td>
                                    <td>{!! $mitigation->mitigation_plan !!}</td>
                                    <td>{!! $mitigation->mitigation_output !!}</td>
                                    <td>{{ $mitigation->format_start_date->format('d M Y') }}</td>
                                    <td>{{ $mitigation->format_end_date->format('d M Y ') }}</td>
                                    <td>Rp.{{ number_format((float) $mitigation->mitigation_cost, 2, ',', '.') }}</td>
                                    <td>{{ $mitigation->rkap_program_type->name }}</td>
                                    <td>{{ $mitigation->mitigation_pic }}</td>
                                </tr>
                            @endforeach
                        @empty
                        @endforelse
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
