<?php
namespace app\models;

use \PDO;
use \PDOException;

use app\models\LogModel;

class TestModel extends DatabaseConnector
{
    // public function updateRecordIfDifferent($tableName, $updateData, $conditions)
    // {
    //     try {
    //         $this->connectToDatabase();

    //         // レコードの現在の値を取得
    //         $currentData = $this->fetchSingleResult("SELECT * FROM $tableName WHERE " . $this->buildConditionsString($conditions), $conditions);

    //         // 更新対象の値と現在の値が同じであればスキップ
    //         if ($currentData && $this->compareData($currentData, $updateData)) {
    //             $this->logModel->logMessage("Record already up-to-date. Skipping update.");
    //         } else {
    //             // 異なる場合は通常の更新処理を実行
    //             $this->updateRecord($tableName, $updateData, $conditions);
    //         }

    //         $this->closeConnection();
    //     } catch (PDOException $e) {
    //         $this->logModel->logMessage("Error updating record: " . $e->getMessage());
    //     }
    // }


    // // 二つのデータが同じかどうかを比較
    // private function compareData($data1, $data2)
    // {
    //     return count(array_diff_assoc($data1, $data2)) == 0 && count(array_diff_assoc($data2, $data1)) == 0;
    // }

    // // 条件配列をSQL文字列に変換
    // private function buildConditionsString($conditions)
    // {
    //     $conditionStrings = [];
    //     foreach ($conditions as $column => $value) {
    //         $conditionStrings[] = "$column = :$column";
    //     }
    //     return implode(" AND ", $conditionStrings);
    // }
}
?>