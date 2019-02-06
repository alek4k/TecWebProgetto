<?php

require_once('Model/Database.php');
require_once('Model/Prenotazione.php');
require_once('Utilities/Functions.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    nuovaPrenotazione();
} else {
    backToPrenota();
}

function nuovaPrenotazione()
{
    $error = "";
    $count = 0;
    $_SESSION["error_name"] = false;
    $_SESSION["error_telefono"] = false;
    $_SESSION["error_data"] = false;
    $_SESSION["error_numPersone"] = false;
    $_SESSION["error_email"] = false;
    $_SESSION["prenotazioneCreata"] = false;

    if (empty($_POST["name"])) {
        $_SESSION["error_name"] = true;
        $count += 1;
    }
    if (empty($_POST["telefono"])) {
        $_SESSION["error_telefono"] = true;
        $count += 1;
    }
    if (empty($_POST["data"])) {
        $_SESSION["error_data"] = true;
        $count += 1;
    }
    if (empty($_POST["numeroPersone"])) {
        $_SESSION["error_numPersone"] = true;
        $count += 1;
    }

    $name = $_POST["name"];
    $telefono = $_POST["telefono"];
    $data = $_POST["data"];
    $numPersone = $_POST["numeroPersone"];
    $email = $_POST["email"];
    $note = $_POST["note"];

    if ((!is_string($name)) || (strlen($name) < 3) || (strlen($name) > 40)) {
        $_SESSION["error_name"] = true;
        $count += 1;
    }
    if ((!is_string($data)) || (strlen($data) != 10) || (!isDate($data))) {
        $_SESSION["error_data"] = true;
        $count += 1;
    }
    if ((!is_string($telefono)) || (strlen($telefono) < 10) || (strlen($telefono) > 13)) {
        $_SESSION["error_telefono"] = true;
        $count += 1;
    }
    if ((!is_string($numPersone)) || (!filter_var($numPersone, FILTER_VALIDATE_INT))) {
        $_SESSION["error_numPersone"] = true;
        $count += 1;
    }
    if ((!empty($_POST["email"])) && ((!is_string($email)) || (!filter_var($email, FILTER_VALIDATE_EMAIL)))) {
        $_SESSION["error_email"] = true;
        $count += 1;
    }

    if ($count > 0) backToPrenota();

    $prenotazione = new Prenotazione();
    $prenotazione->setName(pulisciInput($name));
    $prenotazione->setEmail(pulisciInput($email));
    $prenotazione->setTelefono(pulisciInput($telefono));
    $prenotazione->setPersone(pulisciInput($numPersone));
    $prenotazione->setData(pulisciInput($data));
    $prenotazione->setNote(pulisciInput($note));

    if ($prenotazione->createPrenotazione($error)) {
        $_SESSION["prenotazioneCreata"] = true;
    } else {
        $_SESSION["prenotazioneCreata"] = false;
    }

    backToPrenota();
}

function backToPrenota()
{
    header('Location: '.Functions::$mainDirectory.'prenota.php');
    die();
}

function isDate($string)
{
    $matches = array();
    $pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/';
    if (!preg_match($pattern, $string, $matches)) return false;
    if (!checkdate($matches[2], $matches[1], $matches[3])) return false;

    //controllo che la data non sia passata
    $yyyymmdd = strtotime(date("Y-d-m", strtotime($string)));
    $now = strtotime(date('Y-m-d'));
    if ($yyyymmdd < $now) return false;

    return true;
}

function isPhone($string)
{
    $matches = array();
    $pattern = '/^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/gm';
    if (!preg_match($pattern, $string, $matches)) return false;
    return true;
}

function pulisciInput($value)
{
    $value = trim($value);
    $value = htmlentities($value);
    $value = strip_tags($value);
    return $value;
}