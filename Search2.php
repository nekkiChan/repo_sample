<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input要素の取得</title>
</head>

<body>

    <div id="exampleDiv">
        <input type="text" name="name" placeholder="名前">
        <input type="number" name="age" placeholder="年齢">
        <select name="sex">
            <option value="男">男</option>
            <option value="女">女</option>
        </select>
        <button onclick='getInput(this)'>ボタン</button>
    </div>

    <table id="create">
        <thead>
            <tr>
                <th>名前</th>
                <th>年齢</th>
                <th>性別</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        function getInput(element) {
            // 親DIV要素
            var divElement = element.parentElement;
            // input要素
            var inputElements = divElement.getElementsByTagName('input');
            // select要素
            var selectElements = divElement.getElementsByTagName('select');

            // input要素とselect要素を結合した配列
            var allElements = Array.from(inputElements).concat(Array.from(selectElements));

            // 取得した全ての要素をコンソールに表示（例として）
            allElements.forEach(function(element) {
                console.log(element.name);
                console.log(element.value);
            });
            createValue(allElements);
        }

        function createValue(arrayElement) {
            // 要素を作成するDIV
            var tableElement = document.getElementById('create');
            // body
            var headerElement = tableElement.querySelector('tbody');
            // row
            var rowbodyElement = document.createElement('tr');
            // 要素の追加
            tableElement.appendChild(headerElement);
            headerElement.appendChild(rowbodyElement);


            arrayElement.forEach(
                function(element) {
                    // body
                    var bodyElement = document.createElement('td');
                    // 要素の追加
                    rowbodyElement.appendChild(bodyElement);

                    // 新規要素
                    var new_element = document.createElement('div');
                    // 要素に属性を設定
                    // new_element.setAttribute('type', 'text');
                    // new_element.setAttribute('readonly', 'readonly');
                    new_element.setAttribute('name', element.name);
                    // new_element.setAttribute('value', element.value);
                    // 要素のテキストを設定
                    new_element.innerText = element.value;
                    // 要素の追加
                    bodyElement.appendChild(new_element);
                }
            );
        }
    </script>

    <style>
        #exampleDiv {
            margin: auto;
            width: 90%;
            display: flex;
        }

        #exampleDiv input,
        #exampleDiv select,
        #exampleDiv button {
            width: 25%;
        }

        table {
            margin: auto;
            width: 90vw;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            font-size: calc(1em + 1vw);
        }

        th {
            background-color: #333;
            color: #fff;
        }

        td {
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>

</body>

</html>