<?php

namespace app\views\css;

class CalendarCSS extends CSS
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function echoContentsCSS()
    {
        $code =<<<HTML
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }

                .calendar {
                    max-width: 600px;
                    margin: 20px auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                th,
                td {
                    padding: 10px;
                    text-align: center;
                }

                th {
                    background-color: #333;
                    color: #fff;
                }

                td {
                    border: 1px solid #ddd;
                }

                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }

                .label-container {
                    display: flex;
                    flex-direction: column;
                }
            </style>
        HTML;

        echo $code;
    }
}
