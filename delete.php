<?php

require_once('Model/Database.php');
require_once('Model/Admin.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["token"])) {
    header('Location: /alovo/login.php');
    die();
}

if (!empty($_GET["admin"])) {
    $_SESSION["error_deleteAdmin"] = false;

    if ($_GET["admin"] === $_SESSION["username"]) {
        $_SESSION["error_deleteAdmin"] = true;
        backToAdmin();
    }

    $toDelete = new Admin();
    $toDelete->setUsername($_GET["admin"]);

    if ($toDelete->deleteAdmin()) {
        $_SESSION["error_deleteAdmin"] = false;
    }
    else {
        $_SESSION["error_deleteAdmin"] = true;
    }

    backToAdmin();
}

function backToAdmin() {
    header('Location: /alovo/admin.php');
    die();
}
