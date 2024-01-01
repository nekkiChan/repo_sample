<?php

namespace util;

class Calendar
{
    private $currentMonth;
    private $currentYear;
    private $daysInMonth;
    private $firstDay;
    private $firstDayOfWeek;
    private $currentDay;
    private $route;

    public function __construct()
    {
        $this->route = new Router;
        $this->initialize();
    }

    private function initialize($selectedDate = null)
    {
        if ($selectedDate) {
            $dateTime = \DateTime::createFromFormat('Y-m-d', $selectedDate);

            if ($dateTime === false) {
                // エラー処理: 日付が無効な場合、デフォルトの日付で初期化するか、エラーメッセージを表示するなど
                // 以下はデフォルトの処理として、エラーメッセージを表示し、今日の日付で初期化する例です。
                echo 'Invalid date format. Using today\'s date instead.';
                $dateTime = new \DateTime();
            }

            $this->currentMonth = (int) $dateTime->format('n');
            $this->currentYear = (int) $dateTime->format('Y');
        } else {
            $this->currentMonth = date('n');
            $this->currentYear = date('Y');
        }

        $this->daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->currentMonth, $this->currentYear);
        $this->firstDay = mktime(0, 0, 0, $this->currentMonth, 1, $this->currentYear);
        $this->firstDayOfWeek = date('w', $this->firstDay);
        $this->currentDay = date('j');
    }

    private function generateHeaderCalendar($selectedDate, $type)
    {
        echo '<input type="hidden" name="date" value="' . $selectedDate . '">';
        echo '<button name="option" value="previous">前月へ</button>';
        echo '<button name="option" value="next">次月へ</button>';
        echo "<input type='hidden' name='calendarType' value=$type>";

        // echo '<h2>' . date('F Y', $this->firstDay) . '</h2>';
        echo '<table>';
        echo '<tr>';
        echo '<th>Sun</th>';
        echo '<th>Mon</th>';
        echo '<th>Tue</th>';
        echo '<th>Wed</th>';
        echo '<th>Thu</th>';
        echo '<th>Fri</th>';
        echo '<th>Sat</th>';
        echo '</tr>';

    }

    public function generateCalendar($selectedDate = null, $type = 'monthly')
    {
        $this->initialize($selectedDate);
        $this->generateHeaderCalendar($selectedDate, $type);

        if ($type === 'monthly') {
            $this->generateMonthlyCalendar();
        } elseif ($type === 'weekly') {
            $this->generateWeeklyCalendar();
        }

        echo '</table>';
    }

    private function generateMonthlyCalendar()
    {
        $dayCounter = 0;

        for ($i = 0; $i < 6; $i++) {
            echo '<tr>';
            for ($j = 0; $j < 7; $j++) {
                $this->generateTableCell($dayCounter, 'monthly');
                $dayCounter++;
            }
            echo '</tr>';
        }
    }

    private function generateWeeklyCalendar()
    {
        // 週間カレンダーの生成ロジックを追加
        echo '<tr>';
        for ($j = 0; $j < 7; $j++) {
            $this->generateTableCell($j, 'weekly');
        }
        echo '</tr>';
    }

    private function generateTableCell($index, $viewType)
    {
        // $dayCounterではなく、$indexを使用
        if ($viewType === 'monthly') {
            $dayCounter = $index + 1 - $this->firstDayOfWeek;
        } elseif ($viewType === 'weekly') {
            $dayCounter = $this->currentDay + $index - date('w', $this->firstDay);
        }

        if (($dayCounter >= 1) && ($dayCounter <= $this->daysInMonth)) {
            $day = $dayCounter;
            $dateString = "$this->currentYear-$this->currentMonth-$day";
            echo '<td><a href="' . $this->route->generateUrl('test/calendarResult') . '?date=' . $dateString . '">' . $day . '</a></td>';
        } else {
            echo '<td></td>';
        }
    }
}