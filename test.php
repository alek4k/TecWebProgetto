<?php

session_start();

echo "User: " . $_SESSION["username"] . " logged with token: " . $_SESSION["token"];

echo "\n error_name: " . $_SESSION["error_name"] . " error_email: " . $_SESSION["error_email"] .
    " error_telefono: " . $_SESSION["error_telefono"] . " error_persone: " . $_SESSION["error_numPersone"] .
    " error_data: " . $_SESSION["error_data"] . " PRENOTAZIONE CREATA: " . $_SESSION["prenotazioneCreata"] .
    " TEST LETTURA TOKEN EXPIRATION: " . $_SESSION["LETTURA TOKEN EXPIRATION"] . " ErrorTT: " . $_SESSION["erroreTT"] . " VERA PROVA: "; var_dump($_SESSION["veraProva"]);