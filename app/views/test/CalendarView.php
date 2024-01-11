<?php
namespace app\views\test;

use app\views\View;

class CalendarView extends View
{
    public function getHTML($data)
    {
        parent::getHTML($data);
    }

    protected function renderContents($data = [])
    {

        // バッファリングを開始
        ob_start();

        ?>

        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }

            .calendar {
                max-width: 600px;
                margin: 20px auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                padding: 10px;
                text-align: center;
            }

            th {
                background-color: #333;
                color: #fff;
            }

            td {
                border: 1px solid #ddd;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
        </style>

        <h2>
            <?= $data['title'] ?>
        </h2>

        <!-- ボタンを押すとホーム画面へ -->
        <form method="post" action="<?= $this->router->generateUrl('test/calendar'); ?>">
            <div class="calendar">
                <?php
                echo $this->weeklyCalendar->generateCalendar(new \DateTime($data['date']), null, $data['type']);
                ?>
            </div>
            <input type="text" name="" id="" onclick="addDateSelects(this)">

            <input type="submit" value="Submit">
        </form>

        <form method="post" id="yourFormId" action="<?= $this->router->generateUrl('test/calendar'); ?>">
            <!-- 他のフォーム要素やコンテンツがここに入るかもしれません。 -->
            <!-- 生成したJavaScriptコードを出力 -->
            <?php echo $this->script->addDateSelects('yourFormId'); ?>
            <button type="submit">botan</button>
        </form>

        <?php

        return ob_get_clean();  // バッファの内容を取得してバッファリングを終了
    }
}