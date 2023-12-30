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
    protected $tableName;

    private $logModel;

    public function __construct()
    {
        $this->host = DB_HOST;
        $this->database = DB_NAME;
        $this->user = DB_USER;
        $this->password = DB_PASSWORD;
        $this->logModel = new LogModel();
        $this->tableName = 'users';
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

    /**
     * パラメーター付きでデータベースでクエリを実行するメソッド
     *
     * @param string $query プレースホルダーを含むSQLクエリ。
     * @param array $params パラメーター値の配列。
     */
    public function executeQueryWithParams($query, $params)
    {
        try {
            $this->connectToDatabase();
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
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


    /**
     * データをデータベースに挿入するメソッド
     *
     * @param array $data 挿入するデータの連想配列
     */
    public function insert($data)
    {
        try {
            $this->connectToDatabase();

            // バリデーションなどの処理を追加

            $columns = implode(", ", array_keys($data[0]));
            $placeholders = rtrim(str_repeat("?, ", count($data[0])), ", ");

            $query = "INSERT INTO {$this->tableName} ({$columns}) VALUES ({$placeholders})";

            $this->executeQueryWithParams($query, $this->flattenData($data));

            $this->logModel->logMessage("Data inserted successfully.");
        } catch (PDOException $e) {
            $this->logModel->logMessage("Error inserting data: " . $e->getMessage());
        }
    }

    /**
     * 指定された条件に基づいてデータベース内のデータを更新するメソッド
     *
     * @param array $data 更新するデータの連想配列
     * @param array $conditions 更新のための条件の配列
     */
    public function update($data, $conditions)
    {
        try {
            $this->connectToDatabase();

            // バリデーションなどの処理を追加

            // データが既存のデータと同じであればアップデートをスルーする
            if ($this->dataExists($data, $conditions)) {
                $this->logModel->logMessage("Data already exists. Update skipped.");
                return;
            }

            $setClause = implode(" = ?, ", array_keys($data[0])) . " = ?";
            $whereClause = implode(" AND ", array_map(function ($column) {
                return "$column = ?";
            }, array_keys($conditions)));

            $query = "UPDATE {$this->tableName} SET {$setClause} WHERE {$whereClause}";
            var_dump($query);
            $params = array_merge($this->flattenData($data), array_values($conditions));
            echo '<br><br>';
            var_dump($params);
            $this->executeQueryWithParams($query, $params);

            $this->logModel->logMessage("Data updated successfully.");
        } catch (PDOException $e) {
            $this->logModel->logMessage("Error updating data: " . $e->getMessage());
        }
    }

    /**
     * 多次元配列を単一次元配列に平坦化するメソッド
     *
     * @param array $data 平坦化する多次元配列。
     * @return array 平坦化された配列。
     */
    public function flattenData($data)
    {
        return call_user_func_array('array_merge', array_map('array_values', $data));
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
        $existingData = $this->fetchSingleResult("SELECT * FROM {$this->tableName} WHERE " . implode(" AND ", array_map(function ($column) {
            return "$column = ?";
        }, array_keys($conditions))), array_values($conditions));

        return $existingData !== false && $existingData == $data[0];
    }
}