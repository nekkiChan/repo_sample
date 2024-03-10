<?php

namespace app\views\css;

class CSS
{
    public function __construct()
    {
        $this->echoCSS();
    }

    private function echoCSS()
    {
        $this->echoContentsCSS();
        $this->echoLayoutCSS();
    }

    private function echoLayoutCSS()
    {
        $code = <<<HTML
            <style>
                .content {
                    background-color: bisque;
                }
            </style>
        HTML;

        echo $code;
    }

    protected function echoContentsCSS()
    {
    }
}
