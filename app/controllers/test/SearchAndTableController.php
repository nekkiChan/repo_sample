<?php
namespace app\controllers\test;

use app\controllers\Controller;
use app\models\test\SearchAndTableModel;
use app\views\test\SearchAndTableView;

class SearchAndTableController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new SearchAndTableModel();
        $this->view = new SearchAndTableView();
    }

    public function index()
    {
        parent::index();

        // フォームが送信された場合の処理
        $users = isset($this->model->dataWhenPostRequest) ? $this->model->dataWhenPostRequest : $this->model->methodGetData();

        $data = [
            'title' => "検索テスト画面",
            'users' => $users,
        ];
        
        parent::view($data);
    }
}
