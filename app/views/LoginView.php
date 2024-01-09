<?php
namespace app\views;

use app\views\View;

class LoginView extends View
{
    public function getHTML($data){
        parent::getHTML($data);
    }

    public function renderContents($data = [])
    {

        // バッファリングを開始
        ob_start();

        ?>
        <h1>Login</h1>
        <!-- ログインボタンを押すとホーム画面へ -->
        <form method="post" action="<?php echo $this->router->generateUrl('login/auth'); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Login">
        </form>

        <?php

        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }

    public function showError($errorMessage)
    {
        echo '<p style="color:red;">' . $errorMessage . '</p>';
    }
}
