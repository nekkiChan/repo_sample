<?php
namespace app\views\test;

use app\views\View;

class TableView extends View
{
    private $value;
    public function __construct()
    {
        parent::__construct();
        // echo $this->script->addRow($this->value);
    }
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
            echo $this->script->addRow($contents);
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

        <form method="post" action="<?php echo $this->router->generateUrl('test/table', ['page' => $data['page']]); ?>">
            <input type="hidden" name="table" value="<?= $data['table'] ?>">

            <?php foreach ($getData as $key => $value): ?>
                <input type="hidden" name="page[<?= $key ?>]" value="<?= $value ?>">
            <?php endforeach; ?>

            <table id='<?php echo 'master-' . $data['table']; ?>'>
                <tr>
                    <?php foreach (reset($data['items'][$data['page'] - 1]) as $key => $value): ?>
                        <?php $header = $value; ?>
                        <?php if ($key === 'id'): ?>
                            <input type="hidden" name="<?= $key ?>[]" value="<?= $header ?>">
                        <?php else: ?>
                            <th>
                                <?= $key ?>
                            </th>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>

                <?php foreach ($data['items'][$data['page'] - 1] as $value): ?>
                    <tr>
                        <?php foreach ($value as $k => $val): ?>
                            <?php $cellValue = $val; ?>
                            <?php if ($k === 'id'): ?>
                                <input type="hidden" name="<?= $k ?>[]" value="<?= $cellValue ?>">
                            <?php else: ?>
                                <td>
                                    <input type="text" id="<?= $k ?>[]" name="<?= $k ?>[]" value="<?= $cellValue ?>">
                                </td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
            <!-- 他のフォーム要素も同様に設定 -->
            <input type="submit" value="Submit">
        </form>
        <button onclick="addRow('<?= $data['table'] ?>')">新しい行を追加</button>

        <?php
        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }
}