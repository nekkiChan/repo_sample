<?php

namespace app\views\js\test;

header("Access-Control-Allow-Origin: *");

use app\views\js\Script;

class SearchAndTableScript extends Script
{
    protected $logModel;

    public function __construct()
    {
        parent::__construct();
    }

    protected function getBasicScript()
    {
        $code = parent::getBasicScript();
        $code .= <<<HTML
            <script>
                function getInput(element) {
                    console.log(this.toString());
                    // 親DIV要素
                    var divElement = element.parentElement;
                    // input要素
                    var inputElements = divElement.getElementsByTagName('input');
                    // select要素
                    var selectElements = divElement.getElementsByTagName('select');

                    // input要素とselect要素を結合した配列
                    var allElements = Array.from(inputElements).concat(Array.from(selectElements));

                    // 取得した全ての要素をコンソールに表示（例として）
                    // allElements.forEach(function(element) {
                    //     console.log(element.name);
                    //     console.log(element.value);
                    // });
                    
                    var divStr = divElement.getAttribute('id');
                    editTable(divStr.replace('search', 'exsit'), allElements);
                    // createValue(divStr.replace('search', 'create'), allElements);
                }

                function editTable(element, arrayElements){
                    console.log(this.toString());
                    // ID名
                    var idName = element;
                    // DIV要素
                    var divElement = document.getElementById(idName);
                    // メイン要素
                    var allElements = divElement.querySelectorAll('table tbody tr');

                    console.log(arrayElements[0].getAttribute('name'));

                    rows.forEach(function(row) {
                        var nameText = row.querySelector('td div').innerText.toLowerCase();

                        if (nameText.includes(query)) {
                            row.setAttribute('data-value', 'true');
                            row.style.display = 'table-row';
                        } else {
                            row.setAttribute('data-value', 'false');
                            row.style.display = 'none';
                        }
                    });

                    // // 取得した全ての要素をコンソールに表示（例として）
                    // allElements.forEach(function(element) {
                    //     divElements = element.querySelectorAll('td div');
                    //     divElements.forEach(function(element) {
                    //         var nameElement = element.getAttribute('name');
                    //         var bodyElement = element.innerText;
                    //         var arrayConditions = [];
                    //         arrayElements.forEach(function(element) {
                    //             // console.log(element.value.length == 0);
                    //             var conditions = [
                    //                 // name属性が同じか
                    //                 nameElement == element.getAttribute('name'),
                    //                 // 入力内容同じか
                    //                 bodyElement == element.value,
                    //             ];
                    //             arrayConditions.push(conditions.every(element => element === true));
                    //             // if(conditions.every(element => element === true)) {
                    //             //     console.log(bodyElement);
                    //             // }
                    //         });
                    //     });
                    // });
                }

                function createValue(element, arrayElements) {
                    console.log(this.toString());
                    // 要素を作成するDIV
                    var divElement = document.getElementById(element);
                    // table要素
                    var tableElement = divElement.querySelector('table');
                    // body
                    var headerElement = tableElement.querySelector('tbody');
                    // row
                    var rowbodyElement = document.createElement('tr');
                    // 要素の追加
                    tableElement.appendChild(headerElement);
                    headerElement.appendChild(rowbodyElement);


                    arrayElements.forEach(
                        function(element) {
                            // body
                            var bodyElement = document.createElement('td');
                            // 要素の追加
                            rowbodyElement.appendChild(bodyElement);

                            // 新規要素
                            var new_element = document.createElement('div');
                            // 要素に属性を設定
                            // new_element.setAttribute('type', 'text');
                            // new_element.setAttribute('readonly', 'readonly');
                            new_element.setAttribute('name', element.name);
                            // new_element.setAttribute('value', element.value);
                            // 要素のテキストを設定
                            new_element.innerText = element.value;
                            // 要素の追加
                            bodyElement.appendChild(new_element);
                        }
                    );
                }
            </script>
        HTML;
        return $code;
    }
}
