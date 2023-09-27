<div class="modal fade" id="edit-folder-modal" tabindex="-1" aria-labelledby="modalDocsLabel" aria-hidden="true" style='overflow-y: hidden;'>
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFolderTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('folders.save') }}" method="POST">
                <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                    @csrf
                    <input type="hidden" id="edit-folder-id" name="edit-folder-id" />
                    <input type="hidden" id="edit-folder-clienteId" name="edit-folder-clienteId" />
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="edit-folder-parent-folder">Pasta superiora:</label>
                            <select id="edit-folder-parent-folder" name="edit-folder-parent-folder" class="form-control" required>
                                <option value="" disabled selected>Selecione a pasta superiora</option>
                                @foreach($folders as $f)
                                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="edit-folder-name">Nome da pasta</label>
                            <input type="text" id="edit-folder-name" name="edit-folder-name" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <input type="submit" name="edit-folder-save" id="edit-folder-save" data-loading-text="Loading..." class="btn btn-primary" value="Salvar" />
                </div>
            </form>
        </div>
    </div>
</div>