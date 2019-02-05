<?php

require_once('Model/Admin.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["token"])) {
    backToLogin();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    aggiungiAdmin();
} else {
    backToLogin();
}

function aggiungiAdmin()
{
    $error = "";
    $count = 0;
    $_SESSION["error_username_newAdmin"] = false;
    $_SESSION["error_password_newAdmin"] = false;
    $_SESSION["error_createAdmin"] = false;

    if (empty($_POST["username"])) {
        $_SESSION["error_username_newAdmin"] = true;
        $count += 1;
    }
    if (empty($_POST["password"])) {
        $_SESSION["error_password_newAdmin"] = true;
        $count += 1;
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    if ((!is_string($username)) || (strlen($username) < 3) || (strlen($username) > 12)) {
        $_SESSION["error_username_newAdmin"] = true;
        $count += 1;
    }
    if ((!is_string($password)) || (strlen($password) < 8) || (strlen($password) > 12)) {
        $_SESSION["error_password_newAdmin"] = true;
        $count += 1;
    }

    if ($count > 0) backToAdmin();

    $user = new Admin();
    $user->setUsername($username);
    $user->setPassword($password);

    if (!Admin::searchAdmin($user->getUsername()) && $user->register($error)) {
        $_SESSION["error_createAdmin"] = false;
    } else {
        $_SESSION["error_createAdmin"] = true;
    }

    backToAdmin();
}

function backToLogin()
{
    header('Location: /alovo/login.php');
    die();
}

function backToAdmin()
{
    header('Location: /alovo/admin.php');
    die();
}