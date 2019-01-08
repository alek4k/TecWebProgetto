<?php

session_start();

echo "User: " . $_SESSION["username"] . " logged with token: " . $_SESSION["token"];