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
        // 引数が提供されなかった場合は、デフォルトのインスタンスを作成
        $this->userModel = $userModel ?? new UserModel();
        $this->loginView = $loginView ?? new LoginView();
    }

    public function index()
    {
        // ログインフォームのHTMLを生成
        $loginForm = $this->loginView->generateLoginForm();
        echo $loginForm;

        // 生成されたHTMLを変数として返す
        return $loginForm;
    }

    // ログイン処理を実装
    public function login($username, $password)
    {
        // 入力検証などのロジック

        // ユーザー認証
        $credentials = $this->userModel->getUserCredentials($username);

        if ($credentials && $credentials['password'] === $password) {
            // ログイン成功
            // ここでセッションなどを扱う
        } else {
            // ログイン失敗
            $this->loginView->showError("Invalid username or password");
        }
    }
}
