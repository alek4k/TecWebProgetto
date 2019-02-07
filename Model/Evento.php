<?php

require_once('Database.php');

class Evento
{
    private $data = [];
    private $columns = array('Id', 'titolo', 'descrizione', 'data', 'image');

    public function createEvento(& $error): bool
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

    public static function getAllEventi(): array
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

    public function setTitolo($title)
    {
        $this->data['titolo'] = $title;
    }

    public function getTitolo()
    {
        return $this->data['titolo'];
    }

    public function setDescrizione($description)
    {
        $this->data['descrizione'] = $description;
    }

    public function getDescrizione()
    {
        return $this->data['descrizione'];
    }

    public function setData($data)
    {
        $this->data['data'] = DateTime::createFromFormat('d/m/Y', $data)->format('Y-m-d');
    }

    public function getData()
    {
        return $this->data['data'];
    }

    public function setImage($img)
    {
        $this->data['image'] = $img;
    }

    public function getImage()
    {
        return $this->data['image'];
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