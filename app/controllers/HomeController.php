<?php
namespace app\controllers;

use app\controllers\Controller;

class HomeController extends Controller {
    public function index() {
        parent::index();  // 親クラスの index メソッドを呼び出す
    }
}
