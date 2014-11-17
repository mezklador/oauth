<?php
/**
* File : Database.php   
**/
namespace Server\src;
use PDO;
class Database {
    private $connection = []; //host, user, pwd, db_name & method (mysql, sqlite, etc.)
    private $db_obj = null;
    private $db_status = false;
    private $error;
    private $access;

    private $query;

    private $results;

    public function __construct(array $what)
    {
        $this->connection = $what;
        $this->access = "{$this->connection['method']}:host={$this->connection['host']};dbname={$this->connection['database']}";
        if(is_null($this->db_obj))
        {
                $this->db_obj = new PDO($this->access, $this->connection['user'], $this->connection['pwd']);
                $this->db_obj->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::FETCH_LAZY
                );
                $this->db_status = true;
        }
    }

    public function setQuery($qr)
    {
        $this->query = $qr;
    }

    public function cook()
    {
        if (isset($this->query)) $this->db_obj->prepare($this->query)->execute();
    }

    public function checkTable($tablename)
    {
        if (property_exists($this->db_obj, $tablename) || method_exists($this->db_obj, $tablename)) return true;
        return false;
    }

    public function create($tablename, $values = [])
    {
        if ($tablename && !$this->checkTable($tablename)) {
            $qr = "CREATE TABLE {$tablename} (";
            $qr .= "id VARCHAR(25),";
            foreach ($values as $column => $val)
            {
                $qr .= "{$column} {$val},";
            }
            $qr .= "created_at DATETIME,";
            $qr .= "updated_at DATETIME,";
            $qr .= "PRIMARY KEY (id)";
            $qr .= ") DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;";

            $this->setQuery($qr);
            $this->cook();
            return true;
        }
       return false;
    }

    public function drop($tablename)
    {
        if ($tablename && $this->checkTable($tablename)) {
            $qr = "DROP TABLE {$tablename}";
            $this->setQuery($qr);
            $this->cook();
            return true;
        }
        return false;
    }

    public function blankSlate($tablename)
    {
        if ($tablename && $this->checkTable($tablename)) {
            $qr = "TRUNCATE TABLE {$tablename}";
            $this->setQuery($qr);
            $this->cook();
            return true;
        };
        return false;
    }

    public function all($tablename)
    {
        if ($tablename && $this->checkTable($tablename))
        {
            $qr = "SELECT * FROM {$tablename}";
            $this->results = $this->setQuery($qr)->cook();
            return $this->results;
        }
        return false;
    }

    public function counts($tablename)
    {
        $qr = "SELECT * FROM {$tablename}";
        $this->setQuery($qr);
        $this->results = $this->cook();
        return $this->results;
    }
} 