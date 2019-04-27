<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./Utilities/Base64.php');
require_once('Database.php');

use Utilities\Base64;

class Admin
{
    private $data = [];
    private $columns = array('Id', 'username', 'password', 'token', 'token_generation', 'token_expiration');
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

    public function update()
    {
        $db = new Database();
        $db->update(static::getCollectionName(), array($this->getToken(), $this->getTokenGeneration(), $this->getTokenExpiration(), $this->getUsername()), "token = ?, token_generation = ?, token_expiration = ?", "username = ?");
    }

    public static function loadFromToken($token)
    {
        $db = new Database();
        $admin = new Admin();
        $results = $db->select(static::getCollectionName(), array("token"=>$token), $admin->columns);
        foreach ($results as $result) {
            $admin->setUsername($result['username']);
            $admin->setTokenExpiration($result['token_expiration']);
            $admin->setTokenGeneration($result['token_generation']);
            $admin->setToken($token);
        }

        return $admin;
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
        $this->setTokenExpiration(date("Y-m-d H:i:s", strtotime("+".Functions::$expireTime."minutes")));

        return $token;
    }
}
