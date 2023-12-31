<?php
namespace app\views;

use util\Router;
use util\Calendar;

class View
{
    protected $router;
    protected $calendar;

    public function __construct()
    {
        $this->router = new Router();
        $this->calendar = new Calendar();
    }

    public function renderHeader()
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Login</title>
            <link rel="stylesheet" type="text/css" href="<?= CSS_Path ?>style.css">
        </head>

        <body>
            <div class="content">
                <?php
                return ob_get_clean();
    }

    public function renderFooter()
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
