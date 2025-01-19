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
        <div class="col-3">Kategori Risiko T2</div>
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
