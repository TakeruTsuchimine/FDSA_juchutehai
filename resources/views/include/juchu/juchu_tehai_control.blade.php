<?php
// 「kengenKbn」が送信されていなければ0を設定
if (!isset($kengenKbn)) $kengenKbn = 0;
?>
<div class="flex-box flex-center main-color-back">
    <div id='mainFooter' class="control-panel flex-box flex-between container">
        @if($kengenKbn >= 3)
        <!--新規ボタン-->
        <button id="btnFnc1" class="btn btn-primary" type="button">
            {{__('F1')}}
        </button>
        <!--参照新規ボタン-->
        <button id="btnFnc2" class="btn btn-primary" type="button">
            {{__('F2')}}
        </button>
        @endif
        @if($kengenKbn >= 5)
        <!--修正ボタン-->
        <button id="btnFnc3" class="btn btn-primary" type="button">
            {{__('F3')}}
        </button>
        @endif
        @if($kengenKbn >= 7)
        <!--削除ボタン-->
        <button id="btnFnc4" class="btn btn-primary" type="button">
            {{__('F4')}}
        </button>
        @endif
        <!--表示ボタン-->
        <button id="btnHyouji" class="btn btn-primary" type="button">
            {{__('F5')}}{{__('表示')}}
        </button>
        <!--Excel出力ボタン-->
        <button id="btnExcel" class="btn btn-primary" type="button">
            {{__('F6')}}{{__('Excel出力')}}
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
