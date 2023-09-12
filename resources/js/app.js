import './bootstrap';

import 'inputmask/dist/jquery.inputmask.min';
import $ from 'jquery';

$(document).ready(function () {
    $('input[name="cnpj"]').inputmask({
        mask: '99.999.999/9999-99',
        showMaskOnHover: false,
        greedy: false,
        keepStatic: true,
        definitions: {
            '9': {
                validator: '[0-9]',
                cardinality: 1, // Mostra apenas um dígito por definição
            },
        },
    }); 
});