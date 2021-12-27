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
        {{-- 「シフトCD」 --}}
        <label>
            <span style="width:4.5em;">{{__('shift_cd')}}</span>
            <input name="dataShiftCd" class="form-control" type="text" maxlength="1" autocomplete="off"
                style="width:8em;">
        </label>
        {{-- 「シフト名」 --}}
        <label>
            <span style="width:4.5em;">{{__('shift_name')}}</span>
            <input name="dataShiftName" class="form-control" type="text" maxlength="20" autocomplete="off"
                style="width:22em;">
        </label>
        {{-- 「事業部CD」 --}}
        <label>
            <span style="width:4.5em;">{{__('jigyoubu_cd')}}</span>
            <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                <input name="dataJigyoubuCd" class="form-control" type="text" maxlength="6" autocomplete="off"
                    style="width:8em;">
                {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                <i class="fas fa-search search-btn"></i>
            </span>
            {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
            <input name="dataJigyoubuName" class="form-control" type="text" style="width:22em;" onfocus="blur();" readonly>
        </label>
    </div>
    {{-- 二列目 --}}
    <div class="form-column">
        {{-- 「拠点CD」 --}}
        <label>
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
        {{-- 「シフトCD」 --}}
        <label>
            <span style="width:4.5em;">{{__('shift_cd')}}</span>
            {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
            <input name="dataShiftCd" class="form-control code-check" type="text" maxlength="1" autocomplete="off"
                style="width:8em;" pattern="^([A-Z]{1})$" title="{{ __('A～Zのうちから1つを入力してください') }}" required>
        </label>
    </div>
    <div class="form-column">
        {{-- 「シフト名」 --}}
        <label>
            <span style="width:4.5em;">{{__('shift_name')}}</span>
            <input name="dataShiftName" class="form-control" type="text" maxlength="20" autocomplete="off"
                style="width:22em;" required>
        </label>
    </div>
    <div class="form-column">
        {{-- 「事業部CD」 --}}
        <label>
            <span style="width:4.5em;">{{__('jigyoubu_cd')}}</span>
            <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                <input name="dataJigyoubuCd" class="form-control code-check" type="text" maxlength="6" autocomplete="off"
                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,6})$" title="{{__('半角英数字6文字以内で入力してください')}}" required>
                {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                <i class="fas fa-search search-btn"></i>
            </span>
            {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
            <input name="dataJigyoubuName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
        </label>
    </div>
    <div class="form-column">
            {{-- 「開始時刻」 --}}
            <label>
                <span style="width:14.4em;">{{__('start_jikoku')}}</span>
                {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                    <input name="dataStartJikoku" class="form-control code-check" type="time" autocomplete="off" style="width:7em;" title="時刻を入力してください">
            </label>
        </div>
        <div class="form-column">
            {{-- 「終了時刻（通常勤務）」 --}}
            <label>
                <span style="width:14.4em;">{{__('end_jikoku_tsujou')}}</span>
                {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                    <input name="dataEndJikokuTsujou" class="form-control code-check" type="time" autocomplete="off" style="width:7em;" title="時刻を入力してください">
            </label>
        </div>
        <div class="form-column">
            {{-- 「終了時刻（残業）」 --}}
            <label>
                <span style="width:14.4em;">{{__('end_jikoku_zangyou')}}</span>
                {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                    <input name="dataEndJikokuZangyou" class="form-control code-check" type="time" autocomplete="off" style="width:7em;" title="時刻を入力してください">
            </label>
        </div>
        <div class="form-column">
            {{-- 「指定範囲経過時間（通常勤務）」 --}}
            <label>
                <span style="width:14em; margin-right:5px;">{{__('指定範囲経過時間（通常勤務）')}}</span>
                {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                    <input id="dataKeikaJikanTsujou" name="dataKeikaJikanTsujou" class="form-control code-check" type="text" autocomplete="off"
                    style="width:7em; text-align:right;" title="{{ __('経過時間が表示されます') }}" onfocus="blur();" readonly>
                <span style="width:2em; margin-left:10px;">{{__('分')}}</span>
            </label>
        </div>
        <div class="form-column">
            {{-- 「指定範囲経過時間（残業分）」 --}}
            <label>
                <span style="width:14em; margin-right:5px;">{{__('指定範囲経過時間（残業分）')}}</span>
                {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                    <input id="dataKeikaJikanZangyou" name="dataKeikaJikanZangyou" class="form-control code-check" type="text" autocomplete="off"
                    style="width:7em; text-align:right;" title="{{ __('経過時間が表示されます') }}" onfocus="blur();" readonly>
                <span style="width:2em; margin-left:10px;">{{__('分')}}</span>
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

    function getColors() {
        return 'Red,Green,Blue,White,Black,Yellow,Orange'.split(',');
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
                        {{-- 「シフトCD」 --}}
                        binding: 'dataShiftCd',
                        header: "{{ __('shift_cd') }}",
                        width: '0.5*'
                    }
                ]
            },
            {
                {{-- 2列目 --}}
                cells: [
                    {
                        {{-- 「シフト名」 --}}
                        binding: 'dataShiftName',
                        header: "{{ __('shift_name') }}",
                        width: '1*'
                    }
                ]

            },
            {
                {{-- 3列目 --}}
                cells: [
                    {{-- 1行目 --}}
                    {
                        {{-- 「事業部CD」 --}}
                        binding: 'dataJigyoubuCd',
                        header: "{{ __('jigyoubu_cd') }}",
                        width: '1*'
                    },
                    {{-- 2行目 --}}
                    {
                        {{-- 「事業部名」 --}}
                        binding: 'dataJigyoubuName',
                        header: "{{ __('jigyoubu_name') }}"
                    }
                ]

            },
            {
                {{-- 4列目 --}}
                cells: [
                    {
                        {{-- 「開始時刻」 --}}
                        binding: 'dataStartJikoku',
                        header: "{{ __('start_jikoku') }}",
                        width: '1.2*'
                    }
                ]
            },
            {
                {{-- 5列目 --}}
                cells: [
                    {{-- 1行目 --}}
                    {
                        {{-- 「終了時刻（通常勤務）」 --}}
                        binding: 'dataEndJikokuTsujou',
                        header: "{{ __('end_jikoku_tsujou') }}",
                        width: '1.2*'
                    },
                    {{-- 2行目 --}}
                    {
                        {{-- 「終了時刻（残業）」 --}}
                        binding: 'dataEndJikokuZangyou',
                        header: "{{ __('end_jikoku_zangyou') }}"
                    }
                ]
            },
            {
                {{-- 6列目 --}}
                cells: [
                    {{-- 1行目 --}}
                    {
                        {{-- 「指定範囲経過時間（通常勤務）」 --}}
                        binding: 'dataKeikaJikanTsujou',
                        header: "{{ __('keika_jikan_tsujou') }}",
                        width: '1.2*'
                    },
                    {{-- 2行目 --}}
                    {
                        {{-- 「指定範囲経過時間（残業分）」 --}}
                        binding: 'dataKeikaJikanZangyou',
                        header: "{{ __('keika_jikan_zangyou') }}"
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
        AjaxData("{{ url('/master/2900') }}", soushinData, fncJushinGridData);
        {{-- 検索件数の取得フラグの送信データを追加 --}}
        soushinData["dataCntFlg"] = true;
        {{-- 検索件数のデータ受信 --}}
        AjaxData("{{ url('/master/2900') }}", soushinData, fncJushinDataCnt);
    }
    {{-- 「CSV出力」ボタンイベント --}}
    var fncExportCSV = function()
    {
        {{-- CSV出力用グリッドのレイアウト設定 --}}
        let columns = [{ binding: 'dataShiftCd', header: "{{ __('shift_cd') }}" },
                       { binding: 'dataShiftName', header: "{{ __('shift_name') }}" },
                       { binding: 'dataJigyoubuCd', header: "{{ __('jigyoubu_cd') }}" },
                       { binding: 'dataJigyoubuName', header: "{{ __('jigyoubu_name') }}" },
                       { binding: 'dataStartJikoku', header: "{{ __('start_jikoku') }}" },
                       { binding: 'dataEndJikokuTsujou', header: "{{ __('end_jikoku_tsujou') }}" },
                       { binding: 'dataEndJikokuZangyou', header: "{{ __('end_jikoku_zangyou') }}" },
                       { binding: 'dataKeikaJikanTsujou', header: "{{ __('keika_jikan_tsujou') }}" },
                       { binding: 'dataKeikaJikanZangyou', header: "{{ __('keika_jikan_zangyou') }}" }];
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
        {{-- 「シフトCD」 --}}
        nyuryokuData['dataShiftCd'].value = (copy && !insertFlg) ? data['dataShiftCd'] : '';
        nyuryokuData['dataShiftCd'].disabled = !insertFlg;
        {{-- 「シフト名」 --}}
        nyuryokuData['dataShiftName'].value = copy ? data['dataShiftName'] : '';
        {{-- 「事業部CD」 --}}
        nyuryokuData['dataJigyoubuCd'].value = copy ? data['dataJigyoubuCd'] : '';
        {{-- 「事業部名」 --}}
        nyuryokuData['dataJigyoubuName'].value = copy ? data['dataJigyoubuName'] : '';
        {{-- 「開始時刻」 --}}
        nyuryokuData['dataStartJikoku'].value = copy ? data['dataStartJikoku'] : '';
        {{-- 「終了時刻（通常勤務）」 --}}
        nyuryokuData['dataEndJikokuTsujou'].value = copy ? data['dataEndJikokuTsujou'] : '';
        {{-- 「終了時刻（通常勤務）」 --}}
        nyuryokuData['dataEndJikokuZangyou'].value = copy ? data['dataEndJikokuZangyou'] : '';
        {{-- 「指定範囲経過時間（通常勤務）」 --}}
        nyuryokuData['dataKeikaJikanTsujou'].value = copy ? data['dataKeikaJikanTsujou'] : '';
        {{-- 「指定範囲経過時間（通常勤務）」 --}}
        nyuryokuData['dataKeikaJikanZangyou'].value = copy ? data['dataKeikaJikanZangyou'] : '';
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
        nyuryokuData['dataShiftName'].disabled = deleteFlg; {{-- 「シフト名」 --}}
        nyuryokuData['dataJigyoubuCd'].disabled = deleteFlg;  {{-- 「事業部CD」 --}}
        nyuryokuData['dataStartJikoku'].disabled = deleteFlg;  {{-- 「開始時刻」 --}}
        nyuryokuData['dataEndJikokuTsujou'].disabled = deleteFlg;  {{-- 「終了時刻（通常勤務）」 --}}
        nyuryokuData['dataEndJikokuZangyou'].disabled = deleteFlg;  {{-- 「終了時刻（残業）」 --}}
        nyuryokuData['dataKeikaJikanTsujou'].disabled = deleteFlg;  {{-- 「指定範囲経過時間（通常勤務）」 --}}
        nyuryokuData['dataKeikaJikanZangyou'].disabled = deleteFlg;  {{-- 「指定範囲経過時間（残業分）」 --}}

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
        {{-- グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 --}}
        selectedRows = SortMultiRowData(gridMaster, data[1], 'dataShiftCd');
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
            {{-- 「シフト名」 --}}
            if(nyuryokuData['dataShiftName'].value != data['dataShiftName']) return true;
            {{-- 「事業部CD」 --}}
            if(nyuryokuData['dataJigyoubuCd'].value != data['dataJigyoubuCd']) return true;
            {{-- 「開始時刻」 --}}
            if(nyuryokuData['dataStartJikoku'].value != data['dataStartJikoku']) return true;
            {{-- 「終了時刻（通常勤務）」 --}}
            if(nyuryokuData['dataEndJikokuTsujou'].value != data['dataEndJikokuTsujou']) return true;
            {{-- 「終了時刻（残業）」 --}}
            if(nyuryokuData['dataEndJikokuZangyou'].value != data['dataEndJikokuZangyou']) return true;
            {{-- 「指定範囲経過時間（通常勤務）」 --}}
            if(nyuryokuData['dataKeikaJikanTsujou'].value != data['dataKeikaJikanTsujou']) return true;
            {{-- 「指定範囲経過時間（残業分）」 --}}
            if(nyuryokuData['dataKeikaJikanZangyou'].value != data['dataKeikaJikanZangyou']) return true;

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
                AjaxData("{{ url('/master/2901') }}", soushinData, fncUpdateData);
            }, null);
        }
        else
        {
            {{-- 「データ更新中」表示 --}}
            ShowPopupDlg("{{__('データ更新中')}}");
            {{-- 非同期データ更新開始 --}}
            AjaxData("{{ url('/master/2901') }}", soushinData, fncUpdateData);
        }
    });

    {{-- テキスト変更時に連動するテキスト要素のリセット処理 --}}
    $('input[type="text"]').change(function() {
        {{-- 連動テキスト要素のある要素を判別 --}}
        switch($(this)[0].name)
        {
            {{-- 事業部CD --}}
            case 'dataJigyoubuCd': break;
            {{-- 拠点CD --}}
            case 'dataKyotenCd': break;
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
            {{-- 事業部CD --}}
            case 'dataJigyoubuCd':
            ShowSentakuDlg("{{ __('jigyoubu_cd') }}", "{{ __('jigyoubu_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0100') }}");
            break;
            {{-- 拠点CD --}}
            case 'dataKyotenCd':
            ShowSentakuDlg("{{ __('kyoten_cd') }}", "{{ __('kyoten_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0200') }}");
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
