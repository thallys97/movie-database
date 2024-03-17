<?php

namespace App\Controllers;

use App\Models\Movie;
use App\Models\Watchlist;
use App\Models\Review;

class MoviesController {
    private $movieModel;

    public function __construct() {
        $this->movieModel = new Movie();
    }

    public function index($page = 1) {
        // Busca filmes da base de dados local
        //$localMovies = $this->movieModel->getLatestMovies();

        $searchQuery = $_GET['search'] ?? null; // Pega o termo de busca da URL, se houver



        if ($searchQuery) {
            $tmdbMoviesData = $this->movieModel->searchMoviesByTitle($searchQuery);
        } else {
            $tmdbMoviesData = $this->movieModel->fetchLatestMoviesFromTMDB($page);
        }
        
        $tmdbMovies = $tmdbMoviesData['results'] ?? []; // Certifique-se de que $tmdbMovies é sempre um array
        $totalPages = $tmdbMoviesData['totalPages'] ?? 0;
    
        
        
        
        // Busca filmes mais recentes da TMDB
        // $tmdbMoviesData = $this->movieModel->fetchLatestMoviesFromTMDB($page);
        // $tmdbMovies = $tmdbMoviesData['results'];
        
        
        $genresMap = $this->movieModel->getGenresFromTMDB();
        
        
        // Ordena os filmes por data de lançamento do mais recente para o mais antigo
        if (!empty($tmdbMovies) && !$searchQuery) {
            usort($tmdbMovies, function ($a, $b) {
                return strtotime($b['release_date']) <=> strtotime($a['release_date']);
            });
        }

        $data = [
            //'localMovies' => $localMovies,
            'tmdbMovies' => $tmdbMovies,
            'genresMap' => $genresMap,
            'currentPage' => $page, // Adiciona a página atual aos dados
            'totalPages' => $totalPages // Adiciona o total de páginas aos dados
        ];

        $this->loadView('latestMovies', $data);
    }

    public function show($id) {
        $movieDetails = $this->movieModel->fetchMovieDetailsFromTMDB($id);
        $genresMap = $this->movieModel->getGenresFromTMDB();
    
        // Injeta a model Watchlist para recuperar os filmes da watchlist do usuário
        $watchlistModel = new Watchlist();
        $watchlistMovies = isset($_SESSION['user_id']) ? $watchlistModel->getUserWatchlist($_SESSION['user_id']) : [];
    
        $reviewModel = new Review();
        $reviews = $reviewModel->getReviewsByMovieId($id);

        // Busque a possível review existente feita pelo usuário
        $userReview = isset($_SESSION['user_id']) ? $reviewModel->getUserReviewByMovieId($_SESSION['user_id'], $id) : null;

        
        $data = [
            'movieDetails' => $movieDetails,
            'genresMap' => $genresMap,
            'watchlistMovies' => $watchlistMovies, // Adiciona os filmes da watchlist aos dados passados para a view
            'reviews' => $reviews,
            'userReview' => $userReview // Adiciona a review do usuário aos dados passados para a view
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
