<!-- PHP処理 -->
<?php
    // 「loginId」が送信されていなければ0を設定
    if(!isset($loginId)) $loginId = 0;

    // 検索フォームの高さ
    $kensakuHight = '140px';
?>

<!-- 共通レイアウト呼び出し -->
<!--「base_master.blede.php」・・・マスタ画面の共通テンプレートデザイン -->
@extends('templete.header.master.base_master')

<!-- 「検索フォーム」 -->
@section('kensaku')
    <!-- 検索フォーム全体 -->
    <form id="frmKensaku" name="frmKensaku" class="flex-box" style="height:{{ $kensakuHight }};">
        <!-- 一列目 -->
        <div class="form-column">
            <!-- 「納入先CD」 -->
            <label>
                <span style="width:5em;">{{__('nounyusaki_cd')}}</span>
                <input name="dataNounyusakiCd" class="form-control" type="text"
                       maxlength="10" autocomplete="off" style="width:8em;">
            </label>
            <!-- 「納入先名」 -->
            <label>
                <span style="width:5em;">{{__('nounyusaki_name1')}}</span>
                <input name="dataNounyusakiName1" class="form-control" type="text"
                       maxlength="30" autocomplete="off" style="width:20em;">
            </label>
            <!-- 「得意先CD」 -->
            <label>
                <span style="width:5em;">{{__('tokuisaki_cd')}}</span>
                <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                    <input name="dataTokuisakiCd" class="form-control" type="text"
                           maxlength="10" autocomplete="off" style="width:8em;">
                    <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                    <i class="fas fa-search search-btn"></i>
                </span>
                <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                <input name="dataTokuisakiName1" class="form-control" type="text"
                       style="width:20em;" onfocus="blur();" readonly>
            </label>
        </div>
        <!-- 二列目 -->
        <div class="form-column">
            <!-- 「事業部CD」 -->
            <label>
                <span style="width:5em;">{{__('jigyoubu_cd')}}</span>
                <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                    <input name="dataJigyoubuCd" class="form-control" type="text"
                           maxlength="6" autocomplete="off" style="width:8em;">
                    <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                    <i class="fas fa-search search-btn"></i>
                </span>
                <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                <input name="dataJigyoubuName" class="form-control" type="text"
                       style="width:20em;" onfocus="blur();" readonly>
            </label>
        </div>
        <!-- 表示件数 -->
        <div class="flex-box flex-end item-end" style="width:100%;">
            <div class="base-color-front" style="color:black;">
                <span id="zenkenCnt" style="margin: 0 10px;"></span>{{__('件')}}{{__('を表示')}}
            </div>
        </div>
    </form>
@endsection

