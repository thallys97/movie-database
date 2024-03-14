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
            $this->watchlistModel->addMovieToWatchlist($userId, $tmdbMovieId);
    
            // Redireciona o usuário de volta para a página de detalhes do filme
            header('Location: /movie/' . $tmdbMovieId);
            exit;
        }
    
        // Se a requisição não for POST, redirecionar para a página inicial.
        header('Location: /');
        exit;
    }

    private function loadView($view, $data = []) {
        if (file_exists("../app/views/{$view}.php")) {
            require_once "../app/views/{$view}.php";
        } else {
            die("View does not exist.");
        }
    }
}
