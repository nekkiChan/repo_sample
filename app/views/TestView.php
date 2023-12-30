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

        <script>
            // document.addEventListener('DOMContentLoaded', function () {
            //     console.log('DOMが読み込まれました。');
            //     var inputs = document.querySelectorAll('input[type="text"]');
            //     inputs.forEach(function (input) {
            //         var originalValue = input.value;
            //         var correspondingHiddenInput = input.parentElement.querySelector('input[name="' + input.name + '_original"]');
            //         input.addEventListener('input', function () {
            //             correspondingHiddenInput.value = originalValue; // 隠し要素の値を更新
            //         });
            //     });
            // });
        </script>

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