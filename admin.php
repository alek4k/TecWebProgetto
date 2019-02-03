<?php

require_once('Model/Database.php');
require_once('Model/Admin.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["token"])) {
    header('Location: /alovo/login.php');
    die();
}

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
    <title>Amministratori</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="Rifugio alpino"/>
    <meta name="author" content="Alberto Corrocher, Alessandro Lovo, Amedeo Meggiolaro, Victor Ducta"/>
    <meta name="keywords"
          content="montagna, rifugio, dolomiti, alpi, ristorazione, altopiano, itinerari, roccia, escursione, sentieri, bosco"/>
    <meta name="language" content="italian it"/>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="handheld, screen"/>
    <link rel="stylesheet" type="text/css" href="css/desktop.css" media="handheld, screen and (max-width:1200px), only screen and (max-device-width:1200px)"/>
    <link rel="stylesheet" type="text/css" href="css/tablet.css" media="handheld, screen and (max-width:992px),	only screen and (max-device-width:992px)"/>
    <link rel="stylesheet" type="text/css" href="css/mobile.css" media="handheld, screen and (max-width:600px), only screen and (max-device-width:600px)"/>
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
                <a id="hamburger-menu" class="show-on-small"><i class="fas fa-bars fa-2x"></i></a>
                <div class="firstContactItem vertical-align-block hide-on-small-only">
                    <div class="vertical-align-block">
                        <i class="fas fa-phone fa-2x left"></i>
                    </div>
                    <div class="vertical-align-block">
                        <p>TELEFONO</p>
                        <p>0324-694856</p>
                    </div>
                </div>
                <div class="vertical-align-block hide-on-small-only">
                    <div class="vertical-align-block">
                        <i class="fas fa-at fa-2x left"></i>
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
            <li class="active"><a href="" lang="en">Amministratori</a></li>
            <li><a href="#">Eventi</a></li>
            <li><a href="#">Prenotazioni</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </div>
</div>

<div class="container text-center first-margin-mobile">
    <h1 class="titoli">Gestione amministratori</h1>
    <div class="hr-block">
        <div class="hr-line"></div>
        <div class="hr-icon"><i class="fas fa-user-cog fa-3x"></i></div>
        <div class="hr-line"></div>
    </div>
</div>

<div class="container before-footer margin2">
    <div class="content-half margin2">
        <ul id="lista-admin">
            <?php foreach ($_SESSION["amministratori"] as $admin): ?>
                <li><a href="/alovo/delete.php?admin=<?php echo $admin['username']?>" class="btn btn-red"><i class="fa far fa-trash-alt"></i> elimina</a><?php echo ' '.$admin['username']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div id="newAdmin" class="content-half text-center margin2">
        <h2>Nuovo amministratore</h2>
        <form action="administrator.php" method="post" class="form" id="formLogin">
            <div class='field half required'>
                <label class='label required' for='username'>Username</label>
                <input class='text-input' id='username' name='username' type='text'>
            </div>
            <div class='field half required'>
                <label class='label required' for='password'>Password</label>
                <input class='text-input' id='password' name='password' type='password'>
            </div>
            <div class="centerAlign">
                <input class="btn btn-submit" id="btn_login" type="submit" value="accedi"/>
            </div>
        </form>
    </div>
</div>

<div id="footer" class="text-center">
    <div class="container">
        <a href="http://validator.w3.org/check?uri=referer">
            <img class="left" src="images/valid-xhtml10.png" alt="Valid XHTML 1.0 Strict" />
        </a>
        <div id="footer-text">
            <em>Progetto del corso di Tecnologie Web 2018-2019</em>
            <strong><a id="linkAdmin" href="login.php">Pannello di amministrazione</a></strong>
        </div>
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
            <img class="right" src="images/vcss-blue.gif" alt="CSS Valido!" />
        </a>
    </div>
</div>


</body>

</html>