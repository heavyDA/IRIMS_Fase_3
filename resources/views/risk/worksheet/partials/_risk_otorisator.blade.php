<button style="min-width: 128px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#approveModal">
    <span><i class="ti ti-send-2"></i></span>&nbsp;Approve
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
                    <h6 class="modal-title" id="staticBackdropLabel">Revisi Kertas Kerja</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('risk.worksheet.update_status', $worksheet->getEncryptedId()) }}" id="reviseForm"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="on review">
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
                        class="btn btn-secondary" form="reviseForm">Batal</button>
                    <button type="submit" form="reviseForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-status" id="approveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Approve Kertas Kerja</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('risk.worksheet.update_status', $worksheet->getEncryptedId()) }}"
                        id="approveForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="approved">
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Catatan
                            </div>
                            <div>
                                <div id="approve-note-editor" class="textarea"></div>
                                <textarea class="form-control" id="approve-note" name="note" rows="4"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button onclick="this.form.reset()" data-bs-dismiss="modal" data-bs-target="#approveModal"
                        type="button" class="btn btn-secondary" form="approveForm">Batal</button>
                    <button type="submit" form="approveForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endpush
