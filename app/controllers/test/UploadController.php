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

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            var_dump($_GET);
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

        // 1ページに表示するアイテム数の設定
        $itemsItemsPerPage = 1;
        // ページ数ごとのアイテムの設定
        $items = array_chunk($items, $itemsItemsPerPage);
        // URLから 'page' パラメータを取得
        $itemsPage = isset($_GET[DB_Items]) ? intval($_GET[DB_Items]) : 1;

        $data = [
            'title' => "アップロードテスト画面",
            'contents' =>
                [
                    DB_Users => [
                        'title' => "Users",
                        'items' => $users,
                        'page' => $usersPage,
                    ],
                    DB_Items => [
                        'title' => "Items",
                        'items' => $items,
                        'page' => $itemsPage,
                    ],
                ]
        ];

        parent::view($data);
    }
}
