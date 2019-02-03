<?php

require_once('Model/Database.php');
require_once('Model/Prenotazione.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    nuovaPrenotazione();
}
else {
    header('Location: /alovo/prenota.html');
    die();
}

function nuovaPrenotazione()
{
    $error = "";
    $_SESSION["error_name"] = false;
    $_SESSION["error_telefono"] = false;
    $_SESSION["error_data"] = false;
    $_SESSION["error_numPersone"] = false;
    $_SESSION["error_email"] = false;

    if (empty($_POST["name"])) {
        $_SESSION["error_name"] = true;
        backToPrenota();
    }
    if (empty($_POST["telefono"])) {
        $_SESSION["error_telefono"] = true;
        backToPrenota();
    }
    if (empty($_POST["data"])) {
        $_SESSION["error_data"] = true;
        backToPrenota();
    }
    if (empty($_POST["numeroPersone"])) {
        $_SESSION["error_numPersone"] = true;
        backToPrenota();
    }

    $name = $_POST["name"];
    $telefono = $_POST["telefono"];
    $data = $_POST["data"];
    $numPersone = $_POST["numeroPersone"];
    $email = $_POST["email"];
    $note = $_POST["note"];

    if ((!is_string($name)) || (strlen($name) < 3) || (strlen($name) > 40)) {
        $_SESSION["error_name"] = true;
        backToPrenota();
    }
    if ((!is_string($data)) || (strlen($data) != 10) || (!isDate($data))) {
        $_SESSION["error_data"] = true;
        backToPrenota();
    }
    if ((!is_string($telefono)) || (strlen($telefono) < 10) || (strlen($telefono) > 13)) {
        $_SESSION["error_telefono"] = true;
        backToPrenota();
    }
    if ((!is_string($numPersone)) || (!filter_var($numPersone, FILTER_VALIDATE_INT))) {
        $_SESSION["error_numPersone"] = true;
        backToPrenota();
    }
    if ((!empty($_POST["email"])) && ((!is_string($email)) || (!filter_var($email, FILTER_VALIDATE_EMAIL)))) {
        $_SESSION["error_email"] = true;
        backToPrenota();
    }

    $prenotazione = new Prenotazione();
    $prenotazione->setName(pulisciInput($name));
    $prenotazione->setEmail(pulisciInput($email));
    $prenotazione->setTelefono(pulisciInput($telefono));
    $prenotazione->setPersone(pulisciInput($numPersone));
    $prenotazione->setData(pulisciInput($data));
    $prenotazione->setNote(pulisciInput($note));

    if ($prenotazione->createPrenotazione($error)) {
        $_SESSION["prenotazioneCreata"] = true;
    }
    else {
        $_SESSION["prenotazioneCreata"] = false;
    }

    backToPrenota();
}

function backToPrenota()
{
    header('Location: /alovo/prenota.html');
    die();
}

function isDate($string) {
    $matches = array();
    $pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/';
    if (!preg_match($pattern, $string, $matches)) return false;
    if (!checkdate($matches[2], $matches[1], $matches[3])) return false;
    return true;
}

function isPhone($string) {
    $matches = array();
    $pattern = '/^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/gm';
    if (!preg_match($pattern, $string, $matches)) return false;
    return true;
}

function pulisciInput($value) {
    $value = trim($value);
    $value = htmlentities($value);
    $value = strip_tags($value);
    return $value;
}