<?php

namespace app\views;

use app\models\util\Router;
use app\models\util\Calendar;
use app\views\css\CSS;
use app\views\js\Script;
use app\models\database\DatabaseModel;


class View
{
    protected $router;
    protected $weeklyCalendar;
    protected $css;
    protected $script;
    protected $db;

    public function __construct()
    {
        $this->router = new Router();
        $this->weeklyCalendar = new Calendar();
        $this->css = new CSS();
        $this->script = new Script();
        $this->db = new DatabaseModel();
    }

    protected function getHTML($data)
    {
        echo $this->renderHeader($data);
        echo $this->renderContents($data);
        echo $this->renderFooter();
    }

    protected function renderContents($data)
    {
        ob_start();
        return ob_get_clean();
    }

    protected function renderHeader($data)
    {
        ob_start();
?>
        <!DOCTYPE html>
        <html lang="ja">

        <head>
        <meta charset="UTF-8">
            <title>
                <?= $data['title'] ?>
            </title>
        </head>

        <body>
            <div class="content">
                <h1>
                    <?= $data['title'] ?>
                </h1>
            <?php
            return ob_get_clean();
        }

        protected function renderFooter()
        {
            ob_start();
            ?>
            </div>
            <!-- ./content -->
        </body>

        </html>
<?php
            return ob_get_clean();
        }
    }
