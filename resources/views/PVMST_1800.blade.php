{{-- PHP処理 --}}
<?php
    // アクセス権限
    define("KENGEN_KBN", array( '',
                                '閲覧のみ',
                                '',
                                '閲覧・編集（登録）',
                                '',
                                '閲覧・編集（登録、修正、削除）',
                                '',
                                '',
                                '',
                                '全権限'));
                                // アクセス権限
    define("SHIIRE_KBN", array( '',
                                '無し',
                                '',
                                '有り'));
    define("GAICHU_KBN", array( '',
                                '無し',
                                '',
                                '有り'));       
    define("SHIHARAI_KBN", array( '',
                                '無し',
                                '',
                                '有り'));    
    define("HINMOKU_SHIIRE_KBN", array( '',
                                '無し',
                                '',
                                '有り'));     
    define("SHIHARAI_TSUKI1", array( '',
                                '当月',
                                '',
                                '翌月',
                                '',
                                '翌々月'));
    define("SHIHARAI_DAY1", array( '',
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
                                '月末指定'));                           
    define("SHIHARAI_TSUKI2", array( '',
                                '当月',
                                '',
                                '翌月',
                                '',
                                '翌々月'));
    define("SHIHARAI_DAY2", array( '',
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
                                '月末指定'));  
    define("SHIHARAIHOUHOU1", array( '',
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
    define("SHIHARAIHOUHOU2", array( '',
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
    define("SHIHARAIKOUZA_KBN", array( '',
                                '普通',
                                '',
                                '当座'));                      
    define("KEISHO_KBN", array( '',
                                '無し',
                                '',
                                '有り'));
    define("SHOKUCHI_KBN", array( '',
                                '通常',
                                '',
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
    define("SHOHIZEI_KEISAN_TANI", array( '',
                                '未',
                                '',
                                '締単位',
                                '',
                                '伝票単位',
                                '',
                                '明細単位'));
    define("SHOHIZEI_KEISAN_HOUSHIKI", array( '',
                                '内税金',
                                '',
                                '外税（請求単位）',
                                '',
                                '外税（伝票単位）',
                                '',
                                '外税（アイテム単位',
                                '',
                                '対象外',));
    define("SHOHIZEI_KEISAN_MARUME", array( '',
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
{{-- 検索フォーム全体 --}}
<form id="frmKensaku" name="frmKensaku" class="flex-box" style="height:{{ $kensakuHight }};">
    {{-- 一列目 --}}
    <div class="form-column">
        {{-- 「仕入・外注先CD」 --}}
        <label>
            <span style="width:8em;">{{__('shiiresaki_cd')}}</span>
            <span class="icon-field">
            <input name="dataShiiresakiCd" class="form-control code-check" type="text" 
                maxlength="10" autocomplete="off" style="width:10em;" 
                pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}"   required>
            </span>
        </label>
        {{-- 「仕入・外注先名1」 --}}
        <label>
            <span style="width:8em;">{{__('shiiresaki_name1')}}</span>
            <input name="dataShiiresakiName1" class="form-control code-check" type="text" 
                maxlength="10" autocomplete="off" style="width:20em;" required>
        </label>
        {{-- 「事業部CD」 --}}
        <label>
            <span style="width:8em;">{{__('jigyoubu_cd')}}</span>
            <span class="icon-field"> {{-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 --}}
                <input name="dataJigyoubuCd" class="form-control" type="text"
                    maxlength="6" autocomplete="off" style="width:10em;">
                {{-- 検索アイコンは、スタイルクラス「search-btn」を宣言 --}}
                <i class="fas fa-search search-btn"></i>
            </span>
            {{-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする --}}
            <input name="dataJigyoubuName" class="form-control" type="text"
                style="width:20em;" onfocus="blur();" readonly>
        </label>
    </div>
    {{-- 二列目 --}}
    <div class="form-column">
        {{-- 「支払先CD」 --}}
        <label>
            <span style="width:6em;">{{__('shiharaisaki_cd')}}</span>
            <span class="icon-field">
            <input name="dataShiharaisakiCd" class="form-control code-check" type="text" 
                maxlength="10" autocomplete="off" style="width:10em;" 
                    pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}"   required>
                <i class="fas fa-search search-btn"></i>
            </span>
            <input name="dataShiharaisakiName" class="form-control" type="text" 
                style="width:12em;" onfocus="blur();" readonly>
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
            {{-- 「仕入・外注先CD」 --}}
            <label>
                <span style="width:9em;">{{__('shiiresaki_cd')}}</span>
                <span class="icon-field">
                <input name="dataShiiresakiCd" class="form-control code-check" type="text" 
                    maxlength="10" autocomplete="off" style="width:12em;" 
                    pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}"   required>
                </span>
            </label>
            {{-- 「仕入・外注先名1」 --}}
            <label>
                <span style="width:9.4em;">{{__('shiiresaki_name1')}}</span>
                <input name="dataShiiresakiName1" class="form-control code-check" type="text" 
                    maxlength="30" autocomplete="off" style="width:20em;">
            </label>
            {{-- 「仕入・外注先名カナ」 --}}
            <label>
                <span style="width:9.4em;">{{__('shiiresaki_kana')}}</span>
                <input name="dataShiiresakiKana" class="form-control code-check" type="text" 
                    maxlength="60" autocomplete="off" style="width:15em;">
            </label>
            {{-- 「先方連絡先」 --}}
            <label>
                <span style="width:9.4em;">{{__('senpo_renrakusaki')}}</span>
                <input name="dataSenpoRenrakusaki" class="form-control code-check" type="text" 
                    maxlength="128" autocomplete="off" style="width:10em;">
            </label>
            {{-- 「ZIP」 --}}
            <label>
                <span style="width:9.4em;">{{__('shiiresaki_zip')}}</span>
                <input name="dataShiiresakiZip" class="form-control code-check" type="text" 
                    maxlength="10" autocomplete="off" style="width:12em;">
            </label>
            {{-- 「住所1」 --}}
            <label>
                <span style="width:9.4em;">{{__('shiiresaki_jusho1')}}</span>
                <input name="dataShiiresakiJusho1" class="form-control code-check" type="text" 
                    maxlength="60" autocomplete="off" style="width:20em;">
            </label>
            {{-- 「住所2」 --}}
            <label>
                <span style="width:9.4em;">{{__('shiiresaki_jusho2')}}</span>
                <input name="dataShiiresakiJusho2" class="form-control code-check" type="text" 
                    maxlength="60" autocomplete="off" style="width:20em;">
            </label>
            {{-- 「電話番号」 --}}
            <label>
                <span style="width:9.4em;">{{__('Tel_no')}}</span>
                <input name="dataTelNo" class="form-control code-check" type="text" 
                    maxlength="14" autocomplete="off" style="width:15em;">
            </label>
            {{-- 「FAX番号」 --}}
            <label>
                <span style="width:9.4em;">{{__('Fax_no')}}</span>
                <input name="dataFaxNo" class="form-control code-check" type="text" 
                    maxlength="14" autocomplete="off" style="width:15em;">
            </label>
        </div>
        <div class="flex-box flex-center flex-column item-start "style="margin: 0 120px 0 0">
            {{-- 「仕入・外注先名2」 --}}
            <label>
                <span style="width:9.4em;">{{__('shiiresaki_name2')}}</span>
                <input name="dataShiiresakiName2" class="form-control code-check" type="text" 
                    maxlength="30" autocomplete="off" style="width:20em;">
            </label>    
            {{-- 「略称」 --}}
            <label>
                <span style="width:9.4em;">{{__('shiiresaki_ryaku')}}</span>
                <input name="dataShiiresakiRyaku" class="form-control code-check" type="text" 
                    maxlength="20" autocomplete="off" style="width:10em;">
            </label>
            {{-- 「資本金」 --}}
            <label>
                <span style="width:9.4em;">{{__('shihonkin')}}</span>
                <input name="dataShihonkin" class="form-control code-check" type="text" 
                    maxlength="16" autocomplete="off" style="width:10em;">
            </label>
            {{-- 「銀行名」 --}}
            <label>
                <span style="width:9.4em;">{{__('ginkou_name')}}</span>
                <input name="dataGinkouName" class="form-control code-check" type="text" 
                    maxlength="16" autocomplete="off" style="width:15em;">
            </label>
            {{-- 「支店名」 --}}
            <label>
                <span style="width:9.4em;">{{__('shiten_name')}}</span>
                <input name="dataShitenName" class="form-control code-check" type="text" 
                    maxlength="16" autocomplete="off" style="width:15em;">
            </label>
            {{-- 「事業部CD」 --}}
            <label>
                <span style="width:9em;">{{__('jigyoubu_cd')}}</span>
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
            {{-- 「業種分類CD」 --}}
            <label>
                <span style="width:9.4em;">{{__('gyoushu_cd')}}</span>
                <span class="icon-field">
                <input name="dataGyoushuCd" class="form-control code-check" type="text" 
                    maxlength="10" autocomplete="off" style="width:10em;" 
                        pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}">
                    <i class="fas fa-search search-btn"></i>
                </span>
                <input name="dataGyoushuName" class="form-control" type="text" 
                    style="width:14em;" onfocus="blur();" readonly>
            </label>
            {{-- 「敬称区分」 --}}
            <label>
                <span style="width:9.4em;">{{__('keisho_kbn')}}</span>
                {{-- 「」コンボボックス本体 --}}
                <div id="cmbKeishoKbn" style="width:18em;"></div>
                {{-- 「」フォーム送信データ --}}
                <input name="dataKeishoKbn" type="hidden">
            </label>
            {{-- 「諸口区分」 --}}
            <label>
                <span style="width:9.4em;">{{__('shokuchi_kbn')}}</span>
                {{-- 「」コンボボックス本体 --}}
                <div id="cmbShokuchiKbn" style="width:18em;"></div>
                {{-- 「」フォーム送信データ --}}
                <input name="dataShokuchiKbn" type="hidden">
            </label>
            {{-- 「品目別仕入区分」 --}}
            <label>
                <span style="width:9.4em;">{{__('hinmoku_shiire_kbn')}}</span>
                {{-- 「品目別仕入区分」コンボボックス本体 --}}
                <div id="cmbHinmokuShiireKbn" style="width:18em;"></div>
                {{-- 「品目別仕入区分」フォーム送信データ --}}
                <input name="dataHinmokuShiireKbn" type="hidden">
            </label>
        </div>
    </div>
    <div class="tabs">
        <input id="denpyou" type="radio" name="tab_item">
        <label class="tab_item" for="denpyou"style="width:16em;">仕入・外注・税設定</label>
        <input id="seikyu" type="radio" name="tab_item"checked>
        <label class="tab_item" for="seikyu"style="width:16em;">支払い</label>
        <input id="sonota" type="radio" name="tab_item">
        <label class="tab_item" for="sonota"style="width:16em;">他設定</label>
        <div class="tab_content" id="denpyou_content">
            <div class="tab_content_description">
                <div class="flex-box flex-between item-start">
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0 0 0 20">
                        {{-- 「支払区分」 --}}
                        <label>
                            <span style="width:5.5em;">{{__('shiharai_kbn')}}</span>
                            {{-- 「支払区分」コンボボックス本体 --}}
                            <div id="cmbShiharaiKbn" style="width:10em;"></div>
                            {{-- 「支払区分」フォーム送信データ --}}
                            <input name="dataShiharaiKbn" type="hidden">
                        </label>
                        {{-- 「仕入区分」 --}}
                        <label>
                            <span style="width:5.5em;">{{__('shiire_kbn')}}</span>
                            {{-- 「仕入区分」コンボボックス本体 --}}
                            <div id="cmbShiireKbn" style="width:10em;"></div>
                            {{-- 「仕入区分」フォーム送信データ --}}
                            <input name="dataShiireKbn" type="hidden">
                        </label>
                        {{-- 「外注区分」 --}}
                        <label>
                            <span style="width:5.5em;">{{__('gaichu_kbn')}}</span>
                            {{-- 「外注区分」コンボボックス本体 --}}
                            <div id="cmbGaichuKbn" style="width:10em;"></div>
                            {{-- 「外注区分」フォーム送信データ --}}
                            <input name="dataGaichuKbn" type="hidden">
                        </label>
                    </div>
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0 400px 0 0">
                    {{-- 「消費税計算単位」 --}}
                        <label>
                            <span style="width:9em;">{{__('shohizei_keisan_tani')}}</span>
                            {{-- 「消費税計算単位」コンボボックス本体 --}}
                            <div id="cmbShohizeiKeisanTani" style="width:10em;"></div>
                            {{-- 「消費税計算単位」フォーム送信データ --}}
                            <input name="dataShohizeiKeisanTani" type="hidden">
                        </label>
                        {{-- 「消費税計算方式」 --}}
                        <label>
                            <span style="width:9em;">{{__('shohizei_keisan_houshiki')}}</span>
                            {{-- 「消費税計算方式」コンボボックス本体 --}}
                            <div id="cmbShohizeiKeisanHoushiki" style="width:10em;"></div>
                            {{-- 「消費税計算方式」フォーム送信データ --}}
                            <input name="dataShohizeiKeisanHoushiki" type="hidden">
                        </label>
                        {{-- 「消費税計算丸目」 --}}
                        <label>
                            <span style="width:9em;">{{__('shohizei_keisan_marume')}}</span>
                            {{-- 「消費税計算丸目」コンボボックス本体 --}}
                            <div id="cmbShohizeiKeisanMarume" style="width:10em;"></div>
                            {{-- 「消費税計算丸目」フォーム送信データ --}}
                            <input name="dataShohizeiKeisanMarume" type="hidden">
                        </label>
                        {{-- 「金額計算丸目」 --}}
                        <label>
                            <span style="width:9em;">{{__('kingaku_keisan_marume')}}</span>
                            {{-- 「金額計算丸目」コンボボックス本体 --}}
                            <div id="cmbKingakuKeisanMarume" style="width:10em;"></div>
                            {{-- 「金額計算丸目」フォーム送信データ --}}
                            <input name="dataKingakuKeisanMarume" type="hidden">
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab_content" id="seikyu_content">
            <div class="tab_content_description">
                <div class="form-column"style="margin: 0 0 0 20">
                    {{-- 「支払先CD」 --}}
                    <label>
                        <span style="width:9em;">{{__('shiharaisaki_cd')}}</span>
                        <span class="icon-field">
                        <input name="dataShiharaisakiCd" class="form-control code-check" type="text" 
                            maxlength="10" autocomplete="off" style="width:10em;" 
                                pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}">
                            <i class="fas fa-search search-btn"></i>
                        </span>
                        <input name="dataShiharaisakiName" class="form-control" type="text" 
                            style="width:20em;" onfocus="blur();" readonly>
                    </label>
                    {{-- 「支払親コード」 --}}
                    <label>
                        <span style="width:9em;">{{__('shiiresaki_oya_code')}}</span>
                        <span class="icon-field">
                        <input name="dataShiiresakiOyaCode" class="form-control code-check" type="text" 
                            maxlength="10" autocomplete="off" style="width:10em;" 
                                pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}">
                            <i class="fas fa-search search-btn"></i>
                        </span>
                        <input name="dataShiharaisakiName" class="form-control" type="text" 
                            style="width:20em;" onfocus="blur();" readonly>
                    </label>
                </div>
                <div class="flex-box flex-between item-start">
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0 0 0 20">
                        {{-- 「締日1」 --}}
                        <label>
                            <span style="width:9em;">{{__('shime_day1')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbShimeDay1" style="width:9em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataShimeDay1" type="hidden">
                        </label>
                        {{-- 「締日2」 --}}
                        <label>
                            <span style="width:9em;">{{__('shime_day2')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbShimeDay2" style="width:9em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataShimeDay2" type="hidden">
                        </label>
                        {{-- 「適用月（締日２）」 --}}
                        <label>
                            <span style="width:9em;">{{__('tekiyou_tsuki')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbTekiyouTsuki" style="width:9em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataTekiyouTsuki" type="hidden">
                        </label>
                        {{-- 「支払・回収額上限」 --}}
                        <label>
                            <span style="width:9em;">{{__('shiharai_kaishu_jougen_kin')}}</span>
                            {{-- 「支払・回収額上限」コンボボックス本体 --}}
                            <div id="cmbShiharaiKaishuJougenKin" style="width:9em;"></div>
                            {{-- 「支払・回収額上限」フォーム送信データ --}}
                            <input name="dataShiharaiKaishuJougenKin" type="hidden">
                        </label> 
                        {{-- 「支払口座区分」 --}}
                        <label>
                            <span style="width:9em;">{{__('shiharaikouza_kbn')}}</span>
                            {{-- 「支払口座区分」コンボボックス本体 --}}
                            <div id="cmbShiharaikouzaKbn" style="width:9em;"></div>
                            {{-- 「支払口座区分」フォーム送信データ --}}
                            <input name="dataShiharaikouzaKbn" type="hidden">
                        </label> 
                        {{-- 「振込手数料区分」 --}}
                        <label>
                            <span style="width:9em;">{{__('furikomi_tesuryou_kbn')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbFurikomiTesuryouKbn" style="width:9em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataFurikomiTesuryouKbn" type="hidden">
                        </label>   
                    </div>
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0 300 0 0">        
                        {{-- 「支払口座番号」 --}}
                        <label>
                            <span style="width:6em;">{{__('shiharaikouza_no')}}</span>
                            <input name="dataShiharaikouzaNo" class="form-control code-check" type="text" 
                                maxlength="10" autocomplete="off" style="width:10em;" required>
                        </label>    
                        {{-- 「支払予定月1」 --}}
                        <label>
                            <span id="displayShiharaiTsuki1" style="width:6.3em;">{{__('shiharai_tsuki1')}}</span>
                            {{-- 「支払予定月1」コンボボックス本体 --}}
                            <div id="cmbShiharaiTsuki1" style="width:10em;"></div>
                            {{-- 「支払予定月1」フォーム送信データ --}}
                            <input name="dataShiharaiTsuki1" type="hidden">
                        </label>
                        {{-- 「支払日1」 --}}
                        <label>
                            <span id="displayShiharaiDay1" style="width:6.3em;">{{__('shiharai_day1')}}</span>
                            {{-- 「支払日1」コンボボックス本体 --}}
                            <div id="cmbShiharaiDay1" style="width:10em;"></div>
                            {{-- 「支払日1」フォーム送信データ --}}
                            <input name="dataShiharaiDay1" type="hidden">
                        </label>
                        {{-- 「支払方法1」 --}}
                        <label>
                            <span id="displayShiharaihouhou1" style="width:6.3em;">{{__('shiharaihouhou1')}}</span>
                            {{-- 「支払方法1」コンボボックス本体 --}}
                            <div id="cmbShiharaihouhou1" style="width:10em;"></div>
                            {{-- 「支払方法1」フォーム送信データ --}}
                            <input name="dataShiharaihouhou1" type="hidden">
                        </label>
                        {{-- 「手形サイト1」 --}}
                        <label>
                            <span id="displayTegataSate1" style="width:6.3em;">{{__('tegata_sate1')}}</span>
                            {{-- 「」コンボボックス本体 --}}
                            <div id="cmbTegataSate1" style="width:10em;"></div>
                            {{-- 「」フォーム送信データ --}}
                            <input name="dataTegataSate1" type="hidden">
                        </label>
                    </div>
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0 0 0 0;">
                        {{-- 「支払方法2」 --}}
                        <label>
                            <span id="displayShiharaihouhou2" style="width:6em;display:none;">{{__('shiharaihouhou2')}}</span>
                            {{-- 「支払方法2」コンボボックス本体 --}}
                            <div id="cmbShiharaihouhou2" style="width:6em;display:none;"></div>
                            {{-- 「支払方法2」フォーム送信データ --}}
                            <input name="dataShiharaihouhou2" type="hidden">
                        </label>
                        {{-- 「支払予定月2」 --}}
                        <label>
                            <span id="displayShiharaiTsuki2" style="width:1em;display:none;">{{__('shiharai_tsuki2')}}</span>
                            {{-- 「支払予定月2」コンボボックス本体 --}}
                            <div id="cmbShiharaiTsuki2" style="width:1em;display:none;"></div>
                            {{-- 「支払予定月2」フォーム送信データ --}}
                            <input name="dataShiharaiTsuki2" type="hidden">
                        </label>
                        {{-- 「支払日2」 --}}
                        <label>
                            <span id="displayShiharaiDay2" style="width:1em;display:none;">{{__('shiharai_day2')}}</span>
                            {{-- 「支払日2」コンボボックス本体 --}}
                            <div id="cmbShiharaiDay2" style="width:1em;display:none;"></div>
                            {{-- 「支払日2」フォーム送信データ --}}
                            <input name="dataShiharaiDay2" type="hidden">
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
        <div class="tab_content" id="sonota_content">
            <div class="tab_content_description">
                <div class="form-column"style="margin: 0 0 0 20">
                    {{-- 「備考1」 --}}
                    <label>
                        <span style="width:6em;">{{__('bikou1')}}</span>
                        <input name="dataBikou1" class="form-control" type="text"
                            maxlength="30" autocomplete="off" style="width:30em;">
                    </label>
                    {{-- 「備考2」 --}}
                    <label>
                        <span style="width:6em;">{{__('bikou2')}}</span>
                        <input name="dataBikou2" class="form-control" type="text"
                            maxlength="30" autocomplete="off" style="width:30em;">
                    </label>
                    {{-- 「備考3」 --}}
                    <label>
                        <span style="width:6em;">{{__('bikou3')}}</span>
                        <input name="dataBikou3" class="form-control" type="text"
                            maxlength="30" autocomplete="off" style="width:30em;">
                    </label>
                    {{-- 「確認日」 --}}
                    <label>
                        <span style="width:6.3em;">{{__('kakunin_date')}}</span>
                        <input id="dataKakuninDate" name="dataKakuninDate" type="hidden">
                    </label>
                    {{-- 「取引停止日」 --}}
                    <label>
                        <span style="width:6.3em;">{{__('torihiki_teishi_date')}}</span>
                        <input id="dataTorihikiTeishiDate" name="dataTorihikiTeishiDate" type="hidden">
                    </label>
                    {{-- 「取引停止理由」 --}}
                    <label>
                        <span style="width:6em;">{{__('torihiki_teishi_riyuu')}}</span>
                        <input name="dataTorihikiTeishiRiyuu" class="form-control code-check" type="text" 
                            maxlength="10" autocomplete="off" style="width:30em;">
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

    {{-- 敬称区分選択値 --}}
    var keishoKbn = [];
    {{-- 敬称区分データ登録値 --}}
    var keishoKbnValue = [];
    {{-- 敬称区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(KEISHO_KBN);$i++)
        @if(KEISHO_KBN[$i] !== '')
            keishoKbn.push('{{ KEISHO_KBN[$i] }}');
            keishoKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 仕入区分選択値 --}}
    var shiireKbn = [];
    {{-- 仕入区分データ登録値 --}}
    var shiireKbnValue = [];
    {{-- 仕入区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIIRE_KBN);$i++)
        @if(SHIIRE_KBN[$i] !== '')
            shiireKbn.push('{{ SHIIRE_KBN[$i] }}');
            shiireKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 外注区分選択値 --}}
    var gaichuKbn = [];
    {{-- 外注区分データ登録値 --}}
    var gaichuKbnValue = [];
    {{-- 外注区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(GAICHU_KBN);$i++)
        @if(GAICHU_KBN[$i] !== '')
            gaichuKbn.push('{{ GAICHU_KBN[$i] }}');
            gaichuKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 支払区分選択値 --}}
    var shiharaiKbn = [];
    {{-- 支払区分データ登録値 --}}
    var shiharaiKbnValue = [];
    {{-- 支払区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIHARAI_KBN);$i++)
        @if(SHIHARAI_KBN[$i] !== '')
            shiharaiKbn.push('{{ SHIHARAI_KBN[$i] }}');
            shiharaiKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 諸口区分選択値 --}}
    var shokuchiKbn = [];
    {{-- 諸口区分データ登録値 --}}
    var shokuchiKbnValue = [];
    {{-- 諸口区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHOKUCHI_KBN);$i++)
        @if(SHOKUCHI_KBN[$i] !== '')
            shokuchiKbn.push('{{ SHOKUCHI_KBN[$i] }}');
            shokuchiKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 品目別仕入区分選択値 --}}
    var hinmokuShiireKbn = [];
    {{-- 品目別仕入区分データ登録値 --}}
    var hinmokuShiireKbnValue = [];
    {{-- 品目別仕入区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(HINMOKU_SHIIRE_KBN);$i++)
        @if(HINMOKU_SHIIRE_KBN[$i] !== '')
            hinmokuShiireKbn.push('{{ HINMOKU_SHIIRE_KBN[$i] }}');
            hinmokuShiireKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 消費税計算単位選択値 --}}
    var shohizeiKeisanTani = [];
    {{-- 消費税計算単位データ登録値 --}}
    var shohizeiKeisanTaniValue = [];
    {{-- 消費税計算単位の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHOHIZEI_KEISAN_TANI);$i++)
        @if(SHOHIZEI_KEISAN_TANI[$i] !== '')
            shohizeiKeisanTani.push('{{ SHOHIZEI_KEISAN_TANI[$i] }}');
            shohizeiKeisanTaniValue.push({{ $i }});
        @endif
    @endfor
    {{-- 消費税計算方式選択値 --}}
    var shohizeiKeisanHoushiki = [];
    {{-- 消費税計算方式データ登録値 --}}
    var shohizeiKeisanHoushikiValue = [];
    {{-- 消費税計算方式の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHOHIZEI_KEISAN_HOUSHIKI);$i++)
        @if(SHOHIZEI_KEISAN_HOUSHIKI[$i] !== '')
            shohizeiKeisanHoushiki.push('{{ SHOHIZEI_KEISAN_HOUSHIKI[$i] }}');
            shohizeiKeisanHoushikiValue.push({{ $i }});
        @endif
    @endfor
    {{-- 消費税計算丸目選択値 --}}
    var shohizeiKeisanMarume = [];
    {{-- 消費税計算丸目データ登録値 --}}
    var shohizeiKeisanMarumeValue = [];
    {{-- 消費税計算丸目の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHOHIZEI_KEISAN_MARUME);$i++)
        @if(SHOHIZEI_KEISAN_MARUME[$i] !== '')
            shohizeiKeisanMarume.push('{{ SHOHIZEI_KEISAN_MARUME[$i] }}');
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
    var shimeDay1 = [];
    {{-- 締日1データ登録値 --}}
    var shimeDay1Value = [];
    {{-- 締日1の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIME_DAY1);$i++)
        @if(SHIME_DAY1[$i] !== '')
            shimeDay1.push('{{ SHIME_DAY1[$i] }}');
            shimeDay1Value.push({{ $i }});
        @endif
    @endfor
    {{-- 締日2選択値 --}}
    var shimeDay2 = [];
    {{-- 締日2データ登録値 --}}
    var shimeDay2Value = [];
    {{-- 締日2の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIME_DAY2);$i++)
        @if(SHIME_DAY2[$i] !== '')
            shimeDay2.push('{{ SHIME_DAY2[$i] }}');
            shimeDay2Value.push({{ $i }});
        @endif
    @endfor
    {{-- 適用月（締日２）選択値 --}}
    var tekiyouTsuki = [];
    {{-- 適用月（締日２）データ登録値 --}}
    var tekiyouTsukiValue = [];
    {{-- 適用月（締日２）の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(TEKIYOU_TSUKI);$i++)
        @if(TEKIYOU_TSUKI[$i] !== '')
            tekiyouTsuki.push('{{ TEKIYOU_TSUKI[$i] }}');
            tekiyouTsukiValue.push({{ $i }});
        @endif
    @endfor
    {{-- 支払予定月1選択値 --}}
    var shiharaiTsuki1 = [];
    {{-- 支払予定月1データ登録値 --}}
    var shiharaiTsuki1Value = [];
    {{-- 支払予定月1の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIHARAI_TSUKI1);$i++)
        @if(SHIHARAI_TSUKI1[$i] !== '')
            shiharaiTsuki1.push('{{ SHIHARAI_TSUKI1[$i] }}');
            shiharaiTsuki1Value.push({{ $i }});
        @endif
    @endfor
    {{-- 支払日1選択値 --}}
    var shiharaiDay1 = [];
    {{-- 支払日1データ登録値 --}}
    var shiharaiDay1Value = [];
    {{-- 支払日1の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIHARAI_DAY1);$i++)
        @if(SHIHARAI_DAY1[$i] !== '')
            shiharaiDay1.push('{{ SHIHARAI_DAY1[$i] }}');
            shiharaiDay1Value.push({{ $i }});
        @endif
    @endfor
    {{-- 支払方法1選択値 --}}
    var shiharaihouhou1 = [];
    {{-- 支払方法1データ登録値 --}}
    var shiharaihouhou1Value = [];
    {{-- 支払方法1の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIHARAIHOUHOU1);$i++)
        @if(SHIHARAIHOUHOU1[$i] !== '')
            shiharaihouhou1.push('{{ SHIHARAIHOUHOU1[$i] }}');
            shiharaihouhou1Value.push({{ $i }});
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
    {{-- 支払・回収額上限選択値 --}}
    var shiharaiKaishuJougenKin = [];
    {{-- 支払・回収額上限データ登録値 --}}
    var shiharaiKaishuJougenKinValue = [];
    {{-- 支払・回収額上限の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIHARAI_KAISHU_JOUGEN_KIN);$i++)
        @if(SHIHARAI_KAISHU_JOUGEN_KIN[$i] !== '')
            shiharaiKaishuJougenKin.push('{{ SHIHARAI_KAISHU_JOUGEN_KIN[$i] }}');
            shiharaiKaishuJougenKinValue.push({{ $i }});
        @endif
    @endfor
    {{-- 支払予定月2選択値 --}}
    var shiharaiTsuki2 = [];
    {{-- 支払予定月2データ登録値 --}}
    var shiharaiTsuki2Value = [];
    {{-- 支払予定月2の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIHARAI_TSUKI2);$i++)
        @if(SHIHARAI_TSUKI2[$i] !== '')
            shiharaiTsuki2.push('{{ SHIHARAI_TSUKI1[$i] }}');
            shiharaiTsuki2Value.push({{ $i }});
        @endif
    @endfor
    {{-- 支払日2選択値 --}}
    var shiharaiDay2 = [];
    {{-- 支払日2データ登録値 --}}
    var shiharaiDay2Value = [];
    {{-- 支払日2の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIHARAI_DAY2);$i++)
        @if(SHIHARAI_DAY2[$i] !== '')
            shiharaiDay2.push('{{ SHIHARAI_DAY2[$i] }}');
            shiharaiDay2Value.push({{ $i }});
        @endif
    @endfor
    {{-- 支払方法2選択値 --}}
    var shiharaihouhou2 = [];
    {{-- 支払方法2データ登録値 --}}
    var shiharaihouhou2Value = [];
    {{-- 支払方法2の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIHARAIHOUHOU2);$i++)
        @if(SHIHARAIHOUHOU2[$i] !== '')
            shiharaihouhou2.push('{{ SHIHARAIHOUHOU2[$i] }}');
            shiharaihouhou2Value.push({{ $i }});
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
    {{-- 振込手数料区分選択値 --}}
    var furikomiTesuryouKbn = [];
    {{-- 振込手数料区分データ登録値 --}}
    var furikomiTesuryouKbnValue = [];
    {{-- 振込手数料区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(FURIKOMI_TESURYOU_KBN);$i++)
        @if(FURIKOMI_TESURYOU_KBN[$i] !== '')
            furikomiTesuryouKbn.push('{{ FURIKOMI_TESURYOU_KBN[$i] }}');
            furikomiTesuryouKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- 支払口座区分選択値 --}}
    var shiharaikouzaKbn = [];
    {{-- 支払口座区分データ登録値 --}}
    var shiharaikouzaKbnValue = [];
    {{-- 支払口座区分の元データに入力がある場合は選択値として格納 --}}
    @for($i = 0;$i < count(SHIHARAIKOUZA_KBN);$i++)
        @if(SHIHARAIKOUZA_KBN[$i] !== '')
            shiharaikouzaKbn.push('{{ SHIHARAIKOUZA_KBN[$i] }}');
            shiharaikouzaKbnValue.push({{ $i }});
        @endif
    @endfor
    {{-- コンボボックス宣言 --}}
    var cmbKeishoKbn = new wijmo.input.ComboBox('#cmbKeishoKbn', { itemsSource: keishoKbn });
    var cmbShiireKbn = new wijmo.input.ComboBox('#cmbShiireKbn', { itemsSource: shiireKbn });
    var cmbGaichuKbn = new wijmo.input.ComboBox('#cmbGaichuKbn', { itemsSource: gaichuKbn });
    var cmbShiharaiKbn = new wijmo.input.ComboBox('#cmbShiharaiKbn', { itemsSource: shiharaiKbn });
    var cmbShokuchiKbn = new wijmo.input.ComboBox('#cmbShokuchiKbn', { itemsSource: shokuchiKbn });
    var cmbHinmokuShiireKbn = new wijmo.input.ComboBox('#cmbHinmokuShiireKbn', { itemsSource: hinmokuShiireKbn });
    var cmbShohizeiKeisanTani = new wijmo.input.ComboBox('#cmbShohizeiKeisanTani', { itemsSource: shohizeiKeisanTani });
    var cmbShohizeiKeisanHoushiki = new wijmo.input.ComboBox('#cmbShohizeiKeisanHoushiki', { itemsSource: shohizeiKeisanHoushiki });
    var cmbShohizeiKeisanMarume = new wijmo.input.ComboBox('#cmbShohizeiKeisanMarume', { itemsSource: shohizeiKeisanMarume });
    var cmbKingakuKeisanMarume = new wijmo.input.ComboBox('#cmbKingakuKeisanMarume', { itemsSource: kingakuKeisanMarume });
    var cmbShimeDay1 = new wijmo.input.ComboBox('#cmbShimeDay1', { itemsSource: shimeDay1 });
    var cmbShimeDay2 = new wijmo.input.ComboBox('#cmbShimeDay2', { itemsSource: shimeDay2 });
    var cmbTekiyouTsuki = new wijmo.input.ComboBox('#cmbTekiyouTsuki', { itemsSource: tekiyouTsuki });
    var cmbShiharaiTsuki1 = new wijmo.input.ComboBox('#cmbShiharaiTsuki1', { itemsSource: shiharaiTsuki1 });
    var cmbShiharaiDay1 = new wijmo.input.ComboBox('#cmbShiharaiDay1', { itemsSource: shiharaiDay1 });
    var cmbShiharaihouhou1 = new wijmo.input.ComboBox('#cmbShiharaihouhou1', { itemsSource: shiharaihouhou1 });
    var cmbTegataSate1 = new wijmo.input.ComboBox('#cmbTegataSate1', { itemsSource: tegataSate1 });
    var cmbShiharaiKaishuJougenKin = new wijmo.input.ComboBox('#cmbShiharaiKaishuJougenKin', { itemsSource: shiharaiKaishuJougenKin });
    var cmbShiharaiTsuki2 = new wijmo.input.ComboBox('#cmbShiharaiTsuki2', { itemsSource: shiharaiTsuki2 });
    var cmbShiharaiDay2 = new wijmo.input.ComboBox('#cmbShiharaiDay2', { itemsSource: shiharaiDay2 });
    var cmbShiharaihouhou2 = new wijmo.input.ComboBox('#cmbShiharaihouhou2', { itemsSource: shiharaihouhou2 });
    var cmbTegataSate2 = new wijmo.input.ComboBox('#cmbTegataSate2', { itemsSource: tegataSate2 });
    var cmbFurikomiTesuryouKbn = new wijmo.input.ComboBox('#cmbFurikomiTesuryouKbn', { itemsSource: furikomiTesuryouKbn });
    var cmbShiharaikouzaKbn = new wijmo.input.ComboBox('#cmbShiharaikouzaKbn', { itemsSource: shiharaikouzaKbn });
    
    var dctShiharaihouhou1 = document.getElementById('#cmbShiharaihouhou1');
    var dctShiharaihouhou2 = document.getElementById('cmbShiharaihouhou2');
    var dctTegataSate1 = document.getElementById('cmbTegataSate1');
    var dctTegataSate2 = document.getElementById('cmbTegataSate2');
    var dctShiharaiDay1 = document.getElementById('cmbShiharaiDay1');
    var dctShiharaiDay2 = document.getElementById('cmbShiharaiDay2');
    var dctShiharaiTsuki1 = document.getElementById('cmbShiharaiTsuki1');
    var dctShiharaiTsuki2 = document.getElementById('cmbShiharaiTsuki2');
    var displayShiharaihouhou1  =document.getElementById('#displayShiharaihouhou1');
    var displayShiharaihouhou2  =document.getElementById('displayShiharaihouhou2');
    var displayTegataSate1  =document.getElementById('displayTegataSate1');
    var displayTegataSate2  =document.getElementById('displayTegataSate2');
    var displayShiharaiDay1 = document.getElementById('displayShiharaiDay1');
    var displayShiharaiDay2 = document.getElementById('displayShiharaiDay2');
    var displayShiharaiTsuki1  =document.getElementById('displayShiharaiTsuki1');
    var displayShiharaiTsuki2  =document.getElementById('displayShiharaiTsuki2');

    cmbShiharaiKaishuJougenKin.selectedIndexChanged.addHandler(function(sender, e)
    {
        console.log(sender.selectedValue,"sender.selectedValue")
        if(sender.selectedValue == '0:当該額未満')
        {
            dctShiharaihouhou1.style.display = 'block';
            dctShiharaihouhou2.style.display = 'none';
            displayShiharaihouhou1.style.display='block'
            displayShiharaihouhou2.style.display='none'
            dctShiharaiTsuki1.style.display = 'block';
            dctShiharaiTsuki2.style.display = 'none';
            displayShiharaiTsuki1.style.display='block'
            displayShiharaiTsuki2.style.display='none'
            dctShiharaiDay1.style.display = 'block';
            dctShiharaiDay2.style.display = 'none';
            displayNyukinDay1.style.display='block';
            displayNyukinDay2.style.display='none';
            dctTegataSate1.style.display = 'block';
            dctTegataSate2.style.display = 'none';
            displayTegataSate1.style.display='block';
            displayTegataSate2.style.display='none';
        }
        else if(sender.selectedValue == '1:当該額以上')
        {
            dctShiharaihouhou2.style.display = 'block';
            dctShiharaihouhou1.style.display = 'none';
            displayShiharaihouhou2.style.display='block';
            displayShiharaihouhou1.style.display='none';
            dctShiharaiTsuki2.style.display = 'block';
            dctShiharaiTsuki1.style.display = 'none';
            displayShiharaiTsuki2.style.display='block';
            displayShiharaiTsuki1.style.display='none';
            dctShiharaiDay2.style.display = 'block';
            dctShiharaiDay1.style.display = 'none';
            displayShiharaiDay2.style.display='block';
            displayShiharaiDay1.style.display='none';
            dctTegataSate2.style.display = 'block';
            dctTegataSate1.style.display = 'none';
            displayTegataSate2.style.display='block';
            displayTegataSate1.style.display='none';
        }
    });

    {{-- カレンダー宣言 --}}
    {{-- 「確認日」 --}}
    var dataKakunin = new wijmo.input.InputDate('#dataKakuninDate', { isRequired: false });
    {{-- 「取引停止日」 --}}
    var dataTorihikiTeishi = new wijmo.input.InputDate('#dataTorihikiTeishiDate', { isRequired: false });
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
        {{-- 割付ダイアログ表示イベント登録 --}}
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
        {{-- MultiRowのレイアウト設定 --}}
        let columns = [
               { cells: [{ binding: 'dataJigyoubuCd',   header: "{{__('jigyoubu_cd')}}", width: '1*' },]}, 
               { cells: [{ binding: 'dataShiiresakiCd',   header: "{{__('shiiresaki_cd')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiiresakiRyaku',   header: "{{__('shiiresaki_ryaku')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiiresakiName1',   header: "{{__('shiiresaki_name1')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiiresakiName2',   header: "{{__('shiiresaki_name2')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiiresakiKana',   header: "{{__('shiiresaki_kana')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataKeishoKbn',   header: "{{__('keisho_kbn')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiireKbn',   header: "{{__('shiire_kbn')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataGaichuKbn',   header: "{{__('gaichu_kbn')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiharaiKbn',   header: "{{__('shiharai_kbn')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShokuchiKbn',   header: "{{__('shokuchi_kbn')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiharaisakiCd',   header: "{{__('shiharaisaki_cd')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiiresakiOyaCode',   header: "{{__('shiiresaki_oya_code')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiiresakiZip',   header: "{{__('shiiresaki_zip')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiiresakiJusho1',   header: "{{__('shiiresaki_jusho1')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiiresakiJusho2',   header: "{{__('shiiresaki_jusho2')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataTelNo',   header: "{{__('Tel_no')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataFaxNo',   header: "{{__('Fax_no')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataSenpoRenrakusaki',   header: "{{__('senpo_renrakusaki')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataGyoushuCd',   header: "{{__('gyoushu_cd')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShihonkin',   header: "{{__('shihonkin')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataKakuninDate',   header: "{{__('kakunin_date')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataBikou1',   header: "{{__('bikou1')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataBikou2',   header: "{{__('bikou2')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataBikou3',   header: "{{__('bikou3')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataHinmokuShiireKbn',   header: "{{__('hinmoku_shiire_kbn')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShohizeiKeisanTani',   header: "{{__('shohizei_keisan_tani')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShohizeiKeisanHoushiki',   header: "{{__('shohizei_keisan_houshiki')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShohizeiKeisanMarume',   header: "{{__('shohizei_keisan_marume')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataKingakuKeisanMarune',   header: "{{__('kingaku_keisan_marune')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShimeDay1',   header: "{{__('shime_day1')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShimeDay2',   header: "{{__('shime_day2')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataTekiyouTsuki',   header: "{{__('tekiyou_tsuki')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiharaiTsuki1',   header: "{{__('shiharai_tsuki1')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiharaiDay1',   header: "{{__('shiharai_day1')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiharaihouhou1',   header: "{{__('shiharaihouhou1')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataTegataSate1',   header: "{{__('tegata_sate1')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiharaiKaishuJougenKin',   header: "{{__('shiharai_kaishu_jougen_kin')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiharaiTsuki2',   header: "{{__('shiharai_tsuki2')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiharaiDay2',   header: "{{__('shiharai_day2')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiharaihouhou2',   header: "{{__('shiharaihouhou2')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataTegataSate2',   header: "{{__('tegata_sate2')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataFurikomiTesuryouKbn',   header: "{{__('furikomi_tesuryou_kbn')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataGinkouCd',   header: "{{__('ginkou_cd')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShitenCd',   header: "{{__('shiten_cd')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiharaikouzaKbn',   header: "{{__('shiharaikouza_kbn')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataShiharaikouzaNo',   header: "{{__('shiharaikouza_no')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataTorihikiTeishiDate',   header: "{{__('torihiki_teishi_date')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataTorihikiTeishiRiyuu',   header: "{{__('torihiki_teishi_riyuu')}}", width: 130 },]}, 
               { cells: [{ binding: 'dataStartDate',          header: "{{__('yukoukikan_start_date')}}", width: 130 }] },
               { cells: [{ binding: 'dataEndDate',            header: "{{__('yukoukikan_end_date')}}", width: 130 }] },
               { cells: [{ binding: 'dataIndex', width: 0 }] }]; 
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
        AjaxData("{{ url('/master/1800') }}", soushinData, fncJushinGridData);
        {{-- 検索件数の取得フラグの送信データを追加 --}}
        soushinData["dataCntFlg"] = true;
        {{-- 検索件数のデータ受信 --}}
        AjaxData("{{ url('/master/1800') }}", soushinData, fncJushinDataCnt);
    }
    {{-- 「CSV出力」ボタンイベント --}}
    var fncExportCSV = function()
    {
        {{-- CSV出力用グリッドのレイアウト設定 --}}
        let columns = [
                    { binding: 'dataJigyoubuCd',   header: "{{__('jigyoubu_cd')}}" }, 
                    { binding: 'dataShiiresakiCd',   header: "{{__('shiiresaki_cd')}}" }, 
                    { binding: 'dataShiiresakiRyaku',   header: "{{__('shiiresaki_ryaku')}}" }, 
                    { binding: 'dataShiiresakiName1',   header: "{{__('shiiresaki_name1')}}" }, 
                    { binding: 'dataShiiresakiName2',   header: "{{__('shiiresaki_name2')}}" }, 
                    { binding: 'dataShiiresakiKana',   header: "{{__('shiiresaki_kana')}}" }, 
                    { binding: 'dataKeishoKbn',   header: "{{__('keisho_kbn')}}" }, 
                    { binding: 'dataShiireKbn',   header: "{{__('shiire_kbn')}}" }, 
                    { binding: 'dataGaichuKbn',   header: "{{__('gaichu_kbn')}}" }, 
                    { binding: 'dataShiharaiKbn',   header: "{{__('shiharai_kbn')}}" }, 
                    { binding: 'dataShokuchiKbn',   header: "{{__('shokuchi_kbn')}}" }, 
                    { binding: 'dataShiharaisakiCd',   header: "{{__('shiharaisaki_cd')}}" }, 
                    { binding: 'dataShiiresakiOyaCode',   header: "{{__('shiiresaki_oya_code')}}" }, 
                    { binding: 'dataShiiresakiZip',   header: "{{__('shiiresaki_zip')}}" }, 
                    { binding: 'dataShiiresakiJusho1',   header: "{{__('shiiresaki_jusho1')}}" }, 
                    { binding: 'dataShiiresakiJusho2',   header: "{{__('shiiresaki_jusho2')}}" }, 
                    { binding: 'dataTelNo',   header: "{{__('Tel_no')}}" }, 
                    { binding: 'dataFaxNo',   header: "{{__('Fax_no')}}" }, 
                    { binding: 'dataSenpoRenrakusaki',   header: "{{__('senpo_renrakusaki')}}" }, 
                    { binding: 'dataGyoushuCd',   header: "{{__('gyoushu_cd')}}" }, 
                    { binding: 'dataShihonkin',   header: "{{__('shihonkin')}}" }, 
                    { binding: 'dataKakuninDate',   header: "{{__('kakunin_date')}}" }, 
                    { binding: 'dataBikou1',   header: "{{__('bikou1')}}" }, 
                    { binding: 'dataBikou2',   header: "{{__('bikou2')}}" }, 
                    { binding: 'dataBikou3',   header: "{{__('bikou3')}}" }, 
                    { binding: 'dataHinmokuShiireKbn',   header: "{{__('hinmoku_shiire_kbn')}}" }, 
                    { binding: 'dataShohizeiKeisanTani',   header: "{{__('shohizei_keisan_tani')}}" }, 
                    { binding: 'dataShohizeiKeisanHoushiki',   header: "{{__('shohizei_keisan_houshiki')}}" }, 
                    { binding: 'dataShohizeiKeisanMarume',   header: "{{__('shohizei_keisan_marume')}}" }, 
                    { binding: 'dataKingakuKeisanMarune',   header: "{{__('kingaku_keisan_marune')}}" }, 
                    { binding: 'dataShimeDay1',   header: "{{__('shime_day1')}}" }, 
                    { binding: 'dataShimeDay2',   header: "{{__('shime_day2')}}" }, 
                    { binding: 'dataTekiyouTsuki',   header: "{{__('tekiyou_tsuki')}}" }, 
                    { binding: 'dataShiharaiTsuki1',   header: "{{__('shiharai_tsuki1')}}" }, 
                    { binding: 'dataShiharaiDay1',   header: "{{__('shiharai_day1')}}" }, 
                    { binding: 'dataShiharaihouhou1',   header: "{{__('shiharaihouhou1')}}" }, 
                    { binding: 'dataTegataSate1',   header: "{{__('tegata_sate1')}}" }, 
                    { binding: 'dataShiharaiKaishuJougenKin',   header: "{{__('shiharai_kaishu_jougen_kin')}}" }, 
                    { binding: 'dataShiharaiTsuki2',   header: "{{__('shiharai_tsuki2')}}" }, 
                    { binding: 'dataShiharaiDay2',   header: "{{__('shiharai_day2')}}" }, 
                    { binding: 'dataShiharaihouhou2',   header: "{{__('shiharaihouhou2')}}" }, 
                    { binding: 'dataTegataSate2',   header: "{{__('tegata_sate2')}}" }, 
                    { binding: 'dataFurikomiTesuryouKbn',   header: "{{__('furikomi_tesuryou_kbn')}}" }, 
                    { binding: 'dataGinkouCd',   header: "{{__('ginkou_cd')}}" }, 
                    { binding: 'dataShitenCd',   header: "{{__('shiten_cd')}}" }, 
                    { binding: 'dataShiharaikouzaKbn',   header: "{{__('shiharaikouza_kbn')}}" }, 
                    { binding: 'dataShiharaikouzaNo',   header: "{{__('shiharaikouza_no')}}" }, 
                    { binding: 'dataTorihikiTeishiDate',   header: "{{__('torihiki_teishi_date')}}" }, 
                    { binding: 'dataTorihikiTeishiRiyuu',   header: "{{__('torihiki_teishi_riyuu')}}" }, 
                    { binding: 'dataStartDate',          header: "{{__('yukoukikan_start_date')}}"},
                    { binding: 'dataEndDate',            header: "{{__('yukoukikan_end_date')}}" }];
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
        {{-- 「事業部CD」 --}}
        nyuryokuData['dataJigyoubuCd'].value = copy ? data['dataJigyoubuCd'] : '';
        {{-- 「事業部名」 --}}
        nyuryokuData['dataJigyoubuName'].value = copy ? data['dataJigyoubuName'] : '';
        {{-- 「仕入・外注先CD」 --}}
        nyuryokuData['dataShiiresakiCd'].value = (copy && !insertFlg) ? data['dataShiiresakiCd'] : '';
        nyuryokuData['dataShiiresakiCd'].disabled = !insertFlg;
        {{-- 「略称」 --}}
        nyuryokuData['dataShiiresakiRyaku'].value = copy ? data['dataShiiresakiRyaku'] : '';
        {{-- 「仕入・外注先名1」 --}}
        nyuryokuData['dataShiiresakiName1'].value = (copy && !insertFlg) ? data['dataShiiresakiName1'] : '';
        nyuryokuData['dataShiiresakiName1'].disabled = !insertFlg;
        {{-- 「仕入・外注先名2」 --}}
        nyuryokuData['dataShiiresakiName2'].value = copy ? data['dataShiiresakiName2'] : '';
        {{-- 「仕入・外注先名カナ」 --}}
        nyuryokuData['dataShiiresakiKana'].value = copy ? data['dataShiiresakiKana'] : '';
        {{-- 「敬称区分」 --}}
        cmbKeishoKbn.selectedIndex = (copy && !insertFlg) ? keishoKbnValue.indexOf(data['dataKeishoKbn']) : 0;
        {{-- 「仕入区分」 --}}
        cmbShiireKbn.selectedIndex = (copy && !insertFlg) ? shiireKbnValue.indexOf(data['dataShiireKbn']) : 0;
        {{-- 「外注区分」 --}}
        cmbGaichuKbn.selectedIndex = (copy && !insertFlg) ? gaichuKbnValue.indexOf(data['dataGaichuKbn']) : 0;
        {{-- 「支払区分」 --}}
        cmbShiharaiKbn.selectedIndex = (copy && !insertFlg) ? shiharaiKbnValue.indexOf(data['dataShiharaiKbn']) : 0;
        {{-- 「諸口区分」 --}}
        cmbShokuchiKbn.selectedIndex = (copy && !insertFlg) ? shokuchiKbnValue.indexOf(data['dataShokuchiKbn']) : 0;
        {{-- 「支払先CD」 --}}
        nyuryokuData['dataShiharaisakiCd'].value = copy ? data['dataShiharaisakiCd'] : '';
        {{-- 「支払先名」 --}}
        nyuryokuData['dataShiharaisakiName'].value = copy ? data['dataShiharaisakiName'] : '';
        {{-- 「支払親コード」 --}}
        nyuryokuData['dataShiiresakiOyaCode'].value = copy ? data['dataShiiresakiOyaCode'] : '';
        {{-- 「支払先名」 --}}
        nyuryokuData['dataShiharaisakiName'].value = copy ? data['dataShiharaisakiName'] : '';
        {{-- 「ZIP」 --}}
        nyuryokuData['dataShiiresakiZip'].value = copy ? data['dataShiiresakiZip'] : '';
        {{-- 「住所1」 --}}
        nyuryokuData['dataShiiresakiJusho1'].value = copy ? data['dataShiiresakiJusho1'] : '';
        {{-- 「住所2」 --}}
        nyuryokuData['dataShiiresakiJusho2'].value = copy ? data['dataShiiresakiJusho2'] : '';
        {{-- 「電話番号」 --}}
        nyuryokuData['dataTelNo'].value = copy ? data['dataTelNo'] : '';
        {{-- 「FAX番号」 --}}
        nyuryokuData['dataFaxNo'].value = copy ? data['dataFaxNo'] : '';
        {{-- 「先方連絡先」 --}}
        nyuryokuData['dataSenpoRenrakusaki'].value = copy ? data['dataSenpoRenrakusaki'] : '';
        {{-- 「業種分類CD」 --}}
        nyuryokuData['dataGyoushuCd'].value = copy ? data['dataGyoushuCd'] : '';
        {{-- 「業種分類名」 --}}
        nyuryokuData['dataGyoushuName'].value = copy ? data['dataGyoushuName'] : '';
        {{-- 「資本金」 --}}
        nyuryokuData['dataShihonkin'].value = copy ? data['dataShihonkin'] : '';
        {{-- 「確認日」 --}}
        dataKakunin.value = copy ? data['dataKakuninDate'] : '';
        {{-- 「備考1」 --}}
        nyuryokuData['dataBikou1'].value = copy ? data['dataBikou1'] : '';
        {{-- 「備考2」 --}}
        nyuryokuData['dataBikou2'].value = copy ? data['dataBikou2'] : '';
        {{-- 「備考3」 --}}
        nyuryokuData['dataBikou3'].value = copy ? data['dataBikou3'] : '';
        {{-- 「品目別仕入区分」 --}}
        cmbHinmokuShiireKbn.selectedIndex = (copy && !insertFlg) ? hinmokuShiireKbnValue.indexOf(data['dataHinmokuShiireKbn']) : 0;
        {{-- 「消費税計算単位」 --}}
        cmbShohizeiKeisanTani.selectedIndex = (copy && !insertFlg) ? shohizeiKeisanTaniValue.indexOf(data['dataShohizeiKeisanTani']) : 0;
        {{-- 「消費税計算方式」 --}}
        cmbShohizeiKeisanHoushiki.selectedIndex = (copy && !insertFlg) ? shohizeiKeisanHoushikiValue.indexOf(data['dataShohizeiKeisanHoushiki']) : 0;
        {{-- 「消費税計算丸目」 --}}
        cmbShohizeiKeisanMarume.selectedIndex = (copy && !insertFlg) ? shohizeiKeisanMarumeValue.indexOf(data['dataShohizeiKeisanMarume']) : 0;
        {{-- 「金額計算丸目」 --}}
        cmbKingakuKeisanMarume.selectedIndex = (copy && !insertFlg) ? kingakuKeisanMarumeValue.indexOf(data['dataKingakuKeisanMarume']) : 0;
        {{-- 「締日1」 --}}
        cmbShimeDay1.selectedIndex = (copy && !insertFlg) ? shimeDay1Value.indexOf(data['dataShimeDay1']) : 0;
        {{-- 「締日2」 --}}
        cmbShimeDay2.selectedIndex = (copy && !insertFlg) ? shimeDay2Value.indexOf(data['dataShimeDay2']) : 0;
        {{-- 「適用月（締日２）」 --}}
        cmbTekiyouTsuki.selectedIndex = (copy && !insertFlg) ? tekiyouTsukiValue.indexOf(data['dataTekiyouTsuki']) : 0;
        {{-- 「支払予定月1」 --}}
        cmbShiharaiTsuki1.selectedIndex = (copy && !insertFlg) ? shiharaiTsuki1Value.indexOf(data['dataShiharaiTsuki1']) : 0;
        {{-- 「支払日1」 --}}
        cmbShiharaiDay1.selectedIndex = (copy && !insertFlg) ? shiharaiDay1Value.indexOf(data['dataShiharaiDay1']) : 0;
        {{-- 「支払方法1」 --}}
        cmbShiharaihouhou1.selectedIndex = (copy && !insertFlg) ? shiharaihouhou1Value.indexOf(data['dataShiharaihouhou1']) : 0;
        {{-- 「手形サイト1」 --}}
        cmbTegataSate1.selectedIndex = (copy && !insertFlg) ? tegataSate1Value.indexOf(data['dataTegataSate1']) : 0;
        {{-- 「支払・回収額上限」 --}}
        cmbShiharaiKaishuJougenKin.selectedIndex = (copy && !insertFlg) ? shiharaiKaishuJougenKinValue.indexOf(data['dataShiharaiKaishuJougenKin']) : 0;
        {{-- 「支払予定月2」 --}}
        cmbShiharaiTsuki2.selectedIndex = (copy && !insertFlg) ? shiharaiTsuki2Value.indexOf(data['dataShiharaiTsuki2']) : 0;
        {{-- 「支払日2」 --}}
        cmbShiharaiDay2.selectedIndex = (copy && !insertFlg) ? shiharaiDay2Value.indexOf(data['dataShiharaiDay2']) : 0;
        {{-- 「支払方法2」 --}}
        cmbShiharaihouhou2.selectedIndex = (copy && !insertFlg) ? shiharaihouhou2Value.indexOf(data['dataShiharaihouhou2']) : 0;
        {{-- 「手形サイト2」 --}}
        cmbTegataSate2.selectedIndex = (copy && !insertFlg) ? tegataSate2Value.indexOf(data['dataTegataSate2']) : 0;
        {{-- 「振込手数料区分」 --}}
        cmbFurikomiTesuryouKbn.selectedIndex = (copy && !insertFlg) ? furikomiTesuryouKbnValue.indexOf(data['dataFurikomiTesuryouKbn']) : 0;
        {{-- 「銀行名」 --}}
        nyuryokuData['dataGinkouName'].value = copy ? data['dataGinkouName'] : '';
        {{-- 「支店名」 --}}
        nyuryokuData['dataShitenName'].value = copy ? data['dataShitenName'] : '';
        {{-- 「支払口座区分」 --}}
        cmbShiharaikouzaKbn.selectedIndex = (copy && !insertFlg) ? shiharaikouzaKbnValue.indexOf(data['dataShiharaikouzaKbn']) : 0;
        {{-- 「支払口座番号」 --}}
        nyuryokuData['dataShiharaikouzaNo'].value = copy ? data['dataShiharaikouzaNo'] : '';
        {{-- 「取引停止日」 --}}
        dataTorihikiTeishi.value = copy ? data['dataTorihikiTeishiDate'] : '';
        {{-- 「取引停止理由」 --}}
        nyuryokuData['dataTorihikiTeishiRiyuu'].value = copy ? data['dataTorihikiTeishiRiyuu'] : '';
        {{-- 「有効期間（自）」 --}}
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
        nyuryokuData['dataJigyoubuCd'].disabled = deleteFlg; {{-- 「事業部CD」 --}}
        nyuryokuData['dataShiiresakiCd'].disabled = deleteFlg; {{-- 「仕入・外注先CD」 --}}
        nyuryokuData['dataShiiresakiRyaku'].disabled = deleteFlg; {{-- 「略称」 --}}
        nyuryokuData['dataShiiresakiName1'].disabled = deleteFlg; {{-- 「仕入・外注先名1」 --}}
        nyuryokuData['dataShiiresakiName2'].disabled = deleteFlg; {{-- 「仕入・外注先名2」 --}}
        nyuryokuData['dataShiiresakiKana'].disabled = deleteFlg; {{-- 「仕入・外注先名カナ」 --}}
        cmbKeishoKbn.isDisabled = deleteFlg; {{-- 「敬称区分」 --}}
        cmbShiireKbn.isDisabled = deleteFlg; {{-- 「仕入区分」 --}}
        cmbGaichuKbn.isDisabled = deleteFlg; {{-- 「外注区分」 --}}
        cmbShiharaiKbn.isDisabled = deleteFlg; {{-- 「支払区分」 --}}
        cmbShokuchiKbn.isDisabled = deleteFlg; {{-- 「諸口区分」 --}}
        nyuryokuData['dataShiharaisakiCd'].disabled = deleteFlg; {{-- 「支払先CD」 --}}
        nyuryokuData['dataShiiresakiOyaCode'].disabled = deleteFlg; {{-- 「支払親コード」 --}}
        nyuryokuData['dataShiiresakiZip'].disabled = deleteFlg; {{-- 「ZIP」 --}}
        nyuryokuData['dataShiiresakiJusho1'].disabled = deleteFlg; {{-- 「住所1」 --}}
        nyuryokuData['dataShiiresakiJusho2'].disabled = deleteFlg; {{-- 「住所2」 --}}
        nyuryokuData['dataTelNo'].disabled = deleteFlg; {{-- 「電話番号」 --}}
        nyuryokuData['dataFaxNo'].disabled = deleteFlg; {{-- 「FAX番号」 --}}
        nyuryokuData['dataSenpoRenrakusaki'].disabled = deleteFlg; {{-- 「先方連絡先」 --}}
        nyuryokuData['dataGyoushuCd'].disabled = deleteFlg; {{-- 「業種分類CD」 --}}
        nyuryokuData['dataShihonkin'].disabled = deleteFlg; {{-- 「資本金」 --}}
        dataKakunin.disabled = deleteFlg; {{-- 「確認日」 --}}
        nyuryokuData['dataBikou1'].disabled = deleteFlg; {{-- 「備考1」 --}}
        nyuryokuData['dataBikou2'].disabled = deleteFlg; {{-- 「備考2」 --}}
        nyuryokuData['dataBikou3'].disabled = deleteFlg; {{-- 「備考3」 --}}
        cmbHinmokuShiireKbn.isDisabled = deleteFlg; {{-- 「品目別仕入区分」 --}}
        cmbShohizeiKeisanTani.isDisabled = deleteFlg; {{-- 「消費税計算単位」 --}}
        cmbShohizeiKeisanHoushiki.isDisabled = deleteFlg; {{-- 「消費税計算方式」 --}}
        cmbShohizeiKeisanMarume.isDisabled = deleteFlg; {{-- 「消費税計算丸目」 --}}
        cmbKingakuKeisanMarume.isDisabled = deleteFlg; {{-- 「金額計算丸目」 --}}
        cmbShimeDay1.isDisabled = deleteFlg; {{-- 「締日1」 --}}
        cmbShimeDay2.isDisabled = deleteFlg; {{-- 「締日2」 --}}
        cmbTekiyouTsuki.isDisabled = deleteFlg; {{-- 「適用月（締日２）」 --}}
        cmbShiharaiTsuki1.isDisabled = deleteFlg; {{-- 「支払予定月1」 --}}
        cmbShiharaiDay1.isDisabled = deleteFlg; {{-- 「支払日1」 --}}
        cmbShiharaihouhou1.isDisabled = deleteFlg; {{-- 「支払方法1」 --}}
        cmbTegataSate1.isDisabled = deleteFlg; {{-- 「手形サイト1」 --}}
        cmbShiharaiKaishuJougenKin.isDisabled = deleteFlg; {{-- 「支払・回収額上限」 --}}
        cmbShiharaiTsuki2.isDisabled = deleteFlg; {{-- 「支払予定月2」 --}}
        cmbShiharaiDay2.isDisabled = deleteFlg; {{-- 「支払日2」 --}}
        cmbShiharaihouhou2.isDisabled = deleteFlg; {{-- 「支払方法2」 --}}
        cmbTegataSate2.isDisabled = deleteFlg; {{-- 「手形サイト2」 --}}
        cmbFurikomiTesuryouKbn.isDisabled = deleteFlg; {{-- 「振込手数料区分」 --}}
        nyuryokuData['dataGinkouName'].disabled = deleteFlg; {{-- 「銀行名」 --}}
        nyuryokuData['dataShitenName'].disabled = deleteFlg; {{-- 「支店名」 --}}
        cmbShiharaikouzaKbn.isDisabled = deleteFlg; {{-- 「支払口座区分」 --}}
        nyuryokuData['dataShiharaikouzaNo'].disabled = deleteFlg; {{-- 「支払口座番号」 --}}
        dataTorihikiTeishi.disabled = deleteFlg; {{-- 「取引停止日」 --}}
        nyuryokuData['dataTorihikiTeishiRiyuu'].disabled = deleteFlg; {{-- 「取引停止理由」 --}}
        dateStart.isDisabled = deleteFlg;    {{-- 「有効期間（自）」 --}}
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
        selectedRows = SortMultiRowData(gridMaster, data[1], 'dataTantoushaCd');
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
            {{-- 「事業部CD」 --}}
            if(nyuryokuData['dataJigyoubuCd'].value != data['dataJigyoubuCd']) return true;
            {{-- 「仕入・外注先CD」 --}}
            if(nyuryokuData['dataShiiresakiCd'].value != data['dataShiiresakiCd']) return true;
            {{-- 「略称」 --}}
            if(nyuryokuData['dataShiiresakiRyaku'].value != data['dataShiiresakiRyaku']) return true;
            {{-- 「仕入・外注先名1」 --}}
            if(nyuryokuData['dataShiiresakiName1'].value != data['dataShiiresakiName1']) return true;
            {{-- 「仕入・外注先名2」 --}}
            if(nyuryokuData['dataShiiresakiName2'].value != data['dataShiiresakiName2']) return true;
            {{-- 「仕入・外注先名カナ」 --}}
            if(nyuryokuData['dataShiiresakiKana'].value != data['dataShiiresakiKana']) return true;
            {{-- 「敬称区分」 --}}
            if(keishoKbnValue[cmbKeishoKbn.selectedIndex] != data['dataKeishoKbn']) return true;
            {{-- 「仕入区分」 --}}
            if(shiireKbnValue[cmbShiireKbn.selectedIndex] != data['dataShiireKbn']) return true;
            {{-- 「外注区分」 --}}
            if(gaichuKbnValue[cmbGaichuKbn.selectedIndex] != data['dataGaichuKbn']) return true;
            {{-- 「支払区分」 --}}
            if(shiharaiKbnValue[cmbShiharaiKbn.selectedIndex] != data['dataShiharaiKbn']) return true;
            {{-- 「諸口区分」 --}}
            if(shokuchiKbnValue[cmbShokuchiKbn.selectedIndex] != data['dataShokuchiKbn']) return true;
            {{-- 「支払先CD」 --}}
            if(nyuryokuData['dataShiharaisakiCd'].value != data['dataShiharaisakiCd']) return true;
            {{-- 「支払親コード」 --}}
            if(nyuryokuData['dataShiiresakiOyaCode'].value != data['dataShiiresakiOyaCode']) return true;
            {{-- 「ZIP」 --}}
            if(nyuryokuData['dataShiiresakiZip'].value != data['dataShiiresakiZip']) return true;
            {{-- 「住所1」 --}}
            if(nyuryokuData['dataShiiresakiJusho1'].value != data['dataShiiresakiJusho1']) return true;
            {{-- 「住所2」 --}}
            if(nyuryokuData['dataShiiresakiJusho2'].value != data['dataShiiresakiJusho2']) return true;
            {{-- 「電話番号」 --}}
            if(nyuryokuData['dataTelNo'].value != data['dataTelNo']) return true;
            {{-- 「FAX番号」 --}}
            if(nyuryokuData['dataFaxNo'].value != data['dataFaxNo']) return true;
            {{-- 「先方連絡先」 --}}
            if(nyuryokuData['dataSenpoRenrakusaki'].value != data['dataSenpoRenrakusaki']) return true;
            {{-- 「業種分類CD」 --}}
            if(nyuryokuData['dataGyoushuCd'].value != data['dataGyoushuCd']) return true;
            {{-- 「資本金」 --}}
            if(nyuryokuData['dataShihonkin'].value != data['dataShihonkin']) return true;
            {{-- 「確認日」 --}}
            if((nyuryokuData['dataKakuninDate'].value != data['dataKakuninDate']) &&
            !(nyuryokuData['dataKakuninDate'].value == '' && data['dataKakuninDate'] == null)) return true;
            {{-- 「備考1」 --}}
            if(nyuryokuData['dataBikou1'].value != data['dataBikou1']) return true;
            {{-- 「備考2」 --}}
            if(nyuryokuData['dataBikou2'].value != data['dataBikou2']) return true;
            {{-- 「備考3」 --}}
            if(nyuryokuData['dataBikou3'].value != data['dataBikou3']) return true;
            {{-- 「品目別仕入区分」 --}}
            if(hinmokuShiireKbnValue[cmbHinmokuShiireKbn.selectedIndex] != data['dataHinmokuShiireKbn']) return true;
            {{-- 「消費税計算単位」 --}}
            if(shohizeiKeisanTaniValue[cmbShohizeiKeisanTani.selectedIndex] != data['dataShohizeiKeisanTani']) return true;
            {{-- 「消費税計算方式」 --}}
            if(shohizeiKeisanHoushikiValue[cmbShohizeiKeisanHoushiki.selectedIndex] != data['dataShohizeiKeisanHoushiki']) return true;
            {{-- 「消費税計算丸目」 --}}
            if(shohizeiKeisanMarumeValue[cmbShohizeiKeisanMarume.selectedIndex] != data['dataShohizeiKeisanMarume']) return true;
            {{-- 「金額計算丸目」 --}}
            if(kingakuKeisanMarumeValue[cmbKingakuKeisanMarume.selectedIndex] != data['dataKingakuKeisanMarume']) return true;
            {{-- 「締日1」 --}}
            if(shimeDay1Value[cmbShimeDay1.selectedIndex] != data['dataShimeDay1']) return true;
            {{-- 「締日2」 --}}
            if(shimeDay2Value[cmbShimeDay2.selectedIndex] != data['dataShimeDay2']) return true;
            {{-- 「適用月（締日２）」 --}}
            if(tekiyouTsukiValue[cmbTekiyouTsuki.selectedIndex] != data['dataTekiyouTsuki']) return true;
            {{-- 「支払予定月1」 --}}
            if(shiharaiTsuki1Value[cmbShiharaiTsuki1.selectedIndex] != data['dataShiharaiTsuki1']) return true;
            {{-- 「支払日1」 --}}
            if(shiharaiDay1Value[cmbShiharaiDay1.selectedIndex] != data['dataShiharaiDay1']) return true;
            {{-- 「支払方法1」 --}}
            if(shiharaihouhou1Value[cmbShiharaihouhou1.selectedIndex] != data['dataShiharaihouhou1']) return true;
            {{-- 「手形サイト1」 --}}
            if(tegataSate1Value[cmbTegataSate1.selectedIndex] != data['dataTegataSate1']) return true;
            {{-- 「支払・回収額上限」 --}}
            if(shiharaiKaishuJougenKinValue[cmbShiharaiKaishuJougenKin.selectedIndex] != data['dataShiharaiKaishuJougenKin']) return true;
            {{-- 「支払予定月2」 --}}
            if(shiharaiTsuki2Value[cmbShiharaiTsuki2.selectedIndex] != data['dataShiharaiTsuki2']) return true;
            {{-- 「支払日2」 --}}
            if(shiharaiDay2Value[cmbShiharaiDay2.selectedIndex] != data['dataShiharaiDay2']) return true;
            {{-- 「支払方法2」 --}}
            if(shiharaihouhou2Value[cmbShiharaihouhou2.selectedIndex] != data['dataShiharaihouhou2']) return true;
            {{-- 「手形サイト2」 --}}
            if(tegataSate2Value[cmbTegataSate2.selectedIndex] != data['dataTegataSate2']) return true;
            {{-- 「振込手数料区分」 --}}
            if(furikomiTesuryouKbnValue[cmbFurikomiTesuryouKbn.selectedIndex] != data['dataFurikomiTesuryouKbn']) return true;
            {{-- 「銀行名」 --}}
            if(nyuryokuData['dataGinkouName'].value != data['dataGinkouName']) return true;
            {{-- 「支店名」 --}}
            if(nyuryokuData['dataShitenName'].value != data['dataShitenName']) return true;
            {{-- 「支払口座区分」 --}}
            if(shiharaikouzaKbnValue[cmbShiharaikouzaKbn.selectedIndex] != data['dataShiharaikouzaKbn']) return true;
            {{-- 「支払口座番号」 --}}
            if(nyuryokuData['dataShiharaikouzaNo'].value != data['dataShiharaikouzaNo']) return true;
            {{-- 「取引停止日」 --}}
            if((nyuryokuData['dataTorihikiTeishiDate'].value != data['dataTorihikiTeishiDate']) &&
            !(nyuryokuData['dataTorihikiTeishiDate'].value == '' && data['dataTorihikiTeishiDate'] == null)) return true;
            {{-- 「取引停止理由」 --}}
            if(nyuryokuData['dataTorihikiTeishiRiyuu'].value != data['dataTorihikiTeishiRiyuu']) return true;
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
        {{-- 権限区分のコンボボックスの値取得 --}}
        nyuryokuData['dataKeishoKbn'].value = keishoKbnValue[cmbKeishoKbn.selectedIndex];
        nyuryokuData['dataShiireKbn'].value = shiireKbnValue[cmbShiireKbn.selectedIndex];
        nyuryokuData['dataGaichuKbn'].value = gaichuKbnValue[cmbGaichuKbn.selectedIndex];
        nyuryokuData['dataShiharaiKbn'].value = shiharaiKbnValue[cmbShiharaiKbn.selectedIndex];
        nyuryokuData['dataShokuchiKbn'].value = shokuchiKbnValue[cmbShokuchiKbn.selectedIndex];
        nyuryokuData['dataHinmokuShiireKbn'].value = hinmokuShiireKbnValue[cmbHinmokuShiireKbn.selectedIndex];
        nyuryokuData['dataShohizeiKeisanTani'].value = shohizeiKeisanTaniValue[cmbShohizeiKeisanTani.selectedIndex];
        nyuryokuData['dataShohizeiKeisanHoushiki'].value = shohizeiKeisanHoushikiValue[cmbShohizeiKeisanHoushiki.selectedIndex];
        nyuryokuData['dataShohizeiKeisanMarume'].value = shohizeiKeisanMarumeValue[cmbShohizeiKeisanMarume.selectedIndex];
        nyuryokuData['dataKingakuKeisanMarume'].value = kingakuKeisanMarumeValue[cmbKingakuKeisanMarume.selectedIndex];
        nyuryokuData['dataShimeDay1'].value = shimeDay1Value[cmbShimeDay1.selectedIndex];
        nyuryokuData['dataShimeDay2'].value = shimeDay2Value[cmbShimeDay2.selectedIndex];
        nyuryokuData['dataTekiyouTsuki'].value = tekiyouTsukiValue[cmbTekiyouTsuki.selectedIndex];
        nyuryokuData['dataShiharaiTsuki1'].value = shiharaiTsuki1Value[cmbShiharaiTsuki1.selectedIndex];
        nyuryokuData['dataShiharaiDay1'].value = shiharaiDay1Value[cmbShiharaiDay1.selectedIndex];
        nyuryokuData['dataShiharaihouhou1'].value = shiharaihouhou1Value[cmbShiharaihouhou1.selectedIndex];
        nyuryokuData['dataTegataSate1'].value = tegataSate1Value[cmbTegataSate1.selectedIndex];
        nyuryokuData['dataShiharaiTsuki2'].value = shiharaiTsuki2Value[cmbShiharaiTsuki2.selectedIndex];
        nyuryokuData['dataShiharaiDay2'].value = shiharaiDay2Value[cmbShiharaiDay2.selectedIndex];
        nyuryokuData['dataTegataSate2'].value = tegataSate2Value[cmbTegataSate2.selectedIndex];
        nyuryokuData['dataFurikomiTesuryouKbn'].value = furikomiTesuryouKbnValue[cmbFurikomiTesuryouKbn.selectedIndex];
        nyuryokuData['dataShiharaikouzaKbn'].value = shiharaikouzaKbnValue[cmbShiharaikouzaKbn.selectedIndex];
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
                AjaxData("{{url('/master/1801')}}", soushinData, fncUpdateData);
            }, null);
        }
        else
        {
            console.log(soushinData,"soushinData")
            {{-- 「データ更新中」表示 --}}
            ShowPopupDlg("{{__('データ更新中')}}");
            {{-- 非同期データ更新開始 --}}
            AjaxData("{{url('/master/1801')}}", soushinData, fncUpdateData);
        }
    });
    {{-- テキスト変更時に連動するテキスト要素のリセット処理 --}}
    $('input[type="text"]').change(function() {
        {{-- 連動テキスト要素のある要素を判別 --}}
        switch($(this)[0].name)
        {
            {{-- 事業部CD --}}
            case 'dataJigyoubuCd': break;

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
            /*{{-- 請求先CD --}}
            case 'dataSeikyusakiCd':
            ShowSentakuDlg("{{ __('seikyusaki_cd') }}", "{{ __('seikyusaki_name') }}",
                           currentCdElement, currentNameElement, "/inquiry/0?00");
            break;*/
        }
    });
</script>
@endsection