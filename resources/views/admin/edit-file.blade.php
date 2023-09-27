<div class="modal fade" id="edit-file-modal" tabindex="-1" aria-labelledby="modalDocsLabel" aria-hidden="true" style='overflow-y: hidden'>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFileTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('files.save') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    @csrf
                    <input type="hidden" id="edit-file-id" name="edit-file-id" />
                    <input type="hidden" id="edit-file-clienteId" name="edit-file-clienteId" />
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="edit-file-name">Nome do arquivo:</label>
                            <input type="text" id="edit-file-name" name="edit-file-name" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edit-file-folder">Pasta:</label>
                            <select id="edit-file-folder" name="edit-file-folder" class="form-control" required>
                                <option value="" selected>Selecione a pasta</option>
                                @foreach($folders as $folder)
                                <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="edit-file-description">Observações:</label>
                            <textarea rows="3" maxlength="255" onkeyup="textCounter(this,'counter',255);" id="edit-file-description" name="edit-file-description" class="form-control"></textarea>    
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12">
                            <label for="edit-file-file">Arquivo</label>
                            <input type="file" name="edit-file-file" id="edit-file-file" class="form-control">
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
