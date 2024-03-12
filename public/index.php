<?php
require_once __DIR__ . '/../vendor/autoload.php';

$url = $_GET['url'] ?? 'movies/index';
$url = explode('/', $url);

// Corrige a criação do nome do controller para incluir o namespace completo
$controllerName = 'App\\Controllers\\' . ucfirst($url[0]) . 'Controller';
$method = $url[1] ?? 'index';

// Verifica se a classe do controller existe (não é mais necessário verificar se o arquivo existe)
if(class_exists($controllerName)) {
    $controller = new $controllerName();

    if(method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], []);
    } else {
        // Método não encontrado
        echo "Método {$method} não encontrado no controller {$controllerName}.";
    }
} else {
    // Controller não encontrado
    echo "Controller {$controllerName} não encontrado.";
}
