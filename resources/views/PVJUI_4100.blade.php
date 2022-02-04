{{-- PHP処理 --}}
<?php
    // 状態絞込み
    define("STATUS_SEARCH", array( '',
                                   '未手配受注一覧',
                                   '手配済み受注一覧',
                                   '外注見積状況（依頼・回答・発注）',
                                   '外注納期調整状況（社内手配後）'));
    // 詳細状態絞込み
    // 未手配受注一覧
    define("STATUS_MITEHAI_JUCHU", array( '全て',
                                          '新規',
                                          '再見積要',
                                          'リピート'));
    // 手配済み受注一覧
    define("STATUS_TEHAIZUMI_JUCHU", array( '全て',
                                            '新規',
                                            'リピート',
                                            '一括外注',
                                            '社内手配'));
    // 外注見積状況
    define("STATUS_MITUMORI_GAICHU", array( '依頼分全て',
                                            '見積依頼（依頼書未発行）',
                                            '見積回答（依頼書発行済・回答待ち）',
                                            '発注依頼（回答入力済み・未発注）',
                                            '発注済み'));
    // 外注納期調整状況
    define("STATUS_NOUKI_GAICHU", array( '全て（リピート分・渡り工程外注）',
                                        //  '納期回答依頼（依頼書未発行）',
                                        //  '納期回答（依頼書発行済み・回答待ち）',
                                         '発注依頼（回答入力済み・未発注）',
                                         '発注済み'));
    // 製作振分
    define("SEISAKU_KBN", array( '未手配',
                                 '外注手配',
                                 '社内加工'));
    // 手配ステータス
    define("TEHAI_STATUS", array( '未',
                                  '見積依頼',
                                  '発注指示',
                                  '再見積要',
                                  '中止'));
    // 「loginId」が送信されていなければ0を設定
    if(!isset($loginId)) $loginId = 0;

    // 検索フォームの高さ
    $kensakuHight = '250px';
    $kensakuLeftRowWidth = '6em';
    $kensakuRightRowWidth = '6em';
    $tehaiHight = '400px';
?>

{{-- 共通レイアウト呼び出し --}}
{{--「base_master.blede.php」・・・マスタ画面の共通テンプレートデザイン --}}
@extends('templete.header.juchu.base_juchu_tehai')

{{-- 「検索フォーム」 --}}
@section('kensaku')
{{-- 検索フォーム全体 --}}
<form id="frmKensaku" name="frmKensaku" class="flex-box" style="height:<?php echo $kensakuHight ?>;">
    {{-- 一列目 --}}
    <div class="form-column" style="width:50%;">
        {{-- 「状態絞込み」 --}}
        <label>
            <span style="width:6.5em;">{{__('状態絞込み')}}</span>
            <!-- 「状態絞込み」コンボボックス本体 -->
            <div id="cmbStatusSearch" style="width:20em; margin-left:5px;"></div>
            <!-- 「状態絞込み」フォーム送信データ -->
            <input name="dataStatusSearch" type="hidden">
        </label>
        {{-- 「詳細状態絞込み」 --}}
        <label>
            <span style="width:6.5em;"></span>
            <!-- 「詳細状態絞込み」コンボボックス本体 -->
            <div id="cmbDetailStatusSearch" style="width:27em; margin-left:5px;"></div>
            <!-- 「詳細状態絞込み」フォーム送信データ -->
            <input name="dataDetailStatusSearch" type="hidden">
        </label>
        {{-- 「受注日」 --}}
        <label>
            <span style="width:<?php echo $kensakuLeftRowWidth ?>; margin-right:5px;">{{__('juchu_date')}}</span>
            <input id="dataJuchuStartDate" name="dataJuchuStartDate" type="hidden" style="width:9em;">
            <span style="margin:0 5px;">～</span>
            <input id="dataJuchuEndDate" name="dataJuchuEndDate" type="hidden" style="width:9em;">
        </label>
        {{-- 「見積依頼日」 --}}
        <label id="searchMitsumoriIrai">
            <span style="width:<?php echo $kensakuLeftRowWidth ?>; margin-right:5px;">{{__('mitsumori_irai_date')}}</span>
            <input id="dataMitsumoriIraiStartDate" name="dataMitsumoriIraiStartDate" type="hidden" style="width:9em;">
            <span style="margin:0 5px;">～</span>
            <input id="dataMitsumoriIraiEndDate" name="dataMitsumoriIraiEndDate" type="hidden" style="width:9em;">
        </label>
        {{-- 「見積回答期限」 --}}
        <label id="searchMitsumoriKaitou">
            <span style="width:<?php echo $kensakuLeftRowWidth ?>; margin-right:5px;">{{__('mitsumori_kaitou_kigen_date')}}</span>
            <input id="dataMitsumoriKaitouStartDate" name="dataMitsumoriKaitouStartDate" type="hidden" style="width:9em;">
            <span style="margin:0 5px;">～</span>
            <input id="dataMitsumoriKaitouEndDate" name="dataMitsumoriKaitouEndDate" type="hidden" style="width:9em;">
        </label>
        {{-- 「一括外注候補」 --}}
        <label id="searchIkkatsuGaichuKouho">
            <span style="width:<?php echo $kensakuLeftRowWidth ?>; margin-right:5px;">{{__('ikkatsu_gaichu_kouho_kbn')}}</span>
            <input id="dataIkkatsuGaichuKouhoKbn" name="dataIkkatsuGaichuKouhoKbn" class="form-check-input" type="checkbox" value="0">
            <label style="margin-left:5px;" class="form-check-label" for="dataIkkatsuGaichuKouhoKbn">{{__('チェックが付いた（一括外注候補）のみ表示')}}</label>
        </label>
    </div>
    {{-- 二列目 --}}
    <div class="form-column" style="width:50%;">
        {{-- 「受注番号」 --}}
        <label>
            <span style="width:6em;">{{__('juchu_no')}}</span>
            <input name="dataStartJuchuNo" class="form-control" type="text" style="width:14em;">
            <span style="margin:0 5px;">～</span>
            <input name="dataEndJuchuNo" class="form-control" type="text" style="width:14em;">
        </label>
        {{-- 「得意先CD」 --}}
        <label>
            <span style="width:4.5em;">{{__('tokuisaki_cd')}}</span>
            <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                <input name="dataTokuisakiCd" class="form-control" type="text" maxlength="6" autocomplete="off"
                    style="width:9em;">
                {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                <i class="fas fa-search search-btn"></i>
            </span>
            {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
            <input name="dataTokuisakiName" class="form-control" type="text" style="width:22em;" onfocus="blur();"
                readonly>
        </label>
        {{-- 「客先注文番号」 --}}
        <label>
            <span style="width:6em;">{{__('tokuisaki_chumon_no')}}</span>
            <input name="dataChumonNo" class="form-control" type="text" maxlength="30" autocomplete="off"
                style="width:27em;">
        </label>
        {{-- 「外注先CD」 --}}
        <label>
            <span style="width:4.5em;">{{__('gaichusaki_cd')}}</span>
            <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                <input name="dataGaichusakiCd" class="form-control" type="text" maxlength="6" autocomplete="off"
                    style="width:9em;">
                {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                <i class="fas fa-search search-btn"></i>
            </span>
            {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
            <input name="dataGaichusakiName" class="form-control" type="text" style="width:22em;" onfocus="blur();"
                readonly>
        </label>
        {{-- 「品目CD」 --}}
        <label>
            <span style="width:4.5em;">{{__('hinmoku_cd')}}</span>
            <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                <input name="dataHinmokuCd" class="form-control" type="text" maxlength="6" autocomplete="off"
                    style="width:9em;">
                {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                <i class="fas fa-search search-btn"></i>
            </span>
            {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
            <input name="dataHinmokuCodeName" class="form-control" type="text" style="width:22em;" onfocus="blur();"
                readonly>
        </label>
        {{-- 表示件数 --}}
        <div class="flex-box flex-end" style="margin-top:auto;">
            <div class="base-color-front" style="color:black;">
                <span id="zenkenCnt" style="margin: 0 10px;"></span>{{__('件')}}{{__('を表示')}}
            </div>
        </div>
    </div>

</form>
@endsection

{{-- 「入力ダイアログ」 --}}
@section('nyuryoku') 
<!-- 未手配受注フォーム群 -->
<!-- <div id="statusMitehaiJuchu"> -->
<!-- 一括外注指示フォーム -->
<div id="frmGaichuShiji" class="flex-box flex-column" style="padding:5px 10px;">
    <!-- 基本設定 -->
    <div class="flex-box flex-between item-start">
        <!-- 一列目 -->
        <div class="flex-box flex-start flex-column item-start">
            <div class="form-column">
                {{-- 「受注日」 --}}
                <label>
                    <span style="width:5.5em; margin-right:5px;">{{__('juchu_date')}}</span>
                    <input id="dataJuchuDate" name="dataJuchuDate" type="hidden" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「受注番号」 --}}
                <label>
                    <span style="width:5.5em;">{{__('juchu_no')}}</span>
                    <input id="dataJuchuNo" name="dataJuchuNo" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「得意先CD」 --}}
                <label>
                    <span style="width:5.8em;">{{__('tokuisaki_cd')}}</span>
                    <input id="dataTokuisakiCd" name="dataTokuisakiCd" disabled>
                    <input id="dataTokuisakiName" name="dataTokuisakiName" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「品目CD」 --}}
                <label>
                    <span style="width:5.8em;">{{__('hinmoku_cd')}}</span>
                    <input id="dataHinmokuCd" name="dataHinmokuCd" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「受注区分」 --}}
                <label>
                    <span style="width:5.8em;">{{__('juchu_kbn')}}</span>
                    <input id="dataJuchuKbn" name="dataJuchuKbn" type="hidden">
                    <input id="dataJuchuKbnName" name="dataJuchuKbnName" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「新規リピート区分」 --}}
                <label>
                    <span style="width:5.8em;">{{__('shinki_repeat_kbn')}}</span>
                    <input id="dataShinkiRepeatKbn" name="dataShinkiRepeatKbn" type="hidden">
                    <input id="dataShinkiRepeatKbnName" name="dataShinkiRepeatKbnName" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「希望納期」 --}}
                <label>
                    <span style="width:5.8em;">{{__('kibou_nouki_date')}}</span>
                    <input id="dataKibouNoukiDate" name="dataKibouNoukiDate" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「受注数量」*受注データ --}}
                <label>
                    <span style="width:5.8em;">{{__('juchu_qty')}}</span>
                    <input id="dataJuchuQty" name="dataJuchuQty">
                </label>
            </div>
            <div class="form-column">
                {{-- 「手配数量」*受注データ --}}
                <label>
                    <span style="width:5.8em;">{{__('tehai_qty')}}</span>
                    <input id="dataTehaiQty" name="dataTehaiQty">
                </label>
            </div>
            <div class="form-column">
                {{-- N --}}
                <label>
                    <span></span>
                </label>
            </div>
            <div class="form-column" style="width: 100%;">
                <!-- 「見積依頼有無」 -->
                <div class="flex-box" style="height: 2.5em; align-items: center;">
                    <span style="width:7em;">{{__('tehai_status')}}</span>
                    <div style="width: 60%; display: flex; margin-left: 10px;">
                        <div class="form-check" style="width: 60%;">
                            <input name="rdoTehaiStatus" id="tehaiStatus1" class="form-check-input rdoTehaiStatus" 
                                type="radio" value="1" checked>
                            <label class="form-check-label" for="tehaiStatus1" style="width: 100%;">
                                <?php echo TEHAI_STATUS[1] ?></label>
                        </div>
                        <div class="form-check tehaiStatus2" style="width: 40%;">
                            <input name="rdoTehaiStatus" id="tehaiStatus2" class="form-check-input rdoTehaiStatus" 
                                type="radio" value="2">
                            <label class="form-check-label" for="tehaiStatus2" style="width: 100%;">
                                <?php echo TEHAI_STATUS[2] ?></label>
                        </div>
                        <input name="dataTehaiStatus" type="hidden" value="0">
                    </div>
                </div>
            </div>
            <div class="form-column">
                {{-- N --}}
                <label>
                    <span></span>
                </label>
            </div>
            <div class="form-column">
                <!-- 「相見候補」 -->
                <label>
                    <span style="width:6em;">{{__('aimitsu_kouho')}}</span>
                    <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                        <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                        <input name="dataGaichuTehaiKouhoCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off"
                            style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                        <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                        <i class="fas fa-search search-btn"></i>
                    </span>
                    <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                    <input name="dataGaichuTehaiKouhoName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                </label>
            </div>
            <div class="form-column">
                <!-- 「一社指定」 -->
                <label>
                    <span style="width:6em;">{{__('issya_sitei')}}</span>
                    <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                        <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                        <input name="dataGaichuTehaiCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off"
                            style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                        <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                        <i class="fas fa-search search-btn"></i>
                    </span>
                    <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                    <input name="dataGaichuTehaiName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                </label>
            </div>
            <!-- <div class="form-column"> -->
                <!-- <table align="center" width="90%" cellpadding="5" rules="all">
                    <thead>
                        <tr align="center">
                            <th>発注数</th>
                            <th>発注単価</th>
                            <th>発注金額</th>
                            <th>発注納期</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr align="center">
                            <td> 1</td>
                            <td> 2</td>
                            <td> 3</td>
                            <td> 4</td>
                        </tr>
                    </tbody>
                </table> -->
            <!-- </div> -->
            <div class="form-column">
                {{-- 「発注数量」 --}}
                <label>
                    <span style="width:5.8em;">{{__('hachu_qty')}}</span>
                    <input id="dataHachuQty" name="dataHachuQty">
                </label>
            </div>
            <div class="form-column">
                {{-- 「発注単価」 --}}
                <label>
                    <span style="width:5.8em;">{{__('hachu_tanka')}}</span>
                    <input id="dataHachuTanka" name="dataHachuTanka">
                </label>
            </div>
            <div class="form-column">
                {{-- 「発注金額」 --}}
                <label>
                    <span style="width:5.8em;">{{__('hachu_kin')}}</span>
                    <input id="dataHachuKin" name="dataHachuKin">
                </label>
            </div>
            <div class="form-column">
                {{-- 「発注納期」 --}}
                <label>
                    <span style="width:5.8em;">{{__('hachu_nouki_date')}}</span>
                    <input id="dataHachuNoukiDate" name="dataHachuNoukiDate" type="hidden">
                </label>
            </div>
            {{-- 「製作振分」--}}
            <input id="dataSeisakuKbn" name="dataSeisakuKbn" type="hidden">
        </div>
    </div>
