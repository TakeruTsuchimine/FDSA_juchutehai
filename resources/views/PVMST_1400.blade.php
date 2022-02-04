{{-- PHP処理 --}}
<?php
    // アクセス権限
    define("SHOGUCHI_KBN", array( '通常',
                            '諸口'));
    define("NOUHINSHO_MIDASHI_KBN", array( '',
                            '見出しを請求書とする',)); 
    define("NOUHINSHO_HAKKOU_KBN", array( '',
                            '注番１で並び替えて伝票を発行する（加賀産業）',));
    define("SENYOU_DENPYOU_HAKKOU_KBN", array( '',
                            '未発行',
                            '',
                            '発行'));
    define("SEIKYUSHO_HAKKOU_KBN", array( '',
                            '未発行',
                            '',
                            '発行'));
    define("TOKUISAKI_TORIHIKI_KBN", array( '',
                            '無し',
                            '',
                            '有り'));
    define("SEIKYUSAKI_TORIHIKI_KBN", array( '',
                            '無し',
                            '',
                            '有り'));
    define("SHOUHIZEI_KEISAN_TANI", array( '',
                            '未',
                            '',
                            '締単位',
                            '',
                            '伝票単位',
                            '',
                            '明細単位'));
    define("SHOUHIZEI_KEISAN_HOUSHIKI", array( '',
                            '内税金',
                            '',
                            '外税（請求単位）',
                            '',
                            '外税（伝票単位）',
                            '',
                            '外税（アイテム単位',
                            '',
                            '対象外',));
    define("SHOUHIZEI_KEISAN_MARUME", array( '',
                            '切り捨て',
                            '',
                            '四捨五入',
                            '',
                            '切上げ'));
    define("KINGAKU_KEISAN_MARUME", array( '',
                            '切り捨て',
                            '',
                            '四捨五入',
                            '',
                            '切上げ'));
    define("SHIME_DAY1", array( '',
                            '1日',
                            '',
                            '2日',
                            '',
                            '3日',
                            '',
                            '4日',
                            '',
                            '5日',
                            '',
                            '6日',
                            '',
                            '7日',
                            '',
                            '8日',
                            '',
                            '9日',
                            '',
                            '10日',
                            '',
                            '11日',
                            '',
                            '12日',
                            '',
                            '13日',
                            '',
                            '14日',
                            '',
                            '15日',
                            '',
                            '16日',
                            '',
                            '17日',
                            '',
                            '18日',
                            '',
                            '19日',
                            '',
                            '20日',
                            '',
                            '21日',
                            '',
                            '22日',
                            '',
                            '23日',
                            '',
                            '24日',
                            '',
                            '25日',
                            '',
                            '26日',
                            '',
                            '27日',
                            '',
                            '28日',
                            '',
                            '29日',
                            '',
                            '30日',
                            '',
                            '31日'));
define("SHIME_DAY2", array( '',
                            '1日',
                            '',
                            '2日',
                            '',
                            '3日',
                            '',
                            '4日',
                            '',
                            '5日',
                            '',
                            '6日',
                            '',
                            '7日',
                            '',
                            '8日',
                            '',
                            '9日',
                            '',
                            '10日',
                            '',
                            '11日',
                            '',
                            '12日',
                            '',
                            '13日',
                            '',
                            '14日',
                            '',
                            '15日',
                            '',
                            '16日',
                            '',
                            '17日',
                            '',
                            '18日',
                            '',
                            '19日',
                            '',
                            '20日',
                            '',
                            '21日',
                            '',
                            '22日',
                            '',
                            '23日',
                            '',
                            '24日',
                            '',
                            '25日',
                            '',
                            '26日',
                            '',
                            '27日',
                            '',
                            '28日',
                            '',
                            '29日',
                            '',
                            '30日',
                            '',
                            '31日'));
