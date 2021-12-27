{{-- PHP処理 --}}
<?php
    // 「loginId」が送信されていなければ0を設定
    if(!isset($loginId)) $loginId = 0;

    // 検索フォームの高さ
    $kensakuHight = '140px';
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
        {{-- 「割付候補CD」 --}}
        <label>
            <span style="width:8em;">{{__('waritsukekouho_cd')}}</span>
            <input name="dataWaritsukekouhoCd" class="form-control code-check" type="text" 
                maxlength="10" autocomplete="off" style="width:10em;" 
                    pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}"   required>
        </label>
        {{-- 「割付候補名」 --}}
        <label>
            <span style="width:8em;">{{__('waritsukekouho_name')}}</span>
            <input name="dataWaritsukekouhoName" class="form-control code-check" type="text" 
                maxlength="20" autocomplete="off" style="width:12em;" required>
        </label>
        {{-- 「担当者CD」 --}}
        <label>
            <span style="width:8em;">{{__('tantousha_cd')}}</span>
            <span class="icon-field">
            <input name="dataTantoushaCd" class="form-control code-check" type="text" 
                maxlength="10" autocomplete="off" style="width:12em;" 
                    pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}"   required>
                <i class="fas fa-search search-btn"></i>
            </span>
        <input name="dataTantoushaName" class="form-control" type="text" 
                style="width:15em;" onfocus="blur();" readonly>
        </label>
    </div>
    {{-- 二列目 --}}
    <div class="form-column">
        {{-- 「事業部CD」 --}}
        <label>
            <span style="width:5.5em;">{{__('jigyoubu_cd')}}</span>
            <span class="icon-field">
            <input name="dataJigyoubuCd" class="form-control code-check" type="text" 
                maxlength="6" autocomplete="off" style="width:12em;" 
                    pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}"   required>
                <i class="fas fa-search search-btn"></i>
            </span>
        <input name="dataJigyoubuName" class="form-control" type="text" 
                style="width:15em;" onfocus="blur();" readonly>
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

<!--割付ダイアログ-->
<div id="dlgWaritsuke">
    <!--割付フォーム-->
    <form id="frmWaritsuke" name="frmWaritsuke" style="margin:0;">
        <!--ダイアログヘッダー-->
        <div class="wj-dialog-header" style="padding :5px;">
        {{__('情報入力')}}
        </div>
        {{-- 入力フォーム全体 --}}
        <div class="flex-box flex-center item-start"style="margin: 0px 30px 0 20px">
            <div class="flex-box flex-center flex-column item-start"style="width: 90%;">
                {{-- 「割付候補CD」 --}}
                <label>
                    <span style="width:8em;">{{__('waritsukekouho_cd')}}</span>
                    <input name="dataWaritsukekouhoCd" class="form-control code-check" type="text" 
                        maxlength="10" autocomplete="off" style="width:15em;" 
                            pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}"  required>
                </label>
                {{-- 「割付候補名」 --}}
                <label>
                    <span style="width:8em;">{{__('waritsukekouho_name')}}</span>
                    <input name="dataWaritsukekouhoName" class="form-control code-check" type="text" 
                        maxlength="20" autocomplete="off" style="width:18em;" required>
                </label>
            </div>
            <div class="flex-box flex-center flex-column item-start" style="margin: 0 20px 0 0">
                {{-- 「事業部CD」 --}}
                <label>
                    <span style="width:5em;">{{__('jigyoubu_cd')}}</span>
                    <span class="icon-field">
                    <input name="dataJigyoubuCd" class="form-control code-check" type="text" 
                        maxlength="6" autocomplete="off" style="width:10em;" 
                            pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}"   required>
                        <i class="fas fa-search search-btn"></i>
                    </span>
                <input name="dataJigyoubuName" class="form-control" type="text" 
                        style="width:12em;" onfocus="blur();" readonly>
                </label>
                {{-- 「説明文」 --}}
                <label>
                    <span style="width:5em;">{{__('setsumeibun')}}</span>
                    <input name="dataSetsumeibun" class="form-control code-check" type="text" 
                        maxlength="512" autocomplete="off" style="width:30em;" required>
                </label>
            </div>
        </div>   
        <div class="flex-box flex-between item-start" style="padding: 20px;">
            {{-- 「フォーム左側」 --}}
            <div class="flex-box flex-center flex-column item-start">
                <div id="theSearchLeft"></div>
                <div id="gridMasterLeft" style="width: 94%; height: 500px;"></div>
            </div>
            {{-- 「フォーム真ん中」 --}}
            <div class="flex-box flex-center flex-column item-start"style="margin: 100px 45px 0 0">
                <div class="item-start check_lb">
                    <button id="btnUp" style="width: 150%; height: 40px;"type="button">
                    {{__('⇧')}}</button>
                </div>
                <div class=" item-start check_lb"style="margin: 80px 0 0 0">
                    <button onclick="buttonRight()" id="btnRight" style="width: 150%; height: 40px;"type="button">
                    {{__('⇨')}}</button>
                </div>
                <div class=" item-start check_lb"style="margin: 80px 0 0 0">
                    <button onclick="buttonLeft()" id="btnLeft" style="width: 150%; height: 40px;"type="button">
                    {{__('⇦')}}</button>
                </div>
                <div class="item-start check_lb"style="margin: 80px 0 0 0">
                    <button id="btnDown" style="width: 150%; height: 40px;"type="button">
                    {{__('⇩')}}</button>
                </div>
            </div>
            {{-- 「フォーム右側」 --}}
            <div class="flex-box flex-center flex-column item-start"> 
                <div id="theSearchRight"></div>
                <div id="gridMasterRight" style="width:94%; height: 500px;"></div>
            </div>
        </div>
        <div class="flex-box">
            <div class="form-column"style="margin: 0 0 0 20px">
                {{-- 「有効期間（自）」 --}}
                <label>
                    <span style="width:7em;">{{__('yukoukikan_start_date')}}</span>
                    <input id="dataStartDate" name="dataStartDate" type="hidden">
                </label>
            </div>
            <div class="form-column"style="margin: 0 0 0 100px">
                {{-- 「登録日」 --}}
                <label>
                    <span style="width:8em;">{{__('touroku_dt')}}</span>
                    <input name="dataTourokuDt" class="form-control-plaintext" type="text" readonly>
                </label>
            </div>
            <div class="form-column">
                {{-- 「更新日」 --}}
                <label>
                    <span style="width:8em;">{{__('koushin_dt')}}</span>
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
<div class="flex-box flex-end" style="padding:5px 10px">
<!--参照ボタン-->
<button name="btnSanshou" class="btn btn-primary btnSanshou flex-left" type="button">
{{__('F8')}}{{__('参照')}}
</button>
<!--決定ボタン-->
<input id="btnWaritsukeKettei" name="btnWaritsukeKettei" class="btn btn-primary" type="submit"
style="margin-right:10px;">
<!--戻るボタン-->
<button id="btnWaritsukeKetteiCancel" class="btn btn-primary" type="button" onclick="CloseWaritsukeDlg();">
{{__('F12')}}</span>{{__('戻る')}}
</button>
</div>
</form>
</div>

