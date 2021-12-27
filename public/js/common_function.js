// Ver.2021101301
// JavaScriptの共通関数

////////////////////
//                //
//　ダイアログ関係　//
//                //
////////////////////

///////////////////
// 入力ダイアログ //
///////////////////

// 入力ダイアログ共有変数
var dlgNyuryoku;
// 入力初期値を処理する関数変数
var fncNyuryokuData = function(){}
// 関数を設定
function SetNyuryokuData(fnc)
{
    fncNyuryokuData = fnc;
}
// ダイアログの宣言
// ※宣言は「base_master.blede.php」で宣言
function SetNyuryokuDlg(dlg)
{
    dlg.isDraggable =  true;  // ヘッダー移動操作許可
    dlg.hideTrigger = 'None'; // ダイアログを閉じる条件
    // ダイアログの「キーボード」イベント
    dlg.addEventListener(dlg.hostElement, 'keydown', function (e)
    {
        let idText = '';
        // F8キー
        if(e.keyCode == KEY_F8)  idText = '.btnSanshou';
        // F9キー
        if(e.keyCode == KEY_F9)  idText = '#btnKettei';
        // F12キー
        if(e.keyCode == KEY_F12) idText = '#btnKetteiCancel';
        // クリック処理実行
        if(idText != '') $(idText).click();
        // キーボードイベント重複防止フラグ
        windowKeybordFlg = false;
    });
    dlgNyuryoku = dlg;
}
// ダイアログの表示
function ShowNyuryokuDlg(index, mode)
{
    // 表示
    dlgNyuryoku.show(true);
    // 入力初期値処理
    fncNyuryokuData(index, mode);
}
// ダイアログを閉じる
function CloseNyuryokuDlg()
{
    // 処理種別を初期化
    $('#dataSQLType').val(-1);
    dlgNyuryoku.hide(0);
}
//
function IsVisibleNyuryoku(){
    return dlgNyuryoku.isVisible;
}
///////////////////

///////////////////
// 選択ダイアログ //
///////////////////

