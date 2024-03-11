<?php

namespace App;

use PDO;
use PDOException;

class Database {
    private $host = 'localhost';
    private $db_name = 'moviedb';
    private $username = 'root';
    private $password = '';
    private $conn;
    private $stmt;

    public function connect() {
        if($this->conn == null) {
            try {
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch(PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
                $this->conn = null;
            }
        }

        return $this->conn;
    }

    public function query($sql) {
        $this->stmt = $this->connect()->prepare($sql);
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }
}