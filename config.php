<?php
// OVERVIEW:設定

// エラー表示あり
ini_set('display_errors', 1);
// 日本時間にする
date_default_timezone_set('Asia/Tokyo');
// URLディレクトリ設定
define('HOME_URL', '\\repo_sample\\');
// Appディレクトリ設定
define('APP_Path', 'app\\');
// コントローラーディレクトリ設定
define('Controller_Path', 'controllers\\');


// データベースの接続情報

// ホスト情報
define('DB_HOST', 'localhost');
// ユーザー名
define('DB_USER', 'root');
// パスワード
define('DB_PASSWORD', '');
// データベース名
define('DB_NAME', 'twitter_clone_sample');

?>