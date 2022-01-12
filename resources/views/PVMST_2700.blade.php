<!-- PHP処理 -->
<?php
    // 消費税区分
    define("SHOUHIZEI_KBN", array( '非課税',
                                   '外税',
                                   '内税'));

    // 軽減税率適用区分
    define("KEIGENZEIRITSU_KBN", array( '未',
                                        '軽減税率適用'));

    // 仮区分
    define("KARI_KBN", array( '未',
                              '仮単価'));

    // 未処理区分
    define("MISHORI_KBN", array( '未',
                                 '未設定'));

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
        <!-- 「品目CD」 -->
        <label>
            <span style="width:7.5em;">{{__('hinmoku_cd')}}</span>
            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                <input name="dataHinmokuCd" class="form-control" type="text" maxlength="30" autocomplete="off"
                    style="width:8em;">
                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                <i class="fas fa-search search-btn"></i>
            </span>
            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
            <input name="dataHinmokuName1" class="form-control" type="text" style="width:22em;" onfocus="blur();" readonly>
        </label>
        <!-- 「仕入外注先CD」 -->
        <label>
            <span style="width:7.5em;">{{__('shiiresaki_cd')}}</span>
            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                <input name="dataShiiresakiCd" class="form-control" type="text" maxlength="10" autocomplete="off"
                    style="width:8em;">
                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                <i class="fas fa-search search-btn"></i>
            </span>
            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
            <input name="dataShiiresakiName1" class="form-control" type="text" style="width:22em;" onfocus="blur();" readonly>
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
<div class="flex-box flex-column" style="padding:5px 10px;">
    <div class="form-column">
        <!-- 「品目CD」 -->
        <label>
            <span style="width:7em;">{{__('hinmoku_cd')}}</span>
            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                <input name="dataHinmokuCd" class="form-control code-check" type="text" maxlength="30" autocomplete="off"
                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,30})$" title="{{__('半角英数字30文字以内で入力してください')}}" required>
                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                <i class="fas fa-search search-btn"></i>
            </span>
            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
            <input name="dataHinmokuName1" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
        </label>
    </div>
    <div class="form-column">
        <!-- 「仕入外注先CD」 -->
        <label>
            <span style="width:7em;">{{__('shiiresaki_cd')}}</span>
            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                <input name="dataShiiresakiCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off"
                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{__('半角英数字10文字以内で入力してください')}}" required>
                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                <i class="fas fa-search search-btn"></i>
            </span>
            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
            <input name="dataShiiresakiName1" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
        </label>
    </div>
    <div class="form-column">
        <!-- 「適用日付」 -->
        <label>
            <span style="width:7.6em;">{{__('tekiyou_date')}}</span>
            <input id="dataTekiyouDate" name="dataTekiyouDate" type="hidden" style="width:9em;">
        </label>
    </div>
    <div class="form-column">
        <!-- 「適用最小量（発注単位数）」 -->
        <label>
            <span style="width:12em;">{{__('tekiyou_saishou_qty')}}</span>
            <input name="dataTekiyouSaishouQty" class="form-control" type="text" maxlength="18" autocomplete="off"
                style="width:8em;">
        </label>
    </div>
    <div class="form-column">
        <!-- 「消費税区分」 -->
        <label>
            <span style="width:8.4em;">{{__('shouhizei_kbn')}}</span>
            <!-- 「消費税区分」コンボボックス本体 -->
            <div id="cmbShouhizeiKbn" style="width:8em;"></div>
            <!-- 「消費税区分」フォーム送信データ -->
            <input name="dataShouhizeiKbn" type="hidden">
        </label>
    <div>
    <div class="form-column">
        <!-- 「軽減税率適用区分」 -->
        <label>
            <span style="width:8.4em;">{{__('keigenzeiritsu_kbn')}}</span>
            <!-- 「消費税区分」コンボボックス本体 -->
            <div id="cmbKeigenzeiritsuKbn" style="width:12em;"></div>
            <!-- 「消費税区分」フォーム送信データ -->
            <input name="dataKeigenzeiritsuKbn" type="hidden">
        </label>
    </div>
    <div class="form-column">
        <!-- 「仕入単価」 -->
        <label>
            <span style="width:5em;">{{__('shiire_tanka')}}</span>
            <input name="dataShiireTanka" class="form-control" type="text" maxlength="17" autocomplete="off"
                style="width:8em;">
        </label>
    </div>
    <div class="form-column">
        <!-- 「旧単価」 -->
        <label>
            <span style="width:5em;">{{__('kyu_tanka')}}</span>
            <input name="dataKyuTanka" class="form-control" type="text" maxlength="17" autocomplete="off"
                style="width:8em;">
        </label>
    </div>
    <div class="form-column">
        <!-- 「仮区分」 -->
        <label>
            <span style="width:5.4em;">{{__('kari_kbn')}}</span>
            <!-- 「仮区分」コンボボックス本体 -->
            <div id="cmbKariKbn" style="width:8em;"></div>
            <!-- 「仮区分」フォーム送信データ -->
            <input name="dataKariKbn" type="hidden">
        </label>
    </div>
    <div class="form-column">
        <!-- 「未処理用区分」 -->
        <label>
            <span style="width:5.4em;">{{__('mishori_kbn')}}</span>
            <!-- 「消費税区分」コンボボックス本体 -->
            <div id="cmbMishoriKbn" style="width:8em;"></div>
            <!-- 「消費税区分」フォーム送信データ -->
            <input name="dataMishoriKbn" type="hidden">
        </label>
    </div>
    <div class="form-column">
        <!-- 「備考」 -->
        <label>
            <span style="width:5em;">{{__('bikou')}}</span>
            <input name="dataBikou" class="form-control" type="text" maxlength="256" autocomplete="off"
                style="width:22em;">
        </label>
    </div>
    <div class="form-column">
        <!-- 「有効期間（自）」 -->
        <label>
            <span>{{__('yukoukikan_start_date')}}</span>
            <input id="dataStartDate" name="dataStartDate" type="hidden" style="width:9em;">
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

