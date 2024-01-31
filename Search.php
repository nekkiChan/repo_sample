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

    <ul id="itemList">
        <?php foreach ($items as $key => $item) : ?>
            <div class="list-item" data-value='true'>
                <?php echo $item; ?>
            </div>
        <?php endforeach; ?>
    </ul>

    <!-- JavaScriptのみ -->
    <script>
        function search() {
            var query = document.getElementById('searchInput').value.toLowerCase();
            var items = document.getElementsByClassName('list-item');

            for (var i = 0; i < items.length; i++) {
                var itemText = items[i].innerText.toLowerCase();
                if (itemText.includes(query)) {
                    items[i].setAttribute('data-value', 'true');
                    items[i].style.display = 'block';
                } else {
                    items[i].setAttribute('data-value', 'false');
                    items[i].style.display = 'none';
                }
            }
        }
    </script>

</body>

</html>
