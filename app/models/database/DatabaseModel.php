<?php

namespace app\models\database;

use app\models\Model;
use \Exception;

class DatabaseModel extends Model
{
    protected $tableName;
    protected $tableTitle;
    protected $itemsPerPage;
    public $dbConnector;

    public function __construct()
    {
        parent::__construct();
        $this->dbConnector = new DatabaseConnector();
        $this->setTableName();
    }

    protected function setTableName($tableName = null)
    {
        $this->tableName = $tableName;
        // $this->tableName = 'users';
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
     * @param $data array(3) { ["id"]=> string(1) "1" ["name"]=> string(15) "管理者太郎" ["email"]=> string(14) "taro@admin.com" }
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
    // array(3) { ["id"]=> string(1) "1" ["name"]=> string(15) "管理者太郎" ["email"]=> string(14) "taro@admin.com" }
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

    /**
     * 引数のデータと合致したデータを取得するメソッド
     * 
     * @param $conditions array データの連想配列
     * @param $tableName string テーブル名
     * @param $option array オプションの連想配列
     *   - order: ['column' => '列名', 'order' => 'UP' or 'DOWN']
     *   - limit: [取得件数, オフセット]
     *   - period: [['column' => '列名', 'period' => ['Y-m-d', 'Y-m-d']], ...]
     *   - like: [['column' => '列名', 'value' => '検索文字列'], ...]
     *   - join: [['table' => '列名', 'value' => '検索文字列'], ...]
     * @return array|null データの連想配列
     */
    public function getDataByCredentials($conditions = [], $tableName = '', $option = [])
    {
        $tableName = empty($tableName) ? $this->getTableName() : $tableName;

        // WHERE句の条件を格納する配列
        $_conditions = array();

        // プレースホルダー（SQLインジェクション対策）
        $params = array();

        // クエリのカラム部分を初期化
        $selectColumns = '*';

        // selectキーが存在し、その中にテーブルとカラムの情報がある場合
        if (!empty($option['select']) && is_array($option['select'])) {
            $selectColumns = ''; // カラム部分を初期化

            foreach ($option['select'] as $selectItem) {
                $table = $selectItem['table'];
                $column = $selectItem['column'];

                // テーブル名とカラム名を組み合わせてselect句に追加
                $selectColumns .= "$table.$column AS {$table}_{$column}, ";
            }

            // 末尾の不要なカンマとスペースを削除
            $selectColumns = rtrim($selectColumns, ', ');
        }

        $query = "SELECT $selectColumns FROM $tableName";

        // JOIN 句の条件を格納する配列
        $_joins = array();

        // JOIN 句の追加
        if (!empty($option['join']) && is_array($option['join'])) {
            foreach ($option['join'] as $join) {
                $_joins[] = $join['type'] . ' JOIN ' . $join['table'] . ' ON ' . $join['on'];
            }
        }

        if (!empty($_joins)) {
            $joinStr = implode(' ', $_joins);
            $query .= " $joinStr";
        }

        // 新しい条件の追加: period
        if (!empty($option['period']) && is_array($option['period'])) {
            foreach ($option['period'] as $periodCondition) {
                $column = $periodCondition['column'];
                $start = $periodCondition['period'][0];
                $end = $periodCondition['period'][1];
                $_conditions[] = "$column BETWEEN :start_$column AND :end_$column";
                $params[":start_$column"] = $start;
                $params[":end_$column"] = $end;
            }
        }

        // 新しい条件の追加: like
        if (!empty($option['like']) && is_array($option['like'])) {
            foreach ($option['like'] as $likeCondition) {
                $column = $likeCondition['column'];
                $value = $likeCondition['value'];
                $_column = str_replace('.', '_', $column);
                $_conditions[] = "$column LIKE :$_column";
                $params[":$_column"] = "%$value%";
            }
        }

        if (!empty($conditions)) {
            // $conditions の各要素に対して条件を構築
            foreach ($conditions as $key => $values) {
                // 使用する演算子を選択
                $operator = is_array($values) ? 'IN' : '=';
                $_key = str_replace('.', '_', $key);

                if ($operator === 'IN') {
                    $_conditions[] = "$key $operator (:" . implode(",:", $values) . ")";
                } else {
                    $_conditions[] = "$key $operator :$_key";
                }

                // パラメータを追加
                if ($operator === 'IN') {
                    foreach ($values as $index => $value) {
                        $params[":$value"] = $value;
                    }
                } else {
                    $params[":$_key"] = !is_bool($values) ? $values : ($values == true ? 'YES' : 'NO');
                }
            }
        }

        if (!empty($_conditions)) {
            $conditionStr = implode(' AND ', $_conditions);
            $query .= " WHERE $conditionStr";
        }

        if (!empty($option)) {
            if (!empty($option['order']) && is_array($option['order'])) {
                $column = $option['order']['column'];
                $order = strtoupper($option['order']['order']) === 'UP' ? 'ASC' : 'DESC';
                $query .= " ORDER BY $column $order";
            }

            if (!empty($option['limit']) && count($option['limit']) == 2) {
                $count = (int) $option['limit'][0];
                $start = (int) $option['limit'][1];
                $query .= " LIMIT $count OFFSET $start";
            }
        }

        $this->logModel->logMessage("$tableName テーブルのクエリは $query");

        // 結果を取得
        $result = $this->dbConnector->fetchResultsWithParams($query, $params);

        // もし取得したデータが存在し、selectキーが存在する場合
        if (!empty($result) && !empty($option['select'])) {
            foreach ($option['select'] as $selectItem) {
                $table = $selectItem['table'];
                $column = $selectItem['column'];

                // もしデータに元のカラム名が存在する場合、新しいキーに変更
                if (array_key_exists("{$table}_{$column}", $result[0])) {
                    foreach ($result as $key => $row) {
                        $result[$key]["{$table}.{$column}"] = $result[$key]["{$table}_{$column}"];
                        unset($result[$key]["{$table}_{$column}"]);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * 指定された検索条件に基づいてデータを取得するメソッド
     *
     * @param array $searchParams 検索条件の連想配列。キーは列名、値は検索キーワード。
     * @return array|null 取得したデータの配列、または失敗時にはnull。
     */
    public function getDataBySearch($searchParams, $tableName = null)
    {
        $tableName = !empty($tableName) ? $tableName : $this->tableName;

        // 検索条件をSQLクエリに変換
        $conditions = [];
        foreach ($searchParams as $column => $value) {
            $conditions[] = "$column LIKE ?";
        }
        $whereClause = implode(" AND ", $conditions);

        $query = "SELECT * FROM {$tableName} WHERE $whereClause";

        // パラメーターの値を準備
        $params = [];
        foreach ($searchParams as $value) {
            // プレースホルダーに適用するパラメーターの値を変更する必要がある場合は、必要に応じて変更します。
            $params[] = "%$value%"; // 前後にワイルドカードを追加して部分一致検索を行う例
        }

        // クエリを実行して結果を返す
        return $this->dbConnector->fetchResultsWithParams($query, $params);
    }
}
