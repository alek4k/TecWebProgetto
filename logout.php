<?php

require_once('Utilities/Functions.php');

$_SESSION["username"] = null;
$_SESSION["token"] = null;
$_SESSION["error_login"] = null;

header('Location: '.Functions::$mainDirectory.'index.html');
die();