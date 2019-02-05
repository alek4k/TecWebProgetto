<?php

require_once('Model/Admin.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    login();
} else {
    header('Location: /alovo/login.php');
    die();
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
    if ((!is_string($password)) || (strlen($password) < 8) || (strlen($password) > 12)) {
        $_SESSION["error_login"] = true;
        $count += 1;
    }

    if ($count > 0) backToLogin();

    $user = new Admin();
    $user->setUsername($username);
    $user->setPassword($password);

    if ($user->login($error)) {
        $token = $user->addAuthToken();
        $user->updateAfterLogin();
        $_SESSION["username"] = $user->getUsername();
        $_SESSION["token"] = $token;

        header('Location: /alovo/admin.php');
    } else {
        $_SESSION["error_login"] = true;
        backToLogin();
    }

    die();
}

function backToLogin()
{
    header('Location: /alovo/login.php');
    die();
}