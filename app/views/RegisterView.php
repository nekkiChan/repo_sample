<?php

namespace app\views;

use app\views\View;

class RegisterView extends View
{
    public function getHTML($data)
    {
        parent::getHTML($data);
    }

    public function renderContents($data = [])
    {

        // バッファリングを開始
        ob_start();

?>
        <h1>Register</h1>
        <!-- レジスタボタンを押すとホーム画面へ -->
        <form action="<?php echo $this->router->generateUrl('register/create'); ?>" method="post">
            <label for="name">name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Register">
        </form>


<?php

        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了

    }

    public function showError($errorMessage)
    {
        echo '<p style="color:red;">' . $errorMessage . '</p>';
    }
}