{{-- javascript --}}
@section('javascript')
<script>
    SetWaritsukeDlg(new wijmo.input.Popup('#dlgWaritsuke'));
    {{-- -------------------- --}}
    {{-- wijmoコントロール宣言 --}}
    {{-- -------------------- --}}

    {{-- カレンダー宣言 --}}
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
        SetWaritsukeData(fncWaritsukeData);
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
        let columns = [{ cells: [{ binding: 'dataWaritsukekouhoCd',   header: "{{__('waritsukekouho_cd')}}", width: '2*' }]},
                       { cells: [{ binding: 'dataWaritsukekouhoName', header: "{{__('waritsukekouho_name')}}", width: '2*' },]},
                       { cells: [{ binding: 'dataSubNo', header: "{{__('sub_seq')}}", width: 130 },]},
                       { cells: [{ binding: 'dataCntWaritsukeCd',            header: "{{__('cnt')}}", width: 130 }] },
                       { cells: [{ binding: 'dataTantoushaCd',        header: "{{__('sentoTantosha_cd')}}", width: '2*' },]},
                       { cells: [{ binding: 'dataTantoushaName',      header: "{{__('sentTantosha_name')}}", width: '2*' },]},
                       { cells: [{ binding: 'dataKakouSkill',         header: "{{__('kakou_skill')}}", width:'1.7*' },]},
                       { cells: [{ binding: 'dataKakounouryoku_keisu',      header: "{{__('kakou_nouryoku_keisu')}}", width:'1.7*' },]},
                       { cells: [{ binding: 'dataStartDate',          header: "{{__('yukoukikan_start_date')}}", width: '1.7*' }] },
                       { cells: [{ binding: 'dataEndDate',            header: "{{__('yukoukikan_end_date')}}", width: '1.7*' }] },
                       { cells: [{ binding: 'dataIndex', width: 0 }] }];  
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
            loadedRows: function (s, e)
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
        AjaxData("{{ url('/master/0500') }}", soushinData, fncJushinGridData);
        {{-- 検索件数の取得フラグの送信データを追加 --}}
        soushinData["dataCntFlg"] = true;
        {{-- 検索件数のデータ受信 --}}
        AjaxData("{{ url('/master/0500') }}", soushinData, fncJushinDataCnt);
    }
    {{-- 「CSV出力」ボタンイベント --}}
    var fncExportCSV = function()
    {
        {{-- CSV出力用グリッドのレイアウト設定 --}}
        let columns = [{ binding: 'dataWaritsukekouhoCd',   header: "{{__('waritsukekouho_cd')}}" },
                       { binding: 'dataWaritsukekouhoName', header: "{{__('waritsukekouho_name')}}" },
                       { binding: 'dataSubNo', header: "{{__('sub_seq')}}" },
                       { binding: 'dataCntWaritsukeCd',            header: "{{__('cnt')}}" },
                       { binding: 'dataTantoushaCd',        header: "{{__('sentoTantosha_cd')}}"},
                       { binding: 'dataTantoushaName',      header: "{{__('sentTantosha_name')}}" },
                       { binding: 'dataKakouSkill',         header: "{{__('kakou_skill')}}" },
                       { binding: 'dataKakounouryoku_keisu',      header: "{{__('kakou_nouryoku_keisu')}}" },
                       { binding: 'dataStartDate',          header: "{{__('yukoukikan_start_date')}}" },
                       { binding: 'dataEndDate',            header: "{{__('yukoukikan_end_date')}}" }];
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
    var fncWaritsukeData = function(mode, copy)
    {
        {{-- 割付フォーム要素 --}}
        let waritsukeData = document.forms['frmWaritsuke'].elements;
        {{-- 選択行のグリッドデータ --}}
        let data = gridMaster.collectionView.currentItem;
        {{-- 「新規」処理フラグ --}}
        let insertFlg = (mode == MODE_INSERT);

        {{-- 「処理種別」 --}}
        waritsukeData['dataSQLType'].value = mode;
        {{-- 「割付候補CD」 --}}
        waritsukeData['dataWaritsukekouhoCd'].value = copy ? data['dataWaritsukekouhoCd'] : '';
        waritsukeData['dataWaritsukekouhoCd'].disabled = !insertFlg;
        {{-- 「担当割付候補名」 --}}
        waritsukeData['dataWaritsukekouhoName'].value = copy ? data['dataWaritsukekouhoName'] : '';
        {{-- 「事業部CD」 --}}
        waritsukeData['dataJigyoubuCd'].value = copy ? data['dataJigyoubuCd'] : '';
        {{-- 「事業部名」 --}}
        waritsukeData['dataJigyoubuName'].value = copy ? data['dataJigyoubuName'] : '';
        {{-- 「説明文」 --}}
        waritsukeData['dataSetsumeibun'].value = copy ? data['dataSetsumeibun'] : '';
        if(mode==1 && copy==false){
             waritsukeData['dataWaritsukekouhoCd'].value = '';
             waritsukeData['dataWaritsukekouhoName'].value = '';
             waritsukeData['dataSetsumeibun'].value = ''; 
             waritsukeData['dataJigyoubuCd'].value = '';
        }
        {{-- ボタンのキャプション --}}
        let btnCaption = ["{{ __('登録') }}","{{ __('更新') }}","{{ __('削除') }}"];
        waritsukeData['btnWaritsukeKettei'].value = "{{__('F9')}}" + btnCaption[mode - 1];

        {{-- 「削除」処理フラグ
             ※削除処理時は入力機能を制限して閲覧のみにする --}}
        let deleteFlg = (mode == MODE_DELETE);
        {{-- レコードID ※削除時のみ必要 --}}
        waritsukeData['dataId'].value = deleteFlg ? data['dataId'] : '';
        waritsukeData['dataWaritsukekouhoCd'].disabled = deleteFlg; 
        waritsukeData['dataWaritsukekouhoName'].disabled = deleteFlg; 
        waritsukeData['dataJigyoubuCd'].disabled = deleteFlg; {{-- 「事業部CD」 --}}
        waritsukeData['dataSetsumeibun'].disabled = deleteFlg; 
        waritsukeData['btnRight'].disabled = deleteFlg; 
        waritsukeData['btnLeft'].disabled = deleteFlg; 
        waritsukeData['btnSanshou'].disabled = deleteFlg; 
        
        {{-- 入力フォームのスタイル初期化 ※common_function.js参照　--}}
        InitFormStyle();
    }

    fncWaritsukeSanshouData = function(mode, copy)
    {
        let waritsukeData = document.forms['frmWaritsuke'].elements;
        if(mode==1 && copy==true){
             waritsukeData['dataWaritsukekouhoCd'].value = '';
             waritsukeData['dataWaritsukekouhoName'].value = '';
        }
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
        {{-- グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 --}}
        selectedRows = SortMultiRowData(gridMaster, data[1], 'dataWaritsukekouhoCd');
        console.log(data[1],'data')
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
            CloseWaritsukeDlg();
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

    {{-- 入力ダイアログ　「決定」ボタン　クリック処理 --}}
    $('#frmWaritsuke').submit(function(event)
    {
        {{-- 関数内関数 --}}
        {{-- 編集ダイアログ入力値変更判定 --}}
        function IsChangeNyuryokuData(waritsukeData)
        {
            {{-- 選択行のグリッドデータ --}}
            let data = gridMaster.collectionView.currentItem;
            let data2 = gridMasterRight.collectionView.currentItem;
            {{-- 更新処理以外の処理の場合は判定せずにtrue --}}
            if(waritsukeData['dataSQLType'].value != MODE_UPDATE) return true;
            {{-- 「事業部CD」 --}}
            if(waritsukeData['dataJigyoubuCd'].value != data['dataJigyoubuCd']) return true;
            {{-- 「割付候補CD」 --}}
            if(waritsukeData['dataWaritsukekouhoCd'].value != data['dataWaritsukekouhoCd']) return true;
            {{-- 「割付候補名」 --}}
            if(waritsukeData['dataWaritsukekouhoName'].value != data['dataWaritsukekouhoName']) return true;
            {{-- 「説明文」 --}}
            if(waritsukeData['dataSetsumeibun'] != data['dataSetsumeibun']) return true;
            {{-- 「担当者ID」 --}}
            if(data2['dataTantoshaId'] != data['dataTantoshaId']) return true;
            {{-- 「担当者CD」 --}}
            if(data2['dataTantoushaCd'] != data['dataTantoushaCd']) return true;
            {{-- 「加工スキル」 --}}
            if(data2['dataKakouSkill'] != data['dataKakouSkill']) return true;
            {{-- 「加工能力係数」 --}}
            if(data2['dataKakounouryoku_keisu'] != data['dataKakounouryoku_keisu']) return true;

            {{-- 上記項目に変更が無い場合はfalse --}}
            return false;
        }

        {{-- HTMLでの送信をキャンセル --}}
        event.preventDefault();
        {{-- 入力フォーム要素 --}}
        let waritsukeData = document.forms['frmWaritsuke'].elements;
        {{-- 「データチェック中」表示 --}}
        ShowPopupDlg("{{ __('データチェック中') }}");

        {{-- データ更新判定
             ※修正処理の際、変更箇所が無い場合は更新処理をしない --}}
        if(!IsChangeNyuryokuData(waritsukeData))
        {
            {{-- エラーメッセージ表示 --}}
            ShowAlertDlg("{{__('更新されたデータがありません')}}");
            {{-- 「データチェック中」非表示 --}}
            ClosePopupDlg();
            return;
        }
 
        //let waritsukeData = document.forms['frmWaritsuke'].elements;

        console.log(gridMasterRight.itemsSource,'gridMasterRight.itemsSource');
        let obj = gridMasterRight.itemsSource[0];
        let objName=Object.keys(obj).length;
        let obj2=Object.keys(obj);
        console.log(objName,'obj');
        console.log(obj2[0],'item');
        console.log(waritsukeData.length,'waritsukeData.length');

        // 送信データ
        for(var i = 0; i < gridMasterRight.itemsSource.length; i++){
            // 「データチェック中」非表示
            let obj = gridMasterRight.itemsSource[i];
            if(waritsukeData['dataSQLType'].value == MODE_INSERT)
            {
                waritsukeHantei=true;
            }
            else
            {
                waritsukeHantei=false;
            }
            let obj2={
                'dataSQLType' :  waritsukeData['dataSQLType'].value,
                'dataLoginId'   :  waritsukeData['dataLoginId'].value,
                'dataHantei'    :  i,
                'dataHantei2'   :  waritsukeHantei,
            }
            obj.dataSubNo = i + 1
            obj.dataWaritsukekouhoCd=waritsukeData['dataWaritsukekouhoCd'].value
            obj.dataWaritsukekouhoName=waritsukeData['dataWaritsukekouhoName'].value
            obj.dataSetsumeibun=waritsukeData['dataSetsumeibun'].value
            Object.assign(obj,obj2);
            if(waritsukeData['dataSQLType'].value != MODE_DELETE)
            {
                delete obj.dataId;
            }
            delete obj.EndData;
            let soushinData=obj;
            console.log(soushinData,'soushinData')
            ClosePopupDlg();
            //
            if(waritsukeData['dataSQLType'].value == MODE_DELETE && i == 0)
            {
                {{-- 確認ダイアログを経由して処理 --}}
            ShowConfirmDlg("このレコードを削除しますか？",
            {{-- OKボタンを押したときの処理 --}}
            function()
            {
                {{-- 「データ更新中」表示 --}}
                ShowPopupDlg("{{__('データ更新中')}}");
                {{-- 非同期データ更新開始 --}}
                AjaxData("{{ url('/master/0501') }}", soushinData, fncUpdateData);
            }, null);
            }
            else{
                {{-- 「データ更新中」表示 --}}
                ShowPopupDlg("{{__('データ更新中')}}");
                {{-- 非同期データ更新開始 --}}
                AjaxData("{{ url('/master/0501') }}", soushinData, fncUpdateData);
                }
        }
    });
    
    {{-- テキスト変更時に連動するテキスト要素のリセット処理 --}}
    $('input[type="text"]').change(function() {
        {{-- 連動テキスト要素のある要素を判別 --}}
        switch($(this)[0].name)
        {
            {{-- 担当者CD --}}
            case 'dataTantoushaCd':break;
            {{-- 割付CD --}}
            case 'dataWaritsukekouhoCd':break;
            {{-- 事業部CD --}}
            case 'dataJigyoubuCd':break;
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
        {{-- 選択対象の名前を判別 --}}
        switch(currentCdElement.name)
        {
            {{-- 担当者CD --}}
            case 'dataTantoushaCd':
            ShowSentakuDlg("{{ __('tantousha_cd') }}", "{{ __('tantousha_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0400') }}");
            break;
            {{-- 事業部CD --}}
            case 'dataJigyoubuCd':
            ShowSentakuDlg("{{ __('jigyoubu_cd') }}", "{{ __('jigyoubu_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0100') }}");
            break;
            {{-- 割付CD --}}
            case 'dataWaritsukekouhoCd':
            ShowSentakuDlg("{{ __('waritsukekouho_cd') }}", "{{ __('waritsukekouho_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0500') }}");
            break;
        }
    });
    {{-- グリッド割付変数 --}}
    var gridMasterLeft;
    var gridMasterRight;
    var gridSearchRight;
    var gridSearchLeft;
    
    function sinkiSend(){
        let waritsukeData = document.forms['frmWaritsuke'].elements;
        console.log(waritsukeData['dataWaritsukekouhoName'].value,'dataWaritsukekouhoName');
        // 検索フォーム(送信データ)
        let soushinDataRight = {}
        // 非同期データ更新開始
        AjaxData("{{ url('/inquiry/GridNoData') }}", soushinDataRight,WaritsukeGridRightSend); // グリッドデータ

        let soushinDataLeft = {}
        // 非同期データ更新開始
        AjaxData("{{ url('/inquiry/GridLeft') }}", soushinDataLeft,WaritsukeGridLeftSend); // グリッドデータ
    }

    function shuseiSend(){
        let waritsukeData = document.forms['frmWaritsuke'].elements;
        console.log(waritsukeData['dataWaritsukekouhoName'].value,'dataWaritsukekouhoName');
        // 検索フォーム(送信データ)
        let soushinDataRight = {
            "dataWaritsukekouhoCd"    : GetKensakuWaritsukeData(waritsukeData['dataWaritsukekouhoCd'].value),
            "dataWaritsukekouhoName"  : GetKensakuWaritsukeData(waritsukeData['dataWaritsukekouhoName'].value),
        }
        // 非同期データ更新開始
        AjaxData("{{ url('/inquiry/GridRight') }}", soushinDataRight,WaritsukeGridRightSend); // グリッドデータ

        let soushinDataLeft = {
            "dataWaritsukekouhoCd"    : GetKensakuWaritsukeData(waritsukeData['dataWaritsukekouhoCd'].value),
            "dataWaritsukekouhoName"  : GetKensakuWaritsukeData(waritsukeData['dataWaritsukekouhoName'].value),
        }
        // 非同期データ更新開始
        AjaxData("{{ url('/inquiry/GridLeft') }}", soushinDataLeft,WaritsukeGridLeftSend); // グリッドデータ
    }
    function sakujoSend(){
        let waritsukeData = document.forms['frmWaritsuke'].elements;
        console.log(waritsukeData['dataWaritsukekouhoName'].value,'dataWaritsukekouhoName');
        // 検索フォーム(送信データ)
        let soushinDataRight = {
            "dataWaritsukekouhoCd"    : GetKensakuWaritsukeData(waritsukeData['dataWaritsukekouhoCd'].value),
            "dataWaritsukekouhoName"  : GetKensakuWaritsukeData(waritsukeData['dataWaritsukekouhoName'].value),
        }
        // 非同期データ更新開始
        AjaxData("{{ url('/inquiry/GridRight') }}", soushinDataRight,WaritsukeGridRightSend); // グリッドデータ

        let soushinDataLeft = {
            "dataWaritsukekouhoCd"    : GetKensakuWaritsukeData(waritsukeData['dataWaritsukekouhoCd'].value),
            "dataWaritsukekouhoName"  : GetKensakuWaritsukeData(waritsukeData['dataWaritsukekouhoName'].value),
        }
        // 非同期データ更新開始
        AjaxData("{{ url('/inquiry/GridNoData') }}", soushinDataLeft,WaritsukeGridLeftSend); // グリッドデータ
    }

    function GetKensakuWaritsukeData(value)
    {
        return (value != '') ? value : '';
    }

    var WaritsukeGridRightSend = function(data, errorFlg)
    {
        // グリッドの初期化
        if(gridMasterRight != null) gridMasterRight.dispose();
        if(gridSearchRight != null) gridSearchRight.dispose();

        // マスタデータ一覧
        gridMasterRight = new wijmo.grid.FlexGrid('#gridMasterRight',{itemsSource: data[1],
            // レイアウト設定
            columns: [
                { binding: 'dataTantoushaCd', header: "{{__('tantousha_cd')}}", width: 100},
                { binding: 'dataTantoushaName',  header: "{{__('tantousha_name')}}", width: 100},
                { binding: 'dataTantoushaId',      header: "{{__('tantousha_id')}}", width: 100},
                { binding: 'dataKakouSkill',         header: "{{__('kakou_skill')}}", width: 100},
                { binding: 'dataKakounouryoku_keisu',      header: "{{__('kakou_nouryoku_keisu')}}", width: 150},
                { binding: 'dataIndex', width: 0 }] ,
                isReadOnly: false
        });

        //選択モードの設定
        gridMasterRight.selectionMode = wijmo.grid.SelectionMode.MultiRange;

        gridMasterRight.beginningEdit.addHandler(function (s, e) {
            setTimeout(function () {
                // セルエディタの最大文字数を設定します。
                if (e.col == 0) {
                    s.activeEditor.setAttribute('maxlength', '10');
                } else if (e.col == 1) {
                    s.activeEditor.setAttribute('maxlength', '20');
                } else if (e.col == 3) {
                    s.activeEditor.setAttribute('maxlength', '1');
                } else if (e.col == 4) {
                    s.activeEditor.setAttribute('maxlength', '5');
                }
            });
        });
        
        gridMasterRight.addEventListener(gridMasterRight.hostElement, 'click', function (e){
            selectItemsLeft = gridMasterRight.selectedItems;
            console.log(selectItemsLeft,"selectItemsLeft");
            gridItemsLeft=gridMasterRight.itemsSource
            console.log(gridItemsLeft,"gridItemsLeft");
            gridItemsLeft2=gridMasterLeft.itemsSource
            console.log(gridItemsLeft2,"gridItemsLeft2");
            lenLeft = Object.keys(selectItemsLeft).length
            gridMasterRight.collectionView.refresh;
        });

        gridSearchRight = new wijmo.grid.search.FlexGridSearch('#theSearchRight', {
            placeholder: '検索',
            grid: gridMasterRight,
        });
    }

    var WaritsukeGridLeftSend = function(data, errorFlg)
    {
        // マスタデータ一覧
        if(gridMasterLeft != null) gridMasterLeft.dispose();
        if(gridSearchLeft != null) gridSearchLeft.dispose();
        gridMasterLeft = new wijmo.grid.FlexGrid('#gridMasterLeft',{itemsSource: data[1],
            // レイアウト設定
            columns: [
                { binding: 'dataBumonCd',        header: "{{__('busho_cd')}}", width: 100},
                { binding: 'dataTantoushaCd',        header: "{{__('tantousha_cd')}}", width: 100},
                { binding: 'dataTantoushaName',      header: "{{__('tantousha_name')}}", width: 100 },
                { binding: 'dataKakouSkill',         header: "{{__('kakou_skill')}}", width: 125 },
                { binding: 'dataIndex', width: 0 }] ,
                isReadOnly: false
        });
        gridMasterLeft.selectionMode = wijmo.grid.SelectionMode.MultiRange;

        gridMasterLeft.beginningEdit.addHandler(function (s, e) {
            setTimeout(function () {
                // セルエディタの最大文字数を設定します。
                if (e.col == 1) {
                    s.activeEditor.setAttribute('maxlength', '10');
                } else if (e.col == 2) {
                    s.activeEditor.setAttribute('maxlength', '20');
                } else if (e.col == 3) {
                    s.activeEditor.setAttribute('maxlength', '1');
                }
            });
        });
        // グリッドセルのクリックイベント
        gridMasterLeft.addEventListener(gridMasterLeft.hostElement, 'click', function (e)
        {
            gridItemsRight=new Array();
            gridItemsRight2=new Array();
            gridDeleteRight=new Array();
            selectItemsRight=new Array();
            selectItemsRight = gridMasterLeft.selectedItems;
            gridItemsRight=gridMasterLeft.itemsSource
            gridItemsRight2=gridMasterRight.itemsSource
            lenRight = Object.keys(selectItemsRight).length
            gridMasterLeft.collectionView.refresh;
            console.log(lenRight,"lenRight");
            console.log(selectItemsRight,"selectItemsRight");
            console.log(gridItemsRight,"gridItemsRight");
            console.log(gridItemsRight2,"gridItemsRight2");
        });
        // グリッドセルのダブルクリックイベント
        /*gridMasterLeft.addEventListener(gridMasterLeft.hostElement, 'dblclick', function (e)
        {
            // 選択したセルがヘッダー要素でない場合は「修正」ボタンと同じ処理
            if(gridMasterLeft.hitTest(e).cellType == wijmo.grid.CellType.Cell) $('#btnShusei').click();
        });*/
        gridSearchLeft = new wijmo.grid.search.FlexGridSearch('#theSearchLeft', {
            placeholder: '検索',
            grid: gridMasterLeft,
        });

    }

    var buttonLeft = function()
    {
        if(selectItemsLeft===undefined){
        }

        else{
            //仮データ挿入
            gridDeleteLeft=gridItemsLeft;
            console.log(gridItemsLeft,"gridItemsLeft");

            for(var i=0;i<=lenLeft-1; i++){
                dataIndLeft=selectItemsLeft[i]["dataIndex"];
                if(i==0){
                    gridDeleteLeft=gridItemsLeft.filter(value=>{
                        if(value.dataIndex!=dataIndLeft){
                            return true;
                        }
                    });
                }
                else{
                    gridDeleteLeft=gridDeleteLeft.filter(value=>{
                        if(value.dataIndex!=dataIndLeft){
                            return true;
                        }
                    });
                }
                console.log(gridDeleteLeft,"gridDeleteLeft");
            }
        
            console.log(gridItemsLeft,"gridItemsLeft");
            console.log(gridItemsLeft2,"gridItemsLeft2");
            if(gridItemsLeft2===undefined){
            }
            else{
                selectItemsLeft=selectItemsLeft.concat(gridItemsLeft2);
            }
            if(gridItemsLeft===undefined){
            }
            else{
                WaritsukeGridRight(gridDeleteLeft);
                WaritsukeGridLeft(selectItemsLeft);
            }
            gridItemsLeft=new Array();
            gridItemsLeft2=new Array();
            gridDeleteLeft=new Array();
            selectItemsLeft=new Array();
        }
    }

    var buttonRight = function()
    {

        if(selectItemsRight===undefined){
        }

        else{
            //仮データ挿入
            gridDeleteRight=gridItemsRight;

            for(var i=0;i<=lenRight-1; i++){
                dataIndRight=selectItemsRight[i]["dataIndex"];
                if(i==0){
                    gridDeleteRight=gridItemsRight.filter(value=>{
                        if(value.dataIndex!=dataIndRight){
                            return true;
                        }
                    });
                }
                else{
                    gridDeleteRight=gridDeleteRight.filter(value=>{
                        if(value.dataIndex!=dataIndRight){
                            return true;
                        }
                    });
                }
            }
        
            if(gridItemsRight2===undefined){
            }
            else{
                selectItemsRight=selectItemsRight.concat(gridItemsRight2);
            }
            if(gridItemsRight===undefined){
            }
            else{
                WaritsukeGridRight(selectItemsRight);
                WaritsukeGridLeft(gridDeleteRight);
            }
            gridItemsRight=new Array();
            gridItemsRight2=new Array();
            gridDeleteRight=new Array();
            selectItemsRight=new Array();
        }
    }
    
    var WaritsukeGridRight=function(gridDelete){
        //gridMaster.reflesh(true);
        if(gridMasterRight != null) gridMasterRight.dispose();
        if(gridSearchRight != null) gridSearchRight.dispose();
        // マスタデータ一覧
        gridMasterRight = new wijmo.grid.FlexGrid('#gridMasterRight',{itemsSource: gridDelete,
            // レイアウト設定
            columns: [
                { binding: 'dataTantoushaCd', header: "{{__('tantousha_cd')}}", width: 100},
                { binding: 'dataTantoushaName',  header: "{{__('tantousha_name')}}", width:100 },
                { binding: 'dataTantoushaId',      header: "{{__('tantousha_id')}}", width: 100 },
                { binding: 'dataKakouSkill',         header: "{{__('kakou_skill')}}", width: 100 },
                { binding: 'dataKakounouryoku_keisu',      header: "{{__('kakou_nouryoku_keisu')}}", width: 150 },
                { binding: 'dataIndex', width: 0 }] ,
            isReadOnly: false
        });
        gridMasterRight.selectionMode = wijmo.grid.SelectionMode.MultiRange;

        gridMasterRight.beginningEdit.addHandler(function (s, e) {
            setTimeout(function () {
                // セルエディタの最大文字数を設定します。
                if (e.col == 0) {
                    s.activeEditor.setAttribute('maxlength', '10');
                } else if (e.col == 1) {
                    s.activeEditor.setAttribute('maxlength', '20');
                } else if (e.col == 3) {
                    s.activeEditor.setAttribute('maxlength', '1');
                } else if (e.col == 4) {
                    s.activeEditor.setAttribute('maxlength', '5');
                }
            });
        });

        gridMasterRight.addEventListener(gridMasterRight.hostElement, 'click', function (e){
            gridItemsLeft=new Array();
            gridItemsLeft2=new Array();
            gridDeleteLeft=new Array();
            selectItemsLeft=new Array();
            selectItemsLeft = gridMasterRight.selectedItems;
            console.log(selectItemsLeft,"selectItemsLeft");
            gridItemsLeft=gridMasterRight.itemsSource
            console.log(gridItemsLeft,"gridItemsLeft");
            gridItemsLeft2=gridMasterLeft.itemsSource
            console.log(gridItemsLeft2,"gridItemsLeft2");
            lenLeft = Object.keys(selectItemsLeft).length
            gridMasterRight.collectionView.refresh;
        });
        gridSearchRight = new wijmo.grid.search.FlexGridSearch('#theSearchRight', {
            placeholder: '検索',
            grid: gridMasterRight,
        });
    }
    var WaritsukeGridLeft=function(selectItems){
        // マスタデータ一覧
        if(gridMasterLeft != null) gridMasterLeft.dispose();
        if(gridSearchLeft != null) gridSearchLeft.dispose();
        gridMasterLeft = new wijmo.grid.FlexGrid('#gridMasterLeft',{itemsSource: selectItems,
            // レイアウト設定
            columns: [
                { binding: 'dataBumonCd',        header: "{{__('busho_cd')}}", width: 100},
                { binding: 'dataTantoushaCd',        header: "{{__('tantousha_cd')}}", width: 100},
                { binding: 'dataTantoushaName',      header: "{{__('tantousha_name')}}", width: 100 },
                { binding: 'dataKakouSkill',         header: "{{__('kakou_skill')}}", width: 125 },
                { binding: 'dataIndex', width: 0 }] ,
                isReadOnly: false
        });
        gridMasterLeft.selectionMode = wijmo.grid.SelectionMode.MultiRange;

        gridMasterLeft.beginningEdit.addHandler(function (s, e) {
            setTimeout(function () {
                // セルエディタの最大文字数を設定します。
                if (e.col == 1) {
                    s.activeEditor.setAttribute('maxlength', '10');
                } else if (e.col == 2) {
                    s.activeEditor.setAttribute('maxlength', '20');
                } else if (e.col == 3) {
                    s.activeEditor.setAttribute('maxlength', '1');
                }
            });
        });

        // グリッドセルのクリックイベント
        gridMasterLeft.addEventListener(gridMasterLeft.hostElement, 'click', function (e)
        {
            gridItemsRight=new Array();
            gridItemsRight2=new Array();
            gridDeleteRight=new Array();
            selectItemsRight=new Array();
            selectItemsRight = gridMasterLeft.selectedItems;
            gridItemsRight=gridMasterLeft.itemsSource
            gridItemsRight2=gridMasterRight.itemsSource
            lenRight = Object.keys(selectItemsRight).length
            gridMasterLeft.collectionView.refresh;
            console.log(lenRight,"lenRight");
            console.log(selectItemsRight,"selectItemsRight");
            console.log(gridItemsRight,"gridItemsRight");
            console.log(gridItemsRight2,"gridItemsRight2");
        });
        gridSearchLeft = new wijmo.grid.search.FlexGridSearch('#theSearchLeft', {
            placeholder: '検索',
            grid: gridMasterLeft,
        });
    }

    ///////////////////
    // 割付ダイアログ //
    ///////////////////
    // 入力ダイアログ共有変数
    var dlgWaritsuke;
    
    // 関数を設定
    function SetWaritsukeData(fnc)
    {
        fncWaritsukeData = fnc;
    }

    // ダイアログの設定
    function SetWaritsukeDlg(dlg)
    {
        dlg.isDraggable =  true;  // ヘッダー移動操作許可
        dlg.hideTrigger = 'None'; // ダイアログを閉じる条件
        // グリッドセルの左クリックイベント
        dlg.addEventListener(dlg.hostElement, 'keydown', function (e)
        {
            let idText = '';
            if(e.keyCode == KEY_F8)  idText = '.btnSanshou';
            // F9キー
            if(e.keyCode == KEY_F9)  idText = '#btnWaritsukeKettei';
            // F12キー
            if(e.keyCode == KEY_F12) idText = '#btnWaritsukeKetteiCancel';
            // クリック処理実行
            if(idText != '') $(idText).click();
            windowKeybordFlg = false;
        });
        dlgWaritsuke = dlg;
    }
    // 割付ダイアログの表示
    function ShowWaritsukeDlg(index, mode)
    {
        // 表示
        dlgWaritsuke.show(true);

        // 入力初期値処理
        fncWaritsukeData(index, mode);
        
        if(index==MODE_INSERT && mode==false){
            sinkiSend();
        }
        else if(index==MODE_INSERT && mode==true){
            shuseiSend();
            fncWaritsukeSanshouData(index, mode);
        }
        else if(index==MODE_UPDATE){
            shuseiSend();
        }
        else if(index==MODE_DELETE){
            sakujoSend();
        }
    }
    // ダイアログを閉じる
    function CloseWaritsukeDlg()
    {
        $('#dataSQLType').val(-1);
        dlgWaritsuke.hide(0);
    }

    // ボタン二重起動防止
    $(document).off('click');

    // 「新規」ボタン　クリック処理
    $(document).on('click', '#btnShinki', function()
    {
        // 全て初期値の状態で表示
        ShowWaritsukeDlg(MODE_INSERT, false);
    });
    // 「参照新規」ボタン　クリック処理
    $(document).on('click', '#btnSanshouShinki', function()
    {
        // 選択行の項目をコピーして表示
        ShowWaritsukeDlg(MODE_INSERT, true);
    });
    // 「修正」ボタン　クリック処理
    $(document).on('click', '#btnShusei', function()
    {
        // 選択行の項目をコピーして表示
        ShowWaritsukeDlg(MODE_UPDATE, true);
    });
    // 「削除」ボタン　クリック処理
    $(document).on('click', '#btnSakujo', function()
    {
        // 選択行の項目をコピーして表示
        ShowWaritsukeDlg(MODE_DELETE, true);
    });
    // 「表示」ボタン　クリック処理
    $(document).on('click', '#btnHyouji', function()
    {
        // グリッドデータ表示
        fncBtnHyouji();
    });
    // 「CSV出力」ボタンの実行関数変数
    var fncBtnCSV = function(){}
    // 「CSV出力」ボタンのイベント登録
    function SetBtnCSV(fnc)
    {
        fncBtnCSV = fnc;
    }
    // 「CSV出力」ボタン　クリック処理
    $(document).on('click', '#btnCSV', function()
    {
        // 確認してから実行
        ShowConfirmDlg(msgCSV, fncBtnCSV, null);   
    });
    // 「閉じる」ボタン　クリック処理
    $(document).on('click', '#btnClose', function()
    {
        // 確認してから実行
        ShowConfirmDlg(msgClose, function() {window.close(); }, null);
    });
</script>
@endsection