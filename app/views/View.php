<?php
namespace app\views;

use util\Router;

class View {
    protected $router;

    public function __construct() {
        $this->router = new Router();
    }
}
