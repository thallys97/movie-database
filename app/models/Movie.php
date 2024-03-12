<?php

namespace App\Models;

//use App\Database\Database;

use Exception;

class Movie {
    //private $db;
    private $apiKey = '25bbb10392bc8295016e07f3c4804105'; // Substitua por sua chave API da TMDB

    // public function __construct() {
    //     $this->db = new Database();
    // }

    // public function getLatestMovies() {
    //     $this->db->query("SELECT * FROM movies ORDER BY release_date DESC LIMIT 20");
    //     return $this->db->resultSet();
    // }

    public function fetchLatestMoviesFromTMDB() {
        $url = "https://api.themoviedb.org/3/movie/now_playing?api_key={$this->apiKey}&language=pt-BR";

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($result, true);

            // Garantir que a resposta contém a chave 'results' que é esperada ser um array de filmes
            if (isset($data['results'])) {
                return $data['results'];
            } else {
                return []; // Retorna um array vazio caso não existam resultados
            }
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}