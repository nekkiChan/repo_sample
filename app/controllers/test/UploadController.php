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
                if ($this->userModel->compareUserDataWithDB($data[$key])) {
                    // アップデート
                    $this->userModel->updateUserData($data[$key]);
                } else {
                    $_SESSION['message'][] = $data[$key]['username'] . 'のデータに変更はありません<br>';
                }
            }
        }

        $query = "SELECT id, username, email FROM users";
        $users = $this->userModel->dbConnector->fetchAll($query);
        usort($users, function ($a, $b) {
            return $a['id'] - $b['id'];
        });

        // 1ページに表示するアイテム数の設定
        $itemsPerPage = 3;
        // ページ数ごとのアイテムの設定
        $items = array_chunk($users, $itemsPerPage)[$page - 1];

        $data = [
            'title' => "表テスト画面",
            'users' => $users,
            'items' => $items,
            'page' => $page,
        ];
        return $this->view->getHTML($data);
    }
}
