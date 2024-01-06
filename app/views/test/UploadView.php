<?php
namespace app\views\test;

use app\views\View;

class UploadView extends View
{
    public function getHTML($data)
    {
        parent::getHTML($data);
    }

    protected function renderContents($data = [])
    {
        // バッファリングを開始
        ob_start();

        if (isset($_SESSION['message'])) {
            foreach ($_SESSION['message'] as $value) {
                echo $value;
            }
        }

        foreach ($data['contents'] as $contentName => $contents) {
            echo $this->goPage($contentName, $data['contents']);
            echo $this->generateTable($contents);
        }

        ?>

        <?php

        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }

    protected function goPage($contentName, $data)
    {
        // print_r($contentName . 'テーブルの' . $data[$contentName]['page'] . 'ページ目');
        // バッファリングを開始
        ob_start();

        $getData = array();
        foreach ($data as $key => $value) {
            $getData[$key] = $value['page'];
        }

        ?>

        <div class="page">
            <input type="text" name="page" value="">

            <?php if ($data[$contentName]['page'] > 1): ?>
                <div>
                    <a href="<?php
                    $getData[$contentName] = $getData[$contentName] - 1;
                    echo $this->router->generateUrl(
                        'test/upload',
                        $getData
                    );
                    $getData[$contentName] = $getData[$contentName] + 1;
                    ?>">
                        前へ
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($data[$contentName]['page'] < count($data[$contentName]['items'])): ?>
                <div>
                    <a href="<?php
                    $getData[$contentName] = $getData[$contentName] + 1;
                    echo $this->router->generateUrl(
                        'test/upload',
                        $getData
                    );
                    $getData[$contentName] = $getData[$contentName] - 1;
                    ?>">次へ</a>
                </div>
            <?php endif; ?>
        </div>

        <?php

        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }

    protected function generateTable($data)
    {
        // バッファリングを開始
        ob_start();
        ?>

        <h2>
            <?= $data['title'] ?>
        </h2>

        <form method="post" action="<?php echo $this->router->generateUrl('test/upload', ['page' => $data['page']]); ?>">
            <?php
            foreach ($data['items'][$data['page'] - 1] as $value) {
                foreach ($value as $k => $val) {
                    $data = $val;
                    if ($k === 'id') { ?>
                        <input type="hidden" name="<?= $k ?>[]" value="<?= $data ?>">
                    <?php } else { ?>
                        <label for="<?= $k ?>[]">
                            <?= $k ?>
                        </label>
                        <input type="text" id="<?= $k ?>[]" name="<?= $k ?>[]" value="<?= $data ?>">
                        <?php
                    }
                }
                echo "<br>";
            }
            ?>

            <!-- 他のフォーム要素も同様に設定 -->
            <input type="submit" value="Submit">
        </form>

        <?php
        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }
}