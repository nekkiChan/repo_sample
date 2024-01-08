<?php
namespace app\controllers;

use app\models\util\Router;
use app\models\database\table\UsersModel;
use app\models\database\table\ItemsModel;
use app\views\View;

# Controller.php
class Controller
{
    protected $basicText;
    protected $router;
    protected $usersModel;
    protected $itemsModel;
    protected $view;

    public function __construct()
    {
        $this->router = new Router();
        $this->usersModel = new UsersModel();
        $this->itemsModel = new ItemsModel();
        $this->view = new View();
    }

    protected function index()
    {
        isset($_SESSION) ?? session_start() ;
    }

    protected function view($data = [])
    {
        echo $this->view->getHTML($data);
    }
}
