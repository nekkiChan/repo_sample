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
        $this->router = new Router();
        $this->userModel = new UserModel();
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
