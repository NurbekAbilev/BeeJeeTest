<?php

namespace App;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Dotenv;
use PDO;

class App
{
    /** Entity manager Doctrine ORM */
    public $entityManager;

    public $router;

    public $config;
    
    public function __construct($router)
    {
        $this->router = $router;
    }

    private function invokeController($params)
    {
        $this->config = $this->loadConfig();
        $em = $this->entityManager = $this->createEntityManager();

        $twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('../app/views'));
        session_start();

        $className = $params[0];
        $methodName = $params[1];
        $controller = new $className($twig,$em);
        $controller->{$methodName}();
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
                $this->invokeController($handler);
                break;
        }
    }

    private function createEntityManager()
    {
        $driver = getenv('DB_DRIVER');
        $host = getenv('DB_HOST');
        $dbName = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $config = Setup::createAnnotationMetadataConfiguration([base_path('/app/models')], $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

        $connectionParams = array(
            'dbname' => $dbName,
            'user' => $user,
            'password' => $password,
            'host' => $host,
            'driver' => $driver,
            'charset' =>  'UTF8',
        );
        $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
        
        return EntityManager::create($conn,$config);
    }

    private function loadConfig()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(base_path());
        $dotenv->load();
    }
}