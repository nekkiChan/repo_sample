<?php
namespace app\models;

use \PDO;
use \PDOException;

class DatabaseConnector
{

    private $host;
    private $database;
    private $user;
    private $password;
    private $connection;

    public function __construct()
    {
        $this->host = DB_HOST;
        $this->database = DB_NAME;
        $this->user = DB_USER;
        $this->password = DB_PASSWORD;
    }

    public function connectToDatabase()
    {
        try {
            $dsn = "pgsql:host={$this->host};dbname={$this->database}";
            $this->connection = new PDO($dsn, $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (DEBUG_MODE) {
                echo "Connected to the database.<br>";
            }
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                die("Connection failed: " . $e->getMessage());
            }
        }
    }


    public function closeConnection()
    {
        $this->connection = null;
        if (DEBUG_MODE) {
            echo "Connection closed.<br>";
        }
    }

    public function executeQuery($query)
    {
        try {
            // SQLクエリを実行する前にエラーログに記録
            error_log("Executing query: $query");

            $this->connection->exec($query);
            // エラーログに成功情報を記録
            error_log("Query executed successfully.");
        } catch (PDOException $e) {
            // エラーログにエラーメッセージを記録
            error_log("Error executing query: " . $e->getMessage());
        }
    }


    public function executeQueryWithParams($query, $params)
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            echo "Query executed successfully.<br>";
        } catch (PDOException $e) {
            echo "Error executing query: " . $e->getMessage() . "<br>";
        }
    }

    public function fetchAll($query)
    {
        try {
            $result = $this->connection->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage() . "<br>";
            return null;
        }
    }
}