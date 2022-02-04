<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

/**
 * マスターテーブルレコード更新クラス　「得意先マスター」
 */
class PCMST_1401 extends Controller
{
    /**
     * テーブルレコード更新
     *
     * @param Request $request POST受信データ
     *
     * @return array $resultData 更新結果データ
     */
    public function index(Request $request)
    {
        /** boolean $resultFlg 処理成功フラグ */
        $resultFlg = true;
        /** string  $resultMsg 処理結果メッセージ */
        $resultMsg = '';
        /** array   $resultMsg 処理結果データ */
        $resultVal = [];
        /** string  $tableName 対象テーブル名 */
        $tableName = 'tokuisaki_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        /** App\Http\Controllers\Classes\class_Common 共通関数宣言 */
        $common = new class_Common();
        /** App\Http\Controllers\Classes\class_Database データベース接続クラス宣言 */
        $query = new class_Database();
        /** App\Http\Controllers\Classes\class_Master マスタ共通処理クラス宣言 */
        $master = new class_Master($tableName, 'tokuisaki_cd');
        try {
            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            //
            // 入力値のエラーチェック
            //
            /** int $SQLType トランザクション種別 */
            $SQLType = empty($request->dataSQLType) ? 0 : (int)$request->dataSQLType;
            if ($SQLType < 1) {
                $resultMsg .= '「' . __('データ') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            /** string $tokuisakiCd 得意先CD */
            $tokuisakiCd = $request->dataTokuisakiCd;
            // POSTデータチェックエラー
            if (is_null($tokuisakiCd) || $tokuisakiCd === '') {
                $resultMsg .= '「' . __('tokuisaki_cd') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            /** string $yukoukikanStartDate 有効期間（自） */
            $yukoukikanStartDate = $request->dataStartDate;
            // POSTデータチェックエラー
            if (empty($yukoukikanStartDate)) {
                $resultMsg .= '「' . __('yukoukikan_start_date') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            /** int $loginId 登録者ID */
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
                    /** int $dataId レコードID */
                    $dataId = $request->dataId;
                    if (empty($dataId)) {
                        $resultMsg .= '「' . __('ID') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // データ処理開始
                    $master->DeleteMasterData($tokuisakiCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // 得意先CDは新規登録の際、既に存在する得意先コードの場合はエラー
                    /** int $cdCount 管理CDの登録数 */
                    $cdCount = $common->GetCdCount($tableName, 'tokuisaki_cd', $tokuisakiCd);
                    if ($cdCount > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('tokuisaki_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataTokuisakiCd';
                        $resultFlg = false;
                    }

                    /** string $tokuisakiRyaku 得意先略称 */
                    $tokuisakiRyaku = $request -> dataTokuisakiRyaku;

                    /** string $tokuisakiRyaku2 得意先略称2 */
                    $tokuisakiRyaku2 = $request -> dataTokuisakiRyaku2;

                    /** string $tokuisakiHyoujiName 表示名 */
                    $tokuisakiHyoujiName = $request -> dataTokuisakiHyoujiName;

                    /** string $tokuisakiName1 得意先名1 */
                    $tokuisakiName1 = $request -> dataTokuisakiName1;

                    /** string $tokuisakiName2 得意先名2 */
                    $tokuisakiName2 = $request -> dataTokuisakiName2;

                    /** string $tokuisakiKana 納入先カナ */
                    $tokuisakiKana = $request -> dataTokuisakiKana;

                    /** string $eigyouTantoushaCd 営業担当者CD */
                    $eigyouTantoushaCd = $request -> dataEigyouTantoushaCd;

                    /** string $assistantCd アシスタントCD */
                    $assistantCd = $request -> dataAssistantCd;

                    /** string $nyukinOyaCd 入金親CD */
                    $nyukinOyaCd = $request -> dataNyukinOyaCd;

                    /** string $seikyusakiCd 請求先CD */
                    $seikyusakiCd = $request -> dataSeikyusakiCd ;

                    /** string $jusho1 住所1 */
                    $jusho1 = $request -> dataJusho1;

                    /** string $jusho2 住所2 */
                    $jusho2 = $request -> dataJusho2;

                    /** string $telNo 電話番号 */
                    $telNo = $request -> dataTelNo;

                    /** string $faxNo FAX番号 */
                    $faxNo = $request -> dataFaxNo;

                    /** string $senpouRenrakusaki 先方連絡先 */
                    $senpouRenrakusaki = $request -> dataSenpouRenrakusaki;

                    /** int $yoshingendogaku 与信限度額 */
                    $yoshingendogaku = $request -> dataYoshingendogaku;

                    /** string $bikou1 備考1 */
                    $bikou1 = $request -> dataBikou1;

                    /** string $bikou2 備考2 */
                    $bikou2 = $request -> dataBikou2;

                    /** string $bikou3 備考3 */
                    $bikou3 = $request -> dataBikou3;

                    /** string $bikou4 備考4 */
                    $bikou4 = $request -> dataBikou4;

                    /** string $koumuZumenHokanbasho 工務用図面保管場所 */
                    $koumuZumenHokanbasho = $request -> dataKoumuZumenHokanbasho;

                    /** string $eigyouZumenHokanbasho 営業用図面保管場所 */
                    $eigyouZumenHokanbasho = $request -> dataEigyouZumenHokanbasho;

                    /** string $keishouKbn 敬称区分 */
                    $keishouKbn = $request -> dataKeishouKbn;

                    /** int $shokuchiKbn 諸口区分 */
                    $shokuchiKbn = empty($request -> dataShokuchiKbn) ? 0 : $request -> dataShokuchiKbn;

                    /** int $nouhinshoMidashiKbn 納品書見出区分 */
                    $nouhinshoMidashiKbn = empty($request -> dataNouhinshoMidashiKbn) ? 0 : $request -> dataNouhinshoMidashiKbn;

                    /** int $nouhinshoHakkouKbn 納品書発行区分 */
                    $nouhinshoHakkouKbn = empty($request -> dataNouhinshoHakkouKbn) ? 0 : $request -> dataNouhinshoHakkouKbn;

                    /** int $senyouDenpyouHakkouKbn 専用伝票発行区分 */
                    $senyouDenpyouHakkouKbn = empty($request -> dataSenyouDenpyouHakkouKbn) ? 0 : $request -> dataSenyouDenpyouHakkouKbn;

                    /** int $seikyushoHakkouKbn 請求書発行区分 */
                    $seikyushoHakkouKbn = empty($request -> dataSeikyushoHakkouKbn) ? 1 : $request -> dataSeikyushoHakkouKbn;

                    /** int $tokuisakiTorihikiKbn 得意先取引区分 */
                    $tokuisakiTorihikiKbn = empty($request -> dataTokuisakiTorihikiKbn) ? 1 : $request -> dataTokuisakiTorihikiKbn;

                    /** int $seikyusakiTorihikiKbn 請求先取引区分 */
                    $seikyusakiTorihikiKbn = empty($request -> dataSeikyusakiTorihikiKbn) ? 1 : $request -> dataSeikyusakiTorihikiKbn;

                    /** int $furikomiTesuryouKbn 振込手数料区分 */
                    $furikomiTesuryouKbn = empty($request -> dataFurikomiTesuryouKbn) ? 0 : $request -> dataFurikomiTesuryouKbn;

                    /** int $shohizeiKeisanTani 消費税計算単位 */
                    $shohizeiKeisanTani = empty($request -> dataShohizeiKeisanTani) ? 0 : $request -> dataShohizeiKeisanTani;

                    /** int $shohizeiKeisanHoushiki 消費税計算方式 */
                    $shohizeiKeisanHoushiki = empty($request -> dataShohizeiKeisanHoushiki) ? 1 : $request -> dataShohizeiKeisanHoushiki;

                    /** int $shohizeiKeisanMarume 消費税計算丸目 */
                    $shohizeiKeisanMarume = empty($request -> dataShohizeiKeisanMarume) ? 0 : $request -> dataShohizeiKeisanMarume;

                    /** int $kingakuKeisanMarume 金額計算丸目 */
                    $kingakuKeisanMarume = empty($request -> dataKingakuKeisanMarume) ? 0 : $request -> dataKingakuKeisanMarume;

                    /** int $shimeDay1 締日1 */
                    $shimeDay1 = empty($request -> dataShimeDay1) ? 0 : $request -> dataShimeDay1;

                    /** int $shimeDay2 締日2 */
                    $shimeDay2 = empty($request -> dataShimeDay2) ? 0 : $request -> dataShimeDay2;

                    /** int $tekiyouTsuki 適用月（締日2） */
                    $tekiyouTsuki = empty($request -> dataTekiyouTsuki) ? 0 : $request -> dataTekiyouTsuki;

                    /** int $nyukinTsuki 入金月 */
                    $nyukinTsuki = empty($request -> dataNyukinTsuki) ? 0 : $request -> dataNyukinTsuki;

                    /** int $nyukinDay 入金日 */
                    $nyukinDay = empty($request -> dataNyukinDay) ? 0 : $request -> dataNyukinDay;

                    /** int $kaishuHouhou 回収方法 */
                    $kaishuHouhou = empty($request -> dataKaishuHouhou) ? 0 : $request -> dataKaishuHouhou;

                    /** int $tegataSate 手形サイト */
                    $tegataSate = empty($request -> dataTegataSate) ? 0 : $request -> dataTegataSate;

                    $kaishukouzaKbn = empty($request->dataKaishukouzaKbn) ? 1 : $request->dataKaishukouzaKbn;

                    /** string $jigyoubuCd 事業部CD */
                    $jigyoubuCd = $request -> dataJigyoubuCd;
                    // POSTデータチェックエラー
                    if (is_null($jigyoubuCd) || $jigyoubuCd === '') {
                        $resultMsg .= '「' . __('jigyoubu_cd') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    $cdCount = $common -> GetCdCount('jigyoubu_master', 'jigyoubu_cd', $jigyoubuCd);
                    if($cdCount < 1)
                    {
                        $resultMsg .= __('登録されていない').'「'.__('jigyoubu_cd').'」'.__('です。').'<br>';
                        $resultVal[] = 'dataJigyoubuCd';
                        $resultFlg = false;
                    }

                    // エラーがあった際は処理せずエラーメッセージを表示して終了
                    if (!$resultFlg) throw new Exception($resultMsg);

                    /** string $yukoukikanEndDate 有効期間（至） */
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));

                    // バインドの設定
                    /** array $SQLBind SQLバインド値 */
                    $SQLBind = array();
                    $SQLBind[] = array('jigyoubu_cd',               $jigyoubuCd,       TYPE_STR);
                    $SQLBind[] = array('tokuisaki_cd',              $tokuisakiCd,       TYPE_STR);
                    $SQLBind[] = array('tokuisaki_ryaku',           $tokuisakiRyaku,       TYPE_STR);
                    $SQLBind[] = array('tokuisaki_ryaku2',          $tokuisakiRyaku2,       TYPE_STR);
                    $SQLBind[] = array('tokuisaki_hyouji_name',     $tokuisakiHyoujiName,       TYPE_STR);
                    $SQLBind[] = array('tokuisaki_name1',           $tokuisakiName1,       TYPE_STR);
                    $SQLBind[] = array('tokuisaki_name2',           $tokuisakiName2,       TYPE_STR);
                    $SQLBind[] = array('tokuisaki_kana',            $tokuisakiKana,       TYPE_STR);
                    $SQLBind[] = array('eigyou_tantousha_cd',       $eigyouTantoushaCd,       TYPE_STR);
                    $SQLBind[] = array('assistant_cd',              $assistantCd,     TYPE_STR);
                    $SQLBind[] = array('seikyusaki_cd',             $seikyusakiCd,       TYPE_STR);
                    $SQLBind[] = array('nyukin_oya_cd',             $nyukinOyaCd,       TYPE_STR);
                    $SQLBind[] = array('keishou_kbn',               $keishouKbn,     TYPE_STR);
                    $SQLBind[] = array('shokuchi_kbn',              $shokuchiKbn,     TYPE_INT);
                    $SQLBind[] = array('nouhinsho_midashi_kbn',     $nouhinshoMidashiKbn,     TYPE_INT);
                    $SQLBind[] = array('nouhinsho_hakkou_kbn',      $nouhinshoHakkouKbn,     TYPE_INT);
                    $SQLBind[] = array('senyou_denpyou_hakkou_kbn', $senyouDenpyouHakkouKbn,     TYPE_INT);
                    $SQLBind[] = array('seikyusho_hakkou_kbn',      $seikyushoHakkouKbn,     TYPE_INT);
                    $SQLBind[] = array('tokuisaki_torihiki_kbn',    $tokuisakiTorihikiKbn,     TYPE_INT);
                    $SQLBind[] = array('seikyusaki_torihiki_kbn',   $seikyusakiTorihikiKbn,     TYPE_INT);
                    $SQLBind[] = array('shohizei_keisan_tani',      $shohizeiKeisanTani,     TYPE_INT);
                    $SQLBind[] = array('shohizei_keisan_houshiki',  $shohizeiKeisanHoushiki,     TYPE_INT);
                    $SQLBind[] = array('shohizei_keisan_marume',    $shohizeiKeisanMarume,     TYPE_INT);
                    $SQLBind[] = array('kingaku_keisan_marume',     $kingakuKeisanMarume,     TYPE_INT);
                    $SQLBind[] = array('jusho1',                    $jusho1,       TYPE_STR);
                    $SQLBind[] = array('jusho2',                    $jusho2,       TYPE_STR);
                    $SQLBind[] = array('tel_no',                    $telNo,       TYPE_STR);
                    $SQLBind[] = array('fax_no',                    $faxNo,       TYPE_STR);
                    $SQLBind[] = array('senpou_renrakusaki',        $senpouRenrakusaki,       TYPE_STR);
                    $SQLBind[] = array('shime_day1',                $shimeDay1,     TYPE_INT);
                    $SQLBind[] = array('shime_day2',                $shimeDay2,     TYPE_INT);
                    $SQLBind[] = array('tekiyou_tsuki',             $tekiyouTsuki,     TYPE_INT);
                    $SQLBind[] = array('nyukin_tsuki',              $nyukinTsuki,     TYPE_INT);
                    $SQLBind[] = array('nyukin_day',                $nyukinDay,     TYPE_INT);
                    $SQLBind[] = array('kaishu_houhou',             $kaishuHouhou,     TYPE_INT);
                    $SQLBind[] = array('tegata_sate',               $tegataSate,     TYPE_INT);
                    $SQLBind[] = array('furikomi_tesuryou_kbn',     $furikomiTesuryouKbn,     TYPE_INT);
                    $SQLBind[] = array('yoshingendogaku',           $yoshingendogaku,     TYPE_STR);
                    $SQLBind[] = array('bikou1',                    $bikou1,     TYPE_STR);
                    $SQLBind[] = array('bikou2',                    $bikou2,     TYPE_STR);
                    $SQLBind[] = array('bikou3',                    $bikou3,     TYPE_STR);
                    $SQLBind[] = array('bikou4',                    $bikou4,     TYPE_STR);
                    $SQLBind[] = array('koumu_zumen_hokanbasho',    $koumuZumenHokanbasho,    TYPE_STR);
                    $SQLBind[] = array('eigyou_zumen_hokanbasho',   $eigyouZumenHokanbasho,     TYPE_STR);
                    // データ処理開始
                    $master->InsertMasterData($SQLBind, $tokuisakiCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
                    $resultVal[] = $common->GetMaxId($tableName, $query);
                    break;
                    // INSERT処理終了 //
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $resultMsg = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        }
        /** array $resultData 出力データ */
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($resultMsg, 'UTF-8', 'UTF-8');
        $resultData[] = mb_convert_encoding($resultVal, 'UTF-8', 'UTF-8');
        // 処理結果送信
        return $resultData;
    }
}
