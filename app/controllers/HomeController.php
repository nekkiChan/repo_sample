<?php
namespace app\controllers;

use app\controllers\Controller;
use app\views\HomeView;

class HomeController extends Controller {

    protected $homeView;

    public function __construct()
    {
        parent::__construct();
        $this->homeView = new HomeView();
    }

    public function index() {
        $homeForm = $this->homeView->generateHomeView();
        echo $homeForm;
    }
}
