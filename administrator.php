<?php

require_once('Model/Database.php');
require_once('Model/Admin.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    login();
}
else {
    header('Location: /alovo');
    die();
}

function login()
{
    $error = "";

    if (empty($_POST["username"])) {
        $error = "Username is required";
        backToLogin();
    }

    if (empty($_POST["password"])) {
        $error = "Password is required";
        backToLogin();
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    if ((!is_string($username)) || (strlen($username) < 3)) {
        $error = "Invalid username";
        backToLogin();
    }

    if ((!is_string($password)) || (strlen($password) < 3)) {
        $error = "Invalid password";
        backToLogin();
    }

    $user = new Admin();
    $user->setUsername($username);
    $user->setPassword($password);
    //$success = $userTest->register($error);

    if ($user->login($error)) {
        $token = $user->addAuthToken();
        $user->updateAfterLogin();
        //print("loggato! username:" . $user->getUsername() . " password: " . $user->getPassword() . " token: " . $user->getToken() . " miniToken: " . $token);
        $_SESSION["username"] = $user->getUsername();
        $_SESSION["token"] = $token;

        header('Location: /alovo/admin.html');
    }
    else {
        $error = "ERROR: $error";
        backToLogin();
    }

    die();
}

function backToLogin()
{
    header('Location: /alovo/login.html');
    die();
}