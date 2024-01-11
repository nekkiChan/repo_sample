<?php
namespace app\views\js;

use \app\models\LogModel;
use app\models\util\Calendar;

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

    public function addDateSelects($formId)
    {
        // 現在の年月日を取得
        $currentYear = date('Y');
        $currentMonth = date('n');
        $currentDay = date('j');

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

        // phpメソッドテスト
        $phpModel = new Calendar();
        $phpMethod = $phpModel->generateCalendar(new \DateTime(date('Y-m-d')), null, 'monthly');
        // JavaScriptコード生成
        $escapedPhpMethod = json_encode($phpMethod, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS);


        // JavaScriptコード生成
        $code = <<<HTML
        <script>
            var phpMethod = $escapedPhpMethod;

            document.addEventListener('DOMContentLoaded', function() {
                addDateSelects('$formId');
            });

            // JavaScriptで年月日のセレクトボックスを追加するメソッド
            function addDateSelects(formId) {
                // フォームの要素を取得
                var form = document.getElementById(formId);
    
                // 年のセレクトボックスを生成
                var yearSelect = document.createElement('div');
                yearSelect.innerHTML = '$yearSelect';
                form.appendChild(yearSelect);
    
                // 月のセレクトボックスを生成
                var monthSelect = document.createElement('div');
                monthSelect.innerHTML = '$monthSelect';
                form.appendChild(monthSelect);
    
                // 日のセレクトボックスを生成
                var daySelect = document.createElement('div');
                daySelect.innerHTML = '$daySelect';
                form.appendChild(daySelect);

                // デバッグ用のテキストボックスに年、月、日を表示
                var yearTextBox = document.createElement('input');
                yearTextBox.type = 'text';
                yearTextBox.id = 'yearTextBox';
                yearTextBox.name = 'year';
                yearTextBox.value = '$currentYear';
                form.appendChild(yearTextBox);

                var monthTextBox = document.createElement('input');
                monthTextBox.type = 'text';
                monthTextBox.id = 'monthTextBox';
                monthTextBox.name = 'month';
                monthTextBox.value = '$currentMonth';
                form.appendChild(monthTextBox);

                var dayTextBox = document.createElement('input');
                dayTextBox.type = 'text';
                dayTextBox.id = 'dayTextBox';
                dayTextBox.name = 'day';
                dayTextBox.value = '$currentDay';
                form.appendChild(dayTextBox);

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

                var phpTest = document.createElement('div');
                // 日のセレクトボックスが変更されたときにテキストボックスに値を表示
                function updateTextBoxes() {
                    phpTest.innerHTML = phpMethod;
                    form.appendChild(phpTest);

                    var selectedYear = parseInt(yearSelect.querySelector('select').value);
                    var selectedMonth = parseInt(monthSelect.querySelector('select').value) + 1;
                    var selectedDay = parseInt(daySelect.querySelector('select').value);

                    yearTextBox.value = selectedYear;
                    monthTextBox.value = selectedMonth;
                    dayTextBox.value = selectedDay;
                }
            }
        </script>
    HTML;

        return $code;
    }

}
