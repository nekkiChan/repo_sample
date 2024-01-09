<?php
namespace app\controllers\test;

use app\controllers\Controller;
use app\views\test\TableView;

class TableController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->view = new TableView();
    }

    public function index()
    {
        parent::index();
        if (isset($_SESSION['message'])) {
            unset($_SESSION['message']);
        }

        // フォームが送信された場合の処理
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            var_dump($_POST['table']);

            $listData = $_POST;
            unset($listData['page']);
            unset($listData['table']);

            $keys = array_keys($listData);
            $data = array_map(function (...$values) use ($keys) {
                return array_combine($keys, $values);
            }, ...array_values($listData));

            switch ($_POST['table']) {
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
                    $_SESSION['message'][] = $_POST['table'] . 'テーブルの ID' . $data[$key]['id'] . 'のデータを変更しました<br>';
                } else {
                    $_SESSION['message'][] = $_POST['table'] . 'テーブルの ID' . $data[$key]['id'] . 'のデータに変更はありません<br>';
                }
            }
        }

        $contents[DB_Users] = $this->getContents($this->usersModel);
        $contents[DB_Items] = $this->getContents($this->itemsModel);

        $data = [
            'title' => "表テスト画面",
            'contents' => $contents,
        ];

        parent::view($data);
    }

    protected function getContents($tableModel)
    {
        $items = $this->getTableData($tableModel);
        $items = array_chunk($items, $tableModel->getItemsPerPage());
        return [
            'title' => $tableModel->getMasterName(),
            'table' => $tableModel->getTableName(),
            'items' => $items,
            'page' => $this->getNumberPage($items, $tableModel),
        ];
    }

    protected function getTableData($tableModel)
    {
        $tableData = $tableModel->getDataByCredentials();
        $tableColumns = $tableModel->getColumns();
        $tableData = array_map(function ($item) use ($tableColumns) {
            return array_intersect_key($item, array_flip($tableColumns));
        }, $tableData);

        return $tableData;
    }

    protected function getNumberPage($items, $tableModel)
    {
        $page = isset($_GET[$tableModel->getTableName()]) ? intval($_GET[$tableModel->getTableName()]) : 1;
        $page = isset($_POST['page'][$tableModel->getTableName()]) ? intval($_POST['page'][$tableModel->getTableName()]) : $page;

        return $page;
    }
}
