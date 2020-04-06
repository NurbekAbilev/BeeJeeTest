<?php

namespace App;

class App
{
    /** @var Router */
    public $router;

    public function __construct($router)
    {
        $this->router = $router;
    }

    public function invokeController($handler)
    {
        $className = $handler[0];
        $methodName = $handler[1];
        $controller = new $className;
        $controller->{$handler[1]}();
    }

    public function handleRequest(){
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $this->router->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                echo "Not Found 404";
                die;
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                echo "Method not allowed";
                die;
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                // var_dump([$handler,$vars]);
                $this->invokeController($handler);
                // ... call $handler with $vars
                break;
        }
    }
}