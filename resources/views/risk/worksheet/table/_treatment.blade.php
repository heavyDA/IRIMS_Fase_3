<div>
    <table id="treatmentTable" class="table table-bordered table-hover" style="width:100%">
        <thead class="table-dark">
            <tr style="vertical-align: bottom;">
                <th class="table-dark-custom" style="text-align: center !important;">No. Risiko</th>
                <th class="table-dark-custom" style="text-align: center !important;">No. Penyebab Risiko</th>
                <th class="table-dark-custom" style="text-align: center !important;">Penyebab Risiko</th>
                <th class="table-dark-custom" style="text-align: center !important;">Opsi Perlakuan Risiko</th>
                <th class="table-dark-custom" style="text-align: center !important;">Jenis Rencana Perlakuan Risiko</th>
                <th class="table-dark-custom" style="text-align: center !important;">Rencana Perlakuan Risiko</th>
                <th class="table-dark-custom" style="text-align: center !important;">Ouput Perlakuan Risiko</th>
                <th class="table-dark-custom" style="text-align: center !important;">Tanggal Mulai</th>
                <th class="table-dark-custom" style="text-align: center !important;">Tanggal Selesai</th>
                <th class="table-dark-custom" style="text-align: center !important;">Biaya Mitigasi</th>
                <th class="table-dark-custom" style="text-align: center !important;">Jenis Program Dalam RKAP</th>
                <th class="table-dark-custom" style="text-align: center !important;">PIC (Unit Kerja)</th>
            </tr>
        </thead>
        <tbody>
            @isset($worksheet)
                @forelse ($worksheet->incidents as $incident)
                    @foreach ($incident->mitigations as $mitigation)
                        <tr>
                            <td>{{ $worksheet->worksheet_number }}</td>
                            <td>{{ $incident->risk_cause_number }}</td>
                            <td>{!! html_entity_decode($incident->risk_cause_body) !!}</td>
                            <td>{{ $mitigation?->risk_treatment_option?->name }}</td>
                            <td>{{ $mitigation?->risk_treatment_type?->name }}</td>
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
