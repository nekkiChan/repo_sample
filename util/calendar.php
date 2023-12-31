<?php

namespace util;

class Calendar
{
    private $currentMonth;
    private $currentYear;
    private $daysInMonth;
    private $firstDay;
    private $firstDayOfWeek;
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
    }

    public function generateCalendar($selectedDate = null)
    {
        $this->initialize($selectedDate);

        echo '<h2>' . date('F Y', $this->firstDay) . '</h2>';
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

        $dayCounter = 0;

        for ($i = 0; $i < 6; $i++) {
            echo '<tr>';
            for ($j = 0; $j < 7; $j++) {
                $this->generateTableCell($dayCounter);
                $dayCounter++;
            }
            echo '</tr>';
        }

        echo '</table>';
    }

    private function generateTableCell($dayCounter)
    {
        if (($dayCounter >= $this->firstDayOfWeek) && ($dayCounter - $this->firstDayOfWeek < $this->daysInMonth)) {
            $day = $dayCounter - $this->firstDayOfWeek + 1;
            $dateString = "$this->currentYear-$this->currentMonth-$day"; // YYYY-MM-DD 形式の文字列
            echo '<td><a href="' . $this->route->generateUrl('test/calendarResult') . '?date=' . $dateString . '">' . $day . '</a></td>';
        } else {
            echo '<td></td>';
        }
    }
}