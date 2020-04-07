<?php

namespace App;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Dotenv;

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
        $this->entityManager = $this->createEntityManager();
        
   
        $twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('../app/views'));

        $className = $params[0];
        $methodName = $params[1];
        $controller = new $className($twig);
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

    private function createEntityManager(){

        $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);

        // $isDevMode = true;
        // $proxyDir = null;
        // $cache = null;
        // $useSimpleAnnotationReader = false;
        // $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
        // // database configuration parameters
        // $dbParams = [
        //     'driver'   => 'pdo_mysql',
        //     'user'     => 'root',
        //     'password' => '',
        //     'dbname'   => 'foo',
        // ];
        // $connectionParams = array(
        //     'dbname' => 'mydb',
        //     'user' => 'user',
        //     'password' => 'secret',
        //     'host' => 'localhost',
        //     'driver' => 'pdo_mysql',
        // );
        // $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
        

        return EntityManager::create($dbParams, $config);
    }

    private function loadConfig()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'\\..\\');
        $dotenv->load();
    }
}