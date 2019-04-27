<?php

require_once('Model/Database.php');
require_once('Model/Admin.php');
require_once('Model/Prenotazione.php');
require_once('Utilities/Functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    nuovaPrenotazione();
} else {
    Functions::backToPrenota();
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
    if ((!is_string($data)) || (strlen($data) != 10) || (!Functions::isDate($data))) {
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

    if ($count > 0) Functions::backToPrenota();

    $prenotazione = new Prenotazione();
    $prenotazione->setName(Functions::pulisciInput($name));
    $prenotazione->setEmail(Functions::pulisciInput($email));
    $prenotazione->setTelefono(Functions::pulisciInput($telefono));
    $prenotazione->setPersone(Functions::pulisciInput($numPersone));
    $prenotazione->setData($data);
    $prenotazione->setNote(Functions::pulisciInput($note));

    if ($prenotazione->createPrenotazione($error)) {
        $_SESSION["prenotazioneCreata"] = true;
    } else {
        $_SESSION["prenotazioneCreata"] = false;
    }

    Functions::backToPrenota();
}