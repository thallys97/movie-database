<?php

namespace App\Controllers;

use App\Models\Movie;

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

        $data = [
            //'localMovies' => $localMovies,
            'tmdbMovies' => $tmdbMovies,
            'genresMap' => $genresMap
        ];

        $this->loadView('latestMovies', $data);
    }

    public function show($id) {
        $movieDetails = $this->movieModel->fetchMovieDetailsFromTMDB($id);
        $data = [
            'movieDetails' => $movieDetails
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
