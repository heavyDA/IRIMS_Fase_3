<button style="min-width: 128px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#submitModal">
    <span><i class="ti ti-send-2"></i></span>&nbsp;Submit
</button>
<button style="min-width: 128px;" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#reviseModal">
    <span><i class="ti ti-pencil-exclamation"></i></span>&nbsp;Revise
</button>
@push('element')
    <div class="modal fade modal-status" id="reviseModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Revisi Laporan Monitoring</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('risk.monitoring.update_status_monitoring', $monitoring->getEncryptedId()) }}"
                        id="reviseForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="draft">
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Catatan
                            </div>
                            <div>
                                <div id="revise-note-editor" class="textarea"></div>
                                <textarea class="form-control" id="revise-note" name="note" rows="4"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button onclick="this.form.reset()" data-bs-dismiss="modal" data-bs-target="#reviseModal" type="button"
                        form="reviseForm">Batal</button>
                    <button type="submit" form="reviseForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-status" id="submitModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Konfirmasi Laporan Monitoring</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('risk.monitoring.update_status_monitoring', $monitoring->getEncryptedId()) }}"
                        id="submitForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="on confirmation">
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Catatan
                            </div>
                            <div>
                                <div id="confirmation-note-editor" class="textarea"></div>
                                <textarea class="form-control" id="confirmation-note" name="note" rows="4"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button onclick="this.form.reset()" data-bs-dismiss="modal" data-bs-target="#submitModal" type="button"
                        class="btn btn-secondary" form="submitForm">Batal</button>
                    <button type="submit" form="submitForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endpush
