<?php
namespace util;

class WeeklyCalendar
{
    private $startDate;

    public function __construct()
    {
        // 今日の日付を取得
        $this->startDate = new \DateTime();
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

    private static function getDayCountOfWeek($startWeek)
    {
        $dayOfWeekMap = [
            0 => 'Sun',
            1 => 'Mon',
            2 => 'Tue',
            3 => 'Wed',
            4 => 'Thu',
            5 => 'Fri',
            6 => 'Sat',
        ];

        $count = array_search($startWeek, $dayOfWeekMap);
        for ($i = 0; $i < $count; $i++) {
            $shiftDay = array_shift($dayOfWeekMap);
            array_push($dayOfWeekMap, $shiftDay);
        }

        // print_r($dayOfWeekMap);

        return $dayOfWeekMap;
    }

    public function generateCalendar(\DateTime $customStartDate = null, $startWeek = 'Sun')
    {
        $baseDate = $customStartDate ?? clone $this->startDate;
        $this->generateHeaderCalendar($baseDate->format('Y-m-d'), 'weekly');

        $startDate = $baseDate;
        // 週間カレンダーを生成
        foreach ($this->getDayCountOfWeek($startWeek) as $weekCount => $weekName) {
            if ($weekName == $baseDate->format('D')) {
                // 週の初めを表示したい
                $startDate->modify("-$weekCount day");
            }
        }

        $tableBody = '<tr>';
        for ($i = 0; $i < 7; $i++) {
            // 現在の日付と曜日を表示
            // echo $startDate->format('Y-m-d') . ' (' . $this->getDayCountOfWeek($startWeek)[$i] . ')<br>';
            // echo $startDate->format('Y-m-d').'<br>';
            $tableBody .= '<td>' . $startDate->format('m / d') . '</td>';
            // 次の日に移動
            $startDate->modify('+1 day');
        }
        $tableBody .= '</tr></table>';

        echo $tableBody;
    }

}

?>