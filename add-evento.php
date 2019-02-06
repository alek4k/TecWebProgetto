<?php

require_once('Model/Database.php');
require_once('Model/Evento.php');
require_once('Utilities/Functions.php');

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

    $titolo = $_POST["titolo"];
    $descrizione = $_POST["descrizione"];
    $data = $_POST["data"];

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

    $target_dir = 'uploads/';
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    //Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size (max 2MB)
    if ($_FILES["fileToUpload"]["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    if ($count > 0) backToEventiManager();

    $evento = new Evento();
    $evento->setTitolo(pulisciInput($titolo));
    $evento->setDescrizione(pulisciInput($descrizione));
    $evento->setData(pulisciInput($data));
    $evento->setImage($target_file);

    if ($evento->createEvento($error)) {
        $_SESSION["eventoCreato"] = true;
    } else {
        $_SESSION["eventoCreato"] = false;
    }

    backToEventiManager();
}

function backToEventiManager()
{
    header('Location: '.Functions::$mainDirectory.'eventiManager.php');
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