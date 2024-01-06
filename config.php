<?php
// OVERVIEW:設定

include_once './mask.conf.php';

// エラー表示あり
ini_set('display_errors', 1);
// 日本時間にする
date_default_timezone_set('Asia/Tokyo');
// デバッグモード
define('DEBUG_MODE', 0);

// URLディレクトリ設定
define('HOME_URL', '\\repo_sample\\');
// Appディレクトリ設定
define('APP_Path', 'app\\');
// コントローラーディレクトリ設定
define('Controller_Path', 'controllers\\');
// viewsディレクトリ設定
define('VIEW_Path', APP_Path.'views\\');
// CSSディレクトリ設定
define('CSS_Path', VIEW_Path.'css\\');
// IMGディレクトリ設定
define('IMG_Path', VIEW_Path.'img\\asset\\');

// DBテーブル
// users
define('DB_Users', 'users');
// items
define('DB_Items', 'items');

?>