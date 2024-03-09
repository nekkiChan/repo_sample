<?php

namespace app\views\test;

use app\views\View;
use app\views\css\SearchAndTableCSS;
use app\views\js\test\SearchAndTableScript;

class SearchAndTableView extends View
{
    public function __construct()
    {
        parent::__construct();
        $this->css = new SearchAndTableCSS();
        $this->script = new SearchAndTableScript();
        echo $this->script->toggleValue();
    }
    public function getHTML($data)
    {
        parent::getHTML($data);
    }

    protected function renderContents($data = [])
    {
        // バッファリングを開始
        ob_start();
?>

        <h2><?= $data['title'] ?></h2>
        <!-- ボタンを押すとホーム画面へ -->
        <form method="post" action="<?php echo $this->router->generateUrl('test' . Directory_Separate . 'csv'); ?>">

            <!-- 検索欄 -->
            <div id="users-search">
                <input type="text" name="name" placeholder="名前">
                <input type="email" name="email" placeholder="メール">
                <button onclick='getInput(this);'>ボタン</button>
            </div>

            <div id='users-exsit' style="border: 2px solid black; margin: auto; width: 90vw;">
                <p>既存データ</p>
                <!-- 他のフォーム要素も同様に設定 -->
                <table id='users-exsit-table'>

                    <thead>
                        <?php
                        // ヘッダー部分
                        echo '<tr>';
                        foreach (reset($data['users']) as $column => $value) {
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
                                    <div name=<?= $column ?>>
                                        <?= $v ?>
                                    </div>
                                </td>
                            <?php
                            }
                            ?>
                            <td>
                                <img src="<?= HOME_URL . IMG_Path ?>trash.png" alt="テスト用画像" name="trash[]" value="false" onclick="toggleValue(this)">
                                <input type="hidden" name="trash[]" value="false">
                            </td>
                        <?php
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div id="users-create" style="border: 2px solid black; margin: 1em auto; width: 90vw;">
                <p>作成データ</p>
                <!-- 他のフォーム要素も同様に設定 -->
                <table id='users-create-table'>

                    <thead>
                        <?php
                        // ヘッダー部分
                        echo '<tr>';
                        foreach (reset($data['users']) as $column => $value) {
                            echo "<th>$column</th>";
                        }
                        echo '</tr>';
                        ?>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <input type="submit" value="Submit">
        </form>

<?php

        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }
}
