@extends('templete.header.base_header')
@push('css')
@stack('css')
@endpush
@push('javascript')
@stack('javascript')
@endpush
@section('contents')
<!--検索フォーム-->
<div class="flex-box flex-start flex-column sub-color-back">
    @yield('kensaku')
</div>

<!--マスタデータ一覧-->
<div id="gridMaster" style="width:100%; height:calc(100% - {{$kensakuHight}});"></div>

<!--サブデータ一覧-->
<div id="gridSub" style="width:100%; height:calc(100% - {{$kensakuHight}});"></div>

<!--CSV出力用グリッド（非表示）-->
<div id="gridCSV" style="width:0; height:0; display:none;"></div>

<!--各種操作ボタン-->
@include('include.juchu.juchu_tehai_control')
<!------------->

<!--ポップアップダイアログ-->
@include('include.dialog.dialog_popup')
<!-------------------------->

<!--アラートダイアログ-->
@include('include.dialog.dialog_alert')
<!---------------------->

<!--確認ダイアログ-->
@include('include.dialog.dialog_confirm')
<!---------------------->

<!--選択ダイアログ-->
@include('include.dialog.dialog_sentaku')
<!---------------------->

<!--入力ダイアログ-->
<div id="dlgNyuryoku">
    <!--入力フォーム-->
    <form id="frmNyuryoku" name="frmNyuryoku" style="margin:0;">
        <!--ダイアログヘッダー-->
        <div id="dlgHeader" class="wj-dialog-header" style="padding :5px;">
            {{__('情報入力')}}
        </div>
        @yield('nyuryoku')
        <!--ダイアログフッター-->
        <div class="flex-box flex-end" style="padding:5px 10px">
            <div class="flex-left">
                <!-- 前へボタン -->
                <button id="btnPre"　name="btnPre" class="btn btn-primary" type="button" style="margin-right:10px;">
                    {{__('F1')}}{{__('前へ')}}
                </button>
                <!-- 次へボタン -->
                <button id="btnNext"　name="btnNext" class="btn btn-primary" type="button" style="margin-right:10px;">
                    {{__('F2')}}{{__('次へ')}}
                </button>
            </div>
            <!-- 日程算出ボタン -->
            <button id="btnNittei" name="btnNittei" class="btn btn-primary" type="button" style="margin-right:10px;">
                {{__('F5')}}{{__('日程算出')}}
            </button>
            <!-- 更新ボタン -->
            <button id="btnReload" name="btnReload" class="btn btn-primary" type="button" style="margin-right:10px;">
                {{__('F7')}}{{__('更新')}}
            </button>
            <!-- 参照ボタン -->
            <button name="btnSanshou" class="btn btn-primary btnSanshou" type="button" style="margin-right:10px;">
                {{__('F8')}}{{__('参照')}}
            </button>
            <!-- 決定ボタン -->
            <!-- <input id="btnKettei" name="btnKettei" class="btn btn-primary" type="submit" style="margin-right:10px;"> -->
            <!-- リセットボタン -->
            <!-- <button id="btnReset" name="btnReset" class="btn btn-primary" type="button" style="margin-right:10px;">
                {{__('F11')}}{{__('リセット')}}
            </button> -->
            <!-- 戻るボタン -->
            <button id="btnKetteiCancel" class="btn btn-primary" type="button" onclick="CloseNyuryokuDlg();">
                {{__('F12')}}</span>{{__('戻る')}}
            </button>
        </div>
    </form>
</div>
@yield('addContents')
<script>
    //
    SetPopupDlg(new wijmo.input.Popup('#dlgPopupMsg'));
    //
    SetAlertDlg(new wijmo.input.Popup('#dlgAlertMsg'));
    //
    SetConfirmDlg(new wijmo.input.Popup('#dlgConfirmMsg'));
    //
    SetNyuryokuDlg(new wijmo.input.Popup('#dlgNyuryoku'));
    //
    SetSentakuDlg(new wijmo.input.Popup('#dlgSentaku'));
    //
    SetBtnCSVMsg("{{ __('confirmMsg_exportCSV') }}");
    //
    SetBtnCloseMsg("{{ __('confirmMsg_closeWindow') }}");
</script>
@yield('javascript')
@endsection