<?php
namespace app\views;

use app\views\View;

class TestView extends View
{
    public function generateTestView($viewData)
    {
        session_start();
        echo $this->renderHeader();

        // バッファリングを開始
        ob_start();

        ?>
        <h1>テスト画面</h1>
        <!-- ボタンを押すとホーム画面へ -->
        <form method="post" action="<?php echo $this->router->generateUrl('test/upload/result'); ?>">
            <?php
            foreach ($viewData['users'] as $value) {
                foreach ($value as $k => $val) {
                    $data = $value[$k];
                    if ($k === 'id') { ?>
                        <input type="hidden" name="<?= $k ?>[]" value="<?= $data ?>">
                    <?php } else { ?>
                        <label for="<?= $k ?>[]">
                            <?= $k ?>
                        </label>
                        <input type="text" id="<?= $k ?>[]" name="<?= $k ?>[]" value=<?= $data ?>>
                        <?php
                    }
                }
                echo "<br>";
                ?>
                <?php
            }
            ?>

            <!-- 他のフォーム要素も同様に設定 -->
            <input type="submit" value="Submit">
        </form>

        <?php
        echo $this->renderFooter();

        $html = ob_get_clean();  // バッファの内容を取得してバッファリングを終了

        return $html;
    }

    public function generateImgBtnTestView($viewData)
    {
        session_start();
        echo $this->renderHeader();

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

        <h1>テスト画面</h1>
        <!-- ボタンを押すとホーム画面へ -->
        <form method="post" action="<?php echo $this->router->generateUrl('test/imgbtnResult'); ?>">

            <!-- 他のフォーム要素も同様に設定 -->
            <table>

                <thead>
                    <?php
                    // ヘッダー部分
                    echo '<tr>';
                    foreach ($viewData['users'][0] as $column => $value) {
                        echo "<th>$column</th>";
                    }
                    echo '<th>テスト用</th>';
                    echo '</tr>';
                    ?>
                </thead>
                <tbody>
                    <?php

                    // ボディ部分
                    foreach ($viewData['users'] as $val) {
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
        echo $this->renderFooter();

        $html = ob_get_clean();  // バッファの内容を取得してバッファリングを終了

        return $html;
    }

    public function generateCalenderTestView($viewData)
    {
        session_start();
        echo $this->renderHeader();

        // バッファリングを開始
        ob_start();

        ?>
        <h1>テスト画面</h1>
        <!-- ボタンを押すとホーム画面へ -->
        <form method="post" action="<?php echo $this->router->generateUrl('test/calendarResult'); ?>">
            <input type="submit" value="Submit">
        </form>

        <?php
        echo $this->renderFooter();

        $html = ob_get_clean();  // バッファの内容を取得してバッファリングを終了

        return $html;
    }

    public function showError($errorMessage)
    {
        echo '<p style="color:red;">' . $errorMessage . '</p>';
    }
}
?>