</div>

<!-- 社内加工指示フォーム -->
<div id="frmShanaiKakouShiji" class="flex-box flex-column" style="padding:5px 10px;">
    <!-- 基本設定 -->
    <div class="flex-box flex-between item-start">
        <!-- 一列目 -->
        <div class="flex-box flex-start flex-column item-start">
            <div class="form-column">
                {{-- 「受注日」 --}}
                <label>
                    <span style="width:5.5em; margin-right:5px;">{{__('juchu_date')}}</span>
                    <input id="dataJuchuDate" name="dataJuchuDate" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「受注番号」 --}}
                <label>
                    <span style="width:5.5em;">{{__('juchu_no')}}</span>
                    <input id="dataJuchuNo" name="dataJuchuNo" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「品目CD」 --}}
                <label>
                    <span style="width:5.8em;">{{__('hinmoku_cd')}}</span>
                    <input id="dataHinmokuCd" name="dataHinmokuCd" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「希望納期」 --}}
                <label>
                    <span style="width:5.8em;">{{__('kibou_nouki_date')}}</span>
                    <input id="dataKibouNoukiDate" name="dataKibouNoukiDate" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- N --}}
                <label>
                    <span></span>
                </label>
            </div>
        </div>
        <!-- 二列目 -->
        <div class="flex-box flex-start flex-column item-start" style="padding-left:10px; width:30em;">
            <div class="form-column">
                {{-- 「得意先CD」 --}}
                <label>
                    <span style="width:5.8em;">{{__('tokuisaki_cd')}}</span>
                    <input id="dataTokuisakiCd" name="dataTokuisakiCd" disabled>
                    <input id="dataTokuisakiName" name="dataTokuisakiName" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「受注区分」 --}}
                <label>
                    <span style="width:5.8em;">{{__('juchu_kbn')}}</span>
                    <input id="dataJuchuKbn" name="dataJuchuKbn" type="hidden">
                    <input id="dataJuchuKbnName" name="dataJuchuKbnName" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「まとめ受注」 --}}
                <label>
                    <span style="width:5.8em;">{{__('matome_juchu')}}</span>
                    <input id="dataMatomeKbn" name="dataMatomeKbn" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「受注数量」*受注データ --}}
                <label>
                    <span style="width:5.8em;">{{__('juchu_qty')}}</span>
                    <input id="dataJuchuQty" name="dataJuchuQty" disabled>
                </label>
            </div>
            <div class="form-column">
                {{-- 「手配数量」*受注データ --}}
                <label>
                    <span style="width:5.8em;">{{__('tehai_qty')}}</span>
                    <input id="dataTehaiQty" name="dataTehaiQty" disabled>
                </label>
            </div>
        </div>
    </div>

    <!-- tab setting -->
    <div class="tabs">
        <input id="tab0" type="radio" name="tab_item" checked>
        <label class="tab_item" for="tab0" style="width:30%; display: flex; justify-content: space-between; 
            margin-left: 1%; padding-left: 1%;">手配工程</label>
        <input id="tab1" type="radio" name="tab_item">
        <label class="tab_item" for="tab1" style="width:30%; display: flex; justify-content: space-between; 
            margin-left: 1%; padding-left: 1%;">手配工程負荷状況</label>

        <!-- tab0 -->
        <div class="tab_content" id="tab0_content">
            <!--手配工程データ一覧-->
            <div id="gridTehaiKoutei" style="width:100%; height:<?php echo $tehaiHight ?>;"></div>
        </div>
        <!-- tab1 -->
        <div class="tab_content " id="tab1_content">
            <!--手配工程負荷データ一覧-->
            <div id="gridKoutei" style="width:100%; height:<?php echo $tehaiHight ?>;"></div>
        </div>
    </div>
