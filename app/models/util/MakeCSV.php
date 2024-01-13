<?php
namespace app\models\util;

class MakeCSV
{

    public function __construct()
    {
    }

    public function makeCSV($filename, $data)
    {
        try {
            // CSVファイルの名前を指定
            $filename = $filename . '.csv';

            // 適切なヘッダーを送信
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            // ファイルポインタを開く
            $fp = fopen('php://output', 'w');

            // ファイルポインタのオープンに失敗した場合は例外を投げる
            if ($fp === false) {
                throw new \Exception('Failed to open php://output for writing');
            }

            // ヘッダー行を書き込む
            if (!empty($data)) {
                $header = array_keys($data[0]);
                fputcsv($fp, $header);
            }

            // データ行を書き込む
            foreach ($data as $line) {
                // 連想配列を添字配列に変換して、CSVに書き込む
                $row = array_values($line);

                // ファイルポインタへの書き込みに失敗した場合は例外を投げる
                if (fputcsv($fp, $row) === false) {
                    throw new \Exception('Error writing to php://output');
                }
            }

            // ファイルポインタを閉じる
            if (fclose($fp) === false) {
                throw new \Exception('Error closing php://output');
            }

            // これ以上の出力を防ぐためにプログラムの実行を停止
            exit;
        } catch (\Exception $e) {
            // 例外が発生した場合はエラーメッセージを投げる
            throw new \Exception('Error in methodGetCSV: ' . $e->getMessage());
        }
    }

}
