<?php
require __DIR__.'/../vendor/autoload.php';

@define("PROJECT_DIR",__DIR__.'\\..');
require_once '../helpers.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    /** List of tasks */
    $r->addRoute('GET', '/', [\App\Controller\IndexController::class, 'index']);

    /** Create */
    $r->addRoute('GET', '/create', [\App\Controller\TaskController::class, 'show']);
    $r->addRoute('POST', '/create', [\App\Controller\TaskController::class, 'create']);

    /** Edit */
    $r->addRoute('GET', '/edit', [\App\Controller\TaskController::class, 'edit']);
    $r->addRoute('POST', '/save', [\App\Controller\TaskController::class, 'save']);

    /** Delete */
    $r->addRoute('GET', '/delete', [\App\Controller\TaskController::class, 'delete']);

    /** Auth routine */
    $r->addRoute('GET', '/login', [\App\Controller\LoginController::class, 'show']);
    $r->addRoute('POST', '/login', [\App\Controller\LoginController::class, 'login']);
    $r->addRoute('POST', '/logout', [\App\Controller\LoginController::class, 'logout']);
});

$app = new App\App($dispatcher);
$app->handleRequest();