</div>
<!-- </div> -->

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

    /* 詳細状態絞込み選択値 */
    var detailStatusSearch = [];
    /* 詳細状態絞込みデータ登録値 */
    var detailStatusSearchValue = [];
    /* コンボボックス宣言 */
    var cmbDetailStatusSearch = new wijmo.input.ComboBox('#cmbDetailStatusSearch', { isEditable: false });

    /* 状態絞込み選択値 */
    var statusSearch = [];
    /* 状態絞込みデータ登録値 */
    var statusSearchValue = [];
    let changeColumns =[];
    /* 状態絞込みの元データに入力がある場合は選択値として格納 */
    SetStatusSearch();
    /* コンボボックス宣言 */
    var cmbStatusSearch = new wijmo.input.ComboBox('#cmbStatusSearch', { 
        /**コンボボックスの変更処理 */
        selectedIndexChanged: (sender) => {
            /**詳細状態絞込み選択値を変更 */
            fncChangeDetailStatus(sender.selectedIndex);
            cmbDetailStatusSearch.itemsSource = detailStatusSearch;
            /**検索項目を変更 */
            fncChangeSearchForm(sender.selectedIndex);
            /**コントロール表示を変更 */
            fncChangeControl(sender.selectedIndex);
            /**Grid表示を変更 */
            if (typeof gridMaster !== 'undefined') {
                InitGrid();
            }
            switch(sender.selectedIndex){
                /**未手配 */
                case 0:
                /**手配済み */
                case 1:
                /**外注納期調整 */
                case 3:
                    onDisplay("gridMaster");
                    offDisplay("gridSub");
                    break;
                /**外注見積 */
                case 2:
                    offDisplay("gridMaster");
                    onDisplay("gridSub");
                    break;
            }
            /**グリッドデータの表示 */
            $('#btnHyouji').click();
        //
        },
        itemsSource: statusSearch,
        isEditable: false
    });

    {{-- カレンダー宣言 --}}
    {{-- 有効期間（自） --}}
    // var dateStart = new wijmo.input.InputDate('#dataStartDate');
    var dateJuchu = new wijmo.input.InputDate('#dataJuchuDate', {isRequired: false, isDisabled: true});
    var dateKibouNouki = new wijmo.input.InputDate('#dataKibouNoukiDate', {isRequired: false, isDisabled: true});
    var dateJuchuStart = new wijmo.input.InputDate('#dataJuchuStartDate', {
        isRequired: false,
        valueChanged: (sender) => { CheckJuchuDate(); }
    });
    var dateJuchuEnd = new wijmo.input.InputDate('#dataJuchuEndDate', {
        isDisabled: false,
        isRequired: false,
        valueChanged: (sender) => { CheckJuchuDate(); }
    });
    // var dateMitsumoriIrai = new wijmo.input.InputDate('#dataMitsumoriIraiDate');
    var dateMitsumoriIraiStart = new wijmo.input.InputDate('#dataMitsumoriIraiStartDate', {
        isRequired: false,
        valueChanged: (sender) => { CheckMitsumoriIraiDate(); }
    });
    var dateMitsumoriIraiEnd = new wijmo.input.InputDate('#dataMitsumoriIraiEndDate', {
        isRequired: false,
        valueChanged: (sender) => { CheckMitsumoriIraiDate(); }
    });
    // var dateMitsumoriKaitou = new wijmo.input.InputDate('#dataMitsumoriKaitouDate');
    var dateMitsumoriKaitouStart = new wijmo.input.InputDate('#dataMitsumoriKaitouStartDate', {
        isRequired: false,
        valueChanged: (sender) => { CheckMitsumoriKaitouDate(); }
    });
    var dateMitsumoriKaitouEnd = new wijmo.input.InputDate('#dataMitsumoriKaitouEndDate', {
        isRequired: false,
        valueChanged: (sender) => { CheckMitsumoriKaitouDate(); }
    });

    // var dateNouki = new wijmo.input.InputDate('#dataNoukiDate', { isRequired: false, value: null });
    // var dateNoukiStart = new wijmo.input.InputDate('#dataNoukiStartDate', {
    //     isRequired: false, value: null,
    //     valueChanged: (sender) => { CheckNoukiDate(); }
    // });
    // var dateNoukiEnd = new wijmo.input.InputDate('#dataNoukiEndDate', {
    //     isRequired: false, value: null,
    //     valueChanged: (sender) => { CheckNoukiDate(); }
    // });
    // var dateShukka = new wijmo.input.InputDate('#dataShukkaDate', { isRequired: false, value: null });
    var numJuchuQty = new wijmo.input.InputNumber('#dataJuchuQty', {
        isRequired: false, isDisabled: true, format: 'n0', min: 0, max: 9999999999999999
    });
    // var numJuchuTanka = new wijmo.input.InputNumber('#numJuchuTanka', {
    //     isRequired: false, format: 'n2', min: 0, max: 9999999999999999,
    //     valueChanged: (sender) => { SumJuchuKin(); }
    // });
    // var numJuchuKin = new wijmo.input.InputNumber('#numJuchuKin', {
    //     isRequired: false, isDisabled: true, format: 'n2', min: 0, max: 9999999999999999
    // });
    var numTehaiQty = new wijmo.input.InputNumber('#dataTehaiQty', {
        isRequired: false, isDisabled: true, format: 'n0', min: 0, max: 9999999999999999
    });
    var rdoTehaiStatus = document.getElementsByName('#dataTehaiStatus');



    var numHachuQty = new wijmo.input.InputNumber('#dataHachuQty', {
        isRequired: false, format: 'n0', min: 0, max: 9999999999999999
    });
    var numHachuTanka = new wijmo.input.InputNumber('#dataHachuTanka', {
        isRequired: false, format: 'n0', min: 0, max: 9999999999999999
    });
    var numHachuKin = new wijmo.input.InputNumber('#dataHachuKin', {
        isRequired: false, format: 'n0', min: 0, max: 9999999999999999
    });
    var dateHachuNouki = new wijmo.input.InputDate('#dataHachuNoukiDate', {isRequired: false});



    {{-- 権限区分選択値 --}}
    {{-- コンボボックス宣言 --}}
    // var cmbKaritankaKbn = new wijmo.input.ComboBox('#cmbKaritankaKbn', { isRequired: false, itemsSource: ['0:確定単価','1:仮単価'] });
    {{-- カテゴリー種別 --}}
    var juchuKbn = [];
    {{-- 分類管理CD --}}
    // var juchuKbnCd = [];
    // var cmbJuchuKbn = new wijmo.input.ComboBox('#cmbJuchuKbn', { isRequired: false　});

    // var cmbMatomeKbn = new wijmo.input.ComboBox('#cmbMatomeKbn', { isRequired: false, itemsSource: ['0:単体受注','1:同一品目まとめ','2:異品目まとめ'] });

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

        // {{-- 受注区分初期処理 --}}
        // AjaxData("{{ url('/inquiry/1300') }}", { 'dataTargetCd': 'JUCHUKBN' }, fncJushinJuchuKbnData);
        
        {{-- グリッドデータの表示 --}}
        $('#btnHyouji').click();
    }
    {{-- グリッド共有変数 --}}
    var gridMaster;
    var gridSub;
    {{-- グリッド初期処理--}}
    function InitGrid()
    {
        {{-- FlexGridのレイアウト設定 --}}
        let columns = [];
        switch(cmbStatusSearch.selectedIndex){
            /**未手配 */
            case 0:
            {{-- FlexGridのレイアウト設定 --}}
                columns = [
                    { binding: 'dataGaichuflg', header : "{{__('gai')}}", width  : 100 },
                    { binding: 'dataJuchuDate', header : "{{__('juchu_date')}}", width  : 100 },
                    { binding: 'dataJuchuNo', header : "{{__('juchu_no')}}", width  : 100 },
                    { binding: 'dataTokuisakiCd', header : "{{__('tokuisaki_cd')}}", width  : 100 },
                    { binding: 'dataJuchuKbnName', header : "{{__('juchu_kbn_name')}}", width  : 100 },
                    { binding: 'dataSeisakuKbn', header : "{{__('seisaku_kbn')}}", width  : 100 },
                    { binding: 'dataChumonNo1', header : "{{__('tokuisaki_chumon_no1')}}", width  : 100 },
                    { binding: 'dataMatomeKbn', header: "{{__('matome_kbn')}}", format: 'n', width: 100 },
                    { binding: 'dataJuchuQty', header: "{{__('juchu_qty')}}", format: 'n', width: 100 },
                    { binding: 'dataHinmokuCd', header : "{{__('hinmoku_cd')}}", width  : 200 },
                    { binding: 'dataHinmokuName', header : "{{__('hinmoku_name')}}", width  : 200 },
                    { binding: 'dataZumenNo', header : "{{__('zumen_no')}}", width  : 200 }
                ]; 
                break;
            /**手配済み */
            case 1:
            /**外注納期調整 */
            case 3:
                columns = [
                    { binding: 'dataGaichuflg', header : "{{__('gai')}}", width  : 100 },
                    { binding: 'dataJuchuDate', header : "{{__('juchu_date')}}", width  : 100 },
                    { binding: 'dataJuchuNo', header : "{{__('juchu_no')}}", width  : 100 },
                    { binding: 'dataTokuisakiCd', header : "{{__('tokuisaki_cd')}}", width  : 100 },
                    { binding: 'dataJuchuKbnName', header : "{{__('juchu_kbn_name')}}", width  : 100 },
                    { binding: 'dataSeisakuKbn', header : "{{__('seisaku_kbn')}}", width  : 100 },
                    { binding: 'dataChumonNo1', header : "{{__('tokuisaki_chumon_no1')}}", width  : 100 },
                    { binding: 'dataGaichusakiCD', header: "{{ __('gaichusaki_cd') }}", width: 150 },
                    { binding: 'dataGaichusakiName', header: "{{ __('gaichusaki_name') }}", width: 200 },
                    { binding: 'dataMatomeKbn', header: "{{__('matome_kbn')}}", format: 'n', width: 100 },
                    { binding: 'dataJuchuQty', header: "{{__('juchu_qty')}}", format: 'n', width: 100 },
                    { binding: 'dataHinmokuCd', header : "{{__('hinmoku_cd')}}", width  : 200 },
                    { binding: 'dataHinmokuName', header : "{{__('hinmoku_name')}}", width  : 200 },
                    { binding: 'dataZumenNo', header : "{{__('zumen_no')}}", width  : 200 }
                ]; 
                break;
            /**外注見積 */
            case 2:
                {{-- FlexGridのレイアウト設定 --}}
                columns = [
                    { cells: [{ binding: 'dataJuchuDate', header: "{{ __('juchu_date') }}", width: 150 },
                              { binding: 'dataJuchuNo', header: "{{ __('juchu_no') }}" }]},
                    { cells: [{ binding: 'dataShinkiRepeatKbn', header: "{{ __('shinki_repeat_kbn') }}", width: 150 },
                              { binding: 'dataJuchuKbnName', header: "{{ __('juchu_kbn') }}"}]},
                    { cells: [{ binding: 'dataKaitouStatus', header: "{{ __('kaitou_status') }}", width: 150 }]},
                    { cells: [{ binding: 'dataHinmokuCode', header: "{{ __('hinmoku_cd') }}", width: 300 },
                              { binding: 'dataHinmokuName', header: "{{ __('hinmoku_name') }}" }]},
                    { cells: [{ binding: 'dataGaichusakiCD', header: "{{ __('gaichusaki_cd') }}", width: 200 },
                              { binding: 'dataGaichusakiName', header: "{{ __('gaichusaki_name') }}" }]},
                    { cells: [{ binding: 'dataKaitouDate', header: "{{ __('mitsumori_kaitou_kigen_date') }}", width: 150 },
                              { binding: 'dataKibouNoukiDate', header: "{{ __('kibou_nouki_date') }}",}]},

                    { cells: [{ binding: 'dataKaitouTanka', header: "{{ __('kaitou_tanka') }}", width: 150 }]},
                    { cells: [{ binding: 'dataKaitouNouki', header: "{{ __('kaitou_nouki') }}", width: 150 }]},

                    { cells: [{ binding: 'dataTehaiQty', header: "{{ __('tehai_qty') }}", width: 100 },
                              { binding: 'dataJuchuQty', header: "{{ __('juchu_qty') }}" }]},
                    { cells: [{ binding: 'dataTsukiKeiQty', header: "{{ __('tsuki_kei_qty') }}", width: 100 },
                              { binding: 'dataKikanKeiQty', header: "{{ __('kikann_kei_qty') }}" }]},
                    { cells: [{ binding: 'dataTsukiKeiKin', header: "{{ __('tsuki_kei_kin') }}", width: 150 },
                              { binding: 'dataKikanKeiKin', header: "{{ __('kikann_kei_kin') }}" }]}
                ];
                break;
        }

        {{-- グリッドの設定 --}}
        let gridOption = {};
        switch(cmbStatusSearch.selectedIndex){
            /**未手配 */
            case 0:
            /**手配済み */
            case 1:
            /**外注納期調整 */
            case 3:
                gridOption = {
                    {{-- レイアウト設定 --}}
                    columns: columns,
                    {{-- 選択スタイル（セル単位） --}}
                    selectionMode: wijmo.grid.SelectionMode.Row,
                    {{-- セル編集（無効） --}}
                    isReadOnly: true,
                    {{-- デフォルト行スタイル（0行ごとに色付け） --}}
                    alternatingRowStep: 0,
                    {{-- グリッド上でのEnterキーイベント（無効） --}}
                    keyActionEnter: wijmo.grid.KeyAction.None,
                    {{-- グリッド自動生成 --}}
                    autoGenerateColumns: false,
                    {{-- セル読み込み時のイベント --}}
                    loadedRows: function (s, e)
                    {
                        {{-- 任意の色でセルを色付け
                            ※rowPerItemでMultiRowの1レコード当たりの行数を取得
                            ※common_function.js参照 --}}
                        LoadGridRows(s, 1);
                    }
                } 
                break;
            /**外注見積 */
            case 2:
                gridOption = {
                    {{-- レイアウト設定 --}}
                    layoutDefinition: columns,
                    // {{-- 選択スタイル（セル単位） --}}
                    // selectionMode: wijmo.grid.SelectionMode.Row,
                    {{-- セル編集（無効） --}}
                    isReadOnly: false,
                    {{-- デフォルト行スタイル（0行ごとに色付け） --}}
                    alternatingRowStep: 0,
                    {{-- グリッド上でのEnterキーイベント（無効） --}}
                    keyActionEnter: wijmo.grid.KeyAction.None,
                    {{-- グリッド自動生成 --}}
                    autoGenerateColumns: false,
                    {{-- セル読み込み時のイベント --}}
                    loadedRows: function (s, e)
                    {
                        {{-- 任意の色でセルを色付け
                            ※rowPerItemでMultiRowの1レコード当たりの行数を取得
                            ※common_function.js参照 --}}
                        LoadGridRows(s, 2);
                    }
                } 
                break;
        }       
        {{-- グリッド宣言 --}}
        /**statusによってGridを変更 */
        switch(cmbStatusSearch.selectedIndex){
            /**未手配 */
            case 0:
            /**手配済み */
            case 1:
            /**外注納期調整 */
            case 3:
                if (typeof gridMaster !== 'undefined') {
                    gridMaster.initialize(gridOption);
                    // console.log('FlexGrid initialize') // fuga
                } else {
                    gridMaster = new wijmo.grid.FlexGrid('#gridMaster', gridOption);
                    // console.log('new FlexGrid');          
                }
                break;
            /**外注見積 */
            case 2:
                if (typeof gridSub !== 'undefined') {
                    gridSub.initialize(gridOption);
                    // console.log('MultiRow initialize') // fuga
                } else {
                    gridSub = new wijmo.grid.multirow.MultiRow('#gridSub', gridOption);
                    // console.log('new MultiRow');          
                }
                break;
        }
        {{-- グリッド関連のイベント登録 --}}
        if (typeof gridMaster !== 'undefined') {
            {{-- グリッドの親要素 --}}
            let host = gridMaster.hostElement;

            {{-- グリッドの「右クリック」イベント --}}
            gridMaster.addEventListener(host, 'contextmenu', function (e)
            {
                if(gridMaster.itemsSource.length < 1 ||
                gridMaster.collectionView.currentItem == null) return; 
                {{-- セル上での右クリックメニュー表示 ※common_function.js参照 --}}
                SetGridContextMenu(gridMaster, e);
                {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
                if(gridMaster.itemsSource.length < 1) return;
                {{-- クリックした位置を選択 --}}
                gridMaster.select(new wijmo.grid.CellRange(gridMaster.hitTest(e).row, 0), true);
                console.log('gridMaster contextmenu');
            });

            {{-- グリッドの「ダブルクリック」イベント --}}
            gridMaster.addEventListener(host, 'dblclick', function (e)
            {
                {{-- 選択したセルがヘッダー要素でない場合は「修正」ボタンと同じ処理 --}}
                if(gridMaster.hitTest(e).cellType == wijmo.grid.CellType.Cell) $('#btnShusei').click();
                console.log('gridMaster dblclick');
            });

            {{-- グリッドの「キーボード」イベント --}}
            gridMaster.addEventListener(host, 'keydown', function (e)
            {
                {{-- 「Enterキー」は「修正」ボタンと同じ処理 --}}
                if(e.keyCode == KEY_ENTER)
                {
                    $('#btnShusei').click();
                    {{-- キーボードイベント二重起動防止 --}}
                    windowKeybordFlg = false;
                }
                console.log('gridMaster keydown');
            });
        }
        if (typeof gridSub !== 'undefined') {
            {{-- グリッドの親要素 --}}
            let hostSub = gridSub.hostElement;

            {{-- グリッドの「右クリック」イベント --}}
            gridSub.addEventListener(hostSub, 'contextmenu', function (e)
            {
                if(gridSub.itemsSource.length < 1 ||
                gridSub.collectionView.currentItem == null) return; 
                {{-- セル上での右クリックメニュー表示 ※common_function.js参照 --}}
                SetGridContextMenu(gridSub, e);
                {{-- グリッドに選択する行が無い場合は処理をスキップ --}}
                if(gridSub.itemsSource.length < 1) return;
                {{-- クリックした位置を選択 --}}
                gridSub.select(new wijmo.grid.CellRange(gridSub.hitTest(e).row, 0), true);
                console.log('gridSub contextmenu');
            });

            {{-- グリッドの「ダブルクリック」イベント --}}
            gridSub.addEventListener(hostSub, 'dblclick', function (e)
            {
                {{-- 選択したセルがヘッダー要素でない場合は「修正」ボタンと同じ処理 --}}
                if(gridSub.hitTest(e).cellType == wijmo.grid.CellType.Cell) $('#btnShusei').click();
                console.log('gridSub dblclick');
            });

            {{-- グリッドの「キーボード」イベント --}}
            gridSub.addEventListener(hostSub, 'keydown', function (e)
            {
                {{-- 「Enterキー」は「修正」ボタンと同じ処理 --}}
                if(e.keyCode == KEY_ENTER)
                {
                    $('#btnShusei').click();
                    {{-- キーボードイベント二重起動防止 --}}
                    windowKeybordFlg = false;
                }
                console.log('gridSub keydown');
            });
        }
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
                if(kensakuData[i].name == 'dataChumonNo' ||
                   kensakuData[i].name == 'dataTokuisakiCd' ||
                   kensakuData[i].name == 'dataHinmokuCd' ||
                   kensakuData[i].name == 'dataHinmokuName'){
                    soushinData[kensakuData[i].name] = (kensakuData[i].value != '') ? (kensakuData[i].value + LIKE_VALUE_BOTH) : '';
                }else{
                    soushinData[kensakuData[i].name] = (kensakuData[i].value != '' && kensakuData[i].value != null) ? kensakuData[i].value : null;
                }
            }
        }
        {{-- 「データ更新中」表示 --}}
        ShowPopupDlg("{{ __('データ更新中') }}");
        //
        switch(cmbStatusSearch.selectedIndex){
            /**未手配 */
            case 0:
                {{-- グリッドのデータ受信 --}}
                AjaxData("{{ url('/juchu/4100') }}", soushinData, fncJushinGridData);
                {{-- 検索件数の取得フラグの送信データを追加 --}}
                soushinData["dataCntFlg"] = true;
                {{-- 検索件数のデータ受信 --}}
                AjaxData("{{ url('/juchu/4100') }}", soushinData, fncJushinDataCnt);
                break;
            /**手配済み */
            case 1:
                {{-- グリッドのデータ受信 --}}
                AjaxData("{{ url('/juchu/4110') }}", soushinData, fncJushinGridData);
                {{-- 検索件数の取得フラグの送信データを追加 --}}
                soushinData["dataCntFlg"] = true;
                {{-- 検索件数のデータ受信 --}}
                AjaxData("{{ url('/juchu/4110') }}", soushinData, fncJushinDataCnt);
                break;
            /**外注見積 */
            case 2:
                {{-- グリッドのデータ受信 --}}
                AjaxData("{{ url('/juchu/4120') }}", soushinData, fncJushinGridData);
                {{-- 検索件数の取得フラグの送信データを追加 --}}
                soushinData["dataCntFlg"] = true;
                {{-- 検索件数のデータ受信 --}}
                AjaxData("{{ url('/juchu/4120') }}", soushinData, fncJushinDataCnt);
                break;
            /**外注納期調整 */
            case 3:
                {{-- グリッドのデータ受信 --}}
                AjaxData("{{ url('/juchu/4130') }}", soushinData, fncJushinGridData);
                {{-- 検索件数の取得フラグの送信データを追加 --}}
                soushinData["dataCntFlg"] = true;
                {{-- 検索件数のデータ受信 --}}
                AjaxData("{{ url('/juchu/4130') }}", soushinData, fncJushinDataCnt);
                break;
            default:
            {{-- グリッドのデータ受信 --}}
                AjaxData("{{ url('/juchu/4100') }}", soushinData, fncJushinGridData);
                {{-- 検索件数の取得フラグの送信データを追加 --}}
                soushinData["dataCntFlg"] = true;
                {{-- 検索件数のデータ受信 --}}
                AjaxData("{{ url('/juchu/4100') }}", soushinData, fncJushinDataCnt);
                break;
        }

    }
    {{-- 「CSV出力」ボタンイベント --}}
    var fncExportCSV = function()
    {
        {{-- CSV出力用グリッドのレイアウト設定 --}}
        let columns = [{ binding: 'dataJuchuDate', header: "{{ __('juchu_date') }}" },
                       { binding: 'dataJuchuNo', header: "{{ __('tantousha_name') }}" },
                       { binding: 'dataJigyoubuCd', header: "{{ __('jigyoubu_cd') }}" },
                       { binding: 'dataJigyoubuName', header: "{{ __('jigyoubu_name') }}" },
                       { binding: 'dataJobCd', header: "{{ __('job_cd') }}" },
                       { binding: 'dataJobName', header: "{{ __('job_name') }}" },
                       { binding: 'dataTokuisakiCd', header: "{{ __('tokuisaki_cd') }}" },
                       { binding: 'dataTokuisakiName', header: "{{ __('tokuisaki_name') }}" },
                       { binding: 'dataNounyusakiCd', header: "{{ __('nounyusaki_cd') }}" },
                       { binding: 'dataNounyusakiName', header: "{{ __('nounyusaki_name') }}" },
                       { binding: 'dataEigyouCd', header: "{{ __('eigyou_tantousha_cd') }}" },
                       { binding: 'dataEigyouName', header: "{{ __('eigyou_tantousha_name') }}" },
                       { binding: 'dataAssistantCd', header: "{{ __('assistant_cd') }}" },
                       { binding: 'dataAssistantName', header: "{{ __('assistant_name') }}" },
                       { binding: 'dataChumonNo1', header: "{{ __('tokuisaki_chumon_no1') }}" },
                       { binding: 'dataChumonNo2', header: "{{ __('tokuisaki_chumon_no2') }}" },
                       { binding: 'dataChumonNo3', header: "{{ __('tokuisaki_chumon_no3') }}" },
                       { binding: 'dataHinmokuCd', header: "{{ __('hinmoku_cd') }}" },
                       { binding: 'dataHinmokuName', header: "{{ __('hinmoku_name') }}" },
                       { binding: 'dataTaniCd', header: "{{ __('tani_cd') }}" },
                       { binding: 'dataTaniName', header: "{{ __('tani_name') }}" },
                       { binding: 'dataNoukiDate', header: "{{ __('nouki_date') }}" },
                       { binding: 'dataShukkaDate', header: "{{ __('shukka_date') }}" },
                       { binding: 'dataJuchuQty', header: "{{ __('juchu_qty') }}" },
                       { binding: 'dataJuchuTanka', header: "{{ __('juchu_tanka') }}" },
                       { binding: 'dataJuchukin', header: "{{ __('juchu_kin') }}" },
                       { binding: 'dataKaritankaKbnName', header: "{{ __('karitnka_kbn') }}" },
                       { binding: 'dataJuchuKbnName', header: "{{ __('juchu_kbn') }}" },
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
        switch(cmbStatusSearch.selectedIndex){
            /**未手配 */
            case 0:
            {{-- 入力フォーム要素 --}}
            let nyuryokuData = document.forms['frmNyuryoku'].elements;
            {{-- 選択行のグリッドデータ --}}
            let data = gridMaster.collectionView.currentItem;
            // console.log(data);

            {{-- 「処理種別」 --}}
            nyuryokuData['dataSQLType'].value = mode;
            {{-- 「受注日」 --}}
            dateJuchu.value = copy ? data['dataJuchuDate'] : getNowDate();
            {{-- 「受注No」 --}}
            nyuryokuData['dataJuchuNo'].forEach((e)=>{
                e.value = copy ? data['dataJuchuNo'] : '';
            });
            {{-- 「得意先CD」 --}}
            nyuryokuData['dataTokuisakiCd'].forEach((e)=>{
                e.value = copy ? data['dataTokuisakiCd'] : '';
            });
            {{-- 「得意先名」 --}}
            nyuryokuData['dataTokuisakiName'].forEach((e)=>{
                e.value = copy ? data['dataTokuisakiName'] : '';
            });
            {{-- 「品目CD」 --}}
            nyuryokuData['dataHinmokuCd'].forEach((e)=>{
                e.value = copy ? data['dataHinmokuCd'] : '';
            });
            {{-- 「受注区分」 --}}
            nyuryokuData['dataJuchuKbn'].forEach((e)=>{
                e.value = copy ? data['dataJuchuKbn'] : '';
            });
            {{-- 「受注区分名」 --}}
            nyuryokuData['dataJuchuKbnName'].forEach((e)=>{
                e.value = copy ? data['dataJuchuKbnName'] : '';
            });
            {{-- 「新規リピート区分」 --}}
            // nyuryokuData['dataShinkiRepeatKbn'].value = copy ? data['dataShinkiRepeatKbn'] : '1';
            nyuryokuData['dataShinkiRepeatKbn'].value = '1';
            {{-- 「手配ステータス」 --}}
            rdoTehaiStatus.value =  copy ? data['dataTehaiStatus'] : 0;
            // console.log(rdoTehaiStatus.value);
            {{-- 「手配数量」 --}}
            numTehaiQty.value = copy ? data['dataTehaiQty'] : 0;
            {{-- 「受注数量」 --}}
            numJuchuQty.value = copy ? data['dataJuchuQty'] : 0;
            {{-- 「納期」 --}}
            dateKibouNouki.value = copy ? data['dataKibouNoukiDate'] : getNowDate();
            {{-- 「外注手配候補CD」 --}}
            // nyuryokuData['dataGaichuTehaiKouhoCd'].value = copy ? data['gaichu_kouho_cd'] : '';
            nyuryokuData['dataGaichuTehaiKouhoCd'].value = '';
            {{-- 「外注手配CD」 --}}
            // nyuryokuData['dataGaichuTehaiCd'].value = copy ? data['gaichusaki_cd'] : '';
            nyuryokuData['dataGaichuTehaiCd'].value = '';
        break;
            /**手配済み */
            case 1:
                break;
            /**外注見積 */
            case 2:
                break;
            /**外注納期調整 */
            case 3:
                break;
            default:
                break;
        }

        // {{-- 入力フォーム要素 --}}
        // let nyuryokuData = document.forms['frmNyuryoku'].elements;
        // {{-- 選択行のグリッドデータ --}}
        // let data = gridMaster.collectionView.currentItem;
        // {{-- 「新規」処理フラグ --}}
        // let insertFlg = (mode == MODE_INSERT);

        // {{-- 「処理種別」 --}}
        // nyuryokuData['dataSQLType'].value = mode;
        // {{-- 「受注日」 --}}
        // dateJuchu.value = !insertFlg ? data['dataJuchuDate'] : getNowDate();
        // {{-- 「受注No」 --}}
        // nyuryokuData['dataJuchuNo'].value = (copy && !insertFlg) ? data['dataJuchuNo'] : '';
        // nyuryokuData['dataJuchuNo'].disabled = !insertFlg;
        // {{-- 「事業部CD」 --}}
        // nyuryokuData['dataJigyoubuCd'].value = copy ? data['dataJigyoubuCd'] : '';   
        // {{-- 「事業部名」 --}}
        // nyuryokuData['dataJigyoubuName'].value = copy ? data['dataJigyoubuName'] : '';   
        // {{-- 「業務分類CD」 --}}
        // nyuryokuData['dataJobCd'].value = copy ? data['dataJobCd'] : '';
        // {{-- 「業務分類名」 --}}
        // nyuryokuData['dataJobName'].value = copy ? data['dataJobName'] : '';
        // {{-- 「得意先CD」 --}}
        // nyuryokuData['dataTokuisakiCd'].value = copy ? data['dataTokuisakiCd'] : '';   
        // {{-- 「得意先名」 --}}
        // nyuryokuData['dataTokuisakiName'].value = copy ? data['dataTokuisakiName'] : '';
        // {{-- 「納入先CD」 --}}
        // nyuryokuData['dataNounyusakiCd'].value = copy ? data['dataNounyusakiCd'] : '';   
        // {{-- 「納入先名」 --}}
        // nyuryokuData['dataNounyusakiName'].value = copy ? data['dataNounyusakiName'] : '';
        // {{-- 「営業担当CD」 --}}
        // nyuryokuData['dataEigyouCd'].value = copy ? data['dataEigyouCd'] : '';   
        // {{-- 「営業担当名」 --}}
        // nyuryokuData['dataEigyouName'].value = copy ? data['dataEigyouName'] : '';
        // {{-- 「アシスタントCD」 --}}
        // nyuryokuData['dataAssistantCd'].value = copy ? data['dataAssistantCd'] : '';   
        // {{-- 「アシスタント名」 --}}
        // nyuryokuData['dataAssistantName'].value = copy ? data['dataAssistantName'] : '';
        // {{-- 「客先注番1」 --}}
        // nyuryokuData['dataChumonNo1'].value = copy ? data['dataChumonNo1'] : '';
        // {{-- 「客先注番2」 --}}
        // nyuryokuData['dataChumonNo2'].value = copy ? data['dataChumonNo2'] : '';
        // {{-- 「客先注番3」 --}}
        // nyuryokuData['dataChumonNo3'].value = copy ? data['dataChumonNo3'] : '';
        // {{-- 「品目CD」 --}}
        // nyuryokuData['dataHinmokuCd'].value = copy ? data['dataHinmokuCd'] : '';   
        // {{-- 「品目名」 --}}
        // nyuryokuData['dataHinmokuName'].value = copy ? data['dataHinmokuName'] : '';
        // {{-- 「単位CD」 --}}
        // nyuryokuData['dataTaniCd'].value = copy ? data['dataTaniCd'] : '';   
        // {{-- 「単位名」 --}}
        // nyuryokuData['dataTaniName'].value = copy ? data['dataTaniName'] : '';
        // {{-- 「希望納期」 --}}
        // dateNouki.value = !insertFlg ? data['dataNoukiDate'] : null;
        // {{-- 「出荷予定日」 --}}
        // dateShukka.value = !insertFlg ? data['dataShukkaDate'] : null;
        // {{-- 「手配数量」 --}}
        // numTehaiQty.value = copy = copy ? data['dataTehaiQty'] : 0;
        // {{-- 「受注数量」 --}}
        // numJuchuQty.value = copy ? data['dataJuchuQty'] : 0;
        // {{-- 「受注単価」 --}}
        // numJuchuTanka.value = copy ? data['dataJuchuTanka'] : 0;
        // {{-- 「受注金額」 --}}
        // numJuchuKin.value = copy ? data['dataJuchuKin'] : 0;
        // {{-- 「仮単価区分」 --}}
        // cmbKaritankaKbn.selectedIndex = copy ? data['dataKaritankaKbn'] : 0;
        // {{-- 「受注区分」 --}}
        // cmbJuchuKbn.selectedIndex = copy ? juchuKbnCd.indexOf(data['dataJuchuKbn']) : 0;
        // {{-- 「まとめ区分」 --}}
        // cmbMatomeKbn.selectedIndex = copy ? data['dataMatomeKbn'] : 0;
        // {{-- 「配送便CD」 --}}
        // nyuryokuData['dataHaisoubinCd'].value = copy ? data['dataHaisoubinCd'] : '';   
        // {{-- 「配送便名」 --}}
        // nyuryokuData['dataHaisoubinName'].value = copy ? data['dataHaisoubinName'] : '';
        // {{-- 「備考1」 --}}
        // nyuryokuData['dataNote1'].value = copy ? data['dataNote1'] : '';
        // {{-- 「備考2」 --}}
        // nyuryokuData['dataNote2'].value = copy ? data['dataNote2'] : '';
        // {{-- 「備考3」 --}}
        // nyuryokuData['dataNote3'].value = copy ? data['dataNote3'] : '';
        // {{-- 「有効期間（自）」--}}
        // dateStart.value = !insertFlg ? data['dataStartDate'] : getNowDate();
        // {{-- 「登録日時」 --}}
        // nyuryokuData['dataTourokuDt'].value = !insertFlg ? data['dataTourokuDt'] : '';
        // {{-- 「更新日時」 --}}
        // nyuryokuData['dataKoushinDt'].value = !insertFlg ? data['dataKoushinDt'] : '';

        {{-- 入力フォームのスタイル初期化 ※common_function.js参照　--}}
        InitFormStyle();
    }

    {{-- ---------------------------- --}}
    {{-- 非同期処理呼び出し用の関数変数 --}}
    {{-- ---------------------------- --}}
    {{-- ※data → 非同期通信で受信したjsonデータ配列
         　errorFlg → 非同期通信先のエラー処理判定 --}}

    // {{-- 受注区分取得 --}}
    // var fncJushinJuchuKbnData = function(data, errorFlg)
    // {
    //     {{-- データエラー判定 ※common_function.js参照 --}}
    //     if(IsAjaxDataError(data, errorFlg)) return;
    //     {{-- カテゴリー配列作成 --}}
    //     let juchuKbnData = data[1];
    //     for(let i = 0; i < juchuKbnData.length; i++)
    //     {
    //         juchuKbn.push(juchuKbnData[i].dataSentakuName);
    //         juchuKbnCd.push(juchuKbnData[i].dataSentakuCd);
    //     }
    //     {{-- コンボボックスの更新 --}}
    //     cmbJuchuKbn.itemsSource = juchuKbn;
    // }

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
        // SortGridData(gridMaster, data[1], 'dataJuchuNo', 1);
        // console.log(data);
        switch(cmbStatusSearch.selectedIndex){
            /**未手配 */
            case 0:
                SortGridData(gridMaster, data[1], 'dataJuchuNo', 1);
                break;
            /**手配済み */
            case 1:
                SortGridData(gridMaster, data[1], 'dataJuchuNo', 1);
                break;
            /**外注見積 */
            case 2:
                SortGridData(gridSub, data[1], 'dataJuchuNo', 1);
                break;
            /**外注納期調整 */
            case 3:
                SortGridData(gridMaster, data[1], 'dataJuchuNo', 1);
                break;
            default:
                SortGridData(gridMaster, data[1], 'dataJuchuNo', 1);
                break;
        }    }

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
            // CloseNyuryokuDlg();
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

    {{-- 検索受注日処理 --}}
    function CheckJuchuDate(){
        let startDate = Date.parse(dateJuchuStart.value);
        let endDate = Date.parse(dateJuchuEnd.value);
        if(startDate > endDate) dateJuchuEnd.value = dateJuchuStart.value;
    }

    {{-- 検索見積依頼処理 --}}
    function CheckMitsumoriIraiDate(){
        let startDate = Date.parse(dateMitsumoriIraiStart.value);
        let endDate = Date.parse(dateMitsumoriIraiEnd.value);
        if(startDate > endDate) dateMitsumoriIraiEnd.value = dateMitsumoriIraiStart.value;
    }

    {{-- 検索見積回答処理 --}}
    function CheckMitsumoriKaitouDate(){
        let startDate = Date.parse(dateMitsumoriKaitouStart.value);
        let endDate = Date.parse(dateMitsumoriKaitouEnd.value);
        if(startDate > endDate) dateMitsumoriKaitouEnd.value = dateMitsumoriKaitouStart.value;
    }

    {{-- 検索納期処理 --}}
    function CheckNoukiDate(){
        let startDate = Date.parse(dateNoukiStart.value);
        let endDate = Date.parse(dateNoukiEnd.value);
        if(startDate > endDate) dateNoukiEnd.value = dateNoukiStart.value;
    }

    // {{-- 受注金額合計処理 --}}
    // function SumJuchuKin(){
    //     numJuchuKin.value = numJuchuQty.value * numJuchuTanka.value;
    // }

    // {{-- 「リセット」ボタン　クリック処理 --}}
    // $('#btnReset').click(function() {
    //     {{-- 処理別ボタン処理を実行 --}}
    //     if(document.forms['frmNyuryoku'].elements['dataSQLType'].value == MODE_INSERT){
    //         fncNyuryokuData(MODE_INSERT, false);
    //     }else{
    //         fncNyuryokuData(MODE_UPDATE, true);
    //     }
    // });

    {{-- 「状態絞込み」　処理 --}}
    function SetStatusSearch(){
        let array=<?php echo json_encode(STATUS_SEARCH) ?>;
        for(let i=0; i<array.length; i++){
            if(array[i] !== ''){
                statusSearch.push(array[i]);
                statusSearchValue.push(i);
            }
        }
    }

    {{-- 「状態絞込み」　「詳細状態絞込み」変更処理 --}}
    function fncChangeDetailStatus(index){
        let array=[];
        switch(index){
            case 0:
                array = <?php echo json_encode(STATUS_MITEHAI_JUCHU) ?>;
                break;
            case 1:
                array = <?php echo json_encode(STATUS_TEHAIZUMI_JUCHU) ?>;
                break;
            case 2:
                array = <?php echo json_encode(STATUS_MITUMORI_GAICHU) ?>;
                break;
            case 3:
                array = <?php echo json_encode(STATUS_NOUKI_GAICHU) ?>;
                break;
        }
        detailStatusSearch = [];
        detailStatusSearchValue = [];
        for(let i=0; i<array.length; i++){
            if(array[i] !== ''){
                detailStatusSearch.push(array[i]);
                detailStatusSearchValue.push(i);
            }
        }
    }

    {{-- 「状態絞込み」　検索項目変更処理 --}}
    function fncChangeSearchForm(index){
        offDisplay("searchMitsumoriIrai");
        offDisplay("searchMitsumoriKaitou");
        offDisplay("searchIkkatsuGaichuKouho");
        switch(index){
            /**未手配 */
            case 0:
                onDisplay("searchIkkatsuGaichuKouho","flex");
                break;
            /**手配済み */
            case 1:
                onDisplay("searchIkkatsuGaichuKouho","flex");
                break;
            /**外注見積 */
            case 2:
                onDisplay("searchMitsumoriIrai","flex");
                onDisplay("searchMitsumoriKaitou","flex");
                break;
            /**外注納期調整 */
            case 3:
                onDisplay("searchIkkatsuGaichuKouho","flex");
                break;
            default:
                onDisplay("searchMitsumoriIrai","flex");
                onDisplay("searchMitsumoriKaitou","flex");
                onDisplay("searchIkkatsuGaichuKouho","flex");
                break;
        }
    }

    {{-- 「状態絞込み」　コントロール変更処理 --}}
    function fncChangeControl(index){
        var F1 = document.getElementById('btnFnc1');
        var F2 = document.getElementById('btnFnc2');
        var F3 = document.getElementById('btnFnc3');
        var F4 = document.getElementById('btnFnc4');

        switch(index){
            /**未手配 */
            case 0:
                F2.style="display: flex; align-items: center; justify-content: center;";
                F3.style.display="none";
                F4.style.display="none";
                F1.textContent="{{__('F1')}}{{__('一括外注指示')}}";
                F2.textContent="{{__('F2')}}{{__('社内加工指示')}}";
                F1.style.width="180px";
                F2.style.width="180px";
                break;
            /**手配済み */
            case 1:
                F2.style.display="none";
                F3.style.display="none";
                F4.style.display="none";
                F1.textContent="{{__('F1')}}{{__('編集')}}";
                F1.style.width="130px";
                break;
            /**外注見積 */
            case 2:
                F2.style="display: flex; align-items: center; justify-content: center;";
                F3.style="display: flex; align-items: center; justify-content: center;";
                F4.style="display: flex; align-items: center; justify-content: center;";
                F1.textContent="{{__('F1')}}{{__('見積辞退')}}";
                F2.textContent="{{__('F2')}}{{__('即発注')}}";
                F3.textContent="{{__('F3')}}{{__('再見積依頼')}}";
                F4.textContent="{{__('F4')}}{{__('見積依頼に戻す')}}";
                F1.style.width="130px";
                F2.style.width="130px";
                F3.style.width="160px";
                F4.style.width="180px";
                break;
            /**外注納期調整 */
            case 3:
                F2.style.display="none";
                F3.style.display="none";
                F4.style.display="none";
                F1.textContent="{{__('F1')}}{{__('編集')}}";
                F1.style.width="130px";
                break;
            default:
                F2.style="display: flex; align-items: center; justify-content: center;";
                F3.style="display: flex; align-items: center; justify-content: center;";
                F4.style="display: flex; align-items: center; justify-content: center;";
                F1.textContent="{{__('F1')}}{{__('新規')}}";
                F2.textContent="{{__('F2')}}{{__('参照新規')}}";
                F3.textContent="{{__('F3')}}{{__('修正')}}";
                F4.textContent="{{__('F4')}}{{__('削除')}}";
                F1.style.width="130px";
                F2.style.width="130px";
                F3.style.width="130px";
                F4.style.width="130px";
                break;
        }
    }

    /**非表示に設定 */
    function onDisplay(id,style){
        if(style !== null){
            document.getElementById(id).style.display="";
        } else {
            document.getElementById(id).style.display=style;
        }
        return document.getElementById(id);
    }

    /**表示に設定 */
    function offDisplay(id){
        document.getElementById(id).style.display="none";
        return document.getElementById(id);
    }

    /**製作振分設定 */
    function setSeisakuKbn(kbn){
        document.getElementById("dataSeisakuKbn").value=kbn;
        return document.getElementById("dataSeisakuKbn");
    }

    // 「Fnc1」ボタン　クリック処理
    $('#btnFnc1').click(function() {
        switch(cmbStatusSearch.selectedIndex){
            /**未手配 */
            case 0:
                ShowNyuryokuDlg();
                onDisplay("frmGaichuShiji");
                offDisplay("frmShanaiKakouShiji");
                offDisplay("btnNittei");
                setSeisakuKbn('1');
                CloseNyuryokuDlg();
                ShowNyuryokuDlg(MODE_INSERT, true);
                $('.rdoTehaiStatus').change();
                // ShowNyuryokuDlg(MODE_UPDATE, true);
                break;
            /**手配済み */
            case 1:
                ShowNyuryokuDlg();
                offDisplay("frmGaichuShiji");
                onDisplay("frmShanaiKakouShiji");
                onDisplay("btnNittei","margin-right:10px;");
                CloseNyuryokuDlg();
                ShowNyuryokuDlg(MODE_UPDATE, true);
                break;
            /**外注見積 */
            case 2:
                break;
            /**外注納期調整 */
            case 3:
                ShowNyuryokuDlg();
                offDisplay("frmGaichuShiji");
                onDisplay("frmShanaiKakouShiji");
                onDisplay("btnNittei","margin-right:10px;");
                CloseNyuryokuDlg();
                ShowNyuryokuDlg(MODE_UPDATE, true);
                break;
            default:
                break;
        }
    })

    // 「Fnc2」ボタン　クリック処理
    $('#btnFnc2').click(function() {
        switch(cmbStatusSearch.selectedIndex){
            /**未手配 */
            case 0:
                ShowNyuryokuDlg();
                offDisplay("frmGaichuShiji");
                onDisplay("frmShanaiKakouShiji");
                onDisplay("btnNittei","margin-right:10px;");
                setSeisakuKbn('2');
                CloseNyuryokuDlg();
                ShowNyuryokuDlg(MODE_UPDATE, true);
                break;
            /**手配済み */
            case 1:
                break;
            /**外注見積 */
            case 2:
                break;
            /**外注納期調整 */
            case 3:
                break;
            default:
                break;
        }
    })

    // 「Fnc3」ボタン　クリック処理
    $('#btnFnc3').click(function() {
        switch(cmbStatusSearch.selectedIndex){
            /**未手配 */
            case 0:
                break;
            /**手配済み */
            case 1:
                break;
            /**外注見積 */
            case 2:
                break;
            /**外注納期調整 */
            case 3:
                break;
            default:
                break;
        }
    })

    // 「Fnc4」ボタン　クリック処理
    $('#btnFnc4').click(function() {
        switch(cmbStatusSearch.selectedIndex){
            /**未手配 */
            case 0:
                break;
            /**手配済み */
            case 1:
                break;
            /**外注見積 */
            case 2:
                break;
            /**外注納期調整 */
            case 3:
                break;
            default:
                break;
        }
    })

    {{-- 「前へ」ボタン　クリック処理 --}}
    $('#btnPre').click(function() {
        console.log('前へ');
    });

    {{-- 「次へ」ボタン　クリック処理 --}}
    $('#btnNext').click(function() {
        console.log('次へ');
    });

    {{-- 「日程算出」ボタン　クリック処理 --}}
    $('#btnNittei').click(function() {
        console.log('日程算出');
    });

    {{-- 「更新」ボタン　クリック処理 --}}
    $('#btnReload').click(function() {
        console.log('更新');
        // ステータスによって更新内容を変更する必要あり
        // switch

        {{-- 関数内関数 --}}
        {{-- 編集ダイアログ入力値変更判定 --}}
        function IsChangeNyuryokuData(nyuryokuData)
        {
            {{-- 選択行のグリッドデータ --}}
            let data = gridMaster.collectionView.currentItem;
            {{-- 更新処理以外の処理の場合は判定せずにtrue --}}
            if(nyuryokuData['dataSQLType'].value != MODE_UPDATE) return true;
            {{-- 「受注番号」 --}}
            if((nyuryokuData['dataJuchuNo'].value != data['dataJuchuNo'])) return true;
            {{-- 「新規リピート区分」 --}}
            if((nyuryokuData['dataShinkiRepeatKbn'].value != data['dataShinkiRepeatKbn'])) return true;
            {{-- 「製作振分」 --}}
            if((nyuryokuData['dataSeisakuKbn'].value != data['dataSeisakuKbn'])) return true;
            {{-- 「手配ステータス」 --}}
            if((nyuryokuData['dataTehaiStatus'].value != data['dataTehaiStatus'])) return true;
            {{-- 上記項目に変更が無い場合はfalse --}}
            return false;
        }
        // {{-- HTMLでの送信をキャンセル --}}
        // event.preventDefault();
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
        {{-- 手配ステータス --}}
        nyuryokuData['dataTehaiStatus'].value = rdoTehaiStatus.value;

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
                AjaxData("{{ url('/juchu/4101') }}", soushinData, fncUpdateData);
            }, null);
        }
        else
        {
            // console.log(soushinData,'soushin')
            {{-- 「データ更新中」表示 --}}
            ShowPopupDlg("{{__('データ更新中')}}");
            {{-- 非同期データ更新開始 --}}
            AjaxData("{{ url('/juchu/4101') }}", soushinData, fncUpdateData);
        }
    });

    {{-- 得意先変更時に連動する納入先要素のリセット処理 --}}
    $('#dataTokuisakiCd').change(function() {
        $('#dataNounyusakiCd')[0].value = '';
        $('#dataNounyusakiName')[0].value = '';
    });
    
    {{-- 「手配ステータス」　変更処理 --}}
    $('.rdoTehaiStatus').change(function() {
        var item1 = document.getElementById('tehaiStatus1');
        var item2 = document.getElementById('tehaiStatus2');
        var data1 = document.getElementsByName('dataTehaiStatus');
        var data2 = document.forms['frmNyuryoku'].elements['dataGaichuTehaiKouhoCd']
        // console.log('.rdoTehaiStatus');
        if (item2.checked) {
            data1.value = item2.value;
            rdoTehaiStatus.value = item2.value;
            data2.disabled = true;
        } 
        else {
            data1.value = item1.value;
            rdoTehaiStatus.value = item1.value;
            data2.disabled = false;
        } 
        // console.log(rdoTehaiStatus.value);
    });

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
            {{-- 「受注番号」 --}}
            if((nyuryokuData['dataJuchuNo'].value != data['dataJuchuNo'])) return true;
            {{-- 「製作振分」 --}}
            if((nyuryokuData['dataSeisakuKbn'].value != data['dataSeisakuKbn'])) return true;
            {{-- 「手配ステータス」 --}}
            if((nyuryokuData['dataTehaiStatus'].value != data['dataTehaiStatus'])) return true;
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
        {{-- 手配ステータス --}}
        nyuryokuData['dataTehaiStatus'].value = rdoTehaiStatus.value;

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
                AjaxData("{{ url('/juchu/3801') }}", soushinData, fncUpdateData);
            }, null);
        }
        else
        {
            // console.log(soushinData,'soushin')
            {{-- 「データ更新中」表示 --}}
            ShowPopupDlg("{{__('データ更新中')}}");
            {{-- 非同期データ更新開始 --}}
            AjaxData("{{ url('/juchu/3801') }}", soushinData, fncUpdateData);
        }
    });

    {{-- テキスト変更時に連動するテキスト要素のリセット処理 --}}
    $('input[type="text"]').change(function() {
        {{-- 連動テキスト要素のある要素を判別 --}}
        switch($(this)[0].name)
        {
            {{-- 外注手配候補CD --}}
            case 'dataGaichuTehaiKouhoCd':
            break;
            {{-- 外注手配CD --}}
            case 'dataGaichuTehaiCd':
            break;
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
        {{-- 対象日 --}}
        let targetDate = null;
        {{-- 入力ダイアログが開かれている場合は対象日取得 --}}
        if(IsVisibleNyuryoku()){
            targetDate = document.forms['frmNyuryoku'].elements['dataJuchuDate'].value;
        }
        {{-- 選択対象の名前を判別 --}}
        switch(currentCdElement.name)
        {
            {{-- 事業部CD --}}
            case 'dataJigyoubuCd':
            ShowSentakuDlg("{{ __('jigyoubu_cd') }}", "{{ __('jigyoubu_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0100') }}", targetDate, '', 1);
            break;
            {{-- 業務分類CD --}}
            case 'dataJobCd':
            ShowSentakuDlg("{{ __('job_cd') }}", "{{ __('job_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/3500') }}", targetDate);
            break;
            {{-- 得意先CD --}}
            case 'dataTokuisakiCd':
            ShowSentakuDlg("{{ __('tokuisaki_cd') }}", "{{ __('tokuisaki_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1400') }}", targetDate);
            break;
            {{-- 納入先CD --}}
            case 'dataNounyusakiCd':
            ShowSentakuDlg("{{ __('nounyusaki_cd') }}", "{{ __('nounyusaki_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1600') }}", targetDate,
                           document.forms['frmNyuryoku'].elements['dataTokuisakiCd'].value);
            break;
            {{-- 営業担当CD --}}
            case 'dataEigyouCd':
            ShowSentakuDlg("{{ __('eigyou_tantousha_cd') }}", "{{ __('eigyou_tantousha_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0400') }}", targetDate,
                           document.forms['frmNyuryoku'].elements['dataAssistantCd'].value);
            break;
            {{-- アシスタントCD --}}
            case 'dataAssistantCd':
            ShowSentakuDlg("{{ __('assistant_cd') }}", "{{ __('assistant_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0400') }}", targetDate,
                           document.forms['frmNyuryoku'].elements['dataEigyouCd'].value);
            break;
            {{-- 品目CD --}}
            case 'dataHinmokuCd':
            ShowSentakuDlg("{{ __('hinmoku_cd') }}", "{{ __('hinmoku_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/2600') }}", targetDate);
            break;
            {{-- 単位CD --}}
            case 'dataTaniCd':
            ShowSentakuDlg("{{ __('tani_cd') }}", "{{ __('tani_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}", targetDate, "TANI");
            break;
            {{-- 配送便CD --}}
            case 'dataHaisoubinCd':
            ShowSentakuDlg("{{ __('haisoubin_cd') }}", "{{ __('haisoubin_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}", targetDate, "HAISOUBIN");
            break;
            {{-- 外注手配候補CD --}}
            case 'dataGaichuTehaiKouhoCd':
            ShowSentakuDlg("{{ __('waritukekouho_cd') }}", "{{ __('waritukekouho_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1900') }}", targetDate);
            break;
            {{-- 外注手配CD --}}
            case 'dataGaichuTehaiCd':
            ShowSentakuDlg("{{ __('shiiresaki_cd') }}", "{{ __('shiiresaki_ryaku') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1800') }}", targetDate);
            break;
        }
    });
</script>
@endsection