<?php
namespace app\views;

use app\views\View;

class RegisterView extends View
{
    public function generateRegisterForm()
    {
        echo $this->renderHeader();

        // バッファリングを開始
        ob_start();

        ?>
        <h1>Register</h1>
        <!-- レジスタボタンを押すとホーム画面へ -->
        <form action="<?php echo $this->router->generateUrl('register/create'); ?>" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Register">
        </form>


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
