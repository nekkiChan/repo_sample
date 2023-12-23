<?php
namespace app\controllers;

use app\controllers\Controller;

class HomeController extends Controller {
    public function index() {
        parent::index();  // 親クラスの index メソッドを呼び出す
    }

    public function test() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'register') {
            // フォームが送信された場合
            $username = $_POST['username'];
            $email = $_POST['email'];

            $this->router->redirectTo('test');

            // ユーザーデータをデータベースに登録
            $this->userModel->insertUserData($username, $email);

            // 登録後の処理（例: 成功メッセージを表示するなど）
            echo "User registered successfully!";

        } else {
            // フォームを表示
            include(__DIR__ . '/../views/test.php');
        }
    }
}
