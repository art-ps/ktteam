<?php
declare(strict_types=1);

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;

$container = require __DIR__ . '/../app/bootstrap.php';

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/task/{id}', ['TaskTracker\Http\Controller\TaskController', 'get']);
    $r->addRoute('GET', '/task', ['TaskTracker\Http\Controller\TaskController', 'index']);
    $r->addRoute('POST', '/task', ['TaskTracker\Http\Controller\TaskController', 'create']);
    $r->addRoute('PUT', '/task/{id}', ['TaskTracker\Http\Controller\TaskController', 'edit']);
    $r->addRoute('DELETE', '/task/{id}', ['TaskTracker\Http\Controller\TaskController', 'delete']);
    $r->addRoute('GET', '/user', ['TaskTracker\Http\Controller\UserController', 'index']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

$route = $dispatcher->dispatch($httpMethod, $uri);

switch ($route[0]) {
    case Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;

    case Dispatcher::METHOD_NOT_ALLOWED:
        echo '405 Method Not Allowed';
        break;

    case Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];

        $container->call($controller, $parameters);
        break;
}
