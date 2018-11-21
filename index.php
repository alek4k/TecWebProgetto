<?php

require_once ('./Models/Database.php');
require_once ('./Models/Admin.php');

echo "start ";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    createAdmin();
}

function createAdmin() {
    echo "createAdmin() ";

    $error = "";

    if (empty($_POST["email"])) {
        $error = "Email is required";
        return $error;
    }

    if (empty($_POST["password"])) {
        $error = "Password is required";
        return $error;
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    if ((!is_string($email)) || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
        return "Invalid e-mail address";
    }

    if ((!is_string($password)) || (strlen($password) < 3)) {
        return "Invalid password";
    }

    //$db = new Database();
    //$result = $db->select("admin", array("email"=>"admin@admin.com"), array("email"));
    //var_dump($result);


    $userTest = new Admin();
    $userTest->setEmail($email);
    $userTest->setPassword($password);
    //$success = $userTest->register($error);

    echo "ffff ";
    $result = $userTest->login($error);
    echo "eeee ";

    if ($result) {
        print("loggato! email:".$userTest->getEmail()." password: ".$userTest->getPassword());
    }
    else {
        echo "ERROR: $error";
    }

    echo "end";
    return "";
}