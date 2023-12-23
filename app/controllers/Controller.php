<?php
namespace app\controllers;

use app\models\UserModel;

# Controller.php
class Controller {
    protected $basicText;  // プロパティを追加

    public function index() {
        $this->basicText = 'This is Basic';  // プロパティに値を設定
        $userModel = new UserModel();
        $userName = $userModel->getUserName();
        include(__DIR__ . '/../views/home.php');
    }

    public function getText() {
        $this->basicText = 'This is Basic';  // プロパティに値を設定
        return $this->basicText;
    }
}
