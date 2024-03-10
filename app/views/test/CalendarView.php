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
        // クエリパラメータ "date" の取得
        $dateQueryParam = $_GET['date'] ?? date('Y-m-d');
        $selectedDate = new \DateTime($dateQueryParam);
        echo $selectedDate->format('Y-m-d');

        // バッファリングを開始
        ob_start();
        ?>

        <h2>
            <?= $data['title'] ?>
        </h2>

        <!-- ボタンを押すとホーム画面へ -->
            
            <div class="calendar">
                <?= $this->weeklyCalendar->generateCalendar($selectedDate, null, 'monthly');?>
            </div>

            <div class="calendar">
                <?= $this->weeklyCalendar->generateCalendar($selectedDate, null, 'weekly');?>
            </div>

        <?php

        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }
}
?>
