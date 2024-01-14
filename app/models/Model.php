<?php
namespace app\models;

use app\models\LogModel;
use app\models\util\MakeCSV;

class Model
{
    protected $tableName;
    protected $logModel;
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
    protected function methodWhenPostRequest()
    {
        return null;
    }

    protected function methodGetData()
    {
        return null;
    }

}
