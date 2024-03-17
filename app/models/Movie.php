<?php

namespace App\Models;

//use App\Database\Database;

use Exception;

class Movie {
    //private $db;
    private $apiKey = '25bbb10392bc8295016e07f3c4804105'; // Substitua por sua chave API da TMDB

    public function __construct() {
        $this->apiKey = $_ENV['TMDB_API_KEY'] ?? 'fallback_api_key'; // Use um valor padrão caso a chave não esteja definida
    }
    
    
    // public function __construct() {
    //     $this->db = new Database();
    // }

    // public function getLatestMovies() {
    //     $this->db->query("SELECT * FROM movies ORDER BY release_date DESC LIMIT 20");
    //     return $this->db->resultSet();
    // }

    public function fetchLatestMoviesFromTMDB($page = 1) {
        $url = "https://api.themoviedb.org/3/movie/popular?api_key={$this->apiKey}&language=pt-BR&page={$page}";
    
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);
    
            $data = json_decode($result, true);
    
            if (isset($data['results'])) {
                $results = $data['results'];
                $totalPages = $data['total_pages'] ?? 0; // Adiciona esta linha
                return ['results' => $results, 'totalPages' => $totalPages]; // Modifica esta linha
            } else {
                return ['results' => [], 'totalPages' => 0]; // Modifica esta linha
            }
        } catch (Exception $e) {
            return ['results' => [], 'totalPages' => 0, 'error' => $e->getMessage()]; // Modifica esta linha
        }
    }

    public function getGenresFromTMDB() {
        $url = "https://api.themoviedb.org/3/genre/movie/list?api_key={$this->apiKey}&language=pt-BR";

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            $genresArray = json_decode($result, true);

            $genresMap = [];
            if (isset($genresArray['genres'])) {
                foreach ($genresArray['genres'] as $genre) {
                    $genresMap[$genre['id']] = $genre['name'];
                }
            }

            return $genresMap;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function fetchMovieDetailsFromTMDB($id) {
        $url = "https://api.themoviedb.org/3/movie/{$id}?api_key={$this->apiKey}&language=pt-BR&append_to_response=credits,release_dates";
    
        try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);
                curl_close($ch);
    
                $data = json_decode($result, true);

            return $data;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

}