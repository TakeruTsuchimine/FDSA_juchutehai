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
    define("SHOUHIZEI_KEISAN_TANI", array( '未',
                                '締単位',
                                '',
                                '伝票単位',
                                '',
                                '明細単位'));
    define("SHOUHIZEI_KEISAN_HOUSHIKI", array( '内税金',
                                '外税（請求単位）',
                                '',
                                '外税（伝票単位）',
                                '外税（アイテム単位）',
                                '対象外',));
    define("SHOUHIZEI_KEISAN_MARUME", array( '切り捨て',
                                '四捨五入',
                                '',
                                '切上げ'));
    define("KINGAKU_KEISAN_MARUME", array( '',
                                '切り捨て',
                                '',
                                '四捨五入',
                                '',
                                '切上げ'));
    define("SHIHARAI_KAISHU_JOUGEN_KIN", array( '当該額未満',
                                '当該額以上'));
    define("FURIKOMI_TESURYOU_KBN", array( '手数料自社払い',
                                '手数料相手払い'));
    define("KAISHU_KOUZA_KBN", array( '普通',
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
    <!-- 一列目 --> 
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
        {{-- 「業種分類CD」 --}}
        <label>
            <span style="width:8em;">{{__('gyoushu_cd')}}</span>
            <span class="icon-field">
            <input name="dataGyoushuCd" class="form-control code-check" type="text" 
                maxlength="10" autocomplete="off" style="width:10em;" 
                    pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}">
                <i class="fas fa-search search-btn"></i>
            </span>
            <input name="dataGyoushuName" class="form-control" type="text" 
                style="width:14em;" onfocus="blur();" readonly>
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

{{-- 「入力ダイアログ」 --}}
@section('nyuryoku')
<!-- 入力フォーム全体 -->
<div class="flex-box flex-between item-start" style="padding: 15px;">
        <div class="flex-box flex-center flex-column item-start">
            <!-- 「仕入・外注先CD」 -->
            <label>
                <span style="width:8.2em;">{{__('shiiresaki_cd')}}</span>
                <span class="icon-field">
                <input name="dataShiiresakiCd" class="form-control code-check" type="text"
                    maxlength="6" autocomplete="off" style="width:12em;"
                    pattern="^([a-zA-Z0-9]{0,6})$" title="{{ ('半角英数字6文字以内で入力してください')}}"   required>
                </span>
            </label>
            <!-- 「仕入・外注先名1」 -->
            <label>
                <span style="width:8.5em;">{{__('shiiresaki_name1')}}</span>
                <input name="dataShiiresakiName1" class="form-control code-check" type="text"
                    maxlength="30" autocomplete="off" style="width:20em;">
            </label>
            <!-- 「仕入・外注先名カナ」 -->
            <label>
                <span style="width:8.5em;">{{__('shiiresaki_kana')}}</span>
                <input name="dataShiiresakiKana" class="form-control code-check" type="text"
                    maxlength="60" autocomplete="off" style="width:15em;">
            </label>
            <!-- 「先方連絡先」 -->
            <label>
                <span style="width:8.5em;">{{__('senpou_renrakusaki')}}</span>
                <input name="dataSenpouRenrakusaki" class="form-control code-check" type="text"
                    maxlength="128" autocomplete="off" style="width:10em;">
            </label>
            <!-- 「ZIP」 -->
            <label>
                <span style="width:8.5em;">{{__('shiiresaki_zip')}}</span>
                <input name="dataShiiresakiZip" class="form-control code-check" type="text"
                    maxlength="10" autocomplete="off" style="width:12em;">
            </label>
            <!-- 「住所1」 -->
            <label>
                <span style="width:8.5em;">{{__('shiiresaki_jusho1')}}</span>
                <input name="dataShiiresakiJusho1" class="form-control code-check" type="text"
                    maxlength="60" autocomplete="off" style="width:20em;">
            </label>
            <!-- 「住所2」 -->
            <label>
                <span style="width:8.5em;">{{__('shiiresaki_jusho2')}}</span>
                <input name="dataShiiresakiJusho2" class="form-control code-check" type="text"
                    maxlength="60" autocomplete="off" style="width:20em;">
            </label>
            <!-- 「電話番号」 -->
            <label>
                <span style="width:8.5em;">{{__('Tel_no')}}</span>
                <input name="dataTelNo" class="form-control code-check" type="text"
                    maxlength="14" autocomplete="off" style="width:15em;">
            </label>
            <!-- 「FAX番号」 -->
            <label>
                <span style="width:8.5em;">{{__('Fax_no')}}</span>
                <input name="dataFaxNo" class="form-control code-check" type="text"
                    maxlength="14" autocomplete="off" style="width:15em;">
            </label>
        </div>
        <div class="flex-box flex-center flex-column item-start " style="margin: 0px 30px 0px 40px">
            <!-- 「仕入・外注先名2」 -->
            <label>
                <span style="width:9.4em;">{{__('shiiresaki_name2')}}</span>
                <input name="dataShiiresakiName2" class="form-control code-check" type="text"
                    maxlength="30" autocomplete="off" style="width:20em;">
            </label>
            <!-- 「略称」 -->
            <label>
                <span style="width:9.4em;">{{__('shiiresaki_ryaku')}}</span>
                <input name="dataShiiresakiRyaku" class="form-control code-check" type="text"
                    maxlength="20" autocomplete="off" style="width:10em;">
            </label>
            <!-- 「資本金」 -->
            <label>
                <span style="width:9.4em;">{{__('shihonkin')}}</span>
                <input name="dataShihonkin" class="form-control code-check" type="text"
                    maxlength="16" autocomplete="off" style="width:10em;">
            </label>
            <!-- 「銀行名」 -->
            <label>
                <span style="width:9.4em;">{{__('ginkou_name')}}</span>
                <input name="dataGinkouName" class="form-control code-check" type="text"
                    maxlength="16" autocomplete="off" style="width:15em;">
            </label>
            <!-- 「支店名」 -->
            <label>
                <span style="width:9.4em;">{{__('shiten_name')}}</span>
                <input name="dataShitenName" class="form-control code-check" type="text"
                    maxlength="16" autocomplete="off" style="width:15em;">
            </label>
            <!-- 「事業部CD」 -->
            <label>
                <span style="width:9em;">{{__('jigyoubu_cd')}}</span>
                <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                    <input name="dataJigyoubuCd" class="form-control" type="text"
                           maxlength="6" autocomplete="off" style="width:10em;"
                            pattern="^([a-zA-Z0-9]{0,6})$" title="{{ ('半角英数字6文字以内で入力してください')}}"  required>
                    <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                    <i class="fas fa-search search-btn"></i>
                </span>
                <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                <input name="dataJigyoubuName" class="form-control" type="text"
                       style="width:14em;" onfocus="blur();" readonly>
            </label>
            <!-- 「業種分類CD」 -->
            <label>
                <span style="width:9em;">{{__('gyoushu_cd')}}</span>
                <span class="icon-field">
                <input name="dataGyoushuCd" class="form-control code-check" type="text"
                    maxlength="10" autocomplete="off" style="width:10em;"
                        pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}" required>
                    <i class="fas fa-search search-btn"></i>
                </span>
                <input name="dataGyoushuName" class="form-control" type="text"
                    style="width:14em;" onfocus="blur();" readonly>
            </label>
            <!-- 「敬称区分」 -->
            <label>
                <span style="width:9.4em;">{{__('keishou_kbn')}}</span>
                <span class="icon-field">
                <input name="dataKeishouKbn" class="form-control code-check" type="text"
                    maxlength="10" autocomplete="off" style="width:10em;"
                        pattern="^([a-zA-Z0-9]{0,1})$">
                    <i class="fas fa-search search-btn"></i>
                </span>
                <input name="dataBunruiName" class="form-control" type="text"
                    style="width:14em;" onfocus="blur();" readonly>
            </label>
            <!-- 「諸口区分」 -->
            <label>
                <span style="width:9.7em;">{{__('shokuchi_kbn')}}</span>
                <!-- 「」コンボボックス本体 -->
                <div id="cmbShokuchiKbn" style="width:18em;"></div>
                <!-- 「」フォーム送信データ -->
                <input name="dataShokuchiKbn" type="hidden">
            </label>
        </div>
    </div>
    <div class="flex-box flex-center flex-column item-start " style="margin: 0px 100px 0px 40px">
        <!-- 「仕入・外注先名2」 -->
        <label>
            <span style="width:9.4em;">{{__('shiiresaki_name2')}}</span>
            <input name="dataShiiresakiName2" class="form-control code-check" type="text" maxlength="30" autocomplete="off" style="width:20em;">
        </label>
        <!-- 「略称」 -->
        <label>
            <span style="width:9.4em;">{{__('shiiresaki_ryaku')}}</span>
            <input name="dataShiiresakiRyaku" class="form-control code-check" type="text" maxlength="20" autocomplete="off" style="width:10em;">
        </label>
        <!-- 「資本金」 -->
        <label>
            <span style="width:9.4em;">{{__('shihonkin')}}</span>
            <input name="dataShihonkin" class="form-control code-check" type="text" maxlength="16" autocomplete="off" style="width:10em;">
        </label>
        <!-- 「銀行名」 -->
        <label>
            <span style="width:9.4em;">{{__('ginkou_name')}}</span>
            <input name="dataGinkouName" class="form-control code-check" type="text" maxlength="16" autocomplete="off" style="width:15em;">
        </label>
        <!-- 「支店名」 -->
        <label>
            <span style="width:9.4em;">{{__('shiten_name')}}</span>
            <input name="dataShitenName" class="form-control code-check" type="text" maxlength="16" autocomplete="off" style="width:15em;">
        </label>
        <!-- 「事業部CD」 -->
        <label>
            <span style="width:9em;">{{__('jigyoubu_cd')}}</span>
            <span class="icon-field">
                <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                <input name="dataJigyoubuCd" class="form-control" type="text" maxlength="6" autocomplete="off" style="width:10em;" pattern="^([a-zA-Z0-9]{0,6})$" title="{{ ('半角英数字6文字以内で入力してください')}}" required>
                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                <i class="fas fa-search search-btn"></i>
            </span>
            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
            <input name="dataJigyoubuName" class="form-control" type="text" style="width:14em;" onfocus="blur();" readonly>
        </label>
        <!-- 「業種分類CD」 -->
        <label>
            <span style="width:9em;">{{__('gyoushu_cd')}}</span>
            <span class="icon-field">
                <input name="dataGyoushuCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off" style="width:10em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{ ('半角英数字10文字以内で入力してください')}}" required>
                <i class="fas fa-search search-btn"></i>
            </span>
            <input name="dataGyoushuName" class="form-control" type="text" style="width:14em;" onfocus="blur();" readonly>
        </label>
        <!-- 「敬称区分」 -->
        <label>
            <span style="width:9.7em;">{{__('keishou_kbn')}}</span>
            <!-- 「」コンボボックス本体 -->
            <div id="cmbKeishouKbn" style="width:18em;"></div>
            <!-- 「」フォーム送信データ -->
            <input name="keishou_kbn" type="hidden">
        </label>
        <!-- 「諸口区分」 -->
        <label>
            <span style="width:9.7em;">{{__('shokuchi_kbn')}}</span>
            <!-- 「」コンボボックス本体 -->
            <div id="cmbShokuchiKbn" style="width:18em;"></div>
            <!-- 「」フォーム送信データ -->
            <input name="dataShokuchiKbn" type="hidden">
        </label>
    </div>
