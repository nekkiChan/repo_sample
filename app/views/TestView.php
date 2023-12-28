<?php
namespace app\views;

use app\views\View;

class TestView extends View
{
    public function generateTestView($viewData)
    {
        session_start();
        var_dump($_SESSION);
        echo $this->renderHeader();

        // バッファリングを開始
        ob_start();

        ?>
        <h1>テスト画面</h1>
        <!-- ボタンを押すとホーム画面へ -->
        <form method="post" action="<?php echo $this->router->generateUrl('test/upload/result'); ?>">
            <?php
            $columns = ['id', 'name', 'age'];

            foreach ($viewData['data'] as $key => $value) {
                $id = $value['id'];
                $name = $value['name'];
                $age = $value['age'];
                ?>

                <input type="hidden" name="<?php echo $columns[0]; ?>" value="<?php echo $id; ?>">

                <label for="name_<?php echo $id; ?>">
                    <?php echo $columns[1]; ?>
                </label>
                <input type="text" id="name_<?php echo $id; ?>" name="name_<?php echo $id; ?>" value="<?php echo $name; ?>">
                <input type="hidden" name="name_<?php echo $id; ?>_original" value="<?php echo $name; ?>">

                <label for="age_<?php echo $id; ?>">
                    <?php echo $columns[2]; ?>
                </label>
                <input type="text" id="age_<?php echo $id; ?>" name="age_<?php echo $id; ?>" value="<?php echo $age; ?>">
                <input type="hidden" name="age_<?php echo $id; ?>_original" value="<?php echo $age; ?>">
                <br><br>
                <?php
            }
            ?>

            <!-- 他のフォーム要素も同様に設定 -->

            <input type="submit" value="Submit">
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                console.log('DOMが読み込まれました。');
                var inputs = document.querySelectorAll('input[type="text"]');
                inputs.forEach(function (input) {
                    var originalValue = input.value;
                    var correspondingHiddenInput = input.parentElement.querySelector('input[name="' + input.name + '_original"]');
                    input.addEventListener('input', function () {
                        correspondingHiddenInput.value = originalValue; // 隠し要素の値を更新
                    });
                });
            });
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