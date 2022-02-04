<!-- PHP処理 -->
<?php
    // 「loginId」が送信されていなければ0を設定
    if(!isset($loginId)) $loginId = 0;
    // 「categoryCd」が送信されていなければ無しを設定
    if(!isset($categoryCd)) $categoryCd = '';

    // 検索フォームの高さ
    $kensakuHight = '100px';
    if(empty($categoryCd)) $kensakuHight = '140px';
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
        <!-- 「カテゴリー」 -->
        <label id="categoryCd">
            <span style="width:6em;">{{__('カテゴリー')}}</span>
            <div id="cmbCategory" style="width:18em;"></div>
        </label>
        <!-- 「分類CD」 -->
        <label class="kensakuBunrui">
            <span class="koumokuName1" style="width:4.5em;"></span>
            <input name="dataBunruiCd" class="form-control" type="text" maxlength="10" autocomplete="off"
                style="width:10em;">
        </label>
        <!-- 「分類名」 -->
        <label class="kensakuBunrui">
            <span class="koumokuName2" style="width:4.5em;"></span>
            <input name="dataBunruiName" class="form-control" type="text" maxlength="20" style="width:16em;"
                autocomplete="off">
        </label>
    </div>
</form>
@endsection

<!-- 「入力ダイアログ」 -->
@section('nyuryoku')
<!-- 入力フォーム全体 -->
<div class="flex-box flex-column" style="padding:5px 10px;">
    <!-- カテゴリー -->
    <input id="dataCategoryCd" name="dataCategoryCd" type="hidden" value="{{ $categoryCd }}">
    <!-- 階層レベルが2以上の設定の場合は表示する -->
    <div id="kaisouLevel">
        <!-- 「階層レベル」 -->
        <div class="flex-box" style="height: 2.5em; align-items: center;">
            <span style="width:5.5em;">{{__('jikaisou_level')}}</span>
            <div style="width: 50%; display: flex; justify-content: space-between; margin-left: 10px;">
                <div class="form-check">
                    <input name="dataKaisouLevel" id="kaisouLevel1" class="form-check-input kaisouLevel" type="radio"
                        value="1">
                    <label class="form-check-label" for="kaisouLevel1">01</label>
                </div>
                <div class="form-check kaisouLevel2">
                    <input name="dataKaisouLevel" id="kaisouLevel2" class="form-check-input kaisouLevel" type="radio"
                        value="2">
                    <label class="form-check-label" for="kaisouLevel2">02</label>
                </div>
                <div class="form-check kaisouLevel3">
                    <input name="dataKaisouLevel" id="kaisouLevel3" class="form-check-input kaisouLevel" type="radio"
                        value="3">
                    <label class="form-check-label" for="kaisouLevel3">03</label>
                </div>
            </div>
        </div>
        <div class="form-column">
            <!-- 「親分類CD」 -->
            <label>
                <span style="width:4.5em;"><span class="koumokuName1"></span></span>
                <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                    <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                    <input name="dataOyaBunruiCd" class="form-control code-check" type="text" maxlength="6"
                        autocomplete="off" style="width:8em;" pattern="^([a-zA-Z0-9]{0,6})$"
                        title="{{ __('半角英数字6文字以内で入力してください') }}" required>
                    <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                    <i class="fas fa-search search-btn"></i>
                </span>
                <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                <input name="dataOyaBunruiName" class="form-control" type="text" style="width:12em;" onfocus="blur();"
                    readonly>
            </label>
        </div>
    </div>
    <div class="form-column">
        <!-- 「分類CD」 -->
        <label>
            <span class="koumokuName1" style="width:4.5em;"></span>
            <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
            <input name="dataBunruiCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off"
                style="width:8em;" pattern="^([a-zA-Z0-9]{0,6})$" title="{{ __('半角英数字6文字以内で入力してください') }}" required>
        </label>
    </div>
    <div class="form-column">
        <!-- 「分類名」 -->
        <label>
            <span class="koumokuName2" style="width:4.5em;"></span>
            <input name="dataBunruiName" class="form-control" type="text" maxlength="20" autocomplete="off"
                style="width:22em;" required>
        </label>
    </div>
    <div class="form-column tsuikaJouhou">
        <!-- 「追加情報」 -->
        <label>
            <span class="koumokuName3" style="width:4.5em;"></span>
            <input name="dataTsuikajouhou" class="form-control" type="text" maxlength="10" autocomplete="off"
                style="width:12em;">
        </label>
    </div>
    <div class="form-column">
        <!-- 「有効期間（自）」 -->
        <label>
            <span>{{__('yukoukikan_start_date')}}</span>
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
<!-- 内部入力値 -->
<!-- 「処理種別」
　※入力ダイアログの操作、新規・修正・削除のどの処理で開いたかを判別 -->
<input id="dataSQLType" name="dataSQLType" type="hidden">
<!-- 「ログインID」 -->
<input name="dataLoginId" type="hidden" value="{{ $loginId }}">
<!-- 「レコードID」 -->
<input name="dataId" type="hidden">
@endsection

