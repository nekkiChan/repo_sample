<?php
namespace app\controllers;

use util\Router;
use app\models\UserModel;

# Controller.php
class Controller {
    protected $basicText;
    protected $router;
    protected $userModel;

    public function __construct() {
        $this->logModel = new LogModel();
        $this->router = new Router();
        $this->userModel = new UserModel();
    }

    public function createUserTable() {
        // usersテーブルを作成
        $this->userModel->createUsersTable();
    }

    public function index() {
        $this->basicText = 'This is Basic';  // プロパティに値を設定
        $userName = 'Jone';
        include(__DIR__ . '/../views/home.php');
    }

    public function getText() {
        $this->basicText = 'This is Basic';  // プロパティに値を設定
        return $this->basicText;
    }
}
