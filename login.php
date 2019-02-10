<?php

require_once('Utilities/Functions.php');

if (isset($_SESSION["token"])) {
    Functions::backToAdmin();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
    <title>Login - Rifugio Paolotti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="Login amministratori Rifugio Paolotti"/>
    <meta name="author" content="Alberto Corrocher, Alessandro Lovo, Amedeo Meggiolaro, Victor Ducta"/>
    <meta name="keywords"
          content="montagna, rifugio, dolomiti, alpi, ristorazione, altopiano, itinerari, roccia, escursione, sentieri, bosco"/>
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
            <li><a href="prenota.php" tabindex="3">Prenota</a></li>
            <li><a href="itinerari.html" tabindex="4">Itinerari</a></li>
            <li><a href="eventi.php" tabindex="4">Eventi</a></li>
        </ul>
    </div>
</div>


<div class="container text-center first-margin-mobile">
    <h1 class="titoli">Login</h1>
    <div class="hr-block">
        <div class="hr-line"></div>
        <div class="hr-icon"><span class="fas fa-lock fa-3x"></span></div>
        <div class="hr-line"></div>
    </div>
</div>

<div class="container before-footer">
    <div class="margin2">
        <?php if (!empty($_SESSION["session_expired"])): ?>
            <p class="errorText">Sessione scaduta, effettuare il login</p>
        <?php endif; ?>
        <?php if (!empty($_SESSION["error_login"])): ?>
            <p id="loginError" class="errorText">Credenziali non valide</p>
        <?php else: ?>
            <p id="loginError" class="errorText hidden">Credenziali non valide</p>
        <?php endif; ?>
        <?php
        $_SESSION["error_login"] = false;
        $_SESSION["session_expired"] = false;
        ?>
    </div>

    <form action="administrator.php" method="post" class="form" id="formLogin">
        <div class='field required'>
            <label class='label required' for='username'>Username</label>
            <input class='text-input' id='username' name='username' type='text' tabindex="5"/>
        </div>
        <div class='field required'>
            <label class='label required' for='password'>Password</label>
            <input class='text-input' id='password' name='password' type='password' tabindex="6"/>
        </div>
        <div class="centerAlign">
            <input class="btn btn-submit" id="btn_login" type="submit" value="accedi" tabindex="7"/>
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
            <strong class="active"><a id="linkAdmin" tabindex="8">Pannello di amministrazione</a></strong>
        </div>
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
            <img class="right" src="images/vcss-blue.gif" alt="CSS Valido!"/>
        </a>
    </div>
</div>

</body>

</html>