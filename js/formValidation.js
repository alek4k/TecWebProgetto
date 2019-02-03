$(document).ready(function () {

    $("#name").focusout(function () {
        validateNome();
    });

    $("#email").focusout(function () {
        validateEmail();
    });

    $("#telefono").focusout(function () {
        validateTelefono();
    });

    $("#data").focusout(function () {
        validateData();
    });

    $('#formPrenotazione').submit(function( event ) {
        validateNome();
        validateEmail();
        validateTelefono();
        validateData();
        if ($('#btn_prenota').hasClass('btn-red'))
            event.preventDefault();
    });
});

function validateNome() {
    var msg = $('#nomeError');
    var nome = $('#name').val();
    if (nome.length < 3 || nome.length > 40) {
        msg.text("Inserire almeno 3 e massimo 40 caratteri per il nome");
        msg.removeClass('hidden');
        disablePrenotaBtn();
    }
    else {
        msg.addClass('hidden');
        enablePrenotaBtn();
    }
}

function validateEmail() {
    var msg = $('#emailError');
    var email = $('#email').val();
    if (emailCheck(email) || email.length === 0) {
        msg.addClass('hidden');
        enablePrenotaBtn();
    }
    else {
        msg.text("Indirizzo email non valido");
        msg.removeClass('hidden');
        disablePrenotaBtn();
    }
}

function validateTelefono() {
    var msg = $('#telefonoError');
    var telefono = $('#telefono').val();
    if (telephoneCheck(telefono)) {
        msg.addClass('hidden');
        enablePrenotaBtn();
    }
    else {
        msg.text("Numero di telefono non valido");
        msg.removeClass('hidden');
        disablePrenotaBtn();
    }
}

function validateData() {
    var msg = $('#dataError');
    var data = $('#data').val();
    if (dateCheck(data)) {
        msg.addClass('hidden');
        enablePrenotaBtn();
    }
    else {
        msg.text("Inserire data nel formato gg/mm/aaaa");
        msg.removeClass('hidden');
        disablePrenotaBtn();
    }
}

function disablePrenotaBtn() {
    var btnPrenota = $('#btn_prenota');
    btnPrenota.prop('disabled', true);
    btnPrenota.addClass('btn-red');
}

function enablePrenotaBtn() {
    var btnPrenota = $('#btn_prenota');

    if ($('#dataError').hasClass('hidden') &&
        $('#telefonoError').hasClass('hidden') &&
        $('#nomeError').hasClass('hidden') &&
        $('#emailError').hasClass('hidden')) {
        btnPrenota.prop('disabled', false);
        btnPrenota.removeClass('btn-red');
    }
}

function telephoneCheck(tel) {
    return /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im.test(tel);
}

function dateCheck(data) {
    return /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/.test(data);
}

function emailCheck(email) {
    var regExp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regExp.test(String(email).toLowerCase());
}