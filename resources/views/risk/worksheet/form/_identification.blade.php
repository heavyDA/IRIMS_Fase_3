<form id="identificationForm">
    <div class="row w-75 mx-auto">
        <div class="col">
            <div class="row mb-3">
                <div class="col-3">Nama Perusahaan</div>
                <div class="col">
                    <input value="PT Angkasa Pura Indonesia" type="text" name="company_name"
                        class="form-control not-allowed" disabled>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Kode Perusahaan</div>
                <div class="col">
                    <input value="API" type="text" name="company_code" class="form-control not-allowed" disabled>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Sasaran Perusahaan<span class="text-danger">*</span>
                </div>
                <div class="col">
                    <div id="target_body-editor" class="textarea"></div>
                    <textarea disabled class="form-control not-allowed resize-none d-none" name="target_body" rows="4"></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Kategori Risiko T2<span class="text-danger">*</span>
                    <a tabindex="0"
                        class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                        role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                        title="Information" data-bs-html="true"
                        data-bs-content='
                            <div>Diisi dengan pilihan kategori risiko Portofolio BUMN Kementerian BUMN berikut:</div>
                            <ol><li><b>Risiko Fiskal - Dividen</b> (peristiwa Risiko yang disebabkan oleh kegagalan dan ketidakmampuan dalam membayar dividen kepada APBN)</li><li><b>Risiko Fiskal - PMN</b> (peristiwa Risiko yang disebabkan oleh Ketidakcukupan besaran PMN dan kegagalan pelaksanaan proyek PMN)</li><li><b>Risiko Fiskal - Subsidi &amp; Kompensasi </b>(peristiwa Risiko yang disebabkan oleh Kekurangan, keterlambatan, dan kerugian penerimaan subsidi dan kompensasi serta ketidakmampuan merealisasikan supply volume penyaluran subsidi dan kompensasi)</li><li><b>Risiko Kebijakan - SDM</b> (peristiwa Risiko yang disebabkan oleh penerapan kebijakan pemilihan, pengangkatan dan penetapan KPI Direksi dan Dekom atau Dewan Pengawas BUMN serta kebijakan SDM BUMN yang bersifat strategis)</li><li><b>Risiko Kebijakan - Sektoral </b>(peristiwa Risiko yang disebabkan oleh ketidakselarasan kebijakan yang dikeluarkan oleh Kementerian Teknis dan lembaga regulator yang dapat mempengaruhi ketidakpastian penerimaan atau operasi BUMN secara material)</li><li><b>Risiko Komposisi - Konsentrasi Portofolio </b>(peristiwa Risiko yang ditimbulkan oleh komposisi Portofolio BUMN yang terkonsentrasi pada industri tertentu)</li><li><b>Risiko Struktur - Struktur Korporasi </b>(peristiwa Risiko kerugian yang ditimbulkan dari Anak Perusahaan BUMN dan/atau Perusahaan Afiliasi BUMN)</li><li><b>Risiko Restrukturisasi &amp; Reorganisasi - Penggabungan, Pengambilalihan, Peleburan, Pemisahan, Pembubaran, Likuidasi, Kemitraan, dan Restrukturisasi</b> (peristiwa Risiko yang disebabkan oleh transaksi aksi korporasi atas Penggabungan, Pengambilalihan, Peleburan, Pemisahan, Pembubaran, Likuidasi, Kemitraan, dan Restrukturisasi yang material yang dapat mempengaruhi posisi strategis BUMN di masa yang akan datang)</li><li><b>Risiko Industri Umum - Formulasi Strategis</b> (peristiwa Risiko yang disebabkan oleh ketidakpastian kondisi BUMN dalam peta industri di mana BUMN tersebut beroperasi, termasuk ketidaktepatan arahan kebijakan strategis masing-masing BUMN yang dapat memberikan dampak yang material terhadap posisi BUMN dalam industri di mana BUMN tersebut beroperasi)</li><li><b>Risiko Industri Umum - Pasar &amp; Makroekonomi</b> (peristiwa Risiko yang disebabkan oleh pergerakan-pergerakan variabel makro ekonomi global seperti pergerakan tingkat bunga referensi, pergerakan nilai tukar Rupiah, dan/atau pergerakan harga-harga komoditas yang tidak dapat dikendalikan oleh BUMN)</li><li><b>Risiko Industri Umum - Keuangan </b>(peristiwa Risiko yang disebabkan oleh struktur dan akses pendanaan, terkait perpajakan, anggaran, akuntansi, piutang, pengelolaan modal kerja dan arus kas serta Risiko integritas atas penyusunan dan pelaporan keuangan)</li><li><b>Risiko Industri Umum - Reputasi &amp; Kepatuhan</b> (peristiwa Risiko yang disebabkan oleh tindakan dan/atau tuntutan hukum, kecurangan dalam konteks korupsi, kolusi dan nepotisme, perburukan reputasi BUMN dan ketidakpatuhan pada peraturan perundang-undangan yang berlaku yang dapat berpengaruh terhadap reputasi dan kinerja BUMN)</li><li><b>Risiko Industri Umum - Proyek</b> (peristiwa Risiko yang disebabkan oleh proyek-proyek yang dijalankan oleh BUMN mulai dari proses pemilihan proyek, pemilihan konsorsium, Risiko kontraktual proyek, Risiko eksekusi proyek dan penyelesaian proyek. Risiko ini terutama berasal dari BUMN yang memiliki sumber pendapatan yang berasal dari kontrak-kontrak jangka panjang, dan atau BUMN yang sedang menjalankan proyek jangka panjang untuk kepentingan ekspansi)</li><li><b>Risiko Industri Umum - Teknologi &amp; Keamanan Siber</b> (Risiko yang disebabkan oleh kegagalan perangkat lunak, perangkat keras, jaringan, atau sistem teknologi informasi lainnya pada BUMN termasuk Risiko yang diakibatkan oleh serangan siber (cyber attacks), kehilangan data, pelanggaran privasi, manipulasi data berbahaya, dan/atau pengelolaan akses data)</li><li><b>Risiko Industri Umum - Sosial &amp; Lingkungan</b> (potensi eksposur yang disebabkan oleh peristiwa perubahan iklim fisik, dan/atau Risiko transisi terkait perubahan kebijakan lingkungan, Risiko terkait hubungan yang tidak baik dengan komunitas/masyarakat sekitar dan social engagement)</li><li><b>Risiko Industri Umum - Operasional</b> (potensi kerugian yang disebabkan oleh proses internal, kegagalan sistem, kecelakaan dalam kesehatan keselamatan kerja, kesalahan manusia, atau kejadian eksternal (seperti gangguan rantai pasok, logistik, dan lain sebagainya) yang mempengaruhi operasi bisnis sehari-hari)</li><li><b>Risiko Industri Perbankan - Kredit</b> (peristiwa Risiko yang disebabkan oleh potensi debitur gagal membayar utang yang diwajibkan secara tepat waktu, yang mengakibatkan keterlambatan dan/atau penundaan pembayaran)</li><li><b>Risiko Industri Perbankan - Likuiditas</b> (Risiko ketidakmampuan Bank BUMN untuk memenuhi kewajiban yang jatuh tempo dari sumber pendanaan arus kas dan/atau dari aset likuid yang dapat dengan mudah dikonversi menjadi kas, tanpa mengganggu aktivitas dan kondisi keuangan Bank BUMN)</li><li><b>Risiko Industri Asuransi - Investasi</b> (kemungkinan kerugian atau terganggunya likuiditas Perusahaan, akibat dari aktivitas investasi, yang disebabkan terdapat concentration risk, default risk, settlement risk, general market risk, atau specific market risk, Risiko konsentrasi investasi (kurangnya diversifikasi/akumulasi Risiko dalam buku penjaminan/underwriting), investasi, dan lain-lain)</li><li><b>Risiko Industri Asuransi - Aktuarial</b> (potensi kegagalan Perusahaan untuk memenuhi kewajiban kepada pemegang polis, akibat kelemahan aktivitas aktuaria, yang disebabkan ketidakakuratan asumsi aktuaria/modelling yang digunakan, ketidakcukupan premi/ kontribusi yang ditetapkan, ketidakcukupan pembentukan cadangan teknis, atau volatilitas yang tidak terduga dalam faktor-faktor utama (seperti perubahan demografi, bencana luar biasa, tingkat kematian, tingkat harapan hidup, tingkat kecacatan, biaya kesehatan, biaya operasional, dan sebagainya)</li></ol>
                        '><i
                            class="ti ti-info-circle h5 text-secondary"></i>
                    </a>
                </div>
                <div class="col">
                    <select class="form-select" name="kbumn_risk_category_t2">
                        <option>Pilih</option>
                        @foreach ($kbumn_risk_categories['T2'] as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Kategori Risiko T3<span class="text-danger">*</span></div>
                <div class="col">
                    <select class="form-select" name="kbumn_risk_category_t3">
                        <option>Pilih</option>
                        @foreach ($kbumn_risk_categories['T3'] as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                    <span>Peristiwa Risiko<span class="text-danger">*</span></span>
                    <a tabindex="0"
                        class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                        role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                        title="Information" data-bs-html="true"
                        data-bs-content='
                        <div class="col-md-12" style="padding:20px;">
                        <p>Diisi dengan peristiwa risiko yang relevan serta peristiwa risko harus diidentifikasi secara tepat <strong>(bukan negasi sasaran, negasi dampak)</strong></p>
                    </div>
                    '><i
                            class="ti ti-info-circle h5 text-secondary"></i>
                    </a>
                </div>
                <div class="col">
                    <div class="mb-2">
                        <div id="risk_chronology_body-editor" class="textarea"></div>
                        <textarea class="d-none form-control" name="risk_chronology_body" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                    <span>Deskripsi Peristiwa Risiko<span class="text-danger">*</span></span>
                    <a tabindex="0"
                        class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                        role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                        title="Information" data-bs-html="true"
                        data-bs-content='
                        <div class="col-md-12" style="padding:20px;">
                        <p>Di isi dengan <strong>Penjelasan /narasi atas peristiwa risiko</strong></p>
                    </div>
                    '><i
                            class="ti ti-info-circle h5 text-secondary"></i>
                    </a>
                </div>
                <div class="col">
                    <div class="mb-2">
                        <div id="risk_chronology_description-editor" class="textarea"></div>
                        <textarea class="d-none form-control" name="risk_chronology_description" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Jenis Existing Control<span class="text-danger">*</span>
                    <a tabindex="0"
                        class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                        role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                        title="Information" data-bs-html="true"
                        data-bs-content='
                            <p>Diisi dengan pilihan pada hirarki pertama:<br><ul><li>Kontrol operasi</li><li>Kontrol kepatuhan (compliance)</li><li>Kontrol pelaporan</li></ul><div><br></div><div>Setelah hirarki pertama dipilih, dilanjutkan dengan pilihan hirarki kedua:</div><ul><li>Kontrol pada level entitas/kantor pusat</li><li>Kontral pada level operasi</li></ul></p>
                        '><i
                            class="ti ti-info-circle h5 text-secondary"></i>
                    </a>
                </div>
                <div class="col">
                    <select class="form-select" name="existing_control_type">
                        <option>Pilih</option>
                        @foreach ($existing_control_types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Existing Control<span class="text-danger">*</span>
                    <a tabindex="0"
                        class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                        role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                        title="Information" data-bs-html="true"
                        data-bs-content='
                        <p>BUMN dapat mengisikan semua existing control yang relevan terhadap suatu risiko. Existing control tersebut dapat berupa kontrol SOP, sistem, kebijakan, dl</p>
                    '><i
                            class="ti ti-info-circle h5 text-secondary"></i>
                    </a>
                </div>
                <div class="col">
                    <div class="mb-2">
                        <div id="existing_control_body-editor" class="textarea"></div>
                        <textarea class="d-none form-control" name="existing_control_body" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Penilaian Efektivitas Kontrol<span class="text-danger">*</span>
                    <a tabindex="0"
                        class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                        role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                        title="Information" data-bs-html="true"
                        data-bs-content='
                        <div class="col-md-12" style="padding:20px;">
                        <div>Dipilih&nbsp;penilaian terhadap efektivitas kontrol saat ini (existing control) dengan pilihan sebagai berikut:</div><ol><li>Cukup dan Efektif;</li><li>Cukup dan Efektif Sebagian;</li><li>Cukup dan Tidak Efektif;</li><li>Tidak Cukup dan Efektif Sebagian; dan</li><li>Tidak Cukup dan Tidak Efektif.</li></ol>
                    </div>
                    '><i
                            class="ti ti-info-circle h5 text-secondary"></i>
                    </a>
                </div>
                <div class="col">
                    <select class="form-select" name="control_effectiveness_assessment">
                        <option>Pilih</option>
                        @foreach ($control_effectiveness_assessments as $assessment)
                            <option value="{{ $assessment->id }}">{{ $assessment->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Kategori Dampak<span class="text-danger">*</span></div>
                <div class="col">
                    <select class="form-select" name="risk_impact_category">
                        <option>Pilih</option>
                        <option value="kuantitatif">Kuantitatif</option>
                        <option value="kualitatif">Kualitatif</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Deskripsi Dampak<span class="text-danger">*</span>
                    <a tabindex="0"
                        class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                        role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right"
                        title="Information" data-bs-html="true"
                        data-bs-content='<p>Diisi dengan pilihan kategori dampak:<br><ul><li>Dampak kuantitatif: Risiko yang memiliki dampak finansial terhadap pencapaian target laba BUMN.</li><li>Dampak kualitatif: Risiko yang tidak memiliki dampak finansial terhadap pencapaian target laba BUMN.</li></ul></p>'><i
                            class="ti ti-info-circle h5 text-secondary"></i>
                    </a>
                </div>
                <div class="col">
                    <div class="mb-2">
                        <div id="risk_impact_body-editor" class="textarea"></div>
                        <textarea class="d-none form-control" name="risk_impact_body" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">Perkiraan Waktu Terpapar Risiko<span class="text-danger">*</span></div>
                <div class="col">
                    <input type="hidden" name="risk_impact_start_date" value="2024-01-01">
                    <input type="hidden" name="risk_impact_end_date" value="2024-06-30">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                        <input type="text" class="form-control" id="risk_impact_date-picker">
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs mb-3 nav-justified tab-style-5 d-sm-flex d-block" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#identificationInherentTab"
                        aria-selected="true">Inheren</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" role="tab" href="#identificationResidualTab"
                        aria-selected="false" tabindex="-1">Residual</a>
                </li>
            </ul>

            <div class="tab-content" id="identificationTabs">
                <div class="tab-pane border-0 p-2 show active" id="identificationInherentTab">
                    <div class="row mb-3">
                        <div data-kualitatif="Penjelasan Dampak Kualitatif <span class='text-danger'>*</span>"
                            data-kuantitatif="Asumsi Perhitungan Dampak Kuantitatif <span class='text-danger'>*</span>"
                            class="col-3 label-category-risk">
                            Dampak<span class="text-danger">*</span>
                            <a tabindex="0"
                                class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                                role="button" data-bs-toggle="popover" data-bs-trigger="focus"
                                data-bs-placement="right" title="Information" data-bs-html="true"
                                data-bs-content='<p>Diisi penjelasan atas asumsi/pendekatan yang dipakai untuk menghitung nilai dampak.</p>'><i
                                    class="ti ti-info-circle h5 text-secondary"></i>
                            </a>
                        </div>
                        <div class="col">
                            <div class="mb-2">
                                <div id="inherent_body-editor" class="textarea"></div>
                                <textarea class="d-none form-control" name="inherent_body" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Nilai Dampak Inheren <span
                                class="label-category-risk text-capitalize"></span><span class="text-danger">*</span>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="inherent_impact_value">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Skala Dampak Inheren <span
                                class="label-category-risk text-capitalize"></span><span class="text-danger">*</span>
                            <a tabindex="0"
                                class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                                role="button" data-bs-toggle="popover" data-bs-trigger="focus"
                                data-bs-placement="right" title="Information" data-bs-html="true"
                                data-bs-content='<p>Diisi dengan penilaian dampak Risiko Inheren dengan skala 1 s.d. 5
                                <br><strong>Reference to Table Skala KBUMN</strong></p>'><i
                                    class="ti ti-info-circle h5 text-secondary"></i>
                            </a>
                        </div>
                        <div class="col">
                            <select data-placeholder="Pilih" disabled data-custom class="form-select"
                                name="inherent_impact_scale">
                                <option>Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Nilai Probabilitas Inheren <span class="label-category-risk"></span><span
                                class="text-danger">*</span></div>
                        <div class="col">
                            <div class="input-group">
                                <input type="text" class="form-control" name="inherent_impact_probability">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Skala Probabilitas Inheren <span class="label-category-risk"></span></div>
                        <div class="col">
                            <select data-placeholder="Pilih" disabled data-custom class="form-select"
                                name="inherent_impact_probability_scale">
                                <option>Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Eksposur Risiko <span class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col">
                            <input type="text" disabled class="form-control not-allowed"
                                name="inherent_risk_exposure">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Skala Risiko Inheren <span
                                class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col">
                            <input type="text" disabled class="form-control not-allowed"
                                name="inherent_risk_scale">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Level Risiko Inheren <span
                                class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col">
                            <input type="text" disabled class="form-control not-allowed"
                                name="inherent_risk_level">
                        </div>
                    </div>
                </div>
                <div class="tab-pane border-0 p-2" id="identificationResidualTab">
                    <div class="row mb-3">
                        <div class="col-3">Nilai Dampak Residual <span
                                class="label-category-risk text-capitalize"></span>
                        </div>

                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <input type="text" class="form-control" disabled
                                        name="residual[{{ $quarter }}][impact_value]">
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Skala Dampak Residual <span
                                class="label-category-risk text-capitalize"></span><span class="text-danger">*</span>
                        </div>
                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <select disabled data-custom class="form-select w-100"
                                        name="residual[{{ $quarter }}][impact_scale]">
                                        <option>Pilih</option>
                                    </select>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Nilai Probabilitas Residual <span
                                class="label-category-risk text-capitalize"></span><span class="text-danger">*</span>
                        </div>
                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <input type="text" class="form-control"
                                        name="residual[{{ $quarter }}][impact_probability]">
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Skala Probabilitas <span
                                class="label-category-risk text-capitalize"></span></div>
                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <select disabled data-custom class="form-select w-100"
                                        name="residual[{{ $quarter }}][impact_probability_scale]">
                                        <option>Pilih</option>
                                    </select>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Eksposur Risiko <span class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <input disabled type="text" class="form-control"
                                        name="residual[{{ $quarter }}][risk_exposure]">
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Skala Risiko Residual <span
                                class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <input disabled type="text" class="not-allowed form-control"
                                        name="residual[{{ $quarter }}][risk_scale]">
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">Level Risiko Inheren <span
                                class="label-category-risk text-capitalize"></span>
                        </div>
                        <div class="col row">
                            @for ($quarter = 1; $quarter < 5; $quarter++)
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Q{{ $quarter }}</label>
                                    <input disabled type="text" class="not-allowed form-control"
                                        name="residual[{{ $quarter }}][risk_level]">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-secondary-light" data-bs-toggle="modal" data-bs-target="#incidentModal">
        <i class="ti ti-plus"></i>Tambah Peristiwa Risiko
    </button>

    <div class="row mt-2">
        <div class="col py-2" style="overflow-x: scroll;">
            <table id="worksheetIncidentTable" class="table table-bordered table-stripped" style="width:100%">
                <thead class="table-dark">
                    <tr style="vertical-align: bottom;">
                        <th rowspan="2">Aksi</th>
                        <th style="" rowspan="2">No. Penyebab Risiko</th>
                        <th style="" rowspan="2">Kode Penyebab risiko</th>
                        <th style="width: 220px !important;" rowspan="2">Penyebab risiko</th>
                        <th style="" rowspan="2">Key Risk Indicators</th>
                        <th style="" rowspan="2">Unit Satuan KRI</th>
                        <th style="" colspan="3">Kategori Threshold KRI</th>
                    </tr>
                    <tr style="vertical-align: bottom;">
                        <th rowspan="2">Aman</th>
                        <th rowspan="2">Hati-Hati</th>
                        <th rowspan="2">Bahaya</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</form>


@push('element')
    <div class="modal fade" id="incidentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 100% !important;">
            <div class="modal-content mx-auto" style="width: 80vw !important">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Tambah Peristiwa Risiko</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="incidentForm">
                        <div id="incidentFormAlert" class="alert alert-danger alert-dismissible hide fade mb-2">
                            <p></p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                                    class="bi bi-x"></i></button>
                        </div>
                        <input type="hidden" name="key">
                        <input type="hidden" name="id" value>
                        {{-- <div class="row mb-3">
                            <div class="col-3">No. Risiko</div>
                            <div class="col">
                                <input type="text" class="form-control" name="risk_number" readonly>
                            </div>
                        </div> --}}
                        <div class="row mb-3">
                            <div class="col-3">No. Penyebab Risiko</div>
                            <div class="col">
                                <input type="text" disabled class="not-allowed form-control" name="risk_cause_number"
                                    value="a">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Kode Penyebab Risiko</div>
                            <div class="col">
                                <input type="text" class="form-control" disabled name="risk_cause_code">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <span>Penyebab Risiko<span class="text-danger">*</span></span>
                                <a tabindex="0"
                                    class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                                    role="button" data-bs-toggle="popover" data-bs-trigger="focus"
                                    data-bs-placement="right" title="Information" data-bs-html="true"
                                    data-bs-content='
                            <div style="padding:20px;">
                            <ol><li>Penyebab Risiko yang diidentifikasi adalah akar penyebab/root cause dari terjadinya Risiko.</li><li>Penyebab Risiko dapat bersumber dari sisi manusia, proses, jaringan, sistem, atau sumber lain yang berpotensi memicu terjadinya Risiko.</li><li>Apabila terdapat lebih dari satu penyebab Risiko dalam satu sumber Risiko harus dipastikan bahwa penyebab tersebut satu level kedalaman sebagai root cause. Apabila berbeda level kedalaman, maka dapat terjadi tumpang-tindih penyebab yang akan merancukan program perlakuan Risiko.</li><li>Penyebab Risiko merupakan kondisi yang terjadi saat dilakukan identifikasi Risike. ldentifikasi penyebab Risiko dapat mengacu pada Diagram 2 Fault Tree&nbsp;Analysis.</li></ol>
                        </div>
                        '>
                                    <i class="ti ti-info-circle h5 text-secondary"></i>
                                </a>
                            </div>
                            <div class="col">
                                <div class="mb-2">
                                    <div id="risk_cause_body-editor" class="textarea"></div>
                                    <textarea class="d-none form-control" name="risk_cause_body" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <span>Key Risk Indicators<span class="text-danger">*</span>
                                </span>
                                <a tabindex="0"
                                    class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                                    role="button" data-bs-toggle="popover" data-bs-trigger="focus"
                                    data-bs-placement="right" title="Information" data-bs-html="true"
                                    data-bs-content='
                            <div style="padding:20px;">
                                ldentifikasi KRI:<br><ol><li>Setiap peristiwa Risiko harus memiliki KRI yang menjadi early warning signal sebelum terjadinya suatu peristiwa Risiko.</li><li>ldentifikasi KRI dapat menggunakan Fault Tree Analysis sebagaimana Diagram 2 di alas.</li><li>KRI harus leading indicator dan hindari menetapkan KRI lagging indicator.&nbsp;</li><li>KRI harus dilengkapi dengan batasanlthreshold sebagai alat monitor yang terdiri dari 3 (tiga) threshold yaitu batas bahaya, batas hati-hati, dan batas aman.</li><li>Nilai threshold dapat ditetapkan berdasarkan pertimbangan data historis, benchmarking, dan kebijakan strategi Risiko.</li></ol><div><u></u></div>
                            </div>
                        '>
                                    <i class="ti ti-info-circle h5 text-secondary"></i>
                                </a>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="kri_body">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                <span>Unit Satuan KRI<span class="text-danger">*</span></span>
                                <a tabindex="0"
                                    class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-50-hover text-decoration-underline mx-1"
                                    role="button" data-bs-toggle="popover" data-bs-trigger="focus"
                                    data-bs-placement="right" title="Information" data-bs-html="true"
                                    data-bs-content='
                            <div style="padding:20px;">
                                Unit satuan KRI bisa berbentuk amount/percentage/range/kualitatif
                            </div>
                        '>
                                    <i class="ti ti-info-circle h5 text-secondary"></i>
                                </a>
                            </div>

                            <div class="col">
                                <select name="kri_unit" class="form-select">
                                    <option>Pilih</option>
                                    @foreach ($kri_units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">Kategori Threshold KRI<span class="text-danger">*</span></div>
                            <div class="col">
                                <div class="d-flex flex-column">
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <div class="d-flex flex-column gap-1">
                                                <div class="badge bg-success-transparent">Aman</div>
                                                <input type="text" class="form-control" name="kri_threshold_safe">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="d-flex flex-column gap-1">
                                                <div class="badge bg-warning-transparent">Hati-Hati</div>
                                                <input type="text" class="form-control" name="kri_threshold_caution">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="d-flex flex-column gap-1">
                                                <div class="badge bg-danger-transparent">Bahaya</div>
                                                <input type="text" class="form-control" name="kri_threshold_danger">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="reset" form="incidentForm" class="btn btn-secondary">Batal</button>
                    <button type="submit" form="incidentForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endpush
