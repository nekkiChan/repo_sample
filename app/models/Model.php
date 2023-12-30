<?php
namespace app\models;

use \Exception;

use \app\models\LogModel;
use \app\models\DatabaseConnector;

class Model
{
    protected $tableName;
    protected $logModel;
    public $dbConnector;

    public function __construct()
    {
        // ログ
        $this->logModel = new LogModel();
        // データベース
        $this->dbConnector = new DatabaseConnector();
    }

    // protected function isTableExists($table)
    // {
    //     $query = "SELECT 1 FROM $table LIMIT 1";
    //     try {
    //         // 戻り値を無視する
    //         $this->dbConnector->executeQuery($query);
    //         return true;
    //     } catch (Exception $e) {
    //         // エラーが発生した場合も存在しないとみなす
    //         return false;
    //     }
    // }
    protected function isTableExists($table)
    {
        $query = "
        SELECT EXISTS (
            SELECT 1
            FROM information_schema.tables
            WHERE table_name = :table
        )";

        $params = [':table' => $table];

        try {
            $result = $this->dbConnector->fetchSingleResult($query, $params);
            return $result['exists'] === 't';
        } catch (Exception $e) {
            return false;
        }
    }

    protected function createTable($query)
    {
        $this->dbConnector->executeQuery($query);
    }

    // プレースホルダーを使用したデータ挿入
    protected function insertData($table, $data)
    {
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
    }

    // プレースホルダーを使用したデータ更新（１つのみ）
    // 例： $data
    // array(3) { ["id"]=> string(1) "1" ["username"]=> string(15) "管理者太郎" ["email"]=> string(14) "taro@admin.com" }
    protected function updateData($table, $data)
    {
        $query = "UPDATE $table SET ";

        $columns = array_keys($data);
        $where = '';

        foreach ($columns as $column) {
            if ($column == 'id') {
                $where .= "$column = :$column";
            } else {
                $query .= "$column = :$column, ";
            }
        }
        $query = rtrim($query, ', ');
        $query .= " WHERE $where";

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
    }

    public function getDataByCredentials($table, $data)
    {
        // WHERE句の条件を格納する配列
        $conditions = array();

        // プレースホルダー（SQLインジェクション対策）
        $params = array();

        // $data の各要素に対して条件を構築
        foreach ($data as $key => $value) {
            $conditions[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        $conditionStr = implode(' AND ', $conditions);

        $query = "SELECT * FROM $table WHERE $conditionStr";

        $result = $this->dbConnector->fetchSingleResult($query, $params);

        return $result;
    }

}
