@extends('templete.header.base_header')
@push('css')
@stack('css')
@endpush
@push('javascript')
@stack('javascript')
@endpush
@section('contents')
<!--検索フォーム-->
<div class="flex-box flex-start flex-column sub-color-back">@yield('kensaku')</div>

<!--マスタデータ一覧-->
<div id="gridMaster" style="width:100%; height:calc(100% - {{$kensakuHight}});"></div>

<!--出力用グリッド（非表示）-->
<div id="gridExport" style="width:0; height:0; display:none;"></div>

<!--各種操作ボタン-->
@include('include.master.master_control')

<!--ポップアップダイアログ-->
@include('include.dialog.dialog_popup')

<!--アラートダイアログ-->
@include('include.dialog.dialog_alert')

<!--確認ダイアログ-->
@include('include.dialog.dialog_confirm')

<!--選択ダイアログ-->
@include('include.dialog.dialog_sentaku')

<!--入力ダイアログ-->
<div id="dlgNyuryoku">
    <!--入力フォーム-->
    <form id="frmNyuryoku" name="frmNyuryoku" style="margin:0;">
        <!--ダイアログヘッダー-->
        <div class="wj-dialog-header" style="padding :5px;">
            {{__('情報入力')}}
        </div>
        @yield('nyuryoku')
        <!--ダイアログフッター-->
        <div id="frmNyuryokuFooter" class="flex-box flex-end" style="padding:5px 10px">
            <!--参照ボタン-->
            <button name="btnSanshou" class="btn btn-primary btnSanshou flex-left" type="button">
                {{__('F8')}}{{__('参照')}}
            </button>
            <!--決定ボタン-->
            <input id="btnKettei" name="btnKettei" class="btn btn-primary" type="submit" style="margin-right:10px;">
            <!--戻るボタン-->
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
    SetBtnExcelMsg("{{ __('confirmMsg_exportExcel') }}");
    //
    SetBtnCloseMsg("{{ __('confirmMsg_closeWindow') }}");
</script>
@yield('javascript')
@endsection
