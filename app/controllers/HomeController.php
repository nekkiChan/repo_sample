<?php
namespace app\controllers;

use app\controllers\Controller;
use app\views\HomeView;
use app\views\TestView;

class HomeController extends Controller
{

    protected $homeView;
    protected $testView;

    public function __construct()
    {
        parent::__construct();
        $this->homeView = new HomeView();
        $this->testView = new TestView();
    }

    public function index()
    {
        $homeForm = $this->homeView->generateHomeView();
        echo $homeForm;
    }

    public function arrayTest(){
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

    public function uploadTest()
    {
        $data = [
            ['id' => 1, 'name' => 'taro', 'age' => 25],
            ['id' => 2, 'name' => 'jiro', 'age' => 30],
            ['id' => 3, 'name' => 'hanako', 'age' => 11],
        ];
        $viewData = ['data' => $data];
        // var_dump($viewData);
        $testForm = $this->testView->generateTestView($viewData);
        echo $testForm;
    }

    public function uploadTestResult()
    {
        // フォームが送信された場合の処理
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            foreach ($_POST as $key => $value) {
                var_dump($key);
                echo ' : ';
                var_dump($value);
                echo '<br>';
            }
            $changedInputs = array();

            foreach ($_POST as $key => $value) {
                // 各input要素の変更を確認
                if (strpos($key, '_original') !== false) {
                    // オリジナルの隠しフィールドは無視する
                    continue;
                }

                $originalKey = $key . '_original';
                if (isset($_POST[$originalKey]) && $value !== $_POST[$originalKey]) {
                    $id = $_POST[$key . '_id'];
                    $changedInputs[$key] = [
                        'id' => $id,
                        'value' => $value
                    ];
                }
            }

            foreach ($changedInputs as $key => $value) {
                var_dump($value);
                echo '<br>';
            }

            // $changedInputsに変更されたinput要素の値が格納される
        }
    }

}
