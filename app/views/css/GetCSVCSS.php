<?php

namespace app\views\css;

class GetCSVCSS extends CSS
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function echoContentsCSS()
    {
        $code =<<<HTML
            <style>
                table {
                    width: 80vw;
                    border-collapse: collapse;
                    margin-top: 20px;
                }

                th,
                td {
                    padding: 10px;
                    text-align: left;
                    height: 50px;
                }

                th {
                    background-color: #f2f2f2;
                }

                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }

                td img {
                    background-color: blue;
                    max-width: 100%;
                    max-height: 100%;
                    width: auto;
                    height: auto;
                }
            </style>
        HTML;

        echo $code;
    }
}
