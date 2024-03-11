<?php
require_once __DIR__ . '/../vendor/autoload.php';

$url = $_GET['url'] ?? 'movies/index';
$url = explode('/', $url);
$controllerName = ucfirst($url[0]).'Controller';
$method = isset($url[1]) ? $url[1] : 'index';

if(file_exists("../app/controllers/{$controllerName}.php")) {
    require_once "../app/controllers/{$controllerName}.php";
    $controller = new $controllerName;

    if(method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], []);
    } else {
        // Método não encontrado
    }
} else {
    // Controller não encontrado
}
