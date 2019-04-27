<?php

require_once('Model/Evento.php');
require_once('Utilities/Functions.php');

$_SESSION["eventi"] = Evento::getAllEventi();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
    <title>Eventi - Rifugio Paolotti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="Eventi in programma al Rifugio Paolotti"/>
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
    <script type="text/javascript" src="js/headerScroll.js"></script>
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
            <li><a href="index.html" lang="en" tabindex="1">Home</a></li>
            <li><a href="dovesiamo.html" tabindex="2">Dove siamo</a></li>
            <li><a href="prenota.php" tabindex="3">Prenota</a></li>
            <li><a href="itinerari.html" tabindex="4">Itinerari</a></li>
            <li class="active"><a>Eventi</a></li>
        </ul>
    </div>
</div>

<div class="container text-center first-margin-mobile">
    <h1 class="titoli">Eventi</h1>
    <div class="hr-block">
        <div class="hr-line"></div>
        <div class="hr-icon"><span class="fas fa-glass-cheers fa-3x"></span></div>
        <div class="hr-line"></div>
    </div>
</div>

<div class="container before-footer">
    <?php foreach ($_SESSION["eventi"] as $evento): ?>
        <div class="flexible block-mobile evento">
            <div class="vertical-align-block itemToAligneventi">
                <span class="date hide-on-print"><?php echo substr($evento['data'], 8, 2) ?></span>
                <span class="month hide-on-print"><?php echo Functions::getMese(date("F", strtotime($evento['data']))) ?></span>
                <h2 class="show-on-print-only"><?php echo substr($evento['data'], 8, 2) . " " . Functions::getMese(date("F", strtotime($evento['data']))) ?></h2>
            </div>
            <div class="vertical-align-block eventi-text">
                <h3 class="titoloevento"><?php echo $evento['titolo'] ?></h3>
                <p><?php echo $evento['descrizione'] ?></p>
            </div>
            <div class="vertical-align-block itemToAligneventi hide-on-print">
                <?php if(!empty($evento['image'])):?>
                    <img src="<?php echo $evento['image'] ?>" alt="<?php echo $evento['titolo'] ?>"/>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div id="footer" class="text-center">
    <div class="container">
        <a href="http://validator.w3.org/check?uri=referer">
            <img class="left" src="images/valid-xhtml10.png" lang="en" alt="Valid XHTML 1.0 Strict"/>
        </a>
        <div id="footer-text">
            <em>Progetto del corso di Tecnologie Web 2018-2019</em>
            <strong><a id="linkAdmin" href="login.php" tabindex="5">Pannello di amministrazione</a></strong>
        </div>
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
            <img class="right" src="images/vcss-blue.gif" alt="CSS Valido!"/>
        </a>
    </div>
</div>

</body>

</html>
