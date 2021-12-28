<?php
// 「kengenKbn」が送信されていなければ0を設定
if (!isset($kengenKbn)) $kengenKbn = 0;
?>
<div class="flex-box flex-center main-color-back">
    <div class="control-panel flex-box flex-between container">
        @if($kengenKbn >= 3)
        <!--新規ボタン-->
        <button id="btnShinki" class="btn btn-primary" type="button">
            {{__('F1')}}{{__('新規')}}
        </button>
        <!--参照新規ボタン-->
        <button id="btnSanshouShinki" class="btn btn-primary" type="button">
            {{__('F2')}}{{__('参照新規')}}
        </button>
        @endif
        @if($kengenKbn >= 5)
        <!--修正ボタン-->
        <button id="btnShusei" class="btn btn-primary" type="button">
            {{__('F3')}}{{__('修正')}}
        </button>
        <!--削除ボタン-->
        <button id="btnSakujo" class="btn btn-primary" type="button">
            {{__('F4')}}{{__('削除')}}
        </button>
        @endif
        <!--表示ボタン-->
        <button id="btnHyouji" class="btn btn-primary" type="button">
            {{__('F5')}}{{__('表示')}}
        </button>
        <!--CSV出力ボタン-->
        <button id="btnCSV" class="btn btn-primary" type="button">
            {{__('F6')}}{{__('CSV出力')}}
        </button>
        <!--参照ボタン-->
        <button class="btn btn-primary btnSanshou" type="button">
            {{__('F8')}}{{__('参照')}}
        </button>
        <!--閉じるボタン-->
        <button id="btnClose" class="btn btn-primary flex-right" type="button">
            {{__('F12')}}{{__('閉じる')}}
        </button>
    </div>
</div>