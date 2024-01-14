<?php
namespace app\controllers\test;

use app\controllers\Controller;
use app\models\test\GetCSVModel;
use app\views\test\GetCSVView;

class GetCSVController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new GetCSVModel();
        $this->view = new GetCSVView();
    }

    public function index()
    {
        parent::index();

        // フォームが送信された場合の処理
        $users = isset($this->model->dataWhenPostRequest) ? $this->model->dataWhenPostRequest : null;

        $data = [
            'title' => "CSVテスト画面",
            'users' => $users,
        ];
        
        parent::view($data);
    }
}
