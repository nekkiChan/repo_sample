<?php

namespace app\models\test;

use \app\models\Model;

class CalendarModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function methodWhenPostRequest()
    {
        $timestamp = strtotime(date('Y-m-d'));
        $date = date("Y-m-d", $timestamp);

        if (isset($_POST['calendarType'])) {
            // POSTデータを取得
            $date = isset($_POST['_date']) ? $_POST['_date'] : date("Y-m-d", $timestamp);
        }

        if (isset($_POST['option'])) {
            $option = $_POST['option'];
            if ($_POST['calendarType'] == 'monthly') {
                $timestamp = ($option == 'next') ? strtotime($_POST['date'] . '+1 month') : strtotime($_POST['date'] . '-1 month');
            } else if ($_POST['calendarType'] == 'weekly') {
                $timestamp = ($option == 'next') ? strtotime($_POST['date'] . '+1 week') : strtotime($_POST['date'] . '-1 week');
            }
        }

        return $date;
    }

    /**
     * 期間中の特定の曜日の日程を取得するメソッド
     * @param \Datetime $startDate
     * @param \Datetime $endDate
     * @param array $weekArray
     */
    public function methodGetWeek($startDate, $endDate, $weekArray = ['Sat', 'Sun'])
    {
        $currentDate = clone $startDate;
        $weekDates = [];

        while ($currentDate <= $endDate) {
            if (in_array($currentDate->format('D'), $weekArray)) {
                $weekDates[] = clone $currentDate;
            }
            $currentDate->add(new \DateInterval('P1D'));
        }

        echo "期間内の土曜日と日曜日:";
        print_r(count($weekDates));
        echo '<br>';
        return $weekDates;
    }

    public function methodGetHoliday()
    {
        // 取得したAPIキー
        $api_key = 'AIzaSyDuS2_R49PFrCEPXFTnA5yFKIBVQrmLzqQ';
        // カレンダーID
        // Googleの提供する日本の祝日カレンダー
        $calendar_id = urlencode('japanese__ja@holiday.calendar.google.com');
        // データの開始日
        $start = date('c', strtotime('2024-01-01')); // ISO 8601形式に変更
        // データの終了日
        $end = date('c', strtotime('2024-12-31')); // ISO 8601形式に変更
    
        $url = "https://www.googleapis.com/calendar/v3/calendars/" . $calendar_id . "/events?";
        $query = [
            'key' => $api_key,
            'timeMin' => $start,
            'timeMax' => $end,
            'maxResults' => 50,
            'orderBy' => 'startTime',
            'singleEvents' => 'true'
        ];
    
        $results = [];
        $data = file_get_contents($url . http_build_query($query));
        if ($data !== false) {
            $data = json_decode($data);
            // $data->itemsには日本の祝日カレンダーの"予定"が入ってきます
            foreach ($data->items as $row) {
                // [予定の日付 => 予定のタイトル]
                $results[$row->start->date] = $row->summary;
            }
        } else {
            // エラー処理を追加
            echo "Error fetching data from Google Calendar API.";
        }
    
        var_dump($results);
        echo '<br>';
    }
    
}
