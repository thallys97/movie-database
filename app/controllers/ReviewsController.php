<?php

namespace App\Controllers;

use App\Models\Review;
use App\Models\Movie; // Assumindo que você tem um modelo Movie para buscar detalhes do filme

class ReviewsController {
    private $reviewModel;
    private $movieModel;

    public function __construct() {
        $this->reviewModel = new Review();
        $this->movieModel = new Movie();
    }

    public function createReviewForm($movieId) {
        // Apenas para garantir que o filme existe
        $movieDetails = $this->movieModel->fetchMovieDetailsFromTMDB($movieId);
        if (!$movieDetails) {
            // Tratar erro caso o filme não exista
            die('Filme não encontrado');
        }

        $data = [
            'movieDetails' => $movieDetails        // Adiciona os filmes da watchlist aos dados passados para a view
        ];

        $this->loadView('createReview', $data);
    }

    public function submitReview($movieId) {
        //session_start();
        if (!isset($_SESSION['user_id'])) {
            // Redireciona para o login se o usuário não estiver logado
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $rating = $_POST['rating'] ?? null;
        $comment = trim($_POST['comment']);

        $existingReview = $this->reviewModel->getUserReviewByMovieId($userId, $movieId);
        if ($existingReview) {
            die('Você já deixou uma review para este filme.');
        }

        if (empty($comment)) {
            // Tratar erro se o comentário estiver vazio
            die('O comentário não pode estar vazio.');
        }

        $this->reviewModel->createReview($userId, $movieId, $rating, $comment);

        // Redireciona de volta para a página de detalhes do filme
        header('Location: /movie/' . $movieId);
    }

    private function loadView($view, $data = []) {
        if (file_exists("../app/views/{$view}.php")) {
            require_once "../app/views/{$view}.php";
        } else {
            die("View does not exist.");
        }
    }
}