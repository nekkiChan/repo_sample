<?php
namespace app\views\test;

use app\views\View;

class TableView extends View
{
    public function generateTableView()
    {
        echo $this->renderHeader();

        // バッファリングを開始
        ob_start();

        ?>
        <style>
            table {
                border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
            }

            table tr {
                border-bottom: solid 1px #eee;
                cursor: pointer;
            }

            table tr:hover {
                background-color: #d4f0fd;
            }

            table th,
            table td {
                border:5px solid #333;
                text-align: center;
                justify-items: center;
                width: 25vw;
                padding: 15px 0;
            }

            table td.icon {
                background-size: 35px;
                background-position: left 5px center;
                background-repeat: no-repeat;
                padding-left: 30px;
            }

            .text:focus {
                box-shadow: 0 0 5px 0 rgba(255, 153, 0, 1);
                border: 2px solid #FFF !important;
                outline: 0;
            }
            

            table td .name {
                width: 400px;
                padding: 1rem;
                border: 5px black solid;
            }

            table td .name .nm {
                display: flex;
            }

            .nm input {
                width: 25%;
            }

            .nm .text,
            .kana .text {
                font-size: 12px;
                border: 1px;
            }

            .nm .text {
                font-size: 30px;
                border: 1px;
            }

            .kana .text {
                font-size: 12px;
                border: 1px;
            }

            .text {
                text-align: center;
            }

            .password_box {
                display: flex;
                /*アイコン、テキストボックスを調整する*/
                align-items: center;
                /*アイコン、テキストボックスを縦方向の中心に*/
                justify-content: center;
                /*アイコン、テキストボックスを横方向の中心に*/
                width: 100%;
                height: 50px;
                border-radius: 5px;
                border: 1px solid lightgray;
            }

            .password_inner {
                width: 100%;
                height: 100%;
                background-color: transparent;
                /*.password_boxの枠線お角一部被るため透明に*/
                position: relative;
            }

            #text4 {
                position: absolute;
                z-index: 1;
                /*.password_stringよりも上に配置*/
                height: 100%;
                width: 100%;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                border: none;
                /*枠線非表示*/
                outline: none;
                /*フォーカス時の枠線非表示*/
                padding: 0 10px;
                font-size: 16px;
                background-color: transparent;
                /*後ろの.password_stringを見せるため*/
                box-sizing: border-box;
                /*横幅の解釈をpadding, borderまでとする*/
            }

            .password_string {
                position: absolute;
                height: 100%;
                width: 140px;
                /*文字列分の長さ*/
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                padding-left: 10px;
                /*position: absolute;でのmarginは親要素はみ出す*/
                font-size: 16px;
                line-height: 50px;
                /*文字列を縦方向にmiddleに見せるため*/
                background-color: transparent;
                color: #80868b;
                box-sizing: border-box;
                /*横幅の解釈をpadding, borderまでとする*/
                transition: all 0.2s;
                -webkit-transition: all 0.2s;
            }

            .fa-eye-slash {
                /*アイコンに一定のスペースを設ける*/
                height: 20px;
                width: 20px;
                padding: 5px 5px;
            }

            /*アニメーション*/
            #text4:focus+.password_string {
                color: #3be5ae;
                font-size: 10px;
                line-height: 10px;
                width: 85px;
                height: 10px;
                padding: 0 2px;
                background-color: white;
                transform: translate3d(5px, -6px, 0);
            }
        </style>

        <h1>表テスト画面</h1>

        <?php
        echo $this->renderFooter();
        ?>

        <table>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    <div>カナ</div>
                    <div>名前</div>
                </th>
            </tr>
            <tr>
                <td>
                    1
                </td>
                <td class="name">
                    <div class="kana">
                        <input type="text" class="text" name="" id="" value="カンリシャ" placeholder="苗字（カナ）">
                        <input type="text" class="text" name="" id="" value="タロウ" placeholder="名前（カナ）">
                    </div>
                    <div class="nm">
                        <input type="text" class="text" name="" id="" value="管理者" placeholder="苗字">
                        <input type="text" class="text" name="" id="" value="太郎" placeholder="名前">
                    </div>
                </td>
            </tr>
        </table>

        <div class="group">
            <label for="text4">text4</label>
            <div class="password_box">
                <div class="password_inner">
                    <input id="text4" type="password">
                    <div class="password_string">パスワードを入力</div>
                </div>
                <i class="fas fa-eye-slash"></i>
            </div>
        </div>


        <?php
        $html = ob_get_clean();  // バッファの内容を取得してバッファリングを終了

        return $html;
    }

    public function showError($errorMessage)
    {
        echo '<p style="color:red;">' . $errorMessage . '</p>';
    }
}