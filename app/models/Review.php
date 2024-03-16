<?php

namespace App\Models;

use App\Database\Database;

class Review {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function createReview($userId, $movieId, $rating, $comment) {
        $this->db->query("INSERT INTO Reviews (user_id, tmdb_movie_id, rating, comment) VALUES (:user_id, :tmdb_movie_id, :rating, :comment)");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':tmdb_movie_id', $movieId);
        $this->db->bind(':rating', $rating);
        $this->db->bind(':comment', $comment);

        return $this->db->execute();
    }

    public function getReviewsByMovieId($movieId) {
        $this->db->query("SELECT Reviews.*, Users.name as user_name FROM Reviews JOIN Users ON Reviews.user_id = Users.id WHERE tmdb_movie_id = :tmdb_movie_id ORDER BY created_at DESC");
        $this->db->bind(':tmdb_movie_id', $movieId);

        return $this->db->resultSet();
    }

    public function getUserReviewByMovieId($userId, $movieId) {
        $this->db->query("SELECT * FROM Reviews WHERE user_id = :user_id AND tmdb_movie_id = :tmdb_movie_id");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':tmdb_movie_id', $movieId);
    
        return $this->db->single();
    }
}