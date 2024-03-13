<?php

require_once __DIR__ . '/vendor/autoload.php'; // Ajuste este caminho conforme necessário


use App\Database\Database;


// Criação da instância da classe Database para conectar ao banco de dados
$db = new Database();

// Comandos SQL para criação das tabelas
$tables = [
    'Users' => "
        CREATE TABLE IF NOT EXISTS Users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            name VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
    'Movies' => "
        CREATE TABLE IF NOT EXISTS Movies (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            release_date DATE,
            rating DECIMAL(3, 1),
            actors TEXT
        )",
    'Watchlist' => "
        CREATE TABLE IF NOT EXISTS Watchlist (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            movie_id INT,
            FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
            FOREIGN KEY (movie_id) REFERENCES Movies(id) ON DELETE CASCADE
        )",
    'Reviews' => "
        CREATE TABLE IF NOT EXISTS Reviews (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            movie_id INT,
            rating DECIMAL(3, 1),
            comment TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
            FOREIGN KEY (movie_id) REFERENCES Movies(id) ON DELETE CASCADE
        )"
];

// Loop para executar cada comando SQL
foreach ($tables as $name => $sql) {
    try {
        $db->query($sql);
        $db->execute();
        echo "Tabela {$name} criada com sucesso.\n";
    } catch (Exception $e) {
        echo "Erro ao criar a tabela {$name}: " . $e->getMessage() . "\n";
    }
}