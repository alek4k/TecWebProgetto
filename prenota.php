<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
    <title>Prenota - Rifugio Paolotti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="Prenotazione pernotti"/>
    <meta name="author" content="Alberto Corrocher, Alessandro Lovo, Amedeo Meggiolaro, Victor Ducta"/>
    <meta name="keywords"
          content="montagna, rifugio, dolomiti, alpi, ristorazione, altopiano, itinerari, roccia, escursione, sentieri, bosco"/>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <meta name="language" content="italian it"/>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="handheld, screen"/>
    <link rel="stylesheet" type="text/css" href="css/desktop.css"
          media="handheld, screen and (max-width:1200px), only screen and (max-device-width:1200px)"/>
    <link rel="stylesheet" type="text/css" href="css/tablet.css"
          media="handheld, screen and (max-width:992px),	only screen and (max-device-width:992px)"/>
    <link rel="stylesheet" type="text/css" href="css/mobile.css"
          media="handheld, screen and (max-width:600px), only screen and (max-device-width:600px)"/>
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print"/>
    <link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" media="handheld, screen"/>
    <link rel="stylesheet" type="text/css" href="css/solid.min.css" media="handheld, screen"/>
    <script type="text/javascript" src="js/jquery-3.3.1.slim.min.js"></script>
    <script type="text/javascript" src="js/headerScrollMobile.js"></script>
    <script type="text/javascript" src="js/hamburger.js"></script>
    <script type="text/javascript" src="js/formValidation.js"></script>
</head>

<body>
<div id="topHeader">
    <div id="header-main" class="container">
        <div class="vertical-align-block">
            <img id="logo" src="images/logo.png" alt="logo del rifugio Paolotti"/>
        </div>
        <div id="contact-header" class="vertical-align-block">
            <div class="right">
                <a id="hamburger-menu" class="show-on-small"><span class="fas fa-bars fa-2x"></span></a>
                <div class="firstContactItem vertical-align-block hide-on-small-only">
                    <div class="vertical-align-block">
                        <span class="fas fa-phone fa-2x left"></span>
                    </div>
                    <div class="vertical-align-block">
                        <p>TELEFONO</p>
                        <p>0324-694856</p>
                    </div>
                </div>
                <div class="vertical-align-block hide-on-small-only">
                    <div class="vertical-align-block">
                        <span class="fas fa-at fa-2x left"></span>
                    </div>
                    <div class="vertical-align-block">
                        <p>EMAIL</p>
                        <p>info@rifugiopaolotti.it</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="navbar">
    <div id="navbar-content" class="container">
        <ul id="menu">
            <li><a href="index.html" lang="en" tabindex="1">Home</a></li>
            <li><a href="dovesiamo.html" tabindex="2">Dove siamo</a></li>
            <li class="active"><a href="">Prenota</a></li>
            <li><a href="itinerari.html" tabindex="3">Itinerari</a></li>
            <li><a href="eventi.php" tabindex="4">Eventi</a></li>
        </ul>
    </div>
</div>

<div class="container text-center first-margin-mobile">
    <h1 class="titoli">Prenota</h1>
    <div class="hr-block">
        <div class="hr-line"></div>
        <div class="hr-icon"><span class="fas fa-user-edit fa-3x"></span></div>
        <div class="hr-line"></div>
    </div>
</div>

<div class="container before-footer">
    <div class="margin2">
        <?php if (!empty($_SESSION["prenotazioneCreata"])): ?>
            <p id="createSuccess" class="successText">Prenotazione effettuata. Verrai contattato per conferma il prima possibile!</p>
        <?php endif; ?>
        <?php if ($_SESSION["error_name"] === true): ?>
            <p id="nomeError" class="errorText">Inserire almeno 3 e massimo 40 caratteri per il nome</p>
        <?php else: ?>
            <p id="nomeError" class="errorText hidden">Inserire almeno 3 e massimo 40 caratteri per il nome</p>
        <?php endif; ?>
        <?php if ($_SESSION["error_email"] === true): ?>
            <p id="emailError" class="errorText">Indirizzo email non valido</p>
        <?php else: ?>
            <p id="emailError" class="errorText hidden">Indirizzo email non valido</p>
        <?php endif; ?>
        <?php if ($_SESSION["error_telefono"] === true): ?>
            <p id="telefonoError" class="errorText">Numero di telefono non valido</p>
        <?php else: ?>
            <p id="telefonoError" class="errorText hidden">Numero di telefono non valido</p>
        <?php endif; ?>
        <?php if ($_SESSION["error_data"] === true): ?>
            <p id="dataError" class="errorText">Inserire data nel formato gg/mm/aaaa</p>
        <?php else: ?>
            <p id="dataError" class="errorText hidden">Inserire data nel formato gg/mm/aaaa</p>
        <?php endif; ?>
        <?php
        $_SESSION["prenotazioneCreata"] = false;
        $_SESSION["error_name"] = false;
        $_SESSION["error_telefono"] = false;
        $_SESSION["error_data"] = false;
        $_SESSION["error_numPersone"] = false;
        $_SESSION["error_email"] = false;
        ?>
    </div>

    <form action='add-prenotazione.php' method="post" class='form' id="formPrenotazione">
        <div class='field required'>
            <label class='label required' for='name'>Nome e Cognome</label>
            <input class='text-input' id='name' name='name' type='text' tabindex="5"/>
        </div>
        <div class='field half'>
            <label class='label' for='email'>E-mail</label>
            <input class='text-input' id='email' name='email' type="text" tabindex="6"/>
        </div>
        <div class='field required half'>
            <label class='label' for='telefono'>Telefono</label>
            <input class='text-input' id='telefono' name='telefono' type='text' tabindex="7"/>
        </div>
        <div class='field half required'>
            <label class='label' for='data'>Data Arrivo (gg/mm/aaaa)</label>
            <input class="select" id="data" name="data" type="text" tabindex="8"/>
        </div>
        <div class='field half'>
            <label class='label' for='numeroPersone'>Persone</label>
            <select class='select' id='numeroPersone' name="numeroPersone" tabindex="9">
                <option value='1'>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>
                <option value='6'>6</option>
                <option value='7'>7</option>
            </select>
        </div>
        <div class='field'>
            <label class='label' for='note'>Note</label>
            <textarea class='textarea' cols='50' id='note' name='note' rows='4' tabindex="10"></textarea>
        </div>
        <div class="centerAlign">
            <input class="btn btn-submit" id="btn_prenota" type="submit" value="prenota" tabindex="11"/>
        </div>
    </form>
</div>

<div id="footer" class="text-center">
    <div class="container">
        <a href="http://validator.w3.org/check?uri=referer">
            <img class="left" src="images/valid-xhtml10.png" lang="en" alt="Valid XHTML 1.0 Strict"/>
        </a>
        <div id="footer-text">
            <em>Progetto del corso di Tecnologie Web 2018-2019</em>
            <strong><a id="linkAdmin" href="login.php" tabindex="12">Pannello di amministrazione</a></strong>
        </div>
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
            <img class="right" src="images/vcss-blue.gif" alt="CSS Valido!"/>
        </a>
    </div>
</div>


</body>

</html>
