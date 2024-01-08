<?php
namespace app\models;

use \app\models\LogModel;

class Model
{
    protected $tableName;
    protected $logModel;

    public function __construct()
    {
        // ログ
        $this->logModel = new LogModel();
    }

}
