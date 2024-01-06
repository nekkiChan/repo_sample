<?php
namespace app\controllers\test;

use app\controllers\Controller;
use app\views\test\UploadView;

class UploadController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view = new UploadView();
    }

    public function index()
    {
        parent::index();

        // URLから 'page' パラメータを取得
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        parent::index();
        if (isset($_SESSION['message'])) {
            unset($_SESSION['message']);
        }

        // フォームが送信された場合の処理
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $keys = array_keys($_POST);

            $data = array_map(function (...$values) use ($keys) {
                return array_combine($keys, $values);
            }, ...array_values($_POST));

            foreach ($data as $key => $value) {
                // 変更されているか確認
                if ($this->usersModel->compareDataWithDB($data[$key])) {
                    // アップデート
                    $this->usersModel->updateData($data[$key]);
                } else {
                    $_SESSION['message'][] = $data[$key]['username'] . 'のデータに変更はありません<br>';
                }
            }
        }

        // USERSテーブル
        $query = 'SELECT id, username, email FROM ' . $this->usersModel->getTableName();
        $users = $this->usersModel->dbConnector->fetchAll($query);
        // ITEMSテーブル
        // $query = 'SELECT id, name FROM ' . $this->itemsModel->getTableName();
        // $users = $this->itemsModel->dbConnector->fetchAll($query);
        
        usort($users, function ($a, $b) {
            return $a['id'] - $b['id'];
        });

        // 1ページに表示するアイテム数の設定
        $itemsPerPage = 3;
        // ページ数ごとのアイテムの設定
        $items = array_chunk($users, $itemsPerPage);

        $data = [
            'title' => "表テスト画面",
            'items' => $items,
            'page' => $page,
        ];

        parent::view($data);
    }
}
