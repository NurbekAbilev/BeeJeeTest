<?php
require __DIR__.'/../vendor/autoload.php';

@define("PROJECT_DIR",__DIR__.'\\..');
require_once '../helpers.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', [\App\Controller\IndexController::class, 'index']);
    $r->addRoute('GET', '/create', [\App\Controller\TaskController::class, 'show']);
    $r->addRoute('POST', '/create', [\App\Controller\TaskController::class, 'create']);
});

$app = new App\App($dispatcher);
$app->handleRequest();