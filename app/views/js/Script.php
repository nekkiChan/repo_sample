<?php
namespace app\views\js;

use \app\models\LogModel;

class Script
{
    protected $logModel;

    public function __construct()
    {
        // ログ
        $this->logModel = new LogModel();
    }

    public function toggleValue()
    {
        $code = <<<HTML
        <script>
            function toggleValue(element) {
                // hidden inputを取得
                var hiddenInput = element.nextElementSibling;

                // 現在のvalueを取得
                var currentValue = hiddenInput.value;

                // valueを反転させる
                var newValue = (currentValue === 'true') ? 'false' : 'true';

                // hidden inputのvalueを更新
                hiddenInput.value = newValue;

                // デバッグ用に背景色を変更
                if (newValue === 'false') {
                    element.style.backgroundColor = 'blue'; // falseの場合、背景色を青に設定
                } else {
                    element.style.backgroundColor = 'red'; // trueの場合、背景色を赤に設定
                }

                // クリックされたことを確認するためにコンソールにログを出力（不要であれば削除しても構いません）
                console.log('New value:', newValue);
            }
        </script>
        HTML;

        return $code;
    }

    public function addRow()
    {
        $code = <<<HTML
        <script>
            // JavaScriptで新しい行を追加するメソッド
            function addRow(element) {
                // マスタ名
                var masterName = element;
                // マスタのtableタグ
                var table = document.getElementById(masterName);
                // マスタのthタグの数
                var headerCount = table.getElementsByTagName('th').length;
                // Rowの挿入
                var newRow = table.insertRow(table.rows.length);
                //  thタグの数だけセルを生成
                for (let index = 0; index < headerCount; index++) {
                    newRow.insertCell(index).innerHTML = "<input type='text' placeholder='" + masterName + "'>";
                }
            }
        </script>
        HTML;

        return $code;
    }
}
