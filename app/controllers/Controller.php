<?php

namespace app\controllers;

use app\models\util\Router;
use app\models\database\table\UsersModel;
use app\models\database\table\ItemsModel;
use app\models\Model;
use app\views\View;

# Controller.php
class Controller
{
    protected $basicText;
    protected $router;
    protected $usersModel;
    protected $itemsModel;
    protected $model;
    protected $view;

    public function __construct()
    {
        $this->router = new Router();
        $this->usersModel = new UsersModel();
        $this->itemsModel = new ItemsModel();
        $this->model = new Model();
        $this->view = new View();
        $this->ajax();
    }

    protected function index()
    {
        // session_start();
    }

    public function ajax()
    {
        $jsonData = json_decode(file_get_contents('php://input'), true);

        // テスト
        $_POST['Ajax-data'] = $jsonData;
        if(!empty($jsonData)){
            $this->usersModel->updateData(
                [
                    'id' => 1,
                    'username' => $jsonData['name'],
                ]
            );
        }
    }

    protected function view($data = [])
    {
        echo $this->view->getHTML($data);
    }
}
