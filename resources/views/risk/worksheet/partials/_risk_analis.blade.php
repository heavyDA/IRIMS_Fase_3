<button style="min-width: 128px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
    <span><i class="ti ti-send-2"></i></span>&nbsp;Update Status
</button>
@push('element')
    <div class="modal fade" id="updateStatusModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Submit Kertas Kerja</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('risk.worksheet.update_status', $worksheet->getEncryptedId()) }}" id="updateStatusForm"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="draft">
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Submit Sebagai
                            </div>
                            <div>
                                <select name="role" class="form-select" required>
                                    <option value="">Pilih</option>
                                    <option value="risk admin">Risk Admin</option>
                                    <option value="risk owner">Risk Owner</option>
                                    <option value="risk otorisator">Risk Otorisator</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Status
                            </div>
                            <div>
                                <select name="status" class="form-select" required>
                                    <option value="">Pilih</option>
                                    <option value="draft">Draft</option>
                                    <option value="on review">On Review</option>
                                    <option value="on confirmation">On Confirmation</option>
                                    <option value="approved">Approved</option>
                                    <option value="revise">Revisi</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <div>
                                Catatan
                            </div>
                            <div>
                                {{-- <div id="note-editor" class="textarea"></div> --}}
                                <textarea class="form-control" name="note" rows="4"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="reset" onclick="console.log(e.target.form)" class="btn btn-secondary" form="updateStatusForm">Batal</button>
                    <button type="submit" form="updateStatusForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endpush
