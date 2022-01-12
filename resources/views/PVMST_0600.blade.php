<!-- PHP処理 -->
<?php
// 工程区分
define("KOUTEI_KBN", array(
    '未設定',
    '社内加工',
    '外注加工',
    '材料手配'
));
// 初回のみ有効区分
define("SHOKAI_KBN", array(
    '無効',
    '初回製造のみ有効（手配）'
));
// 報告区分
define("HOUKOKU_KBN", array(
    '無',
    '報告'
));
// 図面配布
define("ZUMEN_HAIFU_KBN", array(
    '無',
    '配布'
));
// 「loginId」が送信されていなければ0を設定
if (!isset($loginId)) $loginId = 0;

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
        <!-- 「事業部CD」 -->
        <label>
            <span style="width:4.5em;">{{__('jigyoubu_cd')}}</span>
            <span class="icon-field">
                <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                <input name="dataJigyoubuCd" class="form-control" type="text" maxlength="6" autocomplete="off" style="width:8em;">
                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                <i class="fas fa-search search-btn"></i>
            </span>
            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
            <input name="dataJigyoubuName" class="form-control" type="text" style="width:22em;" onfocus="blur();" readonly>
        </label>
        <!-- 「工程CD」 -->
        <label>
            <span style="width:4.5em;">{{__('koutei_cd')}}</span>
            <input name="dataKouteiCd" class="form-control" type="text" maxlength="10" autocomplete="off" style="width:8em;">
        </label>
        <!-- 「工程名」 -->
        <label>
            <span style="width:4.5em;">{{__('koutei_name')}}</span>
            <input name="dataKouteiName" class="form-control" type="text" maxlength="20" autocomplete="off" style="width:22em;">
        </label>
        {{-- 「工程略名」 --}}
        <label>
            <span style="width:4.5em;">{{__('koutei_ryaku_name')}}</span>
            <input name="dataKouteiRyakuName" class="form-control" type="text" maxlength="6" autocomplete="off"
                style="width:8em;">
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
            <!-- 「工程CD」 -->
            <label>
                <span style="width:4.5em;">{{__('koutei_cd')}}</span>
                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                <input name="dataKouteiCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off" style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{ __('半角英数字10文字以内で入力してください') }}" required>
            </label>
        </div>
        <div class="form-column">
            <!-- 「工程名」 -->
            <label>
                <span style="width:4.9em;">{{__('koutei_name')}}</span>
                <input name="dataKouteiName" class="form-control" type="text" maxlength="20" autocomplete="off" style="width:20.5em;">
            </label>
        </div>
        <div class="form-column">
            <!-- 「工程略名」 -->
            <label>
                <span style="width:4.9em;">{{__('koutei_ryaku_name')}}</span>
                <input name="dataKouteiRyakuName" class="form-control" type="text" maxlength="6" autocomplete="off" style="width:8em;">
            </label>
        </div>
        <div class="form-column">
            <!-- 「事業部CD」 -->
            <label>
                <span style="width:4.5em;">{{__('jigyoubu_cd')}}</span>
                <span class="icon-field">
                    <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                    <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                    <input name="dataJigyoubuCd" class="form-control code-check" type="text" maxlength="6" autocomplete="off" style="width:8em;" pattern="^([a-zA-Z0-9]{0,6})$" title="{{__('半角英数字6文字以内で入力してください')}}" required>
                    <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                    <i class="fas fa-search search-btn"></i>
                </span>
                <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                <input name="dataJigyoubuName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
            </label>
        </div>
        <div class="form-column">
            <!-- 「工程区分」 -->
            <label>
                <span style="width:4.9em;">{{__('koutei_kbn')}}</span>
                <!-- 「工程区分」コンボボックス本体 -->
                <div id="cmbKouteiKbn" style="width:13.5em; margin-left:5px;"></div>
                <!-- 「工程区分」フォーム送信データ -->
                <input name="dataKouteiKbn" type="hidden">
            </label>
        </div>
        <div class="form-column">
            <!-- 「作業機械候補CD」 -->
            <label>
                <span style="width:8.5em;">{{__('sagyou_kikai_kouho_cd')}}</span>
                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                <input name="dataSagyouKikaiKouhoCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off"
                    style="width:10em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{ __('半角英数字10文字以内で入力してください') }}" required>
            </label>
        </div>
        <div class="form-column">
            <!-- 「作業担当者候補CD」 -->
            <label>
                <span style="width:8.5em;">{{__('sagyou_tantousha_kouho_cd')}}</span>
                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                <input name="dataSagyouTantoushaKouhoCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off"
                    style="width:10em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{ __('半角英数字10文字以内で入力してください') }}" required>
            </label>
        </div>
        <div class="form-column">
            <!-- 「加工先候補CD」 -->
            <label>
                <span style="width:8.5em;">{{__('kakousaki_kouho_cd')}}</span>
                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                <input name="dataKakousakiKouhoCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off"
                    style="width:10em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{ __('半角英数字10文字以内で入力してください') }}" required>
            </label>
        </div>
    </div>
    <!-- 「ダイアログ右側」 -->
    <div class="flex-box flex-start flex-column item-start" style="padding-left:30px;">
        <div class="form-column">
            <!-- 「初回のみ有効区分」 -->
            <label>
                <span style="width:8.4em;">{{__('shokai_kbn')}}</span>
                <!-- 「初回のみ有効区分」コンボボックス本体 -->
                <div id="cmbShokaiKbn" style="width:18em;"></div>
                <!-- 「初回のみ有効区分」フォーム送信データ -->
                <input name="dataShokaiKbn" type="hidden">
            </label>
        </div>
        <div class="form-column">
            <!-- 「報告区分」 -->
            <label>
                <span style="width:8.4em;">{{__('houkoku_kbn')}}</span>
                <!-- 「報告区分」コンボボックス本体 -->
                <div id="cmbHoukokuKbn" style="width:18em;"></div>
                <!-- 「報告区分」フォーム送信データ -->
                <input name="dataHoukokuKbn" type="hidden">
            </label>
        </div>
        <div class="form-column">
            <!-- 「図面配布」 -->
            <label>
                <span style="width:8.4em;">{{__('zumen_haifu_kbn')}}</span>
                <!-- 「図面配布」コンボボックス本体 -->
                <div id="cmbZumenHaifuKbn" style="width:18em;"></div>
                <!-- 「図面配布」フォーム送信データ -->
                <input name="dataZumenHaifuKbn" type="hidden">
            </label>
        </div>
        <div class="form-column">
            <!-- 「工程単価」 -->
            <label>
                <span style="width:8.1em;">{{__('koutei_tanka')}}</span>
                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                <input name="dataKouteiTanka" class="form-control code-check" type="text" maxlength="17" autocomplete="off" style="width:10em;" pattern="^([1-9]\d{1,14}|0)(\.\d+)?$" title="{{ __('半角数字で入力してください') }}">
            </label>
        </div>
        <div class="form-column">
            <!-- 「工程段取単価」 -->
            <label>
                <span style="width:8.1em;">{{__('koutei_dandori_tanka')}}</span>
                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                <input name="dataKouteiDandoriTanka" class="form-control code-check" type="text" maxlength="17" autocomplete="off" style="width:10em;" pattern="^([1-9]\d{1,14}|0)(\.\d+)?$" title="{{ __('半角数字で入力してください') }}">
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

    /* 工程区分選択値 */
    var kouteiKbn = [];
    /* 工程区分データ登録値 */
    var kouteiKbnValue = [];
    /* 工程区分の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(KOUTEI_KBN); $i++)
    @if(KOUTEI_KBN[$i] !== '')
    kouteiKbn.push('{{ $i }}:{{ KOUTEI_KBN[$i] }}');
    kouteiKbnValue.push({
        {
            $i
        }
    });
    @endif
    @endfor
    /* コンボボックス宣言 */
    var cmbKouteiKbn = new wijmo.input.ComboBox('#cmbKouteiKbn', {
        itemsSource: kouteiKbn,
        isRequired: false
    });

    /* 初回のみ有効区分選択値 */
    var shokaiKbn = [];
    /* 初回のみ有効区分データ登録値 */
    var shokaiKbnValue = [];
    /* 初回のみ有効区分の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(SHOKAI_KBN); $i++)
    @if(SHOKAI_KBN[$i] !== '')
    shokaiKbn.push('{{ $i }}:{{ SHOKAI_KBN[$i] }}');
    shokaiKbnValue.push({
        {
            $i
        }
    });
    @endif
    @endfor
    /* コンボボックス宣言 */
    var cmbShokaiKbn = new wijmo.input.ComboBox('#cmbShokaiKbn', {
        itemsSource: shokaiKbn,
        isRequired: false
    });

    /* 報告区分選択値 */
    var houkokuKbn = [];
    /* 報告区分データ登録値 */
    var houkokuKbnValue = [];
    /* 報告区分の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(HOUKOKU_KBN); $i++)
    @if(HOUKOKU_KBN[$i] !== '')
    houkokuKbn.push('{{ $i }}:{{ HOUKOKU_KBN[$i] }}');
    houkokuKbnValue.push({
        {
            $i
        }
    });
    @endif
    @endfor
    /* コンボボックス宣言 */
    var cmbHoukokuKbn = new wijmo.input.ComboBox('#cmbHoukokuKbn', {
        itemsSource: houkokuKbn,
        isRequired: false
    });

    /* 図面配布選択値 */
    var zumenHaifuKbn = [];
    /* 図面配布データ登録値 */
    var zumenHaifuKbnValue = [];
    /* 図面配布の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(ZUMEN_HAIFU_KBN); $i++)
    @if(ZUMEN_HAIFU_KBN[$i] !== '')
    zumenHaifuKbn.push('{{ $i }}:{{ ZUMEN_HAIFU_KBN[$i] }}');
    zumenHaifuKbnValue.push({
        {
            $i
        }
    });
    @endif
    @endfor
    /* コンボボックス宣言 */
    var cmbZumenHaifuKbn = new wijmo.input.ComboBox('#cmbZumenHaifuKbn', {
        itemsSource: zumenHaifuKbn,
        isRequired: false
    });
    /* カレンダー宣言 */
    /* 有効期間（自） */
    var dateStart = new wijmo.input.InputDate('#dataStartDate', {
        isRequired: false
    });

    /* ------- */
    /* 初期処理 */
    /* ------- */

    /* ページ初期処理
         ※ページが読み込まれた際に一番初めに処理される関数 */
    window.onload = function() {
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
    function InitGrid() {
        /* MultiRowのレイアウト設定 */
        let columns = [{
                /* 1列目 */
                cells: [
                    {
                        /* 「工程CD」 */
                        binding: 'dataKouteiCd',
                        header: "{{ __('koutei_cd') }}",
                        width: 130
                    }
                ]
            },
            {
                /* 2列目 */
                cells: [
                    /* 1行目 */
                    {
                        /* 「工程名」 */
                        binding: 'dataKouteiName',
                        header: "{{ __('koutei_name') }}",
                        width: 200
                    },
                    /* 2行目 */
                    {
                        /* 「工程略名」 */
                        binding: 'dataKouteiRyakuName',
                        header: "{{ __('koutei_ryaku_name') }}"
                    }
                ]
            },
            {
                /* 3列目 */
                cells: [{
                        /* 「事業部CD」 */
                        binding: 'dataJigyoubuCd',
                        header: "{{ __('jigyoubu_cd') }}",
                        width: 130
                    },
                    {
                        /* 「事業部名」 */
                        binding: 'dataJigyoubuName',
                        header: "{{ __('jigyoubu_name') }}"
                    }
                ]
            },
            {
                /* 4列目 */
                cells: [
                    {
                        /* 「工程区分」 */
                        binding: 'dataKouteiKbn',
                        header: "{{ __('koutei_kbn') }}",
                        colspan: 3
                    },
                    {
                        /* 「作業機械候補CD」 */
                        binding: 'dataSagyouKikaiKouhoCd',
                        header: "{{ __('sagyou_kikai_kouho_cd') }}",
                        width: 150
                    },
                    {
                        /* 「作業担当者候補CD」 */
                        binding: 'dataSagyouTantoushaKouhoCd',
                        header: "{{ __('sagyou_tantousha_kouho_cd') }}",
                        width: 150
                    },
                    {
                        /* 「加工先候補CD」 */
                        binding: 'dataKakousakiKouhoCd',
                        header: "{{ __('kakousaki_kouho_cd') }}",
                        width: 150
                    }
                ]
            },
            {
                /* 5列目 */
                cells: [{
                        /* 「工程単価」 */
                        binding: 'dataKouteiTanka',
                        header: "{{ __('koutei_tanka') }}",
                        width: 130
                    },
                    {
                        /* 「工程段取単価」 */
                        binding: 'dataKouteiDandoriTanka',
                        header: "{{ __('koutei_dandori_tanka') }}"
                    }
                ]
            },
            {
                /* 6列目 */
                cells: [
                    {
                        /* 「初回のみ有効区分」 */
                        binding: 'dataShokaiKbn',
                        header: "{{ __('shokai_kbn') }}",
                        width: 230
                    }
                ]
            },
            {
                /* 7列目 */
                cells: [
                    {
                        /* 「報告区分」 */
                        binding: 'dataHoukokuKbn',
                        header: "{{ __('houkoku_kbn') }}",
                        width: 130
                    }
                ]
            },
            {
                /* 8列目 */
                cells: [
                    {
                        /* 「図面配布」 */
                        binding: 'dataZumenHaifuKbn',
                        header: "{{ __('zumen_haifu_kbn') }}",
                        width: 130
                    }
                ]
            },
            {
                /* 9列目 */
                cells: [{
                        /* 「有効期間（自）」 */
                        binding: 'dataStartDate',
                        header: "{{ __('yukoukikan_start_date') }}",
                        width: 130
                    },
                    {
                        /* 「有効期間（至）」 */
                        binding: 'dataEndDate',
                        header: "{{ __('yukoukikan_end_date') }}",
                        width: 150
                    }
                ]
            },
            {
                /* 10列目 */
                cells: [{
                        /* 「登録日時」 */
                        binding: 'dataTourokuDt',
                        header: "{{ __('touroku_dt') }}",
                        width: 200
                    },
                    {
                        /* 「更新日時」 */
                        binding: 'dataKoushinDt',
                        header: "{{ __('koushin_dt') }}"
                    }
                ]
            },
            {
                /* 11列目 */
                cells: [{
                        /* 「登録者名」 */
                        binding: 'dataTourokushaName',
                        header: "{{ __('tourokusha_name') }}",
                        width: 200
                    },
                    {
                        /* 「更新者名」 */
                        binding: 'dataKoushinshaName',
                        header: "{{ __('koushinsha_name') }}"
                    }
                ]
            }
        ];
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
            loadedRows: function(s, e) {
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
        gridMaster.addEventListener(host, 'click', function(e) {
            /* グリッドに選択する行が無い場合は処理をスキップ */
            if (gridMaster.itemsSource.length < 1) return;
            /* 選択した行番号を格納 */
            selectedRows = SetSelectedMultiRow(gridMaster, selectedRows);
            /* 選択した行のデータIDを格納 */
            SetSelectedRowId(gridMaster.collectionView.currentItem['dataId']);
        });

        /* グリッドの「右クリック」イベント */
        gridMaster.addEventListener(host, 'contextmenu', function(e) {
            /* セル上での右クリックメニュー表示 ※common_function.js参照 */
            SetGridContextMenu(gridMaster, e);
            /* グリッドに選択する行が無い場合は処理をスキップ */
            if (gridMaster.itemsSource.length < 1) return;
            /* クリックした位置を選択 */
            gridMaster.select(new wijmo.grid.CellRange(gridMaster.hitTest(e).row, 0), true);
            /* 選択した行番号を格納 */
            selectedRows = SetSelectedMultiRow(gridMaster, selectedRows);
            /* 選択した行のデータIDを格納 */
            SetSelectedRowId(gridMaster.collectionView.currentItem['dataId']);
        });

        /* グリッドの「ダブルクリック」イベント */
        gridMaster.addEventListener(host, 'dblclick', function(e) {
            /* 選択したセルがヘッダー要素でない場合は「修正」ボタンと同じ処理 */
            if (gridMaster.hitTest(e).cellType == wijmo.grid.CellType.Cell) $('#btnShusei').click();
        });

        /* グリッドの「キーボード」イベント */
        gridMaster.addEventListener(host, 'keydown', function(e) {
            /* 「←・↑・→・↓キー」はクリック時と同じ処理 */
            if (e.keyCode >= KEY_LEFT && e.keyCode <= KEY_DOWN) {
                /* グリッドに選択する行が無い場合は処理をスキップ */
                if (gridMaster.itemsSource.length < 1) return;
                /* 選択した行番号を格納 */
                selectedRows = SetSelectedMultiRow(gridMaster, selectedRows);
                /* 選択した行のデータIDを格納 */
                SetSelectedRowId(gridMaster.collectionView.currentItem['dataId']);
                /* キーボードイベント二重起動防止 */
                windowKeybordFlg = false;
            }
            /* 「Enterキー」は「修正」ボタンと同じ処理 */
            if (e.keyCode == KEY_ENTER) {
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
    var fncShowDataGrid = function() {
        /* 検索フォーム要素 */
        let kensakuData = document.forms['frmKensaku'].elements;
        /* POST送信用オブジェクト配列 */
        let soushinData = {};
        /* フォーム要素から送信データを格納 */
        for (var i = 0; i < kensakuData.length; i++) {
            /* フォーム要素のnameが宣言されている要素のみ処理 */
            if (kensakuData[i].name != '') {
                /* フォーム要素のnameを配列のキーしてPOSTデータの値を作成する */
                /* 検索値の末尾に検索条件キーを付与してLIKE検索をできるようにする ※LIKE_VALUE_BOTHは部分一致検索 */
                soushinData[kensakuData[i].name] = (kensakuData[i].value != '') ? (kensakuData[i].value + LIKE_VALUE_BOTH) : '';
            }
        }
        /* 「データ読込中」表示 */
        ShowPopupDlg("{{ __('データ読込中') }}");
        /* グリッドのデータ受信 */
        AjaxData("{{ url('/master/0600') }}", soushinData, fncJushinGridData);
    }
    /* 「Excel出力」ボタンイベント */
    var fncExportExcel = function() {
        /* Excel出力用グリッドのレイアウト設定 */
        let columns = [{ binding: 'dataKouteiCd', header: "{{ __('koutei_cd') }}" },
                       { binding: 'dataKouteiName', header: "{{ __('koutei_name') }}" },
                       { binding: 'dataKouteiRyakuName', header: "{{ __('koutei_ryaku_name') }}" },
                       { binding: 'dataJigyoubuCd', header: "{{ __('jigyoubu_cd') }}" },
                       { binding: 'dataJigyoubuName', header: "{{ __('jigyoubu_name') }}" },
                       { binding: 'dataKouteiKbn', header: "{{ __('koutei_kbn') }}" },
                       { binding: 'dataSagyouKikaiKouhoCd', header: "{{ __('sagyou_kikai_kouho_cd') }}" },
                       { binding: 'dataSagyouTantoushaKouhoCd', header: "{{ __('sagyou_tantousha_kouho_cd') }}" },
                       { binding: 'dataKakousakiKouhoCd', header: "{{ __('kakousaki_kouho_cd') }}" },
                       { binding: 'dataKouteiTanka', header: "{{ __('koutei_tanka') }}" },
                       { binding: 'dataKouteiDandoriTanka', header: "{{ __('koutei_dandori_tanka') }}" },
                       { binding: 'dataShokaiKbn', header: "{{ __('shokai_kbn') }}" },
                       { binding: 'dataHoukokuKbn', header: "{{ __('houkoku_kbn') }}" },
                       { binding: 'dataZumenHaifuKbn', header: "{{ __('zumen_haifu_kbn') }}" },
                       { binding: 'dataStartDate', header: "{{ __('yukoukikan_start_date') }}" },
                       { binding: 'dataEndDate', header: "{{ __('yukoukikan_end_date') }}" },
                       { binding: 'dataTourokuDt', header: "{{ __('touroku_dt') }}" },
                       { binding: 'dataTourokushaName', header: "{{ __('tourokusha_name') }}" },
                       { binding: 'dataKoushinDt', header: "{{ __('koushin_dt') }}" },
                       { binding: 'dataKoushinshaName', header: "{{ __('koushinsha_name') }}" }];
        /* 現在のグリッドの並び替え条件取得 */
        let sortState = gridMaster.collectionView.sortDescriptions.map(
            function(sd) {
                /* 並び替え条件をオブジェクト配列として返す */
                return {
                    property: sd.property,
                    ascending: sd.ascending
                }
            }
        );
        /* Excel出力時の並び替え条件を設定 */
        let sortDesc = new wijmo.collections.SortDescription(sortState[0].property, sortState[0].ascending);
        /* Excelファイル作成
             ※ファイル名は「ページタイトル+yyyymmddhhMMss（年月日時分秒）+.csv」
             ※common_function.js参照 */
        ExportExcelFile(gridMaster.itemsSource, columns, sortDesc, '{{ $pageTitle }}' + getNowDateTime() + '.csv');
    }
    /* 「新規・参照新規・修正・削除」ボタンイベント
         ※mode → 入力ダイアログの操作、新規・修正・削除のどの処理で開いたかを判別する処理種別
         　copy → 参照新規や修正などで選択行のレコード情報を初期入力させるかの判定 */
    var fncNyuryokuData = function(mode, copy) {
        /* 入力フォーム要素 */
        let nyuryokuData = document.forms['frmNyuryoku'].elements;
        /* 選択行のグリッドデータ */
        let data = gridMaster.collectionView.currentItem;
        /* 「新規」処理フラグ */
        let insertFlg = (mode == MODE_INSERT);

        /* 「処理種別」 */
        nyuryokuData['dataSQLType'].value = mode;
        /* 「工程CD」 */
        nyuryokuData['dataKouteiCd'].value = (copy && !insertFlg) ? data['dataKouteiCd'] : '';
        nyuryokuData['dataKouteiCd'].disabled = !insertFlg;
        /* 「工程名」 */
        nyuryokuData['dataKouteiName'].value = copy ? data['dataKouteiName'] : '';
        /* 「工程略名」 */
        nyuryokuData['dataKouteiRyakuName'].value = copy ? data['dataKouteiRyakuName'] : '';
        /* 「事業部CD」 */
        nyuryokuData['dataJigyoubuCd'].value = copy ? data['dataJigyoubuCd'] : '';
        /* 「事業部名」 */
        nyuryokuData['dataJigyoubuName'].value = copy ? data['dataJigyoubuName'] : '';
        /* 「工程単価」 */
        nyuryokuData['dataKouteiTanka'].value = copy ? data['dataKouteiTanka'] : '';
        /* 「工程段取単価」 */
        nyuryokuData['dataKouteiDandoriTanka'].value = copy ? data['dataKouteiDandoriTanka'] : '';
        /* 「工程区分」 */
        cmbKouteiKbn.selectedIndex = (copy && !insertFlg) ? kouteiKbnValue.indexOf(data['dataKouteiKbn']) : 0;
        /* 「初回のみ有効区分」 */
        cmbShokaiKbn.selectedIndex = (copy && !insertFlg) ? shokaiKbnValue.indexOf(data['dataShokaiKbn']) : 0;
        /* 「報告区分」 */
        cmbHoukokuKbn.selectedIndex = (copy && !insertFlg) ? houkokuKbnValue.indexOf(data['dataHoukokuKbn']) : 0;
        /* 「図面配布」 */
        cmbZumenHaifuKbn.selectedIndex = (copy && !insertFlg) ? zumenHaifuKbnValue.indexOf(data['dataZumenHaifuKbn']) : 0;
        /* 「作業機械候補CD」 */
        nyuryokuData['dataSagyouKikaiKouhoCd'].value = copy ? data['dataSagyouKikaiKouhoCd'] : '';
        /* 「作業担当者候補CD」 */
        nyuryokuData['dataSagyouTantoushaKouhoCd'].value = copy ? data['dataSagyouTantoushaKouhoCd'] : '';
        /* 「加工先候補CD」 */
        nyuryokuData['dataKakousakiKouhoCd'].value = copy ? data['dataKakousakiKouhoCd'] : '';
        /* 「有効期間（自）」 */
        dateStart.value = !insertFlg ? data['dataStartDate'] : getNowDate();
        /* 「登録日時」 */
        nyuryokuData['dataTourokuDt'].value = !insertFlg ? data['dataTourokuDt'] : '';
        /* 「更新日時」 */
        nyuryokuData['dataKoushinDt'].value = !insertFlg ? data['dataKoushinDt'] : '';

        /* ボタンのキャプション */
        let btnCaption = ["{{ __('登録') }}", "{{ __('更新') }}", "{{ __('削除') }}"];
        nyuryokuData['btnKettei'].value = "{{__('F9')}}" + btnCaption[mode - 1];

        /* 「削除」処理フラグ
             ※削除処理時は入力機能を制限して閲覧のみにする */
        let deleteFlg = (mode == MODE_DELETE);
        /* レコードID ※削除時のみ必要 */
        nyuryokuData['dataId'].value = deleteFlg ? data['dataId'] : '';
        /* 検索ボタン ※削除時のみ制限 */
        nyuryokuData['btnSanshou'].disabled = deleteFlg;
        nyuryokuData['dataKouteiName'].disabled = deleteFlg; /* 「工程名」 */
        nyuryokuData['dataKouteiRyakuName'].disabled = deleteFlg; /* 「工程略名」 */
        nyuryokuData['dataJigyoubuCd'].disabled = deleteFlg; /* 「事業部CD」 */
        nyuryokuData['dataKouteiTanka'].disabled = deleteFlg; /* 「工程単価」 */
        nyuryokuData['dataKouteiDandoriTanka'].disabled = deleteFlg; /* 「工程段取単価」 */
        nyuryokuData['dataSagyouKikaiKouhoCd'].disabled = deleteFlg; /* 「作業機械候補CD」 */
        nyuryokuData['dataSagyouTantoushaKouhoCd'].disabled = deleteFlg; /* 「作業担当者候補CD」 */
        nyuryokuData['dataKakousakiKouhoCd'].disabled = deleteFlg; /* 「加工先候補CD」 */
        cmbKouteiKbn.isDisabled = deleteFlg; /* 「工程区分」 */
        cmbShokaiKbn.isDisabled = deleteFlg; /* 「初回のみ有効区分」 */
        cmbHoukokuKbn.isDisabled = deleteFlg; /* 「報告区分」 */
        cmbZumenHaifuKbn.isDisabled = deleteFlg; /* 「図面配布」 */
        dateStart.isDisabled = deleteFlg; /* 「有効期間（自）」 */

        /* 入力フォームのスタイル初期化 ※common_function.js参照　*/
        InitFormStyle();
    }

    /* ----------------------------- */
    /* 非同期処理呼び出し養用の関数変数 */
    /* ----------------------------- */
    /* ※data → 非同期通信で受信したjsonデータ配列
         　errorFlg → 非同期通信先のエラー処理判定 */

    /* データグリッド更新 */
    var fncJushinGridData = function(data, errorFlg) {
        /* 「データ更新中」非表示 */
        ClosePopupDlg();
        /* データエラー判定 ※common_function.js参照 */
        if(IsAjaxDataError(data, errorFlg)) return;
        /* ボタン制御更新 */
        SetEnableButton(data[1].length);
        /* 件数更新 */
        $("#zenkenCnt").html(data[1].length);
        /* グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 */
        selectedRows = SortMultiRowData(gridMaster, data[1], 'dataKouteiCd');
    }

    /* DBデータ更新 */
    var fncUpdateData = function(data, errorFlg) {
        /* 「データ更新中」非表示 */
        ClosePopupDlg();
        /* データエラー判定 ※common_function.js参照 */
        if (!IsAjaxDataError(data, errorFlg)) {
            /* 「データ更新完了」表示 */
            ShowAlertDlg('データ更新完了');
            /* 選択行のデータIDを保持 ※common_function.js参照 */
            SetSelectedRowId(data[2][0]);
            /* 入力ダイアログを閉じる */
            CloseNyuryokuDlg();
            /* グリッドデータの表示 */
            $('#btnHyouji').click();
        } else {
            /* エラー時処理 */
            /* データ判定対象要素 */
            let targetElement = data[2];
            /* 対象要素のCSSテキスト */
            let classText = '';
            /* 対象要素のCSSテキストを書き換える
                 ※コード検査を行う項目は、スタイルクラス「code-check」が宣言されている */
            for (let i = 0; i < $('.code-check').length; i++) {
                /* 対象要素のCSSテキストを取得 */
                classText = $('.code-check')[i].className;
                /* 既にエラー表示の対象要素をリセット */
                $('.code-check')[i].className = classText.replace('code-check-error', '');
                for (let j = 0; j < targetElement.length; j++) {
                    /* 対象要素であるか判定 */
                    if ($('.code-check')[i].name == targetElement[j]) {
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
    $('#frmNyuryoku').submit(function(event) {
        /* 関数内関数 */
        /* 編集ダイアログ入力値変更判定 */
        function IsChangeNyuryokuData(nyuryokuData) {
            /* 選択行のグリッドデータ */
            let data = gridMaster.collectionView.currentItem;
            /* 更新処理以外の処理の場合は判定せずにtrue */
            if (nyuryokuData['dataSQLType'].value != MODE_UPDATE) return true;
            /* 「工程名」 */
            if ((nyuryokuData['dataKouteiName'].value != data['dataKouteiName']) &&
                !(nyuryokuData['dataKouteiName'].value == '' && data['dataKouteiName'] == null)) return true;
            /* 「工程略名」 */
            if ((nyuryokuData['dataKouteiRyakuName'].value != data['dataKouteiRyakuName']) &&
                !(nyuryokuData['dataKouteiRyakuName'].value == '' && data['dataKouteiRyakuName'] == null)) return true;
            /* 「事業部CD」 */
            if(nyuryokuData['dataJigyoubuCd'].value != data['dataJigyoubuCd']) return true;
            /* 「工程単価」 */
            if ((nyuryokuData['dataKouteiTanka'].value != data['dataKouteiTanka']) &&
                !(nyuryokuData['dataKouteiTanka'].value == '' && data['dataKouteiTanka'] == null)) return true;
            /* 「工程段取単価」 */
            if ((nyuryokuData['dataKouteiDandoriTanka'].value != data['dataKouteiDandoriTanka']) &&
                !(nyuryokuData['dataKouteiDandoriTanka'].value == '' && data['dataKouteiDandoriTanka'] == null)) return true;
            /* 「作業機械候補CD」 */
            if(nyuryokuData['dataSagyouKikaiKouhoCd'].value != data['dataSagyouKikaiKouhoCd']) return true;
            /* 「作業担当者候補CD」 */
            if(nyuryokuData['dataSagyouTantoushaKouhoCd'].value != data['dataSagyouTantoushaKouhoCd']) return true;
            /* 「加工先候補CD」 */
            if(nyuryokuData['dataKakousakiKouhoCd'].value != data['dataKakousakiKouhoCd']) return true;
            /* 「工程区分」 */
            if (kouteiKbnValue[cmbKouteiKbn.selectedIndex] != data['dataKouteiKbn']) return true;
            /* 「初回のみ有効区分」 */
            if (shokaiKbnValue[cmbShokaiKbn.selectedIndex] != data['dataShokaiKbn']) return true;
            /* 「報告区分」 */
            if (houkokuKbnValue[cmbHoukokuKbn.selectedIndex] != data['dataHoukokuKbn']) return true;
            /* 「図面配布」 */
            if (zumenHaifuKbnValue[cmbZumenHaifuKbn.selectedIndex] != data['dataZumenHaifuKbn']) return true;
            /* 「有効期間（自）」 */
            if (nyuryokuData['dataStartDate'].value != data['dataStartDate']) return true;

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
        if (!IsChangeNyuryokuData(nyuryokuData)) {
            /* エラーメッセージ表示 */
            ShowAlertDlg("{{__('更新されたデータがありません')}}");
            /* 「データチェック中」非表示 */
            ClosePopupDlg();
            return;
        }
        /* 工程区分のコンボボックスの値取得 */
        nyuryokuData['dataKouteiKbn'].value = kouteiKbnValue[cmbKouteiKbn.selectedIndex];
        /* 初回のみ有効区分のコンボボックスの値取得 */
        nyuryokuData['dataShokaiKbn'].value = shokaiKbnValue[cmbShokaiKbn.selectedIndex];
        /* 報告区分のコンボボックスの値取得 */
        nyuryokuData['dataHoukokuKbn'].value = houkokuKbnValue[cmbHoukokuKbn.selectedIndex];
        /* 図面配布のコンボボックスの値取得 */
        nyuryokuData['dataZumenHaifuKbn'].value = zumenHaifuKbnValue[cmbZumenHaifuKbn.selectedIndex];
        /* POST送信用オブジェクト配列 */
        let soushinData = {};
        /* フォーム要素から送信データを格納 */
        for (var i = 0; i < nyuryokuData.length; i++) {
            /* フォーム要素のnameが宣言されている要素のみ処理 */
            if (nyuryokuData[i].name != '') {
                /* フォーム要素のnameを配列のキーしてPOSTデータの値を作成する */
                soushinData[nyuryokuData[i].name] = nyuryokuData[i].value;
            }
        }
        /* 「データチェック中」非表示 */
        ClosePopupDlg();
        /* 削除処理時、確認ダイアログを表示 */
        if (nyuryokuData['dataSQLType'].value == MODE_DELETE) {
            /* 確認ダイアログを経由して処理 */
            ShowConfirmDlg("このレコードを削除しますか？",
                /* OKボタンを押したときの処理 */
                function() {
                    /* 「データ更新中」表示 */
                    ShowPopupDlg("{{__('データ更新中')}}");
                    /* 非同期データ更新開始 */
                    AjaxData("{{ url('/master/0601') }}", soushinData, fncUpdateData);
                }, null);
        } else {
            /* 「データ更新中」表示 */
            ShowPopupDlg("{{__('データ更新中')}}");
            /* 非同期データ更新開始 */
            AjaxData("{{ url('/master/0601') }}", soushinData, fncUpdateData);
        }
    });

    /* テキスト変更時に連動するテキスト要素のリセット処理 */
    $('input[type="text"]').change(function() {
        /* 連動テキスト要素のある要素を判別 */
        switch ($(this)[0].name) {
            /* 事業部CD */
            case 'dataJigyoubuCd':
                break;
                /* 該当しない場合は処理終了 */
            default:
                return;
                break;
        }
        let targetElement = $(this).parent().next("input")[0];
        /* 連動テキスト要素が存在し、かつテキストの変更不可の要素である場合は処理 */
        if (targetElement && targetElement.readOnly) targetElement.value = '';
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
        if (currentCdElement.disabled) return;
        /* 選択対象の名前を判別 */
        switch (currentCdElement.name) {
            /* 事業部CD */
            case 'dataJigyoubuCd':
                ShowSentakuDlg("{{ __('jigyoubu_cd') }}", "{{ __('jigyoubu_name') }}",
                    currentCdElement, currentNameElement, "{{ url('/inquiry/0100') }}");
                break;
        }
    });
</script>
@endsection