// 選択ダイアログ共有変数
var dlgSentaku;
// ダイアログの宣言
// ※宣言は「base_master.blede.php」で宣言
function SetSentakuDlg(dlg)
{
    dlg.isDraggable =  true;  // ヘッダー移動操作許可
    dlg.hideTrigger = 'None'; // ダイアログを閉じる条件
    // ダイアログの「キーボード」イベント
    dlg.addEventListener(dlg.hostElement, 'keydown', function (e)
    {
        let idText = '';
        // F5キー
        if(e.keyCode == KEY_F5)  idText = '#btnSentakuKensaku';
        // F9キー
        if(e.keyCode == KEY_F9)  idText = '#btnSentaku';
        // F12キー
        if(e.keyCode == KEY_F12) idText = '#btnSentakuCancel';
        // クリック処理実行
        if(idText != '') $(idText).click();
        // キーボードイベント重複防止フラグ
        windowKeybordFlg = false;
    });
    dlgSentaku = dlg;
}
// 選択グリッド共有変数
var gridSentaku = null;
// 選択ダイアログ表示フラグ
var dlgSentakuFlg = false;
// 選択ダイアログの共有変数群
var sentakuValues = {
    "cdElement": null,
    "nameElement": null,
    "sendURL": "",
    "targetDate": null,
    "targetCode": null,
    "kensakuFlg": 1
}
// ダイアログの表示
function ShowSentakuDlg(cdText, nameText, cdElement, nameElement, sendURL, targetDate, targetCode, kensakuFlg)
{
    if(dlgSentakuFlg) return;
    dlgSentakuFlg = true;
    // 選択ダイアログの必要変数を格納
    sentakuValues.cdElement = cdElement;
    sentakuValues.nameElement = nameElement;
    sentakuValues.sendURL = sendURL;
    // 対象日
    sentakuValues.targetDate = targetDate;
    // 対象コード
    sentakuValues.targetCode = targetCode;
    // 事業部コード検索フラグ
    if( kensakuFlg == null )
    {
        sentakuValues.kensakuFlg = null;
    }
    else
    {
        sentakuValues.kensakuFlg = kensakuFlg ? 1 : 0;
    }
    let textWidth = cdText.length + 0.5;
    // 選択ダイアログの表示
    dlgSentaku.show(true);
    // コード項目のキャプションを変更
    $('#captionKensakuCd').text(cdText);
    $('#captionKensakuCd').css({'cssText': 'width: '+ textWidth +'em;'});
    $('#dataKensakuCd').val('');
    // 名前項目のキャプションを変更
    $('#captionKensakuName').text(nameText);
    $('#captionKensakuName').css({'cssText': 'width: '+ textWidth +'em;'});
    $('#dataKensakuName').val('');
    // グリッドの初期設定
    gridSentaku = InitSentakuGrid();
    gridSentaku.columns[0].header = $('#captionKensakuCd').text();
    gridSentaku.columns[1].header = $('#captionKensakuName').text();
    // 選択ダイアログのグリッドデータ表示
    ShowSentakuGrid();
}
// グリッドの初期設定
function InitSentakuGrid()
{
    // グリッドのレイアウト設定
    let columns = [
        {
            binding: 'dataSentakuCd',
            width  : '*'
        },
        {
            binding: 'dataSentakuName',
            width  : '2*'
        }
    ];
    // グリッドの宣言
    let grid = new wijmo.grid.FlexGrid('#gridSentaku', {
        // 自動列生成停止
        autoGenerateColumns: false,
        // レイアウト設定
        columns: columns,
        // 選択方法（行ごと）
        selectionMode: wijmo.grid.SelectionMode.Row,
        // セルの読み取り専用設定
        isReadOnly: true,
        // デフォルト行スタイル（0行ごとに色付け）
        alternatingRowStep: 0,
        // グリッド上でのEnterキーイベント（無効）
        keyActionEnter: wijmo.grid.KeyAction.None,
        // セル読み込み時のイベント
        loadedRows: function (s, e)
        {
            // 任意の色でセルを色付け
            // ※rowPerItemでMultiRowの1レコード当たりの行数を取得（今回はrowPerItem = 2）
            // ※common_function.js参照 --}}
            LoadGridRows(s, 1);
        }
    });
    let host = grid.hostElement; 
    // グリッドセルのダブルクリックイベント
    grid.addEventListener(host, 'dblclick', function (e)
    {
        // 選択したセルがヘッダー要素でない場合は「修正」ボタンと同じ処理
        if(grid.hitTest(e).cellType == wijmo.grid.CellType.Cell) SetSentakuValue();
    });
    // グリッドの「キーボード」イベント
    grid.addEventListener(host, 'keydown', function (e)
    {
        // 「Enterキー」は「修正」ボタンと同じ処理
        if(e.keyCode == KEY_ENTER)
        {
            SetSentakuValue();
            // キーボードイベント二重起動防止
            windowKeybordFlg = false;
        }
    });
    return grid;
}
// 選択グリッドの表示
function ShowSentakuGrid()
{
    // 検索フォーム要素
    let sentakuData = document.forms['frmSentaku'].elements;
    // POST送信用オブジェクト配列
    let soushinData = {};
    // フォーム要素から送信データを設定
    for(var i = 0; i< sentakuData.length; i++){
        // フォーム要素データのnameが宣言されている要素のみ処理
        if(sentakuData[i].name != ''){
            // フォーム要素のnameを配列のキーしてPOSTデータの値を設定する
            soushinData[sentakuData[i].name] = (sentakuData[i].value != '') ? (sentakuData[i].value + LIKE_VALUE_BOTH) : '';
        }
    
    // 検索条件日（各選択画面での表示抽出を行う）
    soushinData["dataTargetDate"] = sentakuValues.targetDate;}
    // 検索条件コード（各選択画面での表示抽出を行う）
    soushinData["dataTargetCd"] = sentakuValues.targetCode;
    // 検索フラグ（事業部区分フラグで表示抽出を行う）
    soushinData["dataKensakuFlg"] = sentakuValues.kensakuFlg;
    // 非同期データ更新開始
    AjaxData(sentakuValues.sendURL, soushinData, function(data, errorFlg)
    {
        // データエラー判定
        if(IsAjaxDataError(data, errorFlg)) return;
        gridSentaku.itemsSource = data[1];
        // グリッドにフォーカス
        gridSentaku.focus(true);
    });
}
// グリッドから選択した値を対象要素に表示する
function SetSentakuValue()
{
    let gridItem = gridSentaku.collectionView.currentItem;
    if(gridItem != null)
    {
        sentakuValues.cdElement.value = gridItem['dataSentakuCd'];
        if(sentakuValues.nameElement != null) sentakuValues.nameElement.value = gridItem['dataSentakuName'];
    }
    CloseSentakuDlg();
}
// ダイアログを閉じる
function CloseSentakuDlg()
{
    gridSentaku.dispose();
    dlgSentakuFlg = false;
    dlgSentaku.hide(0);
}
///////////////////

