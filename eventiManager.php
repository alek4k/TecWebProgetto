<?php

require_once('Model/Evento.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["token"])) {
    header('Location: /alovo/login.php');
    die();
}

$_SESSION["eventi"] = Evento::getAllEventi();

function getMese($month)
{
    $mese = $month;
    switch ($month) {
        case 'January':
            $mese = 'Gennaio';
            break;
        case 'February':
            $mese = 'Febbraio';
            break;
        case 'March':
            $mese = 'Marzo';
            break;
        case 'April':
            $mese = 'Aprile';
            break;
        case 'May':
            $mese = 'Maggio';
            break;
        case 'June':
            $mese = 'Giugno';
            break;
        case 'July':
            $mese = 'Luglio';
            break;
        case 'August':
            $mese = 'Agosto';
            break;
        case 'September':
            $mese = 'Settembre';
            break;
        case 'October':
            $mese = 'Ottobre';
            break;
        case 'November':
            $mese = 'Novembre';
            break;
        case 'December':
            $mese = 'Dicembre';
            break;
    }
    return $mese;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
    <title>Eventi - Rifugio Paolotti</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="Crea e gestisci gli eventi del rifugio"/>
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
            <li><a href="admin.php">Amministratori</a></li>
            <li class="active"><a>Eventi</a></li>
            <li><a href="prenotazioni.php">Prenotazioni</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>

<div class="container text-center first-margin-mobile">
    <h1 class="titoli">Gestione eventi</h1>
    <div class="hr-block">
        <div class="hr-line"></div>
        <div class="hr-icon"><i class="fas fa-glass-cheers fa-3x"></i></div>
        <div class="hr-line"></div>
    </div>
</div>

<div class="container before-footer">
    <div class="margin2">
        <?php if (!empty($_SESSION["eventoCreato"])): ?>
            <p class="successText">Evento pubblicato!</p>
        <?php else: ?>
            <?php if ($_SESSION["error_titolo"] === true): ?>
                <p id="titoloError" class="errorText">Lunghezza titolo non valida</p>
            <?php else: ?>
                <p id="titoloError" class="errorText hidden">Lunghezza titolo non valida</p>
            <?php endif; ?>
            <?php if ($_SESSION["error_descrizione"] === true): ?>
                <p id="descriptionError" class="errorText">Lunghezza descrizione non valida</p>
            <?php else: ?>
                <p id="descriptionError" class="errorText hidden">Lunghezza descrizione non valida</p>
            <?php endif; ?>
            <?php if ($_SESSION["error_data"] === true): ?>
                <p id="dataError" class="errorText">Inserire data nel formato gg/mm/aaaa</p>
            <?php else: ?>
                <p id="dataError" class="errorText hidden">Inserire data nel formato gg/mm/aaaa</p>
            <?php endif; ?>
            <?php if ($_SESSION["error_image"] === true): ?>
                <p id="imageError" class="errorText">File immagine non valido</p>
            <?php else: ?>
                <p id="imageError" class="errorText hidden">File immagine non valido</p>
            <?php endif; ?>
        <?php endif; ?>
        <?php
        $_SESSION["eventoCreato"] = false;
        $_SESSION["error_titolo"] = false;
        $_SESSION["error_descrizione"] = false;
        $_SESSION["error_data"] = false;
        $_SESSION["error_image"] = false;
        ?>
    </div>

    <form action='add-evento.php' method="post" class='form' id="formEvento" enctype="multipart/form-data">
        <div class='field required'>
            <label class='label required' for='titolo'>Titolo</label>
            <input class='text-input' id='titolo' name='titolo' type='text'>
        </div>
        <div class='field half required'>
            <label class='label' for='data'>Data (gg/mm/aaaa)</label>
            <input class="select" id="data" name="data" type="text">
        </div>
        <div class='field half'>
            <label class='label' for='image'>Immagine</label>
            <input class='text-input' id='image' name='image' type="file">
        </div>
        <div class='field required'>
            <label class='label' for='descrizione'>Descrizione</label>
            <textarea class='textarea' cols='50' id='descrizione' name='descrizione' rows='4'></textarea>
        </div>
        <div class="centerAlign">
            <input class="btn btn-submit" id="btn_creaEvento" type="submit" name="submit" value="crea evento"/>
        </div>
    </form>

    <?php foreach ($_SESSION["eventi"] as $evento): ?>
        <div class="flexible block-mobile evento">
            <div class="vertical-align-block itemToAligneventi alignPrenotazioni hide-on-print">
                <span class="date"><?php echo substr($evento['data'], 8, 2) ?></span>
                <span class="month"><?php echo getMese(date("F", strtotime($evento['data']))) ?></span>
            </div>
            <div class="vertical-align-block eventi-text">
                <p class="titoloevento"><?php echo $evento['titolo'] ?></p>
                <p><?php echo $evento['descrizione'] ?></p>
            </div>
            <div class="vertical-align-block itemToAligneventi alignPrenotazioni hide-on-print">
                <a href="delete.php?evento=<?php echo $evento['Id'] ?>" class="btn btn-red"><i
                            class="fa far fa-trash-alt"></i> elimina</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div id="footer" class="text-center">
    <div class="container">
        <a href="http://validator.w3.org/check?uri=referer">
            <img class="left" src="images/valid-xhtml10.png" alt="Valid XHTML 1.0 Strict"/>
        </a>
        <div id="footer-text">
            <em>Progetto del corso di Tecnologie Web 2018-2019</em>
            <strong><a id="linkAdmin" href="index.html">Torna al sito</a></strong>
        </div>
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
            <img class="right" src="images/vcss-blue.gif" alt="CSS Valido!"/>
        </a>
    </div>
</div>


</body>

</html>
