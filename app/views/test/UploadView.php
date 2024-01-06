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
        ?>
        <h1>アップロードテスト画面</h1>

        <div>
            <input type="text" name="page" value="">

            <?php if ($data['page'] > 0): ?>
                <a href="<?php echo $this->router->generateUrl('test/upload', ['page' => $data['page'] - 1]); ?>">前へ</a>
            <?php endif; ?>

            <?php if ($data['page'] < count($data['items'])): ?>
                <a href="<?php echo $this->router->generateUrl('test/upload', ['page' => $data['page'] + 1]); ?>">次へ</a>
            <?php endif; ?>
        </div>

        <form method="post" action="<?php echo $this->router->generateUrl('test/upload', ['page' => $data['page']]); ?>">
            <?php
            foreach ($data['items'] as $value) {
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