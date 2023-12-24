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
}
