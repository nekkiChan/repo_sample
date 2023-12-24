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
        $this->userModel = $userModel ?? new UserModel();
        $this->loginView = $loginView ?? new LoginView();
    }

    public function index()
    {
        session_start();
        var_dump($_SESSION);
        $loginForm = $this->loginView->generateLoginForm();
        echo $loginForm;
    }

    public function auth()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // 入力検証などのロジック
            if (empty($username) || empty($password)) {
                $this->loginView->showError("Username and password are required");
                return;
            }

            // ユーザー認証
            $data = ['username' => $username];
            $credentials = $this->userModel->getUserByCredentials($data);

            if ($credentials && password_verify($password, $credentials['password'])) {
                // ログイン成功
                // セッション開始
                session_start();

                // ユーザー情報をセッションに保存
                $_SESSION['user_id'] = $credentials['id'];
                $_SESSION['username'] = $credentials['username'];

                $this->router->redirectTo('home');
                echo 'Login successful!';
            } else {
                // ログイン失敗
                $this->loginView->showError("Invalid username or password");
            }
        }
    }

    public function logout()
    {
        // セッション破棄
        session_start();
        session_destroy();

        echo 'Logout successful!';

        $this->router->redirectTo('login');
    }
}
