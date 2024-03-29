<?php

namespace app\controllers;

use app\controllers\Controller;
use app\views\RegisterView;

class RegisterController extends Controller
{
    protected $userModel;
    protected $registerView;

    public function __construct($userModel = null, $registerView = null)
    {
        parent::__construct();
        // 引数が提供されなかった場合は、デフォルトのインスタンスを作成
        $this->view = $registerView ?? new RegisterView();
    }

    public function index()
    {
        // レジスタフォームのHTMLを生成
        $this->view->getHTML([
            'title' => '登録画面',
        ]);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['url'])) {
            // フォームが送信された場合

            foreach ($_POST as $key => $value) {
                $data[$key] = $value;
            }

            // ユーザーデータをデータベースに登録
            $this->userModel->insertData($data);

            // 登録後の処理（例: 成功メッセージを表示するなど）
            echo "User registered successfully!";
        } else {
            // フォームを表示
            // include(__DIR__ . '/../views/test.php');
        }
    }
}
