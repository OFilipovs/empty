<?php
require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Dotenv\Dotenv;
use WSB\Template;

date_default_timezone_set("Europe/Riga");
session_start();
$dotenv = Dotenv::createImmutable(__DIR__."/..");
$dotenv->load();
$loader = new FilesystemLoader('../views');
$twig = new Environment($loader);

$dispatcher = FastRoute\simpleDispatcher
(
    function(FastRoute\RouteCollector $routes)
    {
        $routes->addRoute('GET', '/', ['WSB\Controllers\HomeController', 'index']);
        $routes->addRoute('GET', '/signup', ["\WSB\Controllers\RegistrationController", 'index']);
        $routes->addRoute('GET', '/registerConfirmation', ["\WSB\Controllers\RegistrationController", 'registrationConfirm']);
        $routes->addRoute('POST', '/register', ["\WSB\Controllers\RegistrationController", 'register']);
        $routes->addRoute('GET', '/loginForm', ['WSB\Controllers\LoginController', 'loginForm']);
        $routes->addRoute('POST', '/login', ['WSB\Controllers\LoginController', 'login']);
        $routes->addRoute('GET', '/logout', ['WSB\Controllers\LoginController', 'logout']);
        $routes->addRoute('GET', '/portfolio', ['WSB\Controllers\PortfolioController', 'index']);
        $routes->addRoute('POST', '/buy', ['WSB\Controllers\PortfolioController', 'buy']);
        $routes->addRoute('GET', '/buyForm', ['WSB\Controllers\PortfolioController', 'buyForm']);
        $routes->addRoute('POST', '/buyForm', ['WSB\Controllers\PortfolioController', 'buyForm']);
        $routes->addRoute('GET', '/sellForm', ['WSB\Controllers\PortfolioController', 'sellForm']);
        $routes->addRoute('POST', '/sell', ['WSB\Controllers\PortfolioController', 'sell']);
        $routes->addRoute('GET', '/transactions', ['WSB\Controllers\PortfolioController', 'transactionView']);
    }
);

$authVars = [
    \WSB\ViewVariables\AuthViewVariables::class
];
foreach ($authVars as $var) {
    $var = new $var;
    $twig->addGlobal($var->getName(), $var->getValue());
}
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;
        $response = (new $controller)->{$method}();

        if ($response instanceof Template){
            if (! empty($_SESSION["errors"]))
            {
                $twig->addGlobal("validationErrors",$_SESSION["errors"]);
            }
            if (! empty($_SESSION["validInputs"]))
            {
                $twig->addGlobal("validInputs",$_SESSION["validInputs"]);
            }
            echo $twig->render($response->getPath(), $response->getParams());
            unset($_SESSION["errors"]);
            unset($_SESSION["validInputs"]);
        }

        break;
}


/*
 * Table for users + repository
 * login view + login controller, account model
 */