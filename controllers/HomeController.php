<?php
# HomeController.php
class HomeController {
    public function index() {
        $userModel = new UserModel();
        $userName = $userModel->getUserName();

        include(__DIR__ . '/../views/home.php');
    }
}