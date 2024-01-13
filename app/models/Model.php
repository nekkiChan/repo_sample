<?php
namespace app\models;

use \app\models\LogModel;

class Model
{
    protected $tableName;
    protected $logModel;
    public $dataWhenPostRequest;

    public function __construct()
    {
        // ログ
        $this->logModel = new LogModel();
        $this->dataWhenPostRequest = $_SERVER['REQUEST_METHOD'] === 'POST' ? $this->methodWhenPostRequest() : null;
    }

    // POSTリクエスト
    protected function methodWhenPostRequest()
    {
        return null;
    }

}
