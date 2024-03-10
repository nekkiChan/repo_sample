<?php

namespace app\views;

use app\views\View;

class HomeView extends View
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getHTML($data)
  {
    parent::getHTML($data);
  }

  public function renderContents($data)
  {

    $data = $this->db->getDataByCredentials(
      [
        'count' => 3,
        DB_Users['ID'] . '.name' => 'taro',
      ],
      // [
      //   [
      //     'table' => DB_Users['ID'],
      //     'column' => 'name',
      //   ],
      //   [
      //     'table' => DB_Items['ID'],
      //     'column' => 'name',
      //   ],
      // ],
      DB_Stores['DB_NAME'],
      [
        'order' => [
          'column' => DB_Stores['DB_NAME'] . '.id',
          'order' => 'UP'
        ],
        'period' => [
          [
            'column' => 'date',
            'period' => [
              '2024-03-21',
              '2024-04-21'
            ]
          ],
        ],
        'join' => [
          [
            'type' => 'LEFT',
            'table' => DB_Items['DB_NAME'] . ' AS ' . DB_Items['ID'],
            'on' =>
            DB_Stores['DB_NAME'] . '.' . 'item_id' .
              ' = ' . DB_Items['ID'] . '.' . 'id',
          ],
          [
            'type' => 'LEFT',
            'table' => DB_Users['DB_NAME'] . ' AS ' . DB_Users['ID'],
            'on' =>
            DB_Stores['DB_NAME'] . '.' . 'user_id' .
              ' = ' . DB_Users['ID'] . '.' . 'id',
          ],
        ],
        'select' => [
          [
            'table' => DB_Items['ID'],
            'column' => 'name',
          ],
          [
            'table' => DB_Users['ID'],
            'column' => 'name',
          ],
        ],
        'where' => [
          [
            'column' => DB_Items['ID'] . '.name',
            'value' => '%B%',
            'function' => 'like',
          ],
        ]
      ]
    );

    var_dump($data);
?>



<?php

    return ob_get_clean(); // バッファの内容を取得してバッファリングを終了
  }
}
