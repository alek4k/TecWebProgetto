<?php

require_once('Model/Database.php');
require_once('Model/Admin.php');
require_once('Model/Prenotazione.php');
require_once('Model/Evento.php');
require_once('Utilities/Functions.php');

Functions::checkLogin();
Functions::checkTokenExpiration();

if (!empty($_GET["admin"])) {
    if ($_GET["admin"] === $_SESSION["username"]) {
        Functions::backToAdmin();
    }

    $toDelete = new Admin();
    $toDelete->setUsername($_GET["admin"]);
    $toDelete->delete();

    Functions::backToAdmin();
}

if (!empty($_GET["prenotazione"])) {
    $toDelete = new Prenotazione();
    $toDelete->setId($_GET["prenotazione"]);
    $toDelete->delete();

    Functions::backToPrenotazioni();
}

if (!empty($_GET["evento"])) {
    $toDelete = new Evento();
    $toDelete->setId($_GET["evento"]);
    $toDelete->delete();

    Functions::backToEventiManager();
}