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

        var_dump($date);
        return $date;
    }

}
