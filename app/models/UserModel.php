<?php
namespace app\models;

use \Exception;

use app\models\DatabaseConnector;

class UserModel
{

    private $dbConnector;

    public function __construct()
    {
        // データベース
        $this->dbConnector = new DatabaseConnector();

        // テーブルが存在しない場合のみ作成
        if (!$this->isUsersTableExists()) {
            $this->createUsersTable();
        }
    }

    private function isUsersTableExists()
    {
        $query = "SELECT 1 FROM users LIMIT 1";
        try {
            $this->dbConnector->connectToDatabase();
            $result = $this->dbConnector->executeQuery($query);
            $this->dbConnector->closeConnection();
            return $result !== false;
        } catch (Exception $e) {
            // エラーが発生した場合も存在しないとみなす
            return false;
        }
    }

    public function createUsersTable()
    {
        $this->dbConnector->connectToDatabase();
        $query = "
        CREATE TABLE IF NOT EXISTS users (
            id serial PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
            -- 他のカラムも必要に応じて追加
        )       
        ";

        $this->dbConnector->executeQuery($query);
        $this->dbConnector->closeConnection();
    }

    // プレースホルダーを使用したデータ挿入の例
    public function insertUserData($username, $email)
    {
        $query = "INSERT INTO users (username, email) VALUES (:username, :email)";
        $params = array(':username' => $username, ':email' => $email);

        $this->dbConnector->executeQueryWithParams($query, $params);
    }

    // ユーザー名とメールアドレスからユーザーを取得
    public function getUserByCredentials($username, $email)
    {
        $query = "SELECT * FROM users WHERE username = :username AND email = :email";
        $params = array(':username' => $username, ':email' => $email);

        return $this->dbConnector->fetchSingleResult($query, $params);
    }
}
