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

        $getData = array();
        foreach ($data['contents'] as $key => $value) {
            $getData[$key] = $value['page'];
        }
        foreach ($data['contents'] as $contents) {
            echo $this->goPage($contents, $getData);
            echo $this->generateTable($contents, $getData);
        }

        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }

    protected function goPage($contents, $getData)
    {
        // バッファリングを開始
        ob_start();
        ?>

        <div class="page">
            <input type="text" name="page" value="">

            <?php if ($contents['page'] > 1): ?>
                <div>
                    <a href="<?php
                    $getData[$contents['table']] = $contents['page'] - 1;
                    echo $this->router->generateUrl(
                        'test/upload',
                        $getData
                    );
                    $getData[$contents['table']] = $getData[$contents['table']] + 1;
                    ?>">
                        前へ
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($contents['page'] < count($contents['items'])): ?>
                <div>
                    <a href="<?php
                    $getData[$contents['table']] = $contents['page'] + 1;
                    echo $this->router->generateUrl(
                        'test/upload',
                        $getData
                    );
                    $getData[$contents['table']] = $getData[$contents['table']] - 1;
                    ?>">次へ</a>
                </div>
            <?php endif; ?>
        </div>

        <?php

        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }

    protected function generateTable($data, $getData)
    {
        // バッファリングを開始
        ob_start();
        ?>

        <h2>
            <?= $data['title'] ?>
        </h2>

        <form method="post" action="<?php echo $this->router->generateUrl('test/upload', ['page' => $data['page']]); ?>">
        <input type="hidden" name="table" value="<?= $data['table'] ?>">

            <?php foreach ($getData as $key => $value): ?>
                <input type="hidden" name="page[<?= $key ?>]" value="<?= $value ?>">
            <?php endforeach; ?>

            <?php foreach ($data['items'][$data['page'] - 1] as $value): ?>
                <?php foreach ($value as $k => $val): ?>
                    <?php $data = $val; ?>
                    <?php if ($k === 'id'): ?>
                        <input type="hidden" name="<?= $k ?>[]" value="<?= $data ?>">
                    <?php else: ?>
                        <label for="<?= $k ?>[]">
                            <?= $k ?>
                        </label>
                        <input type="text" id="<?= $k ?>[]" name="<?= $k ?>[]" value="<?= $data ?>">
                    <?php endif; ?>
                <?php endforeach; ?>
                <?= "<br>" ?>
            <?php endforeach; ?>

            <!-- 他のフォーム要素も同様に設定 -->
            <input type="submit" value="Submit">
        </form>

        <?php
        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }
}