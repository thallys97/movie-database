<?php
require_once __DIR__ . '/../vendor/autoload.php';

// A URL padrão é a raiz '/'


$url = trim($_GET['url'] ?? '', '/');



$urlParts = explode('/', $url);

$controllerName = 'App\\Controllers\\MoviesController';
$controller = new $controllerName();

// Se a URL contiver 'movie' como o primeiro segmento, chame o método 'show'
if (!empty($urlParts[0]) && $urlParts[0] === 'movie' && !empty($urlParts[1])) {
    $id = $urlParts[1]; // O ID do filme é o segundo segmento da URL
    $method = 'show';

    if (method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], [$id]);
    } else {
        echo "Método {$method} não encontrado no controller {$controllerName}.";
    }
} else {
    // Para todas as outras URLs, incluindo a raiz '/', chame o método 'index'
    $method = 'index';

    if (method_exists($controller, $method)) {
        call_user_func([$controller, $method]);
    } else {
        echo "Método {$method} não encontrado no controller {$controllerName}.";
    }
}