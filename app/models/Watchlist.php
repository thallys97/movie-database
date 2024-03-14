<?php

namespace App\Models;

use App\Database\Database;

class Watchlist {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addMovieToWatchlist($userId, $tmdbMovieId) {
        $this->db->query("INSERT INTO Watchlist (user_id, tmdb_movie_id) VALUES (:user_id, :tmdb_movie_id)");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':tmdb_movie_id', $tmdbMovieId);
        return $this->db->execute();
    }

    public function getUserWatchlist($userId) {
        $this->db->query("SELECT tmdb_movie_id FROM Watchlist WHERE user_id = :user_id");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
}
