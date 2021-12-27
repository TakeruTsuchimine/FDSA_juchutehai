{{-- PHP処理 --}}
<?php
    // 「loginId」が送信されていなければ0を設定
    if(!isset($loginId)) $loginId = 0;

    // 検索フォームの高さ
    $kensakuHight = '180px';
?>

{{-- 共通レイアウト呼び出し --}}
{{--「base_master.blede.php」・・・マスタ画面の共通テンプレートデザイン --}}
@extends('templete.header.juchu.base_juchu')

{{-- 「検索フォーム」 --}}
@section('kensaku')
{{-- 検索フォーム全体 --}}
<form id="frmKensaku" name="frmKensaku" class="flex-box" style="height:{{ $kensakuHight }};">
    {{-- 一列目 --}}
    <div class="form-column" style="width:50%;">
        {{-- 「受注日」 --}}
        <label>
            <span style="width:4.5em; margin-right:5px;">{{__('juchu_date')}}</span>
            <input id="dataJuchuStartDate" name="dataJuchuStartDate" type="hidden" style="width:9em;">
            <span style="margin:0 5px;">～</span>
            <input id="dataJuchuEndDate" name="dataJuchuEndDate" type="hidden" style="width:9em;">
        </label>
        {{-- 「納期」 --}}
        <label>
            <span style="width:4.5em; margin-right:5px;">{{__('nouki_date')}}</span>
            <input id="dataNoukiStartDate" name="dataNoukiStartDate" type="hidden" style="width:9em;">
            <span style="margin:0 5px;">～</span>
            <input id="dataNoukiEndDate" name="dataNoukiEndDate" type="hidden" style="width:9em;">
        </label>
        {{-- 「受注番号」 --}}
        <label>
            <span style="width:4.5em;">{{__('juchu_no')}}</span>
            <input name="dataStartJuchuNo" class="form-control" type="text" style="width:14em;">
            <span style="margin:0 5px;">～</span>
            <input name="dataEndJuchuNo" class="form-control" type="text" style="width:14em;">
        </label>
        {{-- 「客先注文番号」 --}}
        <label>
            <span style="width:7.5em;">{{__('tokuisaki_chumon_no')}}</span>
            <input name="dataChumonNo" class="form-control" type="text" maxlength="30" autocomplete="off"
                style="width:27em;">
        </label>
    </div>
    {{-- 二列目 --}}
    <div class="form-column" style="width:50%;">
        {{-- 「得意先CD」 --}}
        <label>
            <span style="width:4.5em;">{{__('tokuisaki_cd')}}</span>
            <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                <input name="dataTokuisakiCd" class="form-control" type="text" maxlength="6" autocomplete="off"
                    style="width:9em;">
                {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                <i class="fas fa-search search-btn"></i>
            </span>
            {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
            <input name="dataTokuisakiName" class="form-control" type="text" style="width:22em;" onfocus="blur();"
                readonly>
        </label>
        {{-- 「品目CD」 --}}
        <label>
            <span style="width:4.5em;">{{__('hinmoku_cd')}}</span>
            <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                <input name="dataHinmokuCd" class="form-control" type="text" maxlength="6" autocomplete="off"
                    style="width:9em;">
                {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                <i class="fas fa-search search-btn"></i>
            </span>
            {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
            <input name="dataHinmokuCodeName" class="form-control" type="text" style="width:22em;" onfocus="blur();"
                readonly>
        </label>
        {{-- 「品目名」 --}}
        <label>
            <span style="width:4.5em;">{{__('hinmoku_name')}}</span>
            <input name="dataHinmokuName" class="form-control" type="text" maxlength="30" autocomplete="off"
                style="width:27em;">
        </label>
        {{-- 表示件数 --}}
        <div class="flex-box flex-end" style="margin-top:auto;">
            <div class="base-color-front" style="color:black;">
                <span id="zenkenCnt" style="margin: 0 10px;"></span>{{__('件')}}{{__('を表示')}}
            </div>
        </div>
    </div>

</form>
@endsection

{{-- 「入力ダイアログ」 --}}
@section('nyuryoku')
{{-- 入力フォーム全体 --}}
<div class="flex-box" style="padding:5px 10px;">
    <div class="form-column">
        <div class="form-column">
            {{-- 「受注日」 --}}
            <label>
                <span style="width:4.5em; margin-right:5px;">{{__('juchu_date')}}</span>
                <input id="dataJuchuDate" name="dataJuchuDate" type="hidden">
            </label>
        </div>
        <div class="form-column">
            {{-- 「受注番号」 --}}
            <label>
                <span style="width:4.5em;">{{__('juchu_no')}}</span>
                {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                <input name="dataJuchuNo" class="form-control code-check" type="text" maxlength="20" autocomplete="off"
                    style="width:22em;" pattern="^([a-zA-Z0-9]{0,20})$"
                    title="{{ __('半角英数字') }}20{{ __('文字以内で入力してください') }}" required>
            </label>
        </div>
        <div class="form-column">
            {{-- 「得意先CD」 --}}
            <label>
                <span style="width:4.5em;">{{__('tokuisaki_cd')}}</span>
                <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                    {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                    <input id="dataTokuisakiCd" name="dataTokuisakiCd" class="form-control code-check" type="text" maxlength="10"
                        autocomplete="off" style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$"
                        title="{{ __('半角英数字') }}10{{ __('文字以内で入力してください') }}">
                    {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                    <i class="fas fa-search search-btn"></i>
                </span>
                {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                <input name="dataTokuisakiName" class="form-control" type="text" style="width:30em;" onfocus="blur();"
                    readonly>
            </label>
        </div>
        <div class="form-column">
            {{-- 「納入先CD」 --}}
            <label>
                <span style="width:4.5em;">{{__('nounyusaki_cd')}}</span>
                <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                    {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                    <input id="dataNounyusakiCd" name="dataNounyusakiCd" class="form-control code-check" type="text" maxlength="10"
                        autocomplete="off" style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$"
                        title="{{ __('半角英数字') }}10{{ __('文字以内で入力してください') }}">
                    {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                    <i class="fas fa-search search-btn"></i>
                </span>
                {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                <input id="dataNounyusakiName" name="dataNounyusakiName" class="form-control" type="text" style="width:30em;"
                       onfocus="blur();" readonly>
            </label>
        </div>
        <div class="form-column">
            {{-- 「営業担当」 --}}
            <label>
                <span style="width:6em;">{{__('eigyou_tantousha_cd')}}</span>
                <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                    {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                    <input name="dataEigyouCd" class="form-control code-check" type="text" maxlength="10"
                        autocomplete="off" style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$"
                        title="{{ __('半角英数字') }}10{{ __('文字以内で入力してください') }}">
                    {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                    <i class="fas fa-search search-btn"></i>
                </span>
                {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                <input name="dataEigyouName" class="form-control" type="text" style="width:15em;" onfocus="blur();"
                    readonly>
            </label>
        </div>
        <div class="form-column">
            {{-- 「アシスタントCD」 --}}
            <label>
                <span style="width:6em;">{{__('assistant_cd')}}</span>
                <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                    {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                    <input name="dataAssistantCd" class="form-control code-check" type="text" maxlength="10"
                        autocomplete="off" style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$"
                        title="{{ __('半角英数字') }}10{{ __('文字以内で入力してください') }}">
                    {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                    <i class="fas fa-search search-btn"></i>
                </span>
                {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                <input name="dataAssistantName" class="form-control" type="text" style="width:15em;" onfocus="blur();"
                    readonly>
            </label>
        </div>
        <div class="form-column">
            {{-- 「客先注番1」 --}}
            <label>
                <span style="width:5em;">{{__('tokuisaki_chumon_no1')}}</span>
                <input name="dataChumonNo1" class="form-control" type="text" maxlength="30" autocomplete="off"
                    style="width:33em;" pattern="^([a-zA-Z0-9]{0,30})$"
                    title="{{ __('半角英数字') }}30{{ __('文字以内で入力してください') }}">
            </label>
        </div>
        <div class="form-column">
            {{-- 「客先注番2」 --}}
            <label>
                <span style="width:5em;">{{__('tokuisaki_chumon_no2')}}</span>
                <input name="dataChumonNo2" class="form-control" type="text" maxlength="30" autocomplete="off"
                    style="width:33em;" pattern="^([a-zA-Z0-9]{0,30})$"
                    title="{{ __('半角英数字') }}30{{ __('文字以内で入力してください') }}">
            </label>
        </div>
        <div class="form-column">
            {{-- 「客先品番」 --}}
            <label>
                <span style="width:5em;">{{__('tokuisaki_chumon_no3')}}</span>
                <input name="dataChumonNo3" class="form-control" type="text" maxlength="30" autocomplete="off"
                    style="width:33em;" pattern="^([a-zA-Z0-9]{0,30})$"
                    title="{{ __('半角英数字') }}30{{ __('文字以内で入力してください') }}">
            </label>
        </div>
        <div class="form-column">
            {{-- 「品目CD」 --}}
            <label>
                <span style="width:4.5em;">{{__('hinmoku_cd')}}</span>
                <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                    {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                    <input name="dataHinmokuCd" class="form-control code-check" type="text" maxlength="10"
                        autocomplete="off" style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$"
                        title="{{ __('半角英数字') }}10{{ __('文字以内で入力してください') }}">
                    {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                    <i class="fas fa-search search-btn"></i>
                </span>
                {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                <input name="dataHinmokuName" class="form-control" type="text" style="width:30em;" onfocus="blur();"
                    readonly>
            </label>
        </div>
        <div class="form-column">
            {{-- 「単位CD」 --}}
            <label>
                <span style="width:4.5em;">{{__('tani_cd')}}</span>
                <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                    {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                    <input name="dataTaniCd" class="form-control code-check" type="text" maxlength="10"
                        autocomplete="off" style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$"
                        title="{{ __('半角英数字') }}10{{ __('文字以内で入力してください') }}">
                    {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                    <i class="fas fa-search search-btn"></i>
                </span>
                {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                <input name="dataTaniName" class="form-control" type="text" style="width:12em;" onfocus="blur();"
                    readonly>
            </label>
        </div>
        <div class="form-column">
            {{-- 「希望納期」 --}}
            <label>
                <span style="width:5.5em;">{{__('nouki_date')}}</span>
                <input id="dataNoukiDate" name="dataNoukiDate" type="hidden">
            </label>
        </div>
        <div class="form-column">
            {{-- 「出荷予定日」 --}}
            <label>
                <span style="width:5.5em;">{{__('shukka_date')}}</span>
                <input id="dataShukkaDate" name="dataShukkaDate" type="hidden">
            </label>
        </div>
    </div>
    <div class="form-column" style="margin-left: 10px;">
        <div class="form-column">
            {{-- 「受注数」 --}}
            <label>
                <span style="width:4.5em;">{{__('juchu_qty')}}</span>
                {{-- 「受注数」コントロール本体 --}}
                <div id="numJuchuQty"></div>
                <input name="dataJuchuQty" type="hidden">
            </label>
        </div>
        <div class="form-column">
            {{-- 「受注単価」 --}}
            <label>
                <span style="width:4.5em;">{{__('juchu_tanka')}}</span>
                {{-- 「受注単価」コントロール本体 --}}
                <div id="numJuchuTanka"></div>
                <input name="dataJuchuTanka" type="hidden">
            </label>
        </div>
        <div class="form-column">
            {{-- 「受注金額」 --}}
            <label>
                <span style="width:4.5em;">{{__('juchu_kin')}}</span>
                {{-- 「受注金額」コントロール本体 --}}
                <div id="numJuchuKin"></div>
                <input name="dataJuchuKin" type="hidden">
            </label>
        </div>
        <div class="form-column">
            {{-- 「仮単価区分」 --}}
            <label>
                <span style="width:5.5em;">{{__('karitanka_kbn')}}</span>
                {{-- 「仮単価区分」コンボボックス本体 --}}
                <div id="cmbKaritankaKbn" style="width:10em;"></div>
                {{-- 「仮単価区分」フォーム送信データ --}}
                <input name="dataKaritankaKbn" type="hidden">
            </label>
        </div>
        <div class="form-column">
            {{-- 「受注区分」 --}}
            <label>
                <span style="width:5.5em;">{{__('juchu_kbn')}}</span>
                {{-- 「受注区分」コンボボックス本体 --}}
                <div id="cmbJuchuKbn" style="width:10em;"></div>
                {{-- 「受注区分」フォーム送信データ --}}
                <input name="dataJuchuKbn" type="hidden">
            </label>
        </div>
        <div class="form-column">
            {{-- 「配送便CD」 --}}
            <label>
                <span style="width:4.5em;">{{__('haisoubin_cd')}}</span>
                <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                    {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                    <input name="dataHaisoubinCd" class="form-control code-check" type="text" maxlength="10"
                        autocomplete="off" style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$"
                        title="{{ __('半角英数字') }}10{{ __('文字以内で入力してください') }}">
                    {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                    <i class="fas fa-search search-btn"></i>
                </span>
                {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                <input name="dataHaisoubinName" class="form-control" type="text" style="width:12em;" onfocus="blur();"
                    readonly>
            </label>
        </div>
        <div class="form-column">
            {{-- 「備考1」 --}}
            <label style="height:3.5em;">
                <span style="width:4.5em;">{{__('notes1')}}</span>
                <textarea name="dataNote1" class="form-control" maxlength="120" autocomplete="off"></textarea>
            </label>
        </div>
        <div class="form-column">
            {{-- 「備考2」 --}}
            <label style="height:3.5em;">
                <span style="width:4.5em;">{{__('notes2')}}</span>
                <textarea name="dataNote2" class="form-control" maxlength="60" autocomplete="off"></textarea>
            </label>
        </div>
        <div class="form-column">
            {{-- 「備考3」 --}}
            <label style="height:3.5em;">
                <span style="width:4.5em;">{{__('notes3')}}</span>
                <textarea name="dataNote3" class="form-control" maxlength="60" autocomplete="off"></textarea>
            </label>
        </div>
        <div class="form-column">
            {{-- 「有効期間（自）」 --}}
            <label>
                <span>{{__('yukoukikan_start_date')}}</span>
                <input id="dataStartDate" name="dataStartDate" type="hidden">
            </label>
        </div>
        <div class="form-column">
            {{-- 「登録日」 --}}
            <label>
                <span style="width:10em;">{{__('touroku_dt')}}</span>
                <input name="dataTourokuDt" class="form-control-plaintext" type="text" readonly>
            </label>
        </div>
        <div class="form-column">
            {{-- 「更新日」 --}}
            <label>
                <span style="width:10em;">{{__('koushin_dt')}}</span>
                <input name="dataKoushinDt" class="form-control-plaintext" type="text" readonly>
            </label>
        </div>
    </div>
</div>
{{-- 内部入力値 --}}
{{-- 「処理種別」
　※入力ダイアログの操作、新規・修正・削除のどの処理で開いたかを判別 --}}
<input id="dataSQLType" name="dataSQLType" type="hidden">
{{-- 「ログインID」 --}}
<input name="dataLoginId" type="hidden" value="{{ $loginId }}">
{{-- 「レコードID」 --}}
<input name="dataId" type="hidden">
@endsection

{{-- javascript --}}
@section('javascript')
<script>
    {{-- -------------------- --}}
    {{-- wijmoコントロール宣言 --}}
    {{-- -------------------- --}}

    {{-- カレンダー宣言 --}}
    {{-- 有効期間（自） --}}
    var dateStart = new wijmo.input.InputDate('#dataStartDate');

    var dateJuchu = new wijmo.input.InputDate('#dataJuchuDate');
    var dateJuchuStart = new wijmo.input.InputDate('#dataJuchuStartDate', {
        isRequired: false,
        valueChanged: (sender) => { CheckJuchuDate(); }
    });
    var dateJuchuEnd = new wijmo.input.InputDate('#dataJuchuEndDate', {
        isRequired: false,
        valueChanged: (sender) => { CheckJuchuDate(); }
    });
    var dateNouki = new wijmo.input.InputDate('#dataNoukiDate', { isRequired: false, value: null });
    var dateNoukiStart = new wijmo.input.InputDate('#dataNoukiStartDate', {
        isRequired: false, value: null,
        valueChanged: (sender) => { CheckNoukiDate(); }
    });
    var dateNoukiEnd = new wijmo.input.InputDate('#dataNoukiEndDate', {
        isRequired: false, value: null,
        valueChanged: (sender) => { CheckNoukiDate(); }
    });
    var dateShukka = new wijmo.input.InputDate('#dataShukkaDate', { isRequired: false, value: null });
    var numJuchuQty = new wijmo.input.InputNumber('#numJuchuQty', {
        isRequired: false, format: 'n0', min: 0, max: 9999999999999999,
        valueChanged: (sender) => { SumJuchuKin(); }
    });
    var numJuchuTanka = new wijmo.input.InputNumber('#numJuchuTanka', {
        isRequired: false, format: 'c2', min: 0, max: 9999999999999999,
        valueChanged: (sender) => { SumJuchuKin(); }
    });
    var numJuchuKin = new wijmo.input.InputNumber('#numJuchuKin', { isRequired: false, isDisabled: true, format: 'c2', min: 0, max: 9999999999999999});
    {{-- 権限区分選択値 --}}
    {{-- コンボボックス宣言 --}}
    var cmbKaritankaKbn = new wijmo.input.ComboBox('#cmbKaritankaKbn', { isRequired: false, itemsSource: ['確定単価','仮単価'] });
    {{-- カテゴリー種別 --}}
    var juchuKbn = [];
    {{-- 分類管理CD --}}
    var juchuKbnCd = [];
    var cmbJuchuKbn = new wijmo.input.ComboBox('#cmbJuchuKbn', { isRequired: false　});

    {{-- ------- --}}
    {{-- 初期処理 --}}
    {{-- ------- --}}

    {{-- ページ初期処理
         ※ページが読み込まれた際に一番初めに処理される関数 --}}
    window.onload = function()
    {
        {{-- 右クリック時の操作メニュー宣言 ※common_function.js参照 --}}
        SetContextMenu();
        {{-- ファンクションキーの操作宣言 ※common_function.js参照 --}}
        SetFncKey(null);
        {{-- 入力ダイアログ表示イベント登録 ※common_function.js参照 --}}
        SetNyuryokuData(fncNyuryokuData);
        {{-- 「表示」ボタンイベント登録 ※common_function.js参照 --}}
        SetBtnHyouji(fncShowDataGrid); 
        {{-- 「CSV出力」ボタンイベント登録 ※common_function.js参照 --}}
        SetBtnCSV(fncExportCSV);

        {{-- グリッド初期処理--}}
        InitGrid();

        {{-- 受注区分初期処理 --}}
        AjaxData("{{ url('/inquiry/1300') }}", { 'dataTargetCd': 'JUCHUKBN' }, fncJushinJuchuKbnData);
        
        {{-- グリッドデータの表示 --}}
        $('#btnHyouji').click();
    }
    {{-- グリッド共有変数 --}}
    var gridMaster;
    {{-- グリッド初期処理--}}
    function InitGrid()
    {
        {{-- FlexGridのレイアウト設定 --}}
        let columns = [
            {
                binding: 'dataJuchuDate',
                header : "{{__('juchu_date')}}",
                width  : 100
            },
            {
                binding: 'dataJuchuNo',
                header : "{{__('juchu_no')}}",
                width  : 100
            },
            {
                binding: 'dataTokuisakiName',
                header : "{{__('tokuisaki_name')}}",
                width  : 100
            },
            {
                binding: 'dataHinmokuName',
                header : "{{__('hinmoku_name')}}",
                width  : 200
            },
            {
                binding: 'dataEigyouName',
                header : "{{__('eigyou_tantousha_name')}}",
                width  : 120
            },
            {
                binding: 'dataJuchuKbnName',
                header : "{{__('juchu_kbn')}}",
                width  : 100
            },
            {
                binding: 'dataNoukiDate',
                header : "{{__('nouki_date')}}",
                width  : 100
            },
            {
                binding: 'dataShukkaDate',
                header : "{{__('shukka_date')}}",
                width  : 100
            },
            {
                binding: 'dataJuchuQty',
                header: "{{__('juchu_qty')}}",
                format: 'n',
                width: 100
            },
            {
                binding: 'dataJuchuTanka',
                header: "{{__('juchu_tanka')}}",
                format: 'c2',
                width: 100
            },
            {
                binding: 'dataJuchuKin',
                header: "{{__('juchu_kin')}}",
                format: 'c2',
                width: 100
            },
            {
                binding: 'dataHaisoubinName',
                header: "{{__('haisoubin_name')}}",
                width: 150
            },
            {
                {{-- 「有効期間（自）」 --}}
                binding: 'dataStartDate',
                header: "{{ __('yukoukikan_start_date') }}",
                width: 150
                    
            },
            {
                {{-- 「有効期間（至）」 --}}
                binding: 'dataEndDate',
                header : "{{ __('yukoukikan_end_date') }}",
                width  : 150
            }
        ]; 
        {{-- グリッドの設定 --}}
        let gridOption = {
            {{-- レイアウト設定 --}}
            columns: columns,
            {{-- 選択スタイル（セル単位） --}}
            selectionMode: wijmo.grid.SelectionMode.Row,
            {{-- セル編集（無効） --}}
            isReadOnly: true,
            {{-- デフォルト行スタイル（0行ごとに色付け） --}}
            alternatingRowStep: 0,
            {{-- グリッド上でのEnterキーイベント（無効） --}}
            keyActionEnter: wijmo.grid.KeyAction.None,
            {{-- グリッド自動生成 --}}
            autoGenerateColumns: false,
            {{-- セル読み込み時のイベント --}}
            loadedRows: function (s, e)
            {
                {{-- 任意の色でセルを色付け
                     ※rowPerItemでMultiRowの1レコード当たりの行数を取得
                     ※common_function.js参照 --}}
                LoadGridRows(s, 1);
            }
        }       
        {{-- グリッド宣言 --}}
        gridMaster = new wijmo.grid.FlexGrid('#gridMaster', gridOption);

        {{-- グリッド関連のイベント登録 --}}
        {{-- グリッドの親要素 --}}
        let host = gridMaster.hostElement;

        {{-- グリッドの「右クリック」イベント --}}
        gridMaster.addEventListener(host, 'contextmenu', function (e)
        {
            if(gridMaster.itemsSource.length < 1 ||
               gridMaster.collectionView.currentItem == null) return; 
            {{-- セル上での右クリックメニュー表示 ※common_function.js参照 --}}
            SetGridContextMenu(gridMaster, e);
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            if(gridMaster.itemsSource.length < 1) return;
            {{-- クリックした位置を選択 --}}
            gridMaster.select(new wijmo.grid.CellRange(gridMaster.hitTest(e).row, 0), true);
        });

        {{-- グリッドの「ダブルクリック」イベント --}}
        gridMaster.addEventListener(host, 'dblclick', function (e)
        {
            {{-- 選択したセルがヘッダー要素でない場合は「修正」ボタンと同じ処理 --}}
            if(gridMaster.hitTest(e).cellType == wijmo.grid.CellType.Cell) $('#btnShusei').click();
        });

        {{-- グリッドの「キーボード」イベント --}}
        gridMaster.addEventListener(host, 'keydown', function (e)
        {
            {{-- 「Enterキー」は「修正」ボタンと同じ処理 --}}
            if(e.keyCode == KEY_ENTER)
            {
                $('#btnShusei').click();
                {{-- キーボードイベント二重起動防止 --}}
                windowKeybordFlg = false;
            }
        });
    }

    {{-- --------------------------- --}}
    {{-- ボタンイベント登録用の関数変数 --}}
    {{-- --------------------------- --}}

    {{-- 「表示」ボタンイベント --}}
    var fncShowDataGrid = function()
    {
        {{-- 検索フォーム要素 --}}
        let kensakuData = document.forms['frmKensaku'].elements;
        {{-- POST送信用オブジェクト配列 --}}
        let soushinData = {};
        {{-- フォーム要素から送信データを格納 --}}
        for(var i = 0; i< kensakuData.length; i++){
            {{-- フォーム要素のnameが宣言されている要素のみ処理 --}}
            if(kensakuData[i].name != ''){
                {{-- フォーム要素のnameを配列のキーしてPOSTデータの値を作成する --}}
                {{-- 検索値の末尾に検索条件キーを付与してLIKE検索をできるようにする ※LIKE_VALUE_BOTHは部分一致検索 --}}
                if(kensakuData[i].name == 'dataChumonNo' ||
                   kensakuData[i].name == 'dataTokuisakiCd' ||
                   kensakuData[i].name == 'dataHinmokuCd' ||
                   kensakuData[i].name == 'dataHinmokuName'){
                    soushinData[kensakuData[i].name] = (kensakuData[i].value != '') ? (kensakuData[i].value + LIKE_VALUE_BOTH) : '';
                }else{
                    soushinData[kensakuData[i].name] = (kensakuData[i].value != '' && kensakuData[i].value != null) ? kensakuData[i].value : null;
                }
            }
        }
        {{-- 「データ更新中」表示 --}}
        ShowPopupDlg("{{ __('データ更新中') }}");
        {{-- グリッドのデータ受信 --}}
        AjaxData("{{ url('/juchu/3800') }}", soushinData, fncJushinGridData);
        {{-- 検索件数の取得フラグの送信データを追加 --}}
        soushinData["dataCntFlg"] = true;
        {{-- 検索件数のデータ受信 --}}
        AjaxData("{{ url('/juchu/3800') }}", soushinData, fncJushinDataCnt);
    }
    {{-- 「CSV出力」ボタンイベント --}}
    var fncExportCSV = function()
    {
        {{-- CSV出力用グリッドのレイアウト設定 --}}
        let columns = [{ binding: 'dataJuchuDate', header: "{{ __('juchu_date') }}" },
                       { binding: 'dataJuchuNo', header: "{{ __('tantousha_name') }}" },
                       { binding: 'dataTokuisakiCd', header: "{{ __('tokuisaki_cd') }}" },
                       { binding: 'dataTokuisakiName', header: "{{ __('tokuisaki_name') }}" },
                       { binding: 'dataNounyusakiCd', header: "{{ __('nounyusaki_cd') }}" },
                       { binding: 'dataNounyusakiName', header: "{{ __('nounyusaki_name') }}" },
                       { binding: 'dataEigyouCd', header: "{{ __('eigyou_tantousha_cd') }}" },
                       { binding: 'dataEigyouName', header: "{{ __('eigyou_tantousha_name') }}" },
                       { binding: 'dataAssistantCd', header: "{{ __('assistant_cd') }}" },
                       { binding: 'dataAssistantName', header: "{{ __('assistant_name') }}" },
                       { binding: 'dataChumonNo1', header: "{{ __('tokuisaki_chumon_no1') }}" },
                       { binding: 'dataChumonNo2', header: "{{ __('tokuisaki_chumon_no2') }}" },
                       { binding: 'dataChumonNo3', header: "{{ __('tokuisaki_chumon_no3') }}" },
                       { binding: 'dataHinmokuCd', header: "{{ __('hinmoku_cd') }}" },
                       { binding: 'dataHinmokuName', header: "{{ __('hinmoku_name') }}" },
                       { binding: 'dataTaniCd', header: "{{ __('tani_cd') }}" },
                       { binding: 'dataTaniName', header: "{{ __('tani_name') }}" },
                       { binding: 'dataNoukiDate', header: "{{ __('nouki_date') }}" },
                       { binding: 'dataShukkaDate', header: "{{ __('shukka_date') }}" },
                       { binding: 'dataJuchuQty', header: "{{ __('juchu_qty') }}" },
                       { binding: 'dataJuchuTanka', header: "{{ __('juchu_tanka') }}" },
                       { binding: 'dataJuchukin', header: "{{ __('juchu_kin') }}" },
                       { binding: 'dataKaritankaKbnName', header: "{{ __('karitnka_kbn') }}" },
                       { binding: 'dataJuchuKbnName', header: "{{ __('juchu_kbn') }}" },
                       { binding: 'dataStartDate', header: "{{ __('yukoukikan_start_date') }}" },
                       { binding: 'dataEndDate', header: "{{ __('yukoukikan_end_date') }}" }];
        {{-- 現在のグリッドの並び替え条件取得 --}}
        let sortState = gridMaster.collectionView.sortDescriptions.map(
            function (sd)
            {
                {{-- 並び替え条件をオブジェクト配列として返す --}}
                return { property: sd.property, ascending: sd.ascending }
            }
        );
        {{-- CSV出力時の並び替え条件を設定 --}}
        let sortDesc = new wijmo.collections.SortDescription(sortState[0].property, sortState[0].ascending);
        {{-- CSVファイル作成
             ※ファイル名は「ページタイトル+yyyymmddhhMMss（年月日時分秒）+.csv」
             ※common_function.js参照 --}}
        ExportCSVFile(gridMaster.itemsSource, columns, sortDesc, '{{ $pageTitle }}'+ getNowDateTime() +'.csv');
    }
    {{-- 「新規・参照新規・修正・削除」ボタンイベント
         ※mode → 入力ダイアログの操作、新規・修正・削除のどの処理で開いたかを判別する処理種別
         　copy → 参照新規や修正などで選択行のレコード情報を初期入力させるかの判定 --}}
    var fncNyuryokuData = function(mode, copy)
    {
        {{-- 入力フォーム要素 --}}
        let nyuryokuData = document.forms['frmNyuryoku'].elements;
        {{-- 選択行のグリッドデータ --}}
        let data = gridMaster.collectionView.currentItem;
        {{-- 「新規」処理フラグ --}}
        let insertFlg = (mode == MODE_INSERT);

        {{-- 「処理種別」 --}}
        nyuryokuData['dataSQLType'].value = mode;
        {{-- 「受注日」 --}}
        dateJuchu.value = !insertFlg ? data['dataJuchuDate'] : getNowDate();
        {{-- 「受注No」 --}}
        nyuryokuData['dataJuchuNo'].value = (copy && !insertFlg) ? data['dataJuchuNo'] : '';
        nyuryokuData['dataJuchuNo'].disabled = !insertFlg;
        {{-- 「得意先CD」 --}}
        nyuryokuData['dataTokuisakiCd'].value = copy ? data['dataTokuisakiCd'] : '';   
        {{-- 「得意先名」 --}}
        nyuryokuData['dataTokuisakiName'].value = copy ? data['dataTokuisakiName'] : '';
        {{-- 「納入先CD」 --}}
        nyuryokuData['dataNounyusakiCd'].value = copy ? data['dataNounyusakiCd'] : '';   
        {{-- 「納入先名」 --}}
        nyuryokuData['dataNounyusakiName'].value = copy ? data['dataNounyusakiName'] : '';
        {{-- 「営業担当CD」 --}}
        nyuryokuData['dataEigyouCd'].value = copy ? data['dataEigyouCd'] : '';   
        {{-- 「営業担当名」 --}}
        nyuryokuData['dataEigyouName'].value = copy ? data['dataEigyouName'] : '';
        {{-- 「アシスタントCD」 --}}
        nyuryokuData['dataAssistantCd'].value = copy ? data['dataAssistantCd'] : '';   
        {{-- 「アシスタント名」 --}}
        nyuryokuData['dataAssistantName'].value = copy ? data['dataAssistantName'] : '';
        {{-- 「客先注番1」 --}}
        nyuryokuData['dataChumonNo1'].value = copy ? data['dataChumonNo1'] : '';
        {{-- 「客先注番2」 --}}
        nyuryokuData['dataChumonNo2'].value = copy ? data['dataChumonNo2'] : '';
        {{-- 「客先注番3」 --}}
        nyuryokuData['dataChumonNo3'].value = copy ? data['dataChumonNo3'] : '';
        {{-- 「品目CD」 --}}
        nyuryokuData['dataHinmokuCd'].value = copy ? data['dataHinmokuCd'] : '';   
        {{-- 「品目名」 --}}
        nyuryokuData['dataHinmokuName'].value = copy ? data['dataHinmokuName'] : '';
        {{-- 「単位CD」 --}}
        nyuryokuData['dataTaniCd'].value = copy ? data['dataTaniCd'] : '';   
        {{-- 「単位名」 --}}
        nyuryokuData['dataTaniName'].value = copy ? data['dataTaniName'] : '';
        {{-- 「希望納期」 --}}
        dateNouki.value = !insertFlg ? data['dataNoukiDate'] : null;
        {{-- 「出荷予定日」 --}}
        dateShukka.value = !insertFlg ? data['dataShukkaDate'] : null;
        {{-- 「受注数量」 --}}
        numJuchuQty.value = copy ? data['dataJuchuQty'] : 0;
        {{-- 「受注単価」 --}}
        numJuchuTanka.value = copy ? data['dataJuchuTanka'] : 0;
        {{-- 「受注金額」 --}}
        numJuchuKin.value = copy ? data['dataJuchuKin'] : 0;
        {{-- 「仮単価区分」 --}}
        cmbKaritankaKbn.selectedIndex = copy ? data['dataKaritankaKbn'] : 0;
        {{-- 「受注区分」 --}}
        cmbJuchuKbn.selectedIndex = copy ? juchuKbnCd.indexOf(data['dataJuchuKbn']) : 0;
        {{-- 「配送便CD」 --}}
        nyuryokuData['dataHaisoubinCd'].value = copy ? data['dataHaisoubinCd'] : '';   
        {{-- 「配送便名」 --}}
        nyuryokuData['dataHaisoubinName'].value = copy ? data['dataHaisoubinName'] : '';
        {{-- 「備考1」 --}}
        nyuryokuData['dataNote1'].value = copy ? data['dataNote1'] : '';
        {{-- 「備考2」 --}}
        nyuryokuData['dataNote2'].value = copy ? data['dataNote2'] : '';
        {{-- 「備考3」 --}}
        nyuryokuData['dataNote3'].value = copy ? data['dataNote3'] : '';
        {{-- 「有効期間（自）」--}}
        dateStart.value = !insertFlg ? data['dataStartDate'] : getNowDate();
        {{-- 「登録日時」 --}}
        nyuryokuData['dataTourokuDt'].value = !insertFlg ? data['dataTourokuDt'] : '';
        {{-- 「更新日時」 --}}
        nyuryokuData['dataKoushinDt'].value = !insertFlg ? data['dataKoushinDt'] : '';
        
        {{-- 「削除」処理フラグ
             ※削除処理時は入力機能を制限して閲覧のみにする --}}
        let deleteFlg = (mode == MODE_DELETE);
        {{-- レコードID ※削除時のみ必要 --}}
        nyuryokuData['dataId'].value = deleteFlg ? data['dataId'] : '';
        {{-- 検索ボタン ※削除時のみ制限 --}}
        nyuryokuData['btnSanshou'].disabled = deleteFlg;
        {{-- リセットボタン ※削除時のみ制限 --}}
        nyuryokuData['btnReset'].disabled = deleteFlg;
        {{-- 在庫照会ボタン ※削除時のみ制限 --}}
        nyuryokuData['btnZaikoShoukai'].disabled = deleteFlg;
        dateJuchu.isDisabled = deleteFlg;    {{-- 「受注日」 --}} 
        nyuryokuData['dataTokuisakiCd'].disabled = deleteFlg;  {{-- 「得意先CD」 --}}
        nyuryokuData['dataNounyusakiCd'].disabled = deleteFlg; {{-- 「納入先CD」 --}}
        nyuryokuData['dataEigyouCd'].disabled = deleteFlg; {{-- 「営業担当CD」 --}}
        nyuryokuData['dataAssistantCd'].disabled = deleteFlg; {{-- 「アシスタントCD」 --}}
        nyuryokuData['dataChumonNo1'].disabled = deleteFlg; {{-- 「客先注番1」 --}}
        nyuryokuData['dataChumonNo2'].disabled = deleteFlg; {{-- 「客先注番2」 --}}
        nyuryokuData['dataChumonNo3'].disabled = deleteFlg; {{-- 「客先品番」 --}}
        nyuryokuData['dataHinmokuCd'].disabled = deleteFlg; {{-- 「品目CD」 --}}
        nyuryokuData['dataTaniCd'].disabled = deleteFlg; {{-- 「単位CD」 --}}
        dateNouki.isDisabled = deleteFlg;    {{-- 「希望納期」 --}} 
        dateShukka.isDisabled = deleteFlg;    {{-- 「出荷予定日」 --}} 
        numJuchuQty.isDisabled = deleteFlg;    {{-- 「受注数量」 --}} 
        numJuchuTanka.isDisabled = deleteFlg;    {{-- 「受注単価」 --}} 
        cmbKaritankaKbn.isDisabled = deleteFlg; {{-- 「仮単価区分」 --}}
        cmbJuchuKbn.isDisabled = deleteFlg; {{-- 「受注区分」 --}}
        nyuryokuData['dataHaisoubinCd'].disabled = deleteFlg; {{-- 「配送便CD」 --}}
        nyuryokuData['dataNote1'].disabled = deleteFlg; {{-- 「備考1」 --}}
        nyuryokuData['dataNote2'].disabled = deleteFlg; {{-- 「備考2」 --}}
        nyuryokuData['dataNote3'].disabled = deleteFlg; {{-- 「備考3」 --}}
        dateStart.isDisabled = deleteFlg;    {{-- 「有効期間（自）」 --}}

        {{-- ボタンのキャプション --}}
        let btnCaption = ["{{ __('登録') }}","{{ __('更新') }}","{{ __('削除') }}"];
        nyuryokuData['btnKettei'].value = "{{__('F9')}}" + btnCaption[mode - 1];

        {{-- 入力フォームのスタイル初期化 ※common_function.js参照　--}}
        InitFormStyle();
    }

    {{-- ----------------------------- --}}
    {{-- 非同期処理呼び出し養用の関数変数 --}}
    {{-- ----------------------------- --}}
    {{-- ※data → 非同期通信で受信したjsonデータ配列
         　errorFlg → 非同期通信先のエラー処理判定 --}}

    {{-- 受注区分取得 --}}
    var fncJushinJuchuKbnData = function(data, errorFlg)
    {
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(IsAjaxDataError(data, errorFlg)) return;
        {{-- カテゴリー配列作成 --}}
        let juchuKbnData = data[1];
        for(let i = 0; i < juchuKbnData.length; i++)
        {
            juchuKbn.push(juchuKbnData[i].dataSentakuName);
            juchuKbnCd.push(juchuKbnData[i].dataSentakuCd);
        }
        {{-- コンボボックスの更新 --}}
        cmbJuchuKbn.itemsSource = juchuKbn;
    }

    {{-- データグリッド更新 --}}
    var fncJushinGridData = function(data, errorFlg)
    {
        {{-- 「データ更新中」非表示 --}}
        ClosePopupDlg();
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(IsAjaxDataError(data, errorFlg)) return;
        {{-- ボタン制御更新 --}}
        SetEnableButton(data[1].length);
        {{-- グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 --}}
        SortGridData(gridMaster, data[1], 'dataJuchuNo', 1);
    }

    {{-- 検索件数更新 --}}
    var fncJushinDataCnt = function(data, errorFlg)
    {
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(IsAjaxDataError(data, errorFlg)) return;
        {{-- 件数更新 --}}
        $("#zenkenCnt").html(data[1]);
    }

    {{-- DBデータ更新 --}}
    var fncUpdateData = function(data, errorFlg)
    {
        {{-- 「データ更新中」非表示 --}}
        ClosePopupDlg();
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(!IsAjaxDataError(data, errorFlg))
        {
            {{-- 「データ更新完了」表示 --}}
            ShowAlertDlg('データ更新完了');
            {{-- 選択行のデータIDを保持 ※common_function.js参照 --}}
            SetSelectedRowId(data[2][0]);
            {{-- 入力ダイアログを閉じる --}}
            CloseNyuryokuDlg();
            {{-- グリッドデータの表示 --}}
            $('#btnHyouji').click();
        }
        else
        {
            {{-- エラー時処理 --}}
            {{-- データ判定対象要素 --}}
            let targetElement = data[2];
            {{-- 対象要素のCSSテキスト --}}
            let classText = '';
            {{-- 対象要素のCSSテキストを書き換える
                 ※コード検査を行う項目は、スタイルクラス「code-check」が宣言されている --}}
            for(let i=0; i<$('.code-check').length; i++)
            {
                {{-- 対象要素のCSSテキストを取得 --}}
                classText = $('.code-check')[i].className;
                {{-- 既にエラー表示の対象要素をリセット --}}
                $('.code-check')[i].className = classText.replace('code-check-error', '');
                for(let j=0;j<targetElement.length;j++)
                {
                    {{-- 対象要素であるか判定 --}}
                    if($('.code-check')[i].name == targetElement[j])
                    {
                        {{-- エラー判定の対象要素のスタイルクラスに「code-check-error」を付与して強調表示（赤枠） --}}
                        $('.code-check')[i].className = classText + ' code-check-error';       
                    }
                }
            }
        }
    }

    {{-- ------------------------ --}}
    {{-- その他入力コントロール処理 --}}
    {{-- ------------------------ --}}

    {{-- 検索受注日処理 --}}
    function CheckJuchuDate(){
        let startDate = Date.parse(dateJuchuStart.value);
        let endDate = Date.parse(dateJuchuEnd.value);
        if(startDate > endDate) dateJuchuEnd.value = dateJuchuStart.value;
    }

    {{-- 検索納期処理 --}}
    function CheckNoukiDate(){
        let startDate = Date.parse(dateNoukiStart.value);
        let endDate = Date.parse(dateNoukiEnd.value);
        if(startDate > endDate) dateNoukiEnd.value = dateNoukiStart.value;
    }

    {{-- 受注金額合計処理 --}}
    function SumJuchuKin(){
        numJuchuKin.value = numJuchuQty.value * numJuchuTanka.value;
    }

    {{-- 「リセット」ボタン　クリック処理 --}}
    $('#btnReset').click(function() {
        {{-- 処理別ボタン処理を実行 --}}
        if(document.forms['frmNyuryoku'].elements['dataSQLType'].value == MODE_INSERT){
            fncNyuryokuData(MODE_INSERT, false);
        }else{
            fncNyuryokuData(MODE_UPDATE, true);
        }
    });

    {{-- 「在庫照会」ボタン　クリック処理 --}}
    $('#btnZaikoShoukai').click(function() {
        console.log('在庫照会');
        /*在庫照会の機能の処理を記述*/
    });

    {{-- 得意先変更時に連動する納入先要素のリセット処理 --}}
    $('#dataTokuisakiCd').change(function() {
        $('#dataNounyusakiCd')[0].value = '';
        $('#dataNounyusakiName')[0].value = '';
    });

    {{-- 入力ダイアログ　「決定」ボタン　クリック処理 --}}
    $('#frmNyuryoku').submit(function(event)
    {
        {{-- 関数内関数 --}}
        {{-- 編集ダイアログ入力値変更判定 --}}
        function IsChangeNyuryokuData(nyuryokuData)
        {
            {{-- 選択行のグリッドデータ --}}
            let data = gridMaster.collectionView.currentItem;
            {{-- 更新処理以外の処理の場合は判定せずにtrue --}}
            if(nyuryokuData['dataSQLType'].value != MODE_UPDATE) return true;
            {{-- 「受注日」 --}}
            if((nyuryokuData['dataJuchuDate'].value != data['dataJuchuDate'])) return true;
            {{-- 「得意先CD」 --}}
            if((nyuryokuData['dataTokuisakiCd'].value != data['dataTokuisakiCd']) &&
              !(nyuryokuData['dataTokuisakiCd'].value == '' && data['dataTokuisakiCd'] == null)) return true;
            {{-- 「納入先CD」 --}}
            if((nyuryokuData['dataNounyusakiCd'].value != data['dataNounyusakiCd']) &&
              !(nyuryokuData['dataNounyusakiCd'].value == '' && data['dataNounyusakiCd'] == null)) return true;
            {{-- 「営業担当CD」 --}}
            if((nyuryokuData['dataEigyouCd'].value != data['dataEigyouCd']) &&
              !(nyuryokuData['dataEigyouCd'].value == '' && data['dataEigyouCd'] == null)) return true;
            {{-- 「アシスタントCD」 --}}
            if((nyuryokuData['dataAssistantCd'].value != data['dataAssistantCd']) &&
              !(nyuryokuData['dataAssistantCd'].value == '' && data['dataAssistantCd'] == null)) return true;
            {{-- 「客先注番1」 --}}
            if((nyuryokuData['dataChumonNo1'].value != data['dataChumonNo1']) &&
              !(nyuryokuData['dataChumonNo1'].value == '' && data['dataChumonNo1'] == null)) return true;
            {{-- 「客先注番2」 --}}
            if((nyuryokuData['dataChumonNo2'].value != data['dataChumonNo2']) &&
              !(nyuryokuData['dataChumonNo2'].value == '' && data['dataChumonNo2'] == null)) return true;
            {{-- 「客先注番3」 --}}
            if((nyuryokuData['dataChumonNo3'].value != data['dataChumonNo3']) &&
              !(nyuryokuData['dataChumonNo3'].value == '' && data['dataChumonNo3'] == null)) return true;
            {{-- 「品目CD」 --}}
            if((nyuryokuData['dataHinmokuCd'].value != data['dataHinmokuCd']) &&
              !(nyuryokuData['dataHinmokuCd'].value == '' && data['dataHinmokuCd'] == null)) return true;
            {{-- 「単位CD」 --}}
            if((nyuryokuData['dataTaniCd'].value != data['dataTaniCd']) &&
              !(nyuryokuData['dataTaniCd'].value == '' && data['dataTaniCd'] == null)) return true;
            {{-- 「希望納期」 --}}
            if((nyuryokuData['dataNoukiDate'].value != data['dataNoukiDate']) &&
              !(nyuryokuData['dataNoukiDate'].value == '' && data['dataNoukiDate'] == null)) return true;
            {{-- 「出荷予定日」 --}}
            if((nyuryokuData['dataShukkaDate'].value != data['dataShukkaDate']) &&
              !(nyuryokuData['dataShukkaDate'].value == '' && data['dataShukkaDate'] == null)) return true;
            {{-- 「受注数量」 --}}
            if((nyuryokuData['dataJuchuQty'].value != data['dataJuchuQty'])) return true;
              console.log(i++);
            {{-- 「受注単価」 --}}
            if((nyuryokuData['dataJuchuTanka'].value != data['dataJuchuTanka'])) return true;
            {{-- 「受注金額」 --}}
            if((nyuryokuData['dataJuchuKin'].value != data['dataJuchuKin'])) return true;
            {{-- 「仮単価区分」 --}}
            if(cmbKaritankaKbn.selectedIndex != data['dataKaritankaKbn']) return true;
            {{-- 「受注区分」 --}}
            if(juchuKbnCd[cmbJuchuKbn.selectedIndex] != data['dataJuchuKbn']) return true;
            {{-- 「配送便CD」 --}}
            if((nyuryokuData['dataHaisoubinCd'].value != data['dataHaisoubinCd']) &&
              !(nyuryokuData['dataHaisoubinCd'].value == '' && data['dataHaisoubinCd'] == null)) return true;
            {{-- 「備考1」 --}}
            if((nyuryokuData['dataNote1'].value != data['dataNote1']) &&
              !(nyuryokuData['dataNote1'].value == '' && data['dataNote1'] == null)) return true;
            {{-- 「備考2」 --}}
            if((nyuryokuData['dataNote2'].value != data['dataNote2']) &&
              !(nyuryokuData['dataNote2'].value == '' && data['dataNote2'] == null)) return true;
            {{-- 「備考3」 --}}
            if((nyuryokuData['dataNote3'].value != data['dataNote3']) &&
              !(nyuryokuData['dataNote3'].value == '' && data['dataNote3'] == null)) return true;
            {{-- 上記項目に変更が無い場合はfalse --}}
            return false;
        }

        {{-- HTMLでの送信をキャンセル --}}
        event.preventDefault();
        {{-- 入力フォーム要素 --}}
        let nyuryokuData = document.forms['frmNyuryoku'].elements;
        {{-- 「データチェック中」表示 --}}
        ShowPopupDlg("{{ __('データチェック中') }}");
        {{-- データ更新判定
             ※修正処理の際、変更箇所が無い場合は更新処理をしない --}}
        if(!IsChangeNyuryokuData(nyuryokuData))
        {
            {{-- エラーメッセージ表示 --}}
            ShowAlertDlg("{{__('更新されたデータがありません')}}");
            {{-- 「データチェック中」非表示 --}}
            ClosePopupDlg();
            return;
        }
        {{-- 受注数量 --}}
        nyuryokuData['dataJuchuQty'].value = numJuchuQty.value;
        {{-- 受注単価 --}}
        nyuryokuData['dataJuchuTanka'].value = numJuchuTanka.value;
        {{-- 受注金額 --}}
        nyuryokuData['dataJuchuKin'].value = numJuchuKin.value;
        {{-- 仮単価区分のコンボボックスの値取得 --}}
        nyuryokuData['dataKaritankaKbn'].value = cmbKaritankaKbn.selectedIndex;
        {{-- 受注区分のコンボボックスの値取得 --}}
        nyuryokuData['dataJuchuKbn'].value = juchuKbnCd[cmbJuchuKbn.selectedIndex];
        {{-- POST送信用オブジェクト配列 --}}
        let soushinData = {};
        {{-- フォーム要素から送信データを格納 --}}
        for(var i = 0; i< nyuryokuData.length; i++){
            {{-- フォーム要素のnameが宣言されている要素のみ処理 --}}
            if(nyuryokuData[i].name != ''){
                {{-- フォーム要素のnameを配列のキーしてPOSTデータの値を作成する --}}
                soushinData[nyuryokuData[i].name] = nyuryokuData[i].value;
            }
        }
        {{-- 「データチェック中」非表示 --}}
        ClosePopupDlg();
        {{-- 削除処理時、確認ダイアログを表示 --}}
        if(nyuryokuData['dataSQLType'].value == MODE_DELETE)
        {
            {{-- 確認ダイアログを経由して処理 --}}
            ShowConfirmDlg("このレコードを削除しますか？",
            {{-- OKボタンを押したときの処理 --}}
            function()
            {
                {{-- 「データ更新中」表示 --}}
                ShowPopupDlg("{{__('データ更新中')}}");
                {{-- 非同期データ更新開始 --}}
                AjaxData("{{ url('/juchu/3801') }}", soushinData, fncUpdateData);
            }, null);
        }
        else
        {
            {{-- 「データ更新中」表示 --}}
            ShowPopupDlg("{{__('データ更新中')}}");
            {{-- 非同期データ更新開始 --}}
            AjaxData("{{ url('/juchu/3801') }}", soushinData, fncUpdateData);
        }
    });

    {{-- テキスト変更時に連動するテキスト要素のリセット処理 --}}
    $('input[type="text"]').change(function() {
        {{-- 連動テキスト要素のある要素を判別 --}}
        switch($(this)[0].name)
        {
            {{-- 得意先CD --}}
            case 'dataTokuisakiCd':
            break;
            {{-- 納入先CD --}}
            case 'dataNounyusakiCd':
            break;
            {{-- 営業担当CD --}}
            case 'dataEigyouCd':
            break;
            {{-- アシスタントCD --}}
            case 'dataAssistantCd':
            break;
            {{-- 品目CD --}}
            case 'dataHinmokuCd':
            break;
            {{-- 単位CD --}}
            case 'dataTaniCd':
            break;
            {{-- 配送便CD --}}
            case 'dataHaisoubinCd':
            break;
            {{-- 該当しない場合は処理終了 --}}
            default: return;
            break;
        }
        let targetElement = $(this).parent().next("input")[0];
        {{-- 連動テキスト要素が存在し、かつテキストの変更不可の要素である場合は処理 --}}
        if(targetElement && targetElement.readOnly) targetElement.value = '';
    });

    {{-- クリックされた直近の要素（コード系） --}}
    var currentCdElement = null;
    {{-- クリックされた直近の要素（名前系） --}}
    var currentNameElement = null;

    {{-- テキスト要素にフォーカスを当てた時の処理 --}}
    $('input[type="text"]').on("focusin", function(e) {
        {{-- フォーカスした要素を格納（コード系） --}}
        currentCdElement = $(':focus')[0];
        {{-- フォーカスした要素の親要素の次にある要素を格納（名前系） --}}
        currentNameElement = $(this).parent().next("input")[0];
    });
    {{-- 「参照」ボタンアイコン　クリック処理 --}}
    $('.search-btn').click(function() {
        {{-- フォーカスした要素の前の要素を格納（コード系） --}}
        currentCdElement = $(this).prev("input")[0];
        {{-- フォーカスした要素の親要素の次にある要素を格納（名前系） --}}
        currentNameElement = $(this).parent().next("input")[0];
        {{-- 参照ボタン処理を実行 --}}
        $('.btnSanshou').click();
    });
    {{-- 「参照」ボタン　クリック処理 --}}
    $('.btnSanshou').click(function() {
        {{-- 処理種別が「削除」の場合は処理をスキップ --}}
        if(currentCdElement.disabled) return;
        {{-- 対象日 --}}
        let targetDate = null;
        {{-- 入力ダイアログが開かれている場合は対象日取得 --}}
        if(IsVisibleNyuryoku()){
            targetDate = document.forms['frmNyuryoku'].elements['dataJuchuDate'].value;
        }
        {{-- 選択対象の名前を判別 --}}
        switch(currentCdElement.name)
        {
            {{-- 得意先CD --}}
            case 'dataTokuisakiCd':
            ShowSentakuDlg("{{ __('tokuisaki_cd') }}", "{{ __('tokuisaki_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1400') }}", targetDate);
            break;
            {{-- 納入先CD --}}
            case 'dataNounyusakiCd':
            ShowSentakuDlg("{{ __('nounyusaki_cd') }}", "{{ __('nounyusaki_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1600') }}", targetDate,
                           document.forms['frmNyuryoku'].elements['dataTokuisakiCd'].value);
            break;
            {{-- 営業担当CD --}}
            case 'dataEigyouCd':
            ShowSentakuDlg("{{ __('eigyou_tantousha_cd') }}", "{{ __('eigyou_tantousha_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0400') }}", targetDate,
                           document.forms['frmNyuryoku'].elements['dataAssistantCd'].value);
            break;
            {{-- アシスタントCD --}}
            case 'dataAssistantCd':
            ShowSentakuDlg("{{ __('assistant_cd') }}", "{{ __('assistant_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0400') }}", targetDate,
                           document.forms['frmNyuryoku'].elements['dataEigyouCd'].value);
            break;
            {{-- 品目CD --}}
            case 'dataHinmokuCd':
            ShowSentakuDlg("{{ __('hinmoku_cd') }}", "{{ __('hinmoku_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/2600') }}", targetDate);
            break;
            {{-- 単位CD --}}
            case 'dataTaniCd':
            ShowSentakuDlg("{{ __('tani_cd') }}", "{{ __('tani_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}", targetDate, "TANI");
            break;
            {{-- 配送便CD --}}
            case 'dataHaisoubinCd':
            ShowSentakuDlg("{{ __('haisoubin_cd') }}", "{{ __('haisoubin_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}", targetDate, "HAISOUBIN");
            break;
        }
    });
</script>
@endsection