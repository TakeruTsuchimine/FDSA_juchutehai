{{-- PHP処理 --}}
<?php
    // リソース区分
    define('RESOURCE_KBN', array( '事業部',
                                  '部署',
                                  '機械',
                                  '担当者'));
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
        {{-- 「事業部CD」 --}}
            <label>
                <span style="width:6.7em;">{{__('jigyoubu_cd')}}</span>
                <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                    <input name="dataJigyoubuCd" class="form-control" type="text"
                           maxlength="6" autocomplete="off" style="width:8em;">
                    {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                    <i class="fas fa-search search-btn"></i>
                </span>
                {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                <input name="dataJigyoubuName" class="form-control" type="text"
                       style="width:22em;" onfocus="blur();" readonly>
            </label>
            {{-- 「リソース区分」 --}}
            <label>
                <span style="width:7em;">{{__('resource_kbn')}}</span>
                {{-- 「リソース区分」コンボボックス本体 --}}
                <div id="cmbResourceKbn" style="width:18em;"></div>
                {{-- 「リソース区分」フォーム送信データ --}}
                <input name="dataResourceKbn" type="hidden">
            </label>
        </div>
        {{-- 二列目 --}}
        <div class="form-column">
            <label>
            </label>
        </div>
    </form>
@endsection

@section('addContents')
    {{-- カレンダーマスター（左側） --}}
    {{-- 事業部 --}}
    <div id="gridMasterJigyoubu" style="width:25%; position:absolute; left:0%; top:calc(5% + {{$kensakuHight}}); height:calc(89.8% - {{$kensakuHight}});"></div>
    {{-- 部署 --}}
    <div id="gridMasterBusho" style="width:25%; position:absolute; left:0%; top:calc(5% + {{$kensakuHight}}); height:calc(89.8% - {{$kensakuHight}}); display:none;"></div>
    {{-- 機械 --}}
    <div id="gridMasterKikai" style="width:25%; position:absolute; left:0%; top:calc(5% + {{$kensakuHight}}); height:calc(89.8% - {{$kensakuHight}}); display:none;"></div>
    {{-- 担当者 --}}
    <div id="gridMasterTantousha" style="width:25%; position:absolute; left:0%; top:calc(5% + {{$kensakuHight}}); height:calc(89.8% - {{$kensakuHight}}); display:none;"></div>

    {{-- カレンダーマスター（右側） --}}
    {{-- シフト --}}
    <div id="gridMasterShift" style="width:20%; position:absolute; left:80%; top:calc(5% + {{$kensakuHight}}); height:calc(89.8% - {{$kensakuHight}}); display:none;"></div>

    {{-- カレンダーマスター（中央） --}}
    <div id="row"  style="padding-top:1%; width:45%; position:absolute; left:30%; top:calc(5% + {{$kensakuHight}}); height:calc(89.8% - {{$kensakuHight}}); display: none">
        <div class="row" style="margin-right:0px; margin-bottom:10px;">
            {{-- 年 --}}
            <div class="col-lg-3">
                <select id="WebinarYear" class="form-control">
                    <script>
                        var i;
                        for(i = 2021; i <= 2099; i++)
                        {
                            document.write('<option value="'+ i +'">' + i + '年</option>');
                        }
                    </script>
                </select>
            </div>
            {{-- 月 --}}
            <div class="col-lg-3">
                <select id="WebinarMonth" class="form-control">
                    <script>
                        var j;
                        for(j = 0; j <= 11; j++)
                        {
                            document.write('<option value="'+ j +'">' + (j + 1) + '月</option>');
                        }
                    </script>
                </select>
            </div>
            <div class="col-lg-3">
                <button id="GetCalendar" type="submit" class="btn btn-primary btn-block" onclick="GetCalendar()" style="width:9em;">カレンダー表示</button>
            </div>
        </div>
        {{-- カレンダー表示 --}}
        <div id="calendarGrid" class="row"></div>
    </div>
@endsection

{{-- 「入力ダイアログ」 --}}
@section('nyuryoku')
    {{-- 入力フォーム全体 --}}
    <div class="flex-box flex-column" style="padding:5px 10px;">
        <div class="form-column">
            {{-- 「 対象CD」 --}}
            <label>
                <span style="width:7.5em;">{{__('taishou_cd')}}</span>
                {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                <input name="dataTaishouCd" class="form-control code-check" type="text" maxlength="20" autocomplete="off" style="width:8em;">
            </label>
        </div>
        <div class="form-column">
            {{-- 「シフトCD」 --}}
            <label>
                <span style="width:7.5em;">{{__('shift_cd')}}</span>
                {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                <input name="dataShiftCd" class="form-control code-check" type="text"
                       maxlength="1" autocomplete="off" style="width:8em;"
                       pattern="^[A-Z]{1}$" title="{{ __('A～Zのうちから1つ入力してください') }}">
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
    {{-- -------------------- --}}
    {{-- wijmoコントロール宣言 --}}
    {{-- -------------------- --}}

    {{-- リソース区分選択値 --}}
    var resourceKbn = [];
    {{-- リソース区分データ登録値 --}}
    var resourceKbnValue = [];
    {{-- リソース区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(RESOURCE_KBN);$i++)
        @if(RESOURCE_KBN[$i] !== '')
            resourceKbn.push('{{ RESOURCE_KBN[$i] }}');
            resourceKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- コンボボックス宣言 --}}
    var cmbResourceKbn = new wijmo.input.ComboBox('#cmbResourceKbn', { itemsSource: resourceKbn });


    var jigyoubuMaster = document.getElementById('gridMasterJigyoubu');
    var bushoMaster = document.getElementById('gridMasterBusho');
    var tantoushaMaster = document.getElementById('gridMasterTantousha');
    var kikaiMaster = document.getElementById('gridMasterKikai');
    var shiftMaster = document.getElementById('gridMasterShift');
    var calendar = document.getElementById('row');


    cmbResourceKbn.selectedIndexChanged.addHandler(function(sender, e)
    {
        if(sender.selectedValue == '事業部')
        {
            jigyoubuMaster.style.display = 'block';
            bushoMaster.style.display = 'none';
            kikaiMaster.style.display = 'none';
            tantoushaMaster.style.display = 'none';
        }
        else if(sender.selectedValue == '部署')
        {
            jigyoubuMaster.style.display = 'none';
            bushoMaster.style.display = 'block';
            kikaiMaster.style.display = 'none';
            tantoushaMaster.style.display = 'none';
        }
        else if(sender.selectedValue == '機械')
        {
            jigyoubuMaster.style.display = 'none';
            bushoMaster.style.display = 'none';
            kikaiMaster.style.display = 'block';
            tantoushaMaster.style.display = 'none';
        }
        else if(sender.selectedValue == '担当者')
        {
            jigyoubuMaster.style.display = 'none';
            bushoMaster.style.display = 'none';
            kikaiMaster.style.display = 'none';
            tantoushaMaster.style.display = 'block';
        }
    });

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


    var calendarData;
    var calendarGrid;
    var selectedRows = 0;
    function MakeCalendarData(Month, Year)
    {
        var taishouDateMon = "", taishouDateTue = "",taishouDateWed = "", taishouDateThu = "", taishouDateFri = "", taishouDateSat = "", taishouDateSun = "";
        var calData = new wijmo.collections.ObservableArray();
        console.log(calData,"calData");
        // Get the start day, e.g., Monday=1, Tuesday=2, etc.
        var firstDay = new Date(Year, Month, 0);
        var startingDay = firstDay.getDay();
        // Get the month length
        var cal_days_in_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        var monthLength = cal_days_in_month[Month];
        console.log(monthLength, "monthLength");
        if (Month == 1)
        { //FEB
            if ((Year % 4 == 0 && Year % 100 != 0) || Year % 400 == 0)
            {
                monthLength = 29;       // 閏年
            }
        }
        var day = 1;
        for (var i = 0; i < 6; i++)     // i → カレンダー表示行数
        {
            for (var j = 0; j <= 6; j++)        // j → 改行
            {
                if (day <= monthLength && (i > 0 || j >= startingDay))
                {
                    switch (j) {
                        case 0:
                            Mon = day.toString();
                            break;
                        case 1:
                            Tue = day.toString();
                            break;
                        case 2:
                            Wed = day.toString();
                            break;
                        case 3:
                            Thu = day.toString();
                            break;
                        case 4:
                            Fri = day.toString();
                            break;
                        case 5:
                            Sat = day.toString();
                            break;
                        case 6:
                            Sun = day.toString();
                            break;
                    }
                    day++;
                }
            }

            calData.push(
                {
                Monday: Mon,
                Tuesday: Tue,
                Wednesday: Wed,
                Thursday: Thu,
                Friday: Fri,
                Saturday: Sat,
                Sunday: Sun
            });
            if (day > monthLength)
            {
                break;
            }
            else
            {
                Mon = ""; Tue = ""; Wed = ""; Thu = ""; Fri = ""; Sat = ""; Sun = "";
            }
        }
        return calData;

    }

    function MakeCalendarGrid(Month, Year)
    {
        let columns =
            [
                {
                    header:"{{ __('月') }}",
                    cells: [
                        {
                            binding: 'Monday',
                            width: '7*',
                            isReadOnly: true,
                            allowSorting: false
                        },
                        {
                            binding: 'dataShiftCd',
                            allowSorting: false
                        }
                    ]
                },
                {
                    header:"{{ __('火') }}",
                    cells: [
                        {
                            binding: 'Tuesday',
                            width: '7*',
                            isReadOnly: true,
                            allowSorting: false
                        },
                        {
                            binding: 'dataShiftCd',
                            allowSorting: false
                        }
                    ]
                },
                {
                    header:"{{ __('水') }}",
                    cells: [
                        {
                            binding: 'Wednesday',
                            width: '7*',
                            isReadOnly: true,
                            allowSorting: false
                        },
                        {
                            binding: 'dataShiftCd',
                            allowSorting: false
                        }
                    ]
                },
                {
                    header:"{{ __('木') }}",
                    cells: [
                        {
                            binding: 'Thursday',
                            width: '7*',
                            isReadOnly: true,
                            allowSorting: false
                        },
                        {
                            binding: 'dataShiftCd',
                            allowSorting: false
                        }
                    ]
                },
                {
                    header:"{{ __('金') }}",
                    cells: [
                        {
                            binding: 'Friday',
                            width: '7*',
                            isReadOnly: true,
                            allowSorting: false
                        },
                        {
                            binding: 'dataShiftCd',
                            allowSorting: false
                        }
                    ]
                },
                {
                    header:"{{ __('土') }}",
                    cells: [
                        {
                            binding: 'Saturday',
                            width: '7*',
                            isReadOnly: true,
                            allowSorting: false
                        },
                        {
                            binding: 'dataShiftCd',
                            allowSorting: false
                        }
                    ]
                },
                {
                    header:"{{ __('日') }}",
                    cells: [
                        {
                            binding: 'Sunday',
                            width: '7*',
                            isReadOnly: true,
                            allowSorting: false
                        },
                        {
                            binding: 'dataShiftCd',
                            allowSorting: false
                        }
                    ]
                }
            ];
            calendarData = new wijmo.collections.CollectionView(MakeCalendarData(Month, Year));
            console.log(calendarData,"データ");
            let gridOption = {
                itemsSource: calendarData,
                layoutDefinition:columns,
                selectionMode: wijmo.grid.SelectionMode.Cell,
                keyActionEnter:wijmo.grid.KeyAction.None,
                allowResizing: false,
                collapsedHeaders:true
            }
            calendarGrid = new wijmo.grid.multirow.MultiRow('#calendarGrid',gridOption);
            console.log(calendarGrid,"グリッド");
            calendarGrid.itemFormatter = function(panel, r, c ,cell)
            {
                // セル
                if (panel.cellType == wijmo.grid.CellType.Cell)
                {
                    var flex = panel.grid;
                    // 土曜日の日付スタイル
                    if (c == 5 && r % 2 == 0)
                    {
                        cell.style.color = 'blue';
                    }
                    // 日曜日の日付スタイル
                    else if(c == 6 && r % 2 == 0)
                    {
                        cell.style.color = 'red';
                    }
                    if(r % 2 == 0)
                    {
                        cell.style.textAlign = 'right';
                    }
                }
                // ヘッダー
                if (panel.cellType == wijmo.grid.CellType.ColumnHeader)
                {
                    // ヘッダー中央寄せ
                    cell.style.textAlign = 'center';
                    // 土曜日の日付スタイル
                    if(c == 5)
                    {
                        cell.style.color = 'blue';
                    }
                    // 日曜日の日付スタイル
                    else if(c == 6)
                    {
                        cell.style.color = 'red';
                    }
                }
            }

            {{-- グリッド関連のイベント登録 --}}
            {{-- グリッドの親要素 --}}
            let host = calendarGrid.hostElement;
            {{-- グリッドの「左クリック」イベント --}}
            calendarGrid.addEventListener(host, 'click', function (e)
            {
                {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
                if(calendarGrid.itemsSource.length < 1) return;
            });

            {{-- グリッドの「右クリック」イベント --}}
            calendarGrid.addEventListener(host, 'contextmenu', function (e)
            {
                {{-- セル上での右クリックメニュー表示 ※common_function.js参照 --}}
                SetGridContextMenu(calendarGrid, e);
                {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
                if(calendarGrid.itemsSource.length < 1) return;
                {{-- クリックした位置を選択 --}}
                calendarGrid.select(new wijmo.grid.CellRange(calendarGrid.hitTest(e).row, 0), true);
                {{-- 選択した行番号を格納 --}}
                selectedRows = SetSelectedMultiRow(calendarGrid, selectedRows);
                {{-- 選択した行のデータIDを格納 --}}
                SetSelectedRowId(calendarGrid.collectionView.currentItem['dataId']);
            });


            {{-- グリッドの「キーボード」イベント --}}
            calendarGrid.addEventListener(host, 'keydown', function (e)
            {
                {{-- 「←・↑・→・↓キー」はクリック時と同じ処理 --}}
                if(e.keyCode >= KEY_LEFT && e.keyCode <= KEY_DOWN)
                {
                    {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
                    if(calendarGrid.itemsSource.length < 1) return;
                    {{-- キーボードイベント二重起動防止 --}}
                    windowKeybordFlg = false;
                }
            });
    }
    function GetCalendar() {
        var m = parseInt($("#WebinarMonth").val());
        var y = parseInt($("#WebinarYear").val());
        MakeCalendarGrid(m, y);
    }

    $(document).ready(function ()
    {
        var d = new Date();
        var m = d.getMonth();
        var y = d.getFullYear();
        $("#WebinarMonth").val(m);
        $("#WebinarYear").val(y);
        MakeCalendarGrid(m, y);
    });


    {{-- 事業部 --}}
    function SetSelectedRowIdJigyoubu(rowId)
    {
        selectedRowId = rowId;
    }

    {{-- 部署 --}}
    function SetSelectedRowIdBusho(rowId)
    {
        selectedRowId = rowId;
    }

    {{-- 担当者 --}}
    function SetSelectedRowIdTantousha(rowId)
    {
        selectedRowId = rowId;
    }

    {{-- 機械 --}}
    function SetSelectedRowIdKikai(rowId)
    {
        selectedRowId = rowId;
    }

    {{-- シフト --}}
    function SetSelectedRowIdShift(rowId)
    {
        selectedRowId = rowId;
    }

    {{-- 左側（データ一覧） --}}

    {{-- グリッド共有変数 --}}
    {{-- 担当者 --}}
    var gridMasterTantousha;
    {{-- 事業部 --}}
    var gridMasterJigyoubu;
    {{-- 部署 --}}
    var gridMasterBusho;
    {{-- 機械 --}}
    var gridMasterKikai;
    {{-- 右側（シフトマスター） --}}
    var gridMasterShift;
    {{-- 選択された行
         ※MultiRowでの行選択処理のために必要（FlexGridでは不要） --}}
    {{-- 担当者 --}}
    var selectedRowsTantousha = 0;
    {{-- 事業部 --}}
    var selectedRowsJigyoubu = 0;
    {{-- 部署 --}}
    var selectedRowsBusho = 0;
    {{-- 機械 --}}
    var selectedRowsKikai = 0;
    {{-- 右側（シフトマスター） --}}
    var selectedRowsShift = 0;
    {{-- グリッド初期処理--}}
    function InitGrid()
    {
        {{-- MultiRowのレイアウト設定 --}}
        {{-- 担当者 --}}
        let columnsTantousha = [
            {
                {{-- 1列目 --}}
                cells: [
                    {
                        {{-- 「担当者CD」 --}}
                        binding: 'dataTantoushaCd',
                        header : "{{ __('tantousha_cd') }}",
                        width  : '1*'
                    }
                ]
            },
            {
                {{-- 2列目 --}}
                cells: [
                    {{-- 1行目 --}}
                    {
                        {{-- 「担当者名」 --}}
                        binding: 'dataTantoushaName',
                        header : "{{ __('tantousha_name') }}",
                        width  : '1.2*'
                    }
                ]

            }
        ];

        {{-- 事業部 --}}
        let columnsJigyoubu = [
            {
                {{-- 1列目 --}}
                cells: [
                    {
                        {{-- 「事業部CD」 --}}
                        binding: 'dataJigyoubuCd',
                        header : "{{ __('jigyoubu_cd') }}",
                        width  : '1*'
                    }
                ]
            },
            {
                {{-- 2列目 --}}
                cells: [
                    {{-- 1行目 --}}
                    {
                        {{-- 「事業部名」 --}}
                        binding: 'dataJigyoubuName',
                        header : "{{ __('jigyoubu_name') }}",
                        width  : '1.2*'
                    }
                ]

            }
        ];

        {{-- 部署 --}}
        let columnsBusho = [
            {
                {{-- 1列目 --}}
                cells: [
                    {
                        {{-- 「部署CD」 --}}
                        binding: 'dataBushoCd',
                        header : "{{ __('busho_cd') }}",
                        width  : '1*'
                    }
                ]
            },
            {
                {{-- 2列目 --}}
                cells: [
                    {{-- 1行目 --}}
                    {
                        {{-- 「部署名」 --}}
                        binding: 'dataBushoName',
                        header : "{{ __('busho_name') }}",
                        width  : '1.2*'
                    }
                ]

            }
        ];

        {{-- 機械マスタ --}}
        let columnsKikai = [
            {
                {{-- 1列目 --}}
                cells: [
                    {
                        {{-- 「機械CD」 --}}
                        binding: 'dataKikaiCd',
                        header : "{{ __('kikai_cd') }}",
                        width  : '0.5*'
                    }
                ]
            },
            {
                {{-- 2列目 --}}
                cells: [
                    {
                        {{-- 「機械名」 --}}
                        binding: 'dataKikaiName',
                        header : "{{ __('kikai_name') }}",
                        width  : '0.5*'
                    }
                ]
            }
        ];


        {{-- シフトマスタ --}}
        let columnsShift = [
            {
                {{-- 1列目 --}}
                cells: [
                    {
                        {{-- 「シフトCD」 --}}
                        binding: 'dataShiftCd',
                        header : "{{ __('shift_cd') }}",
                        width  : '0.5*'
                    }
                ]
            },
            {
                {{-- 2列目 --}}
                cells: [
                    {
                        {{-- 「シフト名」 --}}
                        binding: 'dataShiftName',
                        header : "{{ __('shift_name') }}",
                        width  : '0.5*'
                    }
                ]
            }
        ];

        {{-- グリッドの設定 --}}

        {{-- 担当者 --}}
        let gridOptionTantousha = {
            {{-- レイアウト設定 ※MultiRow専用 --}}
            layoutDefinition: columnsTantousha,
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
                LoadGridRows(s, gridMasterTantousha.rowsPerItem);
            }
        }
        {{-- 事業部 --}}
        let gridOptionJigyoubu = {
            {{-- レイアウト設定 ※MultiRow専用 --}}
            layoutDefinition: columnsJigyoubu,
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
                LoadGridRows(s, gridMasterJigyoubu.rowsPerItem);
            }
        }
        {{-- 部署 --}}
        let gridOptionBusho = {
            {{-- レイアウト設定 ※MultiRow専用 --}}
            layoutDefinition: columnsBusho,
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
                LoadGridRows(s, gridMasterBusho.rowsPerItem);
            }
        }
        {{-- 機械 --}}
        let gridOptionKikai = {
            {{-- レイアウト設定 ※MultiRow専用 --}}
            layoutDefinition: columnsKikai,
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
                LoadGridRows(s, gridMasterKikai.rowsPerItem);
            }
        }

        {{-- シフトマスタ --}}
        let gridOptionShift = {
            {{-- レイアウト設定 ※MultiRow専用 --}}
            layoutDefinition: columnsShift,
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
                LoadGridRows(s, gridMasterShift.rowsPerItem);
            }
        }

        {{-- グリッド宣言 --}}
        {{-- 担当者 --}}
        gridMasterTantousha = new wijmo.grid.multirow.MultiRow('#gridMasterTantousha', gridOptionTantousha);
        {{-- 事業部 --}}
        gridMasterJigyoubu = new wijmo.grid.multirow.MultiRow('#gridMasterJigyoubu', gridOptionJigyoubu);
        {{-- 部署 --}}
        gridMasterBusho = new wijmo.grid.multirow.MultiRow('#gridMasterBusho', gridOptionBusho);
        {{-- 機械 --}}
        gridMasterKikai = new wijmo.grid.multirow.MultiRow('#gridMasterKikai', gridOptionKikai);

        {{-- シフトマスタ --}}
        gridMasterShift = new wijmo.grid.multirow.MultiRow('#gridMasterShift', gridOptionShift);

        {{-- グリッド関連のイベント登録 --}}
        {{-- グリッドの親要素 --}}
        {{-- 担当者 --}}
        let hostTantousha = gridMasterTantousha.hostElement;
        {{-- グリッドの「左クリック」イベント --}}
        gridMasterTantousha.addEventListener(hostTantousha, 'click', function (e)
        {
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            {{-- 選択した行番号を格納 --}}
            selectedRowsTantousha = SetSelectedMultiRow(gridMasterTantousha, selectedRowsTantousha);
            {{-- 選択した行のデータIDを格納 --}}
            SetSelectedRowIdTantousha(gridMasterTantousha.collectionView.currentItem['dataId']);
        });

        {{-- 事業部 --}}
        let hostJigyoubu = gridMasterJigyoubu.hostElement;
        {{-- グリッドの「左クリック」イベント --}}
        gridMasterJigyoubu.addEventListener(hostJigyoubu, 'click', function (e)
        {
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            {{-- 選択した行番号を格納 --}}
            selectedRowsJigyoubu = SetSelectedMultiRow(gridMasterJigyoubu, selectedRowsJigyoubu);
            {{-- 選択した行のデータIDを格納 --}}
            SetSelectedRowIdJigyoubu(gridMasterJigyoubu.collectionView.currentItem['dataId']);
        });

        {{-- 部署 --}}
        let hostBusho = gridMasterBusho.hostElement;
        {{-- グリッドの「左クリック」イベント --}}
        gridMasterBusho.addEventListener(hostBusho, 'click', function (e)
        {
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            {{-- 選択した行番号を格納 --}}
            selectedRowsBusho = SetSelectedMultiRow(gridMasterBusho, selectedRowsBusho);
            {{-- 選択した行のデータIDを格納 --}}
            SetSelectedRowIdBusho(gridMasterBusho.collectionView.currentItem['dataId']);
        });

        {{-- 機械 --}}
        let hostKikai = gridMasterKikai.hostElement;
        {{-- グリッドの「左クリック」イベント --}}
        gridMasterKikai.addEventListener(hostKikai, 'click', function (e)
        {
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            {{-- 選択した行番号を格納 --}}
            selectedRowsKikai = SetSelectedMultiRow(gridMasterKikai, selectedRowsKikai);
            {{-- 選択した行のデータIDを格納 --}}
            SetSelectedRowIdKikai(gridMasterKikai.collectionView.currentItem['dataId']);
        });


        {{-- シフトマスタ --}}
        let hostShift = gridMasterShift.hostElement;
        {{-- グリッドの「左クリック」イベント --}}
        gridMasterShift.addEventListener(hostShift, 'click', function (e)
        {
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            if(gridMasterShift.itemsSource.length < 1) return;
            {{-- 選択した行番号を格納 --}}
            selectedRowsShift = SetSelectedMultiRow(gridMasterShift, selectedRowsShift);
        });

        {{-- グリッドの「右クリック」イベント --}}
        {{-- 担当者 --}}
        gridMasterTantousha.addEventListener(hostTantousha, 'contextmenu', function (e)
        {
            {{-- セル上での右クリックメニュー表示 ※common_function.js参照 --}}
            SetGridContextMenu(gridMasterTantousha, e);
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            {{-- クリックした位置を選択 --}}
            gridMasterTantousha.select(new wijmo.grid.CellRange(gridMasterTantousha.hitTest(e).row, 0), true);
            {{-- 選択した行番号を格納 --}}
            selectedRowsTantousha = SetSelectedMultiRow(gridMasterTantousha, selectedRowsTantousha);
            {{-- 選択した行のデータIDを格納 --}}
            SetSelectedRowIdTantousha(gridMasterTantousha.collectionView.currentItem['dataId']);
        });
        {{-- グリッドの「ダブルクリック」イベント --}}
        gridMasterTantousha.addEventListener(hostTantousha, 'dblclick', function (e)
        {
            if(gridMasterTantousha.hitTest(e).cellType == wijmo.grid.CellType.Cell)
            {
                calendar.style.display = 'block';
                shiftMaster.style.display = 'block';
            }
        });
        {{-- グリッドの「キーボード」イベント --}}
        gridMasterTantousha.addEventListener(hostTantousha, 'keydown', function (e)
        {
            {{-- 「←・↑・→・↓キー」はクリック時と同じ処理 --}}
            if(e.keyCode >= KEY_LEFT && e.keyCode <= KEY_DOWN)
            {
                {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
                if(gridMasterTantousha.itemsSource.length < 1) return;
                {{-- 選択した行番号を格納 --}}
                selectedRowsTantousha = SetSelectedMultiRow(gridMasterTantousha, selectedRowsTantousha);
                {{-- 選択した行のデータIDを格納 --}}
                SetSelectedRowIdTantousha(gridMasterTantousha.collectionView.currentItem['dataId']);
                {{-- キーボードイベント二重起動防止 --}}
                windowKeybordFlg = false;
            }
        });

        {{-- 事業部 --}}
        gridMasterJigyoubu.addEventListener(hostJigyoubu, 'contextmenu', function (e)
        {
            {{-- セル上での右クリックメニュー表示 ※common_function.js参照 --}}
            SetGridContextMenu(gridMasterJigyoubu, e);
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            {{-- クリックした位置を選択 --}}
            gridMasterJigyoubu.select(new wijmo.grid.CellRange(gridMasterJigyoubu.hitTest(e).row, 0), true);
            {{-- 選択した行番号を格納 --}}
            selectedRowsJigyoubu = SetSelectedMultiRow(gridMasterJigyoubu, selectedRowsJigyoubu);
            {{-- 選択した行のデータIDを格納 --}}
            SetSelectedRowIdJigyoubu(gridMasterJigyoubu.collectionView.currentItem['dataId']);
        });
        {{-- グリッドの「ダブルクリック」イベント --}}
        gridMasterJigyoubu.addEventListener(hostJigyoubu, 'dblclick', function (e)
        {
            if(gridMasterJigyoubu.hitTest(e).cellType == wijmo.grid.CellType.Cell)
            {
                calendar.style.display = 'block';
                shiftMaster.style.display = 'block';
            }
        });
        {{-- グリッドの「キーボード」イベント --}}
        gridMasterJigyoubu.addEventListener(hostJigyoubu, 'keydown', function (e)
        {
            {{-- 「←・↑・→・↓キー」はクリック時と同じ処理 --}}
            if(e.keyCode >= KEY_LEFT && e.keyCode <= KEY_DOWN)
            {
                {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
                if(gridMasterJigyoubu.itemsSource.length < 1) return;
                {{-- 選択した行番号を格納 --}}
                selectedRowsJigyoubu = SetSelectedMultiRow(gridMasterJigyoubu, selectedRowsJigyoubu);
                {{-- 選択した行のデータIDを格納 --}}
                SetSelectedRowIdJigyoubu(gridMasterJigyoubu.collectionView.currentItem['dataId']);
                {{-- キーボードイベント二重起動防止 --}}
                windowKeybordFlg = false;
            }
        });

        {{-- 部署 --}}
        gridMasterBusho.addEventListener(hostBusho, 'contextmenu', function (e)
        {
            {{-- セル上での右クリックメニュー表示 ※common_function.js参照 --}}
            SetGridContextMenu(gridMasterBusho, e);
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            {{-- クリックした位置を選択 --}}
            gridMasterBusho.select(new wijmo.grid.CellRange(gridMasterBusho.hitTest(e).row, 0), true);
            {{-- 選択した行番号を格納 --}}
            selectedRowsBusho = SetSelectedMultiRow(gridMasterBusho, selectedRowsBusho);
            {{-- 選択した行のデータIDを格納 --}}
            SetSelectedRowIdBusho(gridMasterBusho.collectionView.currentItem['dataId']);
        });
        {{-- グリッドの「ダブルクリック」イベント --}}
        gridMasterBusho.addEventListener(hostBusho, 'dblclick', function (e)
        {
            if(gridMasterBusho.hitTest(e).cellType == wijmo.grid.CellType.Cell)
            {
                calendar.style.display = 'block';
                shiftMaster.style.display = 'block';
            }
        });
        {{-- グリッドの「キーボード」イベント --}}
        gridMasterBusho.addEventListener(hostBusho, 'keydown', function (e)
        {
            {{-- 「←・↑・→・↓キー」はクリック時と同じ処理 --}}
            if(e.keyCode >= KEY_LEFT && e.keyCode <= KEY_DOWN)
            {
                {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
                if(gridMasterBusho.itemsSource.length < 1) return;
                {{-- 選択した行番号を格納 --}}
                selectedRowsBusho = SetSelectedMultiRow(gridMasterBusho, selectedRowsBusho);
                {{-- 選択した行のデータIDを格納 --}}
                SetSelectedRowIdBusho(gridMasterBusho.collectionView.currentItem['dataId']);
                {{-- キーボードイベント二重起動防止 --}}
                windowKeybordFlg = false;
            }
        });

        {{-- 機械 --}}
        gridMasterKikai.addEventListener(hostKikai, 'contextmenu', function (e)
        {
            {{-- セル上での右クリックメニュー表示 ※common_function.js参照 --}}
            SetGridContextMenu(gridMasterKikai, e);
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            {{-- クリックした位置を選択 --}}
            gridMasterKikai.select(new wijmo.grid.CellRange(gridMasterKikai.hitTest(e).row, 0), true);
            {{-- 選択した行番号を格納 --}}
            selectedRowsKikai = SetSelectedMultiRow(gridMasterKikai, selectedRowsKikai);
            {{-- 選択した行のデータIDを格納 --}}
            SetSelectedRowIdKikai(gridMasterKikai.collectionView.currentItem['dataId']);
        });
        {{-- グリッドの「ダブルクリック」イベント --}}
        gridMasterKikai.addEventListener(hostKikai, 'dblclick', function (e)
        {
            if(gridMasterKikai.hitTest(e).cellType == wijmo.grid.CellType.Cell)
            {
                calendar.style.display = 'block';
                shiftMaster.style.display = 'block';
            }
        });
        {{-- グリッドの「キーボード」イベント --}}
        gridMasterKikai.addEventListener(hostKikai, 'keydown', function (e)
        {
            {{-- 「←・↑・→・↓キー」はクリック時と同じ処理 --}}
            if(e.keyCode >= KEY_LEFT && e.keyCode <= KEY_DOWN)
            {
                {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
                if(gridMasterKikai.itemsSource.length < 1) return;
                {{-- 選択した行番号を格納 --}}
                selectedRowsKikai = SetSelectedMultiRow(gridMasterKikai, selectedRowsKikai);
                {{-- 選択した行のデータIDを格納 --}}
                SetSelectedRowIdKikai(gridMasterKikai.collectionView.currentItem['dataId']);
                {{-- キーボードイベント二重起動防止 --}}
                windowKeybordFlg = false;
            }
        });


        {{-- シフトマスタ --}}
        gridMasterShift.addEventListener(hostShift, 'keydown', function (e)
        {
            {{-- 「←・↑・→・↓キー」はクリック時と同じ処理 --}}
            if(e.keyCode >= KEY_LEFT && e.keyCode <= KEY_DOWN)
            {
                {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
                if(gridMasterShift.itemsSource.length < 1) return;
                {{-- 選択した行番号を格納 --}}
                selectedRowsShift = SetSelectedMultiRow(gridMasterShift, selectedRowsShift);
                {{-- 選択した行のデータIDを格納 --}}
                SetSelectedRowIdShift(gridMasterShift.collectionView.currentItem['dataId']);
                {{-- キーボードイベント二重起動防止 --}}
                windowKeybordFlg = false;
            }
        });
    }

    {{-- --------------------------- --}}
    {{-- ボタンイベント登録用の関数変数 --}}
    {{-- --------------------------- --}}


    function AjaxDataSub(URL, callBackFunction)
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: URL,
            datatype: "json"
        }).done(function (data) {
            console.log(data);
            callBackFunction(data, false);
        }).fail(function (data) {
            console.log(data);
            callBackFunction(data, true);
        });
    }

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

        {{-- 「データ更新中」表示 --}}
        ShowPopupDlg("{{ __('データ読込中') }}");
        {{-- グリッドのデータ受信 --}}
        {{-- シフト（カレンダー） --}}
        AjaxData("{{ url('/master/3100') }}",soushinData,  fncJushinGridData);



        {{-- 担当者 --}}
        AjaxDataSub("{{ url('/master/0400') }}", fncJushinGridDataTantousha);
        {{-- 事業部 --}}
        AjaxDataSub("{{ url('/master/0100') }}", fncJushinGridDataJigyoubu);
        {{-- 部署 --}}
        AjaxDataSub("{{ url('/master/0300') }}", fncJushinGridDataBusho);
        {{-- 機械 --}}
        AjaxDataSub("{{ url('/master/0800') }}", fncJushinGridDataKikai);
        {{-- シフトマスタ --}}
        AjaxDataSub("{{ url('/master/2900') }}", fncJushinGridDataShift);

    }
    {{-- 「CSV出力」ボタンイベント --}}
    var fncExportCSV = function()
    {
        {{-- CSV出力用グリッドのレイアウト設定 --}}
        {{-- シフト（カレンダー） --}}
        let columns = [{ binding: 'dataTantoushaCd',   header : "{{ __('tantousha_cd') }}" },
                           { binding: 'dataTantoushaName', header : "{{ __('tantousha_name') }}" }];


        {{-- 現在のグリッドの並び替え条件取得 --}}
        {{-- シフト（カレンダー） --}}
        let sortState = calendarGrid.collectionView.sortDescriptions.map(
            function (sd)
            {
                {{-- 並び替え条件をオブジェクト配列として返す --}}
                return { property: sd.property, ascending: sd.ascending }
            }
        );
        {{-- CSV出力時の並び替え条件を設定 --}}
        {{-- シフト（カレンダー） --}}
        let sortDesc = new wijmo.collections.SortDescription(sortState[0].property, sortState[0].ascending);
        {{-- CSVファイル作成
             ※ファイル名は「ページタイトル+yyyymmddhhMMss（年月日時分秒）+.csv」
             ※common_function.js参照 --}}
        ExportCSVFile(calendarGrid.itemsSource, columns, sortDesc, '{{ $pageTitle }}'+ getNowDateTime() +'.csv');

    }
    {{-- 「新規・参照新規・修正・削除」ボタンイベント
         ※mode → 入力ダイアログの操作、新規・修正・削除のどの処理で開いたかを判別する処理種別
         　copy → 参照新規や修正などで選択行のレコード情報を初期入力させるかの判定 --}}
    var fncNyuryokuData = function(mode, copy)
    {
        {{-- 入力フォーム要素 --}}
        let nyuryokuData = document.forms['frmNyuryoku'].elements;
        {{-- 選択行のグリッドデータ --}}
        let data = calendarGrid.collectionView.currentItem;
        {{-- 「新規」処理フラグ --}}
        let insertFlg = (mode == MODE_INSERT);

        {{-- 「処理種別」 --}}
        nyuryokuData['dataSQLType'].value = mode;
        {{-- 「対象CD」 --}}
        nyuryokuData['dataTaishouCd'].value = (copy && !insertFlg) ? data['dataTaishouCd'] : '';
        nyuryokuData['dataTaishouCd'].disabled = !insertFlg;
        {{-- 「シフトCD」 --}}
        nyuryokuData['dataShiftCd'].value = (copy && !insertFlg) ? data['dataShiftCd'] : '';
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
        nyuryokuData['dataShiftCd'].disabled = deleteFlg; {{-- 「シフトCD」 --}}

        {{-- 入力フォームのスタイル初期化 ※common_function.js参照　--}}
        InitFormStyle();
    }


    {{-- ----------------------------- --}}
    {{-- 非同期処理呼び出し養用の関数変数 --}}
    {{-- ----------------------------- --}}
    {{-- ※data → 非同期通信で受信したjsonデータ配列
         　errorFlg → 非同期通信先のエラー処理判定 --}}
    {{-- データグリッド更新 --}}
    {{-- シフト（カレンダー） --}}
    var fncJushinGridData = function(data, errorFlg)
    {
        {{-- 「データ更新中」非表示 --}}
        ClosePopupDlg();
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(IsAjaxDataError(data, errorFlg)) return;
        {{-- グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 --}}
    }

    {{-- 担当者 --}}
    var fncJushinGridDataTantousha = function(dataTantousha, errorFlg)
    {
        {{-- 「データ更新中」非表示 --}}
        ClosePopupDlg();
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(IsAjaxDataError(dataTantousha, errorFlg)) return;
        {{-- グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 --}}
        selectedRowsTantousha = SortMultiRowData(gridMasterTantousha, dataTantousha[1], 'dataTantoushaCd');
    }

    {{-- 事業部 --}}
    var fncJushinGridDataJigyoubu = function(dataJigyoubu, errorFlg)
    {
        {{-- 「データ更新中」非表示 --}}
        ClosePopupDlg();
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(IsAjaxDataError(dataJigyoubu, errorFlg)) return;
        {{-- グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 --}}
        selectedRowsJigyoubu = SortMultiRowData(gridMasterJigyoubu, dataJigyoubu[1], 'dataJigyoubuCd');
    }

    {{-- 部署 --}}
    var fncJushinGridDataBusho = function(dataBusho, errorFlg)
    {
        {{-- 「データ更新中」非表示 --}}
        ClosePopupDlg();
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(IsAjaxDataError(dataBusho, errorFlg)) return;
        {{-- グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 --}}
        selectedRowsBusho = SortMultiRowData(gridMasterBusho, dataBusho[1], 'dataBushoCd');
    }

    {{-- 機械 --}}
    var fncJushinGridDataKikai = function(dataKikai, errorFlg)
    {
        {{-- 「データ更新中」非表示 --}}
        ClosePopupDlg();
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(IsAjaxDataError(dataKikai, errorFlg)) return;
        {{-- グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 --}}
        selectedRowsKikai = SortMultiRowData(gridMasterKikai, dataKikai[1], 'dataKikaiCd');
    }


    {{-- シフトマスタ --}}
    var fncJushinGridDataShift = function(dataShift, errorFlg)
    {
        {{-- 「データ更新中」非表示 --}}
        ClosePopupDlg();
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(IsAjaxDataError(dataShift, errorFlg)) return;
        {{-- グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 --}}
        selectedRowsShift = SortMultiRowData(gridMasterShift, dataShift[1], 'dataShiftCd');
    }

    {{-- DBデータ更新 --}}
    {{-- シフト（カレンダー） --}}
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
        {{-- シフト（カレンダー） --}}
        function IsChangeNyuryokuData(nyuryoku)
        {
            {{-- 選択行のグリッドデータ --}}
            let data = calendarGrid.collectionView.currentItem;
            {{-- 更新処理以外の処理の場合は判定せずにtrue --}}
            if(nyuryokuData['dataSQLType'].value != MODE_UPDATE) return true;
            {{-- 「シフトCD」 --}}
            if(nyuryokuData['dataShiftCd'].value != data['dataShiftCd']) return true;

            {{-- 上記項目に変更が無い場合はfalse --}}
            return false;
        }


        {{-- HTMLでの送信をキャンセル --}}
        event.preventDefault();
        {{-- シフト --}}
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
                AjaxData("{{ url('/master/3101') }}", soushinData, fncUpdateData);
            }, null);
        }
        else
        {
            {{-- 「データ更新中」表示 --}}
            ShowPopupDlg("{{__('データ更新中')}}");
            {{-- 非同期データ更新開始 --}}
            AjaxData("{{ url('/master/3101') }}", soushinData, fncUpdateData);
        }

    });

    {{-- テキスト変更時に連動するテキスト要素のリセット処理 --}}
    $('input[type="text"]').change(function() {
        {{-- 連動テキスト要素のある要素を判別 --}}
        switch($(this)[0].name)
        {
            {{-- 事業部CD --}}
            case 'dataJigyoubuCd': break;
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
