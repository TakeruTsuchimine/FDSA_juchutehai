<!-- PHP処理 -->
<?php
    // define群
    define("ZAIRYOU_KBN", array(
            'ー',
            '材料'));
    define("KYOTEN_ZAIRYOU_KBN", array( 
            'ー',
            '拠点材料'));
    define("SHANAI_ZAIRYOU_KBN", array( 
            'ー',
            '社内材料'));
    define("JHUCHUHIN_KBN", array( 
            'ー',
            '受注品目'));
    define("SHIKAKARI_KBN", array( 
            'ー',
            '中間仕掛品'));
    define("FUKUSHIZAI_KBN", array( 
            'ー',
            '副資材'));
    define("SHOKUCHI_KBN", array( 
            '通常',
            '諸口（品名入力可）'));
    define("ZAIKOKANRI_TAISHOUGAI_KBN", array( 
            '通常',
            '在庫管理対象外'));
    define("TANKA_INPUT_KBN", array( 
            '未',
            '入力変更可'));
    define("SHOUHIZEI_KBN", array( 
            '非課税',
            '課税'));
    define("KEIGENZEIRITSU_KBN", array( 
            '未',
            '軽減税率適用'));
    define("ZUMEN_KBN", array( 
            '無し',
            '有り'));
    define("KENSA_KBN", array( 
            '無し',
            '有り'));
    define("SHINKI_JUCHU_SHEET_KBN", array( 
            '無し',
            '有り'));
    define("YOJOUZAIKO_KBN", array( 
            '指定無し',
            '不可'));

    // 「loginId」が送信されていなければ0を設定
    if(!isset($loginId)) $loginId = 0;

    // 検索フォームの高さ
    $kensakuHight = '140px';

    // 図面の高さ
    $zumenHight = 50*6;
?>

<!-- 共通レイアウト呼び出し -->
<!--「base_master.blede.php」・・・マスタ画面の共通テンプレートデザイン -->
@extends('templete.header.master.base_master')