define("TEKIYOU_TSUKI", array( '',
                            '1月',
                            '',
                            '2月',
                            '',
                            '3月',
                            '',
                            '4月',
                            '',
                            '5月',
                            '',
                            '6月',
                            '',
                            '7月',
                            '',
                            '8月',
                            '',
                            '9月',
                            '',
                            '10月',
                            '',
                            '11月',
                            '',
                            '12月'));
    define("NYUKIN_TSUKI1", array( '',
                            '当月',
                            '',
                            '翌月',
                            '',
                            '翌々月'));
    define("NYUKIN_DAY1", array( '',
                            '1日',
                            '',
                            '2日',
                            '',
                            '3日',
                            '',
                            '4日',
                            '',
                            '5日',
                            '',
                            '6日',
                            '',
                            '7日',
                            '',
                            '8日',
                            '',
                            '9日',
                            '',
                            '10日',
                            '',
                            '11日',
                            '',
                            '12日',
                            '',
                            '13日',
                            '',
                            '14日',
                            '',
                            '15日',
                            '',
                            '16日',
                            '',
                            '17日',
                            '',
                            '18日',
                            '',
                            '19日',
                            '',
                            '20日',
                            '',
                            '21日',
                            '',
                            '22日',
                            '',
                            '23日',
                            '',
                            '24日',
                            '',
                            '25日',
                            '',
                            '26日',
                            '',
                            '27日',
                            '',
                            '28日',
                            '',
                            '29日',
                            '',
                            '30日',
                            '',
                            '31:月末指定'));
    define("KAISHUHOUHOU1", array( '',
                            '未設定',
                            '',
                            '現金・小切手',
                            '',
                            '振込',
                            '',
                            '振込手数料',
                            '',
                            '手形',
                            '',
                            '電債',
                            '',
                            '入金値引き'));
    define("TEGATA_SATE1", array( '',
                            '30日',
                            '',
                            '60日',
                            '',
                            '90日',
                            '',
                            '120日'));
    define("SHIHARAI_KAISHU_JOUGEN_KIN", array( '',
                            '当該額未満',
                            '',
                            '当該額以上'));  
    define("NYUKIN_TSUKI2", array( '',
                            '当月',
                            '',
                            '翌月',
                            '',
                            '翌々月'));
    define("NYUKIN_DAY2", array( '',
                            '1日',
                            '',
                            '2日',
                            '',
                            '3日',
                            '',
                            '4日',
                            '',
                            '5日',
                            '',
                            '6日',
                            '',
                            '7日',
                            '',
                            '8日',
                            '',
                            '9日',
                            '',
                            '10日',
                            '',
                            '11日',
                            '',
                            '12日',
                            '',
                            '13日',
                            '',
                            '14日',
                            '',
                            '15日',
                            '',
                            '16日',
                            '',
                            '17日',
                            '',
                            '18日',
                            '',
                            '19日',
                            '',
                            '20日',
                            '',
                            '21日',
                            '',
                            '22日',
                            '',
                            '23日',
                            '',
                            '24日',
                            '',
                            '25日',
                            '',
                            '26日',
                            '',
                            '27日',
                            '',
                            '28日',
                            '',
                            '29日',
                            '',
                            '30日',
                            '',
                            '31:月末指定'));
    define("KAISHUHOUHOU2", array( '',
                            '振込',
                            '',
                            '手形'));
    define("TEGATA_SATE2", array( '',
                            '30日',
                            '',
                            '60日',
                            '',
                            '90日',
                            '',
                            '120日'));
    define("FURIKOMI_TESURYOU_KBN", array( '',
                            '手数料自社払い　',
                            '',
                            '手数料相手払い'));
    define("KAISHUKOUZA_KBN", array( '',
                            '普通　',
                            '',
                            '当座'));   
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
            {{-- 「得意先CD」 --}}
            <label>
                <span style="width:5em;">{{__('tokuisaki_cd')}}</span>
                <input name="dataTokuisakiCd" class="form-control" type="text"
                       maxlength="10" autocomplete="off" style="width:8em;">
            </label>
            {{-- 「得意先名」 --}}
            <label>
                <span style="width:5em;">{{__('tokuisaki_hyouji_name')}}</span>
                <input name="dataTokuisakiHyoujiName" class="form-control" type="text"
                       maxlength="60" autocomplete="off" style="width:20em;">
            </label>
            {{-- 「事業部CD」 --}}
            <label>
                <span style="width:5em;">{{__('jigyoubu_cd')}}</span>
                <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                    <input name="dataJigyoubuCd" class="form-control" type="text"
                           maxlength="6" autocomplete="off" style="width:8em;">
                    {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                    <i class="fas fa-search search-btn"></i>
                </span>
                {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                <input name="dataJigyoubuName" class="form-control" type="text"
                       style="width:20em;" onfocus="blur();" readonly>
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
    <div class="flex-box flex-between item-start" style="padding: 20px;">
        <div class="flex-box flex-center flex-column item-start">
            {{-- 「得意先CD」 --}}
            <label>
                <span style="width:6.7em;">{{__('tokuisaki_cd')}}</span>
                {{-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 --}}
                <input name="dataTokuisakiCd" class="form-control code-check" type="text"
                       maxlength="10" autocomplete="off" style="width:12em;" required>
            </label>
            {{-- 「得意先名1」 --}}
            <label>
                <span style="width:7em;">{{__('tokuisaki_name1')}}</span>
                <input name="dataTokuisakiName1" class="form-control" type="text"
                       maxlength="30" autocomplete="off" style="width:20em;">
            </label>
            {{-- 「得意先名2」 --}}
            <label>
                <span style="width:7em;">{{__('tokuisaki_name2')}}</span>
                <input name="dataTokuisakiName2" class="form-control" type="text"
                       maxlength="30" autocomplete="off" style="width:20em;" >
            </label>
            {{-- 「得意先名カナ」 --}}
            <label>
                <span style="width:7em;">{{__('tokuisaki_kana')}}</span>
                <input name="dataTokuisakiKana" class="form-control" type="text"
                       maxlength="60" autocomplete="off" style="width:15em;">
            </label>
            {{-- 「先方連絡先」 --}}
            <label>
                <span style="width:7em;">{{__('senpou_renrakusaki')}}</span>
                <input name="dataSenpouRenrakusaki" class="form-control" type="text"
                       maxlength="128" autocomplete="off" style="width:10em;">
            </label>
            {{-- 「郵便番号」 --}}
            <label>
                <span style="width:7em;">{{__('yubinbangou')}}</span>
                <input name="dataYubinbangou" class="form-control" type="text"
                       maxlength="10" autocomplete="off" style="width:12em;">
            </label>
            {{-- 「住所1」 --}}
            <label>
                <span style="width:7em;">{{__('jusho1')}}</span>
                <input name="dataJusho1" class="form-control" type="text"
                       maxlength="60" autocomplete="off" style="width:20em;">
            </label>
            {{-- 「住所2」 --}}
            <label>
                <span style="width:7em;">{{__('jusho2')}}</span>
                <input name="dataJusho2" class="form-control" type="text"
                       maxlength="60" autocomplete="off" style="width:20em;">
            </label>
            {{-- 「電話番号」 --}}
            <label>
                <span style="width:7em;">{{__('tel_no')}}</span>
                <input name="dataTelNo" class="form-control" type="text"
                       maxlength="14" autocomplete="off" style="width:15em;">
            </label>
            {{-- 「FAX番号」 --}}
            <label>
                <span style="width:7em;">{{__('fax_no')}}</span>
                <input name="dataFaxNo" class="form-control" type="text"
                       maxlength="14" autocomplete="off" style="width:15em;">
            </label>
        </div>
        <div class="flex-box flex-center flex-column item-start "style="margin: 0px 30px 0px 40px">
            <!-- 「得意先略称」 -->
            <label>
                <span style="width:9em;">{{__('tokuisaki_ryaku')}}</span>
                <input name="dataTokuisakiRyaku" class="form-control" type="text"
                       maxlength="20" autocomplete="off" style="width:10em;">
            </label>
            {{-- 「得意先略称2」 --}}
            <label>
                <span style="width:9em;">{{__('tokuisaki_ryaku2')}}</span>
                <input name="dataTokuisakiRyaku2" class="form-control" type="text"
                       maxlength="20" autocomplete="off" style="width:10em;">
            </label>
            {{-- 「得意先名(表示) 」 --}}
            <label>
                <span style="width:9em;">{{__('tokuisaki_hyouji_name')}}</span>
                <input name="dataTokuisakiHyoujiName" class="form-control" type="text"
                       maxlength="20" autocomplete="off" style="width:10em;">
            </label>
            {{-- 「事業部CD」 --}}
            <label>
                <span style="width:8.7em;">{{__('jigyoubu_cd')}}</span>
                <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                    <input name="dataJigyoubuCd" class="form-control" type="text"
                           maxlength="6" autocomplete="off" style="width:10em;"
                            pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}"  required>
                    {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                    <i class="fas fa-search search-btn"></i>
                </span>
                {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                <input name="dataJigyoubuName" class="form-control" type="text"
                       style="width:14em;" onfocus="blur();" readonly>
            </label>
            {{-- 「営業担当者CD」 --}}
            <label>
                <span style="width:9em;">{{__('eigyou_tantousha_cd')}}</span>
                <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                <input name="dataEigyoTantoushaCd" class="form-control code-check" type="text"
                    maxlength="10" autocomplete="off" style="width:10em;">
                    {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                    <i class="fas fa-search search-btn"></i>
                </span>
                {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                <input name="dataEigyoTantoushaName" class="form-control" type="text"
                       style="width:14em;" onfocus="blur();" readonly>
            </label>
            {{-- 「アシスタントCD」 --}}
            <label>
                <span style="width:9em;">{{__('assistant_cd')}}</span>
                <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                <input name="dataAssistantCd" class="form-control code-check" type="text"
                    maxlength="10" autocomplete="off" style="width:10em;">
                    {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                    <i class="fas fa-search search-btn"></i>
                </span>
                {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                <input name="dataAssistantName" class="form-control" type="text"
                       style="width:14em;" onfocus="blur();" readonly>
            </label>
            <div class="display">
            {{-- 「支店CD」 --}}
            <label>
                <span style="width:6.6em;">{{__('keishou_kbn')}}</span>
                <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                    <input name="dataKeishouKbn" class="form-control" type="text"
                           maxlength="6" autocomplete="off" style="width:10em;"
                            pattern="^([a-zA-Z0-9]{0,1})$" required>
                    <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                    <i class="fas fa-search search-btn"></i>
                </span>
                <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                <input name="dataBunruiName" class="form-control" type="text"
                       style="width:14em;" onfocus="blur();" readonly>
            </label>
            </div>
            {{-- 「敬称区分」 --}}
            <label>
                <span style="width:9em;">{{__('keishou_kbn')}}</span>
                {{-- 「」コンボボックス本体 --}}
                <div id="cmbKeishoKbn" style="width:18em;"></div>
                {{-- 「」フォーム送信データ --}}
                <input name="dataKeishoKbn" type="hidden">
            </label>
            {{-- 「諸口区分」 --}}
            <label>
                <span style="width:9em;">{{__('shokuchi_kbn')}}</span>
                {{-- 「」コンボボックス本体 --}}
                <div id="cmbShokuchiKbn" style="width:18em;"></div>
                {{-- 「」フォーム送信データ --}}
                <input name="dataShokuchiKbn" type="hidden">
            </label>
            {{-- 「得意先取引区分」 --}}
            <label>
                <span style="width:9em;">{{__('tokuisaki_torihiki_kbn')}}</span>
                {{-- 「」コンボボックス本体 --}}
                <div id="cmbTokuisakiTorihikiKbn" style="width:18em;"></div>
                {{-- 「」フォーム送信データ --}}
                <input name="dataTokuisakiTorihikiKbn" type="hidden">
            </label>
        </div>
    </div>
    <div class="tabs">
        <input id="denpyou" type="radio" name="tab_item">
        <label class="tab_item" for="denpyou" style="width:32%; display: flex; justify-content: space-between; 
            margin-left: 1%; padding-left: 1%;">伝票・税設定</label>
        <input id="seikyu" type="radio" name="tab_item"checked>
        <label class="tab_item" for="seikyu"style="width:32%; display: flex; justify-content: space-between; 
            margin-left: 1%; padding-left: 1%;">請求</label>
        <input id="sonota" type="radio" name="tab_item">
        <label class="tab_item" for="sonota"style="width:32%; display: flex; justify-content: space-between; 
            margin-left: 1%; padding-left: 1%;">他設定</label>
        <div class="tab_content" id="denpyou_content">
            <div class="tab_content_description">
                <div class="flex-box flex-between item-start">
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0 0 0 20">
                        {{-- 「納品書見出区分」 --}}
                        <label>
                            <span style="width:7em;">{{__('nouhinsho_midashi_kbn')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbNouhinshoMidashiKbn" style="width:18em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataNouhinshoMidashiKbn" type="hidden">
                        </label>
                        {{-- 「納品書発行区分」 --}}
                        <label>
                            <span style="width:7em;">{{__('nouhinsho_hakkou_kbn')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbNouhinshoHakkouKbn" style="width:18em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataNouhinshoHakkouKbn" type="hidden">
                        </label>
                        {{-- 「専用伝票発行区分」 --}}
                        <label>
                            <span style="width:7em;">{{__('senyou_denpyou_hakkou_kbn')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbSenyouDenpyouHakkoKbn" style="width:18em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataSenyouDenpyouHakkoKbn" type="hidden">
                        </label>
                        {{-- 「請求書発行区分」 --}}
                        <label>
                            <span style="width:7em;">{{__('seikyusho_hakkou_kbn')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbSeikyushoHakkouKbn" style="width:18em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataSeikyushoHakkoKbn" type="hidden">
                        </label>
                    </div>
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0 300px 0 0">
                        {{-- 「消費税計算単位」 --}}
                        <label>
                            <span style="width:7.5em;">{{__('shohizei_keisan_tani')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbShouhizeiKeisanTani" style="width:10em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataShohizeiKeisanTani" type="hidden">
                        </label>
                        {{-- 「消費税計算方式」 --}}
                        <label>
                            <span style="width:7.5em;">{{__('shohizei_keisan_houshiki')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbShohizeiKeisanHoushiki" style="width:10em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataShohizeiKeisanHoushiki" type="hidden">
                        </label>
                        {{-- 「消費税計算丸目」 --}}
                        <label>
                            <span style="width:7.5em;">{{__('shohizei_keisan_marume')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbShohizeiKeisanMarume" style="width:10em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataShohizeiKeisanMarume" type="hidden">
                        </label>
                        {{-- 「金額計算丸目」 --}}
                        <label>
                            <span style="width:7.5em;">{{__('kingaku_keisan_marume')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbKingakuKeisanMarume" style="width:10em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataKingakuKeisanMarume" type="hidden">
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab_content" id="seikyu_content">
            <div class="tab_content_description">
                <div class="form-column"style="margin: 0 0 0 20">
                    {{-- 「請求先取引区分」 --}}
                    <label>
                    <span style="width:8.5em;">{{__('seikyusaki_torihiki_kbn')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbSeikyusakiTorihikiKbn" style="width:18em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataSeikyusakiTorihikiKbn" type="hidden">
                    </label>
                    {{-- 「請求先CD」 --}}
                    <label>
                        <span style="width:8.6em;">{{__('seikyusaki_cd')}}</span>
                        <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                        <input name="dataSeikyusakiCd" class="form-control code-check" type="text"
                            maxlength="10" autocomplete="off" style="width:8em;">
                            {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                            <i class="fas fa-search search-btn"></i>
                        </span>
                        {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                        <input name="dataSeikyusakiName" class="form-control" type="text"
                            style="width:20em;" onfocus="blur();" readonly>
                    </label>
                    {{-- 「入金親コード」 --}}
                    <label>
                        <span style="width:8.6em;">{{__('nyukin_oya_cd')}}</span>
                        <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                        <input name="dataNyukinOyaCode" class="form-control code-check" type="text"
                            maxlength="10" autocomplete="off" style="width:8em;">
                            {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                            <i class="fas fa-search search-btn"></i>
                        </span>
                        {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                        <input name="dataNyukinOyaName" class="form-control" type="text"
                            style="width:20em;" onfocus="blur();" readonly>
                    </label>
                </div>
                <div class="flex-box flex-between item-start">
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0 0 0 20">
                        {{-- 「締日1」 --}}
                        <label>
                            <span style="width:8.5em;">{{__('shime_day1')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbShimeDay1" style="width:10em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataShimeDay1" type="hidden">
                        </label>
                        {{-- 「締日2」 --}}
                        <label>
                            <span style="width:8.5em;">{{__('shime_day2')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbShimeDay2" style="width:10em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataShimeDay2" type="hidden">
                        </label>
                        {{-- 「適用月（締日２）」 --}}
                        <label>
                            <span style="width:8.5em;">{{__('tekiyou_tsuki')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbTekiyouTsuki" style="width:10em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataTekiyouTsuki" type="hidden">
                        </label>
                        {{-- 「支払・回収額上限」 --}}
                        <label>
                            <span style="width:8.5em;">{{__('shiharai_kaishu_jougen_kin')}}</span>
                            {{-- 「支払・回収額上限」コンボボックス本体 --}}
                            <div id="cmbShiharaiKaishuJoukenKin" style="width:10em;"></div>
                            {{-- 「支払・回収額上限」フォーム送信データ --}}
                            <input name="dataShiharaiKaishuJoukenKin" type="hidden">
                        </label>
                        {{-- 「振込手数料区分」 --}}
                        <label>
                            <span style="width:8.5em;">{{__('furikomi_tesuryou_kbn')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbHurikomiTesuryouKbn" style="width:14em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataFurikomiTesuryouKbn" type="hidden">
                        </label>            
                    </div>
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0 300 0 0">        
                        {{-- 「入金予定月1」 --}}
                        <label>
                            <span id="displayNyukinTsuki1"style="width:7em;">{{__('nyukin_tsuki')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbNyukinTsuki1" style="width:10em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataNyukinTsuki1" type="hidden">
                        </label>
                        {{-- 「入金日1」 --}}
                        <label>
                            <span id="displayNyukinDay1"style="width:7em;">{{__('nyukin_day1')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbNyukinDay1" style="width:10em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataNyukinDay1" type="hidden">
                        </label>
                        {{-- 「回収方法1」 --}}
                        <label>
                            <span id="displayKaishuhouhou1" style="width:7em;">{{__('kaishuhouhou1')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbKaishuhouhou1" style="width:10em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataKaishuhouhou1" type="hidden">
                        </label>            
                        {{-- 「手形サイト1」 --}}
                        <label>
                            <span id="displayTegataSate1" style="width:7em;">{{__('tegata_sate1')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbTegataSate1" style="width:10em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataTegataSate1" type="hidden">
                        </label>            
                    </div>
                    <div class="display">
                        {{-- 「銀行CD」 --}}
                        <label>
                            <span style="width:7em;">{{__('ginkou_cd')}}</span>
                            <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                            <input name="dataGinkouCd" class="form-control code-check" type="text"
                                maxlength="8" autocomplete="off" style="width:8em;">
                                {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                                <i class="fas fa-search search-btn"></i>
                            </span>
                            {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
                            <input name="dataGinkouName" class="form-control" type="text"
                                    style="width:20em;" onfocus="blur();" readonly>
                        </label>
                        {{-- 「回収口座区分」 --}}
                        <label>
                            <span style="width:8.5em;">{{__('kaishukouza_kbn')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbKaishukouzaKbn" style="width:10em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataKaishukouzaKbn" type="hidden">
                        </label>
                        {{-- 「回収口座番号」 --}}
                        <label>
                            <span style="width:8.5em;">{{__('kaishukouza_no')}}</span>
                            <input name="dataKaishukouzaNo" class="form-control" type="text"
                                 maxlength="20" autocomplete="off" style="width:10em;">
                        </label>
                        {{-- 「与信限度額」 --}}
                        <label>
                            <span style="width:8.5em;">{{__('yoshingendogaku')}}</span>
                            <input name="dataYoshingendogaku" class="form-control" type="text"
                                maxlength="20" autocomplete="off" style="width:10em;">
                        </label>
                    </div>
                    <div class="display">
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0 500 0 0;">
                        {{-- 「回収方法2」 --}}
                        <label>
                            <span id="displayKaishuhouhou2" style="width:1em;display:none;" >{{__('kaishuhouhou2')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbKaishuhouhou2" style="width:1em;display:none;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataKaishuhouhou2" type="hidden">
                        </label>
                        {{-- 「入金予定月2」 --}}
                        <label>
                            <span id="displayNyukinTsuki2" style="width:1em;display:none;">{{__('nyukin_tsuki2')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbNyukinTsuki2" style="width:1em;display:none;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataNyukinTsuki2" type="hidden">
                        </label>
                        {{-- 「入金日2」 --}}
                        <label>
                            <span id="displayNyukinDay2" style="width:1em;display:none;">{{__('nyukin_day2')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbNyukinDay2" style="width:1em;display:none;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataNyukinDay2" type="hidden">
                        </label>
                        {{-- 「手形サイト2」 --}}
                        <label>
                            <span id="displayTegataSate2" style="width:1em;display:none;">{{__('tegata_sate2')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbTegataSate2" style="width:1em;display:none;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataTegataSate2" type="hidden">
                        </label>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab_content" id="sonota_content">
            <div class="tab_content_description">
                <div class="form-column"style="margin: 0 0 0 20">
                    {{-- 「備考1」 --}}
                    <label>
                        <span style="width:10em;">{{__('bikou1')}}</span>
                        <input name="dataBikou1" class="form-control" type="text"
                            maxlength="30" autocomplete="off" style="width:30em;">
                    </label>
                    {{-- 「備考2」 --}}
                    <label>
                        <span style="width:10em;">{{__('bikou2')}}</span>
                        <input name="dataBikou2" class="form-control" type="text"
                            maxlength="30" autocomplete="off" style="width:30em;">
                    </label>
                    {{-- 「備考3」 --}}
                    <label>
                        <span style="width:10em;">{{__('bikou3')}}</span>
                        <input name="dataBikou3" class="form-control" type="text"
                            maxlength="30" autocomplete="off" style="width:30em;">
                    </label>
                    {{-- 「工務用図面保管場所」 --}}
                    <label>
                        <span style="width:10em;">{{__('koum_zumen_hokanbasho')}}</span>
                        <input name="dataKoumZumenHokanbasho" class="form-control" type="text"
                            maxlength="256" autocomplete="off" style="width:30em;">
                    </label>
                    {{-- 「営業用図面保管場所」 --}}
                    <label>
                        <span style="width:10em;">{{__('eigyo_zumen_hokanbasho')}}</span>
                        <input name="dataEigyoZumenHokanbasho" class="form-control" type="text"
                            maxlength="256" autocomplete="off" style="width:30em;">
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="flex-box"style="margin: 0 80px 0 0">
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
                <span style="width:6em;">{{__('touroku_dt')}}</span>
                <input name="dataTourokuDt" class="form-control-plaintext" type="text" readonly>
            </label>
        </div>
        <div class="form-column">
            {{-- 「更新日」 --}}
            <label>
                <span style="width:6em;">{{__('koushin_dt')}}</span>
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

    /* 諸口区分選択値 */
    var shokuchiKbn = [];
    {{-- 諸口区分データ登録値 --}}
    var shokuchiKbnValue = [];
    {{-- 諸口区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHOGUCHI_KBN);$i++)
        @if(SHOGUCHI_KBN[$i] !== '')
            shokuchiKbn.push('{{ SHOGUCHI_KBN[$i] }}');
            shokuchiKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 納品書見出区分選択値 --}}
    var nouhinshoMidashiKbn = [];
    {{-- 納品書見出区分データ登録値 --}}
    var nouhinshoMidashiKbnValue = [];
    {{-- 納品書見出区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(NOUHINSHO_MIDASHI_KBN);$i++)
        @if(NOUHINSHO_MIDASHI_KBN[$i] !== '')
            nouhinshoMidashiKbn.push('{{ NOUHINSHO_MIDASHI_KBN[$i] }}');
            nouhinshoMidashiKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 納品書発行区分選択値 --}}
    var nouhinshoHakkouKbn = [];
    {{-- 納品書発行区分データ登録値 --}}
    var nouhinshoHakkouKbnValue = [];
    {{-- 納品書発行区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(NOUHINSHO_HAKKOU_KBN);$i++)
        @if(NOUHINSHO_HAKKOU_KBN[$i] !== '')
            nouhinshoHakkouKbn.push('{{ NOUHINSHO_HAKKOU_KBN[$i] }}');
            nouhinshoHakkouKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 専用伝票発行区分選択値 --}}
    var senyouDenpyouHakkouKbn = [];
    {{-- 専用伝票発行区分データ登録値 --}}
    var senyouDenpyouHakkouKbnValue = [];
    {{-- 専用伝票発行区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SENYOU_DENPYOU_HAKKOU_KBN);$i++)
        @if(SENYOU_DENPYOU_HAKKOU_KBN[$i] !== '')
            senyouDenpyouHakkouKbn.push('{{ SENYOU_DENPYOU_HAKKOU_KBN[$i] }}');
            senyouDenpyouHakkouKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 請求書発行区分選択値 --}}
    var seikyushoHakkouKbn = [];
    {{-- 請求書発行区分データ登録値 --}}
    var seikyushoHakkouKbnValue = [];
    {{-- 請求書発行区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SEIKYUSHO_HAKKOU_KBN);$i++)
        @if(SEIKYUSHO_HAKKOU_KBN[$i] !== '')
            seikyushoHakkouKbn.push('{{ SEIKYUSHO_HAKKOU_KBN[$i] }}');
            seikyushoHakkouKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 得意先取引区分選択値 --}}
    var tokuisakiTorihikiKbn = [];
    {{-- 得意先取引区分データ登録値 --}}
    var tokuisakiTorihikiKbnValue = [];
    {{-- 得意先取引区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(TOKUISAKI_TORIHIKI_KBN);$i++)
        @if(TOKUISAKI_TORIHIKI_KBN[$i] !== '')
            tokuisakiTorihikiKbn.push('{{ TOKUISAKI_TORIHIKI_KBN[$i] }}');
            tokuisakiTorihikiKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 請求先取引区分選択値 --}}
    var seikyusakiTorihikiKbn = [];
    {{-- 請求先取引区分データ登録値 --}}
    var seikyusakiTorihikiKbnValue = [];
    {{-- 請求先取引区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SEIKYUSAKI_TORIHIKI_KBN);$i++)
        @if(SEIKYUSAKI_TORIHIKI_KBN[$i] !== '')
            seikyusakiTorihikiKbn.push('{{ SEIKYUSAKI_TORIHIKI_KBN[$i] }}');
            seikyusakiTorihikiKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 振込手数料区分選択値 --}}
    var hurikomiTesuryouKbn = [];
    {{-- 振込手数料区分データ登録値 --}}
    var hurikomiTesuryouKbnValue = [];
    {{-- 振込手数料区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(FURIKOMI_TESURYOU_KBN);$i++)
        @if(FURIKOMI_TESURYOU_KBN[$i] !== '')
            hurikomiTesuryouKbn.push('{{ FURIKOMI_TESURYOU_KBN[$i] }}');
            hurikomiTesuryouKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 消費税計算単位選択値 --}}
    var shouhizeiKeisanTani = [];
    {{-- 消費税計算単位データ登録値 --}}
    var shouhizeiKeisanTaniValue = [];
    {{-- 消費税計算単位の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHOUHIZEI_KEISAN_TANI);$i++)
        @if(SHOUHIZEI_KEISAN_TANI[$i] !== '')
            shouhizeiKeisanTani.push('{{ SHOUHIZEI_KEISAN_TANI[$i] }}');
            shouhizeiKeisanTaniValue.push({{ $i }});
        @endif
    @endfor
    {{-- 消費税計算方式選択値 --}}
    var shohizeiKeisanHoushiki = [];
    {{-- 消費税計算方式データ登録値 --}}
    var shohizeiKeisanHoushikiValue = [];
    {{-- 消費税計算方式の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHOUHIZEI_KEISAN_HOUSHIKI);$i++)
        @if(SHOUHIZEI_KEISAN_HOUSHIKI[$i] !== '')
            shohizeiKeisanHoushiki.push('{{ SHOUHIZEI_KEISAN_HOUSHIKI[$i] }}');
            shohizeiKeisanHoushikiValue.push({{ $i }});
        @endif
    @endfor
    {{-- 消費税計算丸目選択値 --}}
    var shohizeiKeisanMarume = [];
    {{-- 消費税計算丸目データ登録値 --}}
    var shohizeiKeisanMarumeValue = [];
    {{-- 消費税計算丸目の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHOUHIZEI_KEISAN_MARUME);$i++)
        @if(SHOUHIZEI_KEISAN_MARUME[$i] !== '')
            shohizeiKeisanMarume.push('{{ SHOUHIZEI_KEISAN_MARUME[$i] }}');
            shohizeiKeisanMarumeValue.push({{ $i }});
        @endif
    @endfor
    {{-- 金額計算丸目選択値 --}}
    var kingakuKeisanMarume = [];
    {{-- 金額計算丸目データ登録値 --}}
    var kingakuKeisanMarumeValue = [];
    {{-- 金額計算丸目の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(KINGAKU_KEISAN_MARUME);$i++)
        @if(KINGAKU_KEISAN_MARUME[$i] !== '')
            kingakuKeisanMarume.push('{{ KINGAKU_KEISAN_MARUME[$i] }}');
            kingakuKeisanMarumeValue.push({{ $i }});
        @endif
    @endfor
    {{-- 締日1選択値 --}}
    var shimebi1 = [];
    {{-- 締日1データ登録値 --}}
    var shimebi1Value = [];
    {{-- 締日1の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIME_DAY1);$i++)
        @if(SHIME_DAY1[$i] !== '')
            shimebi1.push('{{ SHIME_DAY1[$i] }}');
            shimebi1Value.push({{ $i }});
        @endif
    @endfor
    {{-- 締日2選択値 --}}
    var shimebi2 = [];
    {{-- 締日2データ登録値 --}}
    var shimebi2Value = [];
    {{-- 締日2の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIME_DAY2);$i++)
        @if(SHIME_DAY2[$i] !== '')
            shimebi2.push('{{ SHIME_DAY2[$i] }}');
            shimebi2Value.push({{ $i }});
        @endif
    @endfor
    {{-- 適用月選択値 --}}
    var tekiyouTsuki = [];
    {{-- 適用月データ登録値 --}}
    var tekiyouTsukiValue = [];
    {{-- 適用月の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(TEKIYOU_TSUKI);$i++)
        @if(TEKIYOU_TSUKI[$i] !== '')
            tekiyouTsuki.push('{{ TEKIYOU_TSUKI[$i] }}');
            tekiyouTsukiValue.push({{ $i }});
        @endif
    @endfor
    {{-- 入金予定月1選択値 --}}
    var nyukinYoteiTsuki1 = [];
    {{-- 入金予定月1データ登録値 --}}
    var nyukinYoteiTsuki1Value = [];
    {{-- 入金予定月1の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(NYUKIN_TSUKI1);$i++)
        @if(NYUKIN_TSUKI1[$i] !== '')
            nyukinYoteiTsuki1.push('{{ NYUKIN_TSUKI1[$i] }}');
            nyukinYoteiTsuki1Value.push({{ $i }});
        @endif
    @endfor
    {{-- 入金日1選択値 --}}
    var nyukinbi1 = [];
    {{-- 入金日データ登録値 --}}
    var nyukinbi1Value = [];
    {{-- 入金日の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(NYUKIN_DAY1);$i++)
        @if(NYUKIN_DAY1[$i] !== '')
            nyukinbi1.push('{{ NYUKIN_DAY1[$i] }}');
            nyukinbi1Value.push({{ $i }});
        @endif
    @endfor
    {{-- 回収方法1選択値 --}}
    var kaishuhouhou1 = [];
    {{-- 回収方法1データ登録値 --}}
    var kaishuhouhou1Value = [];
    {{-- 回収方法1の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(KAISHUHOUHOU1);$i++)
        @if(KAISHUHOUHOU1[$i] !== '')
            kaishuhouhou1.push('{{ KAISHUHOUHOU1[$i] }}');
            kaishuhouhou1Value.push({{ $i }});
        @endif
    @endfor
    {{-- 手形サイト1選択値 --}}
    var tegataSate1 = [];
    {{-- 手形サイト1データ登録値 --}}
    var tegataSate1Value = [];
    {{-- 手形サイト1の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(TEGATA_SATE1);$i++)
        @if(TEGATA_SATE1[$i] !== '')
            tegataSate1.push('{{ TEGATA_SATE1[$i] }}');
            tegataSate1Value.push({{ $i }});
        @endif
    @endfor
    {{-- 支払い・回収額上限選択値 --}}
    var shiharaiKaishuJoukenKin = [];
    {{-- 支払い・回収額上限データ登録値 --}}
    var shiharaiKaishuJoukenKinValue = [];
    {{-- 支払い・回収上限の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIHARAI_KAISHU_JOUGEN_KIN);$i++)
        @if(SHIHARAI_KAISHU_JOUGEN_KIN[$i] !== '')
            shiharaiKaishuJoukenKin.push('{{ SHIHARAI_KAISHU_JOUGEN_KIN[$i] }}');
            shiharaiKaishuJoukenKinValue.push({{ $i }});
        @endif
    @endfor
    {{-- 回収方法2選択値 --}}
    var kaishuhouhou2 = [];
    {{-- 回収方法2データ登録値 --}}
    var kaishuhouhou2Value = [];
    {{-- 回収方法2の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(KAISHUHOUHOU2);$i++)
        @if(KAISHUHOUHOU2[$i] !== '')
            kaishuhouhou2.push('{{ KAISHUHOUHOU2[$i] }}');
            kaishuhouhou2Value.push({{ $i }});
        @endif
    @endfor
    {{-- 入金予定月2選択値 --}}
    var nyukinYoteiTsuki2 = [];
    {{-- 入金予定月2データ登録値 --}}
    var nyukinYoteiTsuki2Value = [];
    {{-- 入金予定月2の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(NYUKIN_TSUKI2);$i++)
        @if(NYUKIN_TSUKI2[$i] !== '')
            nyukinYoteiTsuki2.push('{{ NYUKIN_TSUKI2[$i] }}');
            nyukinYoteiTsuki2Value.push({{ $i }});
        @endif
    @endfor
    {{-- 入金日2選択値 --}}
    var nyukinbi2 = [];
    {{-- 入金日2データ登録値 --}}
    var nyukinbi2Value = [];
    {{-- 入金日2の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(NYUKIN_DAY2);$i++)
        @if(NYUKIN_DAY2[$i] !== '')
            nyukinbi2.push('{{ NYUKIN_DAY2[$i] }}');
            nyukinbi2Value.push({{ $i }});
        @endif
    @endfor
    {{-- 手形サイト2選択値 --}}
    var tegataSate2 = [];
    {{-- 手形サイト2データ登録値 --}}
    var tegataSate2Value = [];
    {{-- 手形サイト2の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(TEGATA_SATE2);$i++)
        @if(TEGATA_SATE2[$i] !== '')
            tegataSate2.push('{{ TEGATA_SATE2[$i] }}');
            tegataSate2Value.push({{ $i }});
        @endif
    @endfor
    {{-- 回収口座区分選択値 --}}
    var kaishuKouzaKbn = [];
    {{-- 回収口座区分データ登録値 --}}
    var kaishuKouzaKbnValue = [];
    {{-- 回収口座区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(KAISHUKOUZA_KBN);$i++)
        @if(KAISHUKOUZA_KBN[$i] !== '')
            kaishuKouzaKbn.push('{{ KAISHUKOUZA_KBN[$i] }}');
            kaishuKouzaKbnValue.push({{ $i }});
        @endif
    @endfor
    /* コンボボックス宣言 */
    var cmbShokuchiKbn = new wijmo.input.ComboBox('#cmbShokuchiKbn', { itemsSource: shokuchiKbn, isRequired: false });
    var cmbNouhinshoMidashiKbn = new wijmo.input.ComboBox('#cmbNouhinshoMidashiKbn', { itemsSource: nouhinshoMidashiKbn, isRequired: false });
    var cmbNouhinshoHakkouKbn = new wijmo.input.ComboBox('#cmbNouhinshoHakkouKbn', { itemsSource: nouhinshoHakkouKbn, isRequired: false });
    var cmbSenyouDenpyouHakkouKbn = new wijmo.input.ComboBox('#cmbSenyouDenpyouHakkouKbn', { itemsSource: senyouDenpyouHakkouKbn, isRequired: false });
    var cmbSeikyushoHakkouKbn = new wijmo.input.ComboBox('#cmbSeikyushoHakkouKbn', { itemsSource: seikyushoHakkouKbn, isRequired: false });
    var cmbTokuisakiTorihikiKbn = new wijmo.input.ComboBox('#cmbTokuisakiTorihikiKbn', { itemsSource: tokuisakiTorihikiKbn });
    var cmbSeikyusakiTorihikiKbn = new wijmo.input.ComboBox('#cmbSeikyusakiTorihikiKbn', { itemsSource: seikyusakiTorihikiKbn });
    var cmbHurikomiTesuryouKbn = new wijmo.input.ComboBox('#cmbHurikomiTesuryouKbn', { itemsSource: hurikomiTesuryouKbn });
    var cmbShouhizeiKeisanTani = new wijmo.input.ComboBox('#cmbShouhizeiKeisanTani', { itemsSource: shouhizeiKeisanTani });
    var cmbShohizeiKeisanHoushiki = new wijmo.input.ComboBox('#cmbShohizeiKeisanHoushiki', { itemsSource: shohizeiKeisanHoushiki });
    var cmbShohizeiKeisanMarume = new wijmo.input.ComboBox('#cmbShohizeiKeisanMarume', { itemsSource: shohizeiKeisanMarume });
    var cmbKingakuKeisanMarume = new wijmo.input.ComboBox('#cmbKingakuKeisanMarume', { itemsSource: kingakuKeisanMarume });
    var cmbShimeDay1 = new wijmo.input.ComboBox('#cmbShimeDay1', { itemsSource: shimebi1 });
    var cmbShimeDay2 = new wijmo.input.ComboBox('#cmbShimeDay2', { itemsSource: shimebi2 });
    var cmbTekiyouTsuki = new wijmo.input.ComboBox('#cmbTekiyouTsuki', { itemsSource: tekiyouTsuki });
    var cmbNyukinTsuki1 = new wijmo.input.ComboBox('#cmbNyukinTsuki1', { itemsSource: nyukinYoteiTsuki1 });
    var cmbNyukinDay2 = new wijmo.input.ComboBox('#cmbNyukinDay1', { itemsSource: nyukinbi1 });
    var cmbKaishuhouhou1 = new wijmo.input.ComboBox('#cmbKaishuhouhou1', { itemsSource: kaishuhouhou1 });
    var cmbTegataSate1 = new wijmo.input.ComboBox('#cmbTegataSate1', { itemsSource: tegataSate1 });
    var cmbShiharaiKaishuJoukenKin = new wijmo.input.ComboBox('#cmbShiharaiKaishuJoukenKin', { itemsSource: shiharaiKaishuJoukenKin });
    var cmbKaishuhouhou2 = new wijmo.input.ComboBox('#cmbKaishuhouhou2', { itemsSource: kaishuhouhou2});
    var cmbNyukinTsuki2 = new wijmo.input.ComboBox('#cmbNyukinTsuki2', { itemsSource: nyukinYoteiTsuki2 });
    var cmbNyukinDay2 = new wijmo.input.ComboBox('#cmbNyukinDay2', { itemsSource: nyukinbi2 });
    var cmbTegataSate2 = new wijmo.input.ComboBox('#cmbTegataSate2', { itemsSource: tegataSate2 });
    var cmbKaishuKouzaKbn = new wijmo.input.ComboBox('#cmbKaishuKouzaKbn', { itemsSource: kaishuKouzaKbn });
    
    var dctKaishuhouhou1 = document.getElementById('cmbKaishuhouhou1');
    var dctKaishuhouhou2 = document.getElementById('cmbKaishuhouhou2');
    var dctTegataSate1 = document.getElementById('cmbTegataSate1');
    var dctTegataSate2 = document.getElementById('cmbTegataSate2');
    var dctNyukinDay1 = document.getElementById('cmbNyukinDay1');
    var dctNyukinDay2 = document.getElementById('cmbNyukinDay2');
    var dctNyukinTsuki1 = document.getElementById('cmbNyukinTsuki1');
    var dctNyukinTsuki2 = document.getElementById('cmbNyukinTsuki2');
    var displayKaishuhouhou1  =document.getElementById('displayKaishuhouhou1');
    var displayKaishuhouhou2  =document.getElementById('displayKaishuhouhou2');
    var displayTegataSate1  =document.getElementById('displayTegataSate1');
    var displayTegataSate2  =document.getElementById('displayTegataSate2');
    var displayNyukinDay1  =document.getElementById('displayNyukinDay1');
    var displayNyukinDay2 =document.getElementById('displayNyukinDay2');
    var displayNyukinTsuki1  =document.getElementById('displayNyukinTsuki1');
    var displayNyukinTsuki2  =document.getElementById('displayNyukinTsuki2');

    cmbShiharaiKaishuJoukenKin.selectedIndexChanged.addHandler(function(sender, e)
    {
        if(sender.selectedValue == '0:当該額未満')
        {
            dctKaishuhouhou1.style.display = 'block';
            dctKaishuhouhou2.style.display = 'none';
            displayKaishuhouhou1.style.display='block'
            displayKaishuhouhou2.style.display='none'
            dctNyukinTsuki1.style.display = 'block';
            dctNyukinTsuki2.style.display = 'none';
            displayNyukinTsuki1.style.display='block'
            displayNyukinTsuki2.style.display='none'
            dctNyukinDay1.style.display = 'block';
            dctNyukinDay2.style.display = 'none';
            displayNyukinDay1.style.display='block';
            displayNyukinDay2.style.display='none';
            dctTegataSate1.style.display = 'block';
            dctTegataSate2.style.display = 'none';
            displayTegataSate1.style.display='block';
            displayTegataSate2.style.display='none';
        }
        else if(sender.selectedValue == '1:当該額以上')
        {
            dctKaishuhouhou2.style.display = 'block';
            dctKaishuhouhou1.style.display = 'none';
            displayKaishuhouhou2.style.display='block';
            displayKaishuhouhou1.style.display='none';
            dctNyukinTsuki2.style.display = 'block';
            dctNyukinTsuki1.style.display = 'none';
            displayNyukinTsuki2.style.display='block';
            displayNyukinTsuki1.style.display='none';
            dctNyukinDay2.style.display = 'block';
            dctNyukinDay1.style.display = 'none';
            displayNyukinDay2.style.display='block';
            displayNyukinDay1.style.display='none';
            dctTegataSate2.style.display = 'block';
            dctTegataSate1.style.display = 'none';
            displayTegataSate2.style.display='block';
            displayTegataSate1.style.display='none';
        }
    });

    {{-- カレンダー宣言 --}}
    {{-- 有効期間（自） --}}
    var dateStart = new wijmo.input.InputDate('#dataStartDate');
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
        /* 「表示」ボタンイベント登録 ※common_function.js参照 */
        SetBtnHyouji(fncShowDataGrid);
        /* 「Excel出力」ボタンイベント登録 ※common_function.js参照 */
        SetBtnExcel(fncExportExcel);

        {{-- グリッド初期処理--}}
        InitGrid();

        /* ボタン制御更新 */
        SetEnableButton(0);
        /* 件数更新 */
        $("#zenkenCnt").html(0);

        /* グリッドデータの表示 */
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
        /* MultiRowのレイアウト設定 */
        let columns = [{ cells: [{ binding: 'dataTokuisakiCd',   header: "{{__('tokuisaki_cd')}}", width: 130 },
                                 { binding: 'dataTokuisakiHyoujiName', header: "{{__('tokuisaki_hyouji_name')}}"}]},
                       { cells: [{ binding: 'dataJigyoubuCd', header: "{{__('jigyoubu_cd')}}", width: 130 },
                                 { binding: 'dataJigyoubuName',            header: "{{__('jigyoubu_name')}}"}]},
                       { cells: [{ binding: 'dataTokuisakiName1',        header: "{{__('tokuisaki_name1')}}", width: 130 },
                                 { binding: 'dataTokuisakiName2',      header: "{{__('tokuisaki_name2')}}"}]},
                       { cells: [{ binding: 'dataTokuisakiKana',         header: "{{__('tokuisaki_kana')}}", width:130 },]},
                       { cells: [{ binding: 'dataEigyouTantoushaCd',      header: "{{__('eigyou_tantousha_cd')}}", width:130 },
                                 { binding: 'dataEigyouTantoushaName',      header: "{{__('eigyou_tantousha_name')}}"}]},
                       { cells: [{ binding: 'dataAssistantCd',      header: "{{__('assistant_cd')}}", width:160 },
                                 { binding: 'dataAssistantName',      header: "{{__('eigyou_tantousha_name')}}"}]},
                       { cells: [{ binding: 'dataSeikyusakiCd',      header: "{{__('seikyusaki_cd')}}", width:130 }]},
                       { cells: [{ binding: 'dataNyukinOyaCd',      header: "{{__('nyukin_oya_cd')}}", width:130 }]},
                       { cells: [{ binding: 'dataJusho1',      header: "{{__('jusho1')}}", width:130 },
                                 { binding: 'dataJusho2',      header: "{{__('jusho2')}}", width:130 }]},
                       { cells: [{ binding: 'dataTelNo',      header: "{{__('tel_no')}}", width:130 },
                                 { binding: 'dataFaxNo',      header: "{{__('fax_no')}}", width:130 }]},
                       { cells: [{ binding: 'dataSenpouRenrakusaki',      header: "{{__('senpou_renrakusaki')}}", width:130 }]},
                       { cells: [{ binding: 'dataKeishouKbn',      header: "{{__('keishou_kbn')}}", width:130 }]},
                       { cells: [{ binding: 'dataShokuchiKbn',      header: "{{__('shokuchi_kbn')}}", width:130 }]},
                       { cells: [{ binding: 'dataNouhinshoMidashiKbn',      header: "{{__('nouhinsho_midashi_kbn')}}", width:200 },
                                 { binding: 'dataNouhinshoHakkouKbn',      header: "{{__('nouhinsho_hakkou_kbn')}}"}]},
                       { cells: [{ binding: 'dataSenyouDenpyouHakkouKbn',      header: "{{__('senyou_denpyou_hakkou_kbn')}}", width:200 },
                                 { binding: 'dataSeikyushoHakkouKbn',      header: "{{__('seikyusho_hakkou_kbn')}}"}]},
                       { cells: [{ binding: 'dataTokuisakiTorihikiKbn',      header: "{{__('tokuisaki_torihiki_kbn')}}", width:200 },
                                 { binding: 'dataSeikyusakiTorihikiKbn',      header: "{{__('seikyusaki_torihiki_kbn')}}"}]},
                       { cells: [{ binding: 'dataShohizeiKeisanTani',      header: "{{__('shohizei_keisan_tani')}}", width:200 },
                                 { binding: 'dataShohizeiKeisanHoushiki',      header: "{{__('shohizei_keisan_houshiki')}}"}]},
                       { cells: [{ binding: 'dataShohizeiKeisanMarume',      header: "{{__('shohizei_keisan_marume')}}", width:200 },
                                 { binding: 'dataKingakuKeisanMarume',      header: "{{__('kingaku_keisan_marume')}}"}]},
                       { cells: [{ binding: 'dataShimeDay1',      header: "{{__('shime_day1')}}", width:130 },
                                 { binding: 'dataShimeDay2',      header: "{{__('shime_day2')}}"}]},
                       { cells: [{ binding: 'dataTekiyouTsuki',      header: "{{__('tekiyou_tsuki')}}", width:130 }]},
                       { cells: [{ binding: 'dataKaishuHouhou',      header: "{{__('kaishu_houhou')}}", width:130 }]},
                       { cells: [{ binding: 'dataNyukinTsuki',      header: "{{__('nyukin_tsuki')}}", width:130 }]},
                       { cells: [{ binding: 'dataNyukinDay',      header: "{{__('nyukin_day')}}", width:130 }]},
                       { cells: [{ binding: 'dataTegataSate',      header: "{{__('tegata_sate')}}", width:130 }]},
                       { cells: [{ binding: 'dataFurikomiTesuryouKbn',      header: "{{__('furikomi_tesuryou_kbn')}}", width:200 }]},
                       { cells: [{ binding: 'dataYoshingendogaku',      header: "{{__('yoshingendogaku')}}", width:130 }]},
                       { cells: [{ binding: 'dataKoumuZumenHokanbasho',      header: "{{__('koumu_zumen_hokanbasho')}}", width:200 }]},
                       { cells: [{ binding: 'dataEigyouZumenHokanbasho',      header: "{{__('eigyou_zumen_hokanbasho')}}", width:200 }]},
                       { cells: [{ binding: 'dataBikou1',      header: "{{__('bikou1')}}", width:170 }]},
                       { cells: [{ binding: 'dataBikou2',      header: "{{__('bikou2')}}", width:170 }]},
                       { cells: [{ binding: 'dataBikou3',      header: "{{__('bikou3')}}", width:170 }]},
                       { cells: [{ binding: 'dataBikou4',      header: "{{__('bikou4')}}", width:170 }]},
                       { cells: [{ binding: 'dataStartDate',          header: "{{__('yukoukikan_start_date')}}", width: 150 },
                                 { binding: 'dataEndDate',          header: "{{__('yukoukikan_end_date')}}"}] },
                       { cells: [{ binding: 'dataTourokuDt',            header: "{{__('touroku_dt')}}", width: 180 },
                                 { binding: 'dataKoushinDt',            header: "{{__('koushin_dt')}}"}] },
                       { cells: [{ binding: 'dataTourokushaName',            header: "{{__('tourokusha_name')}}", width: 180 },
                                 { binding: 'dataKoushinshaName',            header: "{{__('koushinsha_name')}}"}] }];
        /* グリッドの設定 */
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
        AjaxData("{{ url('/master/1400') }}", soushinData, fncJushinGridData);
    }
    /* 「Excel出力」ボタンイベント */
    var fncExportExcel = function()
    {
        /* Excel出力用グリッドのレイアウト設定 */
        let columns = [
                    { binding: 'dataTokuisakiCd',   header: "{{__('tokuisaki_cd')}}"},
                    { binding: 'dataTokuisakiHyoujiName', header: "{{__('tokuisaki_hyouji_name')}}"},
                    { binding: 'dataJigyoubuCd', header: "{{__('jigyoubu_cd')}}"},
                    { binding: 'dataJigyoubuName',            header: "{{__('jigyoubu_name')}}"},
                    { binding: 'dataTokuisakiName1',        header: "{{__('tokuisaki_name1')}}"},
                    { binding: 'dataTokuisakiName2',      header: "{{__('tokuisaki_name2')}}"},
                    { binding: 'dataTokuisakiKana',         header: "{{__('tokuisaki_kana')}}"},
                    { binding: 'dataEigyouTantoushaCd',      header: "{{__('eigyou_tantousha_cd')}}"},
                    { binding: 'dataEigyouTantoushaName',      header: "{{__('eigyou_tantousha_name')}}"},
                    { binding: 'dataAssistantCd',      header: "{{__('assistant_cd')}}"},
                    { binding: 'dataAssistantName',      header: "{{__('eigyou_tantousha_name')}}"},
                    { binding: 'keishou_kbn',      header: "{{__('keishou_kbn')}}"},
                    { binding: 'dataShokuchiKbn',      header: "{{__('shokuchi_kbn')}}"},
                    { binding: 'dataTokuisakiTorihikiKbn',      header: "{{__('tokuisaki_torihiki_kbn')}}"},
                    { binding: 'dataNouhinshoMidashiKbn',      header: "{{__('nouhinsho_midashi_kbn')}}"},
                    { binding: 'dataNouhinshoHakkouKbn',      header: "{{__('nouhinsho_hakkou_kbn')}}"},
                    { binding: 'dataSenyouDenpyouHakkouKbn',      header: "{{__('senyou_denpyou_hakkouu_kbn')}}"},
                    { binding: 'dataSeikyushoHakkouKbn',      header: "{{__('seikyusho_hakkou_kbn')}}"},
                    { binding: 'dataSeikyusakiTorihikiKbn',      header: "{{__('seikyusaki_torihiki_kbn')}}"},
                    { binding: 'dataSeikyusakiCd',      header: "{{__('seikyusaki_cd')}}"},
                    { binding: 'dataNyukinOyaCd',      header: "{{__('nyukin_oya_cd')}}"},
                    { binding: 'dataJusho1',      header: "{{__('jusho1')}}"},
                    { binding: 'dataJusho2',      header: "{{__('jusho2')}}"},
                    { binding: 'dataTelNo',      header: "{{__('tel_no')}}"},
                    { binding: 'dataFaxNo',      header: "{{__('fax_no')}}"},
                    { binding: 'dataSenpouRenrakusaki',      header: "{{__('senpou_renrakusaki')}}"},
                    { binding: 'dataShohizeiKeisanTani',      header: "{{__('shohizei_keisan_tani')}}"},
                    { binding: 'dataShohizeiKeisanHoushiki',      header: "{{__('shohizei_keisan_houshiki')}}"},
                    { binding: 'dataShohizeiKeisanMarume',      header: "{{__('shohizei_keisan_marume')}}"},
                    { binding: 'dataKingakuKeisanMarume',      header: "{{__('kingaku_keisan_marume')}}"},
                    { binding: 'dataShimeDay1',      header: "{{__('shime_day1')}}"},
                    { binding: 'dataShimeDay2',      header: "{{__('shime_day2')}}"},
                    { binding: 'dataTekiyouTsuki',      header: "{{__('tekiyou_tsuki')}}"},
                    { binding: 'dataNyukinTsuki',      header: "{{__('nyukin_tsuki')}}"},
                    { binding: 'dataNyukinDay',      header: "{{__('nyukin_day')}}"},
                    { binding: 'dataKaishuHouhou',      header: "{{__('kaishu_houhou')}}"},
                    { binding: 'dataTegataSate',      header: "{{__('tegata_sate')}}"},
                    { binding: 'dataBikou1',      header: "{{__('bikou1')}}"},
                    { binding: 'dataBikou2',      header: "{{__('bikou2')}}"},
                    { binding: 'dataBikou3',      header: "{{__('bikou3')}}"},
                    { binding: 'dataBikou4',      header: "{{__('bikou4')}}"},
                    { binding: 'dataKoumuZumenHokanbasho',      header: "{{__('koumu_zumen_hokanbasho')}}"},
                    { binding: 'dataEigyouZumenHokanbasho',      header: "{{__('eigyou_zumen_hokanbasho')}}"},
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
                {{-- 並び替え条件をオブジェクト配列として返す --}}
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
        {{-- 「得意先CD」 --}}
        nyuryokuData['dataTokuisakiCd'].value = (copy && !insertFlg) ? data['dataTokuisakiCd'] : '';
        nyuryokuData['dataTokuisakiCd'].disabled = !insertFlg;
        {{-- 「得意先名」 --}}
        nyuryokuData['dataTokuisakiHyoujiName'].value = copy ? data['dataTokuisakiHyoujiName'] : '';
        {{-- 「得意先略称名」 --}}
        nyuryokuData['dataTokuisakiRyaku'].value = copy ? data['dataTokuisakiRyaku'] : '';
        {{-- 「得意先略称名2」 --}}
        nyuryokuData['dataTokuisakiRyaku2'].value = copy ? data['dataTokuisakiRyaku2'] : '';
        {{-- 「得意先名」 --}}
        nyuryokuData['dataTokuisakiHyoujiName'].value = copy ? data['dataTokuisakiHyoujiName'] : '';
        {{-- 「得意先名1」 --}}
        nyuryokuData['dataTokuisakiName1'].value = copy ? data['dataTokuisakiName1'] : '';
        {{-- 「得意先名2」 --}}
        nyuryokuData['dataTokuisakiName2'].value = copy ? data['dataTokuisakiName2'] : '';
        {{-- 「得意先名カナ」 --}}
        nyuryokuData['dataTokuisakiKana'].value = copy ? data['dataTokuisakiKana'] : '';
        {{-- 「事業部CD」 --}}
        nyuryokuData['dataJigyoubuCd'].value = copy ? data['dataJigyoubuCd'] : '';
        {{-- 「事業部名」 --}}
        nyuryokuData['dataJigyoubuName'].value = copy ? data['dataJigyoubuName'] : '';
        {{-- 「営業担当者CD」 --}}
        nyuryokuData['dataEigyoTantoushaCd'].value = copy ? data['dataEigyoTantoushaCd'] : '';
        {{-- 「アシスタントCD」 --}}
        nyuryokuData['dataAssistantCd'].value = copy ? data['dataAssistantCd'] : '';
        {{-- 「入金親コード」 --}}
        nyuryokuData['dataNyukinOyaCode'].value = copy ? data['dataNyukinOyaCode'] : '';
        {{-- 「請求先CD」 --}}
        nyuryokuData['dataSeikyusakiCd'].value = copy ? data['dataSeikyusakiCd'] : '';
        /* 「敬称区分」 */
        nyuryokuData['dataKeishouKbn'].value = copy ? data['dataKeishouKbn'] : '';
        /* 「分類名」 */
        nyuryokuData['dataBunruiName'].value = copy ? data['dataBunruiName'] : '';
        /* 「諸口区分」 */
        cmbShokuchiKbn.selectedIndex = (copy && !insertFlg) ? shokuchiKbnValue.indexOf(data['dataShokuchiKbn']) : 0;
        {{-- 「納品書見出区分」 --}}
        cmbNouhinshoMidashiKbn.selectedIndex = (copy && !insertFlg) ? nouhinshoMidashiKbnValue.indexOf(data['dataNouhinshoMidashiKbn']) : 0;
        {{-- 「納品書発行区分」 --}}
        cmbNouhinshoHakkouKbn.selectedIndex = (copy && !insertFlg) ? nouhinshoHakkouKbnValue.indexOf(data['dataNouhinshoHakkouKbn']) : 0;
        {{-- 「専用伝票発行区分」 --}}
        cmbSenyouDenpyouHakkoKbn.selectedIndex = (copy && !insertFlg) ? senyouDenpyouHakkouKbnValue.indexOf(data['dataSenyouDenpyouHakkoKbn']) : 0;
        {{-- 「請求書発行区分」 --}}
        cmbSeikyushoHakkouKbn.selectedIndex = (copy && !insertFlg) ? seikyushoHakkouKbnValue.indexOf(data['dataSeikyushoHakkouKbn']) : 0;
        {{-- 「得意先取引区分」 --}}
        cmbTokuisakiTorihikiKbn.selectedIndex = (copy && !insertFlg) ? tokuisakiTorihikiKbnValue.indexOf(data['dataTokuisakiTorihikiKbn']) : 0;
        {{-- 「請求先取引区分」 --}}
        cmbSeikyusakiTorihikiKbn.selectedIndex = (copy && !insertFlg) ? seikyusakiTorihikiKbnValue.indexOf(data['dataSeikyusakiTorihikiKbn']) : 0;
        {{-- 「振込手数料区分」 --}}
        cmbHurikomiTesuryouKbn.selectedIndex = (copy && !insertFlg) ? hurikomiTesuryouKbnValue.indexOf(data['dataHurikomiTesuryouKbn']) : 0;
        {{-- 「郵便番号」 --}}
        nyuryokuData['dataYubinbangou'].value = copy ? data['dataYubinbangou'] : '';
        {{-- 「住所1」 --}}
        nyuryokuData['dataJusho1'].value = copy ? data['dataJusho1'] : '';
        {{-- 「住所2」 --}}
        nyuryokuData['dataJusho2'].value = copy ? data['dataJusho2'] : '';
        {{-- 「電話番号」 --}}
        nyuryokuData['dataTelNo'].value = copy ? data['dataTelNo'] : '';
        {{-- 「FAX番号」 --}}
        nyuryokuData['dataFaxNo'].value = copy ? data['dataFaxNo'] : '';
        {{-- 「先方連絡先」 --}}
        nyuryokuData['dataSenpouRenrakusaki'].value = copy ? data['dataSenpouRenrakusaki'] : '';
        {{-- 「消費税計算単位」 --}}
        cmbShouhizeiKeisanTani.selectedIndex = (copy && !insertFlg) ? shouhizeiKeisanTaniValue.indexOf(data['dataShohizeiKeisanTani']) : 0;
        {{-- 「消費税計算方式」 --}}
        cmbShohizeiKeisanHoushiki.selectedIndex = (copy && !insertFlg) ? shohizeiKeisanHoushikiValue.indexOf(data['dataShohizeiKeisanHoushiki']) : 0;
        {{-- 「消費税計算丸目」 --}}
        cmbShohizeiKeisanMarume.selectedIndex = (copy && !insertFlg) ? shohizeiKeisanMarumeValue.indexOf(data['dataShohizeiKeisanMarume']) : 0;
        {{-- 「金額計算丸目」 --}}
        cmbKingakuKeisanMarume.selectedIndex = (copy && !insertFlg) ? kingakuKeisanMarumeValue.indexOf(data['dataKingakuKeisanMarume']) : 0;
        /* 「締日1」 */
        let numberFlg=(nyuryokuData['dataShimeDay1'] != 0);
        nyuryokuData['dataShimeDay1'].value = (copy && numberFlg) ? data['dataShimeDay1'] : 1;
        /* 「締日2」 */
        numberFlg=(nyuryokuData['dataShimeDay2'] != 0);
        nyuryokuData['dataShimeDay2'].value = (copy && numberFlg) ? data['dataShimeDay2'] : 1;
        /* 「適用月」 */
        numberFlg=(nyuryokuData['dataTekiyouTsuki'] != 0);
        nyuryokuData['dataTekiyouTsuki'].value = (copy && numberFlg) ? data['dataTekiyouTsuki'] : 1;
        /* 「入金予定月」 */
        cmbNyukinTsuki.selectedIndex = (copy && !insertFlg) ? nyukinYoteiTsukiValue.indexOf(data['dataNyukinTsuki']) : 0;
        /* 「入金日」 */
        numberFlg=(nyuryokuData['dataNyukinDay'] != 0);
        nyuryokuData['dataNyukinDay'].value = (copy && numberFlg) ? data['dataNyukinDay'] : 1;
        /* 「回収方法」 */
        cmbKaishuHouhou.selectedIndex = (copy && !insertFlg) ? kaishuHouhouValue.indexOf(data['dataKaishuHouhou']) : 0;
        /* 「手形サイト」 */
        cmbTegataSate.selectedIndex = (copy && !insertFlg) ? tegataSateValue.indexOf(data['dataTegataSate']) : 0;
        /* 「与信限度額」 */
        nyuryokuData['dataYoshingendogaku'].value = copy ? data['dataYoshingendogaku'] : '';
        {{-- 「備考1」 --}}
        nyuryokuData['dataBikou1'].value = copy ? data['dataBikou1'] : '';
        {{-- 「備考2」 --}}
        nyuryokuData['dataBikou2'].value = copy ? data['dataBikou2'] : '';
        {{-- 「備考3」 --}}
        nyuryokuData['dataBikou3'].value = copy ? data['dataBikou3'] : '';
        /* 「備考4」 */
        nyuryokuData['dataBikou4'].value = copy ? data['dataBikou4'] : '';
        /* 「工務用図面保管場所」 */
        nyuryokuData['dataKoumuZumenHokanbasho'].value = copy ? data['dataKoumuZumenHokanbasho'] : '';
        /* 「営業用図面保管場所」 */
        nyuryokuData['dataEigyouZumenHokanbasho'].value = copy ? data['dataEigyouZumenHokanbasho'] : '';
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
        /* 検索ボタン ※削除時のみ制限 */
        nyuryokuData['btnSanshou'].disabled = deleteFlg;
        nyuryokuData['dataTokuisakiRyaku'].disabled = deleteFlg;        /* 「得意先略称」 */
        nyuryokuData['dataTokuisakiRyaku2'].disabled = deleteFlg;       /* 「得意先略称2」 */
        nyuryokuData['dataTokuisakiHyoujiName'].disabled = deleteFlg;   /* 「表示名」 */
        nyuryokuData['dataTokuisakiName1'].disabled = deleteFlg;        /* 「得意先名1」 */
        nyuryokuData['dataTokuisakiName2'].disabled = deleteFlg;        /* 「得意先名2」 */
        nyuryokuData['dataTokuisakiKana'].disabled = deleteFlg;         /* 「得意先カナ」 */
        nyuryokuData['dataJigyoubuCd'].disabled = deleteFlg;            /* 「事業部CD」 */
        nyuryokuData['dataEigyouTantoushaCd'].disabled = deleteFlg;     /* 「営業担当者CD」 */
        nyuryokuData['dataAssistantCd'].disabled = deleteFlg;           /* 「アシスタントCD」 */
        nyuryokuData['dataNyukinOyaCd'].disabled = deleteFlg;           /* 「入金親CD」 */
        nyuryokuData['dataSeikyusakiCd'].disabled = deleteFlg;          /* 「請求先CD」 */
        nyuryokuData['dataKeishouKbn'].disabled = deleteFlg;            /* 「敬称区分」 */
        cmbShokuchiKbn.isDisabled = deleteFlg;                          /* 「諸口区分」 */
        cmbNouhinshoMidashiKbn.isDisabled = deleteFlg;                  /* 「納品書見出区分」 */
        cmbNouhinshoHakkouKbn.isDisabled = deleteFlg;                   /* 「納品書発行区分」 */
        cmbSenyouDenpyouHakkouKbn.isDisabled = deleteFlg;               /* 「専用伝票区分」 */
        cmbSeikyushoHakkouKbn.isDisabled = deleteFlg;                   /* 「請求書発行区分」 */
        cmbTokuisakiTorihikiKbn.isDisabled = deleteFlg;                 /* 「得意先取引区分」 */
        cmbSeikyusakiTorihikiKbn.isDisabled = deleteFlg;                /* 「請求先取引区分」 */
        cmbFurikomiTesuryouKbn.isDisabled = deleteFlg;                  /* 「振込手数料区分」 */
        nyuryokuData['dataJusho1'].disabled = deleteFlg;                /* 「住所1」 */
        nyuryokuData['dataJusho2'].disabled = deleteFlg;                /* 「住所2」 */
        nyuryokuData['dataTelNo'].disabled = deleteFlg;                 /* 「電話番号」 */
        nyuryokuData['dataFaxNo'].disabled = deleteFlg;                 /* 「FAX番号」 */
        nyuryokuData['dataSenpouRenrakusaki'].disabled = deleteFlg;     /* 「先方連絡先」 */
        cmbShohizeiKeisanTani.isDisabled = deleteFlg;                   /* 「消費税計算単位」 */
        cmbShohizeiKeisanHoushiki.isDisabled = deleteFlg;               /* 「消費税計算方式」 */
        cmbShohizeiKeisanMarume.isDisabled = deleteFlg;                 /* 「消費税計算丸目」 */
        cmbKingakuKeisanMarume.isDisabled = deleteFlg;                  /* 「金額計算丸目」 */
        nyuryokuData['dataShimeDay1'].disabled = deleteFlg;             /* 「締日1」 */
        nyuryokuData['dataShimeDay2'].disabled = deleteFlg;             /* 「締日2」 */
        nyuryokuData['dataTekiyouTsuki'].disabled = deleteFlg;          /* 「適用月（締日2）」 */
        cmbNyukinTsuki.isDisabled = deleteFlg;                          /* 「入金予定月」 */
        nyuryokuData['dataNyukinDay'].disabled = deleteFlg;             /* 「入金日」 */
        cmbKaishuHouhou.isDisabled = deleteFlg;                         /* 「回収方法」 */
        cmbTegataSate.isDisabled = deleteFlg;                           /* 「手形サイト」 */
        nyuryokuData['dataYoshingendogaku'].disabled = deleteFlg;       /* 「与信限度額」 */
        nyuryokuData['dataBikou1'].disabled = deleteFlg;                /* 「備考1」 */
        nyuryokuData['dataBikou2'].disabled = deleteFlg;                /* 「備考2」 */
        nyuryokuData['dataBikou3'].disabled = deleteFlg;                /* 「備考3」 */
        nyuryokuData['dataBikou4'].disabled = deleteFlg;                /* 「備考4」 */
        nyuryokuData['dataKoumuZumenHokanbasho'].disabled = deleteFlg;  /* 「工務用図面保管場所」 */
        nyuryokuData['dataEigyouZumenHokanbasho'].disabled = deleteFlg; /* 「営業用図面保管場所」 */
        dateStart.isDisabled = deleteFlg;                               /* 「有効期間（自）」 */

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
        /* ボタン制御更新 */
        SetEnableButton(data[1].length);
        /* 件数更新 */
        $("#zenkenCnt").html(data[1].length);
        /* グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 */
        selectedRows = SortMultiRowData(gridMaster, data[1], 'dataTokuisakiCd');
    }

    /* DBデータ更新 */
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
            if((nyuryokuData['dataTokuisakiRyaku'].value != data['dataTokuisakiRyaku']) &&
              !(nyuryokuData['dataTokuisakiRyaku'].value == '' && data['dataTokuisakiRyaku'] == null)) return true;
            if((nyuryokuData['dataTokuisakiRyaku2'].value != data['dataTokuisakiRyaku2']) &&
              !(nyuryokuData['dataTokuisakiRyaku2'].value == '' && data['dataTokuisakiRyaku2'] == null)) return true;
            if((nyuryokuData['dataTokuisakiHyoujiName'].value != data['dataTokuisakiHyoujiName']) &&
              !(nyuryokuData['dataTokuisakiHyoujiName'].value == '' && data['dataTokuisakiHyoujiName'] == null)) return true;
            if((nyuryokuData['dataTokuisakiName1'].value != data['dataTokuisakiName1']) &&
              !(nyuryokuData['dataTokuisakiName1'].value == '' && data['dataTokuisakiName1'] == null)) return true;
            if((nyuryokuData['dataTokuisakiName2'].value != data['dataTokuisakiName2']) &&
              !(nyuryokuData['dataTokuisakiName2'].value == '' && data['dataTokuisakiName2'] == null)) return true;
            if((nyuryokuData['dataTokuisakiKana'].value != data['dataTokuisakiKana']) &&
              !(nyuryokuData['dataTokuisakiKana'].value == '' && data['dataTokuisakiKana'] == null)) return true;
            if(nyuryokuData['dataJigyoubuCd'].value != data['dataJigyoubuCd']) return true;
            if(nyuryokuData['dataJigyoubuName'].value != data['dataJigyoubuName']) return true;
            if((nyuryokuData['dataEigyouTantoushaCd'].value != data['dataEigyouTantoushaCd']) &&
              !(nyuryokuData['dataEigyouTantoushaCd'].value == '' && data['dataEigyouTantoushaCd'] == null)) return true;
            if((nyuryokuData['dataEigyouTantoushaName'].value != data['dataEigyouTantoushaName']) &&
              !(nyuryokuData['dataEigyouTantoushaName'].value == '' && data['dataEigyouTantoushaName'] == null)) return true;
            if((nyuryokuData['dataAssistantCd'].value != data['dataAssistantCd']) &&
              !(nyuryokuData['dataAssistantCd'].value == '' && data['dataAssistantCd'] == null)) return true;
            if((nyuryokuData['dataAssistantName'].value != data['dataAssistantName']) &&
              !(nyuryokuData['dataAssistantName'].value == '' && data['dataAssistantName'] == null)) return true;
            if((nyuryokuData['dataNyukinOyaCd'].value != data['dataNyukinOyaCd']) &&
              !(nyuryokuData['dataNyukinOyaCd'].value == '' && data['dataNyukinOyaCd'] == null)) return true;
            if((nyuryokuData['dataSeikyusakiCd'].value != data['dataSeikyusakiCd']) &&
              !(nyuryokuData['dataSeikyusakiCd'].value == '' && data['dataSeikyusakiCd'] == null)) return true;
            if((nyuryokuData['dataKeishouKbn'].value != data['dataKeishouKbn']) &&
              !(nyuryokuData['dataKeishouKbn'].value == '' && data['dataKeishouKbn'] == null)) return true;
            if(shokuchiKbnValue[cmbShokuchiKbn.selectedIndex] != data['dataShokuchiKbn']) return true;
            if(nouhinshoMidashiKbnValue[cmbNouhinshoMidashiKbn.selectedIndex] != data['dataNouhinshoMidashiKbn']) return true;
            if(nouhinshoHakkouKbnValue[cmbNouhinshoHakkouKbn.selectedIndex] != data['dataNouhinshoHakkouKbn']) return true;
            if(senyouDenpyouHakkouKbnValue[cmbSenyouDenpyouHakkoKbn.selectedIndex] != data['dataSenyouDenpyouHakkoKbn']) return true;
            if(seikyushoHakkoKbnValue[cmbSeikyushoHakkouKbn.selectedIndex] != data['dataSeikyushoHakkoKbn']) return true;
            if(tokuisakiTorihikiKbnValue[cmbTokuisakiTorihikiKbn.selectedIndex] != data['dataTokuisakiTorihikiKbn']) return true;
            if(seikyusakiTorihikiKbnValue[cmbSeikyusakiTorihikiKbn.selectedIndex] != data['dataSeikyusakiTorihikiKbn']) return true;
            if(hurikomiTesuryouKbnValue[cmbHurikomiTesuryouKbn.selectedIndex] != data['dataFurikomiTesuryouKbn']) return true;
            if(nyuryokuData['dataYubinbangou'].value != data['dataYubinbangou']) return true;
            if(nyuryokuData['dataJusho1'].value != data['dataJusho1']) return true;
            if(nyuryokuData['dataJusho2'].value != data['dataJusho2']) return true;
            if(nyuryokuData['dataTelNo'].value != data['dataTelNo']) return true;
            if(nyuryokuData['dataFaxNo'].value != data['dataFaxNo']) return true;
            if(nyuryokuData['dataSenpouRenrakusaki'].value != data['dataSenpouRenrakusaki']) return true;
            if(shouhizeiKeisanTaniValue[cmbShouhizeiKeisanTani.selectedIndex] != data['dataShohizeiKeisanTani']) return true;
            if(shohizeiKeisanHoushikiValue[cmbShohizeiKeisanHoushiki.selectedIndex] != data['dataShohizeiKeisanHoushiki']) return true;
            if(shohizeiKeisanMarumeValue[cmbShohizeiKeisanMarume.selectedIndex] != data['dataShohizeiKeisanMarume']) return true;
            if(kingakuKeisanMarumeValue[cmbKingakuKeisanMarume.selectedIndex] != data['dataKingakuKeisanMarume']) return true;
            if(shimebi1Value[cmbShimeDay1.selectedIndex] != data['dataShimeDay1']) return true;
            if(shimebi2Value[cmbShimeDay2.selectedIndex] != data['dataShimeDay2']) return true;
            if(tekiyouTsukiValue[cmbTekiyouTsuki.selectedIndex] != data['dataTekiyouTsuki']) return true;
            if(nyukinYoteiTsuki1Value[cmbNyukinTsuki1.selectedIndex] != data['dataNyukinTsuki1']) return true;
            if(nyukinbi1Value[cmbNyukinDay1.selectedIndex] != data['dataNyukinDay1']) return true;
            if(kaishuhouhou1Value[cmbKaishuhouhou1.selectedIndex] != data['dataKaishuhouhou1']) return true;
            if(tegataSate1Value[cmbTegataSate1.selectedIndex] != data['dataTegataSate1']) return true;
            if(shiharaiKaishuJoukenKinValue[cmbShiharaiKaishuJoukenKin.selectedIndex] != data['dataShiharaiKaishuJoukenKin']) return true;
            if(kaishuhouhou2Value[cmbKaishuhouhou2.selectedIndex] != data['dataKaishuhouhou2']) return true;
            if(nyukinYoteiTsuki2Value[cmbNyukinTsuki2.selectedIndex] != data['dataNyukinTsuki2']) return true;
            if(nyukinbi2Value[cmbNyukinDay2.selectedIndex] != data['dataNyukinDay2']) return true;
            if(tegataSate2Value[cmbTegataSate2.selectedIndex] != data['dataTegataSate2']) return true;
            if(kaishukouzaKbnValue[cmbKaishukouzaKbn.selectedIndex] != data['dataKaishukouzaKbn']) return true;
            if(nyuryokuData['dataKaishukouzaNo'].value != data['dataKaishukouzaNo']) return true;
            if(nyuryokuData['dataYoshingendogaku'].value != data['dataYoshingendogaku']) return true;
            if(nyuryokuData['dataBikou1'].value != data['dataBikou1']) return true;
            if(nyuryokuData['dataBikou2'].value != data['dataBikou2']) return true;
            if(nyuryokuData['dataBikou3'].value != data['dataBikou3']) return true;
            if(nyuryokuData['dataKoumZumenHokanbasho'].value != data['dataKoumZumenHokanbasho']) return true;
            if(nyuryokuData['dataEigyoZumenHokanbasho'].value != data['dataEigyoZumenHokanbasho']) return true;
            /*{{-- 「メニューGRCD」 --}}
            if((nyuryokuData['dataMenuGroupCd'].value != data['dataMenuGroupCd']) &&
              !(nyuryokuData['dataMenuGroupCd'].value == '' && data['dataMenuGroupCd'] == null)) return true;*/
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
        /* 権限区分のコンボボックスの値取得 */
        nyuryokuData['dataShokuchiKbn'].value = shokuchiKbnValue[cmbShokuchiKbn.selectedIndex];
        nyuryokuData['dataNouhinshoMidashiKbn'].value = nouhinshoMidashiKbnValue[cmbNouhinshoMidashiKbn.selectedIndex];
        nyuryokuData['dataNouhinshoHakkouKbn'].value = nouhinshoHakkouKbnValue[cmbNouhinshoHakkouKbn.selectedIndex];
        nyuryokuData['dataSenyouDenpyouHakkoKbn'].value = senyouDenpyouHakkouKbnValue[cmbSenyouDenpyouHakkoKbn.selectedIndex];
        nyuryokuData['dataSeikyushoHakkoKbn'].value = seikyushoHakkouKbnValue[cmbSeikyushoHakkouKbn.selectedIndex];
        nyuryokuData['dataTokuisakiTorihikiKbn'].value = tokuisakiTorihikiKbnValue[cmbTokuisakiTorihikiKbn.selectedIndex];
        nyuryokuData['dataSeikyusakiTorihikiKbn'].value = seikyusakiTorihikiKbnValue[cmbSeikyusakiTorihikiKbn.selectedIndex];
        nyuryokuData['dataFurikomiTesuryouKbn'].value = hurikomiTesuryouKbnValue[cmbHurikomiTesuryouKbn.selectedIndex];
        nyuryokuData['dataShohizeiKeisanTani'].value = shouhizeiKeisanTaniValue[cmbShouhizeiKeisanTani.selectedIndex];
        nyuryokuData['dataShohizeiKeisanHoushiki'].value = shohizeiKeisanHoushikiValue[cmbShohizeiKeisanHoushiki.selectedIndex];
        nyuryokuData['dataShohizeiKeisanMarume'].value = shohizeiKeisanMarumeValue[cmbShohizeiKeisanMarume.selectedIndex];
        nyuryokuData['dataKingakuKeisanMarume'].value = kingakuKeisanMarumeValue[cmbKingakuKeisanMarume.selectedIndex];
        nyuryokuData['dataShimeDay1'].value = shimebi1Value[cmbShimeDay1.selectedIndex];
        nyuryokuData['dataShimeDay2'].value = shimebi2Value[cmbShimeDay2.selectedIndex];
        nyuryokuData['dataTekiyouTsuki'].value = tekiyouTsukiValue[cmbTekiyouTsuki.selectedIndex];
        nyuryokuData['dataNyukinTsuki1'].value = nyukinYoteiTsuki1Value[cmbNyukinTsuki1.selectedIndex];
        nyuryokuData['dataNyukinDay1'].value = nyukinbi1Value[cmbNyukinDay1.selectedIndex];
        nyuryokuData['dataKaishuhouhou1'].value = kaishuhouhou1Value[cmbKaishuhouhou1.selectedIndex];
        nyuryokuData['dataTegataSate1'].value = tegataSate1Value[cmbTegataSate1.selectedIndex];
        nyuryokuData['dataShiharaiKaishuJoukenKin'].value = shiharaiKaishuJoukenKinValue[cmbShiharaiKaishuJoukenKin.selectedIndex];
        nyuryokuData['dataKaishuhouhou2'].value = kaishuhouhou2Value[cmbKaishuhouhou2.selectedIndex];
        nyuryokuData['dataNyukinTsuki2'].value = nyukinYoteiTsuki2Value[cmbNyukinTsuki2.selectedIndex];
        nyuryokuData['dataNyukinDay2'].value = nyukinbi2Value[cmbNyukinDay2.selectedIndex];
        nyuryokuData['dataTegataSate2'].value = tegataSate2Value[cmbTegataSate2.selectedIndex];
        nyuryokuData['dataKaishukouzaKbn'].value = kaishuKouzaKbnValue[cmbKaishukouzaKbn.selectedIndex];
        {{-- POST送信用オブジェクト配列 --}}
        let soushinData = {};
        {{-- フォーム要素から送信データを格納 --}}
        for(var i = 0; i< nyuryokuData.length; i++){
            {{-- フォーム要素のnameが宣言されている要素のみ処理 --}}
            if(nyuryokuData[i].name != ''){
                {{-- パスワード設定チェックボックスにチェックが無い場合はパスワードのデータ送信をスキップ --}}
                if(nyuryokuData[i].name == 'dataLoginPass' && !nyuryokuData['chkLoginPass'].checked) continue;
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
                AjaxData("{{ url('/master/1401') }}", soushinData, fncUpdateData);
            }, null);
        }
        else
        {
            {{-- 「データ更新中」表示 --}}
            ShowPopupDlg("{{__('データ更新中')}}");
            {{-- 非同期データ更新開始 --}}
            AjaxData("{{ url('/master/1401') }}", soushinData, fncUpdateData);
        }
    });
    {{-- テキスト変更時に連動するテキスト要素のリセット処理 --}}
    $('input[type="text"]').change(function() {
        {{-- 連動テキスト要素のある要素を判別 --}}
        switch($(this)[0].name)
        {
            {{-- 事業部CD --}}
            case 'dataJigyoubuCd': break;
            /* 該当しない場合は処理終了 */
            break;
            /* 営業担当CD */
            case 'dataEigyouTantoushaCd': break;
            /* 該当しない場合は処理終了 */
            break;
            /* 敬称区分 */
            case 'dataKeishouKbn': break;
            /* 該当しない場合は処理終了 */
            break;
            /* アシスタントCD */
            case 'dataAssistantCd': break;
            /* 該当しない場合は処理終了 */
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
            /* 営業担当者CD */
            case 'dataEigyouTantoushaCd':
            ShowSentakuDlg("{{ __('eigyou_tantousha_cd') }}", "{{ __('eigyou_tantousha_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0400') }}");
            break;
            /* 敬称区分 */
            case 'dataKeishouKbn':
            ShowSentakuDlg("{{ __('keishou_kbn') }}", "{{ __('bunrui_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}");
            break;
            /* アシスタントCD */
            case 'dataAssistantCd':
            ShowSentakuDlg("{{ __('assistant_cd') }}", "{{ __('assistant_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0400') }}");
            break;
        }
    });
</script>
@endsection