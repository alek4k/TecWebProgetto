<?php

require_once('Models/Database.php');
require_once('Models/Admin.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    createAdmin();
}

function createAdmin()
{
    $error = "";

    if (empty($_POST["username"])) {
        $error = "Username is required";
        echo $error;
    }

    if (empty($_POST["password"])) {
        $error = "Password is required";
        echo $error;
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    if ((!is_string($username)) || (strlen($username) < 5)) {
        echo "Invalid username";
    }

    if ((!is_string($password)) || (strlen($password) < 3)) {
        echo "Invalid password";
    }

    //$db = new Database();
    //$result = $db->select("admin", array("email"=>"admin@admin.com"), array("email"));
    //var_dump($result);


    $userTest = new Admin();
    $userTest->setUsername($username);
    $userTest->setPassword($password);
    //$success = $userTest->register($error);

    $result = $userTest->login($error);

    if ($result) {
        $token = $userTest->addAuthToken();

        $userTest->updateAfterLogin();
        print("loggato! username:" . $userTest->getUsername() . " password: " . $userTest->getPassword() . " token: " . $userTest->getToken() . " miniToken: " . $token);
        $_SESSION["user_id"] = $userTest->getId();
        $_SESSION["token"] = $token;
    }
    else {
        echo "ERROR: $error";
    }

    echo " end";
    return "";
}