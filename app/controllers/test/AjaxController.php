<?php
namespace app\controllers\test;

use app\controllers\Controller;
use app\views\test\AjaxView;

class AjaxController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->model = new SearchAndTableModel();
        $this->view = new AjaxView();
    }

    public function index()
    {
        parent::index();

        // フォームが送信された場合の処理
        $users = isset($this->model->dataWhenPostRequest) ? $this->model->dataWhenPostRequest : $this->model->methodGetData();

        $data = [
            'title' => "Ajaxテスト画面",
            'users' => $users,
        ];
        
        parent::view($data);
    }
}
