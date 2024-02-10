<?php
// PHP側の連想配列
$content = [
    ['id' => 1, 'name' => 'taro', 'age' => 12],
    ['id' => 2, 'name' => 'jiro', 'age' => 14],
    ['id' => 3, 'name' => 'taro', 'age' => 12],
    ['id' => 4, 'name' => 'jiro', 'age' => 14],
    ['id' => 5, 'name' => 'taro', 'age' => 12],
    ['id' => 6, 'name' => 'jiro', 'age' => 14],
    ['id' => 7, 'name' => 'taro', 'age' => 12],
    ['id' => 8, 'name' => 'jiro', 'age' => 14],
    ['id' => 9, 'name' => 'taro', 'age' => 12],
    ['id' => 10, 'name' => 'jiro', 'age' => 14],
    ['id' => 11, 'name' => 'taro', 'age' => 12],
    ['id' => 12, 'name' => 'jiro', 'age' => 14],
    ['id' => 13, 'name' => 'taro', 'age' => 12],
    ['id' => 14, 'name' => 'jiro', 'age' => 14],
    ['id' => 15, 'name' => 'taro', 'age' => 12],
    ['id' => 16, 'name' => 'jiro', 'age' => 14],
    ['id' => 17, 'name' => 'taro', 'age' => 12],
    ['id' => 18, 'name' => 'jiro', 'age' => 14],
    ['id' => 19, 'name' => 'taro', 'age' => 12],
    ['id' => 20, 'name' => 'jiro', 'age' => 14],
    ['id' => 21, 'name' => 'taro', 'age' => 12],
    ['id' => 22, 'name' => 'jiro', 'age' => 14],
    ['id' => 23, 'name' => 'taro', 'age' => 12],
    ['id' => 24, 'name' => 'jiro', 'age' => 14],
    ['id' => 25, 'name' => 'taro', 'age' => 12],
    ['id' => 26, 'name' => 'jiro', 'age' => 14],
    ['id' => 27, 'name' => 'taro', 'age' => 12],
    ['id' => 28, 'name' => 'jiro', 'age' => 14],
    ['id' => 29, 'name' => 'taro', 'age' => 12],
    ['id' => 30, 'name' => 'jiro', 'age' => 14],
];

// PHPの連想配列をJSON文字列に変換
$json_content = json_encode($content);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajaxフォーム</title>
    <script>
        var contents = <?php echo $json_content; ?>;
        var currentPage = 0;
        var itemsPerPage = 10;

        function submitTable() {
            var outputElement = document.querySelector('#table .field');

            // 連想配列の取得
            if (!outputElement.querySelector('table.insert-content')) {
                generateTable(Object.keys(contents[0]));
            }
            generateTbody(contents);

            function generateTable(keysArray) {
                // 新規table
                var tableElement = document.createElement("table");
                tableElement.className = 'insert-content';
                // rowの追加
                var theadElement = document.createElement("thead");
                var tbodyElement = document.createElement("tbody");
                var theadRowElement = document.createElement("tr");

                // tableの挿入
                outputElement.appendChild(tableElement);
                tableElement.appendChild(theadElement);
                tableElement.appendChild(tbodyElement);
                theadElement.appendChild(theadRowElement);

                // headerの挿入
                keysArray.map(key => {
                    // 要素の追加
                    var thElement = document.createElement("th");
                    var divElement = document.createElement("div");
                    // テキストの追加
                    var textElement = document.createTextNode(key);
                    // 要素の挿入
                    theadRowElement.appendChild(thElement);
                    thElement.appendChild(divElement);
                    divElement.appendChild(textElement);
                });
            }

            function generateTbody(contents) {
                var tbodyElement = outputElement.querySelector('tbody');
                tbodyElement.innerHTML = ''; // Clear existing tbody content
                var startIndex = currentPage * itemsPerPage;
                var endIndex = (currentPage + 1) * itemsPerPage;
                contents.slice(startIndex, endIndex).forEach(content => {
                    var tbodyRowElement = document.createElement("tr");
                    Object.keys(content).forEach(key => {
                        // 要素の追加
                        var tdElement = document.createElement("td");
                        tdElement.className = key;
                        var divElement = document.createElement("div");
                        divElement.setAttribute('name', key + '[]');
                        divElement.setAttribute('value', content[key]);
                        // テキストの追加
                        var textElement = document.createTextNode(content[key]);
                        // 要素の挿入
                        tbodyRowElement.appendChild(tdElement);
                        tdElement.appendChild(divElement);
                        divElement.appendChild(textElement);
                    });
                    tbodyElement.appendChild(tbodyRowElement);
                });
            }
        }

        function nextPage() {
            var totalPages = Math.ceil(contents.length / itemsPerPage); // 総ページ数を計算
            if (currentPage < totalPages - 1) { // 現在のページが最後のページでない場合にのみ処理を実行
                currentPage++;
                submitTable();
            }
        }

        function prevPage() {
            if (currentPage > 0) {
                currentPage--;
                submitTable();
            }
        }

        function submitForm(element) {
            var formElement = element.closest('form');
            var inputElement = formElement.querySelector('input');
            var outputElement = document.getElementById('output');

            if (document.querySelector('div.insert-content')) {
                // 既存データ
                var existDivElement = Array.from(outputElement.querySelectorAll('div.insert-content'));
                console.log(existDivElement);
                is_exsit = existDivElement.some(element => {
                    if (inputElement.value === element.getAttribute('value')) {
                        return true;
                    } else {
                        return false;
                    }
                });
                if (!is_exsit) {
                    // データ挿入
                    insertElement(inputElement);
                }
            } else {
                // データ挿入
                insertElement(inputElement);
            }

            function insertElement(inputElement) {
                // 新規div
                var divElement = document.createElement("div");
                divElement.className = 'insert-content';
                divElement.setAttribute('name', inputElement.name);
                divElement.setAttribute('value', inputElement.value);
                var textElement = document.createTextNode(inputElement.value);

                // データ挿入
                divElement.appendChild(textElement);
                outputElement.appendChild(divElement);
            }
        }
    </script>
</head>

<body>

    <div id="table" onclick="submitTable();">
        <h2>表の生成</h2>
        <button onclick="prevPage()">前へ</button>
        <button onclick="nextPage()">次へ</button>
        <div class="field">
        </div>
    </div>

    <div id="result">
        <h2>フォームを送信して結果を表示する</h2>
        <form id="myForm" method="post">
            <input type="text" name="name">
            <!-- <select name="sex">
                <option value="男">男</option>
                <option value="女">女</option>
            </select> -->
            <button type="button" onclick="submitForm(this)">送信</button>
        </form>
    </div>

    <div id="output">
    </div>

</body>

</html>