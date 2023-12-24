<?php
namespace app\models;

use \PDO;
use \PDOException;

use app\models\LogModel;

;

class DatabaseConnector
{

    private $host;
    private $database;
    private $user;
    private $password;
    private $connection;

    private $logModel;

    public function __construct()
    {
        $this->host = DB_HOST;
        $this->database = DB_NAME;
        $this->user = DB_USER;
        $this->password = DB_PASSWORD;
        $this->logModel = new LogModel();
    }

    public function connectToDatabase()
    {
        try {
            $dsn = "pgsql:host={$this->host};dbname={$this->database}";
            $this->connection = new PDO($dsn, $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->logModel->logMessage("Connected to the <$this->database> database.");
        } catch (PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
            $this->logModel->logMessage("Connection failed: " . $e->getMessage());
        }
    }

    public function closeConnection()
    {
        $this->connection = null;
        $this->logModel->logMessage("Connection closed.");
    }

    public function executeQuery($query)
    {
        try {
            $this->connectToDatabase();
            // SQLクエリを実行する前にエラーログに記録
            error_log("Executing query: $query");
            $this->logModel->logMessage("Executing query: $query");
            $this->connection->exec($query);
            $this->closeConnection();
            // エラーログに成功情報を記録
            error_log("Query executed successfully.");
            $this->logModel->logMessage("Query executed successfully.");
        } catch (PDOException $e) {
            // エラーログにエラーメッセージを記録
            error_log("Error executing query: " . $e->getMessage());
            $this->logModel->logMessage("Error executing query: " . $e->getMessage());
        }
    }


    public function executeQueryWithParams($query, $params)
    {
        try {
            $this->connectToDatabase();
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            $this->closeConnection();
            $this->logModel->logMessage("Query executed successfully.");
        } catch (PDOException $e) {
            $this->logModel->logMessage("Error executing query: " . $e->getMessage());
        }
    }

    public function fetchAll($query)
    {
        try {
            $this->connectToDatabase();
            $result = $this->connection->query($query);
            $this->closeConnection();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logModel->logMessage("Error fetching data: " . $e->getMessage());
            return null;
        }
    }

    public function fetchSingleResult($query, $params)
    {
        try {
            $this->connectToDatabase();
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            $this->closeConnection();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logModel->logMessage("Error fetching data: " . $e->getMessage());
            return null;
        }
    }
}