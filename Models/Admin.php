<?php


class Admin
{
    private $data = [];
    private $columns = array('email', 'password', 'test');

    public function register(& $error) : bool
    {
        //cripto la password
        if (array_key_exists('password', $this->data)) {
            $this->setPassword($this->getHashedPassword());
        }
        else {
            $error = "Password mancante.";
            return false;
        }

        //nome della classe/tabella corrente
        $table = static::getCollectionName();

        //passo al gestore del db query e parametri da utilizzare
        $db = new Database();
        try {
            $db->insert($table, $this->data, $this->columns);
        }
        catch (Exception $ex) {
            $error = $ex->getMessage();
            return false;
        }

        return true;
    }

    public function login(& $error) : bool
    {
        $admin = new Admin();
        $admin->setEmail($this->getEmail());
        $pwd = $this->getPassword();
        $table = static::getCollectionName();

        $db = new Database();
        try {
            $results = $db->select($table, $admin->data, $this->columns);
            //$results = $db->select("admin", array("email"=>"admin@admin.com"), array("email"));
            //$results = $db->select("admin", array('2'), array("email"), 'email, test', 'test >= ?');
            //var_dump($results);
        }
        catch (Exception $ex) {
            $error = $ex->getMessage();
            return false;
        }

        foreach ($results as $result) {
            $this->setPassword($result['password']);
            if (static::checkHashedPassword($pwd, $this->getPassword())) {
                return true;
            }
            else {
                $error = "Password errata";
                return false;
            }
        }

        $error = "Utente non trovato";
        return false;

        /*
         * test vari db
        $db->update("admin", array("alek.lovo@gmail.com", "alessandro.lovo@gmail.com"), "email = ?", "email = ?");
        $toDelete = new Admin();
        $toDelete->setEmail("giovanni@admin.com");
        $db->delete("admin", $toDelete->data, $this->columns);
        */
    }

    public function setEmail($email)
    {
        if ((!is_string($email)) || (strlen($email) <= 0)) {
            throw new \InvalidArgumentException("Invalid Email");
        }

        $this->data['email'] = $email;
    }

    public function getEmail()
    {
        return $this->data['email'];
    }

    public function setId($Id) {
        $this->data['Id'] = $Id;
    }

    public function getId()
    {
        return $this->data['Id'];
    }

    public function setPassword($password)
    {
        if ((!is_string($password)) || (strlen($password) <= 0)) {
            throw new \InvalidArgumentException("Invalid password");
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
            throw new \InvalidArgumentException("Invalid password");
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
            throw new \InvalidArgumentException("Invalid password hash");
        }

        if ((!is_string($password)) || (strlen($password) <= 0)) {
            throw new \InvalidArgumentException("Invalid password");
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


}
