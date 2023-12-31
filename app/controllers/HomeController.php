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

    public function uploadTest()
    {
        $query = "SELECT id, username, email FROM users";
        $viewData = [
            'users' => $this->userModel->dbConnector->fetchAll($query),
        ];
        // var_dump($viewData);
        $testForm = $this->testView->generateTestView($viewData);
        echo $testForm;
    }

    public function uploadTestResult()
    {
        // フォームが送信された場合の処理
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $keys = array_keys($_POST);

            $data = array_map(function (...$values) use ($keys) {
                return array_combine($keys, $values);
            }, ...array_values($_POST));

            foreach ($data as $key => $value) {
                // 変更されているか確認
                if ($this->userModel->compareUserDataWithDB($data[$key])) {
                    // アップデート
                    $this->userModel->updateUserData($data[$key]);
                }else{
                echo $data[$key]['username'].'のデータに変更はありません<br>';
                }
            }
        }
    }

    public function imgBtnTest()
    {
        $query = "SELECT id, username, email FROM users";
        $viewData = [
            'users' => $this->userModel->dbConnector->fetchAll($query),
        ];
        $testForm = $this->testView->generateImgBtnTestView($viewData);
        echo $testForm;
    }

    public function imgBtnTestResult()
    {

    }

}
