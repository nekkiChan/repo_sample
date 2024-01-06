<?php
namespace app\views\test;

use app\views\View;

class ImgBtnView extends View
{
    public function getHTML($data)
    {
        parent::getHTML($data);
    }

    protected function renderContents($data = [])
    {
        // バッファリングを開始
        ob_start();
        ?>

        <style>
            table {
                width: 80vw;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th,
            td {
                padding: 10px;
                text-align: left;
                height: 50px;
            }

            th {
                background-color: #f2f2f2;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            td img {
                background-color: blue;
                max-width: 100%;
                max-height: 100%;
                width: auto;
                height: auto;
            }
        </style>

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

        <h2><?= $data['title'] ?></h2>
        <!-- ボタンを押すとホーム画面へ -->
        <form method="post" action="<?php echo $this->router->generateUrl('test/imgbtn'); ?>">

            <!-- 他のフォーム要素も同様に設定 -->
            <table>

                <thead>
                    <?php
                    // ヘッダー部分
                    echo '<tr>';
                    foreach ($data['users'][0] as $column => $value) {
                        echo "<th>$column</th>";
                    }
                    echo '<th>テスト用</th>';
                    echo '</tr>';
                    ?>
                </thead>
                <tbody>
                    <?php

                    // ボディ部分
                    foreach ($data['users'] as $val) {
                        echo '<tr>';
                        foreach ($val as $column => $v) {
                            ?>
                            <td>
                                <?= $v ?>
                            </td>
                            <?php
                        }
                        ?>
                        <td>
                            <img src="<?= HOME_URL . IMG_Path ?>trash.png" alt="テスト用画像" name="trash[]" value="false"
                                onclick="toggleValue(this)">
                            <input type="hidden" name="trash[]" value="false">
                        </td>
                        <?php
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>

            <input type="submit" value="Submit">
        </form>

        <?php

        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }
}