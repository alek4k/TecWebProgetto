<?php

require_once('Model/Database.php');
require_once('Model/Admin.php');
require_once('Model/Evento.php');
require_once('Utilities/Functions.php');

Functions::checkLogin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    Functions::checkTokenExpiration();
    nuovoEvento();
} else {
    Functions::backToEventiManager();
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

    $titolo = $_POST["titolo"];
    $descrizione = $_POST["descrizione"];
    $data = $_POST["data"];

    if ((!is_string($titolo)) || (strlen($titolo) < 1) || (strlen($titolo) > 99)) {
        $_SESSION["error_titolo"] = true;
        $count += 1;
    }
    if ((!is_string($data)) || (strlen($data) != 10) || (!Functions::isDate($data))) {
        $_SESSION["error_data"] = true;
        $count += 1;
    }
    if ((!is_string($descrizione)) || (strlen($descrizione) < 1) || (strlen($descrizione) > 999)) {
        $_SESSION["error_descrizione"] = true;
        $count += 1;
    }

    //CONTROLLI E UPLOAD IMMAGINE
    $target_file = "";
    if ($_FILES['image']['size'] > 0 && $_FILES['image']['error'] == 0)
    {
        //l'immagine è stata inserita nel form
        $uploadOk = 1;
        $target_dir = Functions::$uploadDir;
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Controllo dimensione file (max 2MB)
        if ($_FILES["fileToUpload"]["size"] > 2000000) {
            $_SESSION["error_image"] = "File immagine troppo grande";
            $uploadOk = 0;
            $count += 1;
        }
        // Controllo sulle estensioni del file
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $_SESSION["error_image"] = "Formato immagine non consentito";
            $uploadOk = 0;
            $count += 1;
        }

        if ($uploadOk == 1 && !file_exists($target_file)) {
            try {
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            }
            catch (Exception $exception) {
                $_SESSION["error_image"] = "Errore durante il carimento dell'immagine";
                $count += 1;
            }
        }
    }
    //FINE UPLOAD IMMAGINE

    if ($count > 0) Functions::backToEventiManager();

    $evento = new Evento();
    $evento->setTitolo(Functions::pulisciInput($titolo));
    $evento->setDescrizione(Functions::pulisciInput($descrizione));
    $evento->setData($data);
    $evento->setImage($target_file);

    if ($evento->createEvento($error)) {
        $_SESSION["eventoCreato"] = true;
    } else {
        $_SESSION["eventoCreato"] = false;
    }

    Functions::backToEventiManager();
}