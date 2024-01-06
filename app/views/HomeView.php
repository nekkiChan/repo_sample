<?php
namespace app\views;

use app\views\View;

class HomeView extends View
{
    public function generateHomeView()
    {
        session_start();
        var_dump($_SESSION);

        // バッファリングを開始
        ob_start();

        ?>
        <h1>ホーム画面</h1>
        <!-- ボタンを押すとホーム画面へ -->
        <form method="post" action="<?php echo $this->router->generateUrl('login/logout'); ?>">
            <input type="submit" value="Logout">
        </form>

        <?php

        $html = ob_get_clean();  // バッファの内容を取得してバッファリングを終了

        return $html;
    }

    public function showError($errorMessage)
    {
        echo '<p style="color:red;">' . $errorMessage . '</p>';
    }
}
