<?php
namespace app\models;

use \Exception;

use \app\models\LogModel;
use \app\models\DatabaseConnector;

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
