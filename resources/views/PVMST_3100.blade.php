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
                <span style="width:5.7em;">{{__('jigyoubu_cd')}}</span>
                <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                    <input name="dataJigyoubuCd" class="form-control" type="text"
                           maxlength="6" autocomplete="off" style="width:8em;"onchange = "fncChangeDisable()">
                    {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                    <i class="fas fa-search search-btn"onclick = "fncChangeDisable()"></i>
                </span>
                {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                <input name="dataJigyoubuName" class="form-control" type="text"
                       style="width:22em;" onfocus="blur();" readonly>
            </label>
            {{-- 「リソース区分」 --}}
            <label>
                <span style="width:6em;">{{__('resource_kbn')}}</span>
                {{-- 「リソース区分」コンボボックス本体 --}}
                <div id="cmbResourceKbn" style="width:18em;"></div>
                {{-- 「リソース区分」フォーム送信データ --}}
                <input name="dataResourceKbn" type="hidden">
            </label>
            {{-- 対象日 --}}
            <label>
                <span style="width:6em;">{{__('taishou_date')}}</span>
                <select id="year" name="year" class="form-control" style="width:4em; text-align:right;"onchange = "fncChangeDisable()">
                    <script>
                        var i;
                        for(i = 2021; i <= 2099; i++)
                        {
                            document.write('<option value="'+ i +'">' + i + '</option>');
                        }
                    </script>
                </select>
                <span style="margin-right:1em;">{{__('年')}}</span>
                <select id="month" name="month" class="form-control" style="width:3em; text-align:right;" onchange = "fncChangeDisable()">
                    <option value="0">1</option>
                    <option value="1">2</option>
                    <option value="2">3</option>
                    <option value="3">4</option>
                    <option value="4">5</option>
                    <option value="5">6</option>
                    <option value="6">7</option>
                    <option value="7">8</option>
                    <option value="8">9</option>
                    <option value="9">10</option>
                    <option value="10">11</option>
                    <option value="11">12</option>
                </select>
                <span>{{__('月')}}</span>
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
    <div id="gridMasterLeft" style="width:25%; position:absolute; left:0%; top:calc(5.6% + {{$kensakuHight}}); height:calc(88.68% - {{$kensakuHight}});"></div>

    {{-- カレンダーマスター（右側） --}}
    {{-- シフト --}}
    <div id="gridMasterShift" style="width:20%; position:absolute; left:80%; top:calc(5.6% + {{$kensakuHight}}); height:calc(88.68% - {{$kensakuHight}}); display:none;"></div>

    {{-- カレンダーマスター（中央） --}}
    <div id="calendar"  style="padding-top:1%; width:45%; position:absolute; left:30%; top:calc(5% + {{$kensakuHight}}); height:calc(89.8% - {{$kensakuHight}}); display: none">
        <div class="row" style="margin-right:0px; margin-bottom:10px;">
            <div class="col-lg-3">
                <button onclick="dataTouroku()" id="dataTouroku" type="submit" class="btn btn-primary btn-block" style="width:9em;">データ登録</button>
            </div>
        </div>
        {{-- カレンダー表示 --}}
        <div id="calendarGrid" class="row"></div>
    </div>
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
    var cmbResourceKbn = new wijmo.input.ComboBox('#cmbResourceKbn', { itemsSource: resourceKbn, isRequired: false });
    var jigyoubuMaster = document.getElementById('gridMasterLeft');
    var shiftMaster = document.getElementById('gridMasterShift');
    var calendar = document.getElementById('calendar');
    var jigyoubuCd = document.getElementById('dataJigyoubuCd');
    var btnShinki = document.getElementById('btnShinki');
    var btnSanshouShinki = document.getElementById('btnSanshouShinki');
    var btnShusei = document.getElementById('btnShusei');
    var btnSakujo = document.getElementById('btnSakujo');

    btnShinki.style.display = 'none';
    btnSanshouShinki.style.display = 'none';
    btnShusei.style.display = 'none';
    btnSakujo.style.display = 'none';

    cmbResourceKbn.selectedIndexChanged.addHandler(function(sender, e)
    {
        if(sender.selectedValue == '事業部')
        {
            fncChangeDisable();
            AjaxDataSub("{{ url('/inquiry/CalendarJigyoubu') }}", fncJushinGridDataLeft);
        }
        else if(sender.selectedValue == '部署')
        {
            fncChangeDisable();
            AjaxDataSub("{{ url('/inquiry/CalendarBusho') }}", fncJushinGridDataLeft);
        }
        else if(sender.selectedValue == '機械')
        {
            fncChangeDisable();
            AjaxDataSub("{{ url('/inquiry/CalendarKikai') }}", fncJushinGridDataLeft);
        }
        else if(sender.selectedValue == '担当者')
        {
            fncChangeDisable();
            AjaxDataSub("{{ url('/inquiry/CalendarTantousha') }}", fncJushinGridDataLeft);
        }
    })
    function fncChangeDisable(){
        calendar.style.display = 'none';
        shiftMaster.style.display = 'none';
    }

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
        fncShowDataGrid();

        {{-- 「CSV出力」ボタンイベント登録 ※common_function.js参照 --}}
        SetBtnCSV(fncExportCSV);

        {{-- グリッド初期処理--}}
        InitGrid();

        {{-- 対象日初期値 --}}
        var d = new Date();
        var m = d.getMonth();
        var y = d.getFullYear();
        $("#month").val(m);
        $("#year").val(y);
    }

    var calData;
    var calendarGrid;
    var selectedRows = 0;
    function MakeCalendarData(Month, Year)
    {
        var Mon = "", Tue = "",Wed = "", Thu = "", Fri = "", Sat = "", Sun = "";
        var calData = new wijmo.collections.ObservableArray();
        // Get the start day, e.g., Monday=1, Tuesday=2, etc.
        var firstDay = new Date(Year, Month, 1);
        var startingDay = firstDay.getDay() -1;
        if(startingDay < 0)
        {
            startingDay = startingDay + 7;
        }
        // Get the month length
        var cal_days_in_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        var monthLength = cal_days_in_month[Month];
        if (Month == 1)
        { 
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
                Sunday: Sun,
                dataMonShiftCd: '',
                dataTueShiftCd: '',
                dataWedShiftCd: '',
                dataThuShiftCd: '',
                dataFriShiftCd: '',
                dataSatShiftCd: '',
                dataSunShiftCd: ''
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
        //console.log(calData,"calData");
        var calArray;
        for(var c = 0; c < calData['length']; c++){
            //console.log(calData[c])
            calArray = calData[c];
            if(calArray['Monday'] === '' || calArray['Monday'] === null || calArray['Monday'] === undefined){
            }else{
                let calArray2 = {'dataMonShiftCd': ''};
                Object.assign(calArray,calArray2);
            }
            if(calArray['Tuesday'] === '' || calArray['Tuesday'] === null || calArray['Tuesday'] === undefined){
            }else{
                let calArray2 = {'dataTueShiftCd': ''};
                Object.assign(calArray,calArray2);
            }
            if(calArray['Wednesday'] === '' || calArray['Wednesday'] === null || calArray['Wednesday'] === undefined){
            }else{
                let calArray2 = {'dataWedShiftCd': ''};
                Object.assign(calArray,calArray2);
            }
            if(calArray['Thursday'] === '' || calArray['Thursday'] === null || calArray['Thursday'] === undefined){
            }else{
                let calArray2 = {'dataThuShiftCd': ''};
                Object.assign(calArray,calArray2);
            }
            if(calArray['Friday'] === '' || calArray['Friday'] === null || calArray['Friday'] === undefined){
            }else{
                let calArray2 = {'dataFriShiftCd': ''};
                Object.assign(calArray,calArray2);
            }
            if(calArray['Saturday'] === '' || calArray['Saturday'] === null || calArray['Saturday'] === undefined){
            }else{
                let calArray2 = {'dataSatShiftCd': ''};
                Object.assign(calArray,calArray2);
            }
            if(calArray['Sunday'] === '' || calArray['Sunday'] === null || calArray['Sunday'] === undefined){
            }else{
                let calArray2 = {'dataSunShiftCd': ''};
                Object.assign(calArray,calArray2);
            }
        }
        //console.log(calData)
        return calData;

    }

    function MakeCalendarGrid(calData)
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
                            binding: 'dataMonShiftCd',
                            isReadOnly: true,
                            allowSorting: false,
                            /*cellTemplate: (ctx) => {
                                let ctxItem = ctx.item;
                                var ctxValue = ctxItem.dataMonShiftCd;
                                console.log(ctxItem)
                                const cls = _getChangeCls(ctx.value);
                                return `<span class="${cls}"></span>`;
                            }*/
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
                            binding: 'dataTueShiftCd',
                            isReadOnly: true,
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
                            binding: 'dataWedShiftCd',
                            isReadOnly: true,
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
                            binding: 'dataThuShiftCd',
                            isReadOnly: true,
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
                            binding: 'dataFriShiftCd',
                            isReadOnly: true,
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
                            binding: 'dataSatShiftCd',
                            isReadOnly: true,
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
                            binding: 'dataSunShiftCd',
                            isReadOnly: true,
                            allowSorting: false
                        }
                    ]
                }
            ];

            //console.log(calData,"データ");
            let gridOption = {
                itemsSource: calData,
                layoutDefinition:columns,
                selectionMode: wijmo.grid.SelectionMode.CellRange,
                keyActionEnter:wijmo.grid.KeyAction.None,
                allowResizing: false,
                collapsedHeaders:true,
                /*formatItem: function (s, e) {
                if (e.panel == s.cells) {
                    var value = e.panel.getCellData(e.row, e.col);
                    wjCore.toggleClass(e.cell, 'high-value', wjCore.isNumber(value) && value > 6000);
                    wjCore.toggleClass(e.cell, 'low-value', wjCore.isNumber(value) && value < 2000);
                }*/
            }
                // ↓セル読み込み時のイベント（グリッドの色付け）
                //loadedRows: function (s, e)
                //{
                //    LoadGridRows(s, calendarData.rowsPerItem);
                //}
            
            //console.log(calData,'calData');
            if(calendarGrid != null)
            {
                calendarGrid.dispose()
            }
            calendarGrid = new wijmo.grid.multirow.MultiRow('#calendarGrid',gridOption);
            //console.log(calendarGrid,"グリッド");
            calendarGrid.itemFormatter = function(panel, r, c ,cell)
            {
                // セル
                if (panel.cellType == wijmo.grid.CellType.Cell)
                {
                    var flex = panel.grid;
                    var calItems = calendarGrid.itemsSource;
                    var calArray;
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
                    /*if(calItems['row'] === undefined || calItems['col'] === undefined){
                    }
                    else if(c == calItems['col'] && r == calItems['row'] * 2 + 1){
                        cell.style.color = 'red';
                    }*/
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

            {{-- グリッドの「ダブルクリック」イベント --}}
            calendarGrid.addEventListener(host, 'dblclick', function (e)
            {
                var ht = calendarGrid.hitTest(e.pageX, e.pageY);
                if(calendarGrid.hitTest(e).cellType == wijmo.grid.CellType.Cell){
                    var dataShift = gridMasterShift.collectionView.currentItem['dataShiftCd'];
                    var dataEndJikokuTsujou = gridMasterShift.collectionView.currentItem['dataEndJikokuTsujou'];
                    var dataEndJikokuZangyou = gridMasterShift.collectionView.currentItem['dataEndJikokuZangyou'];
                    var dataKeikaJikanTsujou = gridMasterShift.collectionView.currentItem['dataKeikaJikanTsujou'];
                    var dataKeikaJikanZangyou = gridMasterShift.collectionView.currentItem['dataKeikaJikanZangyou'];
                    var index = Math.floor(ht.row / calendarGrid.rowsPerItem);
                    var calenderItem = calendarGrid.itemsSource;
                    var col = calendarGrid.getBindingColumn(ht.panel, ht.row, ht.col);
                    var kbnValue = resourceKbnValue[cmbResourceKbn.selectedIndex];
                    var m = calenderItem[index]["Monday"];
                    var m2 = calenderItem[index]["dataMonShiftCd"];
                    var mFlg;
                    if(col.header == "Monday" || col.header == "dataMonShiftCd"){
                        if(m === '' || m === undefined){
                            mFlg = false;
                        }
                        else if(m2 == dataShift){
                            mFlg = false;
                        }
                        else if(dataShift == '空白'){
                            mFlg = false;
                        }
                        else{
                            mFlg = true;
                        }
                        let obj = { 'dataMonEndJikokuTsujou': dataEndJikokuTsujou, 'dataMonEndJikokuZangyou': dataEndJikokuZangyou, 'dataMonKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataMonKeikaJikanZangyou': dataKeikaJikanZangyou};
                        Object.assign(calenderItem[index], obj);
                        calenderItem[index]["dataMonShiftCd"] = mFlg ? dataShift : '';
                        if(kbnValue !== 0 && calenderItem[index]["dataMonIdFlg"] != kbnValue && calenderItem[index]["dataMonId"] !== undefined){
                            delete calenderItem[index]["dataMonId"];
                        }
                        calenderItem[index]["dataMonIdFlg"] = resourceKbnValue[cmbResourceKbn.selectedIndex];
                        
                        /*if(dataShift == 'H'){
                            calenderItem.row = index;
                            calenderItem.col = 0;
                        }*/
                        MakeCalendarGrid(calenderItem);
                    }
                    var t = calenderItem[index]["Tuesday"];
                    var t2 = calenderItem[index]["dataTueShiftCd"];
                    var tFlg;
                    if(col.header == "Tuesday" || col.header == "dataTueShiftCd"){
                        if(t === '' || t === undefined){
                            tFlg = false;
                        }
                        else if(t2 == dataShift)
                        {
                            tFlg = false;
                        }
                        else if(dataShift == '空白'){
                            tFlg = false;
                        }
                        else{
                            tFlg = true;
                        }
                        let obj = { 'dataTueEndJikokuTsujou': dataEndJikokuTsujou, 'dataTueEndJikokuZangyou': dataEndJikokuZangyou, 'dataTueKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataTueKeikaJikanZangyou': dataKeikaJikanZangyou};
                        Object.assign(calenderItem[index], obj);
                        calenderItem[index]["dataTueShiftCd"] = tFlg ? dataShift : '';
                        if(kbnValue !== 0 && calenderItem[index]["dataTueIdFlg"] != kbnValue && calenderItem[index]["dataTueId"] !== undefined){
                            delete calenderItem[index]["dataTueId"];
                        }
                        calenderItem[index]["dataTueIdFlg"] =  resourceKbnValue[cmbResourceKbn.selectedIndex];

                        MakeCalendarGrid(calenderItem);
                    }
                    var w = calenderItem[index]["Wednesday"];
                    var w2 = calenderItem[index]["dataWedShiftCd"];
                    var wFlg;
                    if(col.header == "Wednesday" || col.header == "dataWedShiftCd"){
                        if(w === '' || w === undefined){
                            wFlg = false;
                        }
                        else if(w2 == dataShift){
                            wFlg = false;
                        }
                        else if(dataShift == '空白'){
                            wFlg = false;
                        }
                        else{
                            wFlg = true;
                        }
                        let obj = { 'dataWedEndJikokuTsujou': dataEndJikokuTsujou, 'dataWedEndJikokuZangyou': dataEndJikokuZangyou, 'dataWedKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataWedKeikaJikanZangyou': dataKeikaJikanZangyou};
                        Object.assign(calenderItem[index], obj);
                        calenderItem[index]["dataWedShiftCd"] = wFlg ? dataShift : '';
                        if(kbnValue !== 0 && calenderItem[index]["dataWedIdFlg"] != kbnValue && calenderItem[index]["dataWedId"] !== undefined){
                            delete calenderItem[index]["dataWedId"];
                        }
                        calenderItem[index]["dataWedIdFlg"] =  resourceKbnValue[cmbResourceKbn.selectedIndex];

                        MakeCalendarGrid(calenderItem);
                    }
                    var th = calenderItem[index]["Thursday"];
                    var th2 = calenderItem[index]["dataThuShiftCd"];
                    var thFlg;
                    if(col.header == "Thursday" || col.header == "dataThuShiftCd"){
                        if(th === '' || th === undefined){
                            thFlg = false;
                        }
                        else if(th2 == dataShift){
                            thFlg = false;
                        }
                        else if(dataShift == '空白'){
                            thFlg = false;
                        }
                        else{
                            thFlg = true;
                        }
                        let obj = { 'dataThuEndJikokuTsujou': dataEndJikokuTsujou, 'dataThuEndJikokuZangyou': dataEndJikokuZangyou, 'dataThuKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataThuKeikaJikanZangyou': dataKeikaJikanZangyou};
                        Object.assign(calenderItem[index], obj);
                        calenderItem[index]["dataThuShiftCd"] = thFlg ? dataShift : '';
                        if(kbnValue !== 0 && calenderItem[index]["dataThuIdFlg"] != kbnValue && calenderItem[index]["dataThuId"] !== undefined){
                            delete calenderItem[index]["dataThuId"];
                        }
                        calenderItem[index]["dataThuIdFlg"] =  resourceKbnValue[cmbResourceKbn.selectedIndex];

                        MakeCalendarGrid(calenderItem);
                    }
                    var f = calenderItem[index]["Friday"];
                    var f2 = calenderItem[index]["dataFriShiftCd"];
                    var fFlg;
                    if(col.header == "Friday" || col.header == "dataFriShiftCd"){
                        if(f === '' || f === undefined){
                            fFlg = false;
                        }
                        else if(f2 == dataShift){
                            fFlg = false;
                        }
                        else if(dataShift == '空白'){
                            fFlg = false;
                        }
                        else{
                            fFlg = true;
                        }
                        let obj = { 'dataFriEndJikokuTsujou': dataEndJikokuTsujou, 'dataFriEndJikokuZangyou': dataEndJikokuZangyou, 'dataFriKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataFriKeikaJikanZangyou': dataKeikaJikanZangyou};
                        Object.assign(calenderItem[index], obj);
                        calenderItem[index]["dataFriShiftCd"] = fFlg ? dataShift : '';
                        if(kbnValue !== 0 && calenderItem[index]["dataFriIdFlg"] != kbnValue && calenderItem[index]["dataFriId"] !== undefined){
                            delete calenderItem[index]["dataFriId"];
                        }
                        calenderItem[index]["dataFriIdFlg"] =  resourceKbnValue[cmbResourceKbn.selectedIndex];

                        //console.log(calenderItem);
                        MakeCalendarGrid(calenderItem);
                    }
                    var s = calenderItem[index]["Saturday"];
                    var s2 = calenderItem[index]["dataSatShiftCd"];
                    var s;
                    if(col.header == "Saturday" || col.header == "dataSatShiftCd"){
                        /*if(s2 == ''){
                            sFlg = true;
                        }else if(s2 != dataShift){
                            sFlg = true;
                        }else{
                            sFlg = false;
                        }
                        if(s2 === '' || s2 === undefined){
                            calenderItem[index]["dataSatShiftCd"] = '';
                        }else{
                            calenderItem[index]["dataSatShiftCd"] = sFlg ? dataShift : '';
                        }*/
                        if(s === '' || s === undefined){
                            sFlg = false;
                        }
                        else if(s2 == dataShift){
                            sFlg = false;
                        }
                        else if(dataShift == '空白'){
                            sFlg = false;
                        }
                        else{
                            sFlg = true;
                        }
                        let obj = { 'dataSatEndJikokuTsujou': dataEndJikokuTsujou, 'dataSatEndJikokuZangyou': dataEndJikokuZangyou, 'dataSatKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataSatKeikaJikanZangyou': dataKeikaJikanZangyou};
                        Object.assign(calenderItem[index], obj);
                        calenderItem[index]["dataSatShiftCd"] = sFlg ? dataShift : '';
                        if(kbnValue !== 0 && calenderItem[index]["dataSatIdFlg"] != kbnValue && calenderItem[index]["dataSatId"] !== undefined){
                            delete calenderItem[index]["dataSatId"];
                        }
                        calenderItem[index]["dataSatIdFlg"] =  resourceKbnValue[cmbResourceKbn.selectedIndex];

                        MakeCalendarGrid(calenderItem);
                    }
                    var su = calenderItem[index]["Sunday"];
                    var su2 = calenderItem[index]["dataSunShiftCd"];
                    var suFlg;
                    if(col.header == "Sunday" || col.header == "dataSunShiftCd"){
                        if(su === '' || su === undefined){
                            suFlg = false;
                        }
                        else if(su2 == dataShift){
                            suFlg = false;
                        }
                        else if(dataShift == '空白'){
                            suFlg = false;
                        }
                        else{
                            suFlg = true;
                        }
                        let obj = { 'dataSunEndJikokuTsujou': dataEndJikokuTsujou, 'dataSunEndJikokuZangyou': dataEndJikokuZangyou, 'dataSunKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataSunKeikaJikanZangyou': dataKeikaJikanZangyou};
                        Object.assign(calenderItem[index], obj);
                        calenderItem[index]["dataSunShiftCd"] = suFlg ? dataShift : '';
                        if(kbnValue !== 0 && calenderItem[index]["dataSunIdFlg"] != kbnValue && calenderItem[index]["dataSunId"] !== undefined){
                            delete calenderItem[index]["dataSunId"];
                        }
                        calenderItem[index]["dataSunIdFlg"] =  resourceKbnValue[cmbResourceKbn.selectedIndex];

                        MakeCalendarGrid(calenderItem);
                    }
                }
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

    /*function _getChangeCls(value){
        if (value == '休') {
            return 'change-up';
        }
        else {
            return 'change-down';
        }
    }*/

    {{-- 左側 --}}
    function SetSelectedRowIdLeft(rowId)
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
    var gridMasterLeft;
    {{-- 右側（シフトマスター） --}}
    var gridMasterShift;
    {{-- 選択された行
         ※MultiRowでの行選択処理のために必要（FlexGridでは不要） --}}
    {{-- 左側 --}}
    var selectedRowsLeft = 0;
    {{-- 右側（シフトマスター） --}}
    var selectedRowsShift = 0;
    {{-- グリッド初期処理--}}
    function InitGrid()
    {
        var resoueceNum = resourceKbnValue[cmbResourceKbn.selectedIndex];
        var kbnName;
        /*if(resoueceNum === 0){
            kbnName = '事業部';
        }
        else if(resoueceNum === 1){
            kbnName = '部署';
        }
        else if(resoueceNum === 2){
            kbnName = '機械';
        }
        else if(resoueceNum === 3){
            kbnName = '担当者';
        }*/
        {{-- MultiRowのレイアウト設定 --}}
        {{-- 左側 --}}
        let columnsLeft = [
            {
                {{-- 1列目 --}}
                cells: [
                    {
                        {{-- 「コード」 --}}
                        binding: 'dataSentakuCd',
                        header : "{{ __('コード') }}",
                        width  : '1*'
                    }
                ]
            },
            {
                {{-- 2列目 --}}
                cells: [
                    {
                        {{-- 「名称」 --}}
                        binding: 'dataSentakuName',
                        header : "{{ __('名称') }}",
                        width  : '1.2*'
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
        {{-- 左側 --}}
        let gridOptionLeft = {
            {{-- レイアウト設定 ※MultiRow専用 --}}
            layoutDefinition: columnsLeft,
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
                LoadGridRows(s, gridMasterLeft.rowsPerItem);
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
            {{-- ソート無効 --}}
            allowSorting: false,
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
        {{-- 左側 --}}
        gridMasterLeft = new wijmo.grid.multirow.MultiRow('#gridMasterLeft', gridOptionLeft);

        {{-- シフトマスタ --}}
        gridMasterShift = new wijmo.grid.multirow.MultiRow('#gridMasterShift', gridOptionShift);

        {{-- グリッド関連のイベント登録 --}}
        {{-- グリッドの親要素 --}}
        {{-- 左側 --}}
        let hostLeft = gridMasterLeft.hostElement;
        {{-- グリッドの「左クリック」イベント --}}
        gridMasterLeft.addEventListener(hostLeft, 'click', function (e)
        {
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            {{-- 選択した行番号を格納 --}}
            selectedRowsLeft = SetSelectedMultiRow(gridMasterLeft, selectedRowsLeft);
            {{-- 選択した行のデータIDを格納 --}}
            SetSelectedRowIdLeft(gridMasterLeft.collectionView.currentItem['dataId']);
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
            {{-- 選択した行のデータIDを格納 --}}
            //SetSelectedRowId(gridMaster.collectionView.currentItem['dataId']);
        });

        {{-- グリッドの「右クリック」イベント --}}
        {{-- 左側 --}}
        gridMasterLeft.addEventListener(hostLeft, 'contextmenu', function (e)
        {
            {{-- セル上での右クリックメニュー表示 ※common_function.js参照 --}}
            SetGridContextMenu(gridMasterLeft, e);
            {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
            {{-- クリックした位置を選択 --}}
            gridMasterLeft.select(new wijmo.grid.CellRange(gridMasterLeft.hitTest(e).row, 0), true);
            {{-- 選択した行番号を格納 --}}
            selectedRowsLeft = SetSelectedMultiRow(gridMasterLeft, selectedRowsLeft);
            {{-- 選択した行のデータIDを格納 --}}
            SetSelectedRowIdLeft(gridMasterLeft.collectionView.currentItem['dataId']);
        });
        {{-- グリッドの「ダブルクリック」イベント --}}
        gridMasterLeft.addEventListener(hostLeft, 'dblclick', function (e)
        {
            if(gridMasterLeft.hitTest(e).cellType == wijmo.grid.CellType.Cell)
            {
                let calData = CalendarSoushinData();
                MakeCalendarGrid(calData);
                calendar.style.display = 'block';
                shiftMaster.style.display = 'block';
            }
        });
        {{-- グリッドの「キーボード」イベント --}}
        gridMasterLeft.addEventListener(hostLeft, 'keydown', function (e)
        {
            {{-- 「←・↑・→・↓キー」はクリック時と同じ処理 --}}
            if(e.keyCode >= KEY_LEFT && e.keyCode <= KEY_DOWN)
            {
                {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
                if(gridMasterLeft.itemsSource.length < 1) return;
                {{-- 選択した行番号を格納 --}}
                selectedRowsLeft = SetSelectedMultiRow(gridMasterLeft, selectedRowsLeft);
                {{-- 選択した行のデータIDを格納 --}}
                SetSelectedRowIdLeft(gridMasterLeft.collectionView.currentItem['dataId']);
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
            // 送信先ファイル名
            url: URL,
            // 受け取りデータの種類
            datatype: "json"
        }).done(function (data) {
            // 通信成功時の処理
            //console.log(data);
            callBackFunction(data, false);
        }).fail(function (data) {
            // 通信失敗時の処理
            //console.log(data);
            callBackFunction(data, true);
        });
    }

    function CalendarSoushinData()
    {

        {{-- POST送信用オブジェクト配列 --}}
        let soushinData = {};
        soushinData.dataSentakuCd = gridMasterLeft.collectionView.currentItem['dataSentakuCd'];
        if(gridMasterLeft.collectionView.currentItem['dataJigyoubuCd'] != undefined){
            soushinData.dataJigyoubuCd2 = gridMasterLeft.collectionView.currentItem['dataJigyoubuCd'];
        }
        if(resourceKbnValue[cmbResourceKbn.selectedIndex] == 2){
            if(gridMasterLeft.collectionView.currentItem['dataBushoCd'] != undefined){
                soushinData.dataBushoCd = "";
            }
        }
        else if(resourceKbnValue[cmbResourceKbn.selectedIndex] == 3){
            if(gridMasterLeft.collectionView.currentItem['dataBushoCd'] != undefined){
                soushinData.dataBushoCd = gridMasterLeft.collectionView.currentItem['dataBushoCd'];
            }
        }

        {{-- 「リソース区分」 --}}
        document.forms['frmKensaku'].elements['dataResourceKbn'].selectedIndex = resourceKbnValue[cmbResourceKbn.selectedIndex];
        soushinData['dataResourceKbn'] = document.forms['frmKensaku'].elements['dataResourceKbn'].selectedIndex;
        soushinData['dataJigyoubuCd'] = document.forms['frmKensaku'].elements['dataJigyoubuCd'].value;
        var y = parseInt(document.forms['frmKensaku'].elements['year'].value);
        var m = parseInt(document.forms['frmKensaku'].elements['month'].value);

        soushinData['dataTaishouStartDate'] = y + '-' + parseInt(m+1) + '-01';
        soushinData['dataTaishouEndDate'] = y + '-' + parseInt(m+2) + '-01'; // y + '-' + m + '-01'

        if(soushinData['dataTaishouEndDate'] == y + '-'+'13-01'){
            soushinData['dataTaishouEndDate'] = (y + 1) + '-1-01'
        }
        //console.log(soushinData['dataTaishouEndDate'],'日付');

        {{-- 「データ更新中」表示 --}}
        ShowPopupDlg("{{ __('データ読込中') }}");
        //console.log(soushinData);
        {{-- グリッドのデータ受信 --}}
        {{-- シフト（カレンダー） --}}
        AjaxData("{{ url('/master/3100') }}",soushinData,  fncJushinGridData);
    }

    {{-- 「表示」ボタンイベント --}}
    var fncShowDataGrid = function()
    {
        {{-- POST送信用オブジェクト配列 --}}
        let soushinData = {};

        {{-- 検索フォーム要素 --}}
        let kensakuData = document.forms['frmKensaku'].elements;
        {{-- フォーム要素から送信データを格納 --}}
        for(var i = 0; i< kensakuData.length; i++){
            {{-- フォーム要素のnameが宣言されている要素のみ処理 --}}
            if(kensakuData[i].name != ''){
                {{-- フォーム要素のnameを配列のキーしてPOSTデータの値を作成する --}}
                {{-- 検索値の末尾に検索条件キーを付与してLIKE検索をできるようにする ※LIKE_VALUE_BOTHは部分一致検索 --}}
                soushinData[kensakuData[i].name] = (kensakuData[i].value != '') ? (kensakuData[i].value + LIKE_VALUE_BOTH) : '';
            }
        }

        {{-- 左側 --}}
        AjaxData("{{ url('/inquiry/CalendarJigyoubu') }}",soushinData, fncJushinGridDataLeft);
        {{-- シフトマスタ --}}
        AjaxData("{{ url('/master/3100') }}",soushinData, fncJushinGridDataShift);
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
    /*var fncNyuryokuData = function(mode, copy)
    {
        {{-- カレンダー --}}
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
        cmbResourceKbn.isDisabled = deleteFlg; {{-- 「リソース区分」 --}}

        {{-- 入力フォームのスタイル初期化 ※common_function.js参照　--}}
        InitFormStyle();
    }*/


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
        //console.log(data,"data");
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(IsAjaxDataError(data, errorFlg)) return;

        var month = parseInt($("#month").val());
        var year = parseInt($("#year").val());
        let calData = MakeCalendarData(month,year);
        let data6 = data[6][0];
        if(data6 !== undefined){
            var dataLastId = data6['dataId'];
        }
        else{
            var dataLastId = 1;
        }
        var resourceVal = resourceKbnValue[cmbResourceKbn.selectedIndex];
        var dataTaishouCd = data[7];
        var dataTaishouCdJigyoubu = data[9];
        var dataTaishouCdLength = data[9].length;
        let taishouCdArray;
        if(resourceVal == 1){
            for(var j = 0; j < dataTaishouCdLength; j++){
                taishouCdArray = dataTaishouCdJigyoubu[j];
                if(dataTaishouCd == taishouCdArray['dataBushoCd']){
                    var dataTaishouCdJ = taishouCdArray['dataJigyoubuCd'];
                    var dataTaishouCdB = '';
                    break;
                }
            }
        }
        var dataTaishouCdKikai = data[11];
        var dataTaishouCdLength = data[11].length;
        if(resourceVal == 2){
            for(var j = 0; j < dataTaishouCdLength; j++){
                taishouCdArray = dataTaishouCdKikai[j];
                if(dataTaishouCd == taishouCdArray['dataKikaiCd']){
                    var dataTaishouCdJ = taishouCdArray['dataJigyoubuCd'];
                    var dataTaishouCdB = '';
                    break;
                }
            }
        }
        var dataTaishouCdBusho = data[10];
        dataTaishouCdLength = data[9].length;
        if(resourceVal == 3){
            for(var j = 0; j < dataTaishouCdLength; j++){
                taishouCdArray = dataTaishouCdBusho[j];
                if(dataTaishouCd == taishouCdArray['dataTantoushaCd']){
                    var dataTaishouCdJ = taishouCdArray['dataJigyoubuCd'];
                    var dataTaishouCdB = taishouCdArray['dataBushoCd'];
                    break;
                }
            }
        }
        let obj = { 'dataMonEndJikokuTsujou': 0, 'dataMonEndJikokuZangyou': 0, 'dataMonKeikaJikanTsujou': 0, 'dataMonKeikaJikanZangyou': 0,
                    'dataTueEndJikokuTsujou': 0, 'dataTueEndJikokuZangyou': 0, 'dataTueKeikaJikanTsujou': 0, 'dataTueKeikaJikanZangyou': 0,
                    'dataWedEndJikokuTsujou': 0, 'dataWedEndJikokuZangyou': 0, 'dataWedKeikaJikanTsujou': 0, 'dataWedKeikaJikanZangyou': 0,
                    'dataThuEndJikokuTsujou': 0, 'dataThuEndJikokuZangyou': 0, 'dataThuKeikaJikanTsujou': 0, 'dataThuKeikaJikanZangyou': 0,
                    'dataFriEndJikokuTsujou': 0, 'dataFriEndJikokuZangyou': 0, 'dataFriKeikaJikanTsujou': 0, 'dataFriKeikaJikanZangyou': 0,
                    'dataSatEndJikokuTsujou': 0, 'dataSatEndJikokuZangyou': 0, 'dataSatKeikaJikanTsujou': 0, 'dataSatKeikaJikanZangyou': 0,
                    'dataSunEndJikokuTsujou': 0, 'dataSunEndJikokuZangyou': 0, 'dataSunKeikaJikanTsujou': 0, 'dataSunKeikaJikanZangyou': 0,
                    'dataMonIdFlg': 0, 'dataTueIdFlg': 0, 'dataWedIdFlg': 0, 'dataThuIdFlg': 0, 'dataFriIdFlg': 0, 'dataSatIdFlg': 0, 'dataSunIdFlg': 0,
                    'dataLastId': dataLastId, 'dataTaishouCd': dataTaishouCd, 'dataTaishouCdJ': dataTaishouCdJ, 'dataTaishouCdB': dataTaishouCdB};
        var calDataArray;
        var data1Data;
        var dataTaishou;
        var dataLength = data[1].length;
        var calDataLength = calData['length'];
        let data2Length = data[2].length;
        var data2Data;
        var dataShiftCd;
        var dataEndJikokuTsujou;
        var dataEndJikokuZangyou;
        var dataKeikaJikanTsujou;
        var dataKeikaJikanZangyou;
        let dataJigyoubu;
        let dataJigyoubu2;
        let dataBusho;
        let dataKikai;
        let dataTantousha;
        for(let a = 0; a < calDataLength; a++){
            calDataArray = calData[a];
            Object.assign(calDataArray,obj);
        }
        //console.log(data[7])
        let calData2 = calData;
        
        {{-- 事業部CD判定 --}}
        let gridJigyoubu = data[8]; 
        let gridJigyoubuArray;
        var gridJigyoubuLength = gridJigyoubu.length;
        var JigyoubuFlg = false;
        for(var l = 0; l < gridJigyoubuLength; l++){
            gridJigyoubuArray = gridJigyoubu[l]
            if(gridJigyoubuArray['dataSentakuCd'] == document.forms['frmKensaku'].elements['dataJigyoubuCd'].value){
                JigyoubuFlg = true;
                break;
            }
        }
        if(document.forms['frmKensaku'].elements['dataJigyoubuCd'].value == ''){
            ShowAlertDlg("{{__('事業部CDを入力してください')}}");
            {{-- 「データ更新中」非表示 --}}
            ClosePopupDlg();
            fncChangeDisable();
        }
        else if(JigyoubuFlg === false){
            ShowAlertDlg("{{__('存在する事業部CDか親事業部CDを入力してください')}}");
            {{-- 「データ更新中」非表示 --}}
            ClosePopupDlg();
            fncChangeDisable();
        }
        else{
            {{-- 日程とのシフトデータの結合 --}}
            if(data[1].length != 0){
                let data1 = data[1];
                let data2 = data[2];
                for(let c = 0; c < dataLength; c++){
                    data1Data = data1[c];
                    if(data1Data.dataShiftCd == '@'){
                        data1Data.dataShiftCd = '';
                    }
                    else if(data1Data.dataShiftCd == 'H'){
                        data1Data.dataShiftCd = '休';
                    }
                    for(let a = 0; a < calDataLength; a++){
                        calDataArray = calData[a];
                        dataTaishou = data1Data['dataTaishouDate'];
                        if(calDataArray['Monday'] == dataTaishou){
                            /*if(data1Data.dataShiftCd === '' || data1Data.dataShiftCd === undefined){
                                data1Data.dataShiftCd = '@';
                            }*/
                            data1Data.dataMonShiftCd = data1Data.dataShiftCd;
                            data1Data.dataMonId = data1Data.dataId;
                            delete data1Data.dataShiftCd;
                            delete data1Data.dataId;
                            delete data1Data.dataTaishouDate;
                            for(var s = 0; s < data2Length; s++){
                                data2Data = data2[s];
                                dataShiftCd = data2Data['dataShiftCd'];
                                dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                                dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                                dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                                dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                                if(dataShiftCd == data1Data['dataMonShiftCd']){
                                    var mObj = { 'dataMonEndJikokuTsujou': dataEndJikokuTsujou, 'dataMonEndJikokuZangyou': dataEndJikokuZangyou,
                                                    'dataMonKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataMonKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                        'dataMonIdFlg': 0};
                                    break;
                                }
                                else{
                                    var mObj = { 'dataMonEndJikokuTsujou': 0, 'dataMonEndJikokuZangyou': 0, 'dataMonKeikaJikanTsujou': 0, 'dataMonKeikaJikanZangyou': 0, 'dataMonIdFlg': 0};
                                }
                            }
                            Object.assign(calDataArray,mObj);  
                            Object.assign(calDataArray,data1Data);
                        }
                        else if(calDataArray['Tuesday'] == dataTaishou){
                            data1Data.dataTueShiftCd = data1Data.dataShiftCd;
                            data1Data.dataTueId = data1Data.dataId;
                            delete data1Data.dataShiftCd;
                            delete data1Data.dataId;
                            delete data1Data.dataTaishouDate;
                            for(var s = 0; s < data2Length; s++){
                                data2Data = data2[s];
                                dataShiftCd = data2Data['dataShiftCd'];
                                dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                                dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                                dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                                dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                                if(dataShiftCd == data1Data['dataTueShiftCd']){
                                    var tObj = { 'dataTueEndJikokuTsujou': dataEndJikokuTsujou, 'dataTueEndJikokuZangyou': dataEndJikokuZangyou,
                                                    'dataTueKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataTueKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                        'dataTueIdFlg': 0};
                                    break;
                                }
                                else{
                                    var tObj = { 'dataTueEndJikokuTsujou': 0, 'dataTueEndJikokuZangyou': 0, 'dataTueKeikaJikanTsujou': 0, 'dataTueKeikaJikanZangyou': 0, 'dataTueIdFlg': 0};
                                }
                            }
                            Object.assign(calDataArray,tObj);
                            Object.assign(calDataArray,data1Data);
                        }
                        else if(calDataArray['Wednesday'] == dataTaishou){
                            data1Data.dataWedShiftCd = data1Data.dataShiftCd;
                            data1Data.dataWedId = data1Data.dataId;
                            delete data1Data.dataShiftCd;
                            delete data1Data.dataId;
                            delete data1Data.dataTaishouDate;
                            for(var s = 0; s < data2Length; s++){
                                data2Data = data2[s];
                                dataShiftCd = data2Data['dataShiftCd'];
                                dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                                dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                                dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                                dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                                if(dataShiftCd == data1Data['dataWedShiftCd']){
                                    var wObj = { 'dataWedEndJikokuTsujou': dataEndJikokuTsujou, 'dataWedEndJikokuZangyou': dataEndJikokuZangyou,
                                                    'dataWedKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataWedKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                        'dataWedIdFlg': 0};
                                    break;
                                }
                                else{
                                    var wObj = { 'dataWedEndJikokuTsujou': 0, 'dataWedEndJikokuZangyou': 0, 'dataWedKeikaJikanTsujou': 0, 'dataWedKeikaJikanZangyou': 0, 'dataWedIdFlg': 0};
                                }
                            }
                            Object.assign(calDataArray,wObj);
                            Object.assign(calDataArray,data1Data);
                        }
                        else if(calDataArray['Thursday'] == dataTaishou){
                            data1Data.dataThuShiftCd = data1Data.dataShiftCd;
                            data1Data.dataThuId = data1Data.dataId;
                            delete data1Data.dataShiftCd;
                            delete data1Data.dataId;
                            delete data1Data.dataTaishouDate;
                            for(var s = 0; s < data2Length; s++){
                                data2Data = data2[s];
                                dataShiftCd = data2Data['dataShiftCd'];
                                dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                                dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                                dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                                dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                                if(dataShiftCd == data1Data['dataThuShiftCd']){
                                    var thObj = { 'dataThuEndJikokuTsujou': dataEndJikokuTsujou, 'dataThuEndJikokuZangyou': dataEndJikokuZangyou,
                                                    'dataThuKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataThuKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                        'dataThuIdFlg': 0};
                                    break;
                                }
                                else{
                                    var thObj = { 'dataThuEndJikokuTsujou': 0, 'dataThuEndJikokuZangyou': 0, 'dataThuKeikaJikanTsujou': 0, 'dataThuKeikaJikanZangyou': 0, 'dataThuIdFlg': 0};
                                }
                            }
                            Object.assign(calDataArray,thObj);
                            Object.assign(calDataArray,data1Data);
                        }
                        else if(calDataArray['Friday'] == dataTaishou){
                            data1Data.dataFriShiftCd = data1Data.dataShiftCd;
                            data1Data.dataFriId = data1Data.dataId;
                            delete data1Data.dataShiftCd;
                            delete data1Data.dataId;
                            delete data1Data.dataTaishouDate;
                            for(var s = 0; s < data2Length; s++){
                                data2Data = data2[s];
                                dataShiftCd = data2Data['dataShiftCd'];
                                dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                                dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                                dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                                dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                                if(dataShiftCd == data1Data['dataFriShiftCd']){
                                    var fObj = { 'dataFriEndJikokuTsujou': dataEndJikokuTsujou, 'dataFriEndJikokuZangyou': dataEndJikokuZangyou,
                                                    'dataFriKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataFriKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                        'dataFriIdFlg': 0};
                                    break;
                                }
                                else{
                                    var fObj = { 'dataFriEndJikokuTsujou': 0, 'dataFriEndJikokuZangyou': 0, 'dataFriKeikaJikanTsujou': 0, 'dataFriKeikaJikanZangyou': 0, 'dataFriIdFlg': 0};
                                }
                            }
                            Object.assign(calDataArray,fObj);
                            Object.assign(calDataArray,data1Data);
                        }
                        else if(calDataArray['Saturday'] == dataTaishou){
                            data1Data.dataSatShiftCd = data1Data.dataShiftCd;
                            data1Data.dataSatId = data1Data.dataId;
                            delete data1Data.dataShiftCd;
                            delete data1Data.dataId;
                            delete data1Data.dataTaishouDate;
                            for(var s = 0; s < data2Length; s++){
                                data2Data = data2[s];
                                dataShiftCd = data2Data['dataShiftCd'];
                                dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                                dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                                dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                                dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                                if(dataShiftCd == data1Data['dataSatShiftCd']){
                                    var sObj = { 'dataSatEndJikokuTsujou': dataEndJikokuTsujou, 'dataSatEndJikokuZangyou': dataEndJikokuZangyou,
                                                    'dataSatKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataSatKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                        'dataSatIdFlg': 0};
                                    break;
                                }
                                else{
                                    var sObj = { 'dataSatEndJikokuTsujou': 0, 'dataSatEndJikokuZangyou': 0, 'dataSatKeikaJikanTsujou': 0, 'dataSatKeikaJikanZangyou': 0, 'dataSatIdFlg': 0};
                                }
                            }
                            Object.assign(calDataArray,sObj);
                            Object.assign(calDataArray,data1Data);
                        }
                        else if(calDataArray['Sunday'] == dataTaishou){
                            data1Data.dataSunShiftCd = data1Data.dataShiftCd;
                            data1Data.dataSunId = data1Data.dataId;
                            delete data1Data.dataShiftCd;
                            delete data1Data.dataId;
                            delete data1Data.dataTaishouDate;
                            for(var s = 0; s < data2Length; s++){
                                data2Data = data2[s];
                                dataShiftCd = data2Data['dataShiftCd'];
                                dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                                dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                                dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                                dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                                if(dataShiftCd == data1Data['dataSunShiftCd']){
                                    var suObj = { 'dataSunEndJikokuTsujou': dataEndJikokuTsujou, 'dataSunEndJikokuZangyou': dataEndJikokuZangyou,
                                                    'dataSunKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataSunKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                        'dataSunIdFlg': 0};
                                    break;
                                }
                                else{
                                    var suObj = { 'dataSunEndJikokuTsujou': 0, 'dataSunEndJikokuZangyou': 0, 'dataSunKeikaJikanTsujou': 0, 'dataSunKeikaJikanZangyou': 0, 'dataSunIdFlg': 0}; 
                                }
                            }
                            Object.assign(calDataArray,suObj);
                            Object.assign(calDataArray,data1Data);
                        }
                    }
                }
                calendarGrid.itemsSource = calData;
                dataBusho = calData;
                dataTantousha = calData;
                dataKikai = calData;
                //console.log(calData)
            }
            else{
                calendarGrid.itemsSource = calData2;
                dataBusho = calData2;
                dataTantousha = calData2;
                dataKikai = calData2;
            }

            //部署用カレンダー
            calData = MakeCalendarData(month,year);
            dataLength = data[3].length;
            calDataLength = calData['length'];
            data1 = data[3];
            data2 = data[2];
            for(let a = 0; a < calDataLength; a++){
                calDataArray = calData[a];
                Object.assign(calDataArray,obj);
            }
            //console.log(data[3],'data[3]')
            for(let c = 0; c < dataLength; c++){
                for(let a = 0; a < calDataLength; a++){
                    data1Data = data1[c];
                    calDataArray = calData[a];
                    if(data1Data.dataShiftCd == '@'){
                        data1Data.dataShiftCd = '';
                    }
                    else if(data1Data.dataShiftCd == 'H'){
                        data1Data.dataShiftCd = '休';
                    }
                    //console.log(data1Data,'data1Data')
                    dataTaishou = data1Data['dataTaishouDate'];
                    if(calDataArray['Monday'] == dataTaishou){
                        /*if(data1Data.dataShiftCd === '' || data1Data.dataShiftCd === undefined){
                            data1Data.dataShiftCd = '@';
                        }*/
                        data1Data.dataMonShiftCd = data1Data.dataShiftCd;
                        data1Data.dataMonId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataMonShiftCd']){
                                var mObj = { 'dataMonEndJikokuTsujou': dataEndJikokuTsujou, 'dataMonEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataMonKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataMonKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataMonIdFlg': 1};
                                break;
                            }
                            else{
                                var mObj = { 'dataMonEndJikokuTsujou': 0, 'dataMonEndJikokuZangyou': 0, 'dataMonKeikaJikanTsujou': 0, 'dataMonKeikaJikanZangyou': 0, 'dataMonIdFlg': 1};
                            }
                        }
                        Object.assign(calDataArray,mObj);  
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Tuesday'] == dataTaishou){
                        data1Data.dataTueShiftCd = data1Data.dataShiftCd;
                        data1Data.dataTueId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataTueShiftCd']){
                                var tObj = { 'dataTueEndJikokuTsujou': dataEndJikokuTsujou, 'dataTueEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataTueKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataTueKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataTueIdFlg': 1};
                                break;
                            }
                            else{
                                var tObj = { 'dataTueEndJikokuTsujou': 0, 'dataTueEndJikokuZangyou': 0, 'dataTueKeikaJikanTsujou': 0, 'dataTueKeikaJikanZangyou': 0, 'dataTueIdFlg': 1};
                            }
                        }
                        Object.assign(calDataArray,tObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Wednesday'] == dataTaishou){
                        data1Data.dataWedShiftCd = data1Data.dataShiftCd;
                        data1Data.dataWedId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataWedShiftCd']){
                                var tObj = { 'dataWedEndJikokuTsujou': dataEndJikokuTsujou, 'dataWedEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataWedKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataWedKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataWedIdFlg': 1};
                                break;
                            }
                            else{
                                var tObj = { 'dataWedEndJikokuTsujou': 0, 'dataWedEndJikokuZangyou': 0, 'dataWedKeikaJikanTsujou': 0, 'dataWedKeikaJikanZangyou': 0, 'dataWedIdFlg': 1};
                            }
                        }
                        Object.assign(calDataArray,tObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Thursday'] == dataTaishou){
                        data1Data.dataThuShiftCd = data1Data.dataShiftCd;
                        data1Data.dataThuId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataThuShiftCd']){
                                var thObj = { 'dataThuEndJikokuTsujou': dataEndJikokuTsujou, 'dataThuEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataThuKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataThuKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataThuIdFlg': 1};
                                break;
                            }
                            else{
                                var thObj = { 'dataThuEndJikokuTsujou': 0, 'dataThuEndJikokuZangyou': 0, 'dataThuKeikaJikanTsujou': 0, 'dataThuKeikaJikanZangyou': 0, 'dataThuIdFlg': 1};
                            }
                        }
                        Object.assign(calDataArray,thObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Friday'] == dataTaishou){
                        data1Data.dataFriShiftCd = data1Data.dataShiftCd;
                        data1Data.dataFriId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataFriShiftCd']){
                                var fObj = { 'dataFriEndJikokuTsujou': dataEndJikokuTsujou, 'dataFriEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataFriKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataFriKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataFriIdFlg': 1};
                                break;
                            }
                            else{
                                var fObj = { 'dataFriEndJikokuTsujou': 0, 'dataFriEndJikokuZangyou': 0, 'dataFriKeikaJikanTsujou': 0, 'dataFriKeikaJikanZangyou': 0, 'dataFriIdFlg': 1};
                            }
                            //console.log(dataShiftCd)
                            //console.log(data1Data['dataFriShiftCd'])
                        }
                        Object.assign(calDataArray,fObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Saturday'] == dataTaishou){
                        data1Data.dataSatShiftCd = data1Data.dataShiftCd;
                        data1Data.dataSatId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataSatShiftCd']){
                                var sObj = { 'dataSatEndJikokuTsujou': dataEndJikokuTsujou, 'dataSatEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataSatKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataSatKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataSatIdFlg': 1};
                                break;
                            }
                            else{
                                var sObj = { 'dataSatEndJikokuTsujou': 0, 'dataSatEndJikokuZangyou': 0, 'dataSatKeikaJikanTsujou': 0, 'dataSatKeikaJikanZangyou': 0, 'dataSatIdFlg': 1};
                            }
                        }
                        Object.assign(calDataArray,sObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Sunday'] == dataTaishou){
                        data1Data.dataSunShiftCd = data1Data.dataShiftCd;
                        data1Data.dataSunId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataSunShiftCd']){
                                var suObj = { 'dataSunEndJikokuTsujou': dataEndJikokuTsujou, 'dataSunEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataSunKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataSunKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataSunIdFlg': 1};
                                break;
                            }
                            else{
                                var suObj = { 'dataSunEndJikokuTsujou': 0, 'dataSunEndJikokuZangyou': 0, 'dataSunKeikaJikanTsujou': 0, 'dataSunKeikaJikanZangyou': 0, 'dataSunIdFlg': 1}; 
                            }
                        }
                        Object.assign(calDataArray,suObj);
                        Object.assign(calDataArray,data1Data);
                    }
                }
            }
            
            let dataBushoArray;
            let dataJigyoubuArray;
            for(var b = 0; b < calDataLength; b++){
                dataJigyoubuArray = dataBusho[b];
                dataBushoArray = calData[b];
                /*console.log(dataJigyoubuArray);
                console.log(dataBushoArray);
                console.log(dataBushoArray['dataFriShiftCd']);*/
                if(dataJigyoubuArray['dataMonId'] != dataBushoArray['dataMonId'] && dataBushoArray['dataMonId'] !== undefined){
                    dataJigyoubuArray.dataMonShiftCd = dataBushoArray['dataMonShiftCd'];
                    dataJigyoubuArray.dataMonId = dataBushoArray['dataMonId'];
                    dataJigyoubuArray.dataMonIdFlg = dataBushoArray['dataMonIdFlg'];
                    dataJigyoubuArray.dataMonEndJikokuTsujou = dataBushoArray['dataMonEndJikokuTsujou'];
                    dataJigyoubuArray.dataMonEndJikokuZangyou = dataBushoArray['dataMonEndJikokuZangyou'];
                    dataJigyoubuArray.dataMonKeikaJikanTsujou = dataBushoArray['dataMonKeikaJikanTsujou'];
                    dataJigyoubuArray.dataMonKeikaJikanZangyou = dataBushoArray['dataMonKeikaJikanZangyou'];
                }
                if(dataJigyoubuArray['dataTueId'] != dataBushoArray['dataTueId'] && dataBushoArray['dataTueId'] !== undefined){
                    dataJigyoubuArray.dataTueShiftCd = dataBushoArray['dataTueShiftCd'];
                    dataJigyoubuArray.dataTueId = dataBushoArray['dataTueId'];
                    dataJigyoubuArray.dataTueIdFlg = dataBushoArray['dataTueIdFlg'];
                    dataJigyoubuArray.dataTueEndJikokuTsujou = dataBushoArray['dataTueEndJikokuTsujou'];
                    dataJigyoubuArray.dataTueEndJikokuZangyou = dataBushoArray['dataTueEndJikokuZangyou'];
                    dataJigyoubuArray.dataTueKeikaJikanTsujou = dataBushoArray['dataTueKeikaJikanTsujou'];
                    dataJigyoubuArray.dataTueKeikaJikanZangyou = dataBushoArray['dataTueKeikaJikanZangyou'];
                }
                if(dataJigyoubuArray['dataWedId'] != dataBushoArray['dataWedId'] && dataBushoArray['dataWedId'] !== undefined){
                    dataJigyoubuArray.dataWedShiftCd = dataBushoArray['dataWedShiftCd'];
                    dataJigyoubuArray.dataWedId = dataBushoArray['dataWedId'];
                    dataJigyoubuArray.dataWedIdFlg = dataBushoArray['dataWedIdFlg'];
                    dataJigyoubuArray.dataWedEndJikokuTsujou = dataBushoArray['dataWedEndJikokuTsujou'];
                    dataJigyoubuArray.dataWedEndJikokuZangyou = dataBushoArray['dataWedEndJikokuZangyou'];
                    dataJigyoubuArray.dataWedKeikaJikanTsujou = dataBushoArray['dataWedKeikaJikanTsujou'];
                    dataJigyoubuArray.dataWedKeikaJikanZangyou = dataBushoArray['dataWedKeikaJikanZangyou'];
                }
                if(dataJigyoubuArray['dataThuId'] != dataBushoArray['dataThuId'] && dataBushoArray['dataThuId'] !== undefined){
                    dataJigyoubuArray.dataThuShiftCd = dataBushoArray['dataThuShiftCd'];
                    dataJigyoubuArray.dataThuId = dataBushoArray['dataThuId'];
                    dataJigyoubuArray.dataThuIdFlg = dataBushoArray['dataThuIdFlg'];
                    dataJigyoubuArray.dataThuEndJikokuTsujou = dataBushoArray['dataThuEndJikokuTsujou'];
                    dataJigyoubuArray.dataThuEndJikokuZangyou = dataBushoArray['dataThuEndJikokuZangyou'];
                    dataJigyoubuArray.dataThuKeikaJikanTsujou = dataBushoArray['dataThuKeikaJikanTsujou'];
                    dataJigyoubuArray.dataThuKeikaJikanZangyou = dataBushoArray['dataThuKeikaJikanZangyou'];
                }
                if(dataJigyoubuArray['dataFriId'] != dataBushoArray['dataFriId'] && dataBushoArray['dataFriId'] !== undefined){
                    dataJigyoubuArray.dataFriShiftCd = dataBushoArray['dataFriShiftCd'];
                    dataJigyoubuArray.dataFriId = dataBushoArray['dataFriId'];
                    dataJigyoubuArray.dataFriIdFlg = dataBushoArray['dataFriIdFlg'];
                    dataJigyoubuArray.dataFriEndJikokuTsujou = dataBushoArray['dataFriEndJikokuTsujou'];
                    dataJigyoubuArray.dataFriEndJikokuZangyou = dataBushoArray['dataFriEndJikokuZangyou'];
                    dataJigyoubuArray.dataFriKeikaJikanTsujou = dataBushoArray['dataFriKeikaJikanTsujou'];
                    dataJigyoubuArray.dataFriKeikaJikanZangyou = dataBushoArray['dataFriKeikaJikanZangyou'];
                }
                if(dataJigyoubuArray['dataSatId'] != dataBushoArray['dataSatId'] && dataBushoArray['dataSatId'] !== undefined){
                    dataJigyoubuArray.dataSatShiftCd = dataBushoArray['dataSatShiftCd'];
                    dataJigyoubuArray.dataSatId = dataBushoArray['dataSatId'];
                    dataJigyoubuArray.dataSatIdFlg = dataBushoArray['dataSatIdFlg'];
                    dataJigyoubuArray.dataSatEndJikokuTsujou = dataBushoArray['dataSatEndJikokuTsujou'];
                    dataJigyoubuArray.dataSatEndJikokuZangyou = dataBushoArray['dataSatEndJikokuZangyou'];
                    dataJigyoubuArray.dataSatKeikaJikanTsujou = dataBushoArray['dataSatKeikaJikanTsujou'];
                    dataJigyoubuArray.dataSatKeikaJikanZangyou = dataBushoArray['dataSatKeikaJikanZangyou'];
                }
                if(dataJigyoubuArray['dataSunId'] != dataBushoArray['dataSunId'] && dataBushoArray['dataSunId'] !== undefined){
                    dataJigyoubuArray.dataSunShiftCd = dataBushoArray['dataSunShiftCd'];
                    dataJigyoubuArray.dataSunId = dataBushoArray['dataSunId'];
                    dataJigyoubuArray.dataSunIdFlg = dataBushoArray['dataSunIdFlg'];
                    dataJigyoubuArray.dataSunEndJikokuTsujou = dataBushoArray['dataSunEndJikokuTsujou'];
                    dataJigyoubuArray.dataSunEndJikokuZangyou = dataBushoArray['dataSunEndJikokuZangyou'];
                    dataJigyoubuArray.dataSunKeikaJikanTsujou = dataBushoArray['dataSunKeikaJikanTsujou'];
                    dataJigyoubuArray.dataSunKeikaJikanZangyou = dataBushoArray['dataSunKeikaJikanZangyou'];
                }
            }

            if(resourceVal == 1){
                if(calData2 != calendarGrid.itemsSource){
                    calendarGrid.itemsSource = dataBusho;
                    dataTantousha = dataBusho;
                }
            }
            

            //担当者用カレンダー
            calData = MakeCalendarData(month,year);
            dataLength = data[4].length;
            calDataLength = calData['length'];
            data1 = data[4];
            data2 = data[2];
            for(let a = 0; a < calDataLength; a++){
                calDataArray = calData[a];
                Object.assign(calDataArray,obj);
            }
            for(let c = 0; c < dataLength; c++){
                for(let a = 0; a < calDataLength; a++){
                    data1Data = data1[c];
                    calDataArray = calData[a];
                    dataTaishou = data1Data['dataTaishouDate'];
                    if(data1Data.dataShiftCd == '@'){
                        data1Data.dataShiftCd = '';
                    }
                    else if(data1Data.dataShiftCd == 'H'){
                        data1Data.dataShiftCd = '休';
                    }
                    if(calDataArray['Monday'] == dataTaishou){
                        /*if(data1Data.dataShiftCd === '' || data1Data.dataShiftCd === undefined){
                            data1Data.dataShiftCd = '@';
                        }*/
                        data1Data.dataMonShiftCd = data1Data.dataShiftCd;
                        data1Data.dataMonId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataMonShiftCd']){
                                var mObj = { 'dataMonEndJikokuTsujou': dataEndJikokuTsujou, 'dataMonEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataMonKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataMonKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataMonIdFlg': 3};
                                break;
                            }
                            else{
                                var mObj = { 'dataMonEndJikokuTsujou': 0, 'dataMonEndJikokuZangyou': 0, 'dataMonKeikaJikanTsujou': 0, 'dataMonKeikaJikanZangyou': 0, 'dataMonIdFlg': 3};
                            }
                        }
                        Object.assign(calDataArray,mObj);  
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Tuesday'] == dataTaishou){
                        data1Data.dataTueShiftCd = data1Data.dataShiftCd;
                        data1Data.dataTueId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataTueShiftCd']){
                                var tObj = { 'dataTueEndJikokuTsujou': dataEndJikokuTsujou, 'dataTueEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataTueKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataTueKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataTueIdFlg': 3};
                                break;
                            }
                            else{
                                var tObj = { 'dataTueEndJikokuTsujou': 0, 'dataTueEndJikokuZangyou': 0, 'dataTueKeikaJikanTsujou': 0, 'dataTueKeikaJikanZangyou': 0, 'dataTueIdFlg': 3};
                            }
                        }
                        Object.assign(calDataArray,tObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Wednesday'] == dataTaishou){
                        data1Data.dataWedShiftCd = data1Data.dataShiftCd;
                        data1Data.dataWedId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataWedShiftCd']){
                                var wObj = { 'dataWedEndJikokuTsujou': dataEndJikokuTsujou, 'dataWedEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataWedKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataWedKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataWedIdFlg': 3};
                                break;
                            }
                            else{
                                var wObj = { 'dataWedEndJikokuTsujou': 0, 'dataWedEndJikokuZangyou': 0, 'dataWedKeikaJikanTsujou': 0, 'dataWedKeikaJikanZangyou': 0, 'dataWedIdFlg': 3};
                            }
                        }
                        Object.assign(calDataArray,wObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Thursday'] == dataTaishou){
                        data1Data.dataThuShiftCd = data1Data.dataShiftCd;
                        data1Data.dataThuId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataThuShiftCd']){
                                var thObj = { 'dataThuEndJikokuTsujou': dataEndJikokuTsujou, 'dataThuEndJikokuZangyou': dataEndJikokuZangyou, 
                                                'dataThuKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataThuKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataThuIdFlg': 3};
                                break;
                            }
                            else{
                                var thObj = { 'dataThuEndJikokuTsujou': 0, 'dataThuEndJikokuZangyou': 0, 'dataThuKeikaJikanTsujou': 0, 'dataThuKeikaJikanZangyou': 0, 'dataThuIdFlg': 3};
                            }
                        }
                        Object.assign(calDataArray,thObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Friday'] == dataTaishou){
                        data1Data.dataFriShiftCd = data1Data.dataShiftCd;
                        data1Data.dataFriId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataFriShiftCd']){
                                var fObj = { 'dataFriEndJikokuTsujou': dataEndJikokuTsujou, 'dataFriEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataFriKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataFriKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataFriIdFlg': 3};
                                break;
                            }
                            else{
                                var fObj = { 'dataFriEndJikokuTsujou': 0, 'dataFriEndJikokuZangyou': 0, 'dataFriKeikaJikanTsujou': 0, 'dataFriKeikaJikanZangyou': 0, 'dataFriIdFlg': 3};
                            }
                        }
                        Object.assign(calDataArray,fObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Saturday'] == dataTaishou){
                        data1Data.dataSatShiftCd = data1Data.dataShiftCd;
                        data1Data.dataSatId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataSatShiftCd']){
                                var sObj = { 'dataSatEndJikokuTsujou': dataEndJikokuTsujou, 'dataSatEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataSatKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataSatKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataSatIdFlg': 3};
                                break;
                            }
                            else{
                                var sObj = { 'dataSatEndJikokuTsujou': 0, 'dataSatEndJikokuZangyou': 0, 'dataSatKeikaJikanTsujou': 0, 'dataSatKeikaJikanZangyou': 0, 'dataSatIdFlg': 3};
                            }
                        }
                        Object.assign(calDataArray,sObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Sunday'] == dataTaishou){
                        data1Data.dataSunShiftCd = data1Data.dataShiftCd;
                        data1Data.dataSunId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataSunShiftCd']){
                                var suObj = { 'dataSunEndJikokuTsujou': dataEndJikokuTsujou, 'dataSunEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataSunKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataSunKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataSunIdFlg': 3};
                                break;
                            }
                            else{
                                var suObj = { 'dataSunEndJikokuTsujou': 0, 'dataSunEndJikokuZangyou': 0, 'dataSunKeikaJikanTsujou': 0, 'dataSunKeikaJikanZangyou': 0, 'dataSunIdFlg': 3}; 
                            }
                        }
                        Object.assign(calDataArray,suObj);
                        Object.assign(calDataArray,data1Data);
                    }
                }
            }

            let dataTantoushaArray;
            for(var b = 0; b < calDataLength; b++){
                dataBushoArray = dataTantousha[b];
                dataTantoushaArray = calData[b];
                if(dataBushoArray['dataMonId'] != dataTantoushaArray['dataMonId'] && dataTantoushaArray['dataMonId'] !== undefined){
                    dataBushoArray.dataMonShiftCd = dataTantoushaArray['dataMonShiftCd'];
                    dataBushoArray.dataMonId = dataTantoushaArray['dataMonId'];
                    dataBushoArray.dataMonIdFlg = dataTantoushaArray['dataMonIdFlg'];
                    dataBushoArray.dataMonEndJikokuTsujou = dataTantoushaArray['dataMonEndJikokuTsujou'];
                    dataBushoArray.dataMonEndJikokuZangyou = dataTantoushaArray['dataMonEndJikokuZangyou'];
                    dataBushoArray.dataMonKeikaJikanTsujou = dataTantoushaArray['dataMonKeikaJikanTsujou'];
                    dataBushoArray.dataMonKeikaJikanZangyou = dataTantoushaArray['dataMonKeikaJikanZangyou'];
                }
                if(dataBushoArray['dataTueId'] != dataTantoushaArray['dataTueId'] && dataTantoushaArray['dataTueId'] !== undefined){
                    dataBushoArray.dataTueShiftCd = dataTantoushaArray['dataTueShiftCd'];
                    dataBushoArray.dataTueId = dataTantoushaArray['dataTueId'];
                    dataBushoArray.dataTueIdFlg = dataTantoushaArray['dataTueIdFlg'];
                    dataBushoArray.dataTueEndJikokuTsujou = dataTantoushaArray['dataTueEndJikokuTsujou'];
                    dataBushoArray.dataTueEndJikokuZangyou = dataTantoushaArray['dataTueEndJikokuZangyou'];
                    dataBushoArray.dataTueKeikaJikanTsujou = dataTantoushaArray['dataTueKeikaJikanTsujou'];
                    dataBushoArray.dataTueKeikaJikanZangyou = dataTantoushaArray['dataTueKeikaJikanZangyou'];
                }
                if(dataBushoArray['dataWedId'] != dataTantoushaArray['dataWedId'] && dataTantoushaArray['dataWedId'] !== undefined){
                    dataBushoArray.dataWedShiftCd = dataTantoushaArray['dataWedShiftCd'];
                    dataBushoArray.dataWedId = dataTantoushaArray['dataWedId'];
                    dataBushoArray.dataWedIdFlg = dataTantoushaArray['dataWedIdFlg'];
                    dataBushoArray.dataWedEndJikokuTsujou = dataTantoushaArray['dataWedEndJikokuTsujou'];
                    dataBushoArray.dataWedEndJikokuZangyou = dataTantoushaArray['dataWedEndJikokuZangyou'];
                    dataBushoArray.dataWedKeikaJikanTsujou = dataTantoushaArray['dataWedKeikaJikanTsujou'];
                    dataBushoArray.dataWedKeikaJikanZangyou = dataTantoushaArray['dataWedKeikaJikanZangyou'];
                }
                if(dataBushoArray['dataThuId'] != dataTantoushaArray['dataThuId'] && dataTantoushaArray['dataThuId'] !== undefined){
                    dataBushoArray.dataThuShiftCd = dataTantoushaArray['dataThuShiftCd'];
                    dataBushoArray.dataThuId = dataTantoushaArray['dataThuId'];
                    dataBushoArray.dataThuIdFlg = dataTantoushaArray['dataThuIdFlg'];
                    dataBushoArray.dataThuEndJikokuTsujou = dataTantoushaArray['dataThuEndJikokuTsujou'];
                    dataBushoArray.dataThuEndJikokuZangyou = dataTantoushaArray['dataThuEndJikokuZangyou'];
                    dataBushoArray.dataThuKeikaJikanTsujou = dataTantoushaArray['dataThuKeikaJikanTsujou'];
                    dataBushoArray.dataThuKeikaJikanZangyou = dataTantoushaArray['dataThuKeikaJikanZangyou'];
                }
                if(dataBushoArray['dataFriId'] != dataTantoushaArray['dataFriId'] && dataTantoushaArray['dataFriId'] !== undefined){
                    dataBushoArray.dataFriShiftCd = dataTantoushaArray['dataFriShiftCd'];
                    dataBushoArray.dataFriId = dataTantoushaArray['dataFriId'];
                    dataBushoArray.dataFriIdFlg = dataTantoushaArray['dataFriIdFlg'];
                    dataBushoArray.dataFriEndJikokuTsujou = dataTantoushaArray['dataFriEndJikokuTsujou'];
                    dataBushoArray.dataFriEndJikokuZangyou = dataTantoushaArray['dataFriEndJikokuZangyou'];
                    dataBushoArray.dataFriKeikaJikanTsujou = dataTantoushaArray['dataFriKeikaJikanTsujou'];
                    dataBushoArray.dataFriKeikaJikanZangyou = dataTantoushaArray['dataFriKeikaJikanZangyou'];
                }
                if(dataBushoArray['dataSatId'] != dataTantoushaArray['dataSatId'] && dataTantoushaArray['dataSatId'] !== undefined){
                    dataBushoArray.dataSatShiftCd = dataTantoushaArray['dataSatShiftCd'];
                    dataBushoArray.dataSatId = dataTantoushaArray['dataSatId'];
                    dataBushoArray.dataSatIdFlg = dataTantoushaArray['dataSatIdFlg'];
                    dataBushoArray.dataSatEndJikokuTsujou = dataTantoushaArray['dataSatEndJikokuTsujou'];
                    dataBushoArray.dataSatEndJikokuZangyou = dataTantoushaArray['dataSatEndJikokuZangyou'];
                    dataBushoArray.dataSatKeikaJikanTsujou = dataTantoushaArray['dataSatKeikaJikanTsujou'];
                    dataBushoArray.dataSatKeikaJikanZangyou = dataTantoushaArray['dataSatKeikaJikanZangyou'];
                }
                if(dataBushoArray['dataSunId'] != dataTantoushaArray['dataSunId'] && dataTantoushaArray['dataSunId'] !== undefined){
                    dataBushoArray.dataSunShiftCd = dataTantoushaArray['dataSunShiftCd'];
                    dataBushoArray.dataSunId = dataTantoushaArray['dataSunId'];
                    dataBushoArray.dataSunIdFlg = dataTantoushaArray['dataSunIdFlg'];
                    dataBushoArray.dataSunEndJikokuTsujou = dataTantoushaArray['dataSunEndJikokuTsujou'];
                    dataBushoArray.dataSunEndJikokuZangyou = dataTantoushaArray['dataSunEndJikokuZangyou'];
                    dataBushoArray.dataSunKeikaJikanTsujou = dataTantoushaArray['dataSunKeikaJikanTsujou'];
                    dataBushoArray.dataSunKeikaJikanZangyou = dataTantoushaArray['dataSunKeikaJikanZangyou'];
                }
            }
            if(resourceVal == 3){
                if(calData2 != calendarGrid.itemsSource){
                    calendarGrid.itemsSource = dataTantousha;
                }
            }

            //機械用カレンダー
            calData = MakeCalendarData(month,year);
            dataLength = data[5].length;
            calDataLength = calData['length'];
            data1 = data[5];
            data2 = data[2];
            for(let a = 0; a < calDataLength; a++){
                calDataArray = calData[a];
                Object.assign(calDataArray,obj);
            }
            for(let c = 0; c < dataLength; c++){
                for(let a = 0; a < calDataLength; a++){
                    data1Data = data1[c];
                    calDataArray = calData[a];
                    dataTaishou = data1Data['dataTaishouDate'];
                    if(data1Data.dataShiftCd == '@'){
                        data1Data.dataShiftCd = '';
                    }
                    else if(data1Data.dataShiftCd == 'H'){
                        data1Data.dataShiftCd = '休';
                    }
                    if(calDataArray['Monday'] == dataTaishou){
                        /*if(data1Data.dataShiftCd === '' || data1Data.dataShiftCd === undefined){
                            data1Data.dataShiftCd = '@';
                        }*/
                        data1Data.dataMonShiftCd = data1Data.dataShiftCd;
                        data1Data.dataMonId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataMonShiftCd']){
                                var mObj = { 'dataMonEndJikokuTsujou': dataEndJikokuTsujou, 'dataMonEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataMonKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataMonKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataMonIdFlg': 2};
                                break;
                            }
                            else{
                                var mObj = { 'dataMonEndJikokuTsujou': 0, 'dataMonEndJikokuZangyou': 0, 'dataMonKeikaJikanTsujou': 0, 'dataMonKeikaJikanZangyou': 0, 'dataMonIdFlg': 2};
                            }
                        }
                        Object.assign(calDataArray,mObj);  
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Tuesday'] == dataTaishou){
                        data1Data.dataTueShiftCd = data1Data.dataShiftCd;
                        data1Data.dataTueId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataTueShiftCd']){
                                var tObj = { 'dataTueEndJikokuTsujou': dataEndJikokuTsujou, 'dataTueEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataTueKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataTueKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataTueIdFlg': 2};
                                break;
                            }
                            else{
                                var tObj = { 'dataTueEndJikokuTsujou': 0, 'dataTueEndJikokuZangyou': 0, 'dataTueKeikaJikanTsujou': 0, 'dataTueKeikaJikanZangyou': 0, 'dataTueIdFlg': 2};
                            }
                        }
                        Object.assign(calDataArray,tObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Wednesday'] == dataTaishou){
                        data1Data.dataWedShiftCd = data1Data.dataShiftCd;
                        data1Data.dataWedId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataWedShiftCd']){
                                var wObj = { 'dataWedEndJikokuTsujou': dataEndJikokuTsujou, 'dataWedEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataWedKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataWedKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataWedIdFlg': 2};
                                break;
                            }
                            else{
                                var wObj = { 'dataWedEndJikokuTsujou': 0, 'dataWedEndJikokuZangyou': 0, 'dataWedKeikaJikanTsujou': 0, 'dataWedKeikaJikanZangyou': 0, 'dataWedIdFlg': 2};
                            }
                        }
                        Object.assign(calDataArray,wObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Thursday'] == dataTaishou){
                        data1Data.dataThuShiftCd = data1Data.dataShiftCd;
                        data1Data.dataThuId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataThuShiftCd']){
                                var thObj = { 'dataThuEndJikokuTsujou': dataEndJikokuTsujou, 'dataThuEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataThuKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataThuKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataThuIdFlg': 2};
                                break;
                            }
                            else{
                                var thObj = { 'dataThuEndJikokuTsujou': 0, 'dataThuEndJikokuZangyou': 0, 'dataThuKeikaJikanTsujou': 0, 'dataThuKeikaJikanZangyou': 0, 'dataThuIdFlg': 2};
                            }
                        }
                        Object.assign(calDataArray,thObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Friday'] == dataTaishou){
                        data1Data.dataFriShiftCd = data1Data.dataShiftCd;
                        data1Data.dataFriId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataFriShiftCd']){
                                var fObj = { 'dataFriEndJikokuTsujou': dataEndJikokuTsujou, 'dataFriEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataFriKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataFriKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataFriIdFlg': 2};
                                break;
                            }
                            else{
                                var fObj = { 'dataFriEndJikokuTsujou': 0, 'dataFriEndJikokuZangyou': 0, 'dataFriKeikaJikanTsujou': 0, 'dataFriKeikaJikanZangyou': 0, 'dataFriIdFlg': 2};
                            }
                        }
                        Object.assign(calDataArray,fObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Saturday'] == dataTaishou){
                        data1Data.dataSatShiftCd = data1Data.dataShiftCd;
                        data1Data.dataSatId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataSatShiftCd']){
                                var sObj = { 'dataSatEndJikokuTsujou': dataEndJikokuTsujou, 'dataSatEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataSatKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataSatKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataSatIdFlg': 2};
                                break;
                            }
                            else{
                                var sObj = { 'dataSatEndJikokuTsujou': 0, 'dataSatEndJikokuZangyou': 0, 'dataSatKeikaJikanTsujou': 0, 'dataSatKeikaJikanZangyou': 0, 'dataSatIdFlg': 2};
                            }
                        }
                        Object.assign(calDataArray,sObj);
                        Object.assign(calDataArray,data1Data);
                    }
                    else if(calDataArray['Sunday'] == dataTaishou){
                        data1Data.dataSunShiftCd = data1Data.dataShiftCd;
                        data1Data.dataSunId = data1Data.dataId;
                        delete data1Data.dataShiftCd;
                        delete data1Data.dataId;
                        delete data1Data.dataTaishouDate;
                        for(var s = 0; s < data2Length; s++){
                            data2Data = data2[s];
                            dataShiftCd = data2Data['dataShiftCd'];
                            dataEndJikokuTsujou = data2Data['dataEndJikokuTsujou'];
                            dataEndJikokuZangyou = data2Data['dataEndJikokuZangyou'];
                            dataKeikaJikanTsujou = data2Data['dataKeikaJikanTsujou'];
                            dataKeikaJikanZangyou = data2Data['dataKeikaJikanZangyou'];
                            if(dataShiftCd == data1Data['dataSunShiftCd']){
                                var suObj = { 'dataSunEndJikokuTsujou': dataEndJikokuTsujou, 'dataSunEndJikokuZangyou': dataEndJikokuZangyou,
                                                'dataSunKeikaJikanTsujou': dataKeikaJikanTsujou, 'dataSunKeikaJikanZangyou': dataKeikaJikanZangyou,
                                                    'dataSunIdFlg': 2};
                                break;
                            }
                            else{
                                var suObj = { 'dataSunEndJikokuTsujou': 0, 'dataSunEndJikokuZangyou': 0, 'dataSunKeikaJikanTsujou': 0, 'dataSunKeikaJikanZangyou': 0, 'dataSunIdFlg': 2}; 
                            }
                        }
                        Object.assign(calDataArray,suObj);
                        Object.assign(calDataArray,data1Data);
                    }
                }
            }
            let dataKikaiArray;
            for(var b = 0; b < calDataLength; b++){
                dataJigyoubuArray = dataKikai[b];
                //console.log(dataJigyoubuArray)
                dataKikaiArray = calData[b];
                if(dataJigyoubuArray['dataMonId'] != dataKikaiArray['dataMonId'] && dataKikaiArray['dataMonId'] !== undefined){
                    dataJigyoubuArray.dataMonShiftCd = dataKikaiArray['dataMonShiftCd'];
                    dataJigyoubuArray.dataMonId = dataKikaiArray['dataMonId'];
                    dataJigyoubuArray.dataMonIdFlg = dataKikaiArray['dataMonIdFlg'];
                    dataJigyoubuArray.dataMonEndJikokuTsujou = dataKikaiArray['dataMonEndJikokuTsujou'];
                    dataJigyoubuArray.dataMonEndJikokuZangyou = dataKikaiArray['dataMonEndJikokuZangyou'];
                    dataJigyoubuArray.dataMonKeikaJikanTsujou = dataKikaiArray['dataMonKeikaJikanTsujou'];
                    dataJigyoubuArray.dataMonKeikaJikanZangyou = dataKikaiArray['dataMonKeikaJikanZangyou'];
                }
                if(dataJigyoubuArray['dataTueId'] != dataKikaiArray['dataTueId'] && dataKikaiArray['dataTueId'] !== undefined){
                    dataJigyoubuArray.dataTueShiftCd = dataKikaiArray['dataTueShiftCd'];
                    dataJigyoubuArray.dataTueId = dataKikaiArray['dataTueId'];
                    dataJigyoubuArray.dataTueIdFlg = dataKikaiArray['dataTueIdFlg'];
                    dataJigyoubuArray.dataTueEndJikokuTsujou = dataKikaiArray['dataTueEndJikokuTsujou'];
                    dataJigyoubuArray.dataTueEndJikokuZangyou = dataKikaiArray['dataTueEndJikokuZangyou'];
                    dataJigyoubuArray.dataTueKeikaJikanTsujou = dataKikaiArray['dataTueKeikaJikanTsujou'];
                    dataJigyoubuArray.dataTueKeikaJikanZangyou = dataKikaiArray['dataTueKeikaJikanZangyou'];
                }
                if(dataJigyoubuArray['dataWedId'] != dataKikaiArray['dataWedId'] && dataKikaiArray['dataWedId'] !== undefined){
                    dataJigyoubuArray.dataWedShiftCd = dataKikaiArray['dataWedShiftCd'];
                    dataJigyoubuArray.dataWedId = dataKikaiArray['dataWedId'];
                    dataJigyoubuArray.dataWedIdFlg = dataKikaiArray['dataWedIdFlg'];
                    dataJigyoubuArray.dataWedEndJikokuTsujou = dataKikaiArray['dataWedEndJikokuTsujou'];
                    dataJigyoubuArray.dataWedEndJikokuZangyou = dataKikaiArray['dataWedEndJikokuZangyou'];
                    dataJigyoubuArray.dataWedKeikaJikanTsujou = dataKikaiArray['dataWedKeikaJikanTsujou'];
                    dataJigyoubuArray.dataWedKeikaJikanZangyou = dataKikaiArray['dataWedKeikaJikanZangyou'];
                }
                if(dataJigyoubuArray['dataThuId'] != dataKikaiArray['dataThuId'] && dataKikaiArray['dataThuId'] !== undefined){
                    dataJigyoubuArray.dataThuShiftCd = dataKikaiArray['dataThuShiftCd'];
                    dataJigyoubuArray.dataThuId = dataKikaiArray['dataThuId'];
                    dataJigyoubuArray.dataThuIdFlg = dataKikaiArray['dataThuIdFlg'];
                    dataJigyoubuArray.dataThuEndJikokuTsujou = dataKikaiArray['dataThuEndJikokuTsujou'];
                    dataJigyoubuArray.dataThuEndJikokuZangyou = dataKikaiArray['dataThuEndJikokuZangyou'];
                    dataJigyoubuArray.dataThuKeikaJikanTsujou = dataKikaiArray['dataThuKeikaJikanTsujou'];
                    dataJigyoubuArray.dataThuKeikaJikanZangyou = dataKikaiArray['dataThuKeikaJikanZangyou'];
                }
                if(dataJigyoubuArray['dataFriId'] != dataKikaiArray['dataFriId'] && dataKikaiArray['dataFriId'] !== undefined){
                    dataJigyoubuArray.dataFriShiftCd = dataKikaiArray['dataFriShiftCd'];
                    dataJigyoubuArray.dataFriId = dataKikaiArray['dataFriId'];
                    dataJigyoubuArray.dataFriIdFlg = dataKikaiArray['dataFriIdFlg'];
                    dataJigyoubuArray.dataFriEndJikokuTsujou = dataKikaiArray['dataFriEndJikokuTsujou'];
                    dataJigyoubuArray.dataFriEndJikokuZangyou = dataKikaiArray['dataFriEndJikokuZangyou'];
                    dataJigyoubuArray.dataFriKeikaJikanTsujou = dataKikaiArray['dataFriKeikaJikanTsujou'];
                    dataJigyoubuArray.dataFriKeikaJikanZangyou = dataKikaiArray['dataFriKeikaJikanZangyou'];
                }
                if(dataJigyoubuArray['dataSatId'] != dataKikaiArray['dataSatId'] && dataKikaiArray['dataSatId'] !== undefined){
                    dataJigyoubuArray.dataSatShiftCd = dataKikaiArray['dataSatShiftCd'];
                    dataJigyoubuArray.dataSatId = dataKikaiArray['dataSatId'];
                    dataJigyoubuArray.dataSatIdFlg = dataKikaiArray['dataSatIdFlg'];
                    dataJigyoubuArray.dataSatEndJikokuTsujou = dataKikaiArray['dataSatEndJikokuTsujou'];
                    dataJigyoubuArray.dataSatEndJikokuZangyou = dataKikaiArray['dataSatEndJikokuZangyou'];
                    dataJigyoubuArray.dataSatKeikaJikanTsujou = dataKikaiArray['dataSatKeikaJikanTsujou'];
                    dataJigyoubuArray.dataSatKeikaJikanZangyou = dataKikaiArray['dataSatKeikaJikanZangyou'];
                }
                if(dataJigyoubuArray['dataSunId'] != dataKikaiArray['dataSunId'] && dataKikaiArray['dataSunId'] !== undefined){
                    dataJigyoubuArray.dataSunShiftCd = dataKikaiArray['dataSunShiftCd'];
                    dataJigyoubuArray.dataSunId = dataKikaiArray['dataSunId'];
                    dataJigyoubuArray.dataSunIdFlg = dataKikaiArray['dataSunIdFlg'];
                    dataJigyoubuArray.dataSunEndJikokuTsujou = dataKikaiArray['dataSunEndJikokuTsujou'];
                    dataJigyoubuArray.dataSunEndJikokuZangyou = dataKikaiArray['dataSunEndJikokuZangyou'];
                    dataJigyoubuArray.dataSunKeikaJikanTsujou = dataKikaiArray['dataSunKeikaJikanTsujou'];
                    dataJigyoubuArray.dataSunKeikaJikanZangyou = dataKikaiArray['dataSunKeikaJikanZangyou'];
                }
            }

            if(resourceVal == 2){
                if(calData2 != calendarGrid.itemsSource){
                    calendarGrid.itemsSource = dataKikai;
                }
            }
            calendarGrid.refresh(true);
            //console.log(calendarGrid.itemsSource)
        }
    }

    {{-- 左側 --}}
    var fncJushinGridDataLeft = function(dataLeft, errorFlg)
    {
        {{-- 「データ更新中」非表示 --}}
        ClosePopupDlg();
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(IsAjaxDataError(dataLeft, errorFlg)) return;
        {{-- グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 --}}
        var dataLeftArray;
        var dataLeft1 = dataLeft[1];
        //console.log(dataLeft,'dataLeft');
        for(var l = 0; l < dataLeft.length; l++){
            dataLeftArray = dataLeft1[l];
            if(dataLeftArray !== undefined){
                if(dataLeftArray['dataJigyoubuCd'] !== undefined){
                    dataLeftArray.dataShiftCd = dataLeftArray.dataJigyoubuCd;
                    dataLeftArray.dataShiftName = dataLeftArray.dataJigyoubuName;
                }
                else if(dataLeftArray['dataBushoCd'] !== undefined){
                    dataLeftArray.dataShiftCd = dataLeftArray.dataBushoCd;
                    dataLeftArray.dataShiftName = dataLeftArray.dataBushoName;
                }
                else if(dataLeftArray['dataKikaiCd'] !== undefined){
                    dataLeftArray.dataShiftCd = dataLeftArray.dataKikaiCd;
                    dataLeftArray.dataShiftName = dataLeftArray.dataKikaiName;
                }
                else if(dataLeftArray['dataTantoushaCd'] !== undefined){
                    dataLeftArray.dataShiftCd = dataLeftArray.dataTantoushaCd;
                    dataLeftArray.dataShiftName = dataLeftArray.dataTantoushaName;
                }
            }
        }
        selectedRowsLeft = SortMultiRowData(gridMasterLeft, dataLeft[1], 'dataJigyoubuCd');
    }

    {{-- シフトマスタ --}}
    var fncJushinGridDataShift = function(dataShift, errorFlg)
    {
        {{-- 「データ更新中」非表示 --}}
        ClosePopupDlg();
        //console.log(dataShift[2])
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(IsAjaxDataError(dataShift, errorFlg)) return;
        var dataShiftLng = dataShift[2].length;
        var dataShiftLng2 = dataShiftLng + 1
        var dataShift2 = { 'dataShiftCd': '休', 'dataShiftName': '休日', 'dataEndJikokuTsujou': 0, 'dataEndJikokuZangyou': 0, 'dataKeikaJikanTsujou': 0, 'dataKeikaJikanZangyou': 0};
        var dataShift3 = { 'dataShiftCd': '空白', 'dataShiftName': '標準シフト','dataEndJikokuTsujou': 0, 'dataEndJikokuZangyou': 0, 'dataKeikaJikanTsujou': 0, 'dataKeikaJikanZangyou': 0};
        dataShift2[dataShiftLng] = dataShift2;
        dataShift2[dataShiftLng2] = dataShift3;
        Object.assign(dataShift[2], dataShift2);
        {{-- グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 --}}
        selectedRowsShift = SortMultiRowData(gridMasterShift, dataShift[2], 'dataShiftCd');
    }

    {{-- DBデータ更新 --}}
    {{-- シフト（カレンダー） --}}
    var fncUpdateData = function(data, errorFlg)
    {
        console.log('a')
        if(data[3] == data[4]){
            {{-- 「データ更新中」非表示 --}}
            ClosePopupDlg();
            CloseAlertDlg();
        }
        {{-- データエラー判定 ※common_function.js参照 --}}
        if(!IsAjaxDataError(data, errorFlg))
        {
            //console.log(data,'aaaaaa')
            if(data[3] == data[4]){
                {{-- 「データ更新完了」表示 --}}
                ShowAlertDlg('データ更新完了');
                {{-- 選択行のデータIDを保持 ※common_function.js参照 --}}
                SetSelectedRowId(data[2][0]);
                {{-- グリッドデータの表示 --}}
                $('#btnHyouji').click();
            }
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
            }
        }
    }


    {{-- ------------------------ --}}
    {{-- その他入力コントロール処理 --}}
    {{-- ------------------------ --}}

    {{-- データ登録ボタン クリック処理 --}}
    function dataTouroku(){
        {{-- POST送信用オブジェクト配列 --}}
        let soushinData = {};
        let calendarSoushinData = calendarGrid,itemsSource;
        let calendarSoushinData0 = calendarGrid.itemsSource[0]
        //console.log(calendarSoushinData0.dataTaishouCd)
        soushinData.dataSentakuCd = calendarSoushinData0.dataTaishouCd;
        if(calendarSoushinData0.dataTaishouCdJ != undefined){
            soushinData.dataJigyoubuCd2 = calendarSoushinData0.dataTaishouCdJ;
        }
        if(resourceKbnValue[cmbResourceKbn.selectedIndex] == 2){
            if(calendarSoushinData0.dataTaishouCdB != undefined){
                soushinData.dataBushoCd = "";
            }
        }

        {{-- 「リソース区分」 --}}
        document.forms['frmKensaku'].elements['dataResourceKbn'].selectedIndex = resourceKbnValue[cmbResourceKbn.selectedIndex];
        soushinData['dataResourceKbn'] = document.forms['frmKensaku'].elements['dataResourceKbn'].selectedIndex;
        soushinData['dataJigyoubuCd'] = document.forms['frmKensaku'].elements['dataJigyoubuCd'].value;
        var y = parseInt(document.forms['frmKensaku'].elements['year'].value);
        var m = parseInt(document.forms['frmKensaku'].elements['month'].value);

        soushinData['dataTaishouStartDate'] = y + '-' + parseInt(m+1) + '-01';
        soushinData['dataTaishouEndDate'] = y + '-' + parseInt(m+2) + '-01'; // y + '-' + m + '-01'

        if(soushinData['dataTaishouEndDate'] == y + '-'+'13-01'){
            soushinData['dataTaishouEndDate'] = (y + 1) + '-1-01'
        }

        {{-- 「データ更新中」表示 --}}
        ShowPopupDlg("{{ __('データ読込中') }}");
        //console.log(soushinData);
        {{-- グリッドのデータ受信 --}}
        {{-- シフト（カレンダー） --}}
        AjaxData("{{ url('/master/3100') }}",soushinData, fncDataTouroku);
    }

    function fncDataTouroku(data, errorFlg)
    {
        let calItems = calendarGrid.itemsSource;
        //console.log(calendarGrid.itemsSource)
        //console.log(data,'aaaaaaaaaaaaa')
        var calLength = calItems.length;
        let calItemsArray = calItems[0];
        var calLastId = calItemsArray['dataLastId'] + 1;

        {{-- 入力フォーム要素 --}}
        let nyuryokuData = document.forms['frmNyuryoku'].elements;
        {{-- POST送信用オブジェクト配列 --}}
        let soushinData = {};
        {{-- フォーム要素から送信データを格納 --}}
        document.forms['frmKensaku'].elements['dataResourceKbn'].selectedIndex = resourceKbnValue[cmbResourceKbn.selectedIndex];
        soushinData['dataResourceKbn'] = document.forms['frmKensaku'].elements['dataResourceKbn'].selectedIndex;
        soushinData['dataJigyoubuCd'] = document.forms['frmKensaku'].elements['dataJigyoubuCd'].value;
        //console.log(document.forms['frmKensaku'].elements['dataJigyoubuCd'].value,'aaaaaa')

        var y = parseInt(document.forms['frmKensaku'].elements['year'].value);
        var m = parseInt(document.forms['frmKensaku'].elements['month'].value);
        var resourceVal = resourceKbnValue[cmbResourceKbn.selectedIndex];
        var month = parseInt($("#month").val());
        var year = parseInt($("#year").val());
        let calData = MakeCalendarData(month,year);
        var calDataLength = calData['length'] - 1;
        //月末用変数(dateMax)
        var dateMax;
        let calDataArray = calData[calDataLength];
        if(calDataArray['Tuesday'] === ''){
            dateMax = calDataArray['Monday'];
        }
        else if(calDataArray['Wednesday'] === ''){
            dateMax = calDataArray['Tuesday'];
        }
        else if(calDataArray['Thursday'] === ''){
            dateMax = calDataArray['Wednesday'];
        }
        else if(calDataArray['Friday'] === ''){
            dateMax = calDataArray['Thursday'];
        }
        else if(calDataArray['Saturday'] === ''){
            dateMax = calDataArray['Friday'];
        }
        else if(calDataArray['Sunday'] === ''){
            dateMax = calDataArray['Saturday'];
        }
        let gridJigyoubu = data[8]; 
        let gridJigyoubuArray;
        var gridJigyoubuLength = gridJigyoubu.length;
        var JigyoubuFlg = false;
        var deleteFlg = 0;
        soushinData.deleteFlg = deleteFlg;
        for(var l = 0; l < gridJigyoubuLength; l++){
            gridJigyoubuArray = gridJigyoubu[l]
            if(gridJigyoubuArray['dataSentakuCd'] == document.forms['frmKensaku'].elements['dataJigyoubuCd'].value){
                JigyoubuFlg = true;
                break;
            }
        }
        for(var d = 1; d <= dateMax; d++){
            deleteFlg = 0;
            if(document.forms['frmKensaku'].elements['dataJigyoubuCd'].value == ''){
                ShowAlertDlg("{{__('事業部CDを入力してください')}}");
                {{-- 「データ更新中」非表示 --}}
                ClosePopupDlg();
                break;
            }
            else{
                if(JigyoubuFlg === false){
                    {{-- 「データ更新中」非表示 --}}
                    ClosePopupDlg();
                    ShowAlertDlg("{{__('存在するCDか親事業部CDを入力してください')}}");
                    break;
                }
            }
            soushinData['dataTaishouDate'] = y + '-' + parseInt(m+1) + '-' + d; 
            soushinData.dataTaishouCd = calItemsArray['dataTaishouCd']
            soushinData.dataLastId = calItemsArray['dataLastId']
            for(var c = 0; c < calLength; c++){
                calItemsArray = calItems[c];
                //console.log(calItemsArray,'calItemsArray');
                if(calItemsArray['Monday'] == d){
                    soushinData.dataShiftCd = calItemsArray['dataMonShiftCd'];
                    if(calItemsArray['dataMonId'] == undefined){
                        soushinData.dataId = calLastId;
                        calLastId++ ;
                    }
                    else{
                        soushinData.dataId = calItemsArray['dataMonId'];
                    }
                    soushinData.dataIdFlg = calItemsArray['dataMonIdFlg'];
                    soushinData.dataEndJikokuTsujou = calItemsArray['dataMonEndJikokuTsujou'];
                    soushinData.dataEndJikokuZangyou = calItemsArray['dataMonEndJikokuZangyou'];
                    soushinData.dataKeikaJikanTsujou = calItemsArray['dataMonKeikaJikanTsujou'];
                    soushinData.dataKeikaJikanZangyou = calItemsArray['dataMonKeikaJikanZangyou'];
                    soushinData.dateMax = dateMax;
                    soushinData.date = d;
                    //console.log(soushinData)
                    //console.log(d)
                    //console.log(soushinData.dataId)
                    break;
                }
                else if(calItemsArray['Tuesday'] == d){
                    soushinData.dataShiftCd = calItemsArray['dataTueShiftCd'];
                    if(calItemsArray['dataTueId'] == undefined){
                        soushinData.dataId = calLastId;
                        calLastId++ ;
                    }
                    else{
                        soushinData.dataId = calItemsArray['dataTueId'];
                    }
                    soushinData.dataIdFlg = calItemsArray['dataTueIdFlg'];
                    soushinData.dataEndJikokuTsujou = calItemsArray['dataTueEndJikokuTsujou'];
                    soushinData.dataEndJikokuZangyou = calItemsArray['dataTueEndJikokuZangyou'];
                    soushinData.dataKeikaJikanTsujou = calItemsArray['dataTueKeikaJikanTsujou'];
                    soushinData.dataKeikaJikanZangyou = calItemsArray['dataTueKeikaJikanZangyou'];
                    soushinData.dateMax = dateMax;
                    soushinData.date = d;
                    //console.log(soushinData)
                    //console.log(d)
                    //console.log(soushinData.dataId)
                    break;
                }
                else if(calItemsArray['Wednesday'] == d){
                    soushinData.dataShiftCd = calItemsArray['dataWedShiftCd'];
                    if(calItemsArray['dataWedId'] == undefined){
                        soushinData.dataId = calLastId;
                        calLastId++ ;
                    }
                    else{
                        soushinData.dataId = calItemsArray['dataWedId'];
                    }
                    soushinData.dataIdFlg = calItemsArray['dataWedIdFlg'];
                    soushinData.dataEndJikokuTsujou = calItemsArray['dataWedEndJikokuTsujou'];
                    soushinData.dataEndJikokuZangyou = calItemsArray['dataWedEndJikokuZangyou'];
                    soushinData.dataKeikaJikanTsujou = calItemsArray['dataWedKeikaJikanTsujou'];
                    soushinData.dataKeikaJikanZangyou = calItemsArray['dataWedKeikaJikanZangyou'];
                    soushinData.dateMax = dateMax;
                    soushinData.date = d;
                    //console.log(soushinData)
                    //console.log(d)
                    //console.log(soushinData.dataId)
                    break;
                }
                else if(calItemsArray['Thursday'] == d){
                    soushinData.dataShiftCd = calItemsArray['dataThuShiftCd'];
                    if(calItemsArray['dataThuId'] == undefined){
                        soushinData.dataId = calLastId;
                        calLastId++ ;
                    }
                    else{
                        soushinData.dataId = calItemsArray['dataThuId'];
                    }
                    soushinData.dataIdFlg = calItemsArray['dataThuIdFlg'];
                    soushinData.dataEndJikokuTsujou = calItemsArray['dataThuEndJikokuTsujou'];
                    soushinData.dataEndJikokuZangyou = calItemsArray['dataThuEndJikokuZangyou'];
                    soushinData.dataKeikaJikanTsujou = calItemsArray['dataThuKeikaJikanTsujou'];
                    soushinData.dataKeikaJikanZangyou = calItemsArray['dataThuKeikaJikanZangyou'];
                    soushinData.dateMax = dateMax;
                    soushinData.date = d;
                    //console.log(soushinData)
                    //console.log(d)
                    //console.log(soushinData.dataId)
                    break;
                }
                else if(calItemsArray['Friday'] == d){
                    soushinData.dataShiftCd = calItemsArray['dataFriShiftCd'];
                    if(calItemsArray['dataFriId'] == undefined){
                        soushinData.dataId = calLastId;
                        calLastId++ ;
                    }
                    else{
                        soushinData.dataId = calItemsArray['dataFriId'];
                    }
                    soushinData.dataIdFlg = calItemsArray['dataFriIdFlg'];
                    soushinData.dataEndJikokuTsujou = calItemsArray['dataFriEndJikokuTsujou'];
                    soushinData.dataEndJikokuZangyou = calItemsArray['dataFriEndJikokuZangyou'];
                    soushinData.dataKeikaJikanTsujou = calItemsArray['dataFriKeikaJikanTsujou'];
                    soushinData.dataKeikaJikanZangyou = calItemsArray['dataFriKeikaJikanZangyou'];
                    soushinData.dateMax = dateMax;
                    soushinData.date = d;
                    //console.log(soushinData)
                    //console.log(d)
                    //console.log(soushinData.dataId)
                    break;
                }
                else if(calItemsArray['Saturday'] == d){
                    soushinData.dataShiftCd = calItemsArray['dataSatShiftCd'];
                    if(calItemsArray['dataSatId'] == undefined){
                        soushinData.dataId = calLastId;
                        calLastId++ ;
                    }
                    else{
                        soushinData.dataId = calItemsArray['dataSatId'];
                    }
                    soushinData.dataIdFlg = calItemsArray['dataSatIdFlg'];
                    soushinData.dataEndJikokuTsujou = calItemsArray['dataSatEndJikokuTsujou'];
                    soushinData.dataEndJikokuZangyou = calItemsArray['dataSatEndJikokuZangyou'];
                    soushinData.dataKeikaJikanTsujou = calItemsArray['dataSatKeikaJikanTsujou'];
                    soushinData.dataKeikaJikanZangyou = calItemsArray['dataSatKeikaJikanZangyou'];
                    soushinData.dateMax = dateMax;
                    soushinData.date = d;
                    //console.log(soushinData)
                    //console.log(d)
                    //console.log(soushinData.dataId)
                    break;
                }
                else if(calItemsArray['Sunday'] == d){
                    soushinData.dataShiftCd = calItemsArray['dataSunShiftCd'];
                    if(calItemsArray['dataSunId'] == undefined){
                        soushinData.dataId = calLastId;
                        calLastId++ ;
                    }
                    else{
                        soushinData.dataId = calItemsArray['dataSunId'];
                    }
                    soushinData.dataIdFlg = calItemsArray['dataSunIdFlg'];
                    soushinData.dataEndJikokuTsujou = calItemsArray['dataSunEndJikokuTsujou'];
                    soushinData.dataEndJikokuZangyou = calItemsArray['dataSunEndJikokuZangyou'];
                    soushinData.dataKeikaJikanTsujou = calItemsArray['dataSunKeikaJikanTsujou'];
                    soushinData.dataKeikaJikanZangyou = calItemsArray['dataSunKeikaJikanZangyou'];
                    soushinData.dateMax = dateMax;
                    soushinData.date = d;
                    //console.log(soushinData)
                    //console.log(d)
                    //console.log(soushinData.dataId)
                    break;
                }
            }
            //console.log(resourceKbnValue[cmbResourceKbn.selectedIndex])

            let jigyoubuData = data[1];
            let jigyoubuArray; 
            var jigyoubuDataLength = jigyoubuData.length;
            let bushoData = data[3];
            let bushoArray; 
            var bushoDataLength;
            var kbnValue = resourceKbnValue[cmbResourceKbn.selectedIndex];
            var idFlg = soushinData.dataIdFlg

            if(kbnValue === 1 || kbnValue === 2 && kbnValue == idFlg){
                //console.log(jigyoubuData,'jigyoubuData')
                //console.log(jigyoubuDataLength)
                for(var j = 0; j < jigyoubuDataLength; j++){
                    jigyoubuArray = jigyoubuData[j];
                    if(jigyoubuArray['dataShiftCd'] == '@'){
                        jigyoubuArray['dataShiftCd'] = '';
                    }
                    if(jigyoubuArray['dataShiftCd'] == 'H'){
                        jigyoubuArray['dataShiftCd'] = '休';
                    }
                    //console.log(jigyoubuArray)
                    //console.log(jigyoubuArray['dataTaishouDate'],'test')
                    //console.log(soushinData.date,'soushinData.date',jigyoubuArray['dataTaishouDate'],'jigyoubuArray[dataTaishouDate]',soushinData.dataShiftCd,'soushinData.dataShiftCd',jigyoubuArray['dataShiftCd'],'jigyoubuArray[dataShiftCd]')
                    if(soushinData.date == jigyoubuArray['dataTaishouDate'] && soushinData.dataShiftCd == jigyoubuArray['dataShiftCd'] && soushinData.dataIdFlg == kbnValue){
                        deleteFlg = 1;
                        soushinData.deleteFlg = deleteFlg;
                        break;
                    }
                }
            }
            if(kbnValue === 3 && kbnValue == idFlg){
                for(var j = 0; j < bushoDataLength; j++){
                    bushoArray = bushoData[j];
                    if(bushoArray['dataShiftCd'] == '@'){
                        bushoArray['dataShiftCd'] = '';
                    }
                    if(bushoArray['dataShiftCd'] == 'H'){
                        bushoArray['dataShiftCd'] = '休';
                    }
                    if(soushinData.date == bushoArray['dataTaishouDate'] && soushinData.dataShiftCd == bushoArray['dataShiftCd'] && soushinData.dataIdFlg == kbnValue){
                        deleteFlg = 1;
                        soushinData.deleteFlg = deleteFlg;
                        break;
                    }
                }
            }
            //console.log(soushinData.deleteFlg,'deleteFlg')
            //console.log(soushinData.dataLastId,'soushinData.dataLastId',soushinData.dataId,'soushinData.dataId')

            //console.log(soushinData.dataIdFlg,'soushinData.dataIdFlg',kbnValue,'kbnValue')
            if(deleteFlg == 0 && soushinData.dataIdFlg == kbnValue){
                {{-- 「データ更新中」表示 --}}
                ShowPopupDlg("{{__('データ更新中')}}");
                {{-- 非同期データ更新開始 --}}
                AjaxData("{{ url('/master/3101') }}", soushinData, fncUpdateData);
            }
            else if(deleteFlg == 1 || soushinData.dataLastId >= soushinData.dataId && soushinData.dataIdFlg == kbnValue){
                {{-- 「データ更新中」表示 --}}
                ShowPopupDlg("{{__('データ更新中')}}");
                {{-- 非同期データ更新開始 --}}
                AjaxData("{{ url('/master/3101') }}", soushinData, fncUpdateData);
            }
        }

        {{-- 関数内関数 --}}
        {{-- 編集ダイアログ入力値変更判定 --}}
        {{-- シフト（カレンダー） --}}

        soushinData={'dataTaishouCd': '', 'dataJigyoubuCd': ''};
        {{-- 「データ更新中」表示 --}}
        ShowPopupDlg("{{__('データ更新中')}}");
        {{-- 非同期データ更新開始 --}}
        AjaxData("{{ url('/master/3100') }}", soushinData, fncCloseDlg);
    };

    var fncCloseDlg = function(data, errorFlg){
        ClosePopupDlg();
    }

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
                           currentCdElement, currentNameElement, "{{ url('/inquiry/CalendarJigyoubu') }}");
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
    var fncBtnHyoujiCalendar = function(){
        let calData = CalendarSoushinData();
        MakeCalendarGrid(calData);
        calendar.style.display = 'block';
        shiftMaster.style.display = 'block';
    }
    // ボタン二重起動防止
    $(document).off('click');

    // 「新規」ボタン　クリック処理
    $(document).on('click', '#btnShinki', function () {
        CloseNyuryokuDlg()
    });
    // 「参照新規」ボタン　クリック処理
    $(document).on('click', '#btnSanshouShinki', function () {
        CloseNyuryokuDlg()
    });
    // 「修正」ボタン　クリック処理
    $(document).on('click', '#btnShusei', function () {
        CloseNyuryokuDlg()
    });
    // 「削除」ボタン　クリック処理
    $(document).on('click', '#btnSakujo', function () {
    });
    // 「表示」ボタン　クリック処理
    $(document).on('click', '#btnHyouji', function () {
        // グリッドデータ表示
        fncBtnHyoujiCalendar();
    });
</script>
@endsection