<!-- 「入力ダイアログ」 -->
@section('nyuryoku')
<!-- 入力フォーム全体 -->
<!-- 「ダイアログ左側」 -->
<div class="flex-box flex-between item-start" style="padding:5px 10px;">
    <div class="form-column">
        <div class="flex-box flex-start flex-column item-start">
        <!-- 「納入先CD」 -->
        <label>
            <span style="width:5.1em;">{{__('nounyusaki_cd')}}</span>
            <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
            <input name="dataNounyusakiCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off"
                style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{ __('半角英数字10文字以内で入力してください') }}" required>
        </label>
        </div>
        <div class="form-column">
            <!-- 「納入先略称」 -->
            <label>
                <span style="width:5.5em;">{{__('nounyusaki_ryaku')}}</span>
                <input name="dataNounyusakiRyaku" class="form-control" type="text" maxlength="20" autocomplete="off"
                    style="width:15em;">
            </label>
        </div>
        <div class="form-column">
            <!-- 「納入先名1」 -->
            <label>
                <span style="width:5.5em;">{{__('nounyusaki_name1')}}</span>
                <input name="dataNounyusakiName1" class="form-control" type="text" maxlength="30" autocomplete="off"
                    style="width:22em;">
            </label>
        </div>
        <div class="form-column">
            <!-- 「納入先名2」 -->
            <label>
                <span style="width:5.5em;">{{__('nounyusaki_name2')}}</span>
                <input name="dataNounyusakiName2" class="form-control" type="text" maxlength="30" autocomplete="off"
                    style="width:22em;">
            </label>
        </div>
        <div class="form-column">
            <!-- 「納入先カナ」 -->
            <label>
                <span style="width:5.5em;">{{__('nounyusaki_kana')}}</span>
                <input name="dataNounyusakiKana" class="form-control" type="text" maxlength="60" autocomplete="off"
                    style="width:22em;">
            </label>
        </div>
        <div class="form-column">
            <!-- 「納入場所」 -->
            <label>
                <span style="width:5.5em;">{{__('nounyubasho')}}</span>
                <input name="dataNounyubasho" class="form-control" type="text" maxlength="16" autocomplete="off"
                    style="width:8em;">
            </label>
        </div>
        <div class="form-column">
            <!-- 「事業部CD」 -->
            <label>
                <span style="width:5.1em;">{{__('jigyoubu_cd')}}</span>
                <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                    <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                    <input name="dataJigyoubuCd" class="form-control code-check" type="text" maxlength="6" autocomplete="off"
                        style="width:8em;" pattern="^([a-zA-Z0-9]{0,6})$" title="{{__('半角英数字6文字以内で入力してください')}}" required>
                    <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                    <i class="fas fa-search search-btn"></i>
                </span>
                <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                <input name="dataJigyoubuName" class="form-control" type="text" style="width:12em;" onfocus="blur();"
                    readonly>
            </label>
        </div>
        <div class="form-column">
            <!-- 「得意先CD」 -->
            <label>
                <span style="width:5.1em;">{{__('tokuisaki_cd')}}</span>
                <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                    <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                    <input name="dataTokuisakiCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off"
                        style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{__('半角英数字10文字以内で入力してください')}}" required>
                    <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                    <i class="fas fa-search search-btn"></i>
                </span>
                <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                <input name="dataTokuisakiName1" class="form-control" type="text" style="width:12em;" onfocus="blur();"
                    readonly>
            </label>
        </div>
    </div>
    <!-- 「ダイアログ右側」 -->
    <div class="flex-box flex-start flex-column item-start" style="padding-left:30px;">
        <div class="form-column">
            <!-- 「納入先ZIP」 -->
            <label>
                <span style="width:5.5em;">{{__('nounyusaki_zip')}}</span>
                <input name="dataNounyusakiZip" class="form-control" type="text" maxlength="10" autocomplete="off"
                    style="width:8em;">
            </label>
        </div>
        <div class="form-column">
            <!-- 「納入先住所1」 -->
            <label>
                <span style="width:5.5em;">{{__('nounyusaki_jusho1')}}</span>
                <input name="dataNounyusakiJusho1" class="form-control" type="text" maxlength="60" autocomplete="off"
                    style="width:22em;">
            </label>
        </div>
        <div class="form-column">
            <!-- 「納入先住所2」 -->
            <label>
                <span style="width:5.5em;">{{__('nounyusaki_jusho2')}}</span>
                <input name="dataNounyusakiJusho2" class="form-control" type="text" maxlength="60" autocomplete="off"
                    style="width:22em;">
            </label>
        </div>
        <div class="form-column">
            <!-- 「電話番号」 -->
            <label>
                <span style="width:5.5em;">{{__('tel_no')}}</span>
                <input name="dataTelNo" class="form-control" type="text" maxlength="14" autocomplete="off"
                    style="width:8em;">
            </label>
        </div>
        <div class="form-column">
            <!-- 「FAX番号」 -->
            <label>
                <span style="width:5.5em;">{{__('fax_no')}}</span>
                <input name="dataFaxNo" class="form-control" type="text" maxlength="14" autocomplete="off"
                    style="width:8em;">
            </label>
        </div>
        <div class="form-column">
            <!-- 「先方連絡先」 -->
            <label>
                <span style="width:5.5em;">{{__('senpou_renrakusaki')}}</span>
                <input name="dataSenpouRenrakusaki" class="form-control" type="text" maxlength="128" autocomplete="off"
                    style="width:22em;">
            </label>
        </div>
        <div class="form-column">
            <!-- 「有効期間（自）」 -->
            <label>
                <span style="width:8.4em;">{{__('yukoukikan_start_date')}}</span>
                <input id="dataStartDate" name="dataStartDate" type="hidden">
            </label>
        </div>
        <div class="form-column">
            <!-- 「登録日」 -->
            <label>
                <span style="width:10em;">{{__('touroku_dt')}}</span>
                <input name="dataTourokuDt" class="form-control-plaintext" type="text" readonly>
            </label>
        </div>
        <div class="form-column">
            <!-- 「更新日」 -->
            <label>
                <span style="width:10em;">{{__('koushin_dt')}}</span>
                <input name="dataKoushinDt" class="form-control-plaintext" type="text" readonly>
            </label>
        </div>
    </div>
</div>
<!-- 内部入力値 -->
<!-- 「処理種別」
　※入力ダイアログの操作、新規・修正・削除のどの処理で開いたかを判別 -->
<input id="dataSQLType" name="dataSQLType" type="hidden">
<!-- 「ログインID」 -->
<input name="dataLoginId" type="hidden" value="{{ $loginId }}">
<!-- 「レコードID」 -->
<input name="dataId" type="hidden">
@endsection

