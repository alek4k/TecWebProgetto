<?php


class Database
{
    //impostazioni database
    private $Host = 'localhost';
    private $DBName = 'alovo';
    private $DBUser = 'alovo';
    private $DBPassword = 'Oe3fooqu1OhphaTi';
    private $DBPort = '3306';
    //gestore della connessione
    private $pdo;

    private function openConnection()
    {
        //opzioni di connessione
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false,      //turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,            //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];

        //connessione al db
        try {
            $this->pdo = new PDO('mysql:dbname=' . $this->DBName . ';host=' . $this->Host . ';port=' . $this->DBPort . ';charset=utf8',
                $this->DBUser,
                $this->DBPassword,
                $options
            );
        } catch (Exception $e) {
            print("Unable to connect: " . $e->getMessage());
        }
    }

    private function closeConnection()
    {
        //chiusura connessione db
        $this->pdo = null;
    }

    public function insert($table, $data, $columns)
    {
        $this->openConnection();

        //se vengono passati parametri che non corrispondono alle colonne li elimino
        $param_values = array_intersect_key($data, array_flip($columns));

        //elimino ora dalla lista colonne quelle non presenti nei parametri della query
        $column_list = array_keys(array_intersect_key(array_flip($columns), $param_values));

        //preparo lista nome parametri
        $param_list = join(',', array_map(function ($col) {
            return ":$col";
        }, $column_list));

        //stringa lista colonne usate per a query
        $column_list = join(',', $column_list);

        //query
        $query = "INSERT INTO $table ($column_list) VALUES ($param_list)";

        try {
            //https://stackoverflow.com/questions/29657367/difference-between-exec-and-execute-in-php
            $sth = $this->pdo->prepare($query);
            $sth->execute($param_values);
        } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
        }

        $this->closeConnection();
    }

    public function select($table, $data, $columns, $whatSelect = '*', $whereClause = null): array
    {
        $this->openConnection();
        $result = "";

        if ($whereClause === null) {
            //se vengono passati parametri che non corrispondono alle colonne li elimino
            $param_values = array_intersect_key($data, array_flip($columns));

            //elimino ora dalla lista colonne quelle non presenti nei parametri della query
            $column_list = array_keys(array_intersect_key(array_flip($columns), $param_values));

            //preparo lista nome parametri
            $param_list = join(' AND ', array_map(function ($col) {
                return "$col = :$col";
            }, $column_list));

            //query
            $query = "SELECT $whatSelect FROM $table WHERE $param_list";
        } else {
            $query = "SELECT $whatSelect FROM $table WHERE $whereClause";
            $param_values = $data;
        }

        try {
            $sth = $this->pdo->prepare($query);
            $sth->execute($param_values);
            $result = $sth->fetchAll();
        } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
        }

        $this->closeConnection();
        return $result;
    }

    public function selectAll($table, $whatSelect = '*'): array
    {
        $this->openConnection();
        $result = $this->pdo->query("SELECT $whatSelect FROM $table")->fetchAll();
        $this->closeConnection();
        return $result;
    }

    public function update($table, $data, $setClause, $whereClause)
    {
        $this->openConnection();

        $query = "UPDATE $table SET $setClause WHERE $whereClause";

        try {
            $sth = $this->pdo->prepare($query);
            $sth->execute($data);
        } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
        }

        $this->closeConnection();
    }

    public function delete($table, $data, $columns, $whereClause = null)
    {
        $this->openConnection();

        if ($whereClause === null) { //cambiare con confronto tra id
            //se vengono passati parametri che non corrispondono alle colonne li elimino
            $param_values = array_intersect_key($data, array_flip($columns));

            //elimino ora dalla lista colonne quelle non presenti nei parametri della query
            $column_list = array_keys(array_intersect_key(array_flip($columns), $param_values));

            //preparo lista nome parametri
            $param_list = join(' AND ', array_map(function ($col) {
                return "$col = :$col";
            }, $column_list));

            $query = "DELETE FROM $table WHERE $param_list";
        } else {
            $query = "DELETE FROM $table WHERE $whereClause";
            $param_values = $data;
        }

        try {
            $sth = $this->pdo->prepare($query);
            $sth->execute($param_values);
        } catch (Exception $e) {
            echo "Failed: " . $e->getMessage();
        }

        $this->closeConnection();
    }
}