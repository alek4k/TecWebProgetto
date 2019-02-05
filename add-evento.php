<?php

require_once('Model/Database.php');
require_once('Model/Evento.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    nuovoEvento();
} else {
    backToEventiManager();
}

function nuovoEvento()
{
    $error = "";
    $count = 0;
    $_SESSION["error_titolo"] = false;
    $_SESSION["error_descrizione"] = false;
    $_SESSION["error_data"] = false;
    $_SESSION["error_image"] = false;
    $_SESSION["eventoCreato"] = false;

    if (empty($_POST["titolo"])) {
        $_SESSION["error_titolo"] = true;
        $count += 1;
    }
    if (empty($_POST["descrizione"])) {
        $_SESSION["error_descrizione"] = true;
        $count += 1;
    }
    if (empty($_POST["data"])) {
        $_SESSION["error_data"] = true;
        $count += 1;
    }
    if (empty($_POST["image"])) {
        $_SESSION["error_image"] = true;
        $count += 1;
    }

    $titolo = $_POST["titolo"];
    $descrizione = $_POST["descrizione"];
    $data = $_POST["data"];
    $image = $_POST["image"];

    if ((!is_string($titolo)) || (strlen($titolo) < 1) || (strlen($titolo) > 99)) {
        $_SESSION["error_titolo"] = true;
        $count += 1;
    }
    if ((!is_string($data)) || (strlen($data) != 10) || (!isDate($data))) {
        $_SESSION["error_data"] = true;
        $count += 1;
    }
    if ((!is_string($descrizione)) || (strlen($descrizione) < 1) || (strlen($descrizione) > 999)) {
        $_SESSION["error_descrizione"] = true;
        $count += 1;
    }
    if ((!is_string($image)) || (strlen($image) < 1)) {
        $_SESSION["error_image"] = true;
        $count += 1;
    }

    if ($count > 0) backToEventiManager();

    $evento = new Evento();
    $evento->setTitolo(pulisciInput($titolo));
    $evento->setDescrizione(pulisciInput($descrizione));
    $evento->setData(pulisciInput($data));
    $evento->setImage(pulisciInput($image));

    if ($evento->createEvento($error)) {
        $_SESSION["eventoCreato"] = true;
    } else {
        $_SESSION["eventoCreato"] = false;
    }

    backToEventiManager();
}

function backToEventiManager()
{
    header('Location: /alovo/eventiManager.php');
    die();
}

function isDate($string)
{
    $matches = array();
    $pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/';
    if (!preg_match($pattern, $string, $matches)) return false;
    if (!checkdate($matches[2], $matches[1], $matches[3])) return false;
    return true;
}

function pulisciInput($value)
{
    $value = trim($value);
    $value = htmlentities($value);
    $value = strip_tags($value);
    return $value;
}