<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION["username"] = null;
$_SESSION["token"] = null;
$_SESSION["error_login"] = null;

header('Location: /alovo/index.html');
die();