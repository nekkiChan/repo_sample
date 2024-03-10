<?php
namespace app\models;

use app\models\LogModel;
use app\models\util\MakeCSV;

class Model
{
    protected $tableName;
    public $logModel;
    protected $makeCSV;
    public $dataWhenPostRequest;

    public function __construct()
    {
        // ログ
        $this->logModel = new LogModel();
        $this->makeCSV = new MakeCSV();
        $this->dataWhenPostRequest = $_SERVER['REQUEST_METHOD'] === 'POST' ? $this->methodWhenPostRequest() : null;
    }

    // POSTリクエスト
    public function methodWhenPostRequest()
    {
        return null;
    }

    public function methodGetData()
    {
        return null;
    }

    public function getSampleData(){
        return $content = [
            ['id' => 1, 'name' => 'taro', 'age' => 12],
            ['id' => 2, 'name' => 'jiro', 'age' => 14],
            ['id' => 3, 'name' => 'taro', 'age' => 12],
            ['id' => 4, 'name' => 'jiro', 'age' => 14],
            ['id' => 5, 'name' => 'taro', 'age' => 12],
            ['id' => 6, 'name' => 'jiro', 'age' => 14],
            ['id' => 7, 'name' => 'taro', 'age' => 12],
            ['id' => 8, 'name' => 'jiro', 'age' => 14],
            ['id' => 9, 'name' => 'taro', 'age' => 12],
            ['id' => 10, 'name' => 'jiro', 'age' => 14],
            ['id' => 11, 'name' => 'taro', 'age' => 12],
            ['id' => 12, 'name' => 'jiro', 'age' => 14],
            ['id' => 13, 'name' => 'taro', 'age' => 12],
            ['id' => 14, 'name' => 'jiro', 'age' => 14],
            ['id' => 15, 'name' => 'taro', 'age' => 12],
            ['id' => 16, 'name' => 'jiro', 'age' => 14],
            ['id' => 17, 'name' => 'taro', 'age' => 12],
            ['id' => 18, 'name' => 'jiro', 'age' => 14],
            ['id' => 19, 'name' => 'taro', 'age' => 12],
            ['id' => 20, 'name' => 'jiro', 'age' => 14],
            ['id' => 21, 'name' => 'taro', 'age' => 12],
            ['id' => 22, 'name' => 'jiro', 'age' => 14],
            ['id' => 23, 'name' => 'taro', 'age' => 12],
            ['id' => 24, 'name' => 'jiro', 'age' => 14],
            ['id' => 25, 'name' => 'taro', 'age' => 12],
            ['id' => 26, 'name' => 'jiro', 'age' => 14],
            ['id' => 27, 'name' => 'taro', 'age' => 12],
            ['id' => 28, 'name' => 'jiro', 'age' => 14],
            ['id' => 29, 'name' => 'taro', 'age' => 12],
            ['id' => 30, 'name' => 'jiro', 'age' => 14],
        ];
    }

}
