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

        parent::index();
        if (isset($_SESSION['message'])) {
            unset($_SESSION['message']);
        }

        // フォームが送信された場合の処理
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $listData = $_POST;
            unset($listData['page']);

            $tableName = $listData['table'];
            unset($listData['table']);

            $keys = array_keys($listData);

            $data = array_map(function (...$values) use ($keys) {
                return array_combine($keys, $values);
            }, ...array_values($listData));

            switch ($tableName) {
                case DB_Users:
                    $tableModel = $this->usersModel;
                    break;
                case DB_Items:
                    $tableModel = $this->itemsModel;
                    break;
                default:
                    break;
            }

            foreach ($data as $key => $value) {
                // 変更されているか確認
                if ($tableModel->compareDataWithDB($data[$key])) {
                    // アップデート
                    $tableModel->updateData($data[$key]);
                    $_SESSION['message'][] = $tableName . 'テーブルの ID' . $data[$key]['id'] . 'のデータを変更しました<br>';
                } else {
                    $_SESSION['message'][] = $tableName . 'テーブルの ID' . $data[$key]['id'] . 'のデータに変更はありません<br>';
                }
            }
        }

        // USERSテーブル
        $query = 'SELECT id, username, email FROM ' . $this->usersModel->getTableName();
        $users = $this->usersModel->dbConnector->fetchAll($query);
        // ITEMSテーブル
        $query = 'SELECT id, name FROM ' . $this->itemsModel->getTableName();
        $items = $this->itemsModel->dbConnector->fetchAll($query);

        usort($users, function ($a, $b) {
            return $a['id'] - $b['id'];
        });
        usort($items, function ($a, $b) {
            return $a['id'] - $b['id'];
        });

        // 1ページに表示するアイテム数の設定
        $usersItemsPerPage = 1;
        // ページ数ごとのアイテムの設定
        $users = array_chunk($users, $usersItemsPerPage);
        // URLから 'page' パラメータを取得
        $usersPage = isset($_GET[DB_Users]) ? intval($_GET[DB_Users]) : 1;
        $usersPage = isset($_POST['page'][DB_Users]) ? intval($_POST['page'][DB_Users]) : $usersPage;

        // 1ページに表示するアイテム数の設定
        $itemsItemsPerPage = 1;
        // ページ数ごとのアイテムの設定
        $items = array_chunk($items, $itemsItemsPerPage);
        // URLから 'page' パラメータを取得
        $itemsPage = isset($_GET[DB_Items]) ? intval($_GET[DB_Items]) : 1;
        $itemsPage = isset($_POST['page'][DB_Items]) ? intval($_POST['page'][DB_Items]) : $itemsPage;

        $data = [
            'title' => "アップロードテスト画面",
            'contents' =>
                [
                    DB_Users => [
                        'title' => "Users",
                        'table' => DB_Users,
                        'items' => $users,
                        'page' => $usersPage,
                    ],
                    DB_Items => [
                        'title' => "Items",
                        'table' => DB_Items,
                        'items' => $items,
                        'page' => $itemsPage,
                    ],
                ]
        ];

        parent::view($data);
    }
}
