<?php
namespace app\controllers\test;

use app\controllers\Controller;
use app\views\test\TableView;

class TableController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view = new TableView();
    }

    public function index()
    {
        parent::index();
        $data = [
            'title' => "表テスト画面",
        ];
        parent::view($data);
    }
}
