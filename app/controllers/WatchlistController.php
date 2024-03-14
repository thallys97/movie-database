<?php

namespace App\Controllers;

use App\Models\Watchlist;

class WatchlistController {
    private $watchlistModel;

    public function __construct() {
        $this->watchlistModel = new Watchlist();
    }

    public function index() {
        //session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $watchlist = $this->watchlistModel->getUserWatchlist($userId);

        // Aqui você irá precisar buscar detalhes dos filmes pela API do TMDB usando os IDs na watchlist
        // Para simplificação, estamos passando apenas os IDs para a view
        $data = [
            'watchlist' => $watchlist,
        ];

        $this->loadView('watchlist', $data);
    }

    private function loadView($view, $data = []) {
        if (file_exists("../app/views/{$view}.php")) {
            require_once "../app/views/{$view}.php";
        } else {
            die("View does not exist.");
        }
    }
}
