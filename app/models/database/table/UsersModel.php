<?php

namespace app\models\database\table;

use app\models\database\DatabaseModel;

class UsersModel extends DatabaseModel
{
    public function __construct()
    {
        parent::__construct();
        // テーブル名
        $this->tableName = DB_Users;
        // マスター名
        $this->tableTitle = Master_Users;
        // ページ毎アイテム
        $this->itemsPerPage = 3;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function getMasterName()
    {
        return $this->tableTitle;
    }

    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }


    /**
     * テーブルのカラム情報を返す
     * 
     */
    public function getColumns()
    {
        return ['id', 'name', 'email'];
    }

    // プレースホルダーを使用したデータ挿入の例
    public function insertData($data)
    {
        parent::insertData($data);
    }

    // プレースホルダーを使用したデータ更新
    public function updateData($data)
    {
        parent::updateData($data);
    }

    public function compareDataWithDB($data)
    {
        return parent::compareDataWithDB($data);
    }
}
