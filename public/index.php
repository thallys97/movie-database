<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Inicia a sessão
session_start();

// A URL padrão é a raiz '/'
$url = trim($_GET['url'] ?? '', '/');
$urlParts = explode('/', $url);

// Inicializa variáveis para controller e method
$controllerName = '';
$method = '';
$params = [];

// Roteamento para MoviesController
if (!empty($urlParts[0]) && $urlParts[0] === 'movie') {
    $controllerName = 'App\\Controllers\\MoviesController';
    $controller = new $controllerName();
    $method = !empty($urlParts[1]) ? 'show' : 'index';
    if($method == 'show') {
        $params[] = $urlParts[1]; // Passa o ID do filme como parâmetro
    }
} 
// Roteamento para AuthController
elseif (!empty($urlParts[0]) && in_array($urlParts[0], ['login', 'register', 'logout'])) {
    $controllerName = 'App\\Controllers\\AuthController';
    $controller = new $controllerName();
    $method = $urlParts[0];
}

elseif (!empty($urlParts[0]) && $urlParts[0] === 'watchlist') {
    $controllerName = 'App\\Controllers\\WatchlistController';
    $controller = new $controllerName();
    $method = 'index';
}
else {
    // Fallback para MoviesController index
    $controllerName = 'App\\Controllers\\MoviesController';
    $controller = new $controllerName();
    $method = 'index';
}

// Chama o método do controller se ele existir
if (method_exists($controller, $method)) {
    call_user_func_array([$controller, $method], $params);
} else {
    echo "Método {$method} não encontrado no controller {$controllerName}.";
}
