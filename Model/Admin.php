<?php

require_once('./Utilities/Base64.php');
require_once('Database.php');

use Utilities\Base64;

class Admin
{
    private $data = [];
    private $columns = array('Id', 'username', 'email', 'password', 'token', 'token_generation', 'token_expiration');
    const EXPIRING_TIME = 60 * 60 * 24;

    public function register(& $error): bool
    {
        //cripto la password
        if (array_key_exists('password', $this->data)) {
            $this->setPassword($this->getHashedPassword());
        } else {
            $error = "Password mancante.";
            return false;
        }

        //nome della classe/tabella corrente
        $table = static::getCollectionName();

        //passo al gestore del db query e parametri da utilizzare
        $db = new Database();
        try {
            $db->insert($table, $this->data, $this->columns);
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            return false;
        }

        return true;
    }

    public function login(& $error): bool
    {
        $admin = new Admin();
        $admin->setUsername($this->getUsername());
        $pwd = $this->getPassword();
        $table = static::getCollectionName();

        $db = new Database();
        try {
            $results = $db->select($table, $admin->data, $this->columns);
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            return false;
        }

        foreach ($results as $result) {
            $this->setPassword($result['password']);
            if (static::checkHashedPassword($pwd, $this->getPassword())) {
                return true;
            } else {
                $error = "Password errata";
                return false;
            }
        }

        $error = "Utente non trovato";
        return false;

        /*
         *   test vari db
         *   $db->update("admin", array("alek.lovo@gmail.com", "alessandro.lovo@gmail.com"), "email = ?", "email = ?");
         */
    }

    public static function getAllAdmin()
    {
        $db = new Database();
        $result = $db->selectAll(static::getCollectionName(), 'username');
        return $result;
    }

    public static function searchAdmin($name): bool
    {
        $result = self::getAllAdmin();

        foreach ($result as $admin) {
            if ($admin['username'] === $name) {
                return true;
            }
        }
        return false;
    }

    public function delete(): bool
    {
        $db = new Database();
        try {
            $db->delete(static::getCollectionName(), $this->data, $this->columns);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function updateAfterLogin()
    {
        $db = new Database();
        $db->update(static::getCollectionName(), array($this->getToken(), $this->getTokenGeneration(), $this->getTokenExpiration(), $this->getUsername()), "token = ?, token_generation = ?, token_expiration = ?", "username = ?");
    }

    public function setUsername($name)
    {
        if ((!is_string($name)) || (strlen($name) <= 0)) {
            throw new InvalidArgumentException("Invalid Username");
        }

        $this->data['username'] = $name;
    }

    public function getUsername()
    {
        return $this->data['username'];
    }

    public function setEmail($email)
    {
        if ((!is_string($email)) || (strlen($email) <= 0)) {
            throw new InvalidArgumentException("Invalid Email");
        }

        $this->data['email'] = $email;
    }

    public function getEmail()
    {
        return $this->data['email'];
    }

    public function setId($Id)
    {
        $this->data['Id'] = $Id;
    }

    public function getId()
    {
        return $this->data['Id'];
    }

    public function setPassword($password)
    {
        if ((!is_string($password)) || (strlen($password) <= 0)) {
            throw new InvalidArgumentException("Invalid password");
        }

        $this->data['password'] = $password;
    }

    public function getPassword()
    {
        return $this->data['password'];
    }

    private static function generatePasswordHash($password)
    {
        if ((!is_string($password)) || (strlen($password) <= 0)) {
            throw new InvalidArgumentException("Invalid password");
        }

        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function getHashedPassword()
    {
        return static::generatePasswordHash($this->getPassword());
    }

    public static function checkHashedPassword($password, $hash)
    {
        if ((!is_string($hash)) || (strlen($hash) <= 0)) {
            throw new InvalidArgumentException("Invalid password hash");
        }

        if ((!is_string($password)) || (strlen($password) <= 0)) {
            throw new InvalidArgumentException("Invalid password");
        }

        return password_verify($password, $hash);
    }

    protected static function getCollectionName()
    {
        $classname = static::class;
        if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
            $classname = $matches[1];
        }
        return lcfirst($classname);
    }

    public function setIsActive($value)
    {
        if ((!is_int($value)) || ($value < 0 || $value > 1)) {
            throw new InvalidArgumentException("Invalid parameter login");
        }

        $this->data['isActive'] = $value;
    }

    public function getIsActive()
    {
        return $this->data['isActive'];
    }

    public function getToken()
    {
        return $this->data['token'];
    }

    public function setToken($token)
    {
        $this->data['token'] = $token;
    }

    public function getTokenExpiration()
    {
        return $this->data['token_expiration'];
    }

    public function setTokenExpiration($token_expiration)
    {
        $this->data['token_expiration'] = $token_expiration;
    }

    public function getTokenGeneration()
    {
        return $this->data['token_generation'];
    }

    public function setTokenGeneration($token_generation)
    {
        $this->data['token_generation'] = $token_generation;
    }

    /**
     * Genera un token univoco che identifica una sessione utente.
     *
     * @return string : the token
     */
    public function addAuthToken()
    {
        if (is_null($this->getUsername())) {
            return null;
        }

        $token = Base64::encode((string)uniqid(bin2hex(openssl_random_pseudo_bytes(12))) . openssl_random_pseudo_bytes(32));

        $this->setToken($token);
        $this->setTokenGeneration(date("Y-m-d H:i:s"));
        $this->setTokenExpiration(date("Y-m-d H:i:s", strtotime("+30 minutes")));

        return $this->getShortCode() . $token;
    }

    public function getShortCode()
    {
        $this->data["shortcode"] = (!array_key_exists("shortcode", $this->data)) ? bin2hex(openssl_random_pseudo_bytes(8)) : $this->data["shortcode"];

        if (strlen($this->data["shortcode"]) != 16) {
            throw new RuntimeException("Bad random number generation");
        }

        return $this->data["shortcode"];
    }


    /*public static function encode($message, $urlCompatible = true) : string
    {
        //check for the message type
        if (!is_string($message)) {
            throw new \InvalidArgumentException('the binary unsafe content must be given as a string');
        }
        //check for url safety param
        if (!is_bool($urlCompatible)) {
            throw new \InvalidArgumentException('the binary unsafe content must be given as a string');
        }
        //get the base64 url unsafe
        $encoded = base64_encode($message);
        //return the url safe version if requested
        return ($urlCompatible) ? rtrim(strtr($encoded, '+/=', '-_~'), '~') : $encoded;
    }*/


}
