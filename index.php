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

require_once 'util/route.php';
use util\Router;

$router = new Router();
$router->addRoute('', 'HomeController', 'index');
$router->addRoute('home', 'HomeController', 'index');
$router->addRoute('register', 'RegisterController', 'index');
$router->addRoute('register/create', 'RegisterController', 'register');
$router->addRoute('login', 'LoginController', 'index');
$router->addRoute('login/auth', 'LoginController', 'auth');
$router->addRoute('login/logout', 'LoginController', 'logout');
// アップロード
$router->addRoute('test/upload', 'HomeController', 'uploadTest');
$router->addRoute('test/upload/result', 'HomeController', 'uploadTestResult');
// 配列
$router->addRoute('test/array', 'HomeController', 'arrayTest');
// 画像ボタン
$router->addRoute('test/imgbtn', 'HomeController', 'imgBtnTest');
$router->addRoute('test/imgbtnResult', 'HomeController', 'imgBtnTestResult');
// カレンダーcalendar
$router->addRoute('test/calendar', 'HomeController', 'calendarTest');
$router->addRoute('test/calendarResult', 'HomeController', 'calendarTestResult');

$route = isset($_GET['url']) ? $_GET['url'] : '';
$router->dispatch($route);
