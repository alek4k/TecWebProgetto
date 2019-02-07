<?php

require_once('Model/Database.php');
require_once('Model/Evento.php');
require_once('Utilities/Functions.php');

Functions::checkLogin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $uploadOk = 1;
    if ($_FILES['image']['size'] > 0 && $_FILES['image']['error'] == 0)
    {
        //CONTROLLI E UPLOAD IMMAGINE
        $target_dir = 'uploads/';
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        //Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false && $_FILES['image']['error'] == 0) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $_SESSION["error_image"] = "L'immagine esiste già";
            $uploadOk = 0;
            $count += 1;
        }
        // Check file size (max 2MB)
        if ($_FILES["fileToUpload"]["size"] > 2000000) {
            $_SESSION["error_image"] = "File immagine troppo grande";
            $uploadOk = 0;
            $count += 1;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            $_SESSION["error_image"] = "Formato immagine non consentito";
            $uploadOk = 0;
            $count += 1;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {

            //echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                //echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
            } else {
                $_SESSION["error_image"] = "Errore durante il carimento dell'immagine";
                $uploadOk = 0;
                $count += 1;
            }
        }
    }
    //FINE UPLOAD IMMAGINE

    if ($count > 0) Functions::backToEventiManager();

    $evento = new Evento();
    $evento->setTitolo(Functions::pulisciInput($titolo));
    $evento->setDescrizione(Functions::pulisciInput($descrizione));
    $evento->setData(Functions::pulisciInput($data));
    if ($uploadOk !== 0)
        $evento->setImage($target_file);
    else
        $evento->setImage("");

    if ($evento->createEvento($error)) {
        $_SESSION["eventoCreato"] = true;
    } else {
        $_SESSION["eventoCreato"] = false;
    }

    Functions::backToEventiManager();
}