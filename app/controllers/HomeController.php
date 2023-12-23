<?php
namespace app\controllers;

use app\controllers\Controller;

class HomeController extends Controller {
    public function index() {
        parent::index();  // 親クラスの index メソッドを呼び出す
    }

    public function test() {
        $basicText = $this->getText();  // 親クラスの getText メソッドを呼び出す
        include(__DIR__ . '/../views/test.php');
    }
}
