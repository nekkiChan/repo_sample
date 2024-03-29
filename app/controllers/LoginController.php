<?php

namespace app\controllers;

use app\controllers\Controller;
use app\models\UserModel;
use app\views\LoginView;

class LoginController extends Controller
{
    protected $userModel;
    protected $loginView;

    public function __construct($userModel = null, $loginView = null)
    {
        parent::__construct();
        $this->loginView = $loginView ?? new LoginView();
    }

    public function index()
    {
        parent::index();
        var_dump($_SESSION);
        $loginForm = $this->loginView->generateLoginForm();
        echo $loginForm;
    }

    public function auth()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $password = $_POST['password'] ?? '';

            // 入力検証などのロジック
            if (empty($name) || empty($password)) {
                $this->loginView->showError("name and password are required");
                return;
            }

            // ユーザー認証
            $data = ['name' => $name];
            $credentials = $this->userModel->getUserByCredentials($data);

            if ($credentials && password_verify($password, $credentials['password'])) {
                // ログイン成功
                // セッション開始
                session_start();

                // ユーザー情報をセッションに保存
                $_SESSION['user_id'] = $credentials['id'];
                $_SESSION['name'] = $credentials['name'];

                $this->router->redirectTo('home');
                echo 'Login successful!';
            } else {
                // ログイン失敗
                $this->loginView->showError("Invalid name or password");
            }
        }
    }

    public function logout()
    {
        // セッション破棄
        parent::index();
        session_destroy();

        echo 'Logout successful!';

        $this->router->redirectTo('login');
    }
}
