<?php
namespace app\controllers;

use app\controllers\Controller;
use app\views\HomeView;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view = new HomeView();
    }

    public function index()
    {
        var_dump($_GET);
        $this->view->getHTML(['title' => 'ホーム画面']);
    }

    public function arrayTest()
    {
        $data = [
            'id' => [1, 2, 3],
            'name' => ['taro', 'jiro', 'hanako', 'suzuki'],
            'age' => [25, 30, 11, 25],
        ];
        print_r($data);
        echo '<br>';
        echo '<br>';

        $result = [];
        $count = count($data['id']); // すべての配列が同じ要素数であることを仮定します    
        for ($i = 0; $i < $count; $i++) {
            $result[] = [
                'id' => $data['id'][$i],
                'name' => $data['name'][$i],
                'age' => $data['age'][$i],
            ];
        }

        print_r($result);
    }

}
