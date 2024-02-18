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
    // var_dump($_SESSION);
    var_dump($_POST);
    var_dump($_GET);

?>
    <div>
      <?= $data['user']['username'] ?>
    </div>
    <div id="ajax-field">
      <div>
        <input type="text" class="id" name="id[]" placeholder="id">
      </div>
      <div>
        <input type="text" class="name" name="name[]" placeholder="name">
      </div>
      <div>
        <input type="text" class="age" name="age[]" placeholder="age">
      </div>
      <button class="ajax" value="ajax通信で取得する" onclick="ajax(this);">
        ajax通信で取得する
      </button>
    </div>
    <div class="result">
      ajax通信で取得する
    </div>

    <form action="<?= $this->router->generateUrl('home') ?>" method="get">
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
