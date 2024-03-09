<?php
// OVERVIEW:設定

include_once __DIR__ . '/mask.conf.php';

// エラー表示あり
error_reporting(E_ALL);
ini_set('display_errors', 1);
// 日本時間にする
date_default_timezone_set('Asia/Tokyo');
// デバッグモード
define('DEBUG_MODE', 0);
// OSによってseparateを変更
$directorySeparate = (substr(PHP_OS, 0, 3) == 'WIN') ? '\\' : '/';
define('Directory_Separate', $directorySeparate);

// URLディレクトリ設定
define('HOME_URL', 'https://localhost/repo_sample' . Directory_Separate);
// Appディレクトリ設定
define('APP_Path', 'app' . Directory_Separate);
// コントローラーディレクトリ設定
define('Controller_Path', 'controllers' . Directory_Separate);
// viewsディレクトリ設定
define('VIEW_Path', APP_Path . 'views' . Directory_Separate);
// CSSディレクトリ設定
define('CSS_Path', VIEW_Path . 'css' . Directory_Separate);
// IMGディレクトリ設定
define('IMG_Path', VIEW_Path . 'img' . Directory_Separate . 'asset' . Directory_Separate);

// DBテーブル
// users
define('DB_Users', ['ID'=>'db_users', 'DB_NAME'=>'users']);
// items
define('DB_Items',  ['ID'=>'db_items', 'DB_NAME'=>'items']);
// items
define('DB_Stores',  ['ID'=>'db_stores', 'DB_NAME'=>'stores']);

// マスタ
// users
define('Master_Users', 'Users');
// items
define('Master_Items', 'Items');
