{{-- PHP処理 --}}
<?php

    // 「loginId」が送信されていなければ0を設定
    if(!isset($loginId)) $loginId = 0;

    // 検索フォームの高さ
    $kensakuHight = '120px';
?>

{{-- 共通レイアウト呼び出し --}}
{{--「base_master.blede.php」・・・マスタ画面の共通テンプレートデザイン --}}
@extends('templete.header.master.base_master')

{{-- 「検索フォーム」 --}}
@section('kensaku')
{{-- 検索フォーム全体 --}}
<form id="frmKensaku" name="frmKensaku" class="flex-box" style="height:{{ $kensakuHight }};">
    {{-- 一列目 --}}
    <div class="form-column">
    {{-- 「構成親品目CD」 --}}
        <label>
            <span style="width:7.5em;">{{__('kousei_oya_hinmoku_cd')}}</span>
            <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                <input name="dataSeikyusakiCd" class="form-control" type="text"
                        maxlength="10" autocomplete="off" style="width:8em;">
                {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                <i class="fas fa-search search-btn"></i>
            </span>
            {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
            <input name="dataSeikyusakiName" class="form-control" type="text"
                    style="width:22em;" onfocus="blur();" readonly>
        </label>
        {{-- 「構成子品目CD」 --}}
        <label>
            <span style="width: 7.5em;">{{__('kousei_hinmoku_cd')}}</span>
            <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                <input name="dataSeikyusakiCd" class="form-control" type="text"
                        maxlength="10" autocomplete="off" style="width:8em;">
                {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                <i class="fas fa-search search-btn"></i>
            </span>
            {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
            <input name="dataSeikyusakiName" class="form-control" type="text"
                    style="width:22em;" onfocus="blur();" readonly>
        </label>
    </div>
    {{-- 二列目 --}}
    <div class="form-column">
        {{-- 「得意先CD」 --}}
        <label>
            <span style="width: 6.6em;">{{__('tokuisaki_cd')}}</span>
            <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                <input name="dataSeikyusakiCd" class="form-control" type="text"
                        maxlength="10" autocomplete="off" style="width:8em;">
                {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                <i class="fas fa-search search-btn"></i>
            </span>
            {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
            <input name="dataSeikyusakiName" class="form-control" type="text"
                    style="width:22em;" onfocus="blur();" readonly>
        </label>
        {{-- 「有効期間（自）」 --}}
        <label>
            <span>{{__('yukoukikan_start_date')}}</span>
            <input id="dataStartDate" name="dataStartDate" type="hidden">
        </label>
    </div>
    {{-- 表示件数 --}}
    <div class="flex-box flex-end item-end" style="width:100%;">
        <div class="base-color-front" style="color:black;">
            <span id="zenkenCnt" style="margin: 0 10px;"></span>{{__('件')}}{{__('を表示')}}
        </div>
    </div>
</form>
@endsection

{{-- 「入力ダイアログ」 --}}
@section('nyuryoku')
{{-- 入力フォーム全体 --}}
<h4 style="padding: 10px 0 0 10px;">構成マスター登録</h4>
<div class="flex-box item-start" style="padding: 0px 0 20px 20px; margin: 0;">
    <div class="flex-box flex-center flex-column item-start" style="padding: 0 25px 0 0;">
        {{-- 「階層レベル」 --}}
        <label>
            <span style="width:6.7em;">{{__('tokuisaki_cd')}}</span>
            {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
            <input name="dataTokuisakiCd" class="form-control code-check" type="text"
                    maxlength="10" autocomplete="off" style="width:12em;" required>
        </label>
        {{-- 「構成品目CD」 --}}
        <label>
            <span style="width:7em;">{{__('tokuisaki_name1')}}</span>
            <input name="dataTokuisakiName1" class="form-control" type="text"
                    maxlength="30" autocomplete="off" style="width:20em;">
        </label>
        {{-- 「レビジョン」 --}}
        <label>
            <span style="width:7em;">{{__('tokuisaki_name2')}}</span>
            <input name="dataTokuisakiName2" class="form-control" type="text"
                    maxlength="30" autocomplete="off" style="width:20em;" >
        </label>
        
    </div>
    <div class="flex-box flex-center flex-column item-start" style="margin: 0 0 0 0">
        {{-- 「部品SEQNO」 --}}
        <label>
            <span style="width:7em;">{{__('tokuisaki_kana')}}</span>
            <input name="dataTokuisakiKana" class="form-control" type="text"
                    maxlength="60" autocomplete="off" style="width:15em;">
        </label>
        {{-- 「構成品目名（CDから辿る？）」 --}}
        <label>
            <span style="width:7em;">{{__('senpou_renrakusaki')}}</span>
            <input name="dataSenpouRenrakusaki" class="form-control" type="text"
                    maxlength="128" autocomplete="off" style="width:10em;">
        </label>
    </div>
</div>
<div class="tabs">
    <input id="denpyou" type="radio" name="tab_item">
    <label class="tab_item" for="denpyou"style="width:17em;">構成品目</label>
    <input id="seikyu" type="radio" name="tab_item"checked>
    <label class="tab_item" for="seikyu"style="width:17em;">手順設定</label>
    <input id="sonota" type="radio" name="tab_item">
    <label class="tab_item" for="sonota"style="width:17em;">他設定</label>
    <input id="oyazumen" type="radio" name="tab_item">
    <label class="tab_item" for="oyazumen"style="width:17em;">親図面</label>
    <input id="kozumen" type="radio" name="tab_item">
    <label class="tab_item" for="kozumen"style="width:17em;">子図面</label>
    <div class="tab_content" id="denpyou_content">
        <div class="tab_content_description">
            <div class="flex-box flex-between item-start">
                <div class="flex-box flex-center flex-column item-start"style="margin: 0 0 0 20">
                    <div id="gridMaster" style="width:100%; height:calc(100% - {{$kensakuHight}});"></div>
                    {{-- 「フォーム」 --}}
                    <div class="flex-box flex-center flex-column item-start"> 
                        <div id="gridMasterKouseiHinmoku" style="width:94%; height: 500px;"></div>
                    </div>
                    {{-- 「納品書見出区分」 --}}
                    <label>
                        <span style="width:7em;">{{__('nouhinsho_midashi_kbn')}}</span>
                        {{-- 「」コンボボックス本体 --}}
                        <div id="cmbNouhinshoMidashiKbn" style="width:18em;"></div>
                        {{-- 「」フォーム送信データ --}}
                        <input name="dataNouhinshoMidashiKbn" type="hidden">
                    </label>
                </div>
                <div class="flex-box flex-center flex-column item-start"style="margin: 0 300px 0 0">
                    {{-- 「消費税計算単位」 --}}
                    <label>
                        <span style="width:7.5em;">{{__('shohizei_keisan_tani')}}</span>
                        {{-- 「」コンボボックス本体 --}}
                        <div id="cmbShouhizeiKeisanTani" style="width:10em;"></div>
                        {{-- 「」フォーム送信データ --}}
                        <input name="dataShohizeiKeisanTani" type="hidden">
                    </label>
                    {{-- 「消費税計算方式」 --}}
                    <label>
                        <span style="width:7.5em;">{{__('shohizei_keisan_houshiki')}}</span>
                        {{-- 「」コンボボックス本体 --}}
                        <div id="cmbShohizeiKeisanHoushiki" style="width:10em;"></div>
                        {{-- 「」フォーム送信データ --}}
                        <input name="dataShohizeiKeisanHoushiki" type="hidden">
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="tab_content" id="seikyu_content">
        <div class="tab_content_description">
            {{-- 「フォーム」 --}}
            <div class="flex-box flex-center flex-column item-start"> 
                <div id="gridMasterKouzyun" style="width:94%; height: 500px;"></div>
            </div>
            <div class="form-column"style="margin: 0 0 0 20">
                {{-- 「請求先取引区分」 --}}
                <label>
                <span style="width:8.5em;">{{__('seikyusaki_torihiki_kbn')}}</span>
                    {{-- 「」コンボボックス本体 --}}
                    <div id="cmbSeikyusakiTorihikiKbn" style="width:18em;"></div>
                    {{-- 「」フォーム送信データ --}}
                    <input name="dataSeikyusakiTorihikiKbn" type="hidden">
                </label>
            </div>
            <div class="flex-box flex-between item-start">
                <div class="flex-box flex-center flex-column item-start"style="margin: 0 0 0 20">
                    {{-- 「締日1」 --}}
                    <label>
                        <span style="width:8.5em;">{{__('shime_day1')}}</span>
                        {{-- 「」コンボボックス本体 --}}
                        <div id="cmbShimeDay1" style="width:10em;"></div>
                        {{-- 「」フォーム送信データ --}}
                        <input name="dataShimeDay1" type="hidden">
                    </label>
                    {{-- 「締日2」 --}}
                    <label>
                        <span style="width:8.5em;">{{__('shime_day2')}}</span>
                        {{-- 「」コンボボックス本体 --}}
                        <div id="cmbShimeDay2" style="width:10em;"></div>
                        {{-- 「」フォーム送信データ --}}
                        <input name="dataShimeDay2" type="hidden">
                    </label>
                    {{-- 「適用月（締日２）」 --}}
                    <label>
                        <span style="width:8.5em;">{{__('tekiyou_tsuki')}}</span>
                        {{-- 「」コンボボックス本体 --}}
                        <div id="cmbTekiyouTsuki" style="width:10em;"></div>
                        {{-- 「」フォーム送信データ --}}
                        <input name="dataTekiyouTsuki" type="hidden">
                    </label>          
                </div>
                <div class="flex-box flex-center flex-column item-start"style="margin: 0 300 0 0">        
                    {{-- 「入金予定月1」 --}}
                    <label>
                        <span id="displayNyukinTsuki1"style="width:7em;">{{__('nyukin_tsuki')}}</span>
                        {{-- 「」コンボボックス本体 --}}
                        <div id="cmbNyukinTsuki1" style="width:10em;"></div>
                        {{-- 「」フォーム送信データ --}}
                        <input name="dataNyukinTsuki1" type="hidden">
                    </label>
                    {{-- 「入金日1」 --}}
                    <label>
                        <span id="displayNyukinDay1"style="width:7em;">{{__('nyukin_day1')}}</span>
                        {{-- 「」コンボボックス本体 --}}
                        <div id="cmbNyukinDay1" style="width:10em;"></div>
                        {{-- 「」フォーム送信データ --}}
                        <input name="dataNyukinDay1" type="hidden">
                    </label>          
                </div>
                <div class="display">
                    {{-- 「銀行CD」 --}}
                    <label>
                        <span style="width:7em;">{{__('ginkou_cd')}}</span>
                        <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                        <input name="dataGinkouCd" class="form-control code-check" type="text"
                            maxlength="8" autocomplete="off" style="width:8em;">
                            {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                            <i class="fas fa-search search-btn"></i>
                        </span>
                        {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                        <input name="dataGinkouName" class="form-control" type="text"
                                style="width:20em;" onfocus="blur();" readonly>
                    </label>
                    {{-- 「回収口座区分」 --}}
                    <label>
                        <span style="width:8.5em;">{{__('kaishukouza_kbn')}}</span>
                        {{-- 「」コンボボックス本体 --}}
                        <div id="cmbKaishukouzaKbn" style="width:10em;"></div>
                        {{-- 「」フォーム送信データ --}}
                        <input name="dataKaishukouzaKbn" type="hidden">
                    </label>
                    {{-- 「回収口座番号」 --}}
                    <label>
                        <span style="width:8.5em;">{{__('kaishukouza_no')}}</span>
                        <input name="dataKaishukouzaNo" class="form-control" type="text"
                        maxlength="20" autocomplete="off" style="width:10em;">
                    </label>
                    {{-- 「与信限度額」 --}}
                    <label>
                        <span style="width:8.5em;">{{__('yoshingendogaku')}}</span>
                        <input name="dataYoshingendogaku" class="form-control" type="text"
                            maxlength="20" autocomplete="off" style="width:10em;">
                    </label>
                </div>
                <div class="display">
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0 500 0 0;">
                        {{-- 「回収方法2」 --}}
                        <label>
                            <span id="displayKaishuhouhou2" style="width:1em;display:none;" >{{__('kaishuhouhou2')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbKaishuhouhou2" style="width:1em;display:none;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataKaishuhouhou2" type="hidden">
                        </label>
                        {{-- 「入金予定月2」 --}}
                        <label>
                            <span id="displayNyukinTsuki2" style="width:1em;display:none;">{{__('nyukin_tsuki2')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbNyukinTsuki2" style="width:1em;display:none;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataNyukinTsuki2" type="hidden">
                        </label>
                        {{-- 「入金日2」 --}}
                        <label>
                            <span id="displayNyukinDay2" style="width:1em;display:none;">{{__('nyukin_day2')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbNyukinDay2" style="width:1em;display:none;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataNyukinDay2" type="hidden">
                        </label>
                        {{-- 「手形サイト2」 --}}
                        <label>
                            <span id="displayTegataSate2" style="width:1em;display:none;">{{__('tegata_sate2')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbTegataSate2" style="width:1em;display:none;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataTegataSate2" type="hidden">
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab_content" id="sonota_content">
        <div class="tab_content_description">
            <div class="form-column"style="margin: 0 0 0 20">
                {{-- 「備考1」 --}}
                <input type="file" onChange="imgPreView(event)">
                <div id="preview"></div>
                <label>
                    <span style="width:10em;">{{__('bikou1')}}</span>
                    <input name="dataBikou1" class="form-control" type="text"
                        maxlength="30" autocomplete="off" style="width:30em;">
                </label>
            </div>
        </div>
    </div>
    <div class="tab_content" id="oyazumen_content">
        <div class="tab_content_description">
            <div class="form-column"style="margin: 0 0 0 20">
                {{-- 「備考1」 --}}
                <label>
                    <span style="width:10em;">{{__('bikou1')}}</span>
                    <input name="dataBikou1" class="form-control" type="text"
                        maxlength="30" autocomplete="off" style="width:30em;">
                </label>
            </div>
        </div>
    </div>
    <div class="tab_content" id="kozumem_content">
        <div class="tab_content_description">
            <div class="form-column"style="margin: 0 0 0 20">
                {{-- 「備考1」 --}}
                <label>
                    <span style="width:10em;">{{__('bikou1')}}</span>
                    <input name="dataBikou1" class="form-control" type="text"
                        maxlength="30" autocomplete="off" style="width:30em;">
                </label>
            </div>
        </div>
    </div>
</div>
<div class="flex-box"style="margin: 0 80px 0 0">
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
            <span style="width:6em;">{{__('touroku_dt')}}</span>
            <input name="dataTourokuDt" class="form-control-plaintext" type="text" readonly>
        </label>
    </div>
    <div class="form-column">
        {{-- 「更新日」 --}}
        <label>
            <span style="width:6em;">{{__('koushin_dt')}}</span>
            <input name="dataKoushinDt" class="form-control-plaintext" type="text" readonly>
        </label>
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
        function imgPreView(event) {
    var file = event.target.files[0];
    var reader = new FileReader();
    var preview = document.getElementById("preview");
    var previewImage = document.getElementById("previewImage");
    
    if(previewImage != null) {
        preview.removeChild(previewImage);
    }
    reader.onload = function(event) {
        var img = document.createElement("img");
        img.setAttribute("src", reader.result);
        img.setAttribute("id", "previewImage");
        preview.appendChild(img);
    };
    
    reader.readAsDataURL(file);
    }

    {{-- -------------------- --}}
    {{-- wijmoコントロール宣言 --}}
    {{-- -------------------- --}}

    {{-- 有効期間（自） --}}
    var dateStart = new wijmo.input.InputDate('#dataStartDate');

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

        {{-- グリッドデータの表示 --}}
        $('#btnHyouji').click();
    }
    {{-- グリッド共有変数 --}}
    var gridMaster;
    {{-- 選択された行
         ※MultiRowでの行選択処理のために必要（FlexGridでは不要） --}}
    var selectedRows = 0;
    {{-- グリッド初期処理--}}
    function InitGrid()
    {
        {{-- MultiRowのレイアウト設定 --}}
        let columns = [
            {
                {{-- 1列目 --}}
                cells: [
                    {
                        {{-- 「請求CD」 --}}
                        binding: 'dataSeikyuCd',
                        header: "{{ __('seikyu_cd') }}",
                        width: 100
                    }
                ]
            },
            {
                {{-- 2列目 --}}
                cells: [
                    {
                        {{-- 「請求部署名」 --}}
                        binding: 'dataSeikyuBushoName',
                        header: "{{ __('seikyu_busho_name') }}",
                        width: '1*'
                    }
                ]

            },
            {
                {{-- 3列目 --}}
                cells: [
                    {
                        {{-- 「郵便番号」 --}}
                        binding: 'dataSeikyuZip',
                        header : "{{ __('seikyu_zip') }}",
                        width  : '1*'
                    },
                    {
                        {{-- 「住所」 --}}
                        binding: 'dataSeikyuJusho',
                        header : "{{ __('seikyu_jusho') }}",
                        width  : '1*'
                    }
                ]
                
            },
            {
                {{-- 4列目 --}}
                cells: [
                    {
                        {{-- 「電話番号」 --}}
                        binding: 'dataTelNo',
                        header: "{{ __('tel_no') }}",
                        width: '1*'
                    },
                    {
                        {{-- 「FAX番号」 --}}
                        binding: 'dataFaxNo',
                        header: "{{ __('fax_no') }}",
                        width: '1*'
                    }
                ]

            },
            {
                {{-- 5列目 --}}
                cells: [
                    {
                        {{-- 「銀行１」 --}}
                        binding: 'dataGinkou1',
                        header: "{{ __('ginkou1') }}",
                        width: 150
                    },
                    {
                        {{-- 「銀行2」 --}}
                        binding: 'dataGinkou2',
                        header: "{{ __('ginkou2') }}",
                        width: 150
                    },
                    {
                        {{-- 「銀行3」 --}}
                        binding: 'dataGinkou3',
                        header: "{{ __('ginkou3') }}",
                        width: 150
                    }
                ]
            },
            {
                {{-- 6列目 --}}
                cells: [
                    {
                        {{-- 「有効期間（自）」 --}}
                        binding: 'dataStartDate',
                        header: "{{ __('yukoukikan_start_date') }}",
                        width: 150
                    }
                ]
            },
            {
                {{-- 7列目 --}}
                cells: [
                    {
                        {{-- 「有効期間（至）」 --}}
                        binding: 'dataEndDate',
                        header: "{{ __('yukoukikan_end_date') }}",
                        width: 150
                    }
                ]
            }
        ];
        {{-- グリッドの設定 --}}
        let gridOption = {
            {{-- レイアウト設定 ※MultiRow専用 --}}
            layoutDefinition: columns,
            {{-- 選択スタイル（セル単位） --}}
            selectionMode: wijmo.grid.SelectionMode.Cell,
            {{-- セル編集（無効） --}}
            isReadOnly: true,
            {{-- デフォルト行スタイル（0行ごとに色付け） --}}
            alternatingRowStep: 0,
            {{-- グリッド上でのEnterキーイベント（無効） --}}
            keyActionEnter: wijmo.grid.KeyAction.None,
            {{-- セル読み込み時のイベント --}}
            loadedRows: function(s, e)
            {
                {{-- 任意の色でセルを色付け
                     ※rowPerItemでMultiRowの1レコード当たりの行数を取得（今回はrowPerItem = 2）
                     ※common_function.js参照 --}}
                LoadGridRows(s, gridMaster.rowsPerItem);
            }
        }
        {{-- グリッド宣言 --}}
        gridMaster = new wijmo.grid.multirow.MultiRow('#gridMaster', gridOption);

        {{-- グリッド関連のイベント登録 --}}
        {{-- グリッドの親要素 --}}
        let host = gridMaster.hostElement;
        {{-- グリッドの「左クリック」イベント --}}
        gridMaster.addEventListener(host, 'click', function (e)
        {
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            if(gridMaster.itemsSource.length < 1) return;
            {{-- 選択した行番号を格納 --}}
            selectedRows = SetSelectedMultiRow(gridMaster, selectedRows);
            {{-- 選択した行のデータIDを格納 --}}
            SetSelectedRowId(gridMaster.collectionView.currentItem['dataId']);
        });

        {{-- グリッドの「右クリック」イベント --}}
        gridMaster.addEventListener(host, 'contextmenu', function (e)
        {
            {{-- セル上での右クリックメニュー表示 ※common_function.js参照 --}}
            SetGridContextMenu(gridMaster, e);
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            if(gridMaster.itemsSource.length < 1) return;
            {{-- クリックした位置を選択 --}}
            gridMaster.select(new wijmo.grid.CellRange(gridMaster.hitTest(e).row, 0), true);
            {{-- 選択した行番号を格納 --}}
            selectedRows = SetSelectedMultiRow(gridMaster, selectedRows);
            {{-- 選択した行のデータIDを格納 --}}
            SetSelectedRowId(gridMaster.collectionView.currentItem['dataId']);
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
            {{-- 「←・↑・→・↓キー」はクリック時と同じ処理 --}}
            if(e.keyCode >= KEY_LEFT && e.keyCode <= KEY_DOWN)
            {
                {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
                if(gridMaster.itemsSource.length < 1) return;
                {{-- 選択した行番号を格納 --}}
                selectedRows = SetSelectedMultiRow(gridMaster, selectedRows);
                {{-- 選択した行のデータIDを格納 --}}
                SetSelectedRowId(gridMaster.collectionView.currentItem['dataId']);
                {{-- キーボードイベント二重起動防止 --}}
                windowKeybordFlg = false;
            }
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
                soushinData[kensakuData[i].name] = (kensakuData[i].value != '') ? (kensakuData[i].value + LIKE_VALUE_BOTH) : '';
            }
        }
        {{-- 「データ読込中」表示 --}}
        ShowPopupDlg("{{ __('データ読込中') }}");
        {{-- グリッドのデータ受信 --}}
        AjaxData("{{ url('/master/6300') }}", soushinData, fncJushinGridData);
        {{-- 検索件数の取得フラグの送信データを追加 --}}
        soushinData["dataCntFlg"] = true;
        {{-- 検索件数のデータ受信 --}}
        AjaxData("{{ url('/master/6300') }}", soushinData, fncJushinDataCnt);
    }
    {{-- 「CSV出力」ボタンイベント --}}
    var fncExportCSV = function()
    {
        {{-- CSV出力用グリッドのレイアウト設定 --}}
        let columns = [{ binding: 'dataSeikyuCd', header: "{{ __('seikyu_cd') }}" },
                       { binding: 'dataSeikyuBushoName', header: "{{ __('seikyu_busho_name') }}" },
                       { binding: 'dataSeikyuZip', header : "{{ __('seikyu_zip') }}" },
                       { binding: 'dataSeikyuJusho', header: "{{ __('seikyu_jusho') }}" },
                       { binding: 'dataTelNo', header: "{{ __('tel_no') }}" },
                       { binding: 'dataFaxNo', header: "{{ __('fax_no') }}" },
                       { binding: 'dataGinkou1', header : "{{ __('ginkou1') }}" },
                       { binding: 'dataGinkou2', header: "{{ __('ginkou2') }}" },
                       { binding: 'dataGinkou3', header: "{{ __('ginkou3') }}" },
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


    var gridMasterKouseiHinmoku;
    var KouseiGridKouseiHinmokuSend = function(data, errorFlg)
    {
        // グリッドの初期化
        // if(gridMasterKouseiHinmoku != null) gridMasterRight.dispose();

        // マスタデータ一覧
        gridMasterKouseiHinmoku = new wijmo.grid.FlexGrid('#gridMasterKouseiHinmoku',{itemsSource: data[1],
            // レイアウト設定
            columns: [
                { binding: 'dataSeikyuCd', header: "{{__('seikyu_cd')}}", width: 100},
                { binding: 'dataSeikyuBushoName',  header: "{{__('seikyu_busho_name')}}", width:100 }] ,
                isReadOnly: false // ここで編集できるように
        });
    }

    var gridMasterKouzyun;
    var KouseiGridKouzyunSend = function(data, errorFlg)
    {
        // グリッドの初期化
        // if(gridMasterKouzyun != null) gridMasterRight.dispose();

        // マスタデータ一覧
        gridMasterKouzyun = new wijmo.grid.FlexGrid('#gridMasterKouzyun',{itemsSource: data[1],
            // レイアウト設定
            columns: [
                { binding: 'dataSeikyuCd', header: "{{__('seikyu_cd')}}", width: 100},
                { binding: 'dataSeikyuBushoName',  header: "{{__('seikyu_busho_name')}}", width:100 }] ,
                isReadOnly: false // ここで編集できるように
        });
    }



    {{-- 「新規・参照新規・修正・削除」ボタンイベント
         ※mode → 入力ダイアログの操作、新規・修正・削除のどの処理で開いたかを判別する処理種別
           copy → 参照新規や修正などで選択行のレコード情報を初期入力させるかの判定 --}}
    var fncNyuryokuData = function(mode, copy)
    {
        {{-- 入力フォーム要素 --}}
        let nyuryokuData = document.forms['frmNyuryoku'].elements;
        
        // 
        // 検索フォーム(送信データ)
        let soushinDataKouseiHinmoku = {}
        // 非同期データ更新開始
        AjaxData("{{ url('/inquiry/GridKouseiHinmoku') }}", soushinDataKouseiHinmoku,KouseiGridKouseiHinmokuSend); // グリッドデータ
        let soushinDataKoujun = {}
        // 非同期データ更新開始
        AjaxData("{{ url('/inquiry/GridKouzyun') }}", soushinDataKoujun,KouseiGridKouzyunSend); // グリッドデータ
        

        {{-- 選択行のグリッドデータ --}}
        let data = gridMaster.collectionView.currentItem;
        {{-- 「新規」処理フラグ --}}
        let insertFlg = (mode == MODE_INSERT);

        {{-- 「処理種別」 --}}
        nyuryokuData['dataSQLType'].value = mode;
        {{-- 「請求CD」 --}}
        nyuryokuData['dataSeikyuCd'].value = (copy && !insertFlg) ? data['dataSeikyuCd'] : '';
        nyuryokuData['dataSeikyuCd'].disabled = !insertFlg;
        {{-- 「請求部署名」 --}}
        nyuryokuData['dataSeikyuBushoName'].value = copy ? data['dataSeikyuBushoName'] : '';
        {{-- 「郵便番号」 --}}
        nyuryokuData['dataSeikyuZip'].value = copy ? data['dataSeikyuZip'] : '';
        {{-- 「住所」 --}}
        nyuryokuData['dataSeikyuJusho'].value = copy ? data['dataSeikyuJusho'] : '';
        {{-- 「電話番号」 --}}
        nyuryokuData['dataTelNo'].value = copy ? data['dataTelNo'] : '';
        {{-- 「FAX番号」 --}}
        nyuryokuData['dataFaxNo'].value = copy ? data['dataFaxNo'] : '';
        {{-- 「銀行1」 --}}
        nyuryokuData['dataGinkou1'].value = copy ? data['dataGinkou1'] : '';
        {{-- 「銀行2」 --}}
        nyuryokuData['dataGinkou2'].value = copy ? data['dataGinkou2'] : '';
        {{-- 「銀行3」 --}}
        nyuryokuData['dataGinkou3'].value = copy ? data['dataGinkou3'] : '';

    
        {{-- 「有効期間（自）」 --}}
        dateStart.value = !insertFlg ? data['dataStartDate'] : getNowDate();
        {{-- 「登録日時」 --}}
        nyuryokuData['dataTourokuDt'].value = !insertFlg ? data['dataTourokuDt'] : '';
        {{-- 「更新日時」 --}}
        nyuryokuData['dataKoushinDt'].value = !insertFlg ? data['dataKoushinDt'] : '';

        {{-- ボタンのキャプション --}}
        let btnCaption = ["{{ __('登録') }}","{{ __('更新') }}","{{ __('削除') }}"];
        nyuryokuData['btnKettei'].value = "{{__('F9')}}" + btnCaption[mode - 1];


        {{-- 「削除」処理フラグ
             ※削除処理時は入力機能を制限して閲覧のみにする --}}
        let deleteFlg = (mode == MODE_DELETE);
        {{-- レコードID ※削除時のみ必要 --}}
        nyuryokuData['dataId'].value = deleteFlg ? data['dataId'] : '';
        {{-- 検索ボタン ※削除時のみ制限 --}}
        nyuryokuData['btnSanshou'].disabled = deleteFlg;
        nyuryokuData['dataSeikyuBushoName'].disabled = deleteFlg; {{-- 「請求部署名」 --}}
        nyuryokuData['dataSeikyuJusho'].disabled = deleteFlg;  {{-- 「住所」 --}}
        dateStart.isDisabled = deleteFlg;    {{-- 「有効期間（自）」 --}}

        {{-- 入力フォームのスタイル初期化 ※common_function.js参照　--}}
        InitFormStyle();
    }

    {{-- ----------------------------- --}}
    {{-- 非同期処理呼び出し養用の関数変数 --}}
    {{-- ----------------------------- --}}
    {{-- ※data → 非同期通信で受信したjsonデータ配列
           errorFlg → 非同期通信先のエラー処理判定 --}}

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
        selectedRows = SortMultiRowData(gridMaster, data[1], 'dataJigyoubuCd');
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

    {{-- 入力ダイアログ「決定」ボタン クリック処理 --}}
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
            {{-- 「請求部署名」 --}}
            if(nyuryokuData['dataSeikyuBushoName'].value != data['dataSeikyuBushoName']) return true;
            {{-- 「郵便番号」 --}}
            if((nyuryokuData['dataSeikyuZip'].value != data['dataSeikyuZip']) &&
              !(nyuryokuData['dataSeikyuZip'].value == '' && data['dataSeikyuZip'] == null)) return true;
            {{-- 「住所」 --}}
            if((nyuryokuData['dataSeikyuJusho'].value != data['dataSeikyuJusho']) &&
              !(nyuryokuData['dataSeikyuJusho'].value == '' && data['dataSeikyuJusho'] == null)) return true;
            {{-- 「電話番号」 --}}
            if((nyuryokuData['dataTelNo'].value != data['dataTelNo']) &&
              !(nyuryokuData['dataTelNo'].value == '' && data['dataTelNo'] == null)) return true;
            {{-- 「FAX番号」 --}}
            if((nyuryokuData['dataFaxNo'].value != data['dataFaxNo']) &&
              !(nyuryokuData['dataFaxNo'].value == '' && data['dataFaxNo'] == null)) return true;
            {{-- 「銀行１」 --}}
            if((nyuryokuData['dataGinkou1'].value != data['dataGinkou1']) &&
              !(nyuryokuData['dataGinkou1'].value == '' && data['dataGinkou1'] == null)) return true;
            {{-- 「銀行２」 --}}
            if((nyuryokuData['dataGinkou2'].value != data['dataGinkou2']) &&
              !(nyuryokuData['dataGinkou2'].value == '' && data['dataGinkou2'] == null)) return true;
            {{-- 「銀行３」 --}}
            if((nyuryokuData['dataGinkou3'].value != data['dataGinkou3']) &&
              !(nyuryokuData['dataGinkou3'].value == '' && data['dataGinkou3'] == null)) return true;

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
                AjaxData("{{ url('/master/6301') }}", soushinData, fncUpdateData);
            }, null);
        }
        else
        {
            {{-- 「データ更新中」表示 --}}
            ShowPopupDlg("{{__('データ更新中')}}");
            {{-- 非同期データ更新開始 --}}
            AjaxData("{{ url('/master/6301') }}", soushinData, fncUpdateData);
        }
    });

    /* 構成マスタ 入力ダイアログ内Grid関連 */



    {{-- テキスト変更時に連動するテキスト要素のリセット処理 --}}
    $('input[type="text"]').change(function() {
        {{-- 連動テキスト要素のある要素を判別 --}}
        switch($(this)[0].name)
        {
            {{-- 事業部CD --}}
            case 'dataJigyoubuCd': break;
            {{-- 請求CD --}}
            case 'dataSeikyuCd': break;
            {{-- 部署CD --}}
            case 'dataBushoCd': break;
            {{-- メニューグループCD --}}
            case 'dataMenuGroupCd': break;
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
    {{-- 「参照」ボタンアイコン クリック処理 --}}
    $('.search-btn').click(function() {
        {{-- フォーカスした要素の前の要素を格納（コード系） --}}
        currentCdElement = $(this).prev("input")[0];
        {{-- フォーカスした要素の親要素の次にある要素を格納（名前系） --}}
        currentNameElement = $(this).parent().next("input")[0];
        {{-- 参照ボタン処理を実行 --}}
        $('.btnSanshou').click();
    });
    {{-- 「参照」ボタン クリック処理 --}}
    $('.btnSanshou').click(function() {
        {{-- 処理種別が「削除」の場合は処理をスキップ --}}
        if(currentCdElement.disabled) return;
        {{-- 選択対象の名前を判別 --}}
        switch(currentCdElement.name)
        {
            {{-- 事業部CD --}}
            case 'dataJigyoubuCd':
            ShowSentakuDlg("{{ __('jigyoubu_cd') }}", "{{ __('jigyoubu_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0100') }}");
            break;
            {{-- 請求CD --}}
            case 'dataSeikyuCd':
            ShowSentakuDlg("{{ __('seikyu_cd') }}", "{{ __('seikyu_busho_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/6300') }}");
            break;
            {{-- 部署CD --}}
            case 'dataBushoCd':
            ShowSentakuDlg("{{ __('busho_cd') }}", "{{ __('busho_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0300') }}");
            break;
            {{-- メニューグループCD --}}
            case 'dataMenuGroupCd':
            ShowSentakuDlg("{{ __('menu_group_cd') }}", "{{ __('menu_group_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/6100') }}");
            break;
        }
    });
</script>
@endsection
