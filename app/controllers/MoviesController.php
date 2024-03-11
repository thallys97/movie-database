<?php

namespace App\Controllers;

use App\Models\Movie;

class MoviesController {
    private $movieModel;

    public function __construct() {
        $this->movieModel = new Movie();
    }

    public function index() {
        $movies = $this->movieModel->getLatestMovies();
        $data = [
            'movies' => $movies
        ];
        $this->loadView('latestMovies', $data);
    }

    private function loadView($view, $data = []) {
        if (file_exists("../app/views/{$view}.php")) {
            require_once "../app/views/{$view}.php";
        } else {
            die("View does not exist.");
        }
    }
}
