<div class="modal fade" id="edit-user-modal" tabindex="-1" aria-labelledby="modalDocsLabel" aria-hidden="true" style='overflow-y: hidden;'>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                    @csrf
                    <input type="hidden" id="edit-user-id" name="edit-user-id" />
                    <div class="form-group row">
                        <div class="col-md-8">
                            <label for="edit-user-name">{{ __('Nome') }}</label>
                            <input id="edit-user-name" type="text" class="form-control" name="edit-user-name" required autocomplete="name" autofocus>
                        </div>
                        <div class="col-md-4">
                            <label for="edit-user-cnpj">{{ __('CNPJ') }}</label>
                            <input id="edit-user-cnpj" type="text" class="form-control" name="edit-user-cnpj" required autocomplete="cnpj">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="edit-user-password">{{ __('Senha') }}</label>
                            <input id="edit-user-password" type="edit-user-password" class="form-control" name="edit-user-password" required autocomplete="new-password">
                        </div>
                        <div class="col-md-6">
                            <label for="edit-user-password-confirm">{{ __('Confirme a senha') }}</label>
                            <input id="edit-user-password-confirm" type="password" class="form-control" name="edit-user-password-confirm" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="edit-user-role">{{ __('Role') }}</label>
                            <select id="edit-user-role" class="form-select" name="edit-user-role" required>
                                <option disabled selected> Selecione o nivel de acesso </option>
                                <option value="Cliente">Cliente</option>
                                <option value="Admin">Administrador</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <input type="submit" name="edit-user-save" id="edit-user-save" data-loading-text="Loading..." class="btn btn-primary" value="Salvar" />
                </div>
            </form>
        </div>
    </div>
</div>