<!-- javascript -->
@section('javascript')
<script>
    /* -------------------- */
    /* wijmoコントロール宣言 */
    /* -------------------- */

    /* カレンダー宣言 */
    /* 有効期間（自） */
    var dateStart = new wijmo.input.InputDate('#dataStartDate', { isRequired: false });
    /* ------- */
    /* 初期処理 */
    /* ------- */

    /* ページ初期処理
         ※ページが読み込まれた際に一番初めに処理される関数 */
    window.onload = function()
    {
        /* 右クリック時の操作メニュー宣言 ※common_function.js参照 */
        SetContextMenu();
        /* ファンクションキーの操作宣言 ※common_function.js参照 */
        SetFncKey(null);
        /* 入力ダイアログ表示イベント登録 ※common_function.js参照 */
        SetNyuryokuData(fncNyuryokuData);
        /* 「表示」ボタンイベント登録 ※common_function.js参照 */
        SetBtnHyouji(fncShowDataGrid);
        /* 「Excel出力」ボタンイベント登録 ※common_function.js参照 */
        SetBtnExcel(fncExportExcel);

        /* グリッド初期処理*/
        InitGrid();

        /* ボタン制御更新 */
        SetEnableButton(0);
        /* 件数更新 */
        $("#zenkenCnt").html(0);

        /* グリッドデータの表示 */
        $('#btnHyouji').click();
    }
    /* グリッド共有変数 */
    var gridMaster;
    /* 選択された行
         ※MultiRowでの行選択処理のために必要（FlexGridでは不要） */
    var selectedRows = 0;
    /* グリッド初期処理*/
    function InitGrid()
    {
        /* MultiRowのレイアウト設定 */
        let columns = [{ cells: [{ binding: 'dataNounyusakiCd',   header: "{{__('nounyusaki_cd')}}", width: 130 }]},
                       { cells: [{ binding: 'dataNounyusakiName1',        header: "{{__('nounyusaki_name1')}}", width: 130 },
                                 { binding: 'dataNounyusakiName2',      header: "{{__('nounyusaki_name2')}}"}]},
                       { cells: [{ binding: 'dataNounyusakiRyaku',        header: "{{__('nounyusaki_ryaku')}}", width: 130 }]},
                       { cells: [{ binding: 'dataNounyusakiKana',         header: "{{__('nounyusaki_kana')}}", width:130 },]},
                       { cells: [{ binding: 'dataNounyubasho',      header: "{{__('nounyubasho')}}", width:130 }]},
                       { cells: [{ binding: 'dataJigyoubuCd', header: "{{__('jigyoubu_cd')}}", width: 130 },
                                 { binding: 'dataJigyoubuName',            header: "{{__('jigyoubu_name')}}"}]},
                       { cells: [{ binding: 'dataTokuisakiCd', header: "{{__('tokuisaki_cd')}}", width: 130 },
                                 { binding: 'dataTokuisakiName1',            header: "{{__('tokuisaki_name1')}}"}]},
                       { cells: [{ binding: 'dataNounyusakiJusho1',      header: "{{__('nounyusaki_jusho1')}}", width:130 },
                                 { binding: 'dataNounyusakiJusho2',      header: "{{__('nounyusaki_jusho2')}}", width:130 }]},
                       { cells: [{ binding: 'dataTelNo',      header: "{{__('tel_no')}}", width:130 },
                                 { binding: 'dataFaxNo',      header: "{{__('fax_no')}}", width:130 }]},
                       { cells: [{ binding: 'dataSenpouRenrakusaki',      header: "{{__('senpou_renrakusaki')}}", width:130 }]},
                       { cells: [{ binding: 'dataStartDate',          header: "{{__('yukoukikan_start_date')}}", width: 150 },
                                 { binding: 'dataEndDate',          header: "{{__('yukoukikan_end_date')}}"}] },
                       { cells: [{ binding: 'dataTourokuDt',            header: "{{__('touroku_dt')}}", width: 180 },
                                 { binding: 'dataKoushinDt',            header: "{{__('koushin_dt')}}"}] },
                       { cells: [{ binding: 'dataTourokushaName',            header: "{{__('tourokusha_name')}}", width: 180 },
                                 { binding: 'dataKoushinshaName',            header: "{{__('koushinsha_name')}}"}] }];
        /* グリッドの設定 */
        let gridOption = {
            /* レイアウト設定 ※MultiRow専用 */
            layoutDefinition: columns,
            /* 選択スタイル（セル単位） */
            selectionMode: wijmo.grid.SelectionMode.Cell,
            /* セル編集（無効） */
            isReadOnly: true,
            /* デフォルト行スタイル（0行ごとに色付け） */
            alternatingRowStep: 0,
            /* グリッド上でのEnterキーイベント（無効） */
            keyActionEnter: wijmo.grid.KeyAction.None,
            /* セル読み込み時のイベント */
            loadedRows: function (s, e)
            {
                /* 任意の色でセルを色付け
                     ※rowPerItemでMultiRowの1レコード当たりの行数を取得（今回はrowPerItem = 2）
                     ※common_function.js参照 */
                LoadGridRows(s, gridMaster.rowsPerItem);
            }
        }
        /* グリッド宣言 */
        gridMaster = new wijmo.grid.multirow.MultiRow('#gridMaster', gridOption);

        /* グリッド関連のイベント登録 */
        /* グリッドの親要素 */
        let host = gridMaster.hostElement;
        /* グリッドの「左クリック」イベント */
        gridMaster.addEventListener(host, 'click', function (e)
        {
            /* グリッドに選択する行が無い場合は処理をスキップ */
            if(gridMaster.itemsSource.length < 1) return;
            /* 選択した行番号を格納 */
            selectedRows = SetSelectedMultiRow(gridMaster, selectedRows);
            /* 選択した行のデータIDを格納 */
            SetSelectedRowId(gridMaster.collectionView.currentItem['dataId']);
        });

        /* グリッドの「右クリック」イベント */
        gridMaster.addEventListener(host, 'contextmenu', function (e)
        {
            /* セル上での右クリックメニュー表示 ※common_function.js参照 */
            SetGridContextMenu(gridMaster, e);
            /* グリッドに選択する行が無い場合は処理をスキップ */
            if(gridMaster.itemsSource.length < 1) return;
            /* クリックした位置を選択 */
            gridMaster.select(new wijmo.grid.CellRange(gridMaster.hitTest(e).row, 0), true);
            /* 選択した行番号を格納 */
            selectedRows = SetSelectedMultiRow(gridMaster, selectedRows);
            /* 選択した行のデータIDを格納 */
            SetSelectedRowId(gridMaster.collectionView.currentItem['dataId']);
        });

        /* グリッドの「ダブルクリック」イベント */
        gridMaster.addEventListener(host, 'dblclick', function (e)
        {
            /* 選択したセルがヘッダー要素でない場合は「修正」ボタンと同じ処理 */
            if(gridMaster.hitTest(e).cellType == wijmo.grid.CellType.Cell) $('#btnShusei').click();
        });

        /* グリッドの「キーボード」イベント */
        gridMaster.addEventListener(host, 'keydown', function (e)
        {
            /* 「←・↑・→・↓キー」はクリック時と同じ処理 */
            if(e.keyCode >= KEY_LEFT && e.keyCode <= KEY_DOWN)
            {
                /* グリッドに選択する行が無い場合は処理をスキップ */
                if(gridMaster.itemsSource.length < 1) return;
                /* 選択した行番号を格納 */
                selectedRows = SetSelectedMultiRow(gridMaster, selectedRows);
                /* 選択した行のデータIDを格納 */
                SetSelectedRowId(gridMaster.collectionView.currentItem['dataId']);
                /* キーボードイベント二重起動防止 */
                windowKeybordFlg = false;
            }
            /* 「Enterキー」は「修正」ボタンと同じ処理 */
            if(e.keyCode == KEY_ENTER)
            {
                $('#btnShusei').click();
                /* キーボードイベント二重起動防止 */
                windowKeybordFlg = false;
            }
        });
    }

    /* --------------------------- */
    /* ボタンイベント登録用の関数変数 */
    /* --------------------------- */

    /* 「表示」ボタンイベント */
    var fncShowDataGrid = function()
    {
        /* 検索フォーム要素 */
        let kensakuData = document.forms['frmKensaku'].elements;
        /* POST送信用オブジェクト配列 */
        let soushinData = {};
        /* フォーム要素から送信データを格納 */
        for(var i = 0; i< kensakuData.length; i++){
            /* フォーム要素のnameが宣言されている要素のみ処理 */
            if(kensakuData[i].name != ''){
                /* フォーム要素のnameを配列のキーしてPOSTデータの値を作成する */
                /* 検索値の末尾に検索条件キーを付与してLIKE検索をできるようにする ※LIKE_VALUE_BOTHは部分一致検索 */
                soushinData[kensakuData[i].name] = (kensakuData[i].value != '') ? (kensakuData[i].value + LIKE_VALUE_BOTH) : '';
            }
        }
        /* 「データ読込中」表示 */
        ShowPopupDlg("{{ __('データ読込中') }}");
        /* グリッドのデータ受信 */
        AjaxData("{{ url('/master/1600') }}", soushinData, fncJushinGridData);
    }
    /* 「Excel出力」ボタンイベント */
    var fncExportExcel = function()
    {
        /* Excel出力用グリッドのレイアウト設定 */
        let columns = [
                    { binding: 'dataNounyusakiCd',   header: "{{__('nounyusaki_cd')}}"},
                    { binding: 'dataNounyusakiName1', header: "{{__('nounyusaki_name1')}}"},
                    { binding: 'dataNounyusakiName2', header: "{{__('nounyusaki_name2')}}"},
                    { binding: 'dataNounyusakiKana', header: "{{__('nounyusaki_kana')}}"},
                    { binding: 'dataNounyusakiRyaku', header: "{{__('nounyusaki_ryaku')}}"},
                    { binding: 'dataJigyoubuCd', header: "{{__('jigyoubu_cd')}}"},
                    { binding: 'dataJigyoubuName',            header: "{{__('jigyoubu_name')}}"},
                    { binding: 'dataTokuisakiCd',        header: "{{__('tokuisaki_cd')}}"},
                    { binding: 'dataTokuisakiName1',      header: "{{__('tokuisaki_name1')}}"},
                    { binding: 'dataNounyusakiJusho1',      header: "{{__('nounyusaki_jusho1')}}"},
                    { binding: 'dataNounyusakiJusho2',      header: "{{__('nounyusaki_jusho2')}}"},
                    { binding: 'dataNounyubasho',      header: "{{__('nounyubasho')}}"},
                    { binding: 'dataTelNo',      header: "{{__('tel_no')}}"},
                    { binding: 'dataFaxNo',      header: "{{__('fax_no')}}"},
                    { binding: 'dataSenpouRenrakusaki',      header: "{{__('senpou_renrakusaki')}}"},
                    { binding: 'dataStartDate',          header: "{{__('yukoukikan_start_date')}}"},
                    { binding: 'dataEndDate',          header: "{{__('yukoukikan_end_date')}}"},
                    { binding: 'dataTourokuDt',            header: "{{__('touroku_dt')}}"},
                    { binding: 'dataTourokushaName',            header: "{{__('tourokusha_name')}}"},
                    { binding: 'dataKoushinDt',            header: "{{__('koushin_dt')}}"},
                    { binding: 'dataKoushinshaName',            header: "{{__('koushinsha_name')}}"}];
        /* 現在のグリッドの並び替え条件取得 */
        let sortState = gridMaster.collectionView.sortDescriptions.map(
            function (sd)
            {
                /* 並び替え条件をオブジェクト配列として返す */
                return { property: sd.property, ascending: sd.ascending }
            }
        );
        /* Excel出力時の並び替え条件を設定 */
        let sortDesc = new wijmo.collections.SortDescription(sortState[0].property, sortState[0].ascending);
        /* Excelファイル作成
             ※ファイル名は「ページタイトル+yyyymmddhhMMss（年月日時分秒）+.csv」
             ※common_function.js参照 */
        ExportExcelFile(gridMaster.itemsSource, columns, sortDesc, '{{ $pageTitle }}'+ getNowDateTime() +'.csv');
    }
    /* 「新規・参照新規・修正・削除」ボタンイベント
         ※mode → 入力ダイアログの操作、新規・修正・削除のどの処理で開いたかを判別する処理種別
         　copy → 参照新規や修正などで選択行のレコード情報を初期入力させるかの判定 */
    var fncNyuryokuData = function(mode, copy)
    {
        /* 入力フォーム要素 */
        let nyuryokuData = document.forms['frmNyuryoku'].elements;
        /* 選択行のグリッドデータ */
        let data = gridMaster.collectionView.currentItem;
        /* 「新規」処理フラグ */
        let insertFlg = (mode == MODE_INSERT);

        /* 「処理種別」 */
        nyuryokuData['dataSQLType'].value = mode;
        /* 「納入先CD」 */
        nyuryokuData['dataNounyusakiCd'].value = (copy && !insertFlg) ? data['dataNounyusakiCd'] : '';
        nyuryokuData['dataNounyusakiCd'].disabled = !insertFlg;
        /* 「納入先略称」 */
        nyuryokuData['dataNounyusakiRyaku'].value = copy ? data['dataNounyusakiRyaku'] : '';
        /* 「納入先名1」 */
        nyuryokuData['dataNounyusakiName1'].value = copy ? data['dataNounyusakiName1'] : '';
        /* 「納入先名1」 */
        nyuryokuData['dataNounyusakiName2'].value = copy ? data['dataNounyusakiName2'] : '';
        /* 「納入先カナ」 */
        nyuryokuData['dataNounyusakiKana'].value = copy ? data['dataNounyusakiKana'] : '';
        /* 「納入先ZIP」 */
        nyuryokuData['dataNounyusakiZip'].value = copy ? data['dataNounyusakiZip'] : '';
        /* 「納入場所」 */
        nyuryokuData['dataNounyubasho'].value = copy ? data['dataNounyubasho'] : '';
        /* 「事業部CD」 */
        nyuryokuData['dataJigyoubuCd'].value = copy ? data['dataJigyoubuCd'] : '';
        /* 「事業部名」 */
        nyuryokuData['dataJigyoubuName'].value = copy ? data['dataJigyoubuName'] : '';
        /* 「得意先CD」 */
        nyuryokuData['dataTokuisakiCd'].value = copy ? data['dataTokuisakiCd'] : '';
        /* 「得意先名1」 */
        nyuryokuData['dataTokuisakiName1'].value = copy ? data['dataTokuisakiName1'] : '';
        /* 「納入先住所1」 */
        nyuryokuData['dataNounyusakiJusho1'].value = copy ? data['dataNounyusakiJusho1'] : '';
        /* 「納入先住所2」 */
        nyuryokuData['dataNounyusakiJusho2'].value = copy ? data['dataNounyusakiJusho2'] : '';
        /* 「電話番号」 */
        nyuryokuData['dataTelNo'].value = copy ? data['dataTelNo'] : '';
        /* 「FAX番号」 */
        nyuryokuData['dataFaxNo'].value = copy ? data['dataFaxNo'] : '';
        /* 「先方連絡先」 */
        nyuryokuData['dataSenpouRenrakusaki'].value = copy ? data['dataSenpouRenrakusaki'] : '';
        /* 「有効期間（自）」 */
        dateStart.value = !insertFlg ? data['dataStartDate'] : getNowDate();
        /* 「登録日時」 */
        nyuryokuData['dataTourokuDt'].value = !insertFlg ? data['dataTourokuDt'] : '';
        /* 「更新日時」 */
        nyuryokuData['dataKoushinDt'].value = !insertFlg ? data['dataKoushinDt'] : '';

        /* ボタンのキャプション */
        let btnCaption = ["{{ __('登録') }}","{{ __('更新') }}","{{ __('削除') }}"];
        nyuryokuData['btnKettei'].value = "{{__('F9')}}" + btnCaption[mode - 1];

        /* 「削除」処理フラグ
             ※削除処理時は入力機能を制限して閲覧のみにする */
        let deleteFlg = (mode == MODE_DELETE);
        /* レコードID ※削除時のみ必要 */
        nyuryokuData['dataId'].value = deleteFlg ? data['dataId'] : '';
        /* 検索ボタン ※削除時のみ制限 */
        nyuryokuData['btnSanshou'].disabled = deleteFlg;
        nyuryokuData['dataNounyusakiRyaku'].disabled = deleteFlg;   /* 「納入先略称」 */
        nyuryokuData['dataNounyusakiName1'].disabled = deleteFlg;   /* 「納入先名1」 */
        nyuryokuData['dataNounyusakiName2'].disabled = deleteFlg;   /* 「納入先名2」 */
        nyuryokuData['dataNounyusakiKana'].disabled = deleteFlg;    /* 「納入先カナ」 */
        nyuryokuData['dataNounyusakiZip'].disabled = deleteFlg;     /* 「納入先ZIP」 */
        nyuryokuData['dataNounyubasho'].disabled = deleteFlg;       /* 「納入場所」 */
        nyuryokuData['dataJigyoubuCd'].disabled = deleteFlg;        /* 「事業部CD」 */
        nyuryokuData['dataTokuisakiCd'].disabled = deleteFlg;       /* 「得意先CD」 */
        nyuryokuData['dataNounyusakiJusho1'].disabled = deleteFlg;  /* 「納入先住所1」 */
        nyuryokuData['dataNounyusakiJusho2'].disabled = deleteFlg;  /* 「納入先住所2」 */
        nyuryokuData['dataTelNo'].disabled = deleteFlg;             /* 「電話番号」 */
        nyuryokuData['dataFaxNo'].disabled = deleteFlg;             /* 「FAX番号」 */
        nyuryokuData['dataSenpouRenrakusaki'].disabled = deleteFlg; /* 「先方連絡先」 */
        dateStart.isDisabled = deleteFlg;                           /* 「有効期間（自）」 */

        /* 入力フォームのスタイル初期化 ※common_function.js参照　*/
        InitFormStyle();
    }

    /* ----------------------------- */
    /* 非同期処理呼び出し養用の関数変数 */
    /* ----------------------------- */
    /* ※data → 非同期通信で受信したjsonデータ配列
         　errorFlg → 非同期通信先のエラー処理判定 */

    /* データグリッド更新 */
    var fncJushinGridData = function(data, errorFlg)
    {
        /* 「データ更新中」非表示 */
        ClosePopupDlg();
        /* データエラー判定 ※common_function.js参照 */
        if(IsAjaxDataError(data, errorFlg)) return;
        /* ボタン制御更新 */
        SetEnableButton(data[1].length);
        /* 件数更新 */
        $("#zenkenCnt").html(data[1].length);
        /* グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 */
        selectedRows = SortMultiRowData(gridMaster, data[1], 'dataNounyusakiCd');
    }

    /* DBデータ更新 */
    var fncUpdateData = function(data, errorFlg)
    {
        /* 「データ更新中」非表示 */
        ClosePopupDlg();
        /* データエラー判定 ※common_function.js参照 */
        if(!IsAjaxDataError(data, errorFlg))
        {
            /* 「データ更新完了」表示 */
            ShowAlertDlg('データ更新完了');
            /* 選択行のデータIDを保持 ※common_function.js参照 */
            SetSelectedRowId(data[2][0]);
            /* 入力ダイアログを閉じる */
            CloseNyuryokuDlg();
            /* グリッドデータの表示 */
            $('#btnHyouji').click();
        }
        else
        {
            /* エラー時処理 */
            /* データ判定対象要素 */
            let targetElement = data[2];
            /* 対象要素のCSSテキスト */
            let classText = '';
            /* 対象要素のCSSテキストを書き換える
                 ※コード検査を行う項目は、スタイルクラス「code-check」が宣言されている */
            for(let i=0; i<$('.code-check').length; i++)
            {
                /* 対象要素のCSSテキストを取得 */
                classText = $('.code-check')[i].className;
                /* 既にエラー表示の対象要素をリセット */
                $('.code-check')[i].className = classText.replace('code-check-error', '');
                for(let j=0;j<targetElement.length;j++)
                {
                    /* 対象要素であるか判定 */
                    if($('.code-check')[i].name == targetElement[j])
                    {
                        /* エラー判定の対象要素のスタイルクラスに「code-check-error」を付与して強調表示（赤枠） */
                        $('.code-check')[i].className = classText + ' code-check-error';
                    }
                }
            }
        }
    }

    /* ------------------------ */
    /* その他入力コントロール処理 */
    /* ------------------------ */

    /* 入力ダイアログ　「決定」ボタン　クリック処理 */
    $('#frmNyuryoku').submit(function(event)
    {
        /* 関数内関数 */
        /* 編集ダイアログ入力値変更判定 */
        function IsChangeNyuryokuData(nyuryokuData)
        {
            /* 選択行のグリッドデータ */
            let data = gridMaster.collectionView.currentItem;
            /* 更新処理以外の処理の場合は判定せずにtrue */
            if(nyuryokuData['dataSQLType'].value != MODE_UPDATE) return true;
            /* 「得意先CD」 */
            if(nyuryokuData['dataTokuisakiCd'].value != data['dataTokuisakiCd']) return true;
            /* 「事業部CD」 */
            if(nyuryokuData['dataJigyoubuCd'].value != data['dataJigyoubuCd']) return true;
            /* 「納入先略称」 */
            if((nyuryokuData['dataNounyusakiRyaku'].value != data['dataNounyusakiRyaku']) &&
              !(nyuryokuData['dataNounyusakiRyaku'].value == '' && data['dataNounyusakiRyaku'] == null)) return true;
            /* 「納入先名1」 */
            if((nyuryokuData['dataNounyusakiName1'].value != data['dataNounyusakiName1']) &&
              !(nyuryokuData['dataNounyusakiName1'].value == '' && data['dataNounyusakiName1'] == null)) return true;
            /* 「納入先名2」 */
            if((nyuryokuData['dataNounyusakiName2'].value != data['dataNounyusakiName2']) &&
              !(nyuryokuData['dataNounyusakiName2'].value == '' && data['dataNounyusakiName2'] == null)) return true;
            /* 「納入先名カナ」 */
            if((nyuryokuData['dataNounyusakiKana'].value != data['dataNounyusakiKana']) &&
              !(nyuryokuData['dataNounyusakiKana'].value == '' && data['dataNounyusakiKana'] == null)) return true;
            /* 「納入先名ZIP」 */
            if((nyuryokuData['dataNounyusakiZip'].value != data['dataNounyusakiZip']) &&
              !(nyuryokuData['dataNounyusakiZip'].value == '' && data['dataNounyusakiZip'] == null)) return true;
            /* 「納入先名住所1」 */
            if((nyuryokuData['dataNounyusakiJusho1'].value != data['dataNounyusakiJusho1']) &&
              !(nyuryokuData['dataNounyusakiJusho1'].value == '' && data['dataNounyusakiJusho1'] == null)) return true;
            /* 「納入先名住所2」 */
            if((nyuryokuData['dataNounyusakiJusho2'].value != data['dataNounyusakiJusho2']) &&
              !(nyuryokuData['dataNounyusakiJusho2'].value == '' && data['dataNounyusakiJusho2'] == null)) return true;
            /* 「納入場所」 */
            if((nyuryokuData['dataNounyubasho'].value != data['dataNounyubasho']) &&
              !(nyuryokuData['dataNounyubasho'].value == '' && data['dataNounyubasho'] == null)) return true;
            /* 「電話番号」 */
            if((nyuryokuData['dataTelNo'].value != data['dataTelNo']) &&
              !(nyuryokuData['dataTelNo'].value == '' && data['dataTelNo'] == null)) return true;
            /* 「FAX番号」 */
            if((nyuryokuData['dataFaxNo'].value != data['dataFaxNo']) &&
              !(nyuryokuData['dataFaxNo'].value == '' && data['dataFaxNo'] == null)) return true;
            /* 「先方連絡先」 */
            if((nyuryokuData['dataSenpouRenrakusaki'].value != data['dataSenpouRenrakusaki']) &&
              !(nyuryokuData['dataSenpouRenrakusaki'].value == '' && data['dataSenpouRenrakusaki'] == null)) return true;
            /* 「有効期間（自）」 */
            if(nyuryokuData['dataStartDate'].value != data['dataStartDate']) return true;
            /* 上記項目に変更が無い場合はfalse */
            return false;
        }

        /* HTMLでの送信をキャンセル */
        event.preventDefault();
        /* 入力フォーム要素 */
        let nyuryokuData = document.forms['frmNyuryoku'].elements;
        /* 「データチェック中」表示 */
        ShowPopupDlg("{{ __('データチェック中') }}");
        /* データ更新判定
             ※修正処理の際、変更箇所が無い場合は更新処理をしない */
        if(!IsChangeNyuryokuData(nyuryokuData))
        {
            /* エラーメッセージ表示 */
            ShowAlertDlg("{{__('更新されたデータがありません')}}");
            /* 「データチェック中」非表示 */
            ClosePopupDlg();
            return;
        }
        /* POST送信用オブジェクト配列 */
        let soushinData = {};
        /* フォーム要素から送信データを格納 */
        for(var i = 0; i< nyuryokuData.length; i++){
            /* フォーム要素のnameが宣言されている要素のみ処理 */
            if(nyuryokuData[i].name != ''){
                /* フォーム要素のnameを配列のキーしてPOSTデータの値を作成する */
                soushinData[nyuryokuData[i].name] = nyuryokuData[i].value;
            }
        }
        soushinHantei = new Array;
        soushinHantei2 = new Array;
        soushinHantei = Object.values(soushinData);
        soushinHantei2 = Object.keys(soushinData);
        for(i = 0; i < Object.keys(soushinData).length; i++){
            if(soushinHantei[i] === 'undefined'){
                soushinData[soushinHantei2[i]] = null;
            }
        }
        /* 「データチェック中」非表示 */
        ClosePopupDlg();
        /* 削除処理時、確認ダイアログを表示 */
        if(nyuryokuData['dataSQLType'].value == MODE_DELETE)
        {
            /* 確認ダイアログを経由して処理 */
            ShowConfirmDlg("このレコードを削除しますか？",
            /* OKボタンを押したときの処理 */
            function()
            {
                /* 「データ更新中」表示 */
                ShowPopupDlg("{{__('データ更新中')}}");
                /* 非同期データ更新開始 */
                AjaxData("{{ url('/master/1601') }}", soushinData, fncUpdateData);
            }, null);
        }
        else
        {
            /* 「データ更新中」表示 */
            ShowPopupDlg("{{__('データ更新中')}}");
            console.log(soushinData,"soushinData");
            /* 非同期データ更新開始 */
            AjaxData("{{ url('/master/1601') }}", soushinData, fncUpdateData);
        }
    });
    /* テキスト変更時に連動するテキスト要素のリセット処理 */
    $('input[type="text"]').change(function() {
        /* 連動テキスト要素のある要素を判別 */
        switch($(this)[0].name)
        {
            /* 事業部CD */
            case 'dataJigyoubuCd': break;
            /* 該当しない場合は処理終了 */
            break;
            /* 得意先CD */
            case 'dataTokuisakiCd': break;
            /* 該当しない場合は処理終了 */
            default: return;
            break;
        }
        let targetElement = $(this).parent().next("input")[0];
        /* 連動テキスト要素が存在し、かつテキストの変更不可の要素である場合は処理 */
        if(targetElement && targetElement.readOnly) targetElement.value = '';
    });

    /* クリックされた直近の要素（コード系） */
    var currentCdElement = null;
    /* クリックされた直近の要素（名前系） */
    var currentNameElement = null;

    /* テキスト要素にフォーカスを当てた時の処理 */
    $('input[type="text"]').on("focusin", function(e) {
        /* フォーカスした要素を格納（コード系） */
        currentCdElement = $(':focus')[0];
        /* フォーカスした要素の親要素の次にある要素を格納（名前系） */
        currentNameElement = $(this).parent().next("input")[0];
    });
    /* 「参照」ボタンアイコン　クリック処理 */
    $('.search-btn').click(function() {
        /* フォーカスした要素の前の要素を格納（コード系） */
        currentCdElement = $(this).prev("input")[0];
        /* フォーカスした要素の親要素の次にある要素を格納（名前系） */
        currentNameElement = $(this).parent().next("input")[0];
        /* 参照ボタン処理を実行 */
        $('.btnSanshou').click();
    });
    /* 「参照」ボタン　クリック処理 */
    $('.btnSanshou').click(function() {
        /* 処理種別が「削除」の場合は処理をスキップ */
        if(currentCdElement.disabled) return;
        /* 選択対象の名前を判別 */
        switch(currentCdElement.name)
        {
            /* 事業部CD */
            case 'dataJigyoubuCd':
            ShowSentakuDlg("{{ __('jigyoubu_cd') }}", "{{ __('jigyoubu_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0100') }}");
            break;
            /* 得意先CD */
            case 'dataTokuisakiCd':
            ShowSentakuDlg("{{ __('tokuisaki_cd') }}", "{{ __('tokuisaki_name1') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1400') }}");
            break;
        }
    });
</script>
@endsection
