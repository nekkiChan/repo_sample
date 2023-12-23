<?php
// index.php

include_once 'config.php';

spl_autoload_register(function ($className) {
    $classFile = __DIR__ . '\\' . $className . '.php';

    if (file_exists($classFile)) {
        include_once $classFile;
    } else {
        echo "Class file not found: $className";
        exit;
    }
});

require_once 'route.php';

$router = new Router();
$router->addRoute('', 'HomeController', 'index');
$router->addRoute('test', 'HomeController', 'test');

$route = isset($_GET['url']) ? $_GET['url'] : '';
$router->dispatch($route);
