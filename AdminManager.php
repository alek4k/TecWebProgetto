<?php

require_once('Model/Admin.php');


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['token'])) {
    $error = "";
    echo "entered";

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
    $success = $user->register($error);

    if ($success) {
        echo "Amministratore aggiunto con successo!";
    } else {
        echo "Si è verificato un errore: " . $error;
    }
} else {
    echo "quit";
}

function backToLogin()
{
    header('Location: /alovo/login.php');
    die();
}