<?php
namespace app\models;

use \Exception;

use \app\models\LogModel;
use \app\models\DatabaseConnector;

class Model
{
    protected $logModel;
    protected $dbConnector;

    public function __construct()
    {
        // ログ
        $this->logModel = new LogModel();
        // データベース
        $this->dbConnector = new DatabaseConnector();
    }

    protected function isTableExists($table)
    {
        $query = "SELECT 1 FROM $table LIMIT 1";
        try {
            $this->dbConnector->connectToDatabase();
            // 戻り値を無視する
            $this->dbConnector->executeQuery($query);
            $this->dbConnector->closeConnection();
            return true;
        } catch (Exception $e) {
            // エラーが発生した場合も存在しないとみなす
            return false;
        }
    }

    protected function createTable($query)
    {
        $this->dbConnector->connectToDatabase();
        $this->dbConnector->executeQuery($query);
        $this->dbConnector->closeConnection();
    }

    // プレースホルダーを使用したデータ挿入
    protected function insertData($table, $columns, $data)
    {
        $query = "INSERT INTO $table ($columns[0], $columns[1]) VALUES (:$data[0], :$data[1])";
        $params = array(':' . $columns[0] => $data[0], ':' . $columns[1] => $data[1]);

        $this->dbConnector->executeQueryWithParams($query, $params);
    }

    public function getDataByCredentials($table, $columns, $data)
    {
        $query = "SELECT * FROM $table WHERE $columns[0] = :$data[0] AND $columns[1] = :$data[1]";
        $params = array(':' . $columns[0] => $data[0], ':' . $columns[1] => $data[1]);

        return $this->dbConnector->fetchSingleResult($query, $params);
    }
}
