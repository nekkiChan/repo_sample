<?php
namespace app\controllers\test;

use app\controllers\Controller;
use app\views\test\CalendarView;

class CalendarController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view = new CalendarView();
    }

    public function index()
    {
        $timestamp = strtotime(date('Y-m-d'));
        $date = date("Y-m-d", $timestamp);

        // フォームが送信されたかどうかを確認
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // POSTデータを取得
            $option = $_POST['option'];

            // dateの設定
            if ($_POST['calendarType'] == 'monthly') {
                $timestamp = ($option == 'next') ? strtotime($_POST['date'] . '+1 month') : strtotime($_POST['date'] . '-1 month');
            } else if ($_POST['calendarType'] == 'weekly') {
                // var_dump($_POST);
                $timestamp = ($option == 'next') ? strtotime($_POST['date'] . '+1 week') : strtotime($_POST['date'] . '-1 week');
            }
            $date = date("Y-m-d", $timestamp);

            // 取得したデータをビューに渡す
            $data = [
                'date' => $date,
            ];
        }

        // 取得したデータをビューに渡す
        $data = [
            'title' => "画像ボタンテスト画面",
            'date' => $date,
            'type' => "weekly",
        ];

        echo $this->view->getHTML($data);
    }
}
