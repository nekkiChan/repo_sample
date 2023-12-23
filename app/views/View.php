<?php
namespace app\views;

use util\Router;

class View
{
    protected $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function renderHeader()
    {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Login</title>
        </head>

        <body>
            <?php
            return ob_get_clean();
    }

    public function renderFooter()
    {
        ob_start();
        ?>
        </body>

        </html>
        <?php
        return ob_get_clean();
    }
}
