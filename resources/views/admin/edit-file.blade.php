<div class="modal fade" id="edit-file-modal" tabindex="-1" aria-labelledby="modalDocsLabel" aria-hidden="true" style='overflow-y: hidden;'>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFileTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('files.save') }}" method="POST">
                <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                    @csrf
                    <input type="hidden" id="edit-file-id" name="edit-file-id" />
                    <input type="hidden" id="edit-file-clienteId" name="edit-file-clienteId" />
                    <input type="hidden" id="edit-file-folderId" name="edit-file-folderId" />
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="edit-file-cliente">Cliente:</label>
                            <input type="text" id="edit-file-cliente" name="edit-file-cliente" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="edit-file-folder">Pasta:</label>
                            <input type="text" id="edit-file-folder" name="edit-file-folder" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="edit-file-description">Observações:</label>
                            <textarea id="edit-file-description" rows="3" name="edit-file-description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12">
                            <label for="edit-file-file">Arquivo</label>
                            <input type="file" name="edit-file-file" id="edit-file-file" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <input type="submit" name="edit-file-save" id="edit-file-save" data-loading-text="Loading..." class="btn btn-primary" value="Salvar" />
                </div>
            </form>
        </div>
    </div>
</div>