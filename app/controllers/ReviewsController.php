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
        $rating = $_POST['rating'];
        $comment = trim($_POST['comment']);

        if(empty($_POST['rating'])) {
            
            $rating = null;
        }

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

    public function myReviews() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    
        $userId = $_SESSION['user_id'];
        $myReviews = $this->reviewModel->getReviewsByUserId($userId); // Assuma que você criará este método no modelo Review


        $reviewMoviesDetails = [];
        foreach ($myReviews as $review) {
            $movieDetails = $this->movieModel->fetchMovieDetailsFromTMDB($review->tmdb_movie_id);
            if (!isset($movieDetails['error'])) {
                $reviewMoviesDetails[] = $movieDetails;
            }
        }
    
        $data = [
            'myReviews' => $myReviews,
            'reviewMoviesDetails' => $reviewMoviesDetails
        ];
    
        $this->loadView('myReviews', $data);
    }

    function showReview($movieId) {

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    
        $userId = $_SESSION['user_id'];

        $review = $this->reviewModel->getUserReviewByMovieId($userId, $movieId);
        $movieDetails = $this->movieModel->fetchMovieDetailsFromTMDB($movieId);

        $data = [
            'review' => $review,
            'movieDetails' => $movieDetails
        ];
        $this->loadView('myReview', $data);
        
    }

    public function deleteReview($reviewId) {
        if (!isset($_SESSION['user_id'])) {
            // Redireciona para o login se o usuário não estiver logado
            header('Location: /login');
            exit;
        }
    
        //$userId = $_SESSION['user_id'];
    
        // Verifica se a review existe e pertence ao usuário
        $review = $this->reviewModel->getUserReviewByReviewId($reviewId);
    
        if ($review) {
            // Deleta a review
            $this->reviewModel->deleteReview($reviewId);
            // Redireciona para a lista de reviews do usuário
            header('Location: /my-reviews');
            exit;
        } else {
            // Trata o caso em que a review não é encontrada ou não pertence ao usuário
            die('Review não encontrada ou você não tem permissão para deletar esta review.');
        }
    }

    public function editReviewForm($reviewId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    
        $review = $this->reviewModel->getUserReviewByReviewId($reviewId);
        if (!$review) {
            die('Review não encontrada.');
        }
    
        $movieDetails = $this->movieModel->fetchMovieDetailsFromTMDB($review->tmdb_movie_id);
    
        $data = [
            'review' => $review,
            'movieDetails' => $movieDetails
        ];
        
        $this->loadView('myReviewEdit', $data);
    }
    
    public function updateReview($reviewId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    
        $userId = $_SESSION['user_id'];
        $rating = $_POST['rating'];
        $comment = trim($_POST['comment']);
    
        if(empty($_POST['rating'])) {
            
            $rating = null;
        }
        
        if (empty($comment)) {
            die('O comentário não pode estar vazio.');
        }
    
        $review = $this->reviewModel->getUserReviewByReviewId($reviewId);
        if (!$review || $review->user_id != $userId) {
            die('Review não encontrada ou você não tem permissão para editar esta review.');
        }
    
        $this->reviewModel->updateReview($reviewId, $rating, $comment);
    
        header('Location: /review/' . $review->tmdb_movie_id);
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
