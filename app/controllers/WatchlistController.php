<?php

namespace App\Controllers;

use App\Models\Watchlist;
use App\Models\Movie;

class WatchlistController {
    private $watchlistModel;
    private $movieModel;

    public function __construct() {
        $this->watchlistModel = new Watchlist();
        $this->movieModel = new Movie();
    }

    public function index() {
        //session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $watchlistIds = $this->watchlistModel->getUserWatchlist($userId);

        $watchlistMovies = [];
        foreach ($watchlistIds as $movieId) {
            $movieDetails = $this->movieModel->fetchMovieDetailsFromTMDB($movieId->tmdb_movie_id);
            if (!isset($movieDetails['error'])) {
                $watchlistMovies[] = $movieDetails;
            }
        }

        $data = [
            'watchlistMovies' => $watchlistMovies,
        ];

        $this->loadView('watchlist', $data);
    }

    public function addToWatchlist($movie_id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tmdbMovieId = $movie_id;
            $userId = $_SESSION['user_id'];
            $wasAdded = $this->watchlistModel->addMovieToWatchlist($userId, $tmdbMovieId);
    
            if ($wasAdded) {
                // Retorne JSON em vez de redirecionar.
                echo json_encode(['success' => true]);
                exit;
            } else {
                // Retorne JSON de erro se o filme já está na watchlist.
                echo json_encode(['success' => false, 'error' => 'O filme já está na watchlist.']);
                exit;
            }
        }
    
        // Se a requisição não for POST, redirecionar para a página inicial.
        header('Location: /');
        exit;
    }

    public function deleteFromWatchlist() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['movie_id'])) {
            $userId = $_SESSION['user_id'];
            $tmdbMovieId = $_POST['movie_id'];
            if ($this->watchlistModel->removeMovieFromWatchlist($userId, $tmdbMovieId)) {
                // Não redirecione, apenas retorne um JSON de sucesso.
                echo json_encode(['success' => true]);
                exit;
            } else {
                // Retorne um JSON de erro.
                echo json_encode(['success' => false, 'error' => 'Não foi possível remover da watchlist.']);
                exit;
            }
        }
    }

    private function loadView($view, $data = []) {
        if (file_exists("../app/views/{$view}.php")) {
            require_once "../app/views/{$view}.php";
        } else {
            die("View does not exist.");
        }
    }
}
