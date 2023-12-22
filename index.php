<?php
spl_autoload_register(function ($className) {
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    
    // コントローラーのクラスファイルを探す
    $controllerClassFile = __DIR__ . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $className . '.php';
    if (file_exists($controllerClassFile)) {
        include_once $controllerClassFile;
        return;
    }

    // モデルのクラスファイルを探す
    $modelClassFile = __DIR__ . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $className . '.php';
    if (file_exists($modelClassFile)) {
        include_once $modelClassFile;
        return;
    }

    // クラスファイルが見つからない場合のエラーハンドリング
    echo "Class file not found: $className";
    exit;
});

$controller = new HomeController();
$controller->index();
