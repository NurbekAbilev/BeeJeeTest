<?php
require __DIR__.'/../vendor/autoload.php';

@define("PROJECT_DIR",__DIR__.'\\..');

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $s = "App\\Controllers\\IndexController@index";
    $r->addRoute('GET', '/', [\App\Controller\IndexController::class, 'index']);

});

$app = new App\App($dispatcher);
$app->handleRequest();