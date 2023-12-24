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
    protected function insertData($table, $data)
    {
        $this->dbConnector->connectToDatabase();
        
        $query = "INSERT INTO $table ";
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(function ($column) {
            return ":$column";
        }, array_keys($data)));
    
        $query .= "($columns) VALUES ($placeholders);";
    
        // プレースホルダー（SQLインジェクション対策）
        $params = array();
        foreach ($data as $key => $value) {
            // カラムが password の場合にハッシュ化
            if ($key === 'password') {
                $hashedPassword = password_hash($value, PASSWORD_DEFAULT);
                $params[":$key"] = $hashedPassword;
            } else {
                $params[":$key"] = $value;
            }
        }
    
        $this->dbConnector->executeQueryWithParams($query, $params);
    
        $this->dbConnector->closeConnection();
    }

    public function getDataByCredentials($table, $data)
    {
        $this->dbConnector->connectToDatabase();

        $conditions = [];
        $params = [];
    
        foreach ($data as $key => $value) {
            $conditions[] = "$key = :$key";
            $params[":$key"] = $value;
        }
    
        $conditionString = implode(' AND ', $conditions);
        $query = "SELECT * FROM $table WHERE $conditionString";
    
        return $this->dbConnector->fetchSingleResult($query, $params);
    }    
}
