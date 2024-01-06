<?php
namespace app\views;

use util\Router;
use util\Calendar;
use util\WeeklyCalendar;


class View
{
    protected $router;
    protected $weeklyCalendar;

    public function __construct()
    {
        $this->router = new Router();
        $this->weeklyCalendar = new WeeklyCalendar();
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
            <title><?= $data['title'] ?></title>
            <link rel="stylesheet" type="text/css" href="<?= HOME_URL . CSS_Path ?>style.css">
        </head>

        <body>
            <div class="content">
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
