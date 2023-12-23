<?php
namespace app\models;

use app\models\DatabaseConnector;

class UserModel
{

    private $dbConnector;

    public function __construct()
    {
        // データベース
        $this->dbConnector = new DatabaseConnector();
        $this->dbConnector->connectToDatabase();
        $this->createUsersTable();
    }

    public function createUsersTable()
    {
        $query = "
        CREATE TABLE IF NOT EXISTS users (
            id serial PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL
            -- 他のカラムも必要に応じて追加
        );        
        ";

        $this->dbConnector->executeQuery($query);
    }

    // プレースホルダーを使用したデータ挿入の例
    public function insertUserData($username, $email)
    {
        echo "こんにちは<br>";
        echo "$username<br>$email";
        $query = "INSERT INTO users (username, email) VALUES (:username, :email)";
        $params = array(':username' => $username, ':email' => $email);

        $this->dbConnector->executeQueryWithParams($query, $params);
    }
}
