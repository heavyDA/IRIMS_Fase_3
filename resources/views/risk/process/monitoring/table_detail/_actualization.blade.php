<div class="row mt-2">
    <div class="col py-2" style="overflow-x: scroll;">
        <table id="actualizationTable" class="table table-stripped table-bordered w-100">
            <thead class="table-dark">
                <tr>
                    <th class="d-none" rowspan="2" style="width: 100px;"></th>
                    <th class="d-none" rowspan="2" style="width: 100px;"></th>
                    <th rowspan="2" style="width: 100px;">No. Penyebab Risiko</th>
                    <th rowspan="2" style="width: 240px;">Realisasi Perlakuan Risiko</th>
                    <th rowspan="2" style="width: 240px;">Realisasi Output atas masing-masing Breakdown Perlakuan
                        Risiko</th>
                    <th rowspan="2" style="width: 140px;">Realisasi Biaya Perlakuan Risiko (RP/USD)</th>
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
            </tbody>
        </table>
    </div>
</div>
