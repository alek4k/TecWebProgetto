<?php

require_once('Model/Database.php');
require_once('Model/Admin.php');
require_once('Utilities/Functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    login();
} else {
    Functions::backToLogin();
}

function login()
{
    $error = "";
    $count = 0;
    $_SESSION["error_login"] = false;

    if (empty($_POST["username"])) {
        $_SESSION["error_login"] = true;
        $count += 1;
    }
    if (empty($_POST["password"])) {
        $_SESSION["error_login"] = true;
        $count += 1;
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    if ((!is_string($username)) || (strlen($username) < 3) || (strlen($username) > 12)) {
        $_SESSION["error_login"] = true;
        $count += 1;
    }
    if ((!is_string($password)) || (strlen($password) < 5) || (strlen($password) > 12)) {
        $_SESSION["error_login"] = true;
        $count += 1;
    }

    if ($count > 0) Functions::backToLogin();

    $user = new Admin();
    $user->setUsername($username);
    $user->setPassword($password);

    if ($user->login($error)) {
        $token = $user->addAuthToken();
        $user->update();
        $_SESSION["username"] = $user->getUsername();
        $_SESSION["token"] = $token;

        Functions::backToAdmin();
    } else {
        $_SESSION["error_login"] = true;
        Functions::backToLogin();
    }

    die();
}