@section('addContents')
<!--親階層選択ダイアログ-->
<div id="dlgOyaBunrui" style="width:50em; height:400px;">
    <!--ダイアログヘッダー-->
    <div class="wj-dialog-header" style="padding :5px;">
        {{ __('選択画面') }}
    </div>
    <!--フォーム-->
    <div style="padding:5px 10px;">
        <!--選択データ一覧-->
        <div id="gridOyabunruiSentaku" style="height:300px;"></div>
    </div>
    <!--ダイアログフッター-->
    <div class="flex-box flex-end" style="padding:5px 10px">
        <!--選択ボタン-->
        <button id="btn" class="btn btn-primary" type="button" onclick="SetOyabunruiSentakuValue();"
            style="margin-right:10px;">
            {{__('F9').__('選択')}}
        </button>
        <!--戻るボタン-->
        <button class="btn btn-primary" type="button" onclick="CloseOyabunruiSentakuDlg();">
            {{__('F12').__('戻る')}}
        </button>
    </div>
</div>
@endsection

<!-- javascript -->
@section('javascript')
<script>
    /* -------------------- */
    /* wijmoコントロール宣言 */
    /* -------------------- */
    /* カテゴリーデータ */
    var categoryData;

    /* カテゴリー種別 */
    var category = [];
    /* 分類管理CD */
    var categoryCd = [];
    /* コンボボックス宣言 */
    var cmbCategory = new wijmo.input.ComboBox('#cmbCategory',{
        selectedIndexChanged: (sender) => {
            if(categoryData.length < 1) return;
            $('.koumokuName1').text(categoryData[sender.selectedIndex].dataKoumokuName1);
            $('.koumokuName2').text(categoryData[sender.selectedIndex].dataKoumokuName2);
            if(categoryData[sender.selectedIndex].dataKanriLevel > 1)
            {
                /* 検索フォーム要素 */
                let kensakuData = document.forms['frmKensaku'].elements;
                kensakuData['dataBunruiCd'].value = '';
                kensakuData['dataBunruiName'].value = '';
                $('.kensakuBunrui').css({'cssText': 'display:none;'});
            }
            else
            {
                $('.kensakuBunrui').css({'cssText': ''});
            }
            /* グリッドデータの表示 */
            $('#btnHyouji').click();
        }
    });

    /* カレンダー宣言 */
    /* 有効期間（自） */
    var dateStart = new wijmo.input.InputDate('#dataStartDate');

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
        gridMaster = InitGrid('#gridMaster');

        /* カテゴリCD */
        let categoryCd = $('#dataCategoryCd').val();
        if(categoryCd != '') $('#categoryCd').css({'cssText': 'display:none;'});

        /* 親分類CD選択ダイアログ */
        SetOyabunruiSentakuDlg(new wijmo.input.Popup('#dlgOyaBunrui'));

        /* カテゴリー初期処理 */
        AjaxData("{{ url('/master/1200') }}", { 'dataCategoryCd' : categoryCd }, fncJushinCategoryData);
    }
    /* グリッド共有変数 */
    var gridMaster;
    /*  */
    var gridMasterData;
    /*  */
    var currentGrid;
    /* グリッド初期処理*/
    function InitGrid(gridElement)
    {
        let grid;
        /* FlexGridのレイアウト設定 */
        let columns = [
            {
                binding: 'dataJikaisouLevel',
                header : "{{__('階層')}}",
                width  : 50
            },
            {
                binding: 'dataBunruiCd',
                header : '',
                width  : 100
            },
            {
                binding: 'dataBunruiName',
                header : '',
                width  : '1*'
            },
            {
                binding: 'dataOyaBunruiCd',
                header : '',
                width  : 100
            },
            {
                /* 「有効期間（自）」 */
                binding: 'dataStartDate',
                header : "{{ __('yukoukikan_start_date') }}",
                width  : 150
                    
            },
            {
                /* 「有効期間（至）」 */
                binding: 'dataEndDate',
                header : "{{ __('yukoukikan_end_date') }}",
                width  : 150
            }
        ]; 
        /* グリッドの設定 */
        let gridOption = {
            /* レイアウト設定 */
            columns: columns,
            /* 選択スタイル（セル単位） */
            selectionMode: wijmo.grid.SelectionMode.Row,
            /* セル編集（無効） */
            isReadOnly: true,
            /* デフォルト行スタイル（0行ごとに色付け） */
            alternatingRowStep: 0,
            /* グリッド上でのEnterキーイベント（無効） */
            keyActionEnter: wijmo.grid.KeyAction.None,
            /* グリッド自動生成 */
            autoGenerateColumns: false,
            /* セル読み込み時のイベント */
            loadedRows: function (s, e)
            {
                /* 任意の色でセルを色付け
                     ※common_function.js参照 */
                LoadGridRows(s, 1);
            }
        }       
        /* グリッド宣言 */
        grid = new wijmo.grid.FlexGrid(gridElement, gridOption);

        /* グリッド関連のイベント登録 */
        /* グリッドの親要素 */
        let host = grid.hostElement;
        /* グリッドの「左クリック」イベント */
        grid.addEventListener(host, 'click', function (e)
        {
            if(grid.itemsSource.length < 1 || grid.collectionView.currentItem == null) return; 
            currentGrid = grid;
        });

        /* グリッドの「右クリック」イベント */
        grid.addEventListener(host, 'contextmenu', function (e)
        {
            if(grid.itemsSource.length < 1 || grid.collectionView.currentItem == null) return; 
            currentGrid = grid;
            /* セル上での右クリックメニュー表示 ※common_function.js参照 */
            SetGridContextMenu(grid, e);
            /* グリッドに選択する行が無い場合は処理をスキップ */
            if(grid.itemsSource.length < 1) return;
            /* クリックした位置を選択 */
            grid.select(new wijmo.grid.CellRange(grid.hitTest(e).row, 0), true);
        });

        /* グリッドの「ダブルクリック」イベント */
        grid.addEventListener(host, 'dblclick', function (e)
        {
            if(grid.itemsSource.length < 1 || grid.collectionView.currentItem == null) return; 
            /* 選択したセルがヘッダー要素でない場合は「修正」ボタンと同じ処理 */
            if(grid.hitTest(e).cellType == wijmo.grid.CellType.Cell) $('#btnShusei').click();
        });

        /* グリッドの「キーボード」イベント */
        grid.addEventListener(host, 'keydown', function (e)
        {
            if(grid.itemsSource.length < 1 || grid.collectionView.currentItem == null) return; 
            /* 「Enterキー」は「修正」ボタンと同じ処理 */
            if(e.keyCode == KEY_ENTER)
            {
                $('#btnShusei').click();
                /* キーボードイベント二重起動防止 */
                windowKeybordFlg = false;
            }
        });
        currentGrid = grid;
        return grid;
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
        /* 「データ更新中」表示 */
        ShowPopupDlg("{{ __('データ更新中') }}");
        /* 初期コンボボックスのカテゴリーを選択 */
        soushinData["dataCategoryCd"] = categoryCd[cmbCategory.selectedIndex];
        /* グリッドのデータ受信 */
        AjaxData("{{ url('/master/1300') }}", soushinData, fncJushinGridData);
    }
    /* 「Excel出力」ボタンイベント */
    var fncExportExcel = function()
    {
        /* Excel出力用グリッドのレイアウト設定 */
        let columns = [{ binding: 'dataJikaisouLevel', header : "{{ __('階層') }}" }];
        columns.push({ binding: 'dataBunruiCd',   header : categoryData[cmbCategory.selectedIndex].dataKoumokuName1 });
        columns.push({ binding: 'dataBunruiName', header : categoryData[cmbCategory.selectedIndex].dataKoumokuName2 });
        let tsuikajouhou = categoryData[cmbCategory.selectedIndex].dataKoumokuName3;
        if(tsuikajouhou != '' && tsuikajouhou != null) columns.push({ binding: 'dataTsuikajouhou',  header : tsuikajouhou });
        /* 管理レベルが2以上の場合 */
        if(categoryData[cmbCategory.selectedIndex].dataKanriLevel > 1)
        {
            columns.push({ binding: 'dataOyaBunruiCd',   header : categoryData[cmbCategory.selectedIndex].dataOyaKoumokuName1 });
        }
        columns.push({ binding: 'dataStartDate', header : "{{ __('yukoukikan_start_date') }}" });
        columns.push({ binding: 'dataEndDate',   header : "{{ __('yukoukikan_end_date') }}" });
        /* 現在のグリッドの並び替え条件取得 */
        let sortState = gridMaster.collectionView.sortDescriptions.map(
            function (sd)
            {
                /* 並び替え条件をオブジェクト配列として返す */
                return { property: sd.property, ascending: sd.ascending }
            }
        );
        /* CSV出力時の並び替え条件を設定 */
        let sortDesc = null;
        if(sortState.length > 0) sortDesc = new wijmo.collections.SortDescription(sortState[0].property, sortState[0].ascending);
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
        let data = currentGrid.collectionView.currentItem;
        /* 「新規」処理フラグ */
        let insertFlg = (mode == MODE_INSERT);
        /* 「処理種別」 */
        nyuryokuData['dataSQLType'].value = mode;
        /* 「階層レベル」 */
        $('.kaisouLevel')[copy ? parseInt(data['dataJikaisouLevel']) - 1 : 0].checked = true;
        nyuryokuData['dataKaisouLevel'][0].disabled = !insertFlg; /* 「階層レベル」 */
        nyuryokuData['dataKaisouLevel'][1].disabled = !insertFlg; /* 「階層レベル」 */
        nyuryokuData['dataKaisouLevel'][2].disabled = !insertFlg; /* 「階層レベル」 */
        /* 「分類CD」 */
        nyuryokuData['dataBunruiCd'].value = (copy && !insertFlg) ? data['dataBunruiCd'] : '';
        nyuryokuData['dataBunruiCd'].maxLength = categoryData[cmbCategory.selectedIndex].dataKetaKoumoku1;
        nyuryokuData['dataBunruiCd'].disabled = !insertFlg;
        /* 「分類名」 */
        nyuryokuData['dataBunruiName'].value = copy ? data['dataBunruiName'] : '';
        nyuryokuData['dataBunruiName'].maxLength = categoryData[cmbCategory.selectedIndex].dataKetaKoumoku2;
        /* 「親分類CD」 */
        nyuryokuData['dataOyaBunruiCd'].value = copy ? data['dataOyaBunruiCd'] : '';
        nyuryokuData['dataOyaBunruiCd'].disabled = true;
        /* 「参照」ボタン */
        nyuryokuData['btnSanshou'].disabled = !insertFlg;
        /* 「親分類名」 */
        nyuryokuData['dataOyaBunruiName'].value = copy ? data['dataOyaBunruiName'] : '';
        /* 「追加情報」 */
        nyuryokuData['dataTsuikajouhou'].value = copy ? data['dataTsuikajouhou'] : '';
        nyuryokuData['dataTsuikajouhou'].maxLength = categoryData[cmbCategory.selectedIndex].dataKetaKoumoku3;
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
        nyuryokuData['dataBunruiName'].disabled = deleteFlg; /* 「分類名」 */
        nyuryokuData['dataTsuikajouhou'].disabled = deleteFlg; /* 「追加情報」 */
        dateStart.isDisabled = deleteFlg;    /* 「有効期間（自）」 */
        /* カテゴリーごとのキャプションに変更 */
        $('#dataCategoryCd').val(categoryData[cmbCategory.selectedIndex].dataCategoryCd);
        let textWidth = categoryData[cmbCategory.selectedIndex].dataKoumokuName1.length + 0.5;
        /* 分類CD */
        $('.koumokuName1').text(categoryData[cmbCategory.selectedIndex].dataKoumokuName1);
        $('.koumokuName1').css({'cssText': 'width: '+ textWidth +'em;'});
        /* 分類名 */
        $('.koumokuName2').text(categoryData[cmbCategory.selectedIndex].dataKoumokuName2);
        $('.koumokuName2').css({'cssText': 'width: '+ textWidth +'em;'});
        /* 「追加情報」にキャプションデータがある場合 */
        if(categoryData[cmbCategory.selectedIndex].dataKoumokuName3 != '')
        {
            textWidth = categoryData[cmbCategory.selectedIndex].dataKoumokuName3.length + 0.5;
            $('.tsuikaJouhou').css({'cssText': ''});
            $('.koumokuName3').text(categoryData[cmbCategory.selectedIndex].dataKoumokuName3);
            $('#captionKensakuCd').css({'cssText': 'width: '+ textWidth +'em;'});
        }
        else
        {
            $('.tsuikaJouhou').css({'cssText': 'display:none;'});
        }
        /* 管理レベルが2以上の場合 */
        if(categoryData[cmbCategory.selectedIndex].dataKanriLevel > 1)
        {
            $('#kaisouLevel').css({'cssText': ''});
            /* 管理レベルが3以上の場合 */
            if(categoryData[cmbCategory.selectedIndex].dataKanriLevel > 2)
            {
                $('.kaisouLevel3').css({'cssText': ''});
            }
            else
            {
                $('.kaisouLevel3').css({'cssText': 'display:none;'});
            }
        }
        else
        {
            $('#kaisouLevel').css({'cssText': 'display:none;'});
            nyuryokuData['btnSanshou'].disabled = true;
        }
        /* 入力フォームのスタイル初期化 ※common_function.js参照　*/
        InitFormStyle();
    }

    /* ----------------------------- */
    /* 非同期処理呼び出し養用の関数変数 */
    /* ----------------------------- */
    /* ※data → 非同期通信で受信したjsonデータ配列
         　errorFlg → 非同期通信先のエラー処理判定 */

    /* カテゴリー取得 */
    var fncJushinCategoryData = function(data, errorFlg)
    {
        /* データエラー判定 ※common_function.js参照 */
        if(IsAjaxDataError(data, errorFlg)) return;
        /* カテゴリー配列作成 */
        categoryData = data[1];
        for(let i = 0; i < categoryData.length; i++)
        {
            category.push(categoryData[i].dataCategoryName);
            categoryCd.push(categoryData[i].dataCategoryCd);
        }
        /* コンボボックスの更新 */
        cmbCategory.itemsSource = category;
        /* グリッドデータの表示 */
        $('#btnHyouji').click();
    }

    /* データグリッド更新 */
    var fncJushinGridData = function(data, errorFlg)
    {
        /* 「データ更新中」非表示 */
        ClosePopupDlg();
        /* データエラー判定 ※common_function.js参照 */
        if(IsAjaxDataError(data, errorFlg)) return;
        /* ボタン制御更新 */
        SetEnableButton(data[1].length);
        /* 管理レベルが2以上の場合 */
        if(categoryData[cmbCategory.selectedIndex].dataKanriLevel > 1)
        {
            gridMaster.columns[3].visible = true;
            /* 1階層目のグリッド */
            gridMaster = fncSetSub(gridMaster, data[1], '', 1);
            /* 2階層目以降のグリッド */
            if(2 <= categoryData[cmbCategory.selectedIndex].dataKanriLevel) SetSubGrid(gridMaster, data[1], 2, fncSetSub);
        }
        else
        {
            gridMaster.columns[3].visible = false;
            SetGridCaption(gridMaster, 1);
            SortGridData(gridMaster, data[1], 'dataBunruiCd', 1);
        }
        gridMasterData = data[1];
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
            if(categoryData[cmbCategory.selectedIndex].dataKanriLevel > 1)
            {
                /* グリッド再描画*/
                gridMaster.dispose();
                gridMaster = InitGrid('#gridMaster');
            }
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
                for(let j = 0; j < targetElement.length; j++)
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
        
    /* カテゴリごとのグリッドのキャプション変更 */
    function SetGridCaption(grid, rowIndex)
    {
        let index = cmbCategory.selectedIndex > -1 ? cmbCategory.selectedIndex : 0;
        /* 分類CD変更 */
        grid.columns[rowIndex].header = categoryData[index].dataKoumokuName1;
        rowIndex++;
        /* 分類名変更 */
        grid.columns[rowIndex].header = categoryData[index].dataKoumokuName2;
        /* 追加情報変更 */
        if(grid.columns.length > 2)
        {
            rowIndex++;
            grid.columns[3].header = categoryData[index].dataOyaKoumokuName1;
        }
        grid.refresh(true);
    }
    /* セル内のサブグリッドの設定 */
    function SetSubGrid(parent, gridData, level, fnc)
    {
        /* 現在の階層 */
        let kaisou;
        /* セル内グリッドの宣言 */
        new wijmo.grid.detail.FlexGridDetailProvider(parent, {
            isAnimated: true,
            /* セル内グリッドの描画処理 */
            createDetailCell: function(row) {
                let cell = document.createElement('div');
                let heightVal = gridData.filter((item) => {
                           return (item.dataOyaBunruiCd === row.dataItem.dataBunruiCd);
                       }).length * 35 + 70;
                cell.style.cssText = 'height:'+heightVal+'px;';
                let grid = InitGrid(cell);
                grid = fnc(grid, gridData, row.dataItem.dataBunruiCd, level);
                kaisou = level;
                if(kaisou <= categoryData[cmbCategory.selectedIndex].dataKanriLevel)
                {
                    kaisou++;
                    SetSubGrid(grid, gridData, kaisou, fnc);
                }
                return cell;
            },
            /* 詳細表示ボタンの描画判定 */
            rowHasDetail: function (row) {
                let flg = (gridData.findIndex((item) => {
                               return (item.dataOyaBunruiCd === row.dataItem.dataBunruiCd);
                           }) > -1);
                return flg;
            }
        });
    }
    /* 条件抽出したグリッドの描画 */
    var fncSetSub = function(grid, gridData, bunruiCd, level)
    {
        grid.itemsSource = gridData;
        grid.collectionView.filter = function (item) {
                return item.dataJikaisouLevel == level &&
                       item.dataOyaBunruiCd == bunruiCd;
            };
        SetGridCaption(grid, 1);
        return grid;
    }
    /* 親分類選択ダイアログ */
    /* 親分類選択ダイアログ共有変数 */
    var dlgOyabunruiSentaku;
    /* ダイアログの宣言 */
    function SetOyabunruiSentakuDlg(dlg)
    {
        dlg.isDraggable =  true;  /* ヘッダー移動操作許可 */
        dlg.hideTrigger = 'None'; /* ダイアログを閉じる条件 */
        /* ダイアログの「キーボード」イベント */
        dlg.addEventListener(dlg.hostElement, 'keydown', function (e)
        {
            let idText = '';
            /*F9キー*/
            if(e.keyCode == KEY_F9)  idText = '#btnOyabunruiSentaku';
            /*F12キー*/
            if(e.keyCode == KEY_F12) idText = '#btnOyabunruiSentakuCancel';
            /*クリック処理実行*/
            if(idText != '') $(idText).click();
            /*キーボードイベント重複防止フラグ*/
            windowKeybordFlg = false;
        });
        dlgOyabunruiSentaku = dlg;
    }
    /*選択グリッド共有変数*/
    var gridOyabunruiSentaku = null;
    /*選択ダイアログの共有変数群*/
    var oyabunruiSentakuValues = {
        "cdElement"   : null,
        "nameElement" : null
    }
    /*ダイアログの表示*/
    function ShowOyabunruiSentakuDlg(cdElement, nameElement)
    {
        /*選択ダイアログの必要変数を格納*/
        oyabunruiSentakuValues.cdElement = cdElement;
        oyabunruiSentakuValues.nameElement = nameElement;
        /*グリッドの初期設定*/
        if(gridOyabunruiSentaku == null) gridOyabunruiSentaku = InitOyabunruiSentakuGrid();
        /*選択ダイアログの表示*/
        dlgOyabunruiSentaku.show(true);
        /*選択ダイアログのグリッドデータ表示*/
        gridOyabunruiSentaku.itemsSource = gridMasterData;
        gridOyabunruiSentaku.collectionView.filter = function (item) {
                return item.dataJikaisouLevel == document.forms['frmNyuryoku']['dataKaisouLevel'].value - 1;
            };
        SetGridCaption(gridOyabunruiSentaku, 0);
    }
    /*グリッドの初期設定*/
    function InitOyabunruiSentakuGrid()
    {
        /*グリッドのレイアウト設定*/
        let columns = [
            {
                binding: 'dataBunruiCd',
                header : '',
                width  : '*'
            },
            {
                binding: 'dataBunruiName',
                header : '',
                width  : '2*'
            }
        ];
        /*グリッドの宣言*/
        let grid = new wijmo.grid.FlexGrid('#gridOyabunruiSentaku', {
            /*自動列生成停止*/
            autoGenerateColumns: false,
            /*レイアウト設定*/
            columns: columns,
            /*選択方法（行ごと）*/
            selectionMode: wijmo.grid.SelectionMode.Row,
            /*セルの読み取り専用設定*/
            isReadOnly: true,
            /*デフォルト行スタイル（0行ごとに色付け）*/
            alternatingRowStep: 0,
            /*グリッド上でのEnterキーイベント（無効）*/
            keyActionEnter: wijmo.grid.KeyAction.None,
            /*セル読み込み時のイベント*/
            loadedRows: function (s, e)
            {
                /*任意の色でセルを色付け
                ※rowPerItemでMultiRowの1レコード当たりの行数を取得（今回はrowPerItem = 2）
                ※common_function.js参照 */
                LoadGridRows(s, 1);
            }
        });
        let host = grid.hostElement; 
        /*グリッドセルのダブルクリックイベント*/
        grid.addEventListener(host, 'dblclick', function (e)
        {
            /*選択したセルがヘッダー要素でない場合は「修正」ボタンと同じ処理*/
            if(grid.hitTest(e).cellType == wijmo.grid.CellType.Cell) SetOyabunruiSentakuValue();
        });
        /*グリッドの「キーボード」イベント*/
        grid.addEventListener(host, 'keydown', function (e)
        {
            /*「Enterキー」は「修正」ボタンと同じ処理*/
            if(e.keyCode == KEY_ENTER)
            {
                SetOyabunruiSentakuValue();
                /*キーボードイベント二重起動防止*/
                windowKeybordFlg = false;
            }
        });
        return grid;
    }
    /*グリッドから選択した値を対象要素に表示する*/
    function SetOyabunruiSentakuValue()
    {
        let gridItem = gridOyabunruiSentaku.collectionView.currentItem;
        if(gridItem != null)
        {
            oyabunruiSentakuValues.cdElement.value = gridItem['dataBunruiCd'];
            if(oyabunruiSentakuValues.nameElement != null) oyabunruiSentakuValues.nameElement.value = gridItem['dataBunruiName'];
        }
        CloseOyabunruiSentakuDlg();
    }
    /*ダイアログを閉じる*/
    function CloseOyabunruiSentakuDlg()
    {
        dlgOyabunruiSentaku.hide(0);
    }
    /* 入力ダイアログ　「決定」ボタン　クリック処理 */
    $('#frmNyuryoku').submit(function(event)
    {
        /* 関数内関数 */
        /* 編集ダイアログ入力値変更判定 */
        function IsChangeNyuryokuData(nyuryokuData)
        {
            /* 選択行のグリッドデータ */
            let data = currentGrid.collectionView.currentItem;
            /* 更新処理以外の処理の場合は判定せずにtrue */
            if(nyuryokuData['dataSQLType'].value != MODE_UPDATE) return true;
            /* 「分類名」 */
            if(nyuryokuData['dataBunruiName'].value != data['dataBunruiName']) return true;
            /* 「追加情報」 */
            if(nyuryokuData['dataTsuikajouhou'].value != data['dataTsuikajouhou']) return true;
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
                if(nyuryokuData[i].name == 'dataKaisouLevel' && nyuryokuData[i].checked == false) continue;
                /* フォーム要素のnameを配列のキーしてPOSTデータの値を作成する */
                soushinData[nyuryokuData[i].name] = nyuryokuData[i].value;
            }
        }
        /* 「データチェック中」非表示 */
        ClosePopupDlg();
        /* 削除処理時、確認ダイアログを表示 */
        if(nyuryokuData['dataSQLType'].value == MODE_DELETE)
        {
            if(currentGrid.collectionView.currentItem['dataKoKaisouCount'] > 0)
            {
                /* エラーメッセージ表示 */
                ShowAlertDlg(categoryData[cmbCategory.selectedIndex].dataOyaKoumokuName1 + "{{__('に設定されているレコードの為、削除することができません。')}}");
                /* 「データチェック中」非表示 */
                ClosePopupDlg();
                return;
            }
            /* 確認ダイアログを経由して処理 */
            ShowConfirmDlg("{{__('このレコードを削除しますか？')}}",
            /* OKボタンを押したときの処理 */
            function()
            {
                /* 「データ更新中」表示 */
                ShowPopupDlg("{{__('データ更新中')}}");
                /* 非同期データ更新開始 */
                AjaxData("{{ url('/master/1301') }}", soushinData, fncUpdateData);
            }, null);
        }
        else
        {
            /* 「データ更新中」表示 */
            ShowPopupDlg("{{__('データ更新中')}}");
            /* 非同期データ更新開始 */
            AjaxData("{{ url('/master/1301') }}", soushinData, fncUpdateData);
        }
    });
    /*「階層レベル」ラジオボタン処理 */
    $('.kaisouLevel').change(function()
    {
        /* 入力フォーム要素 */
        let nyuryokuData = document.forms['frmNyuryoku'].elements;
        nyuryokuData['dataOyaBunruiCd'].disabled = ($(this).val() < 2);
        nyuryokuData['dataOyaBunruiCd'].value = '';
        nyuryokuData['dataOyaBunruiName'].value = '';
    });
    /* テキスト変更時に連動するテキスト要素のリセット処理 */
    $('input[type="text"]').change(function() {
        /* 連動テキスト要素のある要素を判別 */
        switch($(this)[0].name)
        {
            /* 親分類CD */
            case 'dataOyaBunruiCd': break;
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
            /* 親分類CD */
            case 'dataOyaBunruiCd':
            ShowOyabunruiSentakuDlg(currentCdElement, currentNameElement);
            break;
        }
    });
</script>
@endsection