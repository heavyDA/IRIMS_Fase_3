<form id="incidentForm">
    <div class="row mb-1">
        <div class="col-3">
            Nama Kejadian
        </div>
        <div class="col">
            <div id="incident_body-editor" class="textarea"></div>
            <textarea type="text" name="incident_body" class="d-none"></textarea>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Identifikasi Kejadian
        </div>
        <div class="col">
            <div id="incident_identification-editor" class="textarea"></div>
            <textarea type="text" name="incident_identification" class="d-none"></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">Kategori Kejadian</div>
        <div class="col">
            <select class="form-select" name="incident_category">
                <option>Pilih</option>
                @foreach ($incident_categories as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">Sumber Penyebab Kejadian</div>
        <div class="col">
            <select class="form-select" name="incident_source">
                <option>Pilih</option>
                <option value="internal">Internal</option>
                <option value="eksternal">Eksternal</option>
            </select>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Penyebab Kejadian
        </div>
        <div class="col">
            <div id="incident_cause-editor" class="textarea"></div>
            <textarea type="text" name="incident_cause" class="d-none"></textarea>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Penanganan Saat Kejadian
        </div>
        <div class="col">
            <div id="incident_handling-editor" class="textarea"></div>
            <textarea type="text" name="incident_handling" class="d-none"></textarea>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Deskripsi Kejadian
        </div>
        <div class="col">
            <div id="incident_description-editor" class="textarea"></div>
            <textarea type="text" name="incident_description" class="d-none"></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">
            <span>Kategori Risiko T2</span>
            <a tabindex="0"
                class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                data-bs-html="true"
                data-bs-content="
                            <div>Diisi dengan pilihan kategori risiko Portofolio BUMN Kementerian BUMN berikut:</div>
                            <ol><li><b>Risiko Fiskal - Dividen</b> (peristiwa Risiko yang disebabkan oleh kegagalan dan ketidakmampuan dalam membayar dividen kepada APBN)</li><li><b>Risiko Fiskal - PMN</b> (peristiwa Risiko yang disebabkan oleh Ketidakcukupan besaran PMN dan kegagalan pelaksanaan proyek PMN)</li><li><b>Risiko Fiskal - Subsidi &amp; Kompensasi </b>(peristiwa Risiko yang disebabkan oleh Kekurangan, keterlambatan, dan kerugian penerimaan subsidi dan kompensasi serta ketidakmampuan merealisasikan supply volume penyaluran subsidi dan kompensasi)</li><li><b>Risiko Kebijakan - SDM</b> (peristiwa Risiko yang disebabkan oleh penerapan kebijakan pemilihan, pengangkatan dan penetapan KPI Direksi dan Dekom atau Dewan Pengawas BUMN serta kebijakan SDM BUMN yang bersifat strategis)</li><li><b>Risiko Kebijakan - Sektoral </b>(peristiwa Risiko yang disebabkan oleh ketidakselarasan kebijakan yang dikeluarkan oleh Kementerian Teknis dan lembaga regulator yang dapat mempengaruhi ketidakpastian penerimaan atau operasi BUMN secara material)</li><li><b>Risiko Komposisi - Konsentrasi Portofolio </b>(peristiwa Risiko yang ditimbulkan oleh komposisi Portofolio BUMN yang terkonsentrasi pada industri tertentu)</li><li><b>Risiko Struktur - Struktur Korporasi </b>(peristiwa Risiko kerugian yang ditimbulkan dari Anak Perusahaan BUMN dan/atau Perusahaan Afiliasi BUMN)</li><li><b>Risiko Restrukturisasi &amp; Reorganisasi - Penggabungan, Pengambilalihan, Peleburan, Pemisahan, Pembubaran, Likuidasi, Kemitraan, dan Restrukturisasi</b> (peristiwa Risiko yang disebabkan oleh transaksi aksi korporasi atas Penggabungan, Pengambilalihan, Peleburan, Pemisahan, Pembubaran, Likuidasi, Kemitraan, dan Restrukturisasi yang material yang dapat mempengaruhi posisi strategis BUMN di masa yang akan datang)</li><li><b>Risiko Industri Umum - Formulasi Strategis</b> (peristiwa Risiko yang disebabkan oleh ketidakpastian kondisi BUMN dalam peta industri di mana BUMN tersebut beroperasi, termasuk ketidaktepatan arahan kebijakan strategis masing-masing BUMN yang dapat memberikan dampak yang material terhadap posisi BUMN dalam industri di mana BUMN tersebut beroperasi)</li><li><b>Risiko Industri Umum - Pasar &amp; Makroekonomi</b> (peristiwa Risiko yang disebabkan oleh pergerakan-pergerakan variabel makro ekonomi global seperti pergerakan tingkat bunga referensi, pergerakan nilai tukar Rupiah, dan/atau pergerakan harga-harga komoditas yang tidak dapat dikendalikan oleh BUMN)</li><li><b>Risiko Industri Umum - Keuangan </b>(peristiwa Risiko yang disebabkan oleh struktur dan akses pendanaan, terkait perpajakan, anggaran, akuntansi, piutang, pengelolaan modal kerja dan arus kas serta Risiko integritas atas penyusunan dan pelaporan keuangan)</li><li><b>Risiko Industri Umum - Reputasi &amp; Kepatuhan</b> (peristiwa Risiko yang disebabkan oleh tindakan dan/atau tuntutan hukum, kecurangan dalam konteks korupsi, kolusi dan nepotisme, perburukan reputasi BUMN dan ketidakpatuhan pada peraturan perundang-undangan yang berlaku yang dapat berpengaruh terhadap reputasi dan kinerja BUMN)</li><li><b>Risiko Industri Umum - Proyek</b> (peristiwa Risiko yang disebabkan oleh proyek-proyek yang dijalankan oleh BUMN mulai dari proses pemilihan proyek, pemilihan konsorsium, Risiko kontraktual proyek, Risiko eksekusi proyek dan penyelesaian proyek. Risiko ini terutama berasal dari BUMN yang memiliki sumber pendapatan yang berasal dari kontrak-kontrak jangka panjang, dan atau BUMN yang sedang menjalankan proyek jangka panjang untuk kepentingan ekspansi)</li><li><b>Risiko Industri Umum - Teknologi &amp; Keamanan Siber</b> (Risiko yang disebabkan oleh kegagalan perangkat lunak, perangkat keras, jaringan, atau sistem teknologi informasi lainnya pada BUMN termasuk Risiko yang diakibatkan oleh serangan siber (cyber attacks), kehilangan data, pelanggaran privasi, manipulasi data berbahaya, dan/atau pengelolaan akses data)</li><li><b>Risiko Industri Umum - Sosial &amp; Lingkungan</b> (potensi eksposur yang disebabkan oleh peristiwa perubahan iklim fisik, dan/atau Risiko transisi terkait perubahan kebijakan lingkungan, Risiko terkait hubungan yang tidak baik dengan komunitas/masyarakat sekitar dan social engagement)</li><li><b>Risiko Industri Umum - Operasional</b> (potensi kerugian yang disebabkan oleh proses internal, kegagalan sistem, kecelakaan dalam kesehatan keselamatan kerja, kesalahan manusia, atau kejadian eksternal (seperti gangguan rantai pasok, logistik, dan lain sebagainya) yang mempengaruhi operasi bisnis sehari-hari)</li><li><b>Risiko Industri Perbankan - Kredit</b> (peristiwa Risiko yang disebabkan oleh potensi debitur gagal membayar utang yang diwajibkan secara tepat waktu, yang mengakibatkan keterlambatan dan/atau penundaan pembayaran)</li><li><b>Risiko Industri Perbankan - Likuiditas</b> (Risiko ketidakmampuan Bank BUMN untuk memenuhi kewajiban yang jatuh tempo dari sumber pendanaan arus kas dan/atau dari aset likuid yang dapat dengan mudah dikonversi menjadi kas, tanpa mengganggu aktivitas dan kondisi keuangan Bank BUMN)</li><li><b>Risiko Industri Asuransi - Investasi</b> (kemungkinan kerugian atau terganggunya likuiditas Perusahaan, akibat dari aktivitas investasi, yang disebabkan terdapat concentration risk, default risk, settlement risk, general market risk, atau specific market risk, Risiko konsentrasi investasi (kurangnya diversifikasi/akumulasi Risiko dalam buku penjaminan/underwriting), investasi, dan lain-lain)</li><li><b>Risiko Industri Asuransi - Aktuarial</b> (potensi kegagalan Perusahaan untuk memenuhi kewajiban kepada pemegang polis, akibat kelemahan aktivitas aktuaria, yang disebabkan ketidakakuratan asumsi aktuaria/modelling yang digunakan, ketidakcukupan premi/ kontribusi yang ditetapkan, ketidakcukupan pembentukan cadangan teknis, atau volatilitas yang tidak terduga dalam faktor-faktor utama (seperti perubahan demografi, bencana luar biasa, tingkat kematian, tingkat harapan hidup, tingkat kecacatan, biaya kesehatan, biaya operasional, dan sebagainya)</li></ol>
                        "
                aria-label="Information" data-bs-original-title="Information"><i
                    class="ti ti-info-circle h5 text-secondary"></i>
            </a>
        </div>
        <div class="col">
            <select class="form-select" name="risk_category_t2">
                <option>Pilih</option>
                @foreach ($kbumn_risk_categories['T2'] as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">Kategori Risiko T3</div>
        <div class="col">
            <select class="form-select" name="risk_category_t3">
                <option>Pilih</option>
                @foreach ($kbumn_risk_categories['T3'] as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Penjelasan Kerugian
        </div>
        <div class="col">
            <div id="loss_description-editor" class="textarea"></div>
            <textarea type="text" name="loss_description" class="d-none"></textarea>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Nilai Kerugian
        </div>
        <div class="col">
            <input type="text" class="form-control" name="loss_value">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">Kejadian Berulang</div>
        <div class="col">
            <select class="form-select" name="incident_repetitive">
                <option>Pilih</option>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">Frekuensi Kejadian</div>
        <div class="col">
            <select class="form-select" name="incident_frequency">
                <option>Pilih</option>
                @foreach ($frequencies as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Mitigasi yang Direncanakan
        </div>
        <div class="col">
            <div id="mitigation_plan-editor" class="textarea"></div>
            <textarea type="text" name="mitigation_plan" class="d-none"></textarea>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Realisasi Mitigasi
        </div>
        <div class="col">
            <div id="actualization_plan-editor" class="textarea"></div>
            <textarea type="text" name="actualization_plan" class="d-none"></textarea>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Perbaikan Mendatang
        </div>
        <div class="col">
            <div id="follow_up_plan-editor" class="textarea"></div>
            <textarea type="text" name="follow_up_plan" class="d-none"></textarea>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Pihak Terkait
        </div>
        <div class="col">
            <div id="related_party-editor" class="textarea"></div>
            <textarea type="text" name="related_party" class="d-none"></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3">Status Asuransi</div>
        <div class="col">
            <select class="form-select" name="insurance_status">
                <option>Pilih</option>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Nilai Premi
        </div>
        <div class="col">
            <input type="text" class="form-control" name="insurance_permit">
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-3">
            Nilai Klaim
        </div>
        <div class="col">
            <input type="text" class="form-control" name="insurance_claim">
        </div>
    </div>
</form>
