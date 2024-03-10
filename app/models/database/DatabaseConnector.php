<?php

namespace app\models\database;

use \PDO;
use \PDOException;

use app\models\LogModel;

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

    /**
     * データベースへの接続を確立するメソッド
     */
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

    /**
     * データベース接続を閉じるメソッド
     */
    public function closeConnection()
    {
        $this->connection = null;
        $this->logModel->logMessage("Connection closed.");
    }

    /**
     * テーブル名やカラム名をエスケープする関数
     * 
     * @param string $identifier エスケープする名前
     * @return string エスケープされた名前
     */
    function escapeIdentifier($identifier)
    {
        // エスケープ処理を実装する（例えば、`が使われるデータベースではバッククォートでエスケープするなど）
        return "`" . str_replace("`", "``", $identifier) . "`";
    }


    // prepareメソッドの実装
    public function prepare($query)
    {
        try {
            $this->connectToDatabase();
            // SQLクエリを実行する前にエラーログに記録
            error_log("Executing query: $query");
            $this->logModel->logMessage("Executing query: $query");
            $data = $this->connection->prepare($query);
            $this->closeConnection();
            // エラーログに成功情報を記録
            error_log("Query executed successfully.");
            $this->logModel->logMessage("Query executed successfully.");
            return $data;
        } catch (PDOException $e) {
            // エラーログにエラーメッセージを記録
            error_log("Error executing query: " . $e->getMessage());
            $this->logModel->logMessage("Error executing query: " . $e->getMessage());
        }
    }

    /**
     * データベースでクエリを実行するメソッド
     *
     * @param string $query 実行するSQLクエリ。
     */
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
            $this->logModel->logMessage("クエリ: $query");
            $statement = $this->connection->prepare($query);
            foreach ($params as $param => $value) {
                $this->logModel->logMessage("パラメータ: $query");
                $this->logModel->logMessage("値: $value");
                $statement->bindValue($param, $value, PDO::PARAM_STR);
            }
            $statement->execute();
            $this->closeConnection();
            $this->logModel->logMessage("Query executed successfully: $query"); // クエリを出力するよう変更
        } catch (PDOException $e) {
            $this->logModel->logMessage("Error executing query: " . $e->getMessage());
        }
    }


    /**
     * クエリ結果からすべての行を取得するメソッド
     *
     * @param string $query データを取得するSQLクエリ。
     * @return array|null 取得したデータの配列、または失敗時にはnull。
     */
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

    /**
     * パラメーター付きでクエリ結果から単一のレコードを取得するメソッド
     *
     * @param string $query プレースホルダーを含むSQLクエリ。
     * @param array $params パラメーター値の配列。
     * @return array|null 取得した行、または失敗時にはnull。
     */
    public function fetchSingleResultWithParams($query, $params)
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

    /**
     * パラメーター付きでクエリ結果から複数のレコードを取得するメソッド
     *
     * @param string $query プレースホルダーを含むSQLクエリ。
     * @param array $params パラメーター値の配列。
     * @return array|null 取得した行の配列、または失敗時にはnull。
     */
    public function fetchResultsWithParams($query, $params)
    {
        try {
            $this->connectToDatabase();
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            $this->closeConnection();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logModel->logMessage("データの取得中にエラーが発生しました: " . $e->getMessage());
            return null;
        }
    }


    /**
     * データが既存のデータと同じであるかをチェックするメソッド
     *
     * @param array $data チェックするデータの配列。
     * @param array $conditions 更新のための条件の配列。
     * @return bool 既存のデータと同じであればtrue、そうでなければfalse。
     */
    private function dataExists($data, $conditions)
    {
        $databaseModel = new DatabaseModel();
        $existingData = $this->fetchSingleResultWithParams("SELECT * FROM " . $databaseModel->getTableName() . " WHERE " . implode(" AND ", array_map(function ($column) {
            return "$column = ?";
        }, array_keys($conditions))), array_values($conditions));

        return $existingData !== false && $existingData == $data[0];
    }
}