// メッセージだけ表示し、イベントで閉じるタイプのダイアログ
//////////////////////////
// ポップアップダイアログ //
//////////////////////////

// ポップアップダイアログ共有変数
var dlgPopup;
// ダイアログの宣言
// ※宣言は「base_master.blede.php」で宣言
function SetPopupDlg(dlg)
{
    dlg.hideTrigger = 'None'; // ダイアログを閉じる条件
    dlgPopup = dlg;
}
// ダイアログの表示
function ShowPopupDlg(msg)
{     
    dlgPopup.show(true);
    $('#' + $('#' + dlgPopup.hostElement.id).children('span')[0].id).text(msg);
}
// ダイアログを閉じる
function ClosePopupDlg()
{
    dlgPopup.hide(0);
}
//////////////////////////

// メッセージを表示し、確認ボタンを押してダイアログを閉じるタイプのダイアログ
//////////////////////
// アラートダイアログ //
//////////////////////

// アラートダイアログ共有変数
var dlgAlert;
// ダイアログの宣言
// ※宣言は「base_master.blede.php」で宣言
function SetAlertDlg(dlg)
{
    dlg.hideTrigger = 'None'; // ダイアログを閉じる条件
    // ダイアログの「キーボード」イベント
    dlg.addEventListener(dlg.hostElement, 'keydown', function (e)
    {
        let idText = '';
        // F9キー
        if(e.keyCode == KEY_F9)  idText = '#btnKakunin';
        // クリック処理実行
        if(idText != '') $(idText).click();
        windowKeybordFlg = false;
    });
    dlgAlert = dlg;
}
// ダイアログの表示
function ShowAlertDlg(msg)
{
    dlgAlert.show(true);
    $('#' + $('#' + dlgAlert.hostElement.id).children('p')[0].id).html(msg);
}
// ダイアログを閉じる
function CloseAlertDlg()
{
    dlgAlert.hide(0);
}
//////////////////////

// メッセージを表示し、「はい」「いいえ」ボタンを押してダイアログを閉じ、処理を行うタイプのダイアログ
///////////////////
// 確認ダイアログ //
///////////////////

// 確認ダイアログ共有変数
var dlgConfirm;
// 「はい」ボタンイベント関数変数
var fncConfirmOk = function(){};
// 「いいえ」ボタンイベント関数変数
var fncConfirmNo = function(){};
// ダイアログの宣言
// ※宣言は「base_master.blede.php」で宣言
function SetConfirmDlg(dlg)
{
    dlg.hideTrigger = 'None'; // ダイアログを閉じる条件
    // ダイアログの「キーボード」イベント
    dlg.addEventListener(dlg.hostElement, 'keydown', function (e)
    {
        let idText = '';
        // F9キー
        if(e.keyCode == KEY_F9)  idText = '#btnConfOk';
        // F12キー
        if(e.keyCode == KEY_F12)  idText = '#btnConfNo';
        // クリック処理実行
        if(idText != '') $(idText).click();
        // キーボードイベント重複防止フラグ
        windowKeybordFlg = false;
    });
    dlgConfirm = dlg;
}
// ダイアログの表示
function ShowConfirmDlg(msg, fncOk, fncNo)
{
    fncConfirmOk = fncOk;
    fncConfirmNo = fncNo;
    dlgConfirm.show(true);
    $('#' + $('#' + dlgConfirm.hostElement.id).children('p')[0].id).html(msg);
}
// ダイアログを閉じる（「はい」ボタン）
function CloseConfirmDlgOk()
{
    dlgConfirm.hide(1);
    fncConfirmOk();
}
// ダイアログを閉じる（「いいえ」ボタン）
function CloseConfirmDlgNo()
{
    dlgConfirm.hide(0);
    if(fncConfirmNo != null) fncConfirmNo();
}
///////////////////

