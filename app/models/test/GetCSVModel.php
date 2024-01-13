<?php
namespace app\models\test;

use app\models\database\table\UsersModel;
use app\models\Model;

class GetCSVModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function methodWhenPostRequest()
    {
        try {
            $data = $this->methodGetData();
            $this->makeCSV->makeCSV('users', $data);
        } catch (\Exception $e) {
            // Handle the exception (e.g., log it, show an error message)
            echo 'Error: ' . $e->getMessage();
        }
        return null;
    }

    public function methodGetData()
    {
        try {
            $usersModel = new UsersModel();
            $query = "SELECT id, username, email FROM users";
            // Use a prepared statement to prevent SQL injection
            $users = $usersModel->dbConnector->fetchAll($query);
            if ($users === false) {
                throw new \Exception('Failed to fetch data from the database');
            }

            // Sort the data by 'id'
            usort($users, function ($a, $b) {
                return $a['id'] - $b['id'];
            });

            return $users;
        } catch (\Exception $e) {
            throw new \Exception('Error in methodGetData: ' . $e->getMessage());
        }
    }

}
