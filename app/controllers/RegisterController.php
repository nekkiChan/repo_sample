<?php
namespace app\controllers;

use app\controllers\Controller;
use app\models\UserModel;
use app\views\RegisterView;

class RegisterController extends Controller
{
    protected $userModel;
    protected $registerView;

    public function __construct($userModel = null, $registerView = null)
    {
        // 引数が提供されなかった場合は、デフォルトのインスタンスを作成
        $this->userModel = $userModel ?? new UserModel();
        $this->registerView = $registerView ?? new RegisterView();
    }

    public function index()
    {
        // レジスタフォームのHTMLを生成
        $registerForm = $this->registerView->generateRegisterForm();
        echo $registerForm;
    }

    public function register(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['url'])) {
            // フォームが送信された場合

            foreach ($_POST as $key => $value) {
                $data[$key] = $value;
            }

            // ユーザーデータをデータベースに登録
            $this->userModel->insertUserData($data);

            // 登録後の処理（例: 成功メッセージを表示するなど）
            echo "User registered successfully!";
        } else {
            // フォームを表示
            // include(__DIR__ . '/../views/test.php');
        }
    }
}