<!-- 「検索フォーム」 -->
@section('kensaku')
<!-- 検索フォーム全体 -->
<form id="frmKensaku" name="frmKensaku" class="flex-box" style="height:<?php $kensakuHight ?>;">
    <!-- 一列目 -->
    <div class="form-column">
         <!-- 「品目CD」 -->
        <label>
            <span style="width:4.5em;">{{__('hinmoku_cd')}}</span>
            <input name="dataHinmokuCd" class="form-control" type="text" maxlength="30" autocomplete="off"
                style="width:8em;">
        </label>
        <!-- 「品目名」 -->
        <label>
            <span style="width:4.5em;">{{__('hinmoku_name')}}</span>
            <input name="dataHinmokuName" class="form-control" type="text" maxlength="40" autocomplete="off"
                style="width:22em;">
        </label>
        <!-- 「事業部CD」 -->
        <label>
            <span style="width:4.5em;">{{__('jigyoubu_cd')}}</span>
            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                <input name="dataJigyoubuCd" class="form-control" type="text" maxlength="40" autocomplete="off"
                    style="width:8em;">
                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                <i class="fas fa-search search-btn"></i>
            </span>
            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
            <input name="dataJigyoubuName" class="form-control" type="text" style="width:22em;" onfocus="blur();" readonly>
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
    <!-- 基本設定 -->
    <div class="flex-box flex-between item-start">
        <!-- 一列目 -->
        <div class="flex-box flex-start flex-column item-start">
            <div class="form-column">
            <!-- <div class="flex-box flex-start flex-column item-start"> -->
                <!-- 「事業部CD」 -->
                <label>
                    <span style="width:6em;">{{__('jigyoubu_cd')}}</span>
                    <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                        <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                        <input name="dataJigyoubuCd" class="form-control code-check" type="text" maxlength="6" autocomplete="off"
                            style="width:8em;" pattern="^([a-zA-Z0-9]{0,6})$" title="{{__('半角英数字6文字以内で入力してください')}}" required>
                        <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                        <i class="fas fa-search search-btn"></i>
                    </span>
                    <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                    <input name="dataJigyoubuName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                </label>
            </div>
            <div class="form-column">
                <!-- 「品目CD」 -->
                <label>
                    <span style="width:6em;">{{__('hinmoku_cd')}}</span>
                    <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                    <input name="dataHinmokuCd" class="form-control code-check" type="text" maxlength="30" autocomplete="off"
                        style="width:8em;" pattern="^([a-zA-Z0-9]{0,30})$" title="{{ __('半角英数字10文字以内で入力してください') }}" required>
                </label>
            </div>
            <div class="form-column">
                <!-- 「品目名」 -->
                <label>
                    <span style="width:6em;">{{__('hinmoku_name')}}</span>
                    <input name="dataHinmokuName1" class="form-control" type="text" maxlength="40" autocomplete="off"
                        style="width:22em;" required>
                </label>
            </div>
        </div>
        <!-- 二列目 -->
        <div class="flex-box flex-start flex-column item-start" style="padding-left:10px; width:30em;">
            <div class="form-column">
                <!-- 「品目名(ｶﾅ)」 -->
                <label>
                    <span style="width:6em;">{{__('hinmoku_kana')}}</span>
                    <input name="dataHinmokuName2" class="form-control" type="text" maxlength="40" autocomplete="off"
                        style="width:22em;" required>
                </label>
            </div>
            <div class="form-column">
                <!-- 「品目区分」 -->
                <label>
                    <span style="width:6em;">{{__('hinmoku_kbn')}}</span>
                    <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                        <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                        <input name="dataHinmokuKbn" class="form-control code-check" type="text" maxlength="2" autocomplete="off"
                            style="width:8em;" pattern="^([a-zA-Z0-9]{0,2})$" title="{{__('半角英数字6文字以内で入力してください')}}" required>
                        <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                        <i class="fas fa-search search-btn"></i>
                    </span>
                    <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                    <input name="dataHinmokuKbnName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                </label>
            </div>
            <div class="form-column">
                <!-- 「単位CD」 -->
                <label>
                    <span style="width:6em;">{{__('tanni_cd')}}</span>
                    <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                        <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                        <input name="dataTanniCd" class="form-control code-check" type="text" maxlength="3" autocomplete="off"
                            style="width:8em;" pattern="^([a-zA-Z0-9]{0,3})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                        <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                        <i class="fas fa-search search-btn"></i>
                    </span>
                    <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                    <input name="dataTanniName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                </label>
            </div>
        </div>
    </div>

    <!-- tab setting -->
    <div class="tabs">
        <input id="tab0" type="radio" name="tab_item" checked>
        <label class="tab_item" for="tab0" style="width:19%; display: flex; justify-content: space-between; 
            margin-left: 1%; padding-left: 1%;">tab0</label>
        <input id="tab1" type="radio" name="tab_item">
        <label class="tab_item" for="tab1" style="width:19%; display: flex; justify-content: space-between; 
            margin-left: 1%; padding-left: 1%;">tab1</label>
        <input id="tab2" type="radio" name="tab_item">
        <label class="tab_item" for="tab2" style="width:19%; display: flex; justify-content: space-between; 
            margin-left: 1%; padding-left: 1%;">tab2</label>
        <input id="tab3" type="radio" name="tab_item">
        <label class="tab_item" for="tab3" style="width:19%; display: flex; justify-content: space-between; 
            margin-left: 1%; padding-left: 1%;">tab3</label>
        <input id="tab4" type="radio" name="tab_item">
        <label class="tab_item" for="tab4" style="width:19%; display: flex; justify-content: space-between; 
            margin-left: 1%; padding-left: 1%;">tab4</label>
            
        <!-- tab0 -->
        <div class="tab_content" id="tab0_content">
            <div class="flex-box flex-between item-start">
                <!-- 一列目 -->
                <div class="flex-box flex-start flex-column item-start">   
                    <div class="form-column" >
                        <!-- 「材料区分」チェックボックス -->
                        <div class="flex-box" style="height: 2.5em; align-items: center;">
                            <span style="width:9em;">{{__('zairyou_kbn')}}</span>
                            <div class="form-check">
                                <input id="chkZairyouKbn" name="chkZairyouKbn" class="form-check-input" type="checkbox">
                                <label class="form-check-label" for="chkZairyouKbn">
                                    <?php echo ZAIRYOU_KBN[1] ?>{{__('として登録する')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-column" style="width: 100%;">
                        <!-- <div id="zairyouBunrui"> -->
                            <!-- 「材料分類」 -->
                            <div class="flex-box" style="height: 2.5em; align-items: center;">
                                <span style="width:9em;">{{__('zairyou_bunrui')}}</span>
                                <div style="width: 80%; display: flex; margin-left: 10px;">
                                    <div class="form-check" style="width: 27%;">
                                        <input name="rdoZairyouBunrui" id="rdoZairyouKbn" class="form-check-input rdoZairyouBunrui" type="radio"
                                            value=<?php echo ZAIRYOU_KBN[1] ?> disabled>
                                        <label class="form-check-label" for="rdoZairyouKbn" style="width: 100%;">
                                            <?php echo ZAIRYOU_KBN[1] ?></label>
                                    </div>
                                    <input name="dataZairyouKbn" type="hidden">
                                    <div class="form-check" style="width: 36%;">
                                        <input name="rdoZairyouBunrui" id="rdoKyotenZairyouKbn" class="form-check-input rdoZairyouBunrui" type="radio"
                                            value=<?php echo KYOTEN_ZAIRYOU_KBN[1] ?> disabled>
                                        <label class="form-check-label" for="rdoKyotenZairyouKbn" style="width: 100%;">
                                            <?php echo KYOTEN_ZAIRYOU_KBN[1] ?></label>
                                    </div>
                                    <input name="dataKyotenZairyouKbn" type="hidden">
                                    <div class="form-check" style="width: 36%;">
                                        <input name="rdoZairyouBunrui" id="rdoShanaiZairyouKbn" class="form-check-input rdoZairyouBunrui" type="radio"
                                            value=<?php echo SHANAI_ZAIRYOU_KBN[1] ?> disabled>
                                        <label class="form-check-label" for="rdoShanaiZairyouKbn" style="width: 100%;">
                                            <?php echo SHANAI_ZAIRYOU_KBN[1] ?></label>
                                    </div>
                                    <input name="dataShanaiZairyouKbn" type="hidden">
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
                    <div class="form-column">
                        <!-- 「受注品区分」チェックボックス -->
                        <div class="flex-box" style="height: 2.5em; align-items: center;">
                            <span style="width:9em;">{{__('jhuchuhin_kbn')}}</span>
                            <div class="form-check">
                                <input id="dataJhuchuhinKbn" name="dataJhuchuhinKbn" class="form-check-input" type="checkbox" value="0">
                                <label class="form-check-label" for="dataJhuchuhinKbn">
                                    <?php echo JHUCHUHIN_KBN[1] ?>{{__('として登録する')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-column">
                        <!-- 「仕掛品区分」チェックボックス -->
                        <div class="flex-box" style="height: 2.5em; align-items: center;">
                            <span style="width:9em;">{{__('shikakari_kbn')}}</span>
                            <div class="form-check">
                                <input id="dataShikakariKbn" name="dataShikakariKbn" class="form-check-input" type="checkbox" value="0">
                                <label class="form-check-label" for="dataShikakariKbn">
                                    <?php echo SHIKAKARI_KBN[1] ?>{{__('として登録する')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-column">
                        <!-- 「副資材区分」チェックボックス -->
                        <div class="flex-box" style="height: 2.5em; align-items: center;">
                            <span style="width:9em;">{{__('fukushizai_kbn')}}</span>
                            <div class="form-check">
                                <input id="dataFukushizaiKbn" name="dataFukushizaiKbn" class="form-check-input" type="checkbox" value="0">
                                <label class="form-check-label" for="dataFukushizaiKbn">
                                    <?php echo FUKUSHIZAI_KBN[1] ?>{{__('として登録する')}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-column">
                        <!-- N -->
                        <label>
                            <span style="width:6em;"></span>
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- N -->
                        <label>
                            <span style="width:6em;"></span>
                        </label>
                    </div>
                </div>
                <!-- 二列目 -->
                <div class="flex-box flex-start flex-column item-start" style="padding-left:10px; width:30em;">
                    <div class="form-column" style="width: 100%;">
                        <!-- 「諸口区分」 -->
                        <div class="flex-box" style="height: 2.5em; align-items: center;">
                            <span style="width:8.5em;">{{__('shokuchi_kbn')}}</span>
                            <div style="width: 60%; display: flex; margin-left: 10px;">
                                <div class="form-check" style="width: 40%;">
                                    <input name="rdoShokuchiKbn" id="shokuchiKbn1" class="form-check-input rdoShokuchiKbn" 
                                        type="radio" value="0" checked>
                                    <label class="form-check-label" for="shokuchiKbn1" style="width: 100%;">
                                        <?php echo SHOKUCHI_KBN[0] ?></label>
                                </div>
                                <div class="form-check" style="width: 60%;">
                                    <input name="rdoShokuchiKbn" id="shokuchiKbn2" class="form-check-input rdoShokuchiKbn" 
                                        type="radio" value="1">
                                    <label class="form-check-label" for="shokuchiKbn2" style="width: 100%;">
                                        <?php echo SHOKUCHI_KBN[1] ?></label>
                                </div>
                                <input name="dataShokuchiKbn" type="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="form-column" style="width: 100%;">
                        <!-- 「在庫管理区分」 -->
                        <div class="flex-box" style="height: 2.5em; align-items: center;">
                            <span style="width:8.5em;">{{__('zaikokanri_kbn')}}</span>
                            <div style="width: 60%; display: flex; margin-left: 10px;">
                                <div class="form-check" style="width: 40%;">
                                    <input name="rdoZaikokanriKbn" id="zaikokanriKbn1" class="form-check-input rdoZaikokanriKbn"
                                        type="radio" value="0" checked>
                                    <label class="form-check-label" for="zaikokanriKbn1" style="width: 100%;">
                                        <?php echo ZAIKOKANRI_TAISHOUGAI_KBN[0] ?></label>
                                </div>
                                <div class="form-check ZaikokanriKbn2" style="width: 60%;">
                                    <input name="rdoZaikokanriKbn" id="zaikokanriKbn2" class="form-check-input rdoZaikokanriKbn" 
                                        type="radio" value="1">
                                    <label class="form-check-label" for="zaikokanriKbn2" style="width: 100%;">
                                        <?php echo ZAIKOKANRI_TAISHOUGAI_KBN[1] ?></label>
                                </div>
                                <input name="dataZaikokanriKbn" type="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="form-column" style="width: 100%;"> 
                        <!-- 「単価入力区分」 -->
                        <div class="flex-box" style="height: 2.5em; align-items: center;">
                            <span style="width:8.5em;">{{__('tanka_input_kbn')}}</span>
                            <div style="width: 60%; display: flex; margin-left: 10px;">
                                <div class="form-check" style="width: 40%;">
                                    <input name="rdoTankaInputKbn" id="tankaInputKbn1" class="form-check-input rdoTankaInputKbn" 
                                        type="radio" value="0" checked>
                                    <label class="form-check-label" for="tankaInputKbn1" style="width: 100%;">
                                        <?php echo TANKA_INPUT_KBN[0] ?></label>
                                </div>
                                <div class="form-check tankaInputKbn2" style="width: 60%;">
                                    <input name="rdoTankaInputKbn" id="tankaInputKbn2" class="form-check-input rdoTankaInputKbn" 
                                        type="radio" value="1">
                                    <label class="form-check-label" for="tankaInputKbn2" style="width: 100%;">
                                        <?php echo TANKA_INPUT_KBN[1] ?></label>
                                </div>
                                <input name="dataTankaInputKbn" type="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="form-column" style="width: 100%;">
                        <!-- 「消費税区分」 -->
                        <div class="flex-box" style="height: 2.5em; align-items: center;">
                            <span style="width:8.5em;">{{__('shouhizei_kbn')}}</span>
                            <div style="width: 60%; display: flex; margin-left: 10px;">
                                <div class="form-check" style="width: 40%;">
                                    <input name="rdoShouhizeiKbn" id="shouhizeiKbn1" class="form-check-input rdoShouhizeiKbn" 
                                        type="radio" value="0" checked>
                                    <label class="form-check-label" for="shouhizeiKbn1" style="width: 100%;">
                                        <?php echo SHOUHIZEI_KBN[0] ?></label>
                                </div>
                                <div class="form-check shouhizeiKbn2" style="width: 60%;">
                                    <input name="rdoShouhizeiKbn" id="shouhizeiKbn2" class="form-check-input rdoShouhizeiKbn" 
                                        type="radio" value="1">
                                    <label class="form-check-label" for="shouhizeiKbn2" style="width: 100%;">
                                        <?php echo SHOUHIZEI_KBN[1] ?></label>
                                </div>
                                <input name="dataShouhizeiKbn" type="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="form-column" style="width: 100%;">
                        <!-- 「軽減税率適用区分」 -->
                        <div class="flex-box" style="height: 2.5em; align-items: center;">
                            <span style="width:8.5em;">{{__('keigenzeiritsu_kbn')}}</span>
                            <div style="width: 60%; display: flex; margin-left: 10px;">
                                <div class="form-check" style="width: 40%;">
                                    <input name="rdoKeigenzeiritsuKbn" id="keigenzeiritsuKbn1" class="form-check-input rdoKeigenzeiritsuKbn" 
                                        type="radio" value="0" checked>
                                    <label class="form-check-label" for="keigenzeiritsuKbn1" style="width: 100%;">
                                        <?php echo KEIGENZEIRITSU_KBN[0] ?></label>
                                </div>
                                <div class="form-check keigenzeiritsuKbn2" style="width: 60%;">
                                    <input name="rdoKeigenzeiritsuKbn" id="keigenzeiritsuKbn2" class="form-check-input rdoKeigenzeiritsuKbn" 
                                        type="radio" value="1">
                                    <label class="form-check-label" for="keigenzeiritsuKbn2" style="width: 100%;">
                                        <?php echo KEIGENZEIRITSU_KBN[1] ?></label>
                                </div>
                                <input name="dataKeigenzeiritsuKbn" type="hidden">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- tab1 -->
        <div class="tab_content " id="tab1_content">
            <div class="flex-box flex-between item-start">
                <!-- 一列目 -->
                <div class="flex-box flex-start flex-column item-start">   
                    <div class="form-column">
                        <!-- 「材質名CD」 -->
                        <label>
                            <span style="width:6em;">{{__('zaishitsu_cd')}}</span>
                            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                                <input name="dataZaishitsuCd" class="form-control code-check" type="text" maxlength="12" autocomplete="off"
                                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,12})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                                <i class="fas fa-search search-btn"></i>
                            </span>
                            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                            <input name="dataZaishitsuName" class="form-control" type="text" style="width:12em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「メーカーCD」 -->
                        <label>
                            <span style="width:6em;">{{__('maker_cd')}}</span>
                            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                                <input name="dataMakerCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off"
                                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                                <i class="fas fa-search search-btn"></i>
                            </span>
                            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                            <input name="dataMakerName" class="form-control" type="text" style="width:12em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「色CD」 -->
                        <label>
                            <span style="width:6em;">{{__('color_cd')}}</span>
                            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                                <input name="dataColorCd" class="form-control code-check" type="text" maxlength="3" autocomplete="off"
                                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,3})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                                <i class="fas fa-search search-btn"></i>
                            </span>
                            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                            <input name="dataColorName" class="form-control" type="text" style="width:12em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「グレードCD」 -->
                        <label>
                            <span style="width:6em;">{{__('grade_cd')}}</span>
                            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                                <input name="dataGradeCd" class="form-control code-check" type="text" maxlength="6" autocomplete="off"
                                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,6})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                                <i class="fas fa-search search-btn"></i>
                            </span>
                            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                            <input name="dataGradeName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「形状CD」 -->
                        <label>
                            <span style="width:6em;">{{__('keijou_cd')}}</span>
                            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                                <input name="dataKeijouCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off"
                                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                                <i class="fas fa-search search-btn"></i>
                            </span>
                            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                            <input name="dataKeijouName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「規格」 -->
                        <label>
                            <span style="width:6em;">{{__('kikaku_name')}}</span>
                            <input name="dataKikakuName" class="form-control" type="text" maxlength="30" autocomplete="off"
                                style="width:20em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「材料規格」 -->
                        <label>
                            <span style="width:6em;">{{__('zairyou_kikaku')}}</span>
                            <input name="dataKikaku" class="form-control" type="text" maxlength="30" autocomplete="off"
                                style="width:20em;">
                        </label>
                    </div>
                </div>
                <!-- 二列目 -->
                <div class="flex-box flex-start flex-column item-start" style="padding-left:10px; width:30em;">
                    <div class="form-column">
                        <!-- 「サイズ　(W)幅」 -->
                        <label>
                            <span style="width:6.3em;">{{__('size_w')}}</span>
                            <!-- 「サイズ　(W)幅」コントロール本体 -->
                            <div id="numSizeW" style="width:20em;"></div>
                            <input name="dataSizeW" type="hidden">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「サイズ　(D)奥行」 -->
                        <label>
                            <span style="width:6.3em;">{{__('size_d')}}</span>
                            <!-- 「サイズ　(D)奥行」コントロール本体 -->
                            <div id="numSizeD" style="width:20em;"></div>
                            <input name="dataSizeD" type="hidden">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「サイズ　(H)高さ」 -->
                        <label>
                            <span style="width:6.3em;">{{__('size_h')}}</span>
                            <!-- 「サイズ　(H)高さ」コントロール本体 -->
                            <div id="numSizeH" style="width:20em;"></div>
                            <input name="dataSizeH" type="hidden">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「通常仕入先CD」 -->
                        <label>
                            <span style="width:6em;">{{__('tsuujou_shiiresaki_cd')}}</span>
                            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                                <input name="dataShiiresakiCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off"
                                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                                <i class="fas fa-search search-btn"></i>
                            </span>
                            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                            <input name="dataShiiresakiName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「入庫置場CD」 -->
                        <label>
                            <span style="width:6em;">{{__('nyuko_okiba_cd')}}</span>
                            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                                <input name="dataNyukoOkibaCd" class="form-control code-check" type="text" maxlength="20" autocomplete="off"
                                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,20})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                                <i class="fas fa-search search-btn"></i>
                            </span>
                            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                            <input name="dataNyukoOkibaName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「入庫棚CD」 -->
                        <label>
                            <span style="width:6em;">{{__('nyuko_tana_cd')}}</span>
                            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                                <input name="dataNyukoTanaCd" class="form-control code-check" type="text" maxlength="20" autocomplete="off"
                                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,20})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                                <i class="fas fa-search search-btn"></i>
                            </span>
                            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                            <input name="dataNyukoTanaName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- tab2 -->
        <div class="tab_content" id="tab2_content">
            <div class="flex-box flex-between item-start">
                <!-- 一列目 -->
                <div class="flex-box flex-start flex-column item-start">   
                    <div class="form-column">
                        <!-- 「業種CD」 -->
                        <label>
                            <span style="width:6em;">{{__('gyoushu_cd')}}</span>
                            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                                <input name="dataGyoushuCd" class="form-control code-check" type="text" maxlength="4" autocomplete="off"
                                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,4})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                                <i class="fas fa-search search-btn"></i>
                            </span>
                            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                            <input name="dataGyoushuName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「使用主材料CD」 -->
                        <label>
                            <span style="width:6em;">{{__('shuzairyou_cd')}}</span>
                            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                                <input name="dataShuZairyouCd" class="form-control code-check" type="text" maxlength="30" autocomplete="off"
                                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,30})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                                <i class="fas fa-search search-btn"></i>
                            </span>
                            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                            <input name="dataShuZairyouName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「客先品名番」 -->
                        <label>
                            <span style="width:6em;">{{__('kyakusaki_hinban_cd')}}</span>
                            <input name="dataKyakusakiHinbanCd" class="form-control" type="text" maxlength="30" autocomplete="off"
                                style="width:20em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「フォルダー名」 -->
                        <label>
                            <span style="width:6em;">{{__('folder_name')}}</span>
                            <input name="dataFolderName" class="form-control" type="text" maxlength="128" autocomplete="off"
                                style="width:20em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「ファイル名」 -->
                        <label>
                            <span style="width:6em;">{{__('file_name')}}</span>
                            <input name="dataFileName" class="form-control" type="text" style="width:20em;" onfocus="blur();" readonly>
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「ファイル名」 -->
                        <label>
                            <input id="dataFile" class="form-control" type="file" maxlength="64" autocomplete="off"
                                style="margin-left: 6.3em; width:20em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「材料費」 -->
                        <label>
                            <span style="width:6.3em;">{{__('zairyou_kin')}}</span>
                            <!-- 「材料費」コントロール本体 -->
                            <div id="numZairyouKin" style="width:20em;"></div>
                            <input name="dataZairyouKin" type="hidden">
                        </label>
                    </div>
                </div>
                <!-- 二列目 -->
                <div class="flex-box flex-start flex-column item-start" style="padding-left:10px; width:30em;">
                    <div class="form-column" style="width: 100%;">
                        <!-- 「図面区分」 -->
                        <div class="flex-box" style="height: 2.5em; align-items: center;">
                            <span style="width:7em;">{{__('zumen_kbn')}}</span>
                            <div style="width: 60%; display: flex; margin-left: 10px;">
                                <div class="form-check" style="width: 60%;">
                                    <input name="rdoZumenKbn" id="zumenKbn1" class="form-check-input rdoZumenKbn" 
                                        type="radio" value="0" checked>
                                    <label class="form-check-label" for="zumenKbn1" style="width: 100%;">
                                        <?php echo ZUMEN_KBN[0] ?></label>
                                </div>
                                <div class="form-check zumenKbn2" style="width: 40%;">
                                    <input name="rdoZumenKbn" id="zumenKbn2" class="form-check-input rdoZumenKbn" 
                                        type="radio" value="1">
                                    <label class="form-check-label" for="zumenKbn2" style="width: 100%;">
                                        <?php echo ZUMEN_KBN[1] ?></label>
                                </div>
                                <input name="dataZumenKbn" type="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="form-column" style="width: 100%;">
                        <!-- 「検査区分」 -->
                        <div class="flex-box" style="height: 2.5em; align-items: center;">
                            <span style="width:7em;">{{__('kensa_kbn')}}</span>
                            <div style="width: 60%; display: flex; margin-left: 10px;">
                                <div class="form-check" style="width: 60%;">
                                    <input name="rdoKensaKbn" id="kensaKbn1" class="form-check-input rdoKensaKbn" 
                                        type="radio" value="0" checked>
                                    <label class="form-check-label" for="kensaKbn1" style="width: 100%;">
                                        <?php echo KENSA_KBN[0] ?></label>
                                </div>
                                <div class="form-check kensaKbn2" style="width: 40%;">
                                    <input name="rdoKensaKbn" id="kensaKbn2" class="form-check-input rdoKensaKbn" 
                                        type="radio" value="1">
                                    <label class="form-check-label" for="kensaKbn2" style="width: 100%;">
                                        <?php echo KENSA_KBN[1] ?></label>
                                </div>
                                <input name="dataKensaKbn" type="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="form-column" style="width: 100%;">
                        <!-- 「新規受注シート区分」 -->
                        <div class="flex-box" style="height: 2.5em; align-items: center;">
                            <span style="width:7em;">{{__('shinki_juchu_sheet_kbn')}}</span>
                            <div style="width: 60%; display: flex; margin-left: 10px;">
                                <div class="form-check" style="width: 60%;">
                                    <input name="rdoShinkiJuchuSheetKbn" id="shinkiJuchuSheetKbn1" class="form-check-input rdoShinkiJuchuSheetKbn" 
                                        type="radio" value="0" checked>
                                    <label class="form-check-label" for="shinkiJuchuSheetKbn1" style="width: 100%;">
                                        <?php echo SHINKI_JUCHU_SHEET_KBN[0] ?></label>
                                </div>
                                <div class="form-check shinkiJuchuSheetKbn2" style="width: 40%;">
                                    <input name="rdoShinkiJuchuSheetKbn" id="shinkiJuchuSheetKbn2" class="form-check-input rdoShinkiJuchuSheetKbn" 
                                        type="radio" value="1">
                                    <label class="form-check-label" for="shinkiJuchuSheetKbn2" style="width: 100%;">
                                        <?php echo SHINKI_JUCHU_SHEET_KBN[1] ?></label>
                                </div>
                                <input name="dataShinkiJuchuSheetKbn" type="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="form-column" style="width: 100%;">
                        <!-- 「余剰在庫区分」 -->
                        <div class="flex-box" style="height: 2.5em; align-items: center;">
                            <span style="width:7em;">{{__('yojouzaiko_kbn')}}</span>
                            <div style="width: 60%; display: flex; margin-left: 10px;">
                                <div class="form-check" style="width: 60%;">
                                    <input name="rdoYojouzaikoKbn" id="yojouzaikoKbn1" class="form-check-input rdoYojouzaikoKbn" 
                                        type="radio" value="0" checked>
                                    <label class="form-check-label" for="yojouzaikoKbn1" style="width: 100%;">
                                        <?php echo YOJOUZAIKO_KBN[0] ?></label>
                                </div>
                                <div class="form-check yojouzaikoKbn2" style="width: 40%;">
                                    <input name="rdoYojouzaikoKbn" id="yojouzaikoKbn2" class="form-check-input rdoYojouzaikoKbn" 
                                        type="radio" value="1">
                                    <label class="form-check-label" for="yojouzaikoKbn2" style="width: 100%;">
                                        <?php echo YOJOUZAIKO_KBN[1] ?></label>
                                </div>
                                <input name="dataYojouzaikoKbn" type="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="form-column">
                        <!-- 「製品寸法」 -->
                        <label>
                            <span style="width:7em;">{{__('ItemSize')}}</span>
                            <input name="dataItemSize" class="form-control" type="text" maxlength="30" autocomplete="off"
                                style="width:20em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「切断寸法」 -->
                        <label>
                            <span style="width:7em;">{{__('CuttingSize')}}</span>
                            <input name="dataCuttingSize" class="form-control" type="text" maxlength="30" autocomplete="off"
                                style="width:20em;">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- tab3 -->
        <div class="tab_content" id="tab3_content">
            <div class="flex-box flex-between item-start">
                <!-- 一列目 -->
                <div class="flex-box flex-start flex-column item-start">   
                    <div class="form-column">
                        <!-- 「得意先CD」 -->
                        <label>
                            <span style="width:6em;">{{__('tokuisaki_cd')}}</span>
                            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                                <input name="dataTokuisakiCd" class="form-control code-check" type="text" maxlength="10" autocomplete="off"
                                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,10})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                                <i class="fas fa-search search-btn"></i>
                            </span>
                            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                            <input name="dataTokuisakiName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「ネジゲージ」 -->
                        <label>
                            <span style="width:6em;">{{__('neji_geji')}}</span>
                            <input name="dataNejiGeji" class="form-control" type="text" maxlength="20" autocomplete="off"
                                style="width:20em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「作業内訳1」 -->
                        <label>
                            <span style="width:6em;">{{__('sagyou_uchiwake1')}}</span>
                            <input name="dataSagyouUchiwake1" class="form-control" type="text" maxlength="10" autocomplete="off"
                                style="width:20em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「作業内訳2」 -->
                        <label>
                            <span style="width:6em;">{{__('sagyou_uchiwake2')}}</span>
                            <input name="dataSagyouUchiwake2" class="form-control" type="text" maxlength="10" autocomplete="off"
                                style="width:20em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「作業内訳3」 -->
                        <label>
                            <span style="width:6em;">{{__('sagyou_uchiwake3')}}</span>
                            <input name="dataSagyouUchiwake3" class="form-control" type="text" maxlength="10" autocomplete="off"
                                style="width:20em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「図面番号」 -->
                        <label>
                            <span style="width:6em;">{{__('zumen_no')}}</span>
                            <input name="dataZumenNo" class="form-control" type="text" maxlength="30" autocomplete="off"
                                style="width:20em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- N -->
                        <label>
                            <span style="width:6em;"></span>
                        </label>
                    </div>                
                </div>
                <!-- 二列目 -->
                <div class="flex-box flex-start flex-column item-start" style="padding-left:10px; width:30em;">
                    <div class="form-column">
                        <!-- 「備考（営業）」 -->
                        <label style="height:4em;">
                            <span style="width:6.3em;">{{__('bikou_eigyou')}}</span>
                            <textarea name="dataBikouEigyou" class="form-control" maxlength="40" autocomplete="off" 
                                style="width:20em;"></textarea>
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「備考」 -->
                        <label style="height:3.5em;">
                            <span style="width:6.3em;">{{__('bikou')}}</span>
                            <textarea name="dataBikou" class="form-control" maxlength="40" autocomplete="off" 
                                style="width:20em;"></textarea>
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「部品番号」 -->
                        <label>
                            <span style="width:6em;">{{__('buban')}}</span>
                            <input name="dataBuban" class="form-control" type="text" maxlength="10" autocomplete="off"
                                style="width:20em;">
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「材料手配区分」 -->
                        <label>
                            <span style="width:6em;">{{__('zairyou_tehai_kbn')}}</span>
                            <span class="icon-field"> <!-- アイコンボタンを設置する入力項目は、スタイルクラス「icon-field」を宣言 -->
                                <!-- コード検査を行う項目は、スタイルクラス「code-check」を宣言 -->
                                <input name="dataZairyouTehaiKbn" class="form-control code-check" type="text" maxlength="1" autocomplete="off"
                                    style="width:8em;" pattern="^([a-zA-Z0-9]{0,1})$" title="{{__('半角英数字6文字以内で入力してください')}}">
                                <!-- 検索アイコンは、スタイルクラス「search-btn」を宣言 -->
                                <i class="fas fa-search search-btn"></i>
                            </span>
                            <!-- フォーカス時のイベントを「onfocus="blur();"」に設定してフォーカス対象を無効にする -->
                            <input name="dataZairyouTehaiName" class="form-control" type="text" style="width:12em;" onfocus="blur();" readonly>
                        </label>
                    </div>
                    <div class="form-column">
                        <!-- 「計画品目原価」 -->
                        <label>
                            <span style="width:6.3em;">{{__('keikaku_hinmoku_genka_kin')}}</span>
                            <!-- 「計画品目原価」コントロール本体 -->
                            <div id="numKeikakuHinmokuGenkaKin" style="width:20em;"></div>
                            <input name="dataKeikakuHinmokuGenkaKin" type="hidden">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- tab4 -->
        <div class="tab_content" id="tab4_content">
             <div class="flex-box flex-between item-start">
                <!-- 図面 -->
                <div class="flex-box flex-start flex-column item-start" style="width:100%;">   
                    <div class="form-column" style="width:100%;">
                        <!-- 「子図面」 -->
                        <label>
                            <span style="width:6em;">{{__('kozumen1')}}</span>
                            <input name="dataKozumen1" class="form-control" type="text" style="width:30%;" onfocus="blur();" readonly>
                            <input id="imgKozumen1" name="imgKozumen1" class="form-control" type="file" maxlength="64" autocomplete="off"
                                style="width:70%;" accept="image/png, image/jpeg">
                        </label>
                    </div>                
                    <div class="form-column" style="margin-left: 6em; width:98%; height: <?php echo $zumenHight ?>px;">
                        <div id="preview" style="box-sizing:border-box;"></div>
                    </div>                
                </div>
             </div>
        </div>
    </div>

    <div class="form-column">
        <!-- 「有効期間（自）」 -->
        <label>
            <span>{{__('yukoukikan_start_date')}}</span>
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

    /* 有効期間（自） */
    var dateStart = new wijmo.input.InputDate('#dataStartDate');
    /* 数量宣言 */
    var numSizeW = new wijmo.input.InputNumber('#numSizeW', { isRequired: false, format: 'n3', min: 0, max: 9999999});
    var numSizeD = new wijmo.input.InputNumber('#numSizeD', { isRequired: false, format: 'n3', min: 0, max: 9999999});
    var numSizeH = new wijmo.input.InputNumber('#numSizeH', { isRequired: false, format: 'n3', min: 0, max: 9999999});
    var numZairyouKin = new wijmo.input.InputNumber('#numZairyouKin', { isRequired: false, format: 'n0', min: 0, max: 999999999});
    var numKeikakuHinmokuGenkaKin = new wijmo.input.InputNumber('#numKeikakuHinmokuGenkaKin', 
        { isRequired: false, format: 'n2', min: 0, max: 99999999999});
    var HinmokuCd = document.getElementsByName('dataHinmokuCd');
    /**区分宣言 */
    var rdoZairyouKbn = document.getElementById('rdoZairyouKbn');
    var rdoKyotenZairyouKbn = document.getElementById('rdoKyotenZairyouKbn');
    var rdoShanaiZairyouKbn = document.getElementById('rdoShanaiZairyouKbn');
    var chkJhuchuhinKbn = document.getElementById('dataJhuchuhinKbn');
    var chkShikakariKbn = document.getElementById('dataShikakariKbn');
    var chkFukushizaiKbn = document.getElementById('dataFukushizaiKbn');
    var rdoShokuchiKbn = document.getElementsByName('dataShokuchiKbn');
    var rdoZaikokanriKbn = document.getElementsByName('dataZaikokanriKbn');
    var rdoTankaInputKbn = document.getElementsByName('dataTankaInputKbn');
    var rdoShouhizeiKbn = document.getElementsByName('dataShouhizeiKbn');
    var rdoKeigenzeiritsuKbn = document.getElementsByName('dataKeigenzeiritsuKbn');
    var rdoZumenKbn = document.getElementsByName('dataZumenKbn');
    var rdoKensaKbn = document.getElementsByName('dataKensaKbn');
    var rdoShinkiJuchuSheetKbn = document.getElementsByName('dataShinkiJuchuSheetKbn');
    var rdoYojouzaikoKbn = document.getElementsByName('dataYojouzaikoKbn');
    /**ファイル宣言 */
    var dataFile = document.getElementById('dataFile');
    var imgKozumen1 = document.getElementById('imgKozumen1');
 
    /* -------- */
    /* 初期処理 */
    /* -------- */

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
        /* 「CSV出力」ボタンイベント登録 ※common_function.js参照 */
        SetBtnCSV(fncExportCSV);

        /* グリッド初期処理*/
        InitGrid();

        /* 受注区分初期処理 */
        // AjaxData("{{ url('/inquiry/1300') }}", { 'dataTargetCd': 'JUCHUKBN' }, fncJushinJuchuKbnData);
        
        /* グリッドデータの表示 */
        $('#btnHyouji').click();
    }
    /* グリッド共有変数 */
    var gridMaster;
    /* グリッド初期処理*/
    function InitGrid()
    {
        /* FlexGridのレイアウト設定 */
        let columns = [
            {
                binding: 'dataJigyoubuCd',
                header : "{{__('jigyoubu_cd')}}",
                width  : 100
            },
            {
                binding: 'dataJigyoubuName',
                header : "{{__('jigyoubu_name')}}",
                width  : 100
            },
            {
                binding: 'dataHinmokuCd',
                header : "{{__('hinmoku_cd')}}",
                width  : 100
            },
            {
                binding: 'dataHinmokuName1',
                header : "{{__('hinmoku_name')}}",
                width  : 100
            },
            {
                binding: 'dataHinmokuName2',
                header : "{{__('hinmoku_kana')}}",
                width  : 100
            },
            {
                binding: 'dataHinmokuKbn',
                header : "{{__('hinmoku_kbn')}}",
                width  : 100
            },
            {
                binding: 'dataHinmokuKbnName',
                header : "{{__('hinmoku_kbn_name')}}",
                width  : 100
            },
            {
                binding: 'dataTanniCd',
                header : "{{__('tanni_cd')}}",
                width  : 100
            },
            {
                binding: 'dataTanniName',
                header : "{{__('tanni_name')}}",
                width  : 100
            },
            {
                binding: 'capZairyouKbn',
                header : "{{__('zairyou_kbn')}}",
                width  : 100
            },
            {
                binding: 'capKyotenZairyouKbn',
                header : "{{__('kyoten_zairyou_kbn')}}",
                width  : 100
            },
            {
                binding: 'capShanaiZairyouKbn',
                header : "{{__('shanai_zairyou_kbn')}}",
                width  : 100
            },
            {
                binding: 'capJhuchuhinKbn',
                header : "{{__('jhuchuhin_kbn')}}",
                width  : 100
            },
            {
                binding: 'capShikakariKbn',
                header : "{{__('shikakari_kbn')}}",
                width  : 100
            },
            {
                binding: 'capFukushizaiKbn',
                header : "{{__('fukushizai_kbn')}}",
                width  : 100
            },
            {
                binding: 'capShokuchiKbn',
                header : "{{__('shokuchi_kbn')}}",
                width  : 100
            },
            {
                binding: 'capZaikokanriKbn',
                header : "{{__('zaikokanri_kbn')}}",
                width  : 100
            },
            {
                binding: 'capTankaInputKbn',
                header : "{{__('tanka_input_kbn')}}",
                width  : 100
            },
            {
                binding: 'capShouhizeiKbn',
                header : "{{__('shouhizei_kbn')}}",
                width  : 100
            },
            {
                binding: 'capKeigenzeiritsuKbn',
                header : "{{__('keigenzeiritsu_kbn')}}",
                width  : 100
            },
            {
                binding: 'dataZaishitsuCd',
                header : "{{__('zaishitsu_cd')}}",
                width  : 100
            },
            {
                binding: 'dataZaishitsuName',
                header : "{{__('zaishitsu_name')}}",
                width  : 100
            },
            {
                binding: 'dataMakerCd',
                header : "{{__('maker_cd')}}",
                width  : 100
            },
            {
                binding: 'dataMakerName',
                header : "{{__('maker_name')}}",
                width  : 100
            },
            {
                binding: 'dataColorCd',
                header : "{{__('color_cd')}}",
                width  : 100
            },
            {
                binding: 'dataColorName',
                header : "{{__('color_name')}}",
                width  : 100
            },
            {
                binding: 'dataGradeCd',
                header : "{{__('grade_cd')}}",
                width  : 100
            },
            {
                binding: 'dataGradeName',
                header : "{{__('grade_name')}}",
                width  : 100
            },
            {
                binding: 'dataKeijouCd',
                header : "{{__('keijou_cd')}}",
                width  : 100
            },
            {
                binding: 'dataKeijouName',
                header : "{{__('keijou_name')}}",
                width  : 100
            },
            {
                binding: 'dataKikakuName',
                header : "{{__('kikaku_name')}}",
                width  : 100
            },
            {
                binding: 'dataKikaku',
                header : "{{__('zairyou_kikaku')}}",
                width  : 100
            },
            {
                binding: 'dataSizeW',
                header : "{{__('size_w')}}",
                width  : 100
            },
            {
                binding: 'dataSizeD',
                header : "{{__('size_d')}}",
                width  : 100
            },
            {
                binding: 'dataSizeH',
                header : "{{__('size_h')}}",
                width  : 100
            },
            {
                binding: 'dataShiiresakiCd',
                header : "{{__('tsuujou_shiiresaki_cd')}}",
                width  : 100
            },
            {
                binding: 'dataShiiresakiName',
                header : "{{__('shiiresaki_ryaku')}}",
                width  : 100
            },
            {
                binding: 'dataNyukoOkibaCd',
                header : "{{__('nyuko_okiba_cd')}}",
                width  : 100
            },
            {
                binding: 'dataNyukoOkibaName',
                header : "{{__('nyuko_okiba_name')}}",
                width  : 100
            },
            {
                binding: 'dataNyukoTanaCd',
                header : "{{__('nyuko_tana_cd')}}",
                width  : 100
            },
            {
                binding: 'dataNyukoTanaName',
                header : "{{__('nyuko_tana_name')}}",
                width  : 100
            },
            {
                binding: 'dataGyoushuCd',
                header : "{{__('gyoushu_cd')}}",
                width  : 100
            },
            {
                binding: 'dataGyoushuName',
                header : "{{__('gyoushu_name')}}",
                width  : 100
            },
            {
                binding: 'dataShuZairyouCd',
                header : "{{__('shuzairyou_cd')}}",
                width  : 100
            },
            {
                binding: 'dataShuZairyouName',
                header : "{{__('shu_zairyou_name')}}",
                width  : 100
            },
            {
                binding: 'dataKyakusakiHinbanCd',
                header : "{{__('kyakusaki_hinban_cd')}}",
                width  : 100
            },
            {
                binding: 'dataFolderName',
                header : "{{__('folder_name')}}",
                width  : 100
            },
            {
                binding: 'dataFileName',
                header : "{{__('file_name')}}",
                width  : 100
            },
            {
                binding: 'dataZairyouKin',
                header : "{{__('zairyou_kin')}}",
                width  : 100
            },
            {
                binding: 'capZumenKbn',
                header : "{{__('zumen_kbn')}}",
                width  : 100
            },
            {
                binding: 'capKensaKbn',
                header : "{{__('kensa_kbn')}}",
                width  : 100
            },
            {
                binding: 'capShinkiJuchuSheetKbn',
                header : "{{__('shinki_juchu_sheet_kbn')}}",
                width  : 100
            },
            {
                binding: 'dataItemSize',
                header : "{{__('ItemSize')}}",
                width  : 100
            },
            {
                binding: 'dataCuttingSize',
                header : "{{__('CuttingSize')}}",
                width  : 100
            },
            {
                binding: 'dataTokuisakiCd',
                header : "{{__('tokuisaki_cd')}}",
                width  : 100
            },
            {
                binding: 'dataTokuisakiName',
                header : "{{__('tokuisaki_name')}}",
                width  : 100
            },
            {
                binding: 'dataNejiGeji',
                header : "{{__('neji_geji')}}",
                width  : 100
            },
            {
                binding: 'dataSagyouUchiwake1',
                header : "{{__('sagyou_uchiwake1')}}",
                width  : 100
            },
            {
                binding: 'dataSagyouUchiwake2',
                header : "{{__('sagyou_uchiwake2')}}",
                width  : 100
            },
            {
                binding: 'dataSagyouUchiwake3',
                header : "{{__('sagyou_uchiwake3')}}",
                width  : 100
            },
            {
                binding: 'dataZumenNo',
                header : "{{__('zumen_no')}}",
                width  : 100
            },
            {
                binding: 'dataBikouEigyou',
                header : "{{__('bikou_eigyou')}}",
                width  : 100
            },
            {
                binding: 'dataBikou',
                header : "{{__('bikou')}}",
                width  : 100
            },
            {
                binding: 'dataBuban',
                header : "{{__('buban')}}",
                width  : 100
            },
            {
                binding: 'dataZairyouTehaiKbn',
                header : "{{__('zairyou_tehai_kbn')}}",
                width  : 100
            },
            {
                binding: 'dataZairyouTehaiName',
                header : "{{__('zairyou_tehai_name')}}",
                width  : 100
            },
            {
                binding: 'dataKeikakuHinmokuGenkaKin',
                header : "{{__('keikaku_hinmoku_genka_kin')}}",
                width  : 100
            },
            {
                binding: 'dataKozumen1',
                header : "{{__('kozumen1')}}",
                width  : 100
            },
            {
                /* 「有効期間（自）」 */
                binding: 'dataStartDate',
                header: "{{ __('yukoukikan_start_date') }}",
                width: 150    
            },
            {
                /* 「有効期間（至）」 */
                binding: 'dataEndDate',
                header : "{{ __('yukoukikan_end_date') }}",
                width  : 150
            }
        ]; 
        /* グリッドの設定 */
        let gridOption = {
            /* レイアウト設定 */
            columns: columns,
            /* 選択スタイル（セル単位） */
            selectionMode: wijmo.grid.SelectionMode.Row,
            /* セル編集（無効） */
            isReadOnly: true,
            /* デフォルト行スタイル（0行ごとに色付け） */
            alternatingRowStep: 0,
            /* グリッド上でのEnterキーイベント（無効） */
            keyActionEnter: wijmo.grid.KeyAction.None,
            /* グリッド自動生成 */
            autoGenerateColumns: false,
            /* セル読み込み時のイベント */
            loadedRows: function (s, e)
            {
                /* 任意の色でセルを色付け
                     ※rowPerItemでMultiRowの1レコード当たりの行数を取得
                     ※common_function.js参照 */
                LoadGridRows(s, 1);
            }
        }       
        /* グリッド宣言 */
        gridMaster = new wijmo.grid.FlexGrid('#gridMaster', gridOption);

        /* グリッド関連のイベント登録 */
        /* グリッドの親要素 */
        let host = gridMaster.hostElement;

        /* グリッドの「右クリック」イベント */
        gridMaster.addEventListener(host, 'contextmenu', function (e)
        {
            if(gridMaster.itemsSource.length < 1 ||
               gridMaster.collectionView.currentItem == null) return; 
            /* セル上での右クリックメニュー表示 ※common_function.js参照 */
            SetGridContextMenu(gridMaster, e);
            /* グリッドに選択する行が無い場合は処理をスキップ */
            if(gridMaster.itemsSource.length < 1) return;
            /* クリックした位置を選択 */
            gridMaster.select(new wijmo.grid.CellRange(gridMaster.hitTest(e).row, 0), true);
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
            /* 「Enterキー」は「修正」ボタンと同じ処理 */
            if(e.keyCode == KEY_ENTER)
            {
                $('#btnShusei').click();
                /* キーボードイベント二重起動防止 */
                windowKeybordFlg = false;
            }
        });
    }

    /* ---------------------------- */
    /* ボタンイベント登録用の関数変数 */
    /* ---------------------------- */

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
        AjaxData("{{ url('/master/2600') }}", soushinData, fncJushinGridData);
        /* 検索件数の取得フラグの送信データを追加 */
        soushinData["dataCntFlg"] = true;
        /* 検索件数のデータ受信 */
        AjaxData("{{ url('/master/2600') }}", soushinData, fncJushinDataCnt);
    }
    /* 「CSV出力」ボタンイベント */
    var fncExportCSV = function()
    {
        /* CSV出力用グリッドのレイアウト設定 */
        let columns = [
            {  binding: 'dataJigyoubuCd', header : "{{__('jigyoubu_cd')}}"},
            {  binding: 'dataJigyoubuName', header : "{{__('jigyoubu_name')}}"},
            {  binding: 'dataHinmokuCd', header : "{{__('hinmoku_cd')}}"},
            {  binding: 'dataHinmokuName1', header : "{{__('hinmoku_name')}}"},
            {  binding: 'dataHinmokuName2',  header : "{{__('hinmoku_kana')}}"},
            {  binding: 'dataHinmokuKbn',  header : "{{__('hinmoku_kbn')}}"},
            {  binding: 'dataHinmokuKbnName',  header : "{{__('hinmoku_kbn_name')}}"},
            {  binding: 'dataTanniCd',  header : "{{__('tanni_cd')}}"},
            {  binding: 'dataTanniName',  header : "{{__('tanni_name')}}"},
            {  binding: 'capZairyouKbn',  header : "{{__('zairyou_kbn')}}"},
            {  binding: 'capKyotenZairyouKbn',  header : "{{__('kyoten_zairyou_kbn')}}"},
            {  binding: 'capShanaiZairyouKbn',  header : "{{__('shanai_zairyou_kbn')}}"},
            {  binding: 'capJhuchuhinKbn',  header : "{{__('jhuchuhin_kbn')}}"},
            {  binding: 'capShikakariKbn',  header : "{{__('shikakari_kbn')}}"},
            {  binding: 'capFukushizaiKbn',  header : "{{__('fukushizai_kbn')}}"},
            {  binding: 'capShokuchiKbn',  header : "{{__('shokuchi_kbn')}}"},
            {  binding: 'capZaikokanriKbn',  header : "{{__('zaikokanri_kbn')}}"},
            {  binding: 'capTankaInputKbn',  header : "{{__('tanka_input_kbn')}}"},
            {  binding: 'capShouhizeiKbn',  header : "{{__('shouhizei_kbn')}}"},
            {  binding: 'capKeigenzeiritsuKbn', header : "{{__('keigenzeiritsu_kbn')}}"},
            {  binding: 'dataZaishitsuCd',  header : "{{__('zaishitsu_cd')}}"},
            {  binding: 'dataZaishitsuName',  header : "{{__('zaishitsu_name')}}"},
            {  binding: 'dataMakerCd', header : "{{__('maker_cd')}}"},
            {  binding: 'dataMakerName',  header : "{{__('maker_name')}}"},
            {  binding: 'dataColorCd',  header : "{{__('color_cd')}}"},
            {  binding: 'dataColorName',  header : "{{__('color_name')}}"},
            {  binding: 'dataGradeCd', header : "{{__('grade_cd')}}"},
            {  binding: 'dataGradeName',  header : "{{__('grade_name')}}"},
            {  binding: 'dataKeijouCd',  header : "{{__('keijou_cd')}}"},
            {  binding: 'dataKeijouName',  header : "{{__('keijou_name')}}"},
            {  binding: 'dataKikakuName',  header : "{{__('kikaku_name')}}"},
            {  binding: 'dataKikaku',  header : "{{__('zairyou_kikaku')}}"},
            {  binding: 'dataSizeW',  header : "{{__('size_w')}}"},
            {  binding: 'dataSizeD',  header : "{{__('size_d')}}"},
            {  binding: 'dataSizeH',  header : "{{__('size_h')}}"},
            {  binding: 'dataShiiresakiCd',  header : "{{__('tsuujou_shiiresaki_cd')}}"},
            {  binding: 'dataShiiresakiName',  header : "{{__('shiiresaki_ryaku')}}"},
            {  binding: 'dataNyukoOkibaCd',  header : "{{__('nyuko_okiba_cd')}}"},
            {  binding: 'dataNyukoOkibaName',  header : "{{__('nyuko_okiba_name')}}"},
            {  binding: 'dataNyukoTanaCd',  header : "{{__('nyuko_tana_cd')}}"},
            {  binding: 'dataNyukoTanaName',  header : "{{__('nyuko_tana_name')}}"},
            {  binding: 'dataGyoushuCd',  header : "{{__('gyoushu_cd')}}"},
            {  binding: 'dataGyoushuName',  header : "{{__('gyoushu_name')}}"},
            {  binding: 'dataShuZairyouCd',  header : "{{__('shuzairyou_cd')}}"},
            {  binding: 'dataShuZairyouName',  header : "{{__('shu_zairyou_name')}}"},
            {  binding: 'dataKyakusakiHinbanCd',  header : "{{__('kyakusaki_hinban_cd')}}"},
            {  binding: 'dataFolderName',  header : "{{__('folder_name')}}"},
            {  binding: 'dataFileName',  header : "{{__('file_name')}}"},
            {  binding: 'dataZairyouKin',  header : "{{__('zairyou_kin')}}"},
            {  binding: 'capZumenKbn',  header : "{{__('zumen_kbn')}}"},
            {  binding: 'capKensaKbn',  header : "{{__('kensa_kbn')}}"},
            {  binding: 'capShinkiJuchuSheetKbn',  header : "{{__('shinki_juchu_sheet_kbn')}}"},
            {  binding: 'dataItemSize',  header : "{{__('ItemSize')}}"},
            {  binding: 'dataCuttingSize',  header : "{{__('CuttingSize')}}"},
            {  binding: 'dataTokuisakiCd',  header : "{{__('tokuisaki_cd')}}"},
            {  binding: 'dataTokuisakiName',  header : "{{__('tokuisaki_name')}}"},
            {  binding: 'dataNejiGeji',  header : "{{__('neji_geji')}}"},
            {  binding: 'dataSagyouUchiwake1',  header : "{{__('sagyou_uchiwake1')}}"},
            {  binding: 'dataSagyouUchiwake2',  header : "{{__('sagyou_uchiwake2')}}"},
            {  binding: 'dataSagyouUchiwake3',  header : "{{__('sagyou_uchiwake3')}}"},
            {  binding: 'dataZumenNo',  header : "{{__('zumen_no')}}"},
            {  binding: 'dataBikouEigyou',  header : "{{__('bikou_eigyou')}}"},
            {  binding: 'dataBikou',  header : "{{__('bikou')}}"},
            {  binding: 'dataBuban',  header : "{{__('buban')}}"},
            {  binding: 'dataZairyouTehaiKbn',  header : "{{__('zairyou_tehai_kbn')}}"},
            {  binding: 'dataZairyouTehaiName',  header : "{{__('zairyou_tehai_name')}}"},
            {  binding: 'dataKeikakuHinmokuGenkaKin',  header : "{{__('keikaku_hinmoku_genka_kin')}}"},
            {  binding: 'dataKozumen1',  header : "{{__('kozumen1')}}"},
            {  binding: 'dataStartDate',  header: "{{ __('yukoukikan_start_date') }}"},
            {  binding: 'dataEndDate',  header : "{{ __('yukoukikan_end_date') }}"}
        ]; 
        /* 現在のグリッドの並び替え条件取得 */
        let sortState = gridMaster.collectionView.sortDescriptions.map(
            function (sd)
            {
                /* 並び替え条件をオブジェクト配列として返す */
                return { property: sd.property, ascending: sd.ascending }
            }
        );
        /* CSV出力時の並び替え条件を設定 */
        let sortDesc = new wijmo.collections.SortDescription(sortState[0].property, sortState[0].ascending);
        /* CSVファイル作成
             ※ファイル名は「ページタイトル+yyyymmddhhMMss（年月日時分秒）+.csv」
             ※common_function.js参照 */
        ExportCSVFile(gridMaster.itemsSource, columns, sortDesc, '{{ $pageTitle }}'+ getNowDateTime() +'.csv');
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
        /* 「事業部CD」 */
        nyuryokuData['dataJigyoubuCd'].value = copy ? data['dataJigyoubuCd'] : '';
        /* 「事業部名」 */
        nyuryokuData['dataJigyoubuName'].value = copy ? data['dataJigyoubuName'] : '';
        /* 「品目CD」 */
        nyuryokuData['dataHinmokuCd'].value = (copy && !insertFlg) ? data['dataHinmokuCd'] : '';
        nyuryokuData['dataHinmokuCd'].disabled = !insertFlg;
        HinmokuCd.value = nyuryokuData['dataHinmokuCd'].value;
        /* 「品目名1」 */
        nyuryokuData['dataHinmokuName1'].value = copy ? data['dataHinmokuName1'] : '';
        /* 「品目名(ｶﾅ)」 */
        nyuryokuData['dataHinmokuName2'].value = copy ? data['dataHinmokuName2'] : '';
        /* 「品目区分」 */
        nyuryokuData['dataHinmokuKbn'].value = copy ? data['dataHinmokuKbn'] : '';
        /* 「品目区分名」 */
        nyuryokuData['dataHinmokuKbnName'].value = copy ? data['dataHinmokuKbnName'] : '';
        /* 「単位CD」 */
        nyuryokuData['dataTanniCd'].value = copy ? data['dataTanniCd'] : '';
        /* 「単位名」 */
        nyuryokuData['dataTanniName'].value = copy ? data['dataTanniName'] : '';
        /* 「材料区分」 */
        /* 「拠点材料区分」 */
        /* 「社内材料区分」 */
        SetZairyouRadio(copy ? data['dataZairyouKbn'] : 0, copy ? data['dataKyotenZairyouKbn'] : 0, copy ? data['dataShanaiZairyouKbn'] : 0);
        /* 「受注品区分」 */
        SetCheckbox('dataJhuchuhinKbn', copy ? data['dataJhuchuhinKbn'] : 0);
        /* 「中間仕掛区分」 */
        SetCheckbox('dataShikakariKbn', copy ? data['dataShikakariKbn'] : 0);
        /* 「副資材区分」 */
        SetCheckbox('dataFukushizaiKbn', copy ? data['dataFukushizaiKbn'] : 0);
        /* 「諸口区分」 */
        SetRadio('shokuchiKbn1', 'shokuchiKbn2', 'dataShokuchiKbn', copy ? data['dataShokuchiKbn'] : 0);
        /* 「在庫管理対象外区分」 */
        SetRadio('zaikokanriKbn1', 'zaikokanriKbn2', 'dataZaikokanriKbn', copy ? data['dataZaikokanriKbn'] : 0);
        /* 「単価入力区分」 */
        SetRadio('tankaInputKbn1', 'tankaInputKbn2', 'dataTankaInputKbn', copy ? data['dataTankaInputKbn'] : 0);
        /* 「消費税区分」 */
        SetRadio('shouhizeiKbn1', 'shouhizeiKbn2', 'dataShouhizeiKbn', copy ? data['dataShouhizeiKbn'] : 0);
        /* 「軽減税率適用区分」 */
        SetRadio('keigenzeiritsuKbn1', 'keigenzeiritsuKbn2', 'dataKeigenzeiritsuKbn', copy ? data['dataKeigenzeiritsuKbn'] : 0);
        /* 「材質名CD」 */
        nyuryokuData['dataZaishitsuCd'].value = copy ? data['dataZaishitsuCd'] : '';
        /* 「材質名名」 */
        nyuryokuData['dataZaishitsuName'].value = copy ? data['dataZaishitsuName'] : '';
        /* 「材質名」 */
        nyuryokuData['dataZaishitsuName'].value = copy ? data['dataZaishitsuName'] : '';
        /* 「メーカーCD」 */
        nyuryokuData['dataMakerCd'].value = copy ? data['dataMakerCd'] : '';
        /* 「メーカー名」 */
        nyuryokuData['dataMakerName'].value = copy ? data['dataMakerName'] : '';
        /* 「色CD」 */
        nyuryokuData['dataColorCd'].value = copy ? data['dataColorCd'] : '';
        /* 「色名」 */
        nyuryokuData['dataColorName'].value = copy ? data['dataColorName'] : '';
        /* 「グレードCD」 */
        nyuryokuData['dataGradeCd'].value = copy ? data['dataGradeCd'] : '';
        /* 「グレード名」 */
        nyuryokuData['dataGradeName'].value = copy ? data['dataGradeName'] : '';
        /* 「形状CD」 */
        nyuryokuData['dataKeijouCd'].value = copy ? data['dataKeijouCd'] : '';
        /* 「形状名」 */
        nyuryokuData['dataKeijouName'].value = copy ? data['dataKeijouName'] : '';
        /* 「規格」 */
        nyuryokuData['dataKikakuName'].value = copy ? data['dataKikakuName'] : '';
        /* 「サイズ　(W)幅」 */
        numSizeW.value = copy ? data['dataSizeW'] : 0;
        /* 「サイズ　(D)奥行」 */
        numSizeD.value = copy ? data['dataSizeD'] : 0;
        /* 「サイズ　(H)高さ」 */
        numSizeH.value = copy ? data['dataSizeH'] : 0;
        /* 「通常仕入先CD」 */
        nyuryokuData['dataShiiresakiCd'].value = copy ? data['dataShiiresakiCd'] : '';
        /* 「通常仕入先名」 */
        nyuryokuData['dataShiiresakiName'].value = copy ? data['dataShiiresakiName'] : '';
        /* 「入庫置場CD」 */
        nyuryokuData['dataNyukoOkibaCd'].value = copy ? data['dataNyukoOkibaCd'] : '';
        /* 「入庫置場名」 */
        nyuryokuData['dataNyukoOkibaName'].value = copy ? data['dataNyukoOkibaName'] : '';
        /* 「入庫棚CD」 */
        nyuryokuData['dataNyukoTanaCd'].value = copy ? data['dataNyukoTanaCd'] : '';
        /* 「入庫棚名」 */
        nyuryokuData['dataNyukoTanaName'].value = copy ? data['dataNyukoTanaName'] : '';
        /* 「材料規格」 */
        nyuryokuData['dataKikaku'].value = copy ? data['dataKikaku'] : '';
        /* 「業種CD」 */
        nyuryokuData['dataGyoushuCd'].value = copy ? data['dataGyoushuCd'] : '';
        /* 「業種名」 */
        nyuryokuData['dataGyoushuName'].value = copy ? data['dataGyoushuName'] : '';
        /* 「図面区分」 */
        SetRadio('zumenKbn1', 'zumenKbn2', 'dataZumenKbn', copy ? data['dataZumenKbn'] : 0);
        /* 「検査区分」 */
        SetRadio('kensaKbn1', 'kensaKbn2', 'dataKensaKbn', copy ? data['dataKensaKbn'] : 0);
        /* 「新規受注シート区分」 */
        SetRadio('shinkiJuchuSheetKbn1', 'shinkiJuchuSheetKbn2', 'dataShinkiJuchuSheetKbn', copy ? data['dataShinkiJuchuSheetKbn'] : 0);
        /* 「余剰在庫区分」 */
        SetRadio('yojouzaikoKbn1', 'yojouzaikoKbn2', 'dataYojouzaikoKbn', copy ? data['dataYojouzaikoKbn'] : 0);
        /* 「製品寸法」 */
        nyuryokuData['dataItemSize'].value = copy ? data['dataItemSize'] : '';
        /* 「切断寸法」 */
        nyuryokuData['dataCuttingSize'].value = copy ? data['dataCuttingSize'] : '';
        /* 「使用主材料CD」 */
        nyuryokuData['dataShuZairyouCd'].value = copy ? data['dataShuZairyouCd'] : '';
        /* 「使用主材料名」 */
        nyuryokuData['dataShuZairyouName'].value = copy ? data['dataShuZairyouName'] : '';
        /* 「客先品名番」 */
        nyuryokuData['dataKyakusakiHinbanCd'].value = copy ? data['dataKyakusakiHinbanCd'] : '';
        /* 「フォルダー名」 */
        nyuryokuData['dataFolderName'].value = copy ? data['dataFolderName'] : '';
        /* 「ファイル名」 */
        dataFile.value = null;
        nyuryokuData['dataFileName'].value = copy ? data['dataFileName'] : '';
        /* 「材料費」 */
        numZairyouKin.value = copy ? data['dataZairyouKin'] : 0;
        /* 「子図面1」 */
        imgKozumen1.value = null;
        var DelPreview = document.getElementById('img');
        if(DelPreview != null) DelPreview.remove();
        nyuryokuData['dataKozumen1'].value = copy ? data['dataKozumen1'] : '';
        // document.getElementById('preview').src = copy ? data['dataKozumen1'] : null; 
        /* 「子図面2」 */
        // nyuryokuData['dataKozumen2'].value = copy ? data['dataKozumen2'] : '';
        /* 「子図面3」 */
        // nyuryokuData['dataKozumen3'].value = copy ? data['dataKozumen3'] : '';
        /* 「子図面4」 */
        // nyuryokuData['dataKozumen4'].value = copy ? data['dataKozumen4'] : '';
        /* 「子図面5」 */
        // nyuryokuData['dataKozumen5'].value = copy ? data['dataKozumen5'] : '';
        /* 「得意先CD」 */
        nyuryokuData['dataTokuisakiCd'].value = copy ? data['dataTokuisakiCd'] : '';
        /* 「得意先名」 */
        nyuryokuData['dataTokuisakiName'].value = copy ? data['dataTokuisakiName'] : '';
        /* 「ネジゲージ」 */
        nyuryokuData['dataNejiGeji'].value = copy ? data['dataNejiGeji'] : '';
        /* 「作業内訳1」 */
        nyuryokuData['dataSagyouUchiwake1'].value = copy ? data['dataSagyouUchiwake1'] : '';
        /* 「作業内訳2」 */
        nyuryokuData['dataSagyouUchiwake2'].value = copy ? data['dataSagyouUchiwake2'] : '';
        /* 「作業内訳3」 */
        nyuryokuData['dataSagyouUchiwake3'].value = copy ? data['dataSagyouUchiwake3'] : '';
        /* 「図面番号」 */
        nyuryokuData['dataZumenNo'].value = copy ? data['dataZumenNo'] : '';
        /* 「備考（営業）」 */
        nyuryokuData['dataBikouEigyou'].value = copy ? data['dataBikouEigyou'] : '';
        /* 「備考」 */
        nyuryokuData['dataBikou'].value = copy ? data['dataBikou'] : '';
        /* 「部品番号」 */
        nyuryokuData['dataBuban'].value = copy ? data['dataBuban'] : '';
        /* 「材料手配区分」 */
        nyuryokuData['dataZairyouTehaiKbn'].value = copy ? data['dataZairyouTehaiKbn'] : '';
        /* 「材料手配区分名」 */
        nyuryokuData['dataZairyouTehaiName'].value = copy ? data['dataZairyouTehaiName'] : '';
        /* 「計画品目原価」 */
        numKeikakuHinmokuGenkaKin.value = copy ? data['dataKeikakuHinmokuGenkaKin'] : 0;
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
        nyuryokuData['dataJigyoubuCd'].disabled = deleteFlg; /* 「事業部CD」 */
        nyuryokuData['dataHinmokuCd'].disabled = deleteFlg; /* 「品目CD」 */
        nyuryokuData['dataHinmokuName1'].disabled = deleteFlg; /* 「品目名1」 */
        nyuryokuData['dataHinmokuName2'].disabled = deleteFlg; /* 「品目名(ｶﾅ)」 */
        nyuryokuData['dataHinmokuKbn'].disabled = deleteFlg; /* 「品目区分」 */
        chkZairyouKbn.disabled = deleteFlg; SetZairyouCheck();/* 「材料区分」「拠点材料区分」「社内材料区分」 */
        dataJhuchuhinKbn.disabled = deleteFlg; /* 「受注品区分」 */
        dataShikakariKbn.disabled = deleteFlg; /* 「中間仕掛区分」 */
        dataFukushizaiKbn.disabled = deleteFlg; /* 「副資材区分」 */
        nyuryokuData['dataTanniCd'].disabled = deleteFlg; /* 「単位CD」 */
        DisabledRadio('shokuchiKbn1', 'shokuchiKbn2', deleteFlg); /* 「諸口区分」 */
        DisabledRadio('zaikokanriKbn1', 'zaikokanriKbn2', deleteFlg); /* 「在庫管理対象外区分」 */
        DisabledRadio('tankaInputKbn1', 'tankaInputKbn2', deleteFlg); /* 「単価入力区分」 */
        DisabledRadio('shouhizeiKbn1', 'shouhizeiKbn2', deleteFlg); /* 「消費税区分」 */
        DisabledRadio('keigenzeiritsuKbn1', 'keigenzeiritsuKbn2', deleteFlg); /* 「軽減税率適用区分」 */
        nyuryokuData['dataZaishitsuCd'].disabled = deleteFlg; /* 「材質名CD」 */
        nyuryokuData['dataZaishitsuName'].disabled = deleteFlg; /* 「材質名」 */
        nyuryokuData['dataMakerCd'].disabled = deleteFlg; /* 「メーカーCD」 */
        nyuryokuData['dataMakerName'].disabled = deleteFlg; /* 「メーカー名」 */
        nyuryokuData['dataColorCd'].disabled = deleteFlg; /* 「色CD」 */
        nyuryokuData['dataColorName'].disabled = deleteFlg; /* 「色名」 */
        nyuryokuData['dataGradeCd'].disabled = deleteFlg; /* 「グレードCD」 */
        nyuryokuData['dataKeijouCd'].disabled = deleteFlg; /* 「形状CD」 */
        nyuryokuData['dataKikakuName'].disabled = deleteFlg; /* 「規格」 */
        numSizeW.isDisabled = deleteFlg; /* 「サイズ　(W)幅」 */
        numSizeD.isDisabled = deleteFlg; /* 「サイズ　(D)奥行」 */
        numSizeH.isDisabled = deleteFlg; /* 「サイズ　(H)高さ」 */
        nyuryokuData['dataShiiresakiCd'].disabled = deleteFlg; /* 「通常仕入先CD」 */
        nyuryokuData['dataNyukoOkibaCd'].disabled = deleteFlg; /* 「入庫置場CD」 */
        nyuryokuData['dataNyukoTanaCd'].disabled = deleteFlg; /* 「入庫棚CD」 */
        nyuryokuData['dataKikaku'].disabled = deleteFlg; /* 「材料規格」 */
        nyuryokuData['dataGyoushuCd'].disabled = deleteFlg; /* 「業種CD」 */
        DisabledRadio('zumenKbn1', 'zumenKbn2', deleteFlg); /* 「図面区分」 */
        DisabledRadio('kensaKbn1', 'kensaKbn2', deleteFlg); /* 「検査区分」 */
        DisabledRadio('shinkiJuchuSheetKbn1', 'shinkiJuchuSheetKbn2', deleteFlg); /* 「新規受注シート区分」 */
        DisabledRadio('yojouzaikoKbn1', 'yojouzaikoKbn2', deleteFlg); /* 「余剰在庫区分」 */
        nyuryokuData['dataItemSize'].disabled = deleteFlg; /* 「製品寸法」 */
        nyuryokuData['dataCuttingSize'].disabled = deleteFlg; /* 「切断寸法」 */
        nyuryokuData['dataShuZairyouCd'].disabled = deleteFlg; /* 「使用主材料CD」 */
        nyuryokuData['dataKyakusakiHinbanCd'].disabled = deleteFlg; /* 「客先品名番」 */
        nyuryokuData['dataFolderName'].disabled = deleteFlg; /* 「フォルダー名」 */
        dataFile.disabled = deleteFlg; /* 「ファイル名」 */
        numZairyouKin.isDisabled = deleteFlg; /* 「材料費」 */
        imgKozumen1.disabled = deleteFlg; /* 「子図面1」 */
        // nyuryokuData['dataKozumen2'].disabled = deleteFlg; /* 「子図面2」 */
        // nyuryokuData['dataKozumen3'].disabled = deleteFlg; /* 「子図面3」 */
        // nyuryokuData['dataKozumen4'].disabled = deleteFlg; /* 「子図面4」 */
        // nyuryokuData['dataKozumen5'].disabled = deleteFlg; /* 「子図面5」 */
        nyuryokuData['dataTokuisakiCd'].disabled = deleteFlg; /* 「得意先CD」 */
        nyuryokuData['dataNejiGeji'].disabled = deleteFlg; /* 「ネジゲージ」 */
        nyuryokuData['dataSagyouUchiwake1'].disabled = deleteFlg; /* 「作業内訳1」 */
        nyuryokuData['dataSagyouUchiwake2'].disabled = deleteFlg; /* 「作業内訳2」 */
        nyuryokuData['dataSagyouUchiwake3'].disabled = deleteFlg; /* 「作業内訳3」 */
        nyuryokuData['dataZumenNo'].disabled = deleteFlg; /* 「図面番号」 */
        nyuryokuData['dataBikouEigyou'].disabled = deleteFlg; /* 「備考（営業）」 */
        nyuryokuData['dataBikou'].disabled = deleteFlg; /* 「備考」 */
        nyuryokuData['dataBuban'].disabled = deleteFlg; /* 「部品番号」 */
        nyuryokuData['dataZairyouTehaiKbn'].disabled = deleteFlg; /* 「材料手配区分」 */
        numKeikakuHinmokuGenkaKin.isDisabled = deleteFlg; /* 「計画品目原価」 */
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
        /* ボタン制御更新 */
        SetEnableButton(data[1].length);
        /** */
        data[1].forEach(e => {
            e['capZairyouKbn'] = SetCaption(e['dataZairyouKbn'], <?php echo json_encode(ZAIRYOU_KBN) ?>);
            e['capKyotenZairyouKbn'] = SetCaption(e['dataKyotenZairyouKbn'], <?php echo json_encode(KYOTEN_ZAIRYOU_KBN) ?>);
            e['capShanaiZairyouKbn'] = SetCaption(e['dataShanaiZairyouKbn'], <?php echo json_encode(SHANAI_ZAIRYOU_KBN) ?>);
            e['capJhuchuhinKbn'] = SetCaption(e['dataJhuchuhinKbn'], <?php echo json_encode(JHUCHUHIN_KBN) ?>);
            e['capShikakariKbn'] = SetCaption(e['dataShikakariKbn'], <?php echo json_encode(SHIKAKARI_KBN) ?>);
            e['capFukushizaiKbn'] = SetCaption(e['dataFukushizaiKbn'], <?php echo json_encode(FUKUSHIZAI_KBN) ?>);
            e['capShokuchiKbn'] = SetCaption(e['dataShokuchiKbn'], <?php echo json_encode(SHOKUCHI_KBN) ?>);
            e['capZaikokanriKbn'] = SetCaption(e['dataZaikokanriKbn'], <?php echo json_encode(ZAIKOKANRI_TAISHOUGAI_KBN) ?>);
            e['capTankaInputKbn'] = SetCaption(e['dataTankaInputKbn'], <?php echo json_encode(TANKA_INPUT_KBN) ?>);
            e['capShouhizeiKbn'] = SetCaption(e['dataShouhizeiKbn'], <?php echo json_encode(SHOUHIZEI_KBN) ?>);
            e['capKeigenzeiritsuKbn'] = SetCaption(e['dataKeigenzeiritsuKbn'], <?php echo json_encode(KEIGENZEIRITSU_KBN) ?>);
            e['capZumenKbn'] = SetCaption(e['dataZumenKbn'], <?php echo json_encode(ZUMEN_KBN) ?>);
            e['capKensaKbn'] = SetCaption(e['dataKensaKbn'], <?php echo json_encode(KENSA_KBN) ?>);
            e['capShinkiJuchuSheetKbn'] = SetCaption(e['dataShinkiJuchuSheetKbn'], <?php echo json_encode(SHINKI_JUCHU_SHEET_KBN) ?>);
            e['capYojouzaikoKbn'] = SetCaption(e['dataYojouzaikoKbn'], <?php echo json_encode(YOJOUZAIKO_KBN) ?>);
        });
        /* グリッドデータ反映＆並び順と選択位置保持 ※common_function.js参照 */
        SortGridData(gridMaster, data[1], 'dataJuchuNo', 1);
    }

    function SetCaption(data, array) {
        return array[data];
    }

    /* 検索件数更新 */
    var fncJushinDataCnt = function(data, errorFlg)
    {
        /* データエラー判定 ※common_function.js参照 */
        if(IsAjaxDataError(data, errorFlg)) return;
        /* 件数更新 */
        $("#zenkenCnt").html(data[1]);
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

    /* 材料区分表示　クリック処理 */
    $('#chkZairyouKbn').change(function() {
        SetZairyouCheck();
    });

    /* 材料分類処理 */
    function SetZairyouCheck(){
        var check = document.getElementById('chkZairyouKbn');
        var Zairyou = document.getElementById('rdoZairyouKbn');
        var Kyoten = document.getElementById('rdoKyotenZairyouKbn');
        var Shanai = document.getElementById('rdoShanaiZairyouKbn');

        Zairyou.disabled = !check.checked || check.disabled;
        Kyoten.disabled = !check.checked || check.disabled;
        Shanai.disabled = !check.checked || check.disabled;

        if (check.disabled) true
        else if (check.checked) {
            if ((Zairyou.value == 0) && (Kyoten.value == 0) && (Shanai.value == 0))
                Zairyou.checked = true;
        }
        else {
            Zairyou.checked = false;
            Kyoten.checked = false;
            Shanai.checked = false;
        }
        SetZairyouBunrui();
    }

    /* 材料分類処理 */
    function SetZairyouBunrui(){
        var Zairyou = document.getElementById('rdoZairyouKbn');
        var Kyoten = document.getElementById('rdoKyotenZairyouKbn');
        var Shanai = document.getElementById('rdoShanaiZairyouKbn');

        if (Zairyou.checked) Zairyou.value = 1
        else Zairyou.value = 0;
        if (Kyoten.checked) Kyoten.value = 1
        else Kyoten.value = 0;
        if (Shanai.checked) Shanai.value = 1
        else Shanai.value = 0;
        // console.log(Zairyou.value,Kyoten.value,Shanai.value);
    }

    /* 材料分類処理 */
    function SetZairyouRadio(n1, n2, n3){
        var check = document.getElementById('chkZairyouKbn');
        var Zairyou = document.getElementById('rdoZairyouKbn');
        var Kyoten = document.getElementById('rdoKyotenZairyouKbn');
        var Shanai = document.getElementById('rdoShanaiZairyouKbn');

        Zairyou.disabled = false;
        Kyoten.disabled = false;
        Shanai.disabled = false;

        if (n1 == 1) {
            check.checked = true;
            Zairyou.checked = true;
            Zairyou.value = 1;
        } else if (n2 == 1) {
            check.checked = true;
            Kyoten.checked = true;
            Kyoten.value = 1;
        } else if (n3 == 1) {
            check.checked = true;
            Shanai.checked = true;
            Shanai.value = 1;
        } else {
            check.checked = false;
            Zairyou.checked = false;
            Kyoten.checked = false;
            Shanai.checked = false;
            Zairyou.disabled = true;
            Kyoten.disabled = true;
            Shanai.disabled = true;
            Zairyou.value = 0;
            Kyoten.value = 0;
            Shanai.value = 0;
        }
    }

    /* Checkbox処理 */
    function SetCheckData(id) {
        var item = document.getElementById(id);
        if (item.checked) item.value = 1
        else item.value = 0;
        // console.log(item.value);
    }

    /* Checkbox参照処理 */
    function SetCheckbox(id, n) {
        var item = document.getElementById(id);
        if (n == 1) {
            item.checked = true;
            item.value = 1;
        } else {
            item.checked = false;
            item.value = 0;
        }
    }

    /* Radio処理 */
    function SetRadioData(id1, id2, m) {
        var item1 = document.getElementById(id1);
        var item2 = document.getElementById(id2);
        var data = document.getElementsByName(m);
        if (item2.checked) data.value = item2.value
        else data.value = item1.value;
        // console.log(data.value);
    }

    /* Radio参照処理 */
    function SetRadio(id1, id2, m, n) {
        var item1 = document.getElementById(id1);
        var item2 = document.getElementById(id2);
        var data = document.getElementsByName(m);
        if (n == 1) {
            item1.checked = false;
            item2.checked = true;
            data.value = item2.value;
        } else {
            item1.checked = true;
            item2.checked = false;
            data.value = item1.value;
        } 
    }

    /* Radio不能処理 */
    function DisabledRadio(id1, id2, bool) {
        var item1 = document.getElementById(id1);
        var item2 = document.getElementById(id2);
        item1.disabled = bool;
        item2.disabled = bool;
    }

    function previewFile(file) {
        // プレビュー画像を追加する要素
        const preview = document.getElementById('preview');

        // FileReaderオブジェクトを作成
        const reader = new FileReader();

        // ファイルが読み込まれたときに実行する
        reader.onload = function (e) {
            const imageUrl = e.target.result; // 画像のURLはevent.target.resultで呼び出せる
            DelPreview("img", imageUrl, CrePreview);
        }

        var DelPreview = function(id, url, collback) {
            const img = document.getElementById(id);
            if(img != null) img.remove();
            collback(id, url, SetPreviewData);
        }

        var CrePreview = async function(id, url, collback) {
            const img = document.createElement(id); // img要素を作成
            await collback(id, url, img);
            if(img.height >= <?php echo $zumenHight ?>) 
                img.style = "box-sizing:border-box; height:<?php echo $zumenHight ?>px;"
            preview.appendChild(img); // #previewの中に追加
        }

        var SetPreviewData = function(id, url, img) {
            img.id = id;
            img.src = url;
        }

        // いざファイルを読み込む
        reader.readAsDataURL(file);
    }

    $('#imgKozumen1').change(function() {
        const fileInput = document.getElementById('imgKozumen1');
        previewFile(fileInput.files[0]);
    });

    $('.rdoZairyouBunrui').change(function() {
        SetZairyouBunrui();
    });

    $('#dataJhuchuhinKbn').change(function() {
        SetCheckData('dataJhuchuhinKbn');
    });

    $('#dataShikakariKbn').change(function() {
        SetCheckData('dataShikakariKbn');
    });

    $('#dataFukushizaiKbn').change(function() {
        SetCheckData('dataFukushizaiKbn');
    });
    
    $('.rdoShokuchiKbn').change(function() {
        SetRadioData('shokuchiKbn1', 'shokuchiKbn2', 'dataShokuchiKbn');
    });

    $('.rdoZaikokanriKbn').change(function() {
        SetRadioData('zaikokanriKbn1', 'zaikokanriKbn2', 'dataZaikokanriKbn');
    });

    $('.rdoTankaInputKbn').change(function() {
        SetRadioData('tankaInputKbn1', 'tankaInputKbn2', 'dataTankaInputKbn');
    });

    $('.rdoShouhizeiKbn').change(function() {
        SetRadioData('shouhizeiKbn1', 'shouhizeiKbn2', 'dataShouhizeiKbn');
    });

    $('.rdoKeigenzeiritsuKbn').change(function() {
        SetRadioData('keigenzeiritsuKbn1', 'keigenzeiritsuKbn2', 'dataKeigenzeiritsuKbn');
    });

    $('.rdoZumenKbn').change(function() {
        SetRadioData('zumenKbn1', 'zumenKbn2', 'dataZumenKbn');
    });

    $('.rdoKensaKbn').change(function() {
        SetRadioData('kensaKbn1', 'kensaKbn2', 'dataKensaKbn');
    });

    $('.rdoShinkiJuchuSheetKbn').change(function() {
        SetRadioData('shinkiJuchuSheetKbn1', 'shinkiJuchuSheetKbn2', 'dataShinkiJuchuSheetKbn');
    });

    $('.rdoYojouzaikoKbn').change(function() {
        SetRadioData('yojouzaikoKbn1', 'yojouzaikoKbn2', 'dataYojouzaikoKbn');
    });

    /* 「リセット」ボタン　クリック処理 */
    $('#btnReset').click(function() {
        /* 処理別ボタン処理を実行 */
        if(document.forms['frmNyuryoku'].elements['dataSQLType'].value == MODE_INSERT){
            fncNyuryokuData(MODE_INSERT, false);
        }else{
            fncNyuryokuData(MODE_UPDATE, true);
        }
    });

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
            /* 「事業部CD」 */
            if((nyuryokuData['dataJigyoubuCd'].value != data['dataJigyoubuCd']) &&
              !(nyuryokuData['dataJigyoubuCd'].value == '' && data['dataJigyoubuCd'] == null)) return true;
            /* 「品目CD」 */
            if((nyuryokuData['dataHinmokuCd'].value != data['dataHinmokuCd']) &&
              !(nyuryokuData['dataHinmokuCd'].value == '' && data['dataHinmokuCd'] == null)) return true;
            /* 「品目名」 */
            if((nyuryokuData['dataHinmokuName1'].value != data['dataHinmokuName1']) &&
              !(nyuryokuData['dataHinmokuName1'].value == '' && data['dataHinmokuName1'] == null)) return true;
            /* 「品目名(ｶﾅ)」 */
            if((nyuryokuData['dataHinmokuName2'].value != data['dataHinmokuName2']) &&
              !(nyuryokuData['dataHinmokuName2'].value == '' && data['dataHinmokuName2'] == null)) return true;
            /* 「品目区分」 */
            if((nyuryokuData['dataHinmokuKbn'].value != data['dataHinmokuKbn']) &&
              !(nyuryokuData['dataHinmokuKbn'].value == '' && data['dataHinmokuKbn'] == null)) return true;
            /* 「単位CD」 */
            if((nyuryokuData['dataTanniCd'].value != data['dataTanniCd'])) return true;
            /* 「材料分類」 */
            if((nyuryokuData['dataZairyouKbn'].value != data['dataZairyouKbn'])) return true;
            /* 「拠点材料分類」 */
            if((nyuryokuData['dataKyotenZairyouKbn'].value != data['dataKyotenZairyouKbn'])) return true;
            /* 「社内材料分類」 */
            if((nyuryokuData['dataShanaiZairyouKbn'].value != data['dataShanaiZairyouKbn'])) return true;
            /* 「受注品区分」 */
            if((nyuryokuData['dataJhuchuhinKbn'].value != data['dataJhuchuhinKbn'])) return true;
            /* 「仕掛品区分」 */
            if((nyuryokuData['dataShikakariKbn'].value != data['dataShikakariKbn'])) return true;
            /* 「副資材区分」 */
            if((nyuryokuData['dataFukushizaiKbn'].value != data['dataFukushizaiKbn'])) return true;
            /* 「諸口区分」 */
            if((nyuryokuData['dataShokuchiKbn'].value != data['dataShokuchiKbn'])) return true;
            /* 「在庫管理区分」 */
            if((nyuryokuData['dataZaikokanriKbn'].value != data['dataZaikokanriKbn'])) return true;
            /* 「単価入力区分」 */
            if((nyuryokuData['dataTankaInputKbn'].value != data['dataTankaInputKbn'])) return true;
            /* 「消費税区分」 */
            if((nyuryokuData['dataShouhizeiKbn'].value != data['dataShouhizeiKbn'])) return true;
            /* 「軽減税率適用区分」 */
            if((nyuryokuData['dataKeigenzeiritsuKbn'].value != data['dataKeigenzeiritsuKbn'])) return true;              
            /* 「材質名CD」 */
            if((nyuryokuData['dataZaishitsuCd'].value != data['dataZaishitsuCd'])) return true;
            /* 「材質名」 */
            if((nyuryokuData['dataZaishitsuName'].value != data['dataZaishitsuName'])) return true;
            /* 「メーカーCD」 */
            if((nyuryokuData['dataMakerCd'].value != data['dataMakerCd'])) return true;
            /* 「メーカー名」 */
            if((nyuryokuData['dataMakerName'].value != data['dataMakerName'])) return true;
            /* 「色CD」 */
            if((nyuryokuData['dataColorCd'].value != data['dataColorCd'])) return true;
            /* 「色名」 */
            if((nyuryokuData['dataColorName'].value != data['dataColorName'])) return true;
            /* 「グレードCD」 */
            if((nyuryokuData['dataGradeCd'].value != data['dataGradeCd'])) return true;
            /* 「形状CD」 */
            if((nyuryokuData['dataKeijouCd'].value != data['dataKeijouCd'])) return true;
            /* 「形状CD」 */
            if((nyuryokuData['dataKeijouCd'].value != data['dataKeijouCd'])) return true;
            /* 「規格」 */
            if((nyuryokuData['dataKikakuName'].value != data['dataKikakuName'])) return true;
            /* 「材料規格」 */
            if((nyuryokuData['dataKikaku'].value != data['dataKikaku'])) return true;
            /* 「サイズ　(W)幅 */
            if((nyuryokuData['dataSizeW'].value != data['dataSizeW'])) return true;
            /* 「サイズ　(D)奥行」 */
            if((nyuryokuData['dataSizeD'].value != data['dataSizeD'])) return true;
            /* 「サイズ　(H)高さ」 */
            if((nyuryokuData['dataSizeH'].value != data['dataSizeH'])) return true;
            /* 「通常仕入先CD」 */
            if((nyuryokuData['dataShiiresakiCd'].value != data['dataShiiresakiCd'])) return true;
            /* 「入庫置場CD」 */
            if((nyuryokuData['dataNyukoOkibaCd'].value != data['dataNyukoOkibaCd'])) return true;
            /* 「入庫棚CD」 */
            if((nyuryokuData['dataNyukoTanaCd'].value != data['dataNyukoTanaCd'])) return true;
            /* 「業種CD」 */
            if((nyuryokuData['dataGyoushuCd'].value != data['dataGyoushuCd'])) return true;
            /* 「使用主材料CD」 */
            if((nyuryokuData['dataShuZairyouCd'].value != data['dataShuZairyouCd'])) return true;
            /* 「客先品名番」 */
            if((nyuryokuData['dataKyakusakiHinbanCd'].value != data['dataKyakusakiHinbanCd'])) return true;
            /* 「フォルダー名」 */
            if((nyuryokuData['dataFolderName'].value != data['dataFolderName'])) return true;
            /* 「ファイル名」 */
            if((nyuryokuData['dataFileName'].file != data['dataFileName'])) return true;
            /* 「材料費」 */
            if((nyuryokuData['dataZairyouKin'].value != data['dataZairyouKin'])) return true;
            /* 「図面区分」 */
            if((nyuryokuData['dataZumenKbn'].value != data['dataZumenKbn'])) return true;
            /* 「検査区分」 */
            if((nyuryokuData['dataKensaKbn'].value != data['dataKensaKbn'])) return true;
            /* 「新規受注シート区分」 */
            if((nyuryokuData['dataShinkiJuchuSheetKbn'].value != data['dataShinkiJuchuSheetKbn'])) return true;
            /* 「余剰在庫区分」 */
            if((nyuryokuData['dataYojouzaikoKbn'].value != data['dataYojouzaikoKbn'])) return true;
            /* 「製品寸法」 */
            if((nyuryokuData['dataItemSize'].value != data['dataItemSize'])) return true;
            /* 「切断寸法」 */
            if((nyuryokuData['dataCuttingSize'].value != data['dataCuttingSize'])) return true;
            /* 「得意先CD」 */
            if((nyuryokuData['dataTokuisakiCd'].value != data['dataTokuisakiCd'])) return true;
            /* 「ネジゲージ」 */
            if((nyuryokuData['dataNejiGeji'].value != data['dataNejiGeji'])) return true;
            /* 「作業内訳1」 */
            if((nyuryokuData['dataSagyouUchiwake1'].value != data['dataSagyouUchiwake1'])) return true;
            /* 「作業内訳2」 */
            if((nyuryokuData['dataSagyouUchiwake2'].value != data['dataSagyouUchiwake2'])) return true;
            /* 「作業内訳3」 */
            if((nyuryokuData['dataSagyouUchiwake3'].value != data['dataSagyouUchiwake3'])) return true;
            /* 「図面番号」 */
            if((nyuryokuData['dataZumenNo'].value != data['dataZumenNo'])) return true;
            /* 「備考（営業）」 */
            if((nyuryokuData['bikou_eigyou'].value != data['bikou_eigyou'])) return true;
            /* 「備考」 */
            if((nyuryokuData['dataBikou'].value != data['dataBikou'])) return true;
            /* 「部品番号」 */
            if((nyuryokuData['dataBuban'].value != data['dataBuban'])) return true;
            /* 「材料手配区分」 */
            if((nyuryokuData['dataZairyouTehaiKbn'].value != data['dataZairyouTehaiKbn'])) return true;
            /* 「計画品目原価」 */
            if((nyuryokuData['dataKeikakuHinmokuGenkaKin'].value != data['dataKeikakuHinmokuGenkaKin'])) return true;
            /* 「子図面」 */
            if((nyuryokuData['dataKozumen1'].file != data['dataKozumen1'])) return true;
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
        /* 「サイズ　(W)幅 */
        nyuryokuData['dataSizeW'].value = numSizeW.value;
        /* 「サイズ　(D)奥行」 */
        nyuryokuData['dataSizeD'].value = numSizeD.value;
        /* 「サイズ　(H)高さ」 */
        nyuryokuData['dataSizeH'].value = numSizeH.value;
        /* 「材料費」 */
        nyuryokuData['dataZairyouKin'].value = numZairyouKin.value;
        /* 「計画品目原価」 */
        nyuryokuData['dataKeikakuHinmokuGenkaKin'].value = numKeikakuHinmokuGenkaKin.value;
        /* 「材料区分」 */
        nyuryokuData['dataZairyouKbn'].value = rdoZairyouKbn.value;
        /* 「拠点材料区分」 */
        nyuryokuData['dataKyotenZairyouKbn'].value = rdoKyotenZairyouKbn.value;
        /* 「社内材料区分」 */
        nyuryokuData['dataShanaiZairyouKbn'].value = rdoShanaiZairyouKbn.value;
        /* 「受注品区分」 */
        nyuryokuData['dataJhuchuhinKbn'].value = chkJhuchuhinKbn.value;
        /* 「中間仕掛区分」 */
        nyuryokuData['dataShikakariKbn'].value = chkShikakariKbn.value;
        /* 「副資材区分」 */
        nyuryokuData['dataFukushizaiKbn'].value = chkFukushizaiKbn.value;
        /* 「諸口区分」 */
        nyuryokuData['dataShokuchiKbn'].value = rdoShokuchiKbn.value;
        /* 「在庫管理対象外区分」 */
        nyuryokuData['dataZaikokanriKbn'].value = rdoZaikokanriKbn.value;
        /* 「単価入力区分」 */
        nyuryokuData['dataTankaInputKbn'].value = rdoTankaInputKbn.value;
        /* 「消費税区分」 */
        nyuryokuData['dataShouhizeiKbn'].value = rdoShouhizeiKbn.value;
        /* 「軽減税率適用区分」 */
        nyuryokuData['dataKeigenzeiritsuKbn'].value = rdoKeigenzeiritsuKbn.value;
        /* 「図面区分」 */
        nyuryokuData['dataZumenKbn'].value = rdoZumenKbn.value;
        /* 「検査区分」 */
        nyuryokuData['dataKensaKbn'].value = rdoKensaKbn.value;
        /* 「新規受注シート区分」 */
        nyuryokuData['dataShinkiJuchuSheetKbn'].value = rdoShinkiJuchuSheetKbn.value;
        /* 「余剰在庫区分」 */
        nyuryokuData['dataYojouzaikoKbn'].value = rdoYojouzaikoKbn.value;
        /* 「ファイル名」 */
        if(dataFile.files[0] != null)
            nyuryokuData['dataFileName'].value = dataFile.files[0].name;
        /* 「子図面1」 */
        if(imgKozumen1.files[0] != null)
            nyuryokuData['dataKozumen1'].value = imgKozumen1.files[0].name;

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
                AjaxData("{{ url('/master/2601') }}", soushinData, fncUpdateData);
            }, null);
        }
        else
        {
            /* 「データ更新中」表示 */
            ShowPopupDlg("{{__('データ更新中')}}");
            /* 非同期データ更新開始 */
            AjaxData("{{ url('/master/2601') }}", soushinData, fncUpdateData);
        }
    });

    /* テキスト変更時に連動するテキスト要素のリセット処理 */
    $('input[type="text"]').change(function() {
        /* 連動テキスト要素のある要素を判別 */
        switch($(this)[0].name)
        {
            /* 「事業部CD」 */
            case 'dataJigyoubuCd':
            break;
            /* 「品目区分」 */
            case 'dataHinmokuKbn':
            break;
            /* 「単位CD」 */
            case 'dataTanniCd':
            break;
            /* 「材質名CD」 */
            case 'dataZaishitsuCd':
            break;
            /* 「メーカーCD」 */
            case 'dataMakerCd':
            break;
            /* 「色CD」 */
            case 'dataColorCd':
            break;
            /* 「グレードCD」 */
            case 'dataGradeCd':
            break;
            /* 「形状CD」 */
            case 'dataKeijouCd':
            break;
            /* 「通常仕入先CD」 */
            case 'dataShiiresakiCd':
            break;
            /* 「入庫置場CD」 */
            case 'dataNyukoOkibaCd':
            break;
            /* 「入庫棚CD」 */
            case 'dataNyukoTanaCd':
            break;
            /* 「業種CD」 */
            case 'dataGyoushuCd':
            break;
            /* 「使用主材料CD」 */
            case 'dataShuZairyouCd':
            break;
            /* 「得意先CD」 */
            case 'dataTokuisakiCd':
            break;
            /* 「材料手配区分」 */
            case 'dataZairyouTehaiKbn':
            break;
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
        /* 対象日 */
        let targetDate = null;
        /* 選択対象の名前を判別 */
        switch(currentCdElement.name)
        {
            /* 事業部CD */
            case 'dataJigyoubuCd':
            ShowSentakuDlg("{{ __('jigyoubu_cd') }}", "{{ __('jigyoubu_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/0100') }}", targetDate);
            break;
            /* 得意先CD */
            case 'dataTokuisakiCd':
            ShowSentakuDlg("{{ __('tokuisaki_cd') }}", "{{ __('tokuisaki_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1400') }}", targetDate);
            break;
            /* メーカーCD */
            case 'dataMakerCd':
            ShowSentakuDlg("{{ __('maker_cd') }}", "{{ __('maker_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/2000') }}", targetDate);
            break;
            /* 通常仕入先CD */
            case 'dataShiiresakiCd':
            ShowSentakuDlg("{{ __('shiiresaki_cd') }}", "{{ __('shiiresaki_ryaku') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1800') }}", targetDate);
            break;
            /* 入庫置場CD */
            case 'dataNyukoOkibaCd':
            ShowSentakuDlg("{{ __('location_cd') }}", "{{ __('location_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/2100') }}", targetDate, '1'); 
            break;
            /* 入庫棚CD */
            case 'dataNyukoTanaCd':
            ShowSentakuDlg("{{ __('location_cd') }}", "{{ __('location_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/2100') }}", targetDate, '2'); 
            break;
            /* 使用主材料CD */
            case 'dataShuZairyouCd':
            ShowSentakuDlg("{{ __('hinmoku_cd') }}", "{{ __('hinmoku_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/2601') }}", targetDate, HinmokuCd.value);
            break;
            /* 材質CD */
            case 'dataZaishitsuCd':
            ShowSentakuDlg("{{ __('zaishitsu_cd') }}", "{{ __('zaishitsu_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}", targetDate, "ZAISHITSU");
            break;
            /* 品目区分 */
            case 'dataHinmokuKbn':
            ShowSentakuDlg("{{ __('hinmoku_kbn') }}", "{{ __('hinmoku_kbn_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}", targetDate, "HINMOKUKBN");
            break;
            /* 色CD */
            case 'dataColorCd':
            ShowSentakuDlg("{{ __('color_cd') }}", "{{ __('color_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}", targetDate, "COLOR");
            break;
            /* 単位CD */
            case 'dataTanniCd':
            ShowSentakuDlg("{{ __('tanni_cd') }}", "{{ __('tanni_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}", targetDate, "TANI");
            break;
            /* グレードCD */
            case 'dataGradeCd':
            ShowSentakuDlg("{{ __('grade_cd') }}", "{{ __('grade_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}", targetDate, "GRADE");
            break;
            /* 形状CD */
            case 'dataKeijouCd':
            ShowSentakuDlg("{{ __('keijou_cd') }}", "{{ __('keijou_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}", targetDate, "SHAPE");
            break;
            /* 業種CD */
            case 'dataGyoushuCd':
            ShowSentakuDlg("{{ __('gyoushu_cd') }}", "{{ __('gyoushu_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}", targetDate, "GYOUSHU");
            break;
            /* 材料手配区分 */
            case 'dataZairyouTehaiKbn':
            ShowSentakuDlg("{{ __('zairyou_tehai_kbn') }}", "{{ __('zairyou_tehai_name') }}",
                           currentCdElement, currentNameElement, "{{ url('/inquiry/1300') }}", targetDate, "ZAITEHAI");
            break;
        }
    });
</script>
@endsection