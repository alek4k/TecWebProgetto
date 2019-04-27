<?php

require_once('Model/Database.php');
require_once('Model/Admin.php');
require_once('Utilities/Functions.php');

Functions::checkLogin();
Functions::checkTokenExpiration();

$listaAdmin = Admin::getAllAdmin();
$i = 0;
foreach ($listaAdmin as $admin) {
    if ($admin['username'] === $_SESSION["username"]) {
        unset($listaAdmin[$i]);
        break;
    }
    $i += 1;
}
$_SESSION["amministratori"] = $listaAdmin;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
    <title>Amministratori - Rifugio Paolotti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="Gestione amministratori pannello di controllo"/>
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
            <li class="active"><a href="">Amministratori</a></li>
            <li><a href="eventiManager.php" tabindex="1">Eventi</a></li>
            <li><a href="prenotazioni.php" tabindex="2">Prenotazioni</a></li>
            <li><a href="logout.php" tabindex="3">Logout</a></li>
        </ul>
    </div>
</div>

<div class="container text-center first-margin-mobile">
    <h1 class="titoli">Gestione amministratori</h1>
    <div class="hr-block">
        <div class="hr-line"></div>
        <div class="hr-icon"><span class="fas fa-user-cog fa-3x"></span></div>
        <div class="hr-line"></div>
    </div>
</div>

<div class="container before-footer margin2">
    <div class="content-half margin2">
        <ul id="lista-admin">
            <?php foreach ($_SESSION["amministratori"] as $admin): ?>
                <li><a href="delete.php?admin=<?php echo $admin['username'] ?>" class="btn btn-red"><span
                                class="fa far fa-trash-alt"></span> elimina</a><?php echo ' ' . $admin['username']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div id="newAdmin" class="content-half text-center margin2">
        <h2>Nuovo amministratore</h2>
        <?php if (!empty($_SESSION["error_createAdmin"])): ?>
            <p class="errorText">Username non disponibile!</p>
        <?php else: ?>
            <?php if ($_SESSION["error_username_newAdmin"] === true): ?>
                <p class="errorText">Inserire username di lunghezza tra 3 e 12 caratteri</p>
            <?php else: ?>
                <p class="errorText hidden">Inserire username di lunghezza tra 3 e 12 caratteri</p>
            <?php endif; ?>
            <?php if ($_SESSION["error_password_newAdmin"] === true): ?>
                <p class="errorText">Inserire password di lunghezza tra 5 e 12 caratteri</p>
            <?php else: ?>
                <p class="errorText hidden">Inserire password di lunghezza tra 5 e 12 caratteri</p>
            <?php endif; ?>
        <?php endif; ?>
        <?php
        $_SESSION["error_createAdmin"] = false;
        $_SESSION["error_username_newAdmin"] = false;
        $_SESSION["error_password_newAdmin"] = false;
        ?>
        <form action="add-admin.php" method="post" class="form" id="formLogin">
            <div class='field half required'>
                <label class='label required' for='username'>Username</label>
                <input class='text-input' id='username' name='username' type='text' tabindex="4"/>
            </div>
            <div class='field half required'>
                <label class='label required' for='password'>Password</label>
                <input class='text-input' id='password' name='password' type='password' tabindex="5"/>
            </div>
            <div class="centerAlign">
                <input class="btn btn-submit" id="btn_login" type="submit" value="aggiungi" tabindex="6"/>
            </div>
        </form>
    </div>
</div>

<div id="footer" class="text-center">
    <div class="container">
        <a href="http://validator.w3.org/check?uri=referer">
            <img class="left" src="images/valid-xhtml10.png" lang="en" alt="Valid XHTML 1.0 Strict"/>
        </a>
        <div id="footer-text">
            <em>Progetto del corso di Tecnologie Web 2018-2019</em>
            <strong><a id="linkAdmin" href="index.html" tabindex="7">Torna al sito</a></strong>
        </div>
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
            <img class="right" src="images/vcss-blue.gif" alt="CSS Valido!"/>
        </a>
    </div>
</div>


</body>

</html>