</div>
<div class="flex-box" style="margin: 0 80px 0 10">
    <div class="form-column">
        <!-- 「有効期間（自）」 -->
        <label>
            <span style="width:8.7em;">{{__('yukoukikan_start_date')}}</span>
            <input id="dataStartDate" name="dataStartDate" type="hidden">
        </label>
    </div>
    <div class="form-column" style="margin-left:20px">
        <!-- 「登録日」 -->
        <label>
            <span style="width:6em;">{{__('touroku_dt')}}</span>
            <input name="dataTourokuDt" class="form-control-plaintext" type="text" readonly>
        </label>
    </div>
    <div class="form-column">
        <!-- 「更新日」 -->
        <label>
            <span style="width:6em;">{{__('koushin_dt')}}</span>
            <input name="dataKoushinDt" class="form-control-plaintext" type="text" readonly>
        </label>
    </div>
    <div class="tabs">
        <input id="denpyou" type="radio" name="tab_item">
        <label class="tab_item" for="denpyou"style="width:23.5em;">仕入・外注・税設定</label>
        <input id="seikyu" type="radio" name="tab_item"checked>
        <label class="tab_item" for="seikyu"style="width:23.5em;">支払い</label>
        <input id="sonota" type="radio" name="tab_item">
        <label class="tab_item" for="sonota"style="width:23.5em;">他設定</label>
        <div class="tab_content" id="denpyou_content">
            <div class="tab_content_description">
                <div class="flex-box item-start">
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0px 0px 0px 20px">
                        <!-- 「仕入区分」 -->
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
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0px 100px 0px 100px">
                    <!-- 「消費税計算単位」 -->
                        <label>
                            <span style="width:9em;">{{__('shouhizei_keisan_tani')}}</span>
                            <!-- 「消費税計算単位」コンボボックス本体 -->
                            <div id="cmbShouhizeiKeisanTani" style="width:14em;"></div>
                            <!-- 「消費税計算単位」フォーム送信データ -->
                            <input name="dataShouhizeiKeisanTani" type="hidden">
                        </label>
                        {{-- 「消費税計算方式」 --}}
                        <label>
                            <span style="width:9em;">{{__('shouhizei_keisan_houshiki')}}</span>
                            <!-- 「消費税計算方式」コンボボックス本体 -->
                            <div id="cmbShouhizeiKeisanHoushiki" style="width:14em;"></div>
                            <!-- 「消費税計算方式」フォーム送信データ -->
                            <input name="dataShouhizeiKeisanHoushiki" type="hidden">
                        </label>
                        {{-- 「消費税計算丸目」 --}}
                        <label>
                            <span style="width:9em;">{{__('shouhizei_keisan_marume')}}</span>
                            <!-- 「消費税計算丸目」コンボボックス本体 -->
                            <div id="cmbShouhizeiKeisanMarume" style="width:14em;"></div>
                            <!-- 「消費税計算丸目」フォーム送信データ -->
                            <input name="dataShouhizeiKeisanMarume" type="hidden">
                        </label>
                        {{-- 「金額計算丸目」 --}}
                        <label>
                            <span style="width:9em;">{{__('kingaku_keisan_marume')}}</span>
                            <!-- 「金額計算丸目」コンボボックス本体 -->
                            <div id="cmbKingakuKeisanMarume" style="width:14em;"></div>
                            <!-- 「金額計算丸目」フォーム送信データ -->
                            <input name="dataKingakuKeisanMarume" type="hidden">
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab_content" id="seikyu_content">
            <div class="tab_content_description">
                <div class="form-column"style="margin: 0px 0px 0px 20px">
                    <!-- 「支払先CD」 -->
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
                <div class="flex-box item-start">
                    <div class="flex-box flex-center flex-column item-start"style="margin: 0px 0px 0px 20px">
                        <!-- 「支払区分」 -->
                        <label>
                            <span style="width:8em;">{{__('shiharai_kbn')}}</span>
                            <!-- 「支払区分」コンボボックス本体 -->
                            <div id="cmbShiharaiKbn" style="width:10em;"></div>
                            <!-- 「支払区分」フォーム送信データ -->
                            <input name="dataShiharaiKbn" type="hidden">
                        </label>
                        <!-- 「締日1」 -->
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
                    </div>
                    <div class="flex-box flex-column item-start"style="margin: 0px 0px 0px 80px">
                        <!-- 「支払・回収額上限」 -->
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
                    <div id="displayContent" class="flex-box flex-column item-start" style="margin: 0px 0px 0px 80px">
                        <!-- 「支払予定月1」 -->
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
                    <div id="hiddenContent" class="flex-box flex-center flex-column item-start" style="margin: 0px 0px 0px 80px; display:none">
                        <!-- 「支払予定月2」 -->
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

    /* 仕入区分選択値 */
    var shiireKbn = [];
    {{-- 仕入区分データ登録値 --}}
    var shiireKbnValue = [];
    /* 仕入区分の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(SHIIRE_KBN); $i++)
    @if(SHIIRE_KBN[$i] !== '')
    shiireKbn.push('{{ $i }}:{{ SHIIRE_KBN[$i] }}');
    shiireKbnValue.push({{$i}});
    @endif
    @endfor
    {{-- 外注区分選択値 --}}
    var gaichuKbn = [];
    {{-- 外注区分データ登録値 --}}
    var gaichuKbnValue = [];
    /* 外注区分の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(GAICHU_KBN); $i++)
    @if(GAICHU_KBN[$i] !== '')
    gaichuKbn.push('{{ $i }}:{{ GAICHU_KBN[$i] }}');
    gaichuKbnValue.push({{$i}});
    @endif
    @endfor
    {{-- 支払区分選択値 --}}
    var shiharaiKbn = [];
    {{-- 支払区分データ登録値 --}}
    var shiharaiKbnValue = [];
    /* 支払区分の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(SHIHARAI_KBN); $i++)
    @if(SHIHARAI_KBN[$i] !== '')
    shiharaiKbn.push('{{ $i }}:{{ SHIHARAI_KBN[$i] }}');
    shiharaiKbnValue.push({{$i}});
    @endif
    @endfor
    {{-- 諸口区分選択値 --}}
    var shokuchiKbn = [];
    {{-- 諸口区分データ登録値 --}}
    var shokuchiKbnValue = [];
    /* 諸口区分の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(SHOKUCHI_KBN); $i++)
    @if(SHOKUCHI_KBN[$i] !== '')
    shokuchiKbn.push('{{ $i }}:{{ SHOKUCHI_KBN[$i] }}');
    shokuchiKbnValue.push({{$i}});
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
    var shouhizeiKeisanTani = [];
    /* 消費税計算単位データ登録値 */
    var shouhizeiKeisanTaniValue = [];
    /* 消費税計算単位の元データに入力がある場合は選択値として格納 */
    @for($i = 0;$i < count(SHOUHIZEI_KEISAN_TANI);$i++)
        @if(SHOUHIZEI_KEISAN_TANI[$i] !== '')
            shouhizeiKeisanTani.push('{{ $i }}:{{ SHOUHIZEI_KEISAN_TANI[$i] }}');
            shouhizeiKeisanTaniValue.push({{ $i }});
        @endif
    @endfor
    /* 消費税計算方式選択値 */
    var shouhizeiKeisanHoushiki = [];
    /* 消費税計算方式データ登録値 */
    var shouhizeiKeisanHoushikiValue = [];
    /* 消費税計算方式の元データに入力がある場合は選択値として格納 */
    @for($i = 0;$i < count(SHOUHIZEI_KEISAN_HOUSHIKI);$i++)
        @if(SHOUHIZEI_KEISAN_HOUSHIKI[$i] !== '')
            shouhizeiKeisanHoushiki.push('{{ $i }}:{{ SHOUHIZEI_KEISAN_HOUSHIKI[$i] }}');
            shouhizeiKeisanHoushikiValue.push({{ $i }});
        @endif
    @endfor
    /* 消費税計算丸目選択値 */
    var shouhizeiKeisanMarume = [];
    /* 消費税計算丸目データ登録値 */
    var shouhizeiKeisanMarumeValue = [];
    /* 消費税計算丸目の元データに入力がある場合は選択値として格納 */
    @for($i = 0;$i < count(SHOUHIZEI_KEISAN_MARUME);$i++)
        @if(SHOUHIZEI_KEISAN_MARUME[$i] !== '')
            shouhizeiKeisanMarume.push('{{ $i }}:{{ SHOUHIZEI_KEISAN_MARUME[$i] }}');
            shouhizeiKeisanMarumeValue.push({{ $i }});
        @endif
    @endfor
    {{-- 金額計算丸目選択値 --}}
    var kingakuKeisanMarume = [];
    {{-- 金額計算丸目データ登録値 --}}
    var kingakuKeisanMarumeValue = [];
    /* 金額計算丸目の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(KINGAKU_KEISAN_MARUME); $i++)
    @if(KINGAKU_KEISAN_MARUME[$i] !== '')
    kingakuKeisanMarume.push('{{ $i }}:{{ KINGAKU_KEISAN_MARUME[$i] }}');
    kingakuKeisanMarumeValue.push({{ $i}});
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
    /* 支払予定月1の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(SHIHARAI_TSUKI1); $i++)
    @if(SHIHARAI_TSUKI1[$i] !== '')
    shiharaiTsuki1.push('{{ $i }}:{{ SHIHARAI_TSUKI1[$i] }}');
    shiharaiTsuki1Value.push({{$i}});
    @endif
    @endfor
    /* 支払方法1選択値 */
    var shiharaiHouhou1 = [];
    /* 支払方法1データ登録値 */
    var shiharaiHouhou1Value = [];
    /* 支払方法1の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(SHIHARAI_HOUHOU1); $i++)
    @if(SHIHARAI_HOUHOU1[$i] !== '')
    shiharaiHouhou1.push('{{ $i }}:{{ SHIHARAI_HOUHOU1[$i] }}');
    shiharaiHouhou1Value.push({{$i}});
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
    /* 支払・回収額上限の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(SHIHARAI_KAISHU_JOUGEN_KIN); $i++)
    @if(SHIHARAI_KAISHU_JOUGEN_KIN[$i] !== '')
    shiharaiKaishuJougenKin.push('{{ $i }}:{{ SHIHARAI_KAISHU_JOUGEN_KIN[$i] }}');
    shiharaiKaishuJougenKinValue.push({{$i}});
    @endif
    @endfor
    {{-- 支払予定月2選択値 --}}
    var shiharaiTsuki2 = [];
    {{-- 支払予定月2データ登録値 --}}
    var shiharaiTsuki2Value = [];
    /* 支払予定月2の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(SHIHARAI_TSUKI2); $i++)
    @if(SHIHARAI_TSUKI2[$i] !== '')
    shiharaiTsuki2.push('{{ $i }}:{{ SHIHARAI_TSUKI1[$i] }}');
    shiharaiTsuki2Value.push({{$i}});
    @endif
    @endfor
    /* 支払方法2選択値 */
    var shiharaiHouhou2 = [];
    /* 支払方法2データ登録値 */
    var shiharaiHouhou2Value = [];
    /* 支払方法2の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(SHIHARAI_HOUHOU2); $i++)
    @if(SHIHARAI_HOUHOU2[$i] !== '')
    shiharaiHouhou2.push('{{ $i }}:{{ SHIHARAI_HOUHOU2[$i] }}');
    shiharaiHouhou2Value.push({{$i}});
    @endif
    @endfor
    {{-- 振込手数料区分選択値 --}}
    var furikomiTesuryouKbn = [];
    {{-- 振込手数料区分データ登録値 --}}
    var furikomiTesuryouKbnValue = [];
    /* 振込手数料区分の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(FURIKOMI_TESURYOU_KBN); $i++)
    @if(FURIKOMI_TESURYOU_KBN[$i] !== '')
    furikomiTesuryouKbn.push('{{ $i }}:{{ FURIKOMI_TESURYOU_KBN[$i] }}');
    furikomiTesuryouKbnValue.push({{$i}});
    @endif
    @endfor
    /* 支払口座区分選択値 */
    var shiharaiKouzaKbn = [];
    /* 支払口座区分データ登録値 */
    var shiharaiKouzaKbnValue = [];
    /* 支払口座区分の元データに入力がある場合は選択値として格納 */
    @for($i = 0; $i < count(SHIHARAI_KOUZA_KBN); $i++)
    @if(SHIHARAI_KOUZA_KBN[$i] !== '')
    shiharaiKouzaKbn.push('{{ $i }}:{{ SHIHARAI_KOUZA_KBN[$i] }}');
    shiharaiKouzaKbnValue.push({{$i}});
    @endif
    @endfor

    /* コンボボックス宣言 */
    var cmbShiireKbn = new wijmo.input.ComboBox('#cmbShiireKbn', { itemsSource: shiireKbn });
    var cmbGaichuKbn = new wijmo.input.ComboBox('#cmbGaichuKbn', { itemsSource: gaichuKbn });
    var cmbShiharaiKbn = new wijmo.input.ComboBox('#cmbShiharaiKbn', { itemsSource: shiharaiKbn , isRequired: false});
    var cmbShokuchiKbn = new wijmo.input.ComboBox('#cmbShokuchiKbn', { itemsSource: shokuchiKbn , isRequired: false});
    var cmbShouhizeiKeisanTani = new wijmo.input.ComboBox('#cmbShouhizeiKeisanTani', { itemsSource: shouhizeiKeisanTani , isRequired: false});
    var cmbShouhizeiKeisanHoushiki = new wijmo.input.ComboBox('#cmbShouhizeiKeisanHoushiki', { itemsSource: shouhizeiKeisanHoushiki , isRequired: false});
    var cmbShouhizeiKeisanMarume = new wijmo.input.ComboBox('#cmbShouhizeiKeisanMarume', { itemsSource: shouhizeiKeisanMarume , isRequired: false});
    var cmbKingakuKeisanMarume = new wijmo.input.ComboBox('#cmbKingakuKeisanMarume', { itemsSource: kingakuKeisanMarume , isRequired: false});
    var cmbShiharaiTsuki1 = new wijmo.input.ComboBox('#cmbShiharaiTsuki1', { itemsSource: shiharaiTsuki1 , isRequired: false});
    var cmbShiharaiHouhou1 = new wijmo.input.ComboBox('#cmbShiharaiHouhou1', { itemsSource: shiharaiHouhou1 , isRequired: false});
    var cmbShiharaiKaishuJougenKin = new wijmo.input.ComboBox('#cmbShiharaiKaishuJougenKin', { itemsSource: shiharaiKaishuJougenKin, isRequired: false });
    var cmbShiharaiTsuki2 = new wijmo.input.ComboBox('#cmbShiharaiTsuki2', { itemsSource: shiharaiTsuki2, isRequired: false });
    var cmbShiharaiHouhou2 = new wijmo.input.ComboBox('#cmbShiharaiHouhou2', { itemsSource: shiharaiHouhou2, isRequired: false });
    var cmbFurikomiTesuryouKbn = new wijmo.input.ComboBox('#cmbFurikomiTesuryouKbn', { itemsSource: furikomiTesuryouKbn , isRequired: false});
    var cmbShiharaiKouzaKbn = new wijmo.input.ComboBox('#cmbShiharaiKouzaKbn', { itemsSource: shiharaiKouzaKbn, isRequired: false });

    var displayContent = document.getElementById('displayContent');
    var hiddenContent = document.getElementById('hiddenContent');

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
        {{-- MultiRowのレイアウト設定 --}}
        let columns = [
               { cells: [{ binding: 'dataShiiresakiCd',           header: "{{__('shiiresaki_cd')}}", width: 150 }]},
               { cells: [{ binding: 'dataShiiresakiName1',        header: "{{__('shiiresaki_name1')}}", width: 150 },
                         { binding: 'dataShiiresakiName2',        header: "{{__('shiiresaki_name2')}}"}]},
               { cells: [{ binding: 'dataShiiresakiKana',         header: "{{__('shiiresaki_kana')}}", width: 170 },
                         { binding: 'dataShiiresakiRyaku',        header: "{{__('shiiresaki_ryaku')}}"}]},
               { cells: [{ binding: 'dataJigyoubuCd',             header: "{{__('jigyoubu_cd')}}", width: 130 },
                         { binding: 'dataJigyoubuName',           header: "{{__('jigyoubu_name')}}"}]},
               { cells: [{ binding: 'dataKeishouKbn',             header: "{{__('keishou_kbn')}}", width: 130 },
                         { binding: 'dataBunruiName',             header: "{{__('bunrui_name')}}", width: 130 }]},
               { cells: [{ binding: 'dataShiireKbn',              header: "{{__('shiire_kbn')}}", width: 130 }]},
               { cells: [{ binding: 'dataGaichuKbn',              header: "{{__('gaichu_kbn')}}", width: 130 }]},
               { cells: [{ binding: 'dataShiharaiKbn',            header: "{{__('shiharai_kbn')}}", width: 130 }]},
               { cells: [{ binding: 'dataShokuchiKbn',            header: "{{__('shokuchi_kbn')}}", width: 130 }]},
               { cells: [{ binding: 'dataShiharaisakiCd',         header: "{{__('shiharaisaki_cd')}}", width: 130 }]},
               { cells: [{ binding: 'dataShiharaisakiOyaCd',      header: "{{__('shiharaisaki_oya_cd')}}", width: 130 }]},
               { cells: [{ binding: 'dataShiiresakiZip',          header: "{{__('shiiresaki_zip')}}", width: 130 }]},
               { cells: [{ binding: 'dataShiiresakiJusho1',       header: "{{__('shiiresaki_jusho1')}}"},
                         { binding: 'dataShiiresakiJusho2',       header: "{{__('shiiresaki_jusho2')}}"}]},
               { cells: [{ binding: 'dataTelNo',                  header: "{{__('Tel_no')}}", width: 130 },
                         { binding: 'dataFaxNo',                  header: "{{__('Fax_no')}}"}]},
               { cells: [{ binding: 'dataSenpouRenrakusaki',      header: "{{__('senpou_renrakusaki')}}", width: 130 }]},
               { cells: [{ binding: 'dataGyoushuCd',              header: "{{__('gyoushu_cd')}}", width: 130 },
                         { binding: 'dataGyoushuName',            header: "{{__('gyoushu_name')}}"}]},
               { cells: [{ binding: 'dataShihonkin',              header: "{{__('shihonkin')}}", width: 130 }]},
               { cells: [{ binding: 'dataKakuninDate',            header: "{{__('kakunin_date')}}", width: 130 }]},
               { cells: [{ binding: 'dataShouhizeiKeisanTani',     header: "{{__('shouhizei_keisan_tani')}}", width: 200 },
                         { binding: 'dataShouhizeiKeisanHoushiki', header: "{{__('shouhizei_keisan_houshiki')}}"}]},
               { cells: [{ binding: 'dataShouhizeiKeisanMarume',   header: "{{__('shouhizei_keisan_marume')}}", width: 150 },
                         { binding: 'dataKingakuKeisanMarume',    header: "{{__('kingaku_keisan_marume')}}"}]},
               { cells: [{ binding: 'dataShimeDay1',              header: "{{__('shime_day1')}}", width: 130 },
                         { binding: 'dataShimeDay2',              header: "{{__('shime_day2')}}"}]},
               { cells: [{ binding: 'dataTekiyouTsuki',           header: "{{__('tekiyou_tsuki')}}", width: 150 }]},
               { cells: [{ binding: 'dataShiharaiKaishuJougenKin',header: "{{__('shiharai_kaishu_jougen_kin')}}", width: 170 }]},
               { cells: [{ binding: 'dataShiharaiHouhou1',        header: "{{__('shiharai_houhou1')}}", width: 130 },
                         { binding: 'dataShiharaiHouhou2',        header: "{{__('shiharai_houhou2')}}"}]},
               { cells: [{ binding: 'dataShiharaiTsuki1',         header: "{{__('shiharai_tsuki1')}}", width: 130 },
                         { binding: 'dataShiharaiTsuki2',         header: "{{__('shiharai_tsuki2')}}"}]},
               { cells: [{ binding: 'dataShiharaiDay1',           header: "{{__('shiharai_day1')}}", width: 130 },
                         { binding: 'dataShiharaiDay2',           header: "{{__('shiharai_day2')}}"}]},
               { cells: [{ binding: 'dataTegataSate1',            header: "{{__('tegata_sate1')}}", width: 130 },
                         { binding: 'dataTegataSate2',            header: "{{__('tegata_sate2')}}", width: 130 }]},
               { cells: [{ binding: 'dataFurikomiTesuryouKbn',    header: "{{__('furikomi_tesuryou_kbn')}}", width: 170 }]},
               { cells: [{ binding: 'dataGinkouName',             header: "{{__('ginkou_name')}}", width: 130 },
                         { binding: 'dataShitenName',             header: "{{__('shiten_name')}}"}]},
               { cells: [{ binding: 'dataShiharaiKouzaKbn',       header: "{{__('shiharai_kouza_kbn')}}", width: 130 }]},
               { cells: [{ binding: 'dataShiharaiKouzaNo',        header: "{{__('shiharai_kouza_no')}}", width: 130 }]},
               { cells: [{ binding: 'dataBikou1',                 header: "{{__('bikou1')}}", width: 130 }]},
               { cells: [{ binding: 'dataBikou2',                 header: "{{__('bikou2')}}", width: 130 }]},
               { cells: [{ binding: 'dataBikou3',                 header: "{{__('bikou3')}}", width: 130 }]},
               { cells: [{ binding: 'dataBikou4',                 header: "{{__('bikou4')}}", width: 130 }]},
               { cells: [{ binding: 'dataTorihikiTeishiDate',     header: "{{__('torihiki_teishi_date')}}", width: 130 }]},
               { cells: [{ binding: 'dataTorihikiTeishiRiyu',     header: "{{__('torihiki_teishi_riyu')}}", width: 130 }]},
               { cells: [{ binding: 'dataStartDate',              header: "{{__('yukoukikan_start_date')}}", width: 150 },
                         { binding: 'dataEndDate',                header: "{{__('yukoukikan_end_date')}}"}] },
               { cells: [{ binding: 'dataTourokuDt',              header: "{{__('touroku_dt')}}", width: 200 },
                         { binding: 'dataKoushinDt',              header: "{{__('tourokusha_name')}}"}] },
               { cells: [{ binding: 'dataTourokushaName',         header: "{{__('koushin_dt')}}", width: 200 },
                         { binding: 'dataKoushinshaName',         header: "{{__('koushinsha_name')}}"}] }];
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
        AjaxData("{{ url('/master/1800') }}", soushinData, fncJushinGridData);
    }
    /* 「Excel出力」ボタンイベント */
    var fncExportExcel = function()
    {
        /* Excel出力用グリッドのレイアウト設定 */
        let columns = [
                    { binding: 'dataJigyoubuCd',   header: "{{__('jigyoubu_cd')}}" },
                    { binding: 'dataShiiresakiCd',   header: "{{__('shiiresaki_cd')}}" },
                    { binding: 'dataShiiresakiRyaku',   header: "{{__('shiiresaki_ryaku')}}" },
                    { binding: 'dataShiiresakiName1',   header: "{{__('shiiresaki_name1')}}" },
                    { binding: 'dataShiiresakiName2',   header: "{{__('shiiresaki_name2')}}" },
                    { binding: 'dataShiiresakiKana',   header: "{{__('shiiresaki_kana')}}" },
                    { binding: 'dataKeishouKbn',   header: "{{__('keishou_kbn')}}" },
                    { binding: 'dataShiireKbn',   header: "{{__('shiire_kbn')}}" },
                    { binding: 'dataGaichuKbn',   header: "{{__('gaichu_kbn')}}" },
                    { binding: 'dataShiharaiKbn',   header: "{{__('shiharai_kbn')}}" },
                    { binding: 'dataShokuchiKbn',   header: "{{__('shokuchi_kbn')}}" },
                    { binding: 'dataShiharaisakiCd',   header: "{{__('shiharaisaki_cd')}}" },
                    { binding: 'dataShiharaisakiOyaCd',   header: "{{__('shiharaisaki_oya_cd')}}" },
                    { binding: 'dataShiiresakiZip',   header: "{{__('shiiresaki_zip')}}" },
                    { binding: 'dataShiiresakiJusho1',   header: "{{__('shiiresaki_jusho1')}}" },
                    { binding: 'dataShiiresakiJusho2',   header: "{{__('shiiresaki_jusho2')}}" },
                    { binding: 'dataTelNo',   header: "{{__('Tel_no')}}" },
                    { binding: 'dataFaxNo',   header: "{{__('Fax_no')}}" },
                    { binding: 'dataSenpouRenrakusaki',   header: "{{__('senpou_renrakusaki')}}" },
                    { binding: 'dataGyoushuCd',   header: "{{__('gyoushu_cd')}}" },
                    { binding: 'dataGyoushuName',   header: "{{__('gyoushu_name')}}" },
                    { binding: 'dataShihonkin',   header: "{{__('shihonkin')}}" },
                    { binding: 'dataKakuninDate',   header: "{{__('kakunin_date')}}" },
                    { binding: 'dataBikou1',   header: "{{__('bikou1')}}" },
                    { binding: 'dataBikou2',   header: "{{__('bikou2')}}" },
                    { binding: 'dataBikou3',   header: "{{__('bikou3')}}" },
                    { binding: 'dataBikou4',   header: "{{__('bikou4')}}" },
                    { binding: 'dataShouhizeiKeisanTani',   header: "{{__('shouhizei_keisan_tani')}}" },
                    { binding: 'dataShouhizeiKeisanHoushiki',   header: "{{__('shouhizei_keisan_houshiki')}}" },
                    { binding: 'dataShouhizeiKeisanMarume',   header: "{{__('shouhizei_keisan_marume')}}" },
                    { binding: 'dataKingakuKeisanMarume',   header: "{{__('kingaku_keisan_marume')}}" },
                    { binding: 'dataShimeDay1',   header: "{{__('shime_day1')}}" },
                    { binding: 'dataShimeDay2',   header: "{{__('shime_day2')}}" },
                    { binding: 'dataTekiyouTsuki',   header: "{{__('tekiyou_tsuki')}}" },
                    { binding: 'dataShiharaiTsuki1',   header: "{{__('shiharai_tsuki1')}}" },
                    { binding: 'dataShiharaiDay1',   header: "{{__('shiharai_day1')}}" },
                    { binding: 'dataShiharaiHouhou1',   header: "{{__('shiharai_houhou1')}}" },
                    { binding: 'dataTegataSate1',   header: "{{__('tegata_sate1')}}" },
                    { binding: 'dataShiharaiKaishuJougenKin',   header: "{{__('shiharai_kaishu_jougen_kin')}}" },
                    { binding: 'dataShiharaiTsuki2',   header: "{{__('shiharai_tsuki2')}}" },
                    { binding: 'dataShiharaiDay2',   header: "{{__('shiharai_day2')}}" },
                    { binding: 'dataShiharaiHouhou2',   header: "{{__('shiharai_houhou2')}}" },
                    { binding: 'dataTegataSate2',   header: "{{__('tegata_sate2')}}" },
                    { binding: 'dataFurikomiTesuryouKbn',   header: "{{__('furikomi_tesuryou_kbn')}}" },
                    { binding: 'dataGinkouName',   header: "{{__('ginkou_name')}}" },
                    { binding: 'dataShitenName',   header: "{{__('shiten_cd')}}" },
                    { binding: 'dataShiharaiKouzaKbn',   header: "{{__('shiharai_kouza_kbn')}}" },
                    { binding: 'dataShiharaiKouzaNo',   header: "{{__('shiharai_kouza_no')}}" },
                    { binding: 'dataTorihikiTeishiDate',   header: "{{__('torihiki_teishi_date')}}" },
                    { binding: 'dataTorihikiTeishiRiyu',   header: "{{__('torihiki_teishi_riyu')}}" },
                    { binding: 'dataStartDate',          header: "{{__('yukoukikan_start_date')}}"},
                    { binding: 'dataEndDate',            header: "{{__('yukoukikan_end_date')}}" },
                    { binding: 'dataTourokuDt',            header: "{{__('touroku_dt')}}" },
                    { binding: 'dataTourokushaName',            header: "{{__('tourokusha_name')}}" },
                    { binding: 'dataKoushinDt',            header: "{{__('koushin_dt')}}" },
                    { binding: 'dataKoushinshaName',            header: "{{__('koushinsha_name')}}" }];
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
        /* 「敬称区分」 */
        nyuryokuData['dataKeishouKbn'].value = copy ? data['dataKeishouKbn'] : '';
        /* 「分類名」 */
        nyuryokuData['dataBunruiName'].value = copy ? data['dataBunruiName'] : '';
        /* 「仕入区分」 */
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
        /* 「備考4」 */
        nyuryokuData['dataBikou4'].value = copy ? data['dataBikou4'] : '';
        /* 「消費税計算単位」 */
        cmbShouhizeiKeisanTani.selectedIndex = (copy && !insertFlg) ? shouhizeiKeisanTaniValue.indexOf(data['dataShohizeiKeisanTani']) : 0;
        /* 「消費税計算方式」 */
        cmbShouhizeiKeisanHoushiki.selectedIndex = (copy && !insertFlg) ? shouhizeiKeisanHoushikiValue.indexOf(data['dataShohizeiKeisanHoushiki']) : 0;
        /* 「消費税計算丸目」 */
        cmbShouhizeiKeisanMarume.selectedIndex = (copy && !insertFlg) ? shouhizeiKeisanMarumeValue.indexOf(data['dataShohizeiKeisanMarume']) : 0;
        /* 「金額計算丸目」 */
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
        /* 「支払予定月1」 */
        cmbShiharaiTsuki1.selectedIndex = (copy && !insertFlg) ? shiharaiTsuki1Value.indexOf(data['dataShiharaiTsuki1']) : 0;
        /* 「支払日1」 */
        numberFlg=(nyuryokuData['dataShiharaiDay1'] != 0);
        nyuryokuData['dataShiharaiDay1'].value = (copy && numberFlg) ? data['dataShiharaiDay1'] : 1;
        /* 「支払方法1」 */
        cmbShiharaiHouhou1.selectedIndex = (copy && !insertFlg) ? shiharaiHouhou1Value.indexOf(data['dataShiharaiHouhou1']) : 0;
        /* 「手形サイト1」 */
        nyuryokuData['dataTegataSate1'].value = copy ? data['dataTegataSate1'] : '';
        /* 「支払・回収額上限」 */
        cmbShiharaiKaishuJougenKin.selectedIndex = (copy && !insertFlg) ? shiharaiKaishuJougenKinValue.indexOf(data['dataShiharaiKaishuJougenKin']) : 0;
        {{-- 「支払予定月2」 --}}
        cmbShiharaiTsuki2.selectedIndex = (copy && !insertFlg) ? shiharaiTsuki2Value.indexOf(data['dataShiharaiTsuki2']) : 0;
        /* 「支払日2」 */
        numberFlg=(nyuryokuData['dataShiharaiDay2'] != 0);
        nyuryokuData['dataShiharaiDay2'].value = (copy && numberFlg) ? data['dataShiharaiDay2'] : 1;
        /* 「支払方法2」 */
        cmbShiharaiHouhou2.selectedIndex = (copy && !insertFlg) ? shiharaiHouhou2Value.indexOf(data['dataShiharaiHouhou2']) : 0;
        /* 「手形サイト2」 */
        nyuryokuData['dataTegataSate2'].value = copy ? data['dataTegataSate2'] : '';
        /* 「振込手数料区分」 */
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
        nyuryokuData['dataJigyoubuCd'].disabled = deleteFlg; /* 「事業部CD」 */
        //nyuryokuData['dataShiiresakiCd'].disabled = deleteFlg; /* 「仕入・外注先CD」 */
        nyuryokuData['dataShiiresakiRyaku'].disabled = deleteFlg; /* 「略称」 */
        nyuryokuData['dataShiiresakiName1'].disabled = deleteFlg; /* 「仕入・外注先名1」 */
        nyuryokuData['dataShiiresakiName2'].disabled = deleteFlg; /* 「仕入・外注先名2」 */
        nyuryokuData['dataShiiresakiKana'].disabled = deleteFlg; /* 「仕入・外注先名カナ」 */
        nyuryokuData['dataKeishouKbn'].disabled = deleteFlg; /* 「敬称区分」 */
        cmbShiireKbn.isDisabled = deleteFlg; /* 「仕入区分」 */
        cmbGaichuKbn.isDisabled = deleteFlg; /* 「外注区分」 */
        cmbShiharaiKbn.isDisabled = deleteFlg; /* 「支払区分」 */
        cmbShokuchiKbn.isDisabled = deleteFlg; /* 「諸口区分」 */
        nyuryokuData['dataShiharaisakiCd'].disabled = deleteFlg; /* 「支払先CD」 */
        nyuryokuData['dataShiharaisakiOyaCd'].disabled = deleteFlg; /* 「支払親コード」 */
        nyuryokuData['dataShiiresakiZip'].disabled = deleteFlg; /* 「ZIP」 */
        nyuryokuData['dataShiiresakiJusho1'].disabled = deleteFlg; /* 「住所1」 */
        nyuryokuData['dataShiiresakiJusho2'].disabled = deleteFlg; /* 「住所2」 */
        nyuryokuData['dataTelNo'].disabled = deleteFlg; /* 「電話番号」 */
        nyuryokuData['dataFaxNo'].disabled = deleteFlg; /* 「FAX番号」 */
        nyuryokuData['dataSenpouRenrakusaki'].disabled = deleteFlg; /* 「先方連絡先」 */
        nyuryokuData['dataGyoushuCd'].disabled = deleteFlg; /* 「業種分類CD」 */
        nyuryokuData['dataShihonkin'].disabled = deleteFlg; /* 「資本金」 */
        dateKakunin.isDisabled = deleteFlg; /* 「確認日」 */
        nyuryokuData['dataBikou1'].disabled = deleteFlg; /* 「備考1」 */
        nyuryokuData['dataBikou2'].disabled = deleteFlg; /* 「備考2」 */
        nyuryokuData['dataBikou3'].disabled = deleteFlg; /* 「備考3」 */
        nyuryokuData['dataBikou4'].disabled = deleteFlg; /* 「備考4」 */
        cmbShouhizeiKeisanTani.isDisabled = deleteFlg; /* 「消費税計算単位」 */
        cmbShouhizeiKeisanHoushiki.isDisabled = deleteFlg; /* 「消費税計算方式」 */
        cmbShouhizeiKeisanMarume.isDisabled = deleteFlg; /* 「消費税計算丸目」 */
        cmbKingakuKeisanMarume.isDisabled = deleteFlg; /* 「金額計算丸目」 */
        nyuryokuData['dataShimeDay1'].disabled = deleteFlg;/* 「締日1」 */
        nyuryokuData['dataShimeDay2'].disabled = deleteFlg; /* 「締日2」 */
        nyuryokuData['dataTekiyouTsuki'].disabled = deleteFlg; /* 「適用月（締日２）」 */
        cmbShiharaiTsuki1.isDisabled = deleteFlg; /* 「支払予定月1」 */
        nyuryokuData['dataShiharaiDay1'].disabled = deleteFlg; /* 「支払日1」 */
        cmbShiharaiHouhou1.isDisabled = deleteFlg; /* 「支払方法1」 */
        nyuryokuData['dataTegataSate1'].isDisabled = deleteFlg; /* 「手形サイト1」 */
        cmbShiharaiKaishuJougenKin.isDisabled = deleteFlg; /* 「支払・回収額上限」 */
        cmbShiharaiTsuki2.isDisabled = deleteFlg; /* 「支払予定月2」 */
        nyuryokuData['dataShiharaiDay2'].disabled = deleteFlg; /* 「支払日2」 */
        cmbShiharaiHouhou2.isDisabled = deleteFlg; /* 「支払方法2」 */
        nyuryokuData['dataTegataSate2'].isDisabled = deleteFlg; /* 「手形サイト2」 */
        cmbFurikomiTesuryouKbn.isDisabled = deleteFlg; /* 「振込手数料区分」 */
        nyuryokuData['dataGinkouName'].disabled = deleteFlg; /* 「銀行名」 */
        nyuryokuData['dataShitenName'].disabled = deleteFlg; /* 「支店名」 */
        cmbShiharaiKouzaKbn.isDisabled = deleteFlg; /* 「支払口座区分」 */
        nyuryokuData['dataShiharaiKouzaNo'].disabled = deleteFlg; /* 「支払口座番号」 */
        dateTorihikiTeishi.isDisabled = deleteFlg; /* 「取引停止日」 */
        nyuryokuData['dataTorihikiTeishiRiyu'].disabled = deleteFlg; /* 「取引停止理由」 */
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
        /* ボタン制御更新 */
        SetEnableButton(data[1].length);
        /* 件数更新 */
        $("#zenkenCnt").html(data[1].length);
        /* グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 */
        selectedRows = SortMultiRowData(gridMaster, data[1], 'dataShiiresakiCd');
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
            /* 更新処理以外の処理の場合は判定せずにtrue */
            if (nyuryokuData['dataSQLType'].value != MODE_UPDATE) return true;
            /* 「仕入・外注先CD」 */
            if (nyuryokuData['dataShiiresakiCd'].value != data['dataShiiresakiCd']) return true;
            /* 「略称」 */
            if ((nyuryokuData['dataShiiresakiRyaku'].value != data['dataShiiresakiRyaku']) &&
                !(nyuryokuData['dataShiiresakiRyaku'].value == '' && data['dataShiiresakiRyaku'] == null)) return true;
            /* 「仕入・外注先名1」 */
            if ((nyuryokuData['dataShiiresakiName1'].value != data['dataShiiresakiName1']) &&
                !(nyuryokuData['dataShiiresakiName1'].value == '' && data['dataShiiresakiName1'] == null)) return true;
            /* 「仕入・外注先名2」 */
            if ((nyuryokuData['dataShiiresakiName2'].value != data['dataShiiresakiName2']) &&
                !(nyuryokuData['dataShiiresakiName2'].value == '' && data['dataShiiresakiName2'] == null)) return true;
            /* 「仕入・外注先名カナ」 */
            if ((nyuryokuData['dataShiiresakiKana'].value != data['dataShiiresakiKana']) &&
                !(nyuryokuData['dataShiiresakiKana'].value == '' && data['dataShiiresakiKana'] == null)) return true;
            /* 「事業部CD」 */
            if (nyuryokuData['dataJigyoubuCd'].value != data['dataJigyoubuCd']) return true;
            /* 「事業部名」 */
            if (nyuryokuData['dataJigyoubuName'].value != data['dataJigyoubuName']) return true;
            /* 「敬称区分」 */
            if(nyuryokuData['dataKeishouKbn'].value != data['dataKeishouKbn']) return true;
            /* 「仕入区分」 */
            if (shiireKbnValue[cmbShiireKbn.selectedIndex] != data['dataShiireKbn']) return true;
            /* 「外注区分」 */
            if (gaichuKbnValue[cmbGaichuKbn.selectedIndex] != data['dataGaichuKbn']) return true;
            /* 「支払区分」 */
            if (shiharaiKbnValue[cmbShiharaiKbn.selectedIndex] != data['dataShiharaiKbn']) return true;
            /* 「諸口区分」 */
            if (shokuchiKbnValue[cmbShokuchiKbn.selectedIndex] != data['dataShokuchiKbn']) return true;
            /* 「支払先CD」 */
            if ((nyuryokuData['dataShiharaisakiCd'].value != data['dataShiharaisakiCd']) &&
                !(nyuryokuData['dataShiharaisakiCd'].value == '' && data['dataShiharaisakiCd'] == null)) return true;
            /* 「支払親コード」 */
            if ((nyuryokuData['dataShiharaisakiOyaCd'].value != data['dataShiharaisakiOyaCd']) &&
                !(nyuryokuData['dataShiharaisakiOyaCd'].value == '' && data['dataShiharaisakiOyaCd'] == null)) return true;
            /* 「ZIP」 */
            if ((nyuryokuData['dataShiiresakiZip'].value != data['dataShiiresakiZip']) &&
                !(nyuryokuData['dataShiiresakiZip'].value == '' && data['dataShiiresakiZip'] == null)) return true;
            /* 「住所1」 */
            if ((nyuryokuData['dataShiiresakiJusho1'].value != data['dataShiiresakiJusho1']) &&
                !(nyuryokuData['dataShiiresakiJusho1'].value == '' && data['dataShiiresakiJusho1'] == null)) return true;
            /* 「住所2」 */
            if ((nyuryokuData['dataShiiresakiJusho2'].value != data['dataShiiresakiJusho2']) &&
                !(nyuryokuData['dataShiiresakiJusho2'].value == '' && data['dataShiiresakiJusho2'] == null)) return true;
            /* 「電話番号」 */
            if ((nyuryokuData['dataTelNo'].value != data['dataTelNo']) &&
                !(nyuryokuData['dataTelNo'].value == '' && data['dataTelNo'] == null)) return true;
            /* 「FAX番号」 */
            if ((nyuryokuData['dataFaxNo'].value != data['dataFaxNo']) &&
                !(nyuryokuData['dataFaxNo'].value == '' && data['dataFaxNo'] == null)) return true;
            /* 「先方連絡先」 */
            if ((nyuryokuData['dataSenpouRenrakusaki'].value != data['dataSenpouRenrakusaki']) &&
                !(nyuryokuData['dataSenpouRenrakusaki'].value == '' && data['dataSenpouRenrakusaki'] == null)) return true;
            /* 「業種分類CD」 */
            if (nyuryokuData['dataGyoushuCd'].value != data['dataGyoushuCd']) return true;
            /* 「業種分類名」 */
            if (nyuryokuData['dataGyoushuName'].value != data['dataGyoushuName']) return true;
            /* 「資本金」 */
            if ((nyuryokuData['dataShihonkin'].value != data['dataShihonkin']) &&
                !(nyuryokuData['dataShihonkin'].value == '' && data['dataShihonkin'] == null)) return true;
            /* 「確認日」 */
            if (nyuryokuData['dataKakuninDate'].value != data['dataKakuninDate']) return true;
            /* 「備考1」 */
            if ((nyuryokuData['dataBikou1'].value != data['dataBikou1']) &&
                !(nyuryokuData['dataBikou1'].value == '' && data['dataBikou1'] == null)) return true;
            /* 「備考2」 */
            if ((nyuryokuData['dataBikou2'].value != data['dataBikou2']) &&
                !(nyuryokuData['dataBikou2'].value == '' && data['dataBikou2'] == null)) return true;
            /* 「備考3」 */
            if ((nyuryokuData['dataBikou3'].value != data['dataBikou3']) &&
                !(nyuryokuData['dataBikou3'].value == '' && data['dataBikou3'] == null)) return true;
            /* 「備考4」 */
            if ((nyuryokuData['dataBikou4'].value != data['dataBikou4']) &&
                !(nyuryokuData['dataBikou4'].value == '' && data['dataBikou4'] == null)) return true;
            /* 「消費税計算単位」 */
            if(shouhizeiKeisanTaniValue[cmbShouhizeiKeisanTani.selectedIndex] != data['dataShouhizeiKeisanTani']) return true;
            /* 「消費税計算方式」 */
            if(shouhizeiKeisanHoushikiValue[cmbShouhizeiKeisanHoushiki.selectedIndex] != data['dataShouhizeiKeisanHoushiki']) return true;
            /* 「消費税計算丸目」 */
            if(shouhizeiKeisanMarumeValue[cmbShouhizeiKeisanMarume.selectedIndex] != data['dataShouhizeiKeisanMarume']) return true;
            /* 「金額計算丸目」 */
            if (kingakuKeisanMarumeValue[cmbKingakuKeisanMarume.selectedIndex] != data['dataKingakuKeisanMarume']) return true;
            /* 「締日1」 */
            if ((nyuryokuData['dataShimeDay1'].value != data['dataShimeDay1']) &&
                !(nyuryokuData['dataShimeDay1'].value == '' && data['dataShimeDay1'] == null)) return true;
            /* 「締日2」 */
            if ((nyuryokuData['dataShimeDay2'].value != data['dataShimeDay2']) &&
                !(nyuryokuData['dataShimeDay2'].value == '' && data['dataShimeDay2'] == null)) return true;
            /* 「適用月（締日２）」 */
            if ((nyuryokuData['dataTekiyouTsuki'].value != data['dataTekiyouTsuki']) &&
                !(nyuryokuData['dataTekiyouTsuki'].value == '' && data['dataTekiyouTsuki'] == null)) return true;
            /* 「支払予定月1」 */
            if (shiharaiTsuki1Value[cmbShiharaiTsuki1.selectedIndex] != data['dataShiharaiTsuki1']) return true;
            /* 「支払日1」 */
            if ((nyuryokuData['dataShiharaiDay1'].value != data['dataShiharaiDay1']) &&
                !(nyuryokuData['dataShiharaiDay1'].value == '' && data['dataShiharaiDay1'] == null)) return true;
            /* 「支払方法1」 */
            if (shiharaiHouhou1Value[cmbShiharaiHouhou1.selectedIndex] != data['dataShiharaiHouhou1']) return true;
            /* 「手形サイト1」 */
            if ((nyuryokuData['dataTegataSate1'].value != data['dataTegataSate1']) &&
                !(nyuryokuData['dataTegataSate1'].value == '' && data['dataTegataSate1'] == null)) return true;
            /* 「支払・回収額上限」 */
            if (shiharaiKaishuJougenKinValue[cmbShiharaiKaishuJougenKin.selectedIndex] != data['dataShiharaiKaishuJougenKin']) return true;
            /* 「支払予定月2」 */
            if (shiharaiTsuki2Value[cmbShiharaiTsuki2.selectedIndex] != data['dataShiharaiTsuki2']) return true;
            /* 「支払日2」 */
            if ((nyuryokuData['dataShiharaiDay2'].value != data['dataShiharaiDay2']) &&
                !(nyuryokuData['dataShiharaiDay2'].value == '' && data['dataShiharaiDay2'] == null)) return true;
            /* 「支払方法2」 */
            if (shiharaiHouhou2Value[cmbShiharaiHouhou2.selectedIndex] != data['dataShiharaiHouhou2']) return true;
            /* 「手形サイト2」 */
            if ((nyuryokuData['dataTegataSate2'].value != data['dataTegataSate2']) &&
                !(nyuryokuData['dataTegataSate2'].value == '' && data['dataTegataSate2'] == null)) return true;
            /* 「振込手数料区分」 */
            if (furikomiTesuryouKbnValue[cmbFurikomiTesuryouKbn.selectedIndex] != data['dataFurikomiTesuryouKbn']) return true;
            /* 「銀行名」 */
            if ((nyuryokuData['dataGinkouName'].value != data['dataGinkouName']) &&
                !(nyuryokuData['dataGinkouName'].value == '' && data['dataGinkouName'] == null)) return true;
            /* 「支店名」 */
            if ((nyuryokuData['dataShitenName'].value != data['dataShitenName']) &&
                !(nyuryokuData['dataShitenName'].value == '' && data['dataShitenName'] == null)) return true;
            /* 「支払口座区分」 */
            if (shiharaiKouzaKbnValue[cmbShiharaiKouzaKbn.selectedIndex] != data['dataShiharaiKouzaKbn']) return true;
            /* 「支払口座番号」 */
            if ((nyuryokuData['dataShiharaiKouzaNo'].value != data['dataShiharaiKouzaNo']) &&
                !(nyuryokuData['dataShiharaiKouzaNo'].value == '' && data['dataShiharaiKouzaNo'] == null)) return true;
            /* 「取引停止日」 */
            if (nyuryokuData['dataTorihikiTeishiDate'].value != data['dataTorihikiTeishiDate']) return true;
            /* 「取引停止理由」 */
            if((nyuryokuData['dataTorihikiTeishiRiyu'].value != data['dataTorihikiTeishiRiyu']) &&
              !(nyuryokuData['dataTorihikiTeishiRiyu'].value == '' && data['dataTorihikiTeishiRiyu'] == null)) return true;
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
        nyuryokuData['dataShiireKbn'].value = shiireKbnValue[cmbShiireKbn.selectedIndex];
        nyuryokuData['dataGaichuKbn'].value = gaichuKbnValue[cmbGaichuKbn.selectedIndex];
        nyuryokuData['dataShiharaiKbn'].value = shiharaiKbnValue[cmbShiharaiKbn.selectedIndex];
        nyuryokuData['dataShokuchiKbn'].value = shokuchiKbnValue[cmbShokuchiKbn.selectedIndex];
        nyuryokuData['dataShouhizeiKeisanTani'].value = shouhizeiKeisanTaniValue[cmbShouhizeiKeisanTani.selectedIndex];
        nyuryokuData['dataShouhizeiKeisanHoushiki'].value = shouhizeiKeisanHoushikiValue[cmbShouhizeiKeisanHoushiki.selectedIndex];
        nyuryokuData['dataShouhizeiKeisanMarume'].value = shouhizeiKeisanMarumeValue[cmbShouhizeiKeisanMarume.selectedIndex];
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

            /* 敬称区分 */
            case 'dataKeishouKbn': break;
            /* 該当しない場合は処理終了 */
            break;

            /* 業種分類CD */
            case 'dataGyoushuCd': break;
            /* 該当しない場合は処理終了 */
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
            /* 敬称区分 */
            case 'dataKeishouKbn':
            ShowSentakuDlg("{{ __('keishou_kbn') }}", "{{ __('bunrui_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}");
            break;
            /* 業種分類CD */
            case 'dataGyoushuCd':
            ShowSentakuDlg("{{ __('gyoushu_cd') }}", "{{ __('gyoushu_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}");
            break;
        }
    });
</script>
@endsection