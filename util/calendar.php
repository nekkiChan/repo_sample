<!-- calendar.php -->
<?php

use util\Router;
$route = new Router;

$currentMonth = date('n');
$currentYear = date('Y');
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
$firstDay = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
$firstDayOfWeek = date('w', $firstDay);

echo '<h2>' . date('F Y', $firstDay) . '</h2>';
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
        if (($dayCounter >= $firstDayOfWeek) && ($dayCounter - $firstDayOfWeek < $daysInMonth)) {
            $day = $dayCounter - $firstDayOfWeek + 1;
            $dateString = "$currentYear-$currentMonth-$day"; // YYYY-MM-DD 形式の文字列
            echo '<td><a href="' . $route->generateUrl('test/calendarResult') . '?date=' . $dateString . '">' . $day . '</a></td>';
        } else {
            echo '<td></td>';
        }
        $dayCounter++;
    }
    echo '</tr>';
}

echo '</table>';
?>
