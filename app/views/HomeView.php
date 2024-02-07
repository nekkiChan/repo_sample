<?php

namespace app\views;

use app\views\View;

class HomeView extends View
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getHTML($data)
  {
    parent::getHTML($data);
  }

  public function renderContents($data)
  {
    session_start();
    // var_dump($_SESSION);

?>

    <?php

    $param = $this->db->getDataBySearch(['username' => $_GET['name'], 'email' => $_GET['email']], 'users');
    var_dump($param);
    ?>

    <form action="<?= $this->router->generateUrl('home') ?>" method="get">
      <input type="text" name="name" value="">
      <input type="text" name="email" value="">
      <button type="submit">ボタン</button>
    </form>


    <!-- ボタンを押すとホーム画面へ -->
    <!-- <form method="post" action="<?php echo $this->router->generateUrl('login/logout'); ?>">
            <input type="submit" value="Logout">
        </form> -->

<?php

    return ob_get_clean(); // バッファの内容を取得してバッファリングを終了
  }
}
