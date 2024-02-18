<?php

namespace app\views\js;

header("Access-Control-Allow-Origin: *");

use \app\models\LogModel;

class Script
{
    protected $logModel;

    public function __construct()
    {
        // ログ
        $this->logModel = new LogModel();
        // 基本スクリプト導入
        echo $this->getBasicScript();
    }

    protected function getBasicScript()
    {

        ob_start();
?>
        <script>
            function convertAllInputElements(element){
                let inputElements = element.closest('div').querySelectorAll('input');

                console.log(inputElements);
                let objects = {}
                Array.from(inputElements).map(element => {
                    objects[element.getAttribute('class')] = element.value;
                });

                return objects;
            }

            function ajax(element) {

                let objects = convertAllInputElements(element);

                var xhr = new XMLHttpRequest(); // XMLHttpRequestオブジェクトを作成
                var jsonData = JSON.stringify(objects);

                // リクエストを準備
                // xhr.open('GET', 'ajax?ajax-data[name]=taro', true);
                xhr.open('POST', 'ajax', true);
                xhr.setRequestHeader('Content-Type', 'application/json'); // POSTリクエストの場合はContent-Typeを設定する

                // リクエストが完了した際の処理
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 300) { // HTTPステータスコードが成功を示す場合
                        // 通信成功時の処理
                        // alert('通信成功！');
                        // document.querySelector('html').innerHTML = xhr.responseText; // 取得したHTMLを.resultに反映
                    } else {
                        // 通信失敗時の処理
                        alert('通信失敗！');
                    }
                };

                // リクエストがエラーで終了した場合の処理
                xhr.onerror = function() {
                    // 通信失敗時の処理
                    alert('通信失敗！');
                };

                // リクエストを送信
                xhr.send(jsonData);
            }
        </script>
<?php
        return ob_get_clean();
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

    public function addRow($contents)
    {
        $master = $contents['table'];
        $code = <<<HTML
        <script>
            var master = '$master';
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

    public function addDateSelects($formId, $parentId, $date)
    {
        // 現在の年月日を取得
        $currentYear = $date->format('Y');
        $currentMonth = $date->format('n');
        $currentDay = $date->format('j');

        // 年のセレクトボックス生成
        $yearSelect = '<select name="year">';
        for ($year = $currentYear + 10; $year >= $currentYear - 10; $year--) {
            $selected = ($year == $currentYear) ? 'selected' : '';
            $yearSelect .= '<option value="' . $year . '" ' . $selected . '>' . $year . '</option>';
        }
        $yearSelect .= '</select>';

        // 月のセレクトボックス生成
        $monthSelect = '<select name="month">';
        for ($month = 1; $month <= 12; $month++) {
            $selected = ($month == $currentMonth) ? 'selected' : '';
            $monthSelect .= '<option value="' . $month . '" ' . $selected . '>' . $month . '</option>';
        }
        $monthSelect .= '</select>';

        // 日のセレクトボックス生成
        $daySelect = '<select name="day"></select>';

        // JavaScriptコード生成
        $code = <<<HTML
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                addDateSelects('$formId', '$parentId');
            });

            /**
             * JavaScriptで年月日のセレクトボックスを追加するメソッド
             */
            function addDateSelects(formId, parentId) {
                // フォームの要素を取得
                var form = document.getElementById(parentId);

                // 親要素を作成
                var selectField = document.createElement('div');
                // selectField.style.backgroundColor = "red";
                selectField.style.display = "flex";
                form.appendChild(selectField);

                // 年のセレクトボックスを生成
                var yearSelect = document.createElement('div');
                yearSelect.innerHTML = '$yearSelect';
                selectField.appendChild(yearSelect);

                // 月のセレクトボックスを生成
                var monthSelect = document.createElement('div');
                monthSelect.innerHTML = '$monthSelect';
                selectField.appendChild(monthSelect);

                // 日のセレクトボックスを生成
                var daySelect = document.createElement('div');
                daySelect.innerHTML = '$daySelect';
                selectField.appendChild(daySelect);

                // デバッグ用のテキストボックスに年、月、日を表示
                var hiddenBox = document.createElement('input');
                hiddenBox.type = 'hidden';
                hiddenBox.id = 'dateBox';
                hiddenBox.name = '_date';
                hiddenBox.value = '$currentYear' + '-' + '$currentMonth' + '-' + '$currentDay';
                form.appendChild(hiddenBox);

                yearSelect.querySelector('select').addEventListener('change', updateTextBoxes);
                monthSelect.querySelector('select').addEventListener('change', updateTextBoxes);
                daySelect.querySelector('select').addEventListener('change', updateTextBoxes);


                // 年月が変更されたら日のセレクトボックスを更新
                yearSelect.querySelector('select').addEventListener('change', updateDays);
                monthSelect.querySelector('select').addEventListener('change', updateDays);

                // 初回実行
                updateDays();

                // 日のセレクトボックスを更新する関数
                function updateDays() {
                    var selectedYear = parseInt(yearSelect.querySelector('select').value);
                    var selectedMonth = parseInt(monthSelect.querySelector('select').value);
                    var lastDay = new Date(selectedYear, selectedMonth, 0).getDate();

                    var daySelectElement = daySelect.querySelector('select');
                    daySelectElement.innerHTML = ''; // 日のセレクトボックスをクリア

                    // 日のセレクトボックスを生成
                    for (var day = 1; day <= lastDay; day++) { // 最終日までループ
                        var option = document.createElement('option');
                        option.value = day;
                        option.textContent = day;
                        daySelectElement.appendChild(option);
                    }

                    // 初期値を設定
                    daySelectElement.value = $currentDay;
                }

                /**
                 * セレクトボックスが変更されたときにinputに値を与えてform送信
                 */
                function updateTextBoxes() {

                    var selectedYear = parseInt(yearSelect.querySelector('select').value);
                    var selectedMonth = parseInt(monthSelect.querySelector('select').value);
                    var selectedDay = parseInt(daySelect.querySelector('select').value);

                    hiddenBox.value = selectedYear + '-' + selectedMonth + '-' + selectedDay;

                    document.getElementById(formId).submit();
                }
            }
        </script>
    HTML;

        return $code;
    }
}
