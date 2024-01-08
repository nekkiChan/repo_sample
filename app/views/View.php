<?php
namespace app\views;

use app\views\js\Script;
use util\Router;
use util\WeeklyCalendar;


class View
{
    protected $router;
    protected $weeklyCalendar;
    protected $script;

    public function __construct()
    {
        $this->router = new Router();
        $this->weeklyCalendar = new WeeklyCalendar();
        $this->script = new Script();
    }

    protected function getHTML($data)
    {
        echo $this->renderHeader($data);
        echo $this->renderContents($data);
        echo $this->renderFooter();
    }

    protected function renderContents($data = [])
    {
        ob_start();
        return ob_get_clean();
    }

    protected function renderHeader($data)
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>
                <?= $data['title'] ?>
            </title>
            <link rel="stylesheet" type="text/css" href="<?= HOME_URL . CSS_Path ?>style.css">
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
