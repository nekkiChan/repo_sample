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

    <style>
      /* ハンバーガーボタンのスタイル */
      #gnav-btn {
        color: gray;
        padding: 10px;
        font-size: 30px;
        position: fixed;
        top: 10px;
        right: 10px;
        z-index: 100;
        background-color: white;
        border: solid 1px #d1caca;
        border-radius: 3px;
      }

      /* ナビゲーションコンテンツのスタイル */
      #gnav-input:checked~#gnav-content {
        top: 0;
      }

      #gnav-content {
        position: fixed;
        top: -100%;
        left: 0;
        z-index: 10;
        transition: 0.3s;
        width: 100%;
      }

      /* メニュータイトルのスタイル */
      .humb-menu__title {
        padding: 1.5rem;
      }

      /* 各メニューアイテムラベルのスタイル */
      .humb-menu label {
        display: flex;
        justify-content: space-between;
        padding: 1.5rem;
        cursor: pointer;
        border-top: 0.5px solid #c7c5c5;
      }

      /* チェックボックス入力を非表示にするスタイル */
      .humb-menu input {
        display: none;
      }

      /* デフォルトで子コンテンツを非表示にするスタイル */
      .humb-menu .accshow {
        height: 0;
        overflow: hidden;
      }

      /* 子コンテンツの段落のスタイル */
      .humb-menu .accshow p {
        padding: 1.5rem;
      }

      /* チェックボックスがチェックされている場合に子コンテンツを表示するスタイル */
      .humb-menu .cssacc:checked+.accshow {
        height: auto;
      }
    </style>

    <div class="humb-menu">
      <input id="gnav-input" type="checkbox">
      <label for="gnav-input" id="gnav-btn">
        <div i class="fas fa-bars"></div>
      </label>

      <div id="gnav-content">
        <!-- タイトルを記載ください -->
        <div class="humb-menu__title">title</div>

        <label for="label1">
          <!-- 親要素の名前 -->
          <p>label</p>
          <p>＋</p>
        </label>
        <input type="checkbox" id="label1" class="cssacc" />
        <div class="accshow">
          <!-- 子要素の名前 -->
          <p>content</p>
          <p>content</p>
          <p>content</p>
          <p>content</p>
        </div>

        <label for="label2">
          <p>label</p>
          <p>＋</p>
        </label>
        <input type="checkbox" id="label2" class="cssacc" />
        <div class="accshow">
          <p>content</p>
          <p>content</p>
          <p>content</p>
          <p>content</p>
        </div>

        <label for="label3">
          <p>label</p>
          <p>＋</p>
        </label>
        <input type="checkbox" id="label3" class="cssacc" />
        <div class="accshow">
          <p>content</p>
          <p>content</p>
          <p>content</p>
          <p>content</p>
        </div>
      </div>
    </div>


    <!-- ボタンを押すとホーム画面へ -->
    <!-- <form method="post" action="<?php echo $this->router->generateUrl('login/logout'); ?>">
            <input type="submit" value="Logout">
        </form> -->

<?php

    return ob_get_clean(); // バッファの内容を取得してバッファリングを終了
  }
}