////////////////////////
//                    //
//　ボタンイベント関係　//
//                    //
////////////////////////

//////////////////////////
// 共通ボタンイベント登録 //
//////////////////////////

// ボタン二重起動防止
$(document).off('click');

// 「新規」ボタン　クリック処理
$(document).on('click', '#btnShinki', function()
{
    // 全て初期値の状態で表示
    ShowNyuryokuDlg(MODE_INSERT, false);
});
// 「参照新規」ボタン　クリック処理
$(document).on('click', '#btnSanshouShinki', function()
{
    // 選択行の項目をコピーして表示
    ShowNyuryokuDlg(MODE_INSERT, true);
});
// 「修正」ボタン　クリック処理
$(document).on('click', '#btnShusei', function()
{
    // 選択行の項目をコピーして表示
    ShowNyuryokuDlg(MODE_UPDATE, true);
});
// 「削除」ボタン　クリック処理
$(document).on('click', '#btnSakujo', function()
{
    // 選択行の項目をコピーして表示
    ShowNyuryokuDlg(MODE_DELETE, true);
});
// 「表示」ボタンの実行関数変数
var fncBtnHyouji = function(){}
// 「表示」ボタンのイベント登録
function SetBtnHyouji(fnc)
{
    fncBtnHyouji = fnc;
}
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
//　「CSV出力」ボタン　確認メッセージ
var msgCSV = "";
// ※宣言は「base_master.blede.php」で宣言
function SetBtnCSVMsg(msg)
{
    msgCSV = msg;
}
// 「CSV出力」ボタン　クリック処理
$(document).on('click', '#btnCSV', function()
{
    // 確認してから実行
    ShowConfirmDlg(msgCSV, fncBtnCSV, null);   
});
//　「閉じる」ボタン　確認メッセージ
var msgClose = "";
// ※宣言は「base_master.blede.php」で宣言
function SetBtnCloseMsg(msg)
{
    msgClose = msg;
}
// 「閉じる」ボタン　クリック処理
$(document).on('click', '#btnClose', function()
{
    // 確認してから実行
    ShowConfirmDlg(msgClose, function() {window.close(); }, null);
});
// ボタン制御
function SetEnableButton(count){
    $("#btnSanshouShinki").prop("disabled", (count < 1));
    $("#btnShusei").prop("disabled", (count < 1));
    $("#btnSakujo").prop("disabled", (count < 1));
    $("#btnCSV").prop("disabled", (count < 1));
}
//////////////////////////

////////////////////////////
//                        //
//　キーボードイベント関係  //
//                        //
////////////////////////////

// キーボードイベント重複防止フラグ
var windowKeybordFlg = true;
// 画面のファンクションキー操作禁止と任意割り当て
function SetFncKey(fncKeybord)
{
    window.document.onkeydown = function(event)
    {
        // ファンクションキーを無効
        if(event.keyCode >= KEY_F1 && event.keyCode <= KEY_F12){
            event.keyCode = null;
            event.returnValue = false;
        }
        // キーボードイベント重複防止フラグ
        if(windowKeybordFlg)
        {
            if(fncKeybord != null) fncKeybord(event);
            // 操作ボタンのid名
            let idText = '';
            // F1キー
            if(event.keyCode == KEY_F1)  idText = '#btnShinki';
            // F2キー
            if(event.keyCode == KEY_F2)  idText = '#btnSanshouShinki';
            // F3キー
            if(event.keyCode == KEY_F3)  idText = '#btnShusei';
            // F4キー
            if(event.keyCode == KEY_F4)  idText = '#btnSakujo';
            // F5キー
            if(event.keyCode == KEY_F5)  idText = '#btnHyouji';
            // F6キー
            if(event.keyCode == KEY_F6)  idText = '#btnCSV';
            // F8キー
            if(event.keyCode == KEY_F8)  idText = '.btnSanshou';
            // F12キー
            if(event.keyCode == KEY_F12) idText = '#btnClose';
            // クリック処理実行
            if(idText != '') $(idText).click();
        }
        windowKeybordFlg = true;
    };
}

