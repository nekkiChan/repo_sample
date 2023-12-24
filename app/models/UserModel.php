<?php
namespace app\models;

use app\models\Model;

class UserModel extends Model
{
    public function __construct()
    {
        // データベース
        $this->dbConnector = new DatabaseConnector();
        // テーブル名
        $this->tableName = 'users';

        // テーブルが存在しない場合のみ作成
        if (!$this->isTableExists($this->tableName)) {
            $this->createTable($this->getQueryUsersTable());
        }
    }

    public function getQueryUsersTable()
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

    // プレースホルダーを使用したデータ挿入の例
    public function insertUserData($data)
    {
        $this->insertData($this->tableName, $data);
    }

    // ユーザー名とメールアドレスからユーザーを取得
    public function getUserByCredentials($data)
    {
        return $this->getDataByCredentials($this->tableName, $data);
    }
}
