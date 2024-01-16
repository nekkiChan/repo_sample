<?php
namespace app\controllers\test;

use app\controllers\Controller;
use app\models\test\CalendarModel;
use app\views\test\CalendarView;

class CalendarController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new CalendarModel();
        $this->view = new CalendarView();
    }

    public function index()
    {
        parent::index();

        // フォームが送信されたかどうかを確認
        $date = isset($this->model->dataWhenPostRequest) ? $this->model->dataWhenPostRequest : null;

        // 取得したデータをビューに渡す
        $data = [
            'title' => "カレンダーテスト画面",
            'date' => $date,
            'type' => "weekly",
        ];

        $this->model->methodGetWeek(new \DateTime(date('Y-m-d')), new \DateTime('2024-5-20'));
        $this->model->methodGetHoliday();
        // parent::view($data);
    }
}
