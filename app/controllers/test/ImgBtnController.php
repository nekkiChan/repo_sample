<?php

namespace app\controllers\test;

use app\controllers\Controller;
use app\views\test\ImgBtnView;

class ImgBtnController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view = new ImgBtnView();
    }

    public function index()
    {
        parent::index();

        // フォームが送信された場合の処理
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            var_dump($_POST);
        }
        $query = "SELECT id, name, email FROM users";
        $users = $this->usersModel->dbConnector->fetchAll($query);
        usort($users, function ($a, $b) {
            return $a['id'] - $b['id'];
        });
        $data = [
            'title' => "画像ボタンテスト画面",
            'users' => $users,
        ];

        parent::view($data);
    }
}
