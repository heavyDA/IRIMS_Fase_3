<div class="row mt-2">
    <div class="col py-2" style="overflow-x: scroll;">
        <table id="alterationTable" class="table table-stripped table-bordered w-100">
            <thead class="table-dark">
                <tr>
                    <th>Nama Kejadian</th>
                    <th>Identifikasi Kejadian</th>
                    <th>Kategori Kejadian</th>
                    <th>Sumber Penyebab Kejadian</th>
                    <th>Penyebab Kejadian</th>
                    <th>Penanganan Saat Kejadian</th>
                    <th>Deskripsi Kejadian - Risk Event</th>
                    <th>Kategori Risiko T2 & T3</th>
                    <th>Penjelasan Kerugian</th>
                    <th>Nilai Kerugian</th>
                    <th>Kejadian Berulang</th>
                    <th>Frekuensi Kejadian</th>
                    <th>Mitigasi yang Direncanakan</th>
                    <th>Realisasi Mitigasi</th>
                    <th>Perbaikan Mendatang</th>
                    <th>Pihak Terkait</th>
                    <th>Status Asuransi</th>
                    <th>Nilai Premi</th>
                    <th>Nilai Klaim</th>
                </tr>
            </thead>
            <tbody>
                @isset($monitoring)
                    <tr>
                        <td>{!! html_entity_decode($monitoring->incident->incident_body) !!}</td>
                        <td>{!! html_entity_decode($monitoring->incident->incident_identification) !!}</td>
                        <td>{{ $monitoring->incident?->incident_category?->name }}</td>
                        <td>{{ $monitoring->incident->incident_source }}</td>
                        <td>{!! html_entity_decode($monitoring->incident->incident_cause) !!}</td>
                        <td>{!! html_entity_decode($monitoring->incident->incident_handling) !!}</td>
                        <td>{!! html_entity_decode($monitoring->incident->incident_description) !!}</td>
                        <td>{{ $monitoring->incident?->risk_category_t2?->name }} &
                            {{ $monitoring->incident?->risk_category_t3?->name }}</td>
                        <td>{!! html_entity_decode($monitoring->incident->loss_description) !!}</td>
                        <td>{{ $monitoring->incident->loss_value ? money_format((float) $monitoring->incident->loss_value) : '' }}
                        </td>
                        <td>{{ $monitoring->incident->incident_repetitive ? 'Ya' : 'Tidak' }}</td>
                        <td>{{ $monitoring->incident?->incident_frequency?->name }}</td>
                        <td>{!! html_entity_decode($monitoring->incident->mitigation_plan) !!}</td>
                        <td>{!! html_entity_decode($monitoring->incident->actualization_plan) !!}</td>
                        <td>{!! html_entity_decode($monitoring->incident->follow_up_plan) !!}</td>
                        <td>{!! html_entity_decode($monitoring->incident->related_party) !!}</td>
                        <td>{{ $monitoring->incident->insurance_status ? 'Ya' : 'Tidak' }}</td>
                        <td>{{ $monitoring->incident->insurance_permit ? money_format((float) $monitoring->incident->insurance_permit) : '' }}
                        </td>
                        <td>{{ $monitoring->incident->insurance_claim ? money_format((float) $monitoring->incident->insurance_claim) : '' }}
                        </td>
                    </tr>
                @endisset
            </tbody>
        </table>
    </div>
</div>