////////////////////////
//                    //
//　右クリック操作関係　//
//                    //
////////////////////////

// 右クリックメニューの制限
function SetContextMenu()
{
    // 従来の右クリックメニュー非表示
    document.oncontextmenu = function (){ return false; }
    // クリック対象の要素の取得
    let inputText = document.querySelectorAll('input[type="text"]');
    for (let i = 0; i < inputText.length; i++) {
        // オリジナル右クリックメニューを表示する対象要素に表示クリックイベントを登録
        inputText[i].addEventListener('contextmenu', e => {
            // 右クリックメニュー宣言
            let contextMenu = new wijmo.input.Menu(document.createElement('div'), {
                // メニュー表示させる親要素
                owner: e.target,
                // メニューに表示する項目を設定するキー名
                displayMemberPath: 'header',
                // メニュー処理を実行する項目を設定するキー名
                selectedValuePath: 'cmd',
                // スタイルクラス名
                dropDownCssClass: 'ctx-menu',
                // メニュー表示アイテム
                itemsSource: [
                    { header: '切り取り', cmd: 'ctrlX' },
                    { header: 'コピー',   cmd: 'ctrlC' },
                    { header: '貼り付け', cmd: 'ctrlV' },
                    { header: '全て選択', cmd: 'ctrlA' },
                ],
                // メニューイベント
                command:{
                    // メニューをクリックした時の処理内容
                    executeCommand: (menu) => {
                        let originText = e.target.value;
                        // 選択開始位置
                        let startIndex = e.target.selectionStart;
                        // 選択終了位置
                        let endIndex = e.target.selectionEnd;
                        // メニュー名ごとに処理判別
                        switch (menu.cmd) {
                            // 切り取り
                            case 'ctrlX':
                            originText = originText.substring(startIndex, endIndex);
                            navigator.clipboard.writeText(originText);
                            originText = e.target.value;
                            e.target.value = originText.substring(0, startIndex) + originText.substring(endIndex, originText.length);
                            break;
                            // コピー
                            case 'ctrlC':
                            originText = originText.substring(startIndex, endIndex);
                            navigator.clipboard.writeText(originText);
                            break;
                            // 貼り付け
                            case 'ctrlV':
                            navigator.clipboard.readText().then(function(text){
                                originText = e.target.value;
                                originText = originText.substring(0, startIndex) + originText.substring(endIndex, originText.length);
                                originText = originText.substring(0, startIndex) + text + originText.substring(startIndex, originText.length);
                                e.target.value = originText.slice(0, e.target.maxLength);
                            });
                            break;
                            // 全て選択
                            case 'ctrlA':
                            e.target.select();
                            break;
                            //
                            default:
                            return;
                        }
                    },
                    // メニューの選択可否の判定
                    canExecuteCommand: (menu) => {
                        // 選択開始位置
                        let startIndex = e.target.selectionStart;
                        // 選択終了位置
                        let endIndex = e.target.selectionEnd;
                        switch (menu.cmd) {
                            // 切り取り
                            case 'ctrlX':
                            return startIndex != endIndex;
                            // コピー
                            case 'ctrlC':    
                            return startIndex != endIndex;
                        }
                        return true;
                    }
                }
            });
            // 右クリックした要素が対象要素だった時の処理
            if (contextMenu.owner)
            {
                if(!e.target.readOnly)
                {
                    e.preventDefault();
                    pasteMenu.show(e); // 右クリックメニューの表示
                }
            }
        }, true);
    }
}

//////////////////////
//                  //
//　グリッド操作関係　//
//                  //
//////////////////////

