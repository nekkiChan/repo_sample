<?php
namespace app\models\database\table;

use app\models\database\DatabaseModel;

class UsersModel extends DatabaseModel
{
    public function __construct()
    {
        parent::__construct();
        // テーブル名
        $this->tableName = DB_Users;
        $this->logModel->logMessage($this->getQueryDataTable());

        // テーブルが存在しない場合のみ作成
        if (!$this->isTableExists()) {
            $this->createTable($this->getQueryDataTable());
        }
    }

    public function getQueryDataTable()
    {
        $query = "
        CREATE TABLE IF NOT EXISTS $this->tableName (
            id serial PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
            -- 他のカラムも必要に応じて追加
        )       
        ";

        return $query;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * テーブルのカラム情報を返す
     * 
     */
    public function getColumns()
    {
        return ['id', 'username', 'email'];
    }

    // プレースホルダーを使用したデータ挿入の例
    public function insertData($data)
    {
        parent::insertData($data);
    }

    // プレースホルダーを使用したデータ更新
    public function updateData($data)
    {
        parent::updateData($data);
    }

    public function compareDataWithDB($data)
    {
        return parent::compareDataWithDB($data);
    }

    // ユーザー名からユーザーを取得
    public function getDataByCredentials($data = [])
    {
        return parent::getDataByCredentials($data);
    }
}
