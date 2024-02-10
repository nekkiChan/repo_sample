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
    public function methodWhenPostRequest()
    {
        return null;
    }

    public function methodGetData()
    {
        return null;
    }

}
