<?php
namespace app\models\database;

use app\models\Model;
use \Exception;

class DatabaseModel extends Model
{
    protected $tableName;
    protected $tableTitle;
    protected $itemsPerPage;
    protected $logModel;
    public $dbConnector;

    public function __construct()
    {
        parent::__construct();
        $this->dbConnector = new DatabaseConnector();
        $this->setTableName();
    }

    protected function setTableName($tableName = null)
    {
        // $this->tableName = $tableName;
        $this->tableName = 'users';
    }

    private function getTableName()
    {
        return $this->tableName;
    }

    /**
     * テーブルのカラム情報を返す
     * 
     */
    public function getColumns()
    {
        return [];
    }

    protected function isTableExists()
    {
        $query = "
        SELECT EXISTS (
            SELECT 1
            FROM information_schema.tables
            WHERE table_name = :table
        )";

        $params = [':table' => $this->getTableName()];

        try {
            $result = $this->dbConnector->fetchSingleResultWithParams($query, $params);
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
    protected function insertData($data)
    {
        $query = 'INSERT INTO ' . $this->getTableName();
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

    /**
     * 得られたデータがDBのものと変更されているか確認するメソッド
     * @param $data array(3) { ["id"]=> string(1) "1" ["username"]=> string(15) "管理者太郎" ["email"]=> string(14) "taro@admin.com" }
     */
    protected function compareDataWithDB($data)
    {
        $existData = $this->getDataByCredentials(['id' => $data['id']]);
        $existData = reset($existData);
        $existData = array_intersect_key($existData, array_flip(array_keys($data)));

        return array_diff_assoc($data, $existData);
    }

    // プレースホルダーを使用したデータ更新（１つのみ）
    // 例： $data
    // array(3) { ["id"]=> string(1) "1" ["username"]=> string(15) "管理者太郎" ["email"]=> string(14) "taro@admin.com" }
    protected function updateData($data)
    {
        $query = 'UPDATE ' . $this->getTableName() . ' SET ';

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

    public function getDataByCredentials($data = [])
    {
        // WHERE句の条件を格納する配列
        $conditions = array();

        // プレースホルダー（SQLインジェクション対策）
        $params = array();
        $query = 'SELECT * FROM ' . $this->getTableName();

        if (!empty($data)) {
            // $data の各要素に対して条件を構築
            foreach ($data as $key => $value) {
                $conditions[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $conditionStr = implode(' AND ', $conditions);
            $query .= " WHERE $conditionStr";
        }

        $result = $this->dbConnector->fetchResultsWithParams($query, $params);

        usort($result, function ($a, $b) {
            return $a['id'] - $b['id'];
        });

        return $result;
    }

}
