<?php

require_once 'models/LogModel.php';

use app\models\LogModel;

class LogController
{
    private $logModel;

    public function __construct()
    {
        $this->logModel = new LogModel();
    }

    public function logMessage($message)
    {
        $this->logModel->logMessage($message);
    }
}
