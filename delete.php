<?php

require_once('Model/Database.php');
require_once('Model/Admin.php');
require_once('Model/Prenotazione.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["token"])) {
    header('Location: /alovo/login.php');
    die();
}

if (!empty($_GET["admin"])) {
    if ($_GET["admin"] === $_SESSION["username"]) {
        backToAdmin();
    }

    $toDelete = new Admin();
    $toDelete->setUsername($_GET["admin"]);
    $toDelete->delete();

    backToAdmin();
}

if (!empty($_GET["prenotazione"])) {
    $toDelete = new Prenotazione();
    $toDelete->setId($_GET["prenotazione"]);
    $toDelete->delete();

    backToPrenotazioni();
}

function backToAdmin() {
    header('Location: /alovo/admin.php');
    die();
}

function backToPrenotazioni() {
    header('Location: /alovo/prenotazioni.php');
    die();
}