<?php

namespace App\Models;

use App\Database;

class Movie {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getLatestMovies() {
        $this->db->query("SELECT * FROM movies ORDER BY release_date DESC LIMIT 20");
        return $this->db->resultSet();
    }
}