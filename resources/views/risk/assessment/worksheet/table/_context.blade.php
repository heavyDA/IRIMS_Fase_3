<div class="row mt-2">
    <div class="col py-2" style="overflow-x: scroll;">
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
                    @foreach ($worksheet->target->strategies as $strategy)
                        <tr>
                            <td>{!! html_entity_decode($worksheet->target->body) !!}</td>
                            <td>{!! $strategy->body !!}</td>
                            <td>{!! $strategy->expected_feedback !!}</td>
                            <td>{!! $strategy->risk_value !!}</td>
                            <td>Rp.{{ number_format((int) $strategy->risk_value_limit, 2, ',', '.') }}</td>
                            <td>{{ $strategy->decision }}</td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
    </div>
</div>
