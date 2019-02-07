$(document).ready(function () {

    //form prenotazione
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

    $('#formPrenotazione').submit(function (event) {
        validateNome();
        validateEmail();
        validateTelefono();
        validateData();
        $('#createSuccess').addClass('hidden');
        if ($('#btn_prenota').hasClass('btn-red'))
            event.preventDefault();
    });

    //form login
    $("#username").focusout(function () {
        validateUsername();
    });

    $("#password").focusout(function () {
        validatePassword();
    });

    $('#formLogin').submit(function (event) {
        validateUsername();
        validatePassword();
        if ($('#btn_login').hasClass('btn-red'))
            event.preventDefault();
    });

});

function validateNome() {
    $('#createSuccess').addClass('hidden');
    var msg = $('#nomeError');
    var nome = $('#name').val();
    if (nome.length < 3 || nome.length > 40) {
        msg.removeClass('hidden');
        disablePrenotaBtn();
    } else {
        msg.addClass('hidden');
        enablePrenotaBtn();
    }
}

function validateEmail() {
    $('#createSuccess').addClass('hidden');
    var msg = $('#emailError');
    var email = $('#email').val();
    if (emailCheck(email) || email.length === 0) {
        msg.addClass('hidden');
        enablePrenotaBtn();
    } else {
        msg.removeClass('hidden');
        disablePrenotaBtn();
    }
}

function validateTelefono() {
    $('#createSuccess').addClass('hidden');
    var msg = $('#telefonoError');
    var telefono = $('#telefono').val();
    if (telephoneCheck(telefono)) {
        msg.addClass('hidden');
        enablePrenotaBtn();
    } else {
        msg.removeClass('hidden');
        disablePrenotaBtn();
    }
}

function validateData() {
    $('#createSuccess').addClass('hidden');
    var msg = $('#dataError');
    var data = $('#data').val();
    if (dateCheck(data)) {
        msg.addClass('hidden');
        enablePrenotaBtn();
    } else {
        msg.removeClass('hidden');
        disablePrenotaBtn();
    }
}

function validatePassword() {
    var msg = $('#loginError');
    var password = $('#password').val();
    if (password.length > 4 && password.length < 13) {
        msg.addClass('hidden');
        enableLoginBtn();
    } else {
        msg.removeClass('hidden');
        disableLoginBtn();
    }
}

function validateUsername() {
    var msg = $('#loginError');
    var username = $('#username').val();
    if (username.length > 2 && username.length < 13) {
        msg.addClass('hidden');
        enableLoginBtn();
    } else {
        msg.removeClass('hidden');
        disableLoginBtn();
    }
}

function disablePrenotaBtn() {
    var btnPrenota = $('#btn_prenota');
    btnPrenota.prop('disabled', true);
    btnPrenota.addClass('btn-red');
}

function disableLoginBtn() {
    var btnLogin = $('#btn_login');
    btnLogin.prop('disabled', true);
    btnLogin.addClass('btn-red');
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

function enableLoginBtn() {
    var btnLogin = $('#btn_login');

    if ($('#loginError').hasClass('hidden')) {
        btnLogin.prop('disabled', false);
        btnLogin.removeClass('btn-red');
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