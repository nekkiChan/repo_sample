<?php
namespace app\models\util;

class Calendar
{
    private $startDate;
    private $startWeek;
    private $tableBody;

    public function __construct()
    {
        // 今日の日付を取得
        $this->startDate = new \DateTime();
        // はじめに表示する曜日
        $this->startWeek = 'Sun';
        // 表のbody部分
        $this->tableBody = '';
    }

    private function generateHeaderCalendar($selectedDate, $type)
    {
        echo '<input type="hidden" name="date" value="' . $selectedDate . '">';
        echo '<button name="option" value="previous">前月へ</button>';
        echo '<button name="option" value="next">次月へ</button>';
        echo "<input type='hidden' name='calendarType' value=$type>";

        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Sun</th>';
        echo '<th>Mon</th>';
        echo '<th>Tue</th>';
        echo '<th>Wed</th>';
        echo '<th>Thu</th>';
        echo '<th>Fri</th>';
        echo '<th>Sat</th>';
        echo '</tr>';
        echo '</thead>';

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

        return $dayOfWeekMap;
    }

    public function generateCalendar(\DateTime $customStartDate = null, $customStartWeek = 'Sun', $calendarType = 'weekly')
    {
        $this->startDate = $customStartDate !== null ? $customStartDate : clone $this->startDate;
        $this->startWeek = $customStartWeek !== null ? $customStartWeek : $this->startWeek;
        $this->generateHeaderCalendar($this->startDate->format('Y-m-d'), $calendarType);

        $this->tableBody = '<tr>';
        if ($calendarType == 'weekly') {
            // 週間カレンダーを生成
            $this->generateWeekCalendar();
        } else {
            $this->generateMonthCalendar();
        }
        $this->tableBody .= '</tr></table>';

        // テーブルbody部分を表示
        echo $this->tableBody;
    }

    private function generateWeekCalendar()
    {
        // 週間カレンダーを生成
        foreach ($this->getDayCountOfWeek($this->startWeek) as $weekCount => $weekName) {
            if ($weekName == $this->startDate->format('D')) {
                // 週の初めを表示したい
                $this->startDate->modify("-$weekCount day");
            }
        }
        for ($i = 0; $i < 7; $i++) {
            // 現在の日付と曜日を表示
            $this->tableBody .= '<td>' . $this->startDate->format('m / d') . '</td>';
            // 次の日に移動
            $this->startDate->modify('+1 day');
        }
    }

    private function generateMonthCalendar()
    {
        $SDay = (clone $this->startDate)->modify('first day of this month');
        $monthName = $SDay->format('m');
        var_dump($SDay->format('m'));

        for ($i = 0; $i < 6; $i++) {
            echo '<tr>';
            for ($j = 0; $j < 7; $j++) {
                echo '<td>';
                if ($i != 0 || $j >= $SDay->format('w')) {
                    if ($monthName == $SDay->format('m')) {
                        echo $SDay->format('d');
                        $SDay->modify('+1 day');
                    }
                }
                echo '</td>';
            }
            echo '</tr>';
            if ($monthName != $SDay->format('m')) {
                break;
            }
        }
    }
}

?>