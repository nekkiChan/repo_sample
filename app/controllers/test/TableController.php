<?php
namespace app\controllers\test;

use app\controllers\Controller;
use app\views\test\TableView;

class TableController extends Controller
{
    protected $testView;

    public function __construct()
    {
        parent::__construct();
        $this->testView = new TableView();
    }

    public function index()
    {
        $testForm = $this->testView->generateTableView();
        echo $testForm;
    }
}
