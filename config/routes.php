<?php

$uri = $_SERVER['REQUEST_URI'];

switch ($uri) {
    case '/':
        require_once '../src/Controller/HomeController.php';
        (new HomeController())->index();
        break;
    case '/about':
        require_once '../src/Controller/HomeController.php';
        (new HomeController())->about();
        break;
    // 他のルートの定義も追加できます
    default:
        header('HTTP/1.1 404 Not Found');
        echo '404 Not Found';
        break;
}
