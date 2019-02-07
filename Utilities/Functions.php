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

    public static function checkLogin()
    {
        if (!isset($_SESSION["token"])) {
            self::backToLogin();
        }
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
        $yyyymmdd = strtotime(date("Y-d-m", strtotime($string)));
        $now = strtotime(date('Y-m-d'));
        if ($yyyymmdd < $now) return false;

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