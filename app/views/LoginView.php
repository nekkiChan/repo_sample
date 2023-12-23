<?php
namespace app\views;

use app\views\View;

class LoginView extends View
{
    public function generateLoginForm()
    {
        // バッファリングを開始
        ob_start();

        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Login</title>
        </head>

        <body>
            <h2>Login</h2>
            <!-- ログインボタンを押すとホーム画面へ -->
            <form method="post" action="<?php echo $this->router->generateUrl('home'); ?>">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>

                <input type="submit" value="Login">
            </form>
        </body>

        </html>
        <?php

        $html = ob_get_clean();  // バッファの内容を取得してバッファリングを終了
        return $html;
    }

    public function showError($errorMessage)
    {
        echo '<p style="color:red;">' . $errorMessage . '</p>';
    }
}
