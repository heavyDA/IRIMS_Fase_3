    <div class="row mt-2">
        <div class="col py-2" style="overflow-x: scroll;">
            <table class="table table-bordered table-stripped" style="width:100%">
                <thead class="table-dark">
                    <tr style="vertical-align: bottom;">
                        <th rowspan="3">Aksi</th>
                        <th style="width: 220px !important;" rowspan="3">Peristiwa Risiko</th>
                        <th style="width: 220px !important;" rowspan="3">Deskripsi Peristiwa Risiko</th>
                        <th style="" rowspan="3">No. Penyebab Risiko</th>
                        <th style="" rowspan="3">Kode Penyebab risiko</th>
                        <th style="width: 220px !important;" rowspan="3">Penyebab risiko</th>
                        <th style="" rowspan="3">Key Risk Indicators</th>
                        <th style="" rowspan="3">Unit Satuan KRI</th>
                        <th style="" colspan="3">Kategori Threshold KRI</th>
                        <th style="" rowspan="3">Jenis Existing Control</th>
                        <th style="" rowspan="3">Existing Control</th>
                        <th style="" rowspan="3">Penilaian Efektivitas Kontrol</th>
                        <th style="" rowspan="3">Kategori Dampak</th>
                        <th style="" rowspan="3">Deskripsi Dampak</th>
                        <th style="" rowspan="3">Perkiraan Waktu Terpapar Risiko</th>
                        <th style="" colspan="12">Risiko Inheren</th>
                        <th style="" colspan="28">Target Risiko Residual</th>
                    </tr>
                    <tr style="vertical-align: bottom;">
                        <th rowspan="2">Aman</th>
                        <th rowspan="2">Hati-Hati</th>
                        <th rowspan="2">Bahaya</th>
                        <th style="" rowspan="2">Asumsi Perhitungan Dampak</th>
                        <th style="" rowspan="2">Nilai Dampak</th>
                        <th style="" rowspan="1" colspan="2">Skala Dampak</th>
                        <th style="" rowspan="2">Nilai Probabilitas (%)</th>
                        <th style="" rowspan="1" colspan="2">Skala Probabilitas</th>
                        <th style="" rowspan="2">Eksposur Risiko</th>
                        <th style="" rowspan="1" colspan="2">Skala Risiko</th>
                        <th style="" rowspan="1" colspan="2">Level Risiko</th>
                        <th colspan="4">Nilai Dampak</th>
                        <th colspan="4">Skala Dampak</th>
                        <th colspan="4">Nilai Probabilitas (%)</th>
                        <th colspan="4">Skala Probabilitas</th>
                        <th colspan="4">Eksposur Risiko</th>
                        <th colspan="4">Skala Risiko</th>
                        <th colspan="4">Level Risiko</th>
                    </tr>
                    <tr style="vertical-align: bottom;">
                        <th>BUMN</th>
                        <th>KBUMN</th>
                        <th>BUMN</th>
                        <th>KBUMN</th>
                        <th>BUMN</th>
                        <th>KBUMN</th>
                        <th>BUMN</th>
                        <th>KBUMN</th>
                        @for ($i = 0; $i < 7; $i++)
                            @for ($q = 1; $q <= 4; $q++)
                                <th>Q{{ $q }}</th>
                            @endfor
                        @endfor
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
