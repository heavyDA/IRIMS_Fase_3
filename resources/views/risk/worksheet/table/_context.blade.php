<div class="table-container" style="height: 40vh;">
    <table id="contextTable" class="table table-bordered table-hover">
        <thead class="table-dark" style="position: sticky; top: 0;">
            <tr>
                <th>Pilihan Sasaran</th>
                <th>Pilihan Strategi</th>
                <th>Hasil yang diharapkan dapat diterima perusahaan</th>
                <th>Nilai Risiko Yang Akan Timbul</th>
                <th>Nilai limit risiko sesuai dengan parameter risiko dalam Metrik
                    Strategi Risiko</th>
                <th>Keputusan Penetapan</th>
            </tr>
        </thead>
        <tbody>
            @isset($worksheet)
                @foreach ($worksheet->strategies as $strategy)
                    <tr>
                        <td>{!! html_entity_decode($worksheet->target_body) !!}</td>
                        <td>{!! html_entity_decode($strategy->body) !!}</td>
                        <td>{!! html_entity_decode($strategy->expected_feedback) !!}</td>
                        <td>{!! html_entity_decode($strategy->risk_value) !!}</td>
                        <td>Rp.{{ number_format((float) $strategy->risk_value_limit, 2, ',', '.') }}</td>
                        <td>{{ ucwords($strategy->decision) }}</td>
                    </tr>
                @endforeach
            @endisset
        </tbody>
    </table>
</div>
