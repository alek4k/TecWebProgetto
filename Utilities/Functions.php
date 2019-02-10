<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class Functions
{
    //----> website root folder <----
    public static $mainDirectory = "/alovo/";

    //----> website upload images folder <----
    public static $uploadDir = "uploads/";

    //----> session expiration time (minutes) <----
    public static $expireTime = 15;

    public static function checkLogin()
    {
        if (!isset($_SESSION["token"])) {
            self::backToLogin();
        }
    }

    public static function checkTokenExpiration()
    {
        if (isset($_SESSION["token"])) {
            $current_user = Admin::loadFromToken($_SESSION["token"]);

            $expiration = DateTime::createFromFormat('Y-m-d H:i:s', $current_user->getTokenExpiration());
            $now = new DateTime();
            if ($expiration <= $now) {
                $_SESSION["username"] = null;
                $_SESSION["token"] = null;
                $_SESSION["error_login"] = null;
                $_SESSION["session_expired"] = true;
                self::backToLogin();
            }

            $current_user->setTokenGeneration(date("Y-m-d H:i:s"));
            $current_user->setTokenExpiration(date("Y-m-d H:i:s", strtotime("+".self::$expireTime."minutes")));
            $current_user->update();
        }
    }

    public static function logout()
    {
        $_SESSION["username"] = null;
        $_SESSION["token"] = null;
        $_SESSION["error_login"] = null;

        header('Location: '.Functions::$mainDirectory.'index.html');
        die();
    }

    public static function backToLogin()
    {
        header('Location: '.self::$mainDirectory.'login.php');
        die();
    }

    public static function backToAdmin()
    {
        header('Location: '.self::$mainDirectory.'admin.php');
        die();
    }

    public static function backToEventiManager()
    {
        header('Location: '.self::$mainDirectory.'eventiManager.php');
        die();
    }

    public static function backToPrenota()
    {
        header('Location: '.self::$mainDirectory.'prenota.php');
        die();
    }

    public static function backToPrenotazioni()
    {
        header('Location: '.self::$mainDirectory.'prenotazioni.php');
        die();
    }

    public static function pulisciInput($value)
    {
        $value = trim($value);
        $value = htmlentities($value);
        $value = strip_tags($value);
        return $value;
    }

    public static function isDate($string)
    {
        $matches = array();
        $pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/';
        if (!preg_match($pattern, $string, $matches)) return false;
        if (!checkdate($matches[2], $matches[1], $matches[3])) return false;

        //controllo che la data non sia passata
        $data = DateTime::createFromFormat('d/m/Y', $string);
        $now = new DateTime();
        if ($data <= $now) return false;

        return true;
    }

    public static function getMese($month)
    {
        $mese = $month;
        switch ($month) {
            case 'January':
                $mese = 'Gennaio';
                break;
            case 'February':
                $mese = 'Febbraio';
                break;
            case 'March':
                $mese = 'Marzo';
                break;
            case 'April':
                $mese = 'Aprile';
                break;
            case 'May':
                $mese = 'Maggio';
                break;
            case 'June':
                $mese = 'Giugno';
                break;
            case 'July':
                $mese = 'Luglio';
                break;
            case 'August':
                $mese = 'Agosto';
                break;
            case 'September':
                $mese = 'Settembre';
                break;
            case 'October':
                $mese = 'Ottobre';
                break;
            case 'November':
                $mese = 'Novembre';
                break;
            case 'December':
                $mese = 'Dicembre';
                break;
        }
        return $mese;
    }
}