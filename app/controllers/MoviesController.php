<?php

namespace App\Controllers;

use App\Models\Movie;
use App\Models\Watchlist;

class MoviesController {
    private $movieModel;

    public function __construct() {
        $this->movieModel = new Movie();
    }

    public function index() {
        // Busca filmes da base de dados local
        //$localMovies = $this->movieModel->getLatestMovies();

        // Busca filmes mais recentes da TMDB
        $tmdbMovies = $this->movieModel->fetchLatestMoviesFromTMDB();
        $genresMap = $this->movieModel->getGenresFromTMDB();


         // Ordena os filmes por data de lançamento do mais recente para o mais antigo
        usort($tmdbMovies, function ($a, $b) {
            return strtotime($b['release_date']) <=> strtotime($a['release_date']);
        });

        $data = [
            //'localMovies' => $localMovies,
            'tmdbMovies' => $tmdbMovies,
            'genresMap' => $genresMap
        ];

        $this->loadView('latestMovies', $data);
    }

    public function show($id) {
        $movieDetails = $this->movieModel->fetchMovieDetailsFromTMDB($id);
        $genresMap = $this->movieModel->getGenresFromTMDB();
    
        // Injeta a model Watchlist para recuperar os filmes da watchlist do usuário
        $watchlistModel = new Watchlist();
        $watchlistMovies = isset($_SESSION['user_id']) ? $watchlistModel->getUserWatchlist($_SESSION['user_id']) : [];
    
        $data = [
            'movieDetails' => $movieDetails,
            'genresMap' => $genresMap,
            'watchlistMovies' => $watchlistMovies // Adiciona os filmes da watchlist aos dados passados para a view
        ];
    
        $this->loadView('movieDetails', $data);
    }
    
    private function loadView($view, $data = []) {
        if (file_exists("../app/views/{$view}.php")) {
            require_once "../app/views/{$view}.php";
        } else {
            die("View does not exist.");
        }
    }
}
