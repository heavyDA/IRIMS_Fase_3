<table id="contextTable" class="table table-bordered table-stripped" style="width:100%">
    <thead class="table-dark">
        <tr>
            <th style="width: 240px;">Pilihan Sasaran</th>
            <th style="width: 240px;">Pilihan Strategi</th>
            <th style="width: 240px;">Hasil yang diharapkan dapat diterima perusahaan</th>
            <th style="width: 240px;">Nilai Risiko Yang Akan Timbul</th>
            <th style="width: 240px;">Nilai limit risiko sesuai dengan parameter risiko dalam Metrik
                Strategi Risiko</th>
            <th style="width: 100px;">Keputusan Penetapan</th>
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
