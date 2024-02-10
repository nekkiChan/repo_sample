<?php

namespace app\views\test;

use app\views\View;
// use app\views\css\AjaxCSS;

class AjaxView extends View
{
    public function __construct()
    {
        parent::__construct();
        // $this->css = new AjaxCSS();
    }
    public function getHTML($data)
    {
        parent::getHTML($data);
    }

    protected function renderContents($data = [])
    {
        // バッファリングを開始
        ob_start();
?>

        <div id="result">
            <h2>フォームを送信して結果を表示する</h2>
            <form id="myForm" method="post">
                <input type="text" name="data" id="data">
                <button type="button" onclick="submitForm()">送信</button>
            </form>
        </div>

        <div>
            <div>
                <?= var_dump($_POST) ?>
            </div>
        </div>

<?php

        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }
}
