<?php
namespace app\views\test;

use app\views\css\CalendarCSS;
use app\views\View;

class CalendarView extends View
{
    public function getHTML($data)
    {
        parent::getHTML($data);
        $this->css = new CalendarCSS();
    }

    protected function renderContents($data = [])
    {

        // バッファリングを開始
        ob_start();
        ?>

        <h2>
            <?= $data['title'] ?>
        </h2>

        <!-- ボタンを押すとホーム画面へ -->
        <form method="post" id="yourFormId" action="<?= $this->router->generateUrl('test/calendar'); ?>">
            <div id="select">
                <?php echo $this->script->addDateSelects('yourFormId','select', new \DateTime($data['date'])); ?>
            </div>
            
            <div class="calendar">
                <?php
                echo $this->weeklyCalendar->generateCalendar(new \DateTime($data['date']), null, $data['type']);
                ?>
                <input type="submit" value="button">
            </div>

            <input type="submit" name="submit1" value="Submit">
        </form>

        <?php

        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }
}