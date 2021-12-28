<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCMST_1801 extends Controller
{
    public function index(Request $request)
    {
        // 処理成功フラグ
        $resultFlg = true;
        //
        $resultMsg = '';
        //
        $resultVal = [];
        //
        $tableName = 'shiiresaki_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'shiiresaki_cd');
        try {
            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            //
            // 入力値のエラーチェック
            //
            // トランザクション種別
            $SQLType = empty($request->dataSQLType) ? 0 : (int)$request->dataSQLType;
            if ($SQLType < 1) {
                $resultMsg .= '「' . __('データ') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // 事業部CD
            $jigyoubuCd = $request -> dataJigyoubuCd;
            if(is_null($jigyoubuCd) || $jigyoubuCd === ''){
                $resultMsg .= '「'.__('shiiresaki_cd').'」'.__('が正常に送信されていません。').'\n';
                $resultFlg = false;
            }

            // 仕入・外注先CD
            $shiiresakiCd = $request -> dataShiiresakiCd;
            if(is_null($shiiresakiCd) || $shiiresakiCd === ''){
                $resultMsg .= '「'.__('shiiresaki_cd').'」'.__('が正常に送信されていません。').'\n';
                $resultFlg = false;
            }

            // 支払先CD
            $shiharaisakiCd = $request -> dataShiharaisakiCd;
            if(is_null($shiharaisakiCd) || $shiharaisakiCd === ''){
                $resultMsg .= '「'.__('shiiresaki_cd').'」'.__('が正常に送信されていません。').'\n';
                $resultFlg = false;
            }

            // 有効期間（自）
            $yukoukikanStartDate = $request->dataStartDate;
            // POSTデータチェックエラー
            if (empty($yukoukikanStartDate)) {
                $resultMsg .= '「' . __('yukoukikan_start_date') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // 登録者ID
            $loginId = empty($request->dataLoginId) ? 0 : (int)$request->dataLoginId;

            ///////////////////////////
            // Insert 及び Delete処理 //
            ///////////////////////////
            // トランザクション別処理
            switch ($SQLType) {

                    ////////////////
                    // DELETE処理 //
                    ////////////////
                case SQL_DELETE:
                    // レコードID
                    $dataId = $request->dataId;
                    if (empty($dataId)) {
                        $resultMsg .= '「' . __('ID') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // データ処理開始
                    $master->DeleteMasterData($shiiresakiCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // 事業部CDは新規登録の際、既に存在する事業部CDの場合はエラー
                    $result = $common -> GetCdCount($tableName, 'jigyoubu_cd', $jigyoubuCd, $query);
                    if($result > 0 && $SQLType === SQL_INSERT){
                        $resultMsg .= __('既に登録されている').'「'.__('jigyoubu_cd').'」'.__('です。').'<br>';
                        $resultVal[] = 'dataJigyoubuCd';
                        $resultFlg = false;
                    }
                    //事業部名
                    $dataJigyoubuName = $request -> dataJigyoubuName;

                    // 仕入・外注先CDは新規登録の際、既に存在する仕入・外注先CDの場合はエラー
                    $result = $common -> GetCdCount($tableName, 'shiiresaki_cd', $shiiresakiCd);
                    if($result > 0 && $SQLType === SQL_INSERT){
                        $resultMsg .= __('既に登録されている').'「'.__('shiiresaki_cd').'」'.__('です。').'<br>';
                        $resultVal[] = 'dataShiiresakiCd';
                        $resultFlg = false;
                    }

                    // 支払先CDは新規登録の際、既に存在する支払先CDの場合はエラー
                    $result = $common -> GetCdCount($tableName, 'shiharaisaki_cd', $shiharaisakiCd);
                    if($result > 0 && $SQLType === SQL_INSERT){
                        $resultMsg .= __('既に登録されている').'「'.__('shiharaisaki_cd').'」'.__('です。').'<br>';
                        $resultVal[] = 'dataShiharaisakiCd';
                        $resultFlg = false;
                    }
                    // 支払先名
                    $shiharaisakiCd = $request -> dataShiharaisakiName;
                    // 略称
                    $shiiresakiRyaku = $request -> dataShiiresakiRyaku;
                    // 仕入・外注先名1
                    $shiiresakiName1 = $request -> dataShiiresakiName1;
                    // 仕入・外注先名2
                    $shiiresakiName2 = $request -> dataShiiresakiName2;
                    // 仕入・外注先名カナ
                    $shiiresakiKana = $request -> dataShiiresakiKana;
                    // ZIP
                    $shiiresakiZip = $request -> dataShiiresakiZip;
                    // 住所1
                    $shiiresakiJusho1 = $request -> dataShiiresakiJusho1;
                    // 住所2
                    $shiiresakiJusho2 = $request -> dataShiiresakiJusho2;
                    // 電話番号
                    $telNo = $request -> dataTelNo;
                    // FAX番号
                    $faxNo = $request -> dataFaxNo;
                    // 先方連絡先
                    $senpoRenrakusaki = $request -> dataSenpoRenrakusaki;
                    // 資本金
                    $shihonkin = $request -> dataShihonkin;
                    // 備考1
                    $bikou1 = $request -> dataBikou1;
                    // 備考2
                    $bikou2 = $request -> dataBikou2;
                    // 備考3
                    $bikou3 = $request -> dataBikou3;
                    // 銀行名
                    $ginkouName = $request -> dataGinkouName;
                    // 支店名
                    $shitenName = $request -> dataShitenName;
                    // 支払口座番号
                    $shiharaikouzaNo = $request -> dataShiharaikouzaNo;
                    // 取引停止理由
                    $torihikiTeishiRiyuu = $request -> dataTorihikiTeishiRiyuu;
                    // 支払親コード
                    $shiiresakiOyaCode = $request -> dataShiiresakiOyaCode;
                    // 支払先名
                    $shiiresakiOyaCode = $request -> dataShiharaisakiName;
                    // 業種分類CD
                    $gyoushuCd = $request -> dataGyoushuCd;
                    // 業種分類名
                    $gyoushuCd = $request -> dataGyoushuName;
                    // 確認日
                    $kakuninDate = $request -> dataKakuninDate;
                    // 取引停止日
                    $torihikiTeishiDate = $request -> dataTorihikiTeishiDate;
                    
                    // コンポボックス
                    // 敬称区分
                    $keishoKbn = empty($request -> dataKeishoKbn) ? 1 : $request -> dataKeishoKbn;
                    // 仕入区分
                    $shiireKbn = empty($request -> dataShiireKbn) ? 1 : $request -> dataShiireKbn;
                    // 外注区分
                    $gaichuKbn = empty($request -> dataGaichuKbn) ? 1 : $request -> dataGaichuKbn;
                    // 支払区分
                    $shiharaiKbn = empty($request -> dataShiharaiKbn) ? 1 : $request -> dataShiharaiKbn;
                    // 諸口区分
                    $shokuchiKbn = empty($request -> dataShokuchiKbn) ? 1 : $request -> dataShokuchiKbn;
                    // 品目別仕入区分
                    $hinmokuShiireKbn = empty($request -> dataHinmokuShiireKbn) ? 1 : $request -> dataHinmokuShiireKbn;
                    // 消費税計算単位
                    $shohizeiKeisanTani = empty($request -> dataShohizeiKeisanTani) ? 1 : $request -> dataShohizeiKeisanTani;
                    // 消費税計算方式
                    $shohizeiKeisanHoushiki = empty($request -> dataShohizeiKeisanHoushiki) ? 1 : $request -> dataShohizeiKeisanHoushiki;
                    // 消費税計算丸目
                    $shohizeiKeisanMarume = empty($request -> dataShohizeiKeisanMarume) ? 1 : $request -> dataShohizeiKeisanMarume;
                    // 金額計算丸目
                    $kingakuKeisanMarume = empty($request -> dataKingakuKeisanMarume) ? 1 : $request -> dataKingakuKeisanMarume;
                    // 締日1
                    $shimeDay1 = empty($request -> dataShimeDay1) ? 1 : $request -> dataShimeDay1;
                    // 締日2
                    $shimeDay2 = empty($request -> dataShimeDay2) ? 1 : $request -> dataShimeDay2;
                    // 適用月（締日２）
                    $tekiyouTsuki = empty($request -> dataTekiyouTsuki) ? 1 : $request -> dataTekiyouTsuki;
                    // 支払予定月1
                    $shiharaiTsuki1 = empty($request -> dataShiharaiTsuki1) ? 1 : $request -> dataShiharaiTsuki1;
                    // 支払日1
                    $shiharaiDay1 = empty($request -> dataShiharaiDay1) ? 1 : $request -> dataShiharaiDay1;
                    // 支払方法1
                    $shiharaihouhou1 = empty($request -> dataShiharaihouhou1) ? 1 : $request -> dataShiharaihouhou1;
                    // 手形サイト1
                    $tegataSate1 = empty($request -> dataTegataSate1) ? 1 : $request -> dataTegataSate1;
                    // 支払・回収額上限
                    $shiharaiKaishuJougenKin = empty($request -> dataShiharaiKaishuJougenKin) ? 1 : $request -> dataShiharaiKaishuJougenKin;
                    // 支払予定月2
                    $shiharaiTsuki2 = empty($request -> dataShiharaiTsuki2) ? 1 : $request -> dataShiharaiTsuki2;
                    // 支払日2
                    $shiharaiDay2 = empty($request -> dataShiharaiDay2) ? 1 : $request -> dataShiharaiDay2;
                    // 支払方法2
                    $shiharaihouhou2 = empty($request -> dataShiharaihouhou2) ? 1 : $request -> dataShiharaihouhou2;
                    // 手形サイト2
                    $tegataSate2 = empty($request -> dataTegataSate2) ? 1 : $request -> dataTegataSate2;
                    // 振込手数料区分
                    $furikomiTesuryouKbn = empty($request -> dataFurikomiTesuryouKbn) ? 1 : $request -> dataFurikomiTesuryouKbn;
                    // 支払口座区分
                    $shiharaikouzaKbn = empty($request -> dataShiharaikouzaKbn) ? 1 : $request -> dataShiharaikouzaKbn;



                    if (!$resultFlg) throw new Exception($resultMsg);

                    // 有効期間終了の設定
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    // バインドの設定
                    $SQLBind = array();
                    $SQLBind[] = array('jigyoubu_cd',       $jigyoubuCd, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_cd',       $shiiresakiCd, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_ryaku',       $shiiresakiRyaku, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_name1',       $shiiresakiName1, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_name2',       $shiiresakiName2, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_kana',       $shiiresakiKana, TYPE_STR);
                    $SQLBind[] = array('keisho_kbn',       $keishoKbn, TYPE_INT);
                    $SQLBind[] = array('shiire_kbn',       $shiireKbn, TYPE_INT);
                    $SQLBind[] = array('gaichu_kbn',       $gaichuKbn, TYPE_INT);
                    $SQLBind[] = array('shiharai_kbn',       $shiharaiKbn, TYPE_INT);
                    $SQLBind[] = array('shokuchi_kbn',       $shokuchiKbn, TYPE_INT);
                    $SQLBind[] = array('shiharaisaki_cd',       $shiharaisakiCd, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_oya_code',       $shiiresakiOyaCode, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_zip',       $shiiresakiZip, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_jusho1',       $shiiresakiJusho1, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_jusho2',       $shiiresakiJusho2, TYPE_STR);
                    $SQLBind[] = array('Tel_no',       $telNo, TYPE_STR);
                    $SQLBind[] = array('Fax_no',       $faxNo, TYPE_STR);
                    $SQLBind[] = array('senpo_renrakusaki',       $senpoRenrakusaki, TYPE_STR);
                    $SQLBind[] = array('gyoushu_cd',       $gyoushuCd, TYPE_STR);
                    $SQLBind[] = array('shihonkin',       $shihonkin, TYPE_STR);
                    $SQLBind[] = array('kakunin_date',       $kakuninDate, TYPE_STR);
                    $SQLBind[] = array('bikou1',       $bikou1, TYPE_STR);
                    $SQLBind[] = array('bikou2',       $bikou2, TYPE_STR);
                    $SQLBind[] = array('bikou3',       $bikou3, TYPE_STR);
                    $SQLBind[] = array('hinmoku_shiire_kbn',       $hinmokuShiireKbn, TYPE_INT);
                    $SQLBind[] = array('shohizei_keisan_tani',       $shohizeiKeisanTani, TYPE_INT);
                    $SQLBind[] = array('shohizei_keisan_houshiki',       $shohizeiKeisanHoushiki, TYPE_INT);
                    $SQLBind[] = array('shohizei_keisan_marume',       $shohizeiKeisanMarume, TYPE_INT);
                    $SQLBind[] = array('kingaku_keisan_marume',       $kingakuKeisanMarume, TYPE_INT);
                    $SQLBind[] = array('shime_day1',       $shimeDay1, TYPE_INT);
                    $SQLBind[] = array('shime_day2',       $shimeDay2, TYPE_INT);
                    $SQLBind[] = array('tekiyou_tsuki',       $tekiyouTsuki, TYPE_INT);
                    $SQLBind[] = array('shiharai_tsuki1',       $shiharaiTsuki1, TYPE_INT);
                    $SQLBind[] = array('shiharai_day1',       $shiharaiDay1, TYPE_INT);
                    $SQLBind[] = array('shiharaihouhou1',       $shiharaihouhou1, TYPE_INT);
                    $SQLBind[] = array('tegata_sate1',       $tegataSate1, TYPE_INT);
                    $SQLBind[] = array('shiharai_kaishu_jougen_kin',       $shiharaiKaishuJougenKin, TYPE_INT);
                    $SQLBind[] = array('shiharai_tsuki2',       $shiharaiTsuki2, TYPE_INT);
                    $SQLBind[] = array('shiharai_day2',       $shiharaiDay2, TYPE_INT);
                    $SQLBind[] = array('shiharaihouhou2',       $shiharaihouhou2, TYPE_INT);
                    $SQLBind[] = array('tegata_sate2',       $tegataSate2, TYPE_INT);
                    $SQLBind[] = array('furikomi_tesuryou_kbn',       $furikomiTesuryouKbn, TYPE_INT);
                    $SQLBind[] = array('ginkou_name',       $ginkouName, TYPE_STR);
                    $SQLBind[] = array('shiten_name',       $shitenName, TYPE_STR);
                    $SQLBind[] = array('shiharaikouza_kbn',       $shiharaikouzaKbn, TYPE_INT);
                    $SQLBind[] = array('shiharaikouza_no',       $shiharaikouzaNo, TYPE_STR);
                    $SQLBind[] = array('torihiki_teishi_date',       $torihikiTeishiDate, TYPE_STR);
                    $SQLBind[] = array('torihiki_teishi_riyuu',       $torihikiTeishiRiyuu, TYPE_STR);
                    // データ処理開始
                    $master -> InsertMasterData($SQLBind, $shiiresakiCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
                    $resultVal[] = $common -> GetMaxId($tableName);
                    break;
                    // INSERT処理終了 //
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $resultMsg = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        }
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($resultMsg, 'UTF-8', 'UTF-8');
        $resultData[] = mb_convert_encoding($resultVal, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}
