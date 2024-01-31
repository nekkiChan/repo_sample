<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
</head>

<body>
    <?php

    $items = [
        'タロウ',
        'Item2',
        '次郎',
        '太郎',
        'Mark2'
    ];

    ?>
    <!-- 検索フォームとリスト表示 -->
    <input type="text" id="searchInput" placeholder="検索...">
    <button onclick="search()">検索</button>

    <table id="itemList">
        <thead>
            <tr>
                <th class='id'>
                    <div>
                        <?= 'id' ?>
                    </div>
                </th>
                <th class='name'>
                    <div>
                        <?= 'name' ?>
                    </div>
                </th>
                <th class='event'>
                    <div>
                        <?= 'click!' ?>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $key => $item) : ?>
                <tr class="list-item" data-value='true'>
                    <td class='id'>
                        <div>
                            <?php echo $key; ?>
                        </div>
                    </td>
                    <td class='name'>
                        <div>
                            <?php echo $item; ?>
                        </div>
                    </td>
                    <td class='event'>
                        <div>
                            <button onclick="addToOutput(this)">Click</button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table id='output' style='margin-top: 1em;'>
        <thead>
            <tr>
                <th class='id'>
                    <div>
                        <?= 'id' ?>
                    </div>
                </th>
                <th class='name'>
                    <div>
                        <?= 'name' ?>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <!-- Output Table Body -->
        </tbody>
    </table>

    <script>
        // 初回クリック時にフォームを生成するためのフラグ
        var formCreated = false;

        function search() {
            var query = document.getElementById('searchInput').value.toLowerCase();
            var rows = document.querySelectorAll('#itemList tbody tr');

            rows.forEach(function(row) {
                var nameText = row.querySelector('.name div').innerText.toLowerCase();

                if (nameText.includes(query)) {
                    row.setAttribute('data-value', 'true');
                    row.style.display = 'table-row';
                } else {
                    row.setAttribute('data-value', 'false');
                    row.style.display = 'none';
                }
            });
        }

        function isAlreadyAdded(id) {
            var outputTable = document.getElementById('output').getElementsByTagName('tbody')[0];
            var rows = outputTable.getElementsByTagName('tr');

            for (var i = 0; i < rows.length; i++) {
                var existingId = rows[i].getAttribute('data-id');
                if (existingId === id) {
                    return true; // 既に存在する場合はtrueを返す
                }
            }
            return false; // 存在しない場合はfalseを返す
        }

        function addToOutput(button) {
            var row = button.closest('tr');
            var idElement = row.querySelector('.id div');
            var nameElement = row.querySelector('.name div');

            if (idElement && nameElement) {
                var id = idElement.innerText;
                var name = nameElement.innerText;

                if (!isAlreadyAdded(id)) {
                    var outputTable = document.getElementById('output').getElementsByTagName('tbody')[0];
                    var newRow = outputTable.insertRow(outputTable.rows.length);

                    newRow.setAttribute('data-id', id); // 新たに追加する行に data-id 属性を設定

                    var cell1 = newRow.insertCell(0);
                    cell1.innerHTML = id;
                    cell1.setAttribute('name', 'outputId[]'); // name属性を設定

                    var cell2 = newRow.insertCell(1);
                    cell2.innerHTML = name;
                    cell2.setAttribute('name', 'outputName[]'); // name属性を設定

                    // フォームデータにも追加
                    if (!formCreated) {
                        createForm();
                    }
                    appendHiddenField('outputId[]', id);
                    appendHiddenField('outputName[]', name);
                } else {
                    console.log('Already added:', id); // デバッグ情報
                }
            }
        }

        function createForm() {
            var outputForm = document.createElement('form');
            outputForm.id = 'outputForm';
            outputForm.method = 'post';
            outputForm.action = 'your_server_script.php';
            document.body.appendChild(outputForm);
            formCreated = true;
        }

        function appendHiddenField(name, value) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;

            var outputForm = document.getElementById('outputForm');
            if (outputForm) {
                outputForm.appendChild(input);
            }
        }
    </script>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
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