<?php

namespace app\models;

class LogModel
{
    private $logFilePath;
    private $logFileName;

    public function __construct()
    {
        $this->logFilePath = 'logs/';
        $this->logFileName = 'log_' . date('Y-m-d') . '.txt';
    }

    public function getLogFilePath()
    {
        return $this->logFilePath . $this->logFileName;
    }

    public function logMessage($message)
    {
        $this->createLogFileIfNeeded();        
        $formattedMessage = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
        file_put_contents($this->getLogFilePath(), $formattedMessage, FILE_APPEND);
    }

    private function createLogFileIfNeeded()
    {
        $logFilePath = $this->getLogFilePath();

        // ログディレクトリが存在しない場合は作成
        if (!file_exists($this->logFilePath)) {
            mkdir($this->logFilePath, 0777, true);
            chmod($this->logFilePath, 0777); // 権限を変更
        }

        // ログファイルが存在しない場合は作成
        if (!file_exists($logFilePath)) {
            touch($logFilePath); // ファイルを作成
            chmod($logFilePath, 0666); // 権限を変更
        }
    }
}
