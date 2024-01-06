<?php
namespace app\controllers;

use util\Router;
use app\models\UserModel;
use app\views\View;

# Controller.php
class Controller {
    protected $basicText;
    protected $router;
    protected $userModel;
    protected $view;

    public function __construct() {
        $this->router = new Router();
        $this->userModel = new UserModel();
        $this->view = new View();
    }

    public function index() {
        session_start();
    }

    public function getText() {
        $this->basicText = 'This is Basic';  // プロパティに値を設定
        return $this->basicText;
    }
}
