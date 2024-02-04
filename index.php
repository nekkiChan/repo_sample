<?php

include_once 'config.php';

spl_autoload_register(function ($className) {
    $classFile = __DIR__ . Directory_Separate . $className . '.php';
    if (file_exists($classFile)) {
        include_once $classFile;
    } else {
        echo "クラスファイルが見つかりませんでした: $classFile";
        exit;
    }
});

require_once 'app/models/util/Router.php';

use app\models\util\Router;

$router = new Router();
$router->addRoute('', 'HomeController', 'index');
$router->addRoute('home', 'HomeController', 'index');
$router->addRoute('register', 'RegisterController', 'index');
$router->addRoute('register/create', 'RegisterController', 'register');
$router->addRoute('login', 'LoginController', 'index');
$router->addRoute('login/auth', 'LoginController', 'auth');
$router->addRoute('login/logout', 'LoginController', 'logout');
// アップロード
$router->addRoute('test/upload', 'test' . Directory_Separate . 'UploadController', 'index');
// $router->addRoute('test/upload/result', 'HomeController', 'uploadTestResult');
// 配列
$router->addRoute('test/array', 'HomeController', 'arrayTest');
// 画像ボタン
$router->addRoute('test/imgbtn', 'test' . Directory_Separate . 'ImgBtnController', 'index');
// カレンダー
$router->addRoute('test/calendar', 'test' . Directory_Separate . 'CalendarController', 'index');
// 表
$router->addRoute('test/table', 'test' . Directory_Separate . 'TableController', 'index');
// CSV
$router->addRoute('test/csv', 'test' . Directory_Separate . 'GetCSVController', 'index');
// 検索
$router->addRoute('test/search', 'test' . Directory_Separate . 'SearchAndTableController', 'index');


$route = isset($_GET['url']) ? $_GET['url'] : '';
$router->dispatch($route);
