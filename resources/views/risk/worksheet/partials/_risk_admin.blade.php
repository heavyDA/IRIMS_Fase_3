<button class="btn btn-primary" style="min-width: 128px;" data-bs-toggle="modal" data-bs-target="#submitModal">
    <span><i class="ti ti-send-2"></i></span>&nbsp;Submit
</button>
@push('element')
    <div class="modal fade" id="submitModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Submit Kertas Kerja</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('risk.worksheet.update_status', $worksheet->getEncryptedId()) }}" id="submitForm"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="on review">
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
                    <button type="reset" class="btn btn-secondary" form="submitForm">Batal</button>
                    <button type="submit" form="submitForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endpush
