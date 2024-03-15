<?php

namespace App\Models;

use App\Database\Database;

class Watchlist {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addMovieToWatchlist($userId, $tmdbMovieId) {
        // Primeiro, verifique se o filme já está na watchlist
        $this->db->query("SELECT 1 FROM Watchlist WHERE user_id = :user_id AND tmdb_movie_id = :tmdb_movie_id");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':tmdb_movie_id', $tmdbMovieId);
    
        if ($this->db->single()) {
            // O filme já está na watchlist, não faça nada
            return false;
        } else {
            // Insira o novo filme na watchlist
            $this->db->query("INSERT INTO Watchlist (user_id, tmdb_movie_id) VALUES (:user_id, :tmdb_movie_id)");
            // Rebind os parâmetros para a nova consulta
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':tmdb_movie_id', $tmdbMovieId);
    
            // Execute a inserção
            return $this->db->execute();
        }
    }

    public function removeMovieFromWatchlist($userId, $tmdbMovieId) {
        $this->db->query("DELETE FROM Watchlist WHERE user_id = :user_id AND tmdb_movie_id = :tmdb_movie_id");
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