<!-- javascript -->
@section('javascript')
<script>
    /* -------------------- */
    /* wijmoコントロール宣言 */
    /* -------------------- */

    /* 消費税区分選択値 */
    var shouhizeiKbn = [];
    /* 消費税区分データ登録値 */
    var shouhizeiKbnValue = [];
    /* 消費税区分の元データに入力がある場合は選択値として格納 */
    @for($i = 0;$i < count(SHOUHIZEI_KBN);$i++)
        @if(SHOUHIZEI_KBN[$i] !== '')
            shouhizeiKbn.push('{{ $i }}:{{ SHOUHIZEI_KBN[$i] }}');
            shouhizeiKbnValue.push({{ $i }});
        @endif
    @endfor
    /* コンボボックス宣言 */
    var cmbShouhizeiKbn = new wijmo.input.ComboBox('#cmbShouhizeiKbn', { itemsSource: shouhizeiKbn , isRequired: false});
    /* 軽減税率適用区分選択値 */
    var keigenzeiritsuKbn = [];
    /* 軽減税率適用区分データ登録値 */
    var keigenzeiritsuKbnValue = [];
    /* 軽減税率適用区分の元データに入力がある場合は選択値として格納 */
    @for($i = 0;$i < count(KEIGENZEIRITSU_KBN);$i++)
        @if(KEIGENZEIRITSU_KBN[$i] !== '')
            keigenzeiritsuKbn.push('{{ $i }}:{{ KEIGENZEIRITSU_KBN[$i] }}');
            keigenzeiritsuKbnValue.push({{ $i }});
        @endif
    @endfor
    /* コンボボックス宣言 */
    var cmbKeigenzeiritsuKbn = new wijmo.input.ComboBox('#cmbKeigenzeiritsuKbn', { itemsSource: keigenzeiritsuKbn , isRequired: false });
    /* 仮区分選択値 */
    var kariKbn = [];
    /* 仮区分データ登録値 */
    var kariKbnValue = [];
    /* 仮区分の元データに入力がある場合は選択値として格納 */
    @for($i = 0;$i < count(KARI_KBN);$i++)
        @if(KARI_KBN[$i] !== '')
            kariKbn.push('{{ $i }}:{{ KARI_KBN[$i] }}');
            kariKbnValue.push({{ $i }});
        @endif
    @endfor
    /* コンボボックス宣言 */
    var cmbKariKbn = new wijmo.input.ComboBox('#cmbKariKbn', { itemsSource: kariKbn , isRequired: false });
    /* 未処理区分選択値 */
    var mishoriKbn = [];
    /* 未処理区分データ登録値 */
    var mishoriKbnValue = [];
    /* 未処理区分の元データに入力がある場合は選択値として格納 */
    @for($i = 0;$i < count(MISHORI_KBN);$i++)
        @if(MISHORI_KBN[$i] !== '')
            mishoriKbn.push('{{ $i }}:{{ MISHORI_KBN[$i] }}');
            mishoriKbnValue.push({{ $i }});
        @endif
    @endfor
    /* コンボボックス宣言 */
    var cmbMishoriKbn = new wijmo.input.ComboBox('#cmbMishoriKbn', { itemsSource: mishoriKbn , isRequired: false });
    /* カレンダー宣言 */
    /* 適用日付 */
    var dateTekiyou = new wijmo.input.InputDate('#dataTekiyouDate', { isRequired: false });
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
        let columns = [

            {
                /* 1列目 */
                cells: [
                    {
                        /* 「品目CD」 */
                        binding: 'dataHinmokuCd',
                        header: "{{ __('hinmoku_cd') }}",
                        width: 150
                    },
                    {
                        /* 「品目名1」 */
                        binding: 'dataHinmokuName1',
                        header: "{{ __('hinmoku_name1') }}"
                    }
                ]
            },
            {
                /* 2列目 */
                cells: [
                    {
                        /* 「仕入先CD」 */
                        binding: 'dataShiiresakiCd',
                        header: "{{ __('shiiresaki_cd') }}",
                        width: 150
                    },
                    {
                        /* 「仕入先名1」 */
                        binding: 'dataShiiresakiName1',
                        header: "{{ __('shiiresaki_name1') }}"
                    }
                ]
            },
            {
                /* 3列目 */
                cells: [
                    {
                        /* 「適用最小量（発注単位数）」 */
                        binding: 'dataTekiyouSaishouQty',
                        header: "{{ __('tekiyou_saishou_qty') }}",
                        width: 250
                    },
                    {
                        /* 「適用日付」 */
                        binding: 'dataTekiyouDate',
                        header: "{{ __('tekiyou_date') }}"
                    }
                ]
            },
            {
                /* 4列目 */
                cells: [
                    {
                        /* 「仕入単価」 */
                        binding: 'dataShiireTanka',
                        header: "{{ __('shiire_tanka') }}",
                        width: 120
                    },
                    {
                        /* 「旧単価」 */
                        binding: 'dataKyuTanka',
                        header: "{{ __('kyu_tanka') }}"
                    }
                ]
            },
            {
                /* 5列目 */
                cells: [
                    {
                        /* 「消費税区分」 */
                        binding: 'dataShouhizeiKbn',
                        header: "{{ __('shouhizei_kbn') }}",
                        width: 170
                    },
                    {
                        /* 「軽減税率適用区分」 */
                        binding: 'dataKeigenzeiritsuKbn',
                        header: "{{ __('keigenzeiritsu_kbn') }}"
                    }
                ]
            },
            {
                /* 6列目 */
                cells: [
                    {
                        /* 「仮区分」 */
                        binding: 'dataKariKbn',
                        header: "{{ __('kari_kbn') }}",
                        width: 150
                    },
                    {
                        /* 「未処理区分」 */
                        binding: 'dataMishoriKbn',
                        header: "{{ __('mishori_kbn') }}"
                    }
                ]
            },
            {
                /* 7列目 */
                cells: [
                    {
                        /* 「備考」 */
                        binding: 'dataBikou',
                        header: "{{ __('bikou') }}",
                        width: 300
                    }
                ]
            },
            {
                /* 8列目 */
                cells: [
                    {
                        /* 「有効期間（自）」 */
                        binding: 'dataStartDate',
                        header: "{{ __('yukoukikan_start_date') }}",
                        width: 150
                    },
                    {
                        /* 「有効期間（至）」 */
                        binding: 'dataEndDate',
                        header: "{{ __('yukoukikan_end_date') }}"
                    }
                ]
            },
            {
                /* 9列目 */
                cells: [
                    {
                        /* 「登録日」 */
                        binding: 'dataTourokuDt',
                        header: "{{ __('touroku_dt') }}",
                        width: 170
                    },
                    {
                        /* 「更新日」 */
                        binding: 'dataKoushinDt',
                        header: "{{ __('koushin_dt') }}"
                    }
                ]
            },
            {
                /* 10列目 */
                cells: [
                    {
                        /* 「登録者名」 */
                        binding: 'dataTourokushaName',
                        header: "{{ __('tourokusha_name') }}",
                        width: 300
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
        AjaxData("{{ url('/master/2700') }}", soushinData, fncJushinGridData);
    }
    /* 「Excel出力」ボタンイベント */
    var fncExportExcel = function()
    {
        /* Excel出力用グリッドのレイアウト設定 */
        let columns = [{ binding: 'dataHinmokuCd', header: "{{ __('hinmoku_cd') }}" },
                       { binding: 'datahinmokuName1', header: "{{ __('hinmoku_name1') }}" },
                       { binding: 'dataShiiresakiCd', header: "{{ __('shiiresaki_cd') }}" },
                       { binding: 'dataShiiresakiName1', header: "{{ __('shiiresaki_name1') }}" },
                       { binding: 'dataTekiyouDate', header: "{{ __('tekiyou_date') }}" },
                       { binding: 'dataTekiyouSaishouQty', header: "{{ __('tekiyou_saishou_qty') }}" },
                       { binding: 'dataShiireTanka', header: "{{ __('shiire_tanka') }}" },
                       { binding: 'dataKyuTanka', header: "{{ __('kyu_tanka') }}" },
                       { binding: 'dataShouhizeiKbn', header: "{{ __('shouhizei_kbn') }}" },
                       { binding: 'dataKeigenzeiritsuKbn', header: "{{ __('keigenzeiritsu_kbn') }}" },
                       { binding: 'dataKariKbn', header: "{{ __('kari_kbn') }}" },
                       { binding: 'dataMishoriKbn', header: "{{ __('mishori_kbn') }}" },
                       { binding: 'dataBikou', header: "{{ __('bikou') }}" },
                       { binding: 'dataStartDate', header: "{{ __('yukoukikan_start_date') }}" },
                       { binding: 'dataEndDate', header: "{{ __('yukoukikan_end_date') }}" },
                       { binding: 'dataToruokuDt', header: "{{ __('touroku_dt') }}" },
                       { binding: 'dataTourokushaId', header: "{{ __('tourokusha_id') }}" },
                       { binding: 'dataKoushinDt', header: "{{ __('koushin_dt') }}" },
                       { binding: 'dataKoushinshaId', header: "{{ __('koushinsha_id') }}" }];
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
        /* 「品目CD」 */
        nyuryokuData['dataHinmokuCd'].value = (copy && !insertFlg) ? data['dataHinmokuCd'] : '';
        nyuryokuData['dataHinmokuCd'].disabled = !insertFlg;
        /* 「仕入先CD」 */
        nyuryokuData['dataShiiresakiCd'].value = copy ? data['dataShiiresakiCd'] : '';
        nyuryokuData['dataShiiresakiCd'].disabled = !insertFlg;
        /* 「適用日付」 */
        dateTekiyou.value = !insertFlg ? data['dataTekiyouDate'] : getNowDate();
        /* 「適用最小量（発注単位数）」 */
        nyuryokuData['dataTekiyouSaishouQty'].value = copy ? data['dataTekiyouSaishouQty'] : '';
        /* 「消費税区分区分」 */
        cmbShouhizeiKbn.selectedIndex = (copy && !insertFlg) ? shouhizeiKbnValue.indexOf(data['dataShouhizeiKbn']) : 0;
        /* 「軽減税率適用区分」 */
        cmbKeigenzeiritsuKbn.selectedIndex = (copy && !insertFlg) ? keigenzeiritsuKbnValue.indexOf(data['dataKeigenzeiritsuKbn']) : 0;
        /* 「仮区分」 */
        cmbKariKbn.selectedIndex = (copy && !insertFlg) ? kariKbnValue.indexOf(data['dataKariKbn']) : 0;
        /* 「未処理区分」 */
        cmbMishoriKbn.selectedIndex = (copy && !insertFlg) ? mishoriKbnValue.indexOf(data['dataMishoriKbn']) : 0;
        /* 「仕入単価」 */
        nyuryokuData['dataShiireTanka'].value = copy ? data['dataShiireTanka'] : '';
        /* 「旧単価」 */
        nyuryokuData['dataKyuTanka'].value = copy ? data['dataKyuTanka'] : '';
        /* 「備考」 */
        nyuryokuData['dataBikou'].value = copy ? data['dataBikou'] : '';
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
        nyuryokuData['dataTekiyouSaishouQty'].disabled = deleteFlg;  /* 「適用最小量（発注単位数）」 */
        nyuryokuData['dataShiireTanka'].disabled = deleteFlg; /* 「仕入単価」 */
        nyuryokuData['dataKyuTanka'].disabled = deleteFlg; /* 「旧単価」 */
        nyuryokuData['dataBikou'].disabled = deleteFlg; /* 「備考」 */
        cmbShouhizeiKbn.isDisabled = deleteFlg; /* 「消費税区分」 */
        cmbKeigenzeiritsuKbn.isDisabled = deleteFlg; /* 「軽減税率適用区分」 */
        cmbKariKbn.isDisabled = deleteFlg; /* 「仮区分」 */
        cmbMishoriKbn.isDisabled = deleteFlg; /* 「未処理区分」 */
        dateTekiyou.isDisabled = deleteFlg;   /* 「入社日」 */
        dateStart.isDisabled = deleteFlg;    /* 「有効期間（自）」 */

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
        /* 件数更新 */
        $("#zenkenCnt").html(data[1].length);
        /* グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 */
        selectedRows = SortMultiRowData(gridMaster, data[1], 'dataHinmokuCd');
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
            /* 「適用日付」 */
            if(nyuryokuData['dataTekiyouDate'].value != data['dataTekiyouDate']) return true;
            /* 「消費税区分」 */
            if(shouhizeiKbnValue[cmbShouhizeiKbn.selectedIndex] != data['dataShouhizeiKbn']) return true;
            /* 「軽減税率適用区分」 */
            if(keigenzeiritsuKbnValue[cmbKeigenzeiritsuKbn.selectedIndex] != data['dataKeigenzeiritsuKbn']) return true;
            /* 「仮区分」 */
            if(kariKbnValue[cmbKariKbn.selectedIndex] != data['dataKariKbn']) return true;
            /* 「未処理区分」 */
            if(mishoriKbnValue[cmbMishoriKbn.selectedIndex] != data['dataMishoriKbn']) return true;
            /* 「適用最小量（発注単位数）」 */
            if((nyuryokuData['dataTekiyouSaishouQty'].value != data['dataTekiyouSaishouQty']) &&
              !(nyuryokuData['dataTekiyouSaishouQty'].value == '' && data['dataTekiyouSaishouQty'] == null)) return true;
            /* 「仕入単価」 */
            if((nyuryokuData['dataShiireTanka'].value != data['dataShiireTanka']) &&
              !(nyuryokuData['dataShiireTanka'].value == '' && data['dataShiireTanka'] == null)) return true;
            /* 「旧単価」 */
            if((nyuryokuData['dataKyuTanka'].value != data['dataKyuTanka']) &&
              !(nyuryokuData['dataKyuTanka'].value == '' && data['dataKyuTanka'] == null)) return true;
            /* 「備考」 */
            if((nyuryokuData['dataBikou'].value != data['dataBikou']) &&
              !(nyuryokuData['dataBikou'].value == '' && data['dataBikou'] == null)) return true;
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
        /* 消費税区分のコンボボックスの値取得 */
        nyuryokuData['dataShouhizeiKbn'].value = shouhizeiKbnValue[cmbShouhizeiKbn.selectedIndex];
        /* 軽減税率適用区分のコンボボックスの値取得 */
        nyuryokuData['dataKeigenzeiritsuKbn'].value = keigenzeiritsuKbnValue[cmbKeigenzeiritsuKbn.selectedIndex];
        /* 仮区分のコンボボックスの値取得 */
        nyuryokuData['dataKariKbn'].value = kariKbnValue[cmbKariKbn.selectedIndex];
        /* 未処理区分のコンボボックスの値取得 */
        nyuryokuData['dataMishoriKbn'].value = mishoriKbnValue[cmbMishoriKbn.selectedIndex];
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
                AjaxData("{{ url('/master/2701') }}", soushinData, fncUpdateData);
            }, null);
        }
        else
        {
            /* 「データ更新中」表示 */
            ShowPopupDlg("{{__('データ更新中')}}");
            /* 非同期データ更新開始 */
            AjaxData("{{ url('/master/2701') }}", soushinData, fncUpdateData);
        }
    });

    /* テキスト変更時に連動するテキスト要素のリセット処理 */
    $('input[type="text"]').change(function() {
        /* 連動テキスト要素のある要素を判別 */
        switch($(this)[0].name)
        {
            /* 品目CD */
            case 'dataHinmokuCd': break;
            /* 仕入外注先CD */
            case 'dataShiiresakiCd': break;
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
            /* 品目CD */
            case 'dataHinmokuCd':
            ShowSentakuDlg("{{ __('hinmoku_cd') }}", "{{ __('hinmoku_name1') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/2600') }}");
            break;
            /* 仕入外注先CD */
            case 'dataShiiresakiCd':
            ShowSentakuDlg("{{ __('shiiresaki_cd') }}", "{{ __('shiiresaki_name1') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1800') }}");
            break;
        }
    });
</script>
@endsection
