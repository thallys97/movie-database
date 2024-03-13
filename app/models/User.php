<?php

namespace App\Models;

use App\Database\Database;

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($email, $password, $name) {
        $this->db->query("INSERT INTO Users (email, password, name) VALUES (:email, :password, :name)");
        $this->db->bind(':email', $email);
        $this->db->bind(':password', $password);
        $this->db->bind(':name', $name);

        return $this->db->execute();
    }

    public function login($email, $password) {
        $this->db->query("SELECT * FROM Users WHERE email = :email");
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($row && password_verify($password, $row->password)) {
            return $row;
        } else {
            return false;
        }
    }

        // Implementação do método findUserByEmail
        public function findUserByEmail($email) {
            $this->db->query("SELECT * FROM Users WHERE email = :email LIMIT 1");
            $this->db->bind(':email', $email);
    
            $row = $this->db->single();
    
            // Se encontrar um usuário, retorna true
            if ($row) {
                return true;
            } else {
                // Caso contrário, retorna false
                return false;
            }
        }

}
