<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

/**
 * マスターテーブルレコード更新クラス　「仕入外注先マスター」
 */
class PCMST_1801 extends Controller
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
        /** App\Http\Controllers\Classes\class_Master マスタ共通処理クラス宣言 */
        $tableName = 'shiiresaki_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        /** App\Http\Controllers\Classes\class_Common 共通関数宣言 */
        $common = new class_Common();
        /** App\Http\Controllers\Classes\class_Database データベース接続クラス宣言 */
        $query = new class_Database();
        /** App\Http\Controllers\Classes\class_Master マスタ共通処理クラス宣言 */
        $master = new class_Master($tableName, 'shiiresaki_cd');
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

            /** string $jigyoubuCd 事業部CD */
            $jigyoubuCd = $request -> dataJigyoubuCd;
            // POSTデータチェックエラー
            if(is_null($jigyoubuCd) || $jigyoubuCd === ''){
                $resultMsg .= '「'.__('jigyoubu_cd').'」'.__('が正常に送信されていません。').'\n';
                $resultFlg = false;
            }

            /** string $shiiresakiCd 仕入・外注先CD */
            $shiiresakiCd = $request -> dataShiiresakiCd;
            // POSTデータチェックエラー
            if(is_null($shiiresakiCd) || $shiiresakiCd === ''){
                $resultMsg .= '「'.__('shiiresaki_cd').'」'.__('が正常に送信されていません。').'\n';
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
                    $master->DeleteMasterData($shiiresakiCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // 事業部CD
                    $jigyoubuCd = $request->dataJigyoubuCd;
                    // POSTデータチェックエラー
                    if (is_null($jigyoubuCd) || $jigyoubuCd === '') {
                        $resultMsg .= '「' . __('jigyoubu_cd') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    /** int $cdCount 管理CDの登録数 */
                    $cdCount = $common->GetCdCount('jigyoubu_master', 'jigyoubu_cd', $jigyoubuCd);
                    if ($cdCount < 1) {
                        $resultMsg .= __('登録されていない') . '「' . __('jigyoubu_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataJigyoubuCd';
                        $resultFlg = false;
                    }

                    // 仕入・外注先CDは新規登録の際、既に存在する仕入・外注先CDの場合はエラー
                    $cdCount = $common -> GetCdCount($tableName, 'shiiresaki_cd', $shiiresakiCd);
                    if($cdCount > 0 && $SQLType === SQL_INSERT){
                        $resultMsg .= __('既に登録されている').'「'.__('shiiresaki_cd').'」'.__('です。').'<br>';
                        $resultVal[] = 'dataShiiresakiCd';
                        $resultFlg = false;
                    }

                    /** string $shiharaisakiCd 支払先CD */
                    $shiharaisakiCd = $request -> dataShiharaisakiCd;
                    /** string $shiharaisakiOyaCd 支払親コード */
                    $shiharaisakiOyaCd = $request -> dataShiharaisakiOyaCd;
                    /** string $shiiresakiRyaku 略称 */
                    $shiiresakiRyaku = $request -> dataShiiresakiRyaku;
                    /** string $shiiresakiName1 仕入・外注先名1 */
                    $shiiresakiName1 = $request -> dataShiiresakiName1;
                    /** string $shiiresakiName2 仕入・外注先名2 */
                    $shiiresakiName2 = $request -> dataShiiresakiName2;
                    /** string $shiiresakiKana 仕入・外注先名カナ */
                    $shiiresakiKana = $request -> dataShiiresakiKana;
                    /** string $shiiresakiZip ZIP */
                    $shiiresakiZip = $request -> dataShiiresakiZip;
                    /** string $shiiresakiJusho1 住所1 */
                    $shiiresakiJusho1 = $request -> dataShiiresakiJusho1;
                    /** string $shiiresakiJusho2 住所2 */
                    $shiiresakiJusho2 = $request -> dataShiiresakiJusho2;
                    /** string $telNo 電話番号 */
                    $telNo = $request -> dataTelNo;
                    /** string $faxNo FAX番号 */
                    $faxNo = $request -> dataFaxNo;
                    /** string $senpouRenrakusaki 先方連絡先 */
                    $senpouRenrakusaki = $request -> dataSenpouRenrakusaki;
                    /** int $shihonkin 資本金 */
                    $shihonkin = $request -> dataShihonkin;
                    /** string $bikou1 備考1 */
                    $bikou1 = $request -> dataBikou1;
                    /** string $bikou2 備考2 */
                    $bikou2 = $request -> dataBikou2;
                    /** string $bikou3 備考3 */
                    $bikou3 = $request -> dataBikou3;
                    /** string $bikou4 備考4 */
                    $bikou4 = $request -> dataBikou4;
                    /** string $ginkouName 銀行名 */
                    $ginkouName = $request -> dataGinkouName;
                    /** string $shitenName 支店名 */
                    $shitenName = $request -> dataShitenName;
                    /** int $shiharaiKouzaNo 支払口座番号 */
                    $shiharaiKouzaNo = $request -> dataShiharaiKouzaNo;
                    /** string $torihikiTeishiRiyu 取引停止理由 */
                    $torihikiTeishiRiyu = $request -> dataTorihikiTeishiRiyu;
                    /** string $gyoushuCd 業種分類CD */
                    $gyoushuCd = $request -> dataGyoushuCd;
                    /** string $kakuninDate 確認日 */
                    $kakuninDate = $request -> dataKakuninDate;
                    /** string $torihikiTeishiDate 取引停止日 */
                    $torihikiTeishiDate = $request -> dataTorihikiTeishiDate;
                    /** string $keishouKbn 敬称区分 */
                    $keishouKbn = $request -> dataKeishouKbn;

                    // コンポボックス
                    /** int $shiireKbn 仕入区分 */
                    $shiireKbn = empty($request -> dataShiireKbn) ? 0 : $request -> dataShiireKbn;
                    /** int $gaichuKbn 外注区分 */
                    $gaichuKbn = empty($request -> dataGaichuKbn) ? 0 : $request -> dataGaichuKbn;
                    /** int $shiharaiKbn 支払区分 */
                    $shiharaiKbn = empty($request -> dataShiharaiKbn) ? 0 : $request -> dataShiharaiKbn;
                    /** int $shokuchiKbn 諸口区分 */
                    $shokuchiKbn = empty($request -> dataShokuchiKbn) ? 0 : $request -> dataShokuchiKbn;
                    /** int $shouhizeiKeisanTani 消費税計算単位 */
                    $shouhizeiKeisanTani = empty($request -> dataShouhizeiKeisanTani) ? 0 : $request -> dataShohizeiKeisanTani;
                    /** int $shouhizeiKeisanHoushiki 消費税計算方式 */
                    $shouhizeiKeisanHoushiki = empty($request -> dataShouhizeiKeisanHoushiki) ? 0 : $request -> dataShohizeiKeisanHoushiki;
                    /** int $shouhizeiKeisanMarume 消費税計算丸目 */
                    $shouhizeiKeisanMarume = empty($request -> dataShouhizeiKeisanMarume) ? 0 : $request -> dataShohizeiKeisanMarume;
                    /** int $kingakuKeisanMarume 金額計算丸目 */
                    $kingakuKeisanMarume = empty($request -> dataKingakuKeisanMarume) ? 0 : $request -> dataKingakuKeisanMarume;
                    /** int $shimeDay1 締日1 */
                    $shimeDay1 = empty($request -> dataShimeDay1) ? 1 : $request -> dataShimeDay1;
                    /** int $shimeDay2 締日2 */
                    $shimeDay2 = empty($request -> dataShimeDay2) ? 1 : $request -> dataShimeDay2;
                    /** int $tekiyouTsuki 適用月（締日2） */
                    $tekiyouTsuki = empty($request -> dataTekiyouTsuki) ? 1 : $request -> dataTekiyouTsuki;
                    /** int $shiharaiTsuki1 支払予定月1 */
                    $shiharaiTsuki1 = empty($request -> dataShiharaiTsuki1) ? 0 : $request -> dataShiharaiTsuki1;
                    /** int $shiharaiDay1 支払日1 */
                    $shiharaiDay1 = empty($request -> dataShiharaiDay1) ? 1 : $request -> dataShiharaiDay1;
                    /** int $shiharaiHouhou1 支払方法1 */
                    $shiharaiHouhou1 = empty($request -> dataShiharaiHouhou1) ? 0 : $request -> dataShiharaiHouhou1;
                    /** int $tegataSate1 手形サイト1 */
                    $tegataSate1 = empty($request -> dataTegataSate1) ? 0 : $request -> dataTegataSate1;
                    /** int $shiharaiKaishuJougenKin 支払・回収額上限 */
                    $shiharaiKaishuJougenKin = empty($request -> dataShiharaiKaishuJougenKin) ? 0 : $request -> dataShiharaiKaishuJougenKin;
                    /** int $shiharaiTsuki2 支払予定月2 */
                    $shiharaiTsuki2 = empty($request -> dataShiharaiTsuki2) ? 0 : $request -> dataShiharaiTsuki2;
                    /** int $shiharaiDay2 支払日2 */
                    $shiharaiDay2 = empty($request -> dataShiharaiDay2) ? 1 : $request -> dataShiharaiDay2;
                    /** int $shiharaiHouhou2 支払方法2 */
                    $shiharaiHouhou2 = empty($request -> dataShiharaiHouhou2) ? 0 : $request -> dataShiharaiHouhou2;
                    /** int $tegataSate2 手形サイト2 */
                    $tegataSate2 = empty($request -> dataTegataSate2) ? 0 : $request -> dataTegataSate2;
                    /** int $furikomiTesuryouKbn 振込手数料区分 */
                    $furikomiTesuryouKbn = empty($request -> dataFurikomiTesuryouKbn) ? 0 : $request -> dataFurikomiTesuryouKbn;
                    /** int $shiharaiKouzaKbn 支払口座区分 */
                    $shiharaiKouzaKbn = empty($request -> dataShiharaiKouzaKbn) ? 0 : $request -> dataShiharaiKouzaKbn;


                    // エラーがあった際は処理せずエラーメッセージを表示して終了
                    if (!$resultFlg) throw new Exception($resultMsg);

                    /** string $yukoukikanEndDate 有効期間（至） */
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    // バインドの設定
                    /** array $SQLBind SQLバインド値 */
                    $SQLBind = array();
                    $SQLBind[] = array('jigyoubu_cd',       $jigyoubuCd, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_cd',       $shiiresakiCd, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_ryaku',       $shiiresakiRyaku, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_name1',       $shiiresakiName1, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_name2',       $shiiresakiName2, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_kana',       $shiiresakiKana, TYPE_STR);
                    $SQLBind[] = array('keishou_kbn',       $keishouKbn, TYPE_STR);
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
                    $SQLBind[] = array('bikou4',       $bikou4, TYPE_STR);
                    $SQLBind[] = array('shouhizei_keisan_tani',       $shouhizeiKeisanTani, TYPE_INT);
                    $SQLBind[] = array('shouhizei_keisan_houshiki',       $shouhizeiKeisanHoushiki, TYPE_INT);
                    $SQLBind[] = array('shouhizei_keisan_marume',       $shouhizeiKeisanMarume, TYPE_INT);
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
        /** array $resultData 出力データ */
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($resultMsg, 'UTF-8', 'UTF-8');
        $resultData[] = mb_convert_encoding($resultVal, 'UTF-8', 'UTF-8');
        // 処理結果送信
        return $resultData;
    }
}
