<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCMST_1401 extends Controller
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
        $tableName = 'tokuisaki_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common(); 
        // データベース接続宣言
        $query = new class_Database(); 
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'tokuisaki_cd');
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

            // 得意先CD
            $tokuisakiCd = $request -> dataTokuisakiCd;
            // POSTデータチェックエラー
            if(is_null($tokuisakiCd) || $tokuisakiCd === ''){
                $resultMsg .= '「'.__('tokuisaki_cd').'」'.__('が正常に送信されていません。').'\n';
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
                    $master -> DeleteMasterData($tokuisakiCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // 担当者CDは新規登録の際、既に存在する担当者コードの場合はエラー
                    $result = $common -> GetCdCount($tableName, 'tokuisaki_cd', $tokuisakiCd);
                    if($result > 0 && $SQLType === SQL_INSERT){ 
                        $resultMsg .= __('既に登録されている').'「'.__('tokuisaki_cd').'」'.__('です。').'<br>';
                        $resultVal[] = 'dataTokuisakiCd';
                        $resultFlg = false;
                    }

                    $jigyoubuName = $request -> dataJigyoubuName;

                    $tokuisakiRyaku = $request -> dataTokuisakiRyaku;
    
                    $tokuisakiRyaku2 = $request -> dataTokuisakiRyaku2;
    
                    $tokuisakiHyoujiName = $request -> dataTokuisakiHyoujiName;
    
                    $tokuisakiName1 = $request -> dataTokuisakiName1;
    
                    $tokuisakiName2 = $request -> dataTokuisakiName2;
    
                    $tokuisakiKana = $request -> dataTokuisakiKana;
    
                    $eigyoTantoushaCd = $request -> dataEigyoTantoushaCd;
    
                    $eigyoTantoushaName = $request -> dataEigyoTantoushaName;
    
                    $assistantCd = $request -> dataAssistantCd;
    
                    $assistantName = $request -> dataAssistantName;
    
                    $nyukinOyaCode = $request -> dataNyukinOyaCode;
    
                    $nyukinOyaName = $request -> dataNyukinOyaName;
    
                    $seikyusakiCd = $request -> dataSeikyusakiCd ;
    
                    $seikyusakiName = $request -> dataSeikyusakiName;
    
                    $ginkouCd = $request -> dataGinkouCd;
    
                    $ginkouName = $request -> dataGinkouName;
    
                    $shitenCd = $request -> dataShitenCd;
    
                    $shitenName = $request -> dataShitenName;
    
                    $yubinbangou = $request -> dataYubinbangou;
    
                    $jusho1 = $request -> dataJusho1;
    
                    $jusho2 = $request -> dataJusho2;
    
                    $telNo = $request -> dataTelNo;
    
                    $faxNo = $request -> dataFaxNo;
    
                    $senpouRenrakusaki = $request -> dataSenpouRenrakusaki;
                    
                    $kaishukouzaNo = $request -> dataKaishukouzaNo;
    
                    $yoshingendogaku = $request -> dataYoshingendogaku;
    
                    $bikou1 = $request -> dataBikou1;
    
                    $bikou2 = $request -> dataBikou2;
    
                    $bikou3 = $request -> dataBikou3;
    
                    $koumZumenHokanbasho = $request -> dataKoumZumenHokanbasho;
                    
                    $eigyoZumenHokanbasho = $request -> dataEigyoZumenHokanbasho;
    
                
                    // コンポボックス
                    $keishoKbn = empty($request -> dataKeishoKbn) ? 1 : $request -> dataKeishoKbn;
    
                    $shokuchiKbn = empty($request -> dataShokuchiKbn) ? 1 : $request -> dataShokuchiKbn;
    
                    $nouhinshoMidashiKbn = empty($request -> dataNouhinshoMidashiKbn) ? 1 : $request -> dataNouhinshoMidashiKbn;
    
                    $nouhinshoHakkouKbn = empty($request -> dataNouhinshoHakkouKbn) ? 1 : $request -> dataNouhinshoHakkouKbn;
    
                    $senyouDenpyouHakkoKbn = empty($request -> dataSenyouDenpyouHakkoKbn) ? 1 : $request -> dataSenyouDenpyouHakkoKbn;
    
                    $seikyushoHakkoKbn = empty($request -> dataSeikyushoHakkoKbn) ? 1 : $request -> dataSeikyushoHakkoKbn;
    
                    $tokuisakiTorihikiKbn = empty($request -> dataTokuisakiTorihikiKbn) ? 1 : $request -> dataTokuisakiTorihikiKbn;
    
                    $seikyusakiTorihikiKbn = empty($request -> dataSeikyusakiTorihikiKbn) ? 1 : $request -> dataSeikyusakiTorihikiKbn;
                    
                    $furikomiTesuryouKbn = empty($request -> dataFurikomiTesuryouKbn) ? 1 : $request -> dataFurikomiTesuryouKbn;
    
                    $shohizeiKeisanTani = empty($request -> dataShohizeiKeisanTani) ? 1 : $request -> dataShohizeiKeisanTani;
    
                    $shohizeiKeisanHoushiki = empty($request -> dataShohizeiKeisanHoushiki) ? 1 : $request -> dataShohizeiKeisanHoushiki;
    
                    $shohizeiKeisanMarume = empty($request -> dataShohizeiKeisanMarume) ? 1 : $request -> dataShohizeiKeisanMarume;
    
                    $kingakuKeisanMarume = empty($request -> dataKingakuKeisanMarume) ? 1 : $request -> dataKingakuKeisanMarume;
    
                    $shimeDay1 = empty($request -> dataShimeDay1) ? 1 : $request -> dataShimeDay1;
    
                    $shimeDay2 = empty($request -> dataShimeDay2) ? 1 : $request -> dataShimeDay2;
    
                    $tekiyouTsuki = empty($request -> dataTekiyouTsuki) ? 1 : $request -> dataTekiyouTsuki;
    
                    $nyukinTsuki1 = empty($request -> dataNyukinTsuki1) ? 1 : $request -> dataNyukinTsuki1;
    
                    $nyukinDay1 = empty($request -> dataNyukinDay1) ? 1 : $request -> dataNyukinDay1;
    
                    $kaishuhouhou1 = empty($request -> dataKaishuhouhou1) ? 1 : $request -> dataKaishuhouhou1;
    
                    $tegataSate1 = empty($request -> dataTegataSate1) ? 1 : $request -> dataTegataSate1;
    
                    $shiharaiKaishuJoukenKin = empty($request -> dataShiharaiKaishuJoukenKin) ? 1 : $request -> dataShiharaiKaishuJoukenKin;
    
                    $kaishuhouhou2 = empty($request -> dataKaishuhouhou2) ? 1 : $request -> dataKaishuhouhou2;
    
                    $nyukinTsuki2 = empty($request -> dataNyukinTsuki2) ? 1 : $request -> dataNyukinTsuki2;
    
                    $nyukinDay2 = empty($request -> dataNyukinDay2) ? 1 : $request -> dataNyukinDay2;
                    
                    $tegataSate2 = empty($request -> dataTegataSate2) ? 1 : $request -> dataTegataSate2;
    
                    $kaishukouzaKbn = empty($request -> dataKaishukouzaKbn) ? 1 : $request -> dataKaishukouzaKbn;
    
                     // 事業部CD
                    $jigyoubuCd = $request -> dataJigyoubuCd;
                    // POSTデータチェックエラー
                    if(is_null($jigyoubuCd) || $jigyoubuCd === '')
                    {
                        $resultMsg .= '「'.__('jigyoubu_cd').'」'.__('が正常に送信されていません。').'<br>';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    $result = $common -> GetCdCount('jigyoubu_master', 'jigyoubu_cd', $jigyoubuCd, $query);
                    if($result < 1)
                    {
                        $resultMsg .= __('登録されていない').'「'.__('jigyoubu_cd').'」'.__('です。').'<br>';
                        $resultVal[] = 'dataJigyoubuCd';
                        $resultFlg = false;
                    }

                    if (!$resultFlg) throw new Exception($resultMsg);

                    // 有効期間終了の設定
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    $SQLBind = array();
                    $SQLBind[] = array(':jigyoubu_cd',       $jigyoubuCd,       TYPE_STR);
                    $SQLBind[] = array(':jigyoubu_name',       $jigyoubuName,       TYPE_STR);
                    $SQLBind[] = array(':tokuisaki_cd',       $tokuisakiCd,       TYPE_STR);
                    $SQLBind[] = array(':tokuisaki_ryaku',      $tokuisakiRyaku,       TYPE_STR);
                    $SQLBind[] = array(':tokuisaki_ryaku2',       $tokuisakiRyaku2,       TYPE_STR);
                    $SQLBind[] = array(':tokuisaki_hyouji_name',     $tokuisakiHyoujiName,       TYPE_STR);
                    $SQLBind[] = array(':tokuisaki_name1',       $tokuisakiName1,       TYPE_STR);
                    $SQLBind[] = array(':tokuisaki_name2',       $tokuisakiName2,       TYPE_STR);
                    $SQLBind[] = array(':tokuisaki_kana',       $tokuisakiKana,       TYPE_STR);
                    $SQLBind[] = array(':eigyo_tantousha_cd',       $eigyoTantoushaCd,       TYPE_STR);
                    $SQLBind[] = array(':assistant_cd',         $assistantCd,     TYPE_STR);
                    $SQLBind[] = array(':seikyusaki_cd',       $seikyusakiCd,       TYPE_STR);
                    $SQLBind[] = array(':nyukin_oya_code',       $nyukinOyaCode,       TYPE_STR);
                    $SQLBind[] = array(':ginkou_cd',       $ginkouCd,       TYPE_STR);
                    $SQLBind[] = array(':shiten_cd',       $shitenCd,       TYPE_STR);
                    $SQLBind[] = array(':keisho_kbn',  $keishoKbn,     TYPE_INT);
                    $SQLBind[] = array(':shokuchi_kbn',  $shokuchiKbn,     TYPE_INT);
                    $SQLBind[] = array(':nouhinsho_midashi_kbn',  $nouhinshoMidashiKbn,     TYPE_INT);
                    $SQLBind[] = array(':nouhinsho_hakkou_kbn',  $nouhinshoHakkouKbn,     TYPE_INT);
                    $SQLBind[] = array(':senyou_denpyou_hakko_kbn',  $senyouDenpyouHakkoKbn,     TYPE_INT);
                    $SQLBind[] = array(':seikyusho_hakkou_kbn',  $seikyushoHakkoKbn,     TYPE_INT);
                    $SQLBind[] = array(':tokuisaki_torihiki_kbn',  $tokuisakiTorihikiKbn,     TYPE_INT);
                    $SQLBind[] = array(':seikyusaki_torihiki_kbn',  $seikyusakiTorihikiKbn,     TYPE_INT);
                    $SQLBind[] = array(':shohizei_keisan_tani',  $shohizeiKeisanTani,     TYPE_INT);
                    $SQLBind[] = array(':shohizei_keisan_houshiki',  $shohizeiKeisanHoushiki,     TYPE_INT);
                    $SQLBind[] = array(':shohizei_keisan_marume',  $shohizeiKeisanMarume,     TYPE_INT);
                    $SQLBind[] = array(':kingaku_keisan_marune',  $kingakuKeisanMarume,     TYPE_INT);
                    $SQLBind[] = array(':yubinbangou',       $yubinbangou,       TYPE_STR);
                    $SQLBind[] = array(':jusyo1',       $jusho1,       TYPE_STR);
                    $SQLBind[] = array(':jusyo2',       $jusho2,       TYPE_STR);
                    $SQLBind[] = array(':tel_no',       $telNo,       TYPE_STR);
                    $SQLBind[] = array(':fax_no',       $faxNo,       TYPE_STR);
                    $SQLBind[] = array(':senpou_renrakusaki',       $senpouRenrakusaki,       TYPE_STR);
                    $SQLBind[] = array(':shime_day1',  $shimeDay1,     TYPE_INT);
                    $SQLBind[] = array(':shime_day2',  $shimeDay2,     TYPE_INT);
                    $SQLBind[] = array(':tekiyou_tsuki',  $tekiyouTsuki,     TYPE_INT);
                    $SQLBind[] = array(':nyukin_tsuki1',  $nyukinTsuki1,     TYPE_INT);
                    $SQLBind[] = array(':nyukin_day1',  $nyukinDay1,     TYPE_INT);
                    $SQLBind[] = array(':kaishuhouhou1',  $kaishuhouhou1,     TYPE_INT);
                    $SQLBind[] = array(':tegata_sate1',  $tegataSate1,     TYPE_INT);
                    $SQLBind[] = array(':shiharai_kaishu_jougen_kin',  $shiharaiKaishuJoukenKin,     TYPE_INT);
                    $SQLBind[] = array(':kaishuhouhou2',  $kaishuhouhou2,     TYPE_INT);
                    $SQLBind[] = array(':nyukin_tsuki2',  $nyukinTsuki2,     TYPE_INT);
                    $SQLBind[] = array(':nyukin_day2',  $nyukinDay2,     TYPE_INT);
                    $SQLBind[] = array(':tegata_sate2',  $tegataSate2,     TYPE_INT);
                    $SQLBind[] = array(':furikomi_tesuryou_kbn',  $furikomiTesuryouKbn,     TYPE_INT);
                    $SQLBind[] = array(':kaishukouza_kbn',  $kaishukouzaKbn,     TYPE_INT);
                    $SQLBind[] = array(':kaishukouza_no',  $kaishukouzaNo,     TYPE_STR);
                    $SQLBind[] = array(':yoshingendogaku',  $yoshingendogaku,     TYPE_STR);
                    $SQLBind[] = array(':bikou1',  $bikou1,     TYPE_STR);
                    $SQLBind[] = array(':bikou2',  $bikou2,     TYPE_STR);
                    $SQLBind[] = array(':bikou3',  $bikou3,     TYPE_STR);
                    $SQLBind[] = array(':koum_zumen_hokanbasho',  $koumZumenHokanbasho,    TYPE_STR);
                    $SQLBind[] = array(':eigyo_zumen_hokanbasho',  $eigyoZumenHokanbasho,     TYPE_STR);
                    // データ処理開始
                    $master -> InsertMasterData($SQLBind, $tokuisakiCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
                    $resultVal[] = $common -> GetMaxId($tableName, $query);
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
