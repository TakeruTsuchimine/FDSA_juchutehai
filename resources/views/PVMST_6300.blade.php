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
        <!-- 「請求CD」 -->
        <label>
            <span style="width:5em;">{{__('seikyu_cd')}}</span>
            <input name="dataSeikyuCd" class="form-control" type="text"
            maxlength="6" autocomplete="off" style="width:8em;">
        </label>
        <!-- 「請求部署名」 -->
        <label>
            <span style="width:5em;">{{__('seikyu_busho_name')}}</span>
            <input name="dataSeikyuBushoName" class="form-control" type="text"
            maxlength="20" autocomplete="off" style="width:22em;">
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
<div class="flex-box flex-column" style="padding:5px 10px;">
    <div class="form-column">
        <!-- 「請求CD」 -->
        <label>
            <span style="width:5em;">{{__('seikyu_cd')}}</span>
            <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
            <input name="dataSeikyuCd" class="form-control code-check" type="text"
            maxlength="6" autocomplete="off" style="width:8em;" pattern="^([a-zA-Z0-9]{0,6})$"
            title="{{ __('半角英数字6文字以内で入力してください') }}" required>
        </label>
    </div>
    <div class="form-column">
        <!-- 「請求部署名」 -->
        <label>
            <span style="width:5em;">{{__('seikyu_busho_name')}}</span>
            <input name="dataSeikyuBushoName" class="form-control" type="text" maxlength="20" autocomplete="off"
                style="width:22em;" required>
        </label>
    </div>
    <div class="form-column">
        <!-- 「郵便番号」 -->
        <label>
            <span style="width:5.5em;">{{__('seikyu_zip')}}</span>
            <input name="dataSeikyuZip" class="form-control" type="text" maxlength="10" autocomplete="off"
                style="width:8em;">
        </label>
    </div>
    <div class="form-column">
        <!-- 「住所」 -->
        <label>
            <span style="width:5.5em;">{{__('seikyu_jusho')}}</span>
            <input name="dataSeikyuJusho" class="form-control" type="text" maxlength="42" autocomplete="off"
                style="width:22em;">
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
    /* -------------------- */
    /* wijmoコントロール宣言 */
    /* -------------------- */
    /* 有効期間（自） */
    var dateStart = new wijmo.input.InputDate('#dataStartDate', { isRequired: false });
    /* ------- */
    /* 初期処理 */
    /* ------- */
    /* ページ初期処理
         ※ページが読み込まれた際に一番初めに処理される関数 */
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
                        /* 「請求CD」 */
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
                        /* 「請求部署名」 */
                        binding: 'dataSeikyuBushoName',
                        header: "{{ __('seikyu_busho_name') }}",
                        width: 150
                    }
                ]

            },
            {
                {{-- 3列目 --}}
                cells: [
                    {
                        /* 「郵便番号」 */
                        binding: 'dataSeikyuZip',
                        header : "{{ __('seikyu_zip') }}",
                        width  : '1*'
                    },
                    {
                        /* 「住所」 */
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
                        /* 「電話番号」 */
                        binding: 'dataTelNo',
                        header: "{{ __('tel_no') }}",
                        width: '1*'
                    },
                    {
                        /* 「FAX番号」 */
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
                        /* 「銀行1」 */
                        binding: 'dataGinkou1',
                        header: "{{ __('ginkou1') }}",
                        width: 150
                    },
                    {
                        /* 「銀行2」 */
                        binding: 'dataGinkou2',
                        header: "{{ __('ginkou2') }}",
                        width: 150
                    },
                    {
                        /* 「銀行3」 */
                        binding: 'dataGinkou3',
                        header: "{{ __('ginkou3') }}",
                        width: 150
                    }
                ]
            },
            {
                /* 6列目 */
                cells: [
                    {
                        /* 「有効期間（自）」 */
                        binding: 'dataStartDate',
                        header: "{{ __('yukoukikan_start_date') }}",
                        width: 150
                    }
                ]
            },
            {
                /* 7列目 */
                cells: [
                    {
                        /* 「登録日時」 */
                        binding: 'dataTourokuDt',
                        header: "{{ __('touroku_dt') }}",
                        width: 170
                    },
                    {
                        /* 「更新日時」 */
                        binding: 'dataKoushinDt',
                        header: "{{ __('koushin_dt') }}"
                    }
                ]
            },
            {
                /* 8列目 */
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
        /* CSV出力用グリッドのレイアウト設定 */
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
        /* 「請求CD」 */
        nyuryokuData['dataSeikyuCd'].value = (copy && !insertFlg) ? data['dataSeikyuCd'] : '';
        nyuryokuData['dataSeikyuCd'].disabled = !insertFlg;
        /* 「請求部署名」 */
        nyuryokuData['dataSeikyuBushoName'].value = copy ? data['dataSeikyuBushoName'] : '';
        /* 「郵便番号」 */
        nyuryokuData['dataSeikyuZip'].value = copy ? data['dataSeikyuZip'] : '';
        /* 「住所」 */
        nyuryokuData['dataSeikyuJusho'].value = copy ? data['dataSeikyuJusho'] : '';
        /* 「電話番号」 */
        nyuryokuData['dataTelNo'].value = copy ? data['dataTelNo'] : '';
        /* 「FAX番号」 */
        nyuryokuData['dataFaxNo'].value = copy ? data['dataFaxNo'] : '';
        /* 「銀行1」 */
        nyuryokuData['dataGinkou1'].value = copy ? data['dataGinkou1'] : '';
        /* 「銀行2」 */
        nyuryokuData['dataGinkou2'].value = copy ? data['dataGinkou2'] : '';
        /* 「銀行3」 */
        nyuryokuData['dataGinkou3'].value = copy ? data['dataGinkou3'] : '';

        /* 「有効期間（自）」 */
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
        nyuryokuData['dataSeikyuBushoName'].disabled = deleteFlg; /* 「請求部署名」 */
        nyuryokuData['dataSeikyuZip'].disabled = deleteFlg; /* 「郵便番号」 */
        nyuryokuData['dataSeikyuJusho'].disabled = deleteFlg;  /* 「住所」 */
        nyuryokuData['dataTelNo'].disabled = deleteFlg;  /* 「電話番号」 */
        nyuryokuData['dataFaxNo'].disabled = deleteFlg;  /* 「FAX番号」 */
        nyuryokuData['dataGinkou1'].disabled = deleteFlg;  /* 「銀行1」 */
        nyuryokuData['dataGinkou2'].disabled = deleteFlg;  /* 「銀行2」 */
        nyuryokuData['dataGinkou3'].disabled = deleteFlg;  /* 「銀行3」 */
        dateStart.isDisabled = deleteFlg;    /* 「有効期間（自）」 */
        /* 入力フォームのスタイル初期化 ※common_function.js参照　*/
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
            /* 「請求部署名」 */
            if(nyuryokuData['dataSeikyuBushoName'].value != data['dataSeikyuBushoName']) return true;
            /* 「郵便番号」 */
            if((nyuryokuData['dataSeikyuZip'].value != data['dataSeikyuZip']) &&
              !(nyuryokuData['dataSeikyuZip'].value == '' && data['dataSeikyuZip'] == null)) return true;
            /* 「住所」 */
            if((nyuryokuData['dataSeikyuJusho'].value != data['dataSeikyuJusho']) &&
              !(nyuryokuData['dataSeikyuJusho'].value == '' && data['dataSeikyuJusho'] == null)) return true;
            /* 「電話番号」 */
            if((nyuryokuData['dataTelNo'].value != data['dataTelNo']) &&
              !(nyuryokuData['dataTelNo'].value == '' && data['dataTelNo'] == null)) return true;
            /* 「FAX番号」 */
            if((nyuryokuData['dataFaxNo'].value != data['dataFaxNo']) &&
              !(nyuryokuData['dataFaxNo'].value == '' && data['dataFaxNo'] == null)) return true;
            /* 「銀行１」 */
            if((nyuryokuData['dataGinkou1'].value != data['dataGinkou1']) &&
              !(nyuryokuData['dataGinkou1'].value == '' && data['dataGinkou1'] == null)) return true;
            /* 「銀行２」 */
            if((nyuryokuData['dataGinkou2'].value != data['dataGinkou2']) &&
              !(nyuryokuData['dataGinkou2'].value == '' && data['dataGinkou2'] == null)) return true;
            /* 「銀行３」 */
            if((nyuryokuData['dataGinkou3'].value != data['dataGinkou3']) &&
              !(nyuryokuData['dataGinkou3'].value == '' && data['dataGinkou3'] == null)) return true;
            /* 「有効期間（自）」 */
            if(nyuryokuData['dataStartDate'].value != data['dataStartDate']) return true;
            /* 上記項目に変更が無い場合はfalse */
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
        /* POST送信用オブジェクト配列 */
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
</script>
@endsection
