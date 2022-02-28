<?php

session_start();

use App\Redirect;
use App\View;
use App\Controller\ArticleController;
use App\Controller\SignupController;

require 'vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    // Sign Up
    $r->addRoute('GET', '/signup', [SignupController::class, 'signUp']);
    $r->addRoute('POST', '/signup', [SignupController::class, 'signUpUser']);


    // Articles
    $r->addRoute('GET', '/articles', [ArticleController::class, 'index']);
    $r->addRoute('GET', '/articles/{id:\d+}', [ArticleController::class, 'show']);
    $r->addRoute('GET', '/articles/create', [ArticleController::class, 'create']);
    $r->addRoute('POST', '/articles', [ArticleController::class, 'store']);
    $r->addRoute('POST', '/articles/{id:\d+}/delete', [ArticleController::class, 'delete']);
    $r->addRoute('POST', '/articles/{id:\d+}/update', [ArticleController::class, 'edit']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "405 Method Not Allowed";

        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $routeInfo[1][0];
        $method = $routeInfo[1][1];

        $response = (new $controller)->$method($routeInfo[2]);

        $twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('app/View'));
        
        if ($response instanceof View) {
            echo $twig->render($response->getPath() . ".html", $response->getVariables());
        }
        if ($response instanceof Redirect) {
            header("Location: ". $response->getPath());
            exit;
        }
        break;
}
