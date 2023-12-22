<?php

// /your_project/src/Controller/HomeController.php

class HomeController
{
    public function index()
    {
        include '../src/View/home.php';
    }

    public function about()
    {
        echo 'About page';
    }
}
