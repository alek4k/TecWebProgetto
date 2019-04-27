<?php

require_once('Database.php');

class Prenotazione
{
    private $data = [];
    private $columns = array('Id', 'nome', 'email', 'telefono', 'persone', 'data', 'note');

    public function createPrenotazione(& $error): bool
    {
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

    public static function getAllPrenotazioni(): array
    {
        $db = new Database();
        return $db->selectAll(static::getCollectionName());
    }

    public function setId($id)
    {
        $this->data['Id'] = $id;
    }

    public function getId()
    {
        return $this->data['Id'];
    }

    public function setName($name)
    {
        $this->data['nome'] = $name;
    }

    public function getName()
    {
        return $this->data['nome'];
    }

    public function setEmail($email)
    {
        $this->data['email'] = $email;
    }

    public function getEmail()
    {
        return $this->data['email'];
    }

    public function setTelefono($phone)
    {
        $this->data['telefono'] = $phone;
    }

    public function getTelefono()
    {
        return $this->data['telefono'];
    }

    public function setPersone($persone)
    {
        $this->data['persone'] = $persone;
    }

    public function getPersone()
    {
        return $this->data['persone'];
    }

    public function setData($data)
    {
        $this->data['data'] = DateTime::createFromFormat('d/m/Y', $data)->format('Y-m-d');
    }

    public function getData()
    {
        return $this->data['data'];
    }

    public function setNote($note)
    {
        $this->data['note'] = $note;
    }

    public function getNote()
    {
        return $this->data['note'];
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