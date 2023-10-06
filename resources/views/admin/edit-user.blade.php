<div class="modal fade" id="edit-user-modal" tabindex="-1" aria-labelledby="modalDocsLabel" aria-hidden="true" style='overflow-y: hidden;'>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('users.save')}}" id="edit-user-form" method="POST">
                <div class="modal-body" style="max-height: 70vh; overflow-y: hidden; padding:.5rem 1rem">
                    @csrf
                    <input type="hidden" id="edit-user-id" name="edit-user-id" />
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="edit-user-name">{{ __('Nome') }}</label>
                            <input id="edit-user-name" type="text" class="form-control" name="edit-user-name" minLenght="3" maxLength="100" name="edit-user-password" required autocomplete="name" autofocus>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="edit-user-role">{{ __('Nível de acesso') }}</label>
                            <select id="edit-user-role" class="form-select" name="edit-user-role" required>
                                <option disabled selected> Selecione o nivel de acesso </option>
                                <option value="Cliente">Cliente</option>
                                <option value="Admin">Administrador</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit-user-cnpj">{{ __('CNPJ') }}</label>
                            <input id="edit-user-cnpj" type="text" class="form-control" onchange="mask()" minlength="18" maxlength="18" name="edit-user-cnpj" required>
                        </div>
                    </div>
                    <div class="form-group row" id="disablePasswordsDiv">
                        <label class="col-md-3"> <input type="checkbox" class="form-check-input me-1" id="disablePasswordFields" onchange="disablePasswordChange(this)" /> {{ __('Atualizar senha') }}</label>
                        <hr class="col m-0 pt-auto" style="align-self: center">
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="edit-user-password">{{ __('Senha') }}</label>
                            <div class="password">
                                <input id="edit-user-password" type="password" class="form-control passwordInput" minLenght="8" maxLength="100" name="edit-user-password" disabled>
                                <label>
                                    <button type="button" id="strongPassword" class="strongPassword" onclick="generateStrongPassword(12)" disabled title="Sugerir senha forte">
                                        <i class="fa fa-lock"></i>
                                    </button>
                                </label>
                                <label>
                                    <button type="button" class="passwordToggle" id="password" disabled onclick="toggle(this)">
                                        <i class="far fa-eye" id="password-toggle"></i>
                                    </button>
                                </label>
                            </div>
                            <label id="edit-user-password-error" class="error" for="edit-user-password"></label>
                        </div>
                        <div class="col-md-6">
                            <label for="edit-user-password-confirm">{{ __('Confirme a senha') }}</label>
                            <div class="password">
                                <input id="edit-user-password-confirm" type="password" class="passwordInput form-control" minLenght="8" maxLength="100" name="edit-user-password-confirm" disabled>
                                <label>
                                    <button type="button" class="passwordToggle" id="password-confirm" disabled onclick="toggle(this)">
                                        <i class="far fa-eye" id="password-confirm-toggle"></i>
                                    </button>
                                </label>
                            </div>
                            <label id="edit-user-password-confirm-error" class="error" for="edit-user-password-confirm"></label>
                        </div>
                        <div id="popover-password">
                            <p><span id="result"></span></p>
                            <div class="progress">
                                <div id="password-strength" class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                </div>
                            </div>
                            <ul class="mt-2 mb-2 list-unstyled row">
                                <div class="col-md-6">
                                    <li class="">
                                        <span class="low-upper-case">
                                            <i class="fas fa-circle" aria-hidden="true"></i>
                                            &nbsp;Maiúsculas &amp; minúsculas
                                        </span>
                                    </li>
                                    <li class="">
                                        <span class="one-number">
                                            <i class="fas fa-circle" aria-hidden="true"></i>
                                            &nbsp;Números (0-9)
                                        </span>
                                    </li>
                                </div>
                                <div class="col-md-6">
                                    <li class="">
                                        <span class="one-special-char">
                                            <i class="fas fa-circle" aria-hidden="true"></i>
                                            &nbsp;Caracteres Especiais (!@#$%^&*)
                                        </span>
                                    </li>
                                    <li class="">
                                        <span class="eight-character">
                                            <i class="fas fa-circle" aria-hidden="true"></i>
                                            &nbsp;Mínimo de 8 caracteres
                                        </span>
                                    </li>
                                </div>
                            </ul>
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

<script>
    let state = false;
    let password = document.getElementById("edit-user-password");
    let passwordStrength = document.getElementById("password-strength");
    let lowUpperCase = document.querySelector(".low-upper-case i");
    let number = document.querySelector(".one-number i");
    let specialChar = document.querySelector(".one-special-char i");
    let eightChar = document.querySelector(".eight-character i");

    password.addEventListener("keyup", function() {
        let pass = document.getElementById("edit-user-password").value;
        checkStrength(pass);
    });

    function generateStrongPassword(length) {

        const lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
        const uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const numericChars = '0123456789';
        const specialChars = '!%&@#$^*?_~';

        const allChars = lowercaseChars + uppercaseChars + numericChars + specialChars;

        let password = '';

        // Garante pelo menos um de cada tipo
        password += getRandomChar(lowercaseChars);
        password += getRandomChar(uppercaseChars);
        password += getRandomChar(numericChars);
        password += getRandomChar(specialChars);

        // Preenche o restante da senha com caracteres aleatórios
        for (let i = 4; i < length; i++) {
            password += getRandomChar(allChars);
        }

        // Embaralha a senha para torná-la mais segura
        password = shuffleString(password);
        checkStrength(password);
        document.getElementById("edit-user-password").value = password
        document.getElementById("edit-user-password-confirm").value = password;
    }

    function getRandomChar(charset) {
        const randomIndex = Math.floor(Math.random() * charset.length);
        return charset.charAt(randomIndex);
    }

    function shuffleString(string) {
        const array = string.split('');
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array.join('');
    }

    function toggle(show) {

        let element;
        let icon;
        if (show.id === 'password') {
            element = document.getElementById("edit-user-password");
            icon = document.getElementById("password-toggle");
        } else {
            element = document.getElementById("edit-user-password-confirm");
            icon = document.getElementById("password-confirm-toggle");
        }

        if (state) {
            icon.classList.replace("fa-eye-slash", "fa-eye");
            element.setAttribute("type", "password");
            state = false;
        } else {
            icon.classList.replace("fa-eye", "fa-eye-slash");
            element.setAttribute("type", "text")
            state = true;
        }
    }

    function checkStrength(password) {
        let strength = 0;
        //If password contains both lower and uppercase characters
        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
            strength += 1;
            lowUpperCase.classList.remove('fa-circle');
            lowUpperCase.classList.add('fa-check');
        } else {
            lowUpperCase.classList.add('fa-circle');
            lowUpperCase.classList.remove('fa-check');
        }
        //If it has numbers and characters
        if (password.match(/([0-9])/)) {
            strength += 1;
            number.classList.remove('fa-circle');
            number.classList.add('fa-check');
        } else {
            number.classList.add('fa-circle');
            number.classList.remove('fa-check');
        }
        //If it has one special character
        if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
            strength += 1;
            specialChar.classList.remove('fa-circle');
            specialChar.classList.add('fa-check');
        } else {
            specialChar.classList.add('fa-circle');
            specialChar.classList.remove('fa-check');
        }
        //If password is greater than 7
        if (password.length > 7) {
            strength += 1;
            eightChar.classList.remove('fa-circle');
            eightChar.classList.add('fa-check');
        } else {
            eightChar.classList.add('fa-circle');
            eightChar.classList.remove('fa-check');
        }

        if (strength < 2) {
            passwordStrength.classList.remove('progress-bar-warning');
            passwordStrength.classList.remove('progress-bar-success');
            passwordStrength.classList.add('progress-bar-danger');
            passwordStrength.style = 'width: 10%';
        } else if (strength == 3) {
            passwordStrength.classList.remove('progress-bar-success');
            passwordStrength.classList.remove('progress-bar-danger');
            passwordStrength.classList.add('progress-bar-warning');
            passwordStrength.style = 'width: 60%';
        } else if (strength == 4) {
            passwordStrength.classList.remove('progress-bar-warning');
            passwordStrength.classList.remove('progress-bar-danger');
            passwordStrength.classList.add('progress-bar-success');
            passwordStrength.style = 'width: 100%';
        }

    }


    function disablePasswordChange(check) {
        if (!check.checked) {
            // Desabilitar os campos e torná-los não obrigatórios
            $("#edit-user-password, #edit-user-password-confirm")
                .prop("disabled", true)
                .removeAttr("required")
                .val("");
            $("#strongPassword, .passwordToggle")
                .prop("disabled", true);

        } else {
            // Habilitar os campos e torná-los obrigatórios novamente
            $("#edit-user-password, #edit-user-password-confirm")
                .prop("disabled", false)
                .attr("required", "required")
                .val("");
            $("#strongPassword, .passwordToggle")
                .prop("disabled", false);
        }
    };

    function mask() {
        input = document.getElementById('edit-user-cnpj');
        var x = input.value;
        x = x.replace(/\D/g, "") //Remove tudo o que não é dígito
        x = x.slice(0, 14)
        x = x.replace(/^(\d{2})(\d)/, "$1.$2") //Coloca ponto entre o segundo e o terceiro dígitos
        x = x.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
        x = x.replace(/\.(\d{3})(\d)/, ".$1/$2") //Coloca uma barra entre o oitavo e o nono dígitos
        x = x.replace(/(\d{4})(\d)/, "$1-$2");
        input.value = x;
    }
</script>