// グリッド上での右クリックメニューの制限
function SetGridContextMenu(grid, e)
{
    // グリッドデータが無い場合は実行しない
    if(grid.itemsSource.length < 1) return; 
    // セル要素取得
    let cellValue = grid.cells.getCellData(grid.hitTest(e).row, grid.hitTest(e).col, true);
    // オリジナル右クリックメニューを表示する対象要素に表示クリックイベントを登録
    let copyMenu = new wijmo.input.Menu(document.createElement('div'), {
        // メニュー表示させる親要素
        owner: grid.hostElement,
        // メニューに表示する項目を設定するキー名
        displayMemberPath: 'header',
        // メニュー処理を実行する項目を設定するキー名
        selectedValuePath: 'cmd',
        // スタイルクラス名
        dropDownCssClass: 'ctx-menu',
        // メニュー表示アイテム
        itemsSource: [ { header: 'コピー', cmd: 'コピー' } ],
        // メニューをクリックした時の処理内容
        itemClicked: () => {
            navigator.clipboard.writeText(cellValue);
        }
    });
    // セルにデータがあればメニューを表示する
    if(cellValue != '')
    {
        copyMenu.itemsSource[0].header = '「' + cellValue + '」をコピーする';
        copyMenu.show(e); // 右クリックメニューの表示
    }
}
// グリッドの色分けデザイン登録
function LoadGridRows(g, rowsPerItem) {    
    for (var i = 0; i < g.rows.length; i++) {
        var row = g.rows[i];
        // 偶数行は色付け
        if (Math.floor(i / rowsPerItem) % 2 != 0)
        {
            row.cssClass = 'row-even';
        }
    }
}
// 選択行のデータID
var selectedRowId;
// 選択行のデータID取得
function SetSelectedRowId(rowId)
{
    selectedRowId = rowId;
}
// グリッドデータ反映＆並び順と選択位置保持
function SortGridData(grid, dataSource, initSortItem, rowsPerItem)
{
    let sortState = null;
    if(grid.itemsSource != null)
    {
        // 現在のソート条件を取得
        sortState = grid.collectionView.sortDescriptions.map(
            function (sd)
            {
                // オブジェクト配列形式で返す
                return { property: sd.property, ascending: sd.ascending }
            }
        );
    }
    // グリッドデータ更新
    grid.itemsSource = dataSource;
    // 選択行のデータIDをグリッドのデータソース内で検索し、一致した行番号を取得する
    let target = grid.itemsSource.findIndex((item) => item.dataId == selectedRowId) * rowsPerItem;
    // データIDが一致した行番号の要素を選択する
    grid.select(new wijmo.grid.CellRange((isNaN(target) || target < 0) ? 0 : target, 0), true);
    // デフォルトのソート条件は指定したキー要素を昇順で並べる
    let sortDesc = new wijmo.collections.SortDescription(initSortItem, true);
    // グリッドデータ更新前にソート条件が指定されていた場合は処理する 
    if(sortState != null && sortState.length > 0)
    {
        // グリッドデータ更新前のソート条件を設定
        sortDesc = new wijmo.collections.SortDescription(sortState[0].property, sortState[0].ascending);
    }
    // ソート条件を適用する
    grid.collectionView.sortDescriptions.push(sortDesc);
    grid.refresh(true);
    // 現在選択行番号を取得
    target = (isNaN(target) || target < 0) ? 0 : grid.selection.row;
    grid.select(new wijmo.grid.CellRange(target, 0), true);
    grid.focus(true);
}

// グリッドデータ反映＆並び順と選択位置保持（MultiRow用）
function SortMultiRowData(grid, dataSource, initSortItem)
{
    SortGridData(grid, dataSource, initSortItem, grid.rowsPerItem);
    return SetSelectedMultiRow(grid, 0);
}

// MultiRow用選択行処理
function SetSelectedMultiRow(grid, selectedRows)
{
    // グリッドデータが無い場合は実行しない
    if(grid.rows.length < 1) return 0;
    // 選択されていた行の選択状態を解除する
    for(let i = 0; i < grid.rowsPerItem; i++) // MultiRowの1レコード当たりの行数分実行
    {
        grid.rows[selectedRows * grid.rowsPerItem + i].isSelected = false;
    }
    // 現在選択行を取得
    let targetRows = Math.floor(grid.selection.row / grid.rowsPerItem);
    // 現在選択行の選択状態を設定する
    for(let i = 0; i < grid.rowsPerItem; i++) // MultiRowの1レコード当たりの行数分実行
    {
        grid.rows[targetRows * grid.rowsPerItem + i].isSelected = true;
    }
    // 現在選択行を表示範囲に移動させる 
    grid.scrollIntoView(targetRows * grid.rowsPerItem + grid.rowsPerItem * 2, -1);
    // 現在選択行を返す
    return targetRows;
}

//////////////////////
//                  //
//　フォーム操作関係　//
//                  //
//////////////////////

// フォームデザインをリセット
function InitFormStyle()
{
    // コードチェックエラー
    for(let i=0; i<$('.code-check').length; i++)
    {
        $('.code-check')[i].className = $('.code-check')[i].className.replace('code-check-error', '');
    }
    // パスワードボタンの設定
    for(let i=0; i<$('.password-btn').length; i++)
    {
        $('.password-btn')[i].className = $('.password-btn')[i].className.replace('-slash', '');
        $('.password-btn')[i].className = $('.password-btn')[i].className.replace('fa-eye', 'fa-eye-slash');
    }
    // パスワード要素の設定
    for(let i=0; i<$('.password-btn').prev("input").length; i++)
    {
        $('.password-btn').prev("input")[i].type = 'password';
    }
    // 必須入力要素にマークを付ける
    var parent = $('#frmNyuryoku input:required').closest('label');
    for(let i = 0; i < parent.length; i++){
        parent[i].className = 'required';
    }
}

//////////////////////
//                  //
//　非同期通信関係　//
//                  //
//////////////////////

// 非同期通信の成功判定
function IsAjaxDataError(data, errorFlg)
{
    // 通信失敗時の処理
    if(errorFlg)
    {
        // エラーメッセージ表示
        let msg = 'error : ' + data['responseJSON']['message'] + '<br>';
        msg += 'file : ' + data['responseJSON']['file'] + '<br>';
        msg += 'line : ' + data['responseJSON']['line'] + '<br>';
        ShowAlertDlg(msg);
        return true;
    }
    // データ処理失敗時の処理
    if(!Array.isArray(data))
    {
        // エラーメッセージ表示
        ShowAlertDlg(data);
        return true;
    }
    // データ処理失敗時の処理
    if(!data[0])
    {
        // エラーメッセージ表示
        ShowAlertDlg(data[1]);
        return true;
    }
    return false;
}

//////////////////
//              //
//　CSV出力関数　//
//              //
//////////////////

// CSV文字列をダウンロード可能なファイルに変換する関数
function ExportCSVFile(data, columns, sortDesc, fileName)
{
    // CSV出力用グリッドの初期化（非表示）
    let grid= new wijmo.grid.FlexGrid('#gridCSV', {
        autoGenerateColumns: false,
        columns: columns,
        itemsSource: data
    });
    //
    if(sortDesc != null) grid.collectionView.sortDescriptions.push(sortDesc);
    // グリッドをCSVにエクスポートします
    var range = new wijmo.grid.CellRange(0, 0, grid.rows.length - 1, grid.columns.length - 1);
    var csv = grid.getClipString(range, true, true);
    //
    let bom  = new Uint8Array([0xEF, 0xBB, 0xBF]);
    let blob = new Blob([bom, csv], {type: 'text/csv'});
    let url = (window.URL || window.webkitURL).createObjectURL(blob);
    //
    var e = document.createElement('a');
    e.download = fileName;
    e.href = url;
    e.style.display = 'none';
    document.body.appendChild(e);
    e.click();
    document.body.removeChild(e);
    // CSV用グリッドリリース
    grid.dispose();
}

///////////////////
//               //
//　その他の関数  //
//               //
///////////////////

// 今日の日付を取得（yyyy/mm/dd形式）
function getNowDate()
{
    return new Date().getFullYear() + '/' + (new Date().getMonth() + 1) + '/' + new Date().getDate();
}

// 今日の日付を取得（yyyymmddhhMMss形式）
function getNowDateTime()
{
    let d = new Date();
    let MM = '' + (d.getMonth() + 1);
    if(MM < 10) MM = '0' + MM; 
    let dd = '' + d.getDate();
    if(dd < 10) dd = '0' + dd;
    let hh = '' + d.getHours();
    if(hh < 10) hh = '0' + hh;
    let mm = '' + d.getMinutes();
    if(mm < 10) mm = '0' + mm;
    let ss = '' + d.getSeconds();
    if(ss < 10) ss = '0' + ss;
    return d.getFullYear() + MM + dd + hh + mm + ss;
}