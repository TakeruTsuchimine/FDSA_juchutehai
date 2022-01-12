<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

/**
 * マスターテーブルレコード更新クラス　「得意先別納入先マスター」
 */
class PCMST_1601 extends Controller
{
    public function index(Request $request)
    {
        // 処理成功フラグ
        $resultFlg = true;
        //
        $resultMsg = '';
        //
        $resultVal = [];
        /** string  $tableName 対象テーブル名 */
        $tableName = 'tokui_nounyusaki_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        /** App\Http\Controllers\Classes\class_Master マスタ共通処理クラス宣言 */
        $master = new class_Master($tableName, 'nounyusakisaki_cd');
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

            /** string $nounyusakiCd 納入先CD */
            $nounyusakiCd = $request->dataNounyusakiCd;
            // POSTデータチェックエラー
            if (is_null($nounyusakiCd) || $nounyusakiCd === '') {
                $resultMsg .= '「' . __('nounyusaki_cd') . '」' . __('が正常に送信されていません。') . '\n';
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
                    $master->DeleteMasterData($nounyusakiCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // 納入先CDは新規登録の際、既に存在する納入先コードの場合はエラー
                    /** int $cdCount 管理CDの登録数 */
                    $cdCount = $common->GetCdCount($tableName, 'nounyusaki_cd', $nounyusakiCd);
                    if ($cdCount > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('nounyusaki_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataNounyusakiCd';
                        $resultFlg = false;
                    }

                    /** string $nounyusakiRyaku 納入先略称 */
                    $nounyusakiRyaku = $request -> dataNounyusakiRyaku;

                    /** string $nounyusakiName1 納入先名1 */
                    $nounyusakiName1 = $request -> dataNounyusakiName1;

                    /** string $nounyusakiName2 納入先名2 */
                    $nounyusakiName2 = $request -> dataNounyusakiName2;

                    /** string $nounyusakiKana 納入先カナ */
                    $nounyusakiKana = $request -> dataNounyusakiKana;

                    /** string $nounyusakiZip 納入先ZIP */
                    $nounyusakiZip = $request -> dataNounyusakiZip;

                    /** string $nounyusakiJusho1 納入先住所1 */
                    $nounyusakiJusho1 = $request -> dataNounyusakiJusho1;

                    /** string $nounyusakiJusho2 納入先住所2 */
                    $nounyusakiJusho2 = $request -> dataNounyusakiJusho2;

                    /** string $nounyubasho 納入場所 */
                    $nounyubasho = $request -> dataNounyubasho;

                    /** string $telNo 電話番号 */
                    $telNo = $request -> dataTelNo;

                    /** string $faxNo FAX番号 */
                    $faxNo = $request -> dataFaxNo;

                    /** string $senpouRenrakusaki 先方連絡先 */
                    $senpouRenrakusaki = $request -> dataSenpouRenrakusaki;

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

                    /** string $tokuisakiCd 得意先CD */
                    $tokuisakiCd = $request -> dataTokuisakiCd;
                    // POSTデータチェックエラー
                    if (is_null($tokuisakiCd) || $tokuisakiCd === '') {
                        $resultMsg .= '「' . __('tokuisaki_cd') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    $cdCount = $common -> GetCdCount('tokuisaki_master', 'tokuisaki_cd', $tokuisakiCd);
                    if($cdCount < 1)
                    {
                        $resultMsg .= __('登録されていない').'「'.__('tokuisaki_cd').'」'.__('です。').'<br>';
                        $resultVal[] = 'dataTokuisakiCd';
                        $resultFlg = false;
                    }

                    if (!$resultFlg) throw new Exception($resultMsg);

                    // 有効期間終了の設定
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));

                    // バインドの設定
                    /** array $SQLBind SQLバインド値 */
                    $SQLBind = array();
                    $SQLBind[] = array('jigyoubu_cd',           $jigyoubuCd,        TYPE_STR);
                    $SQLBind[] = array('tokuisaki_cd',          $tokuisakiCd,       TYPE_STR);
                    $SQLBind[] = array('nounyusaki_cd',         $nounyusakiCd,      TYPE_STR);
                    $SQLBind[] = array('nounyusaki_ryaku',      $nounyusakiRyaku,   TYPE_STR);
                    $SQLBind[] = array('nounyusaki_name1',      $nounyusakiName1,   TYPE_STR);
                    $SQLBind[] = array('nounyusaki_name2',      $nounyusakiName2,   TYPE_STR);
                    $SQLBind[] = array('nounyusaki_kana',       $nounyusakiKana,    TYPE_STR);
                    $SQLBind[] = array('nounyusaki_zip',        $nounyusakiZip,     TYPE_STR);
                    $SQLBind[] = array('nounyusaki_jusho1',     $nounyusakiJusho1,  TYPE_STR);
                    $SQLBind[] = array('nounyusaki_jusho2',     $nounyusakiJusho2,  TYPE_STR);
                    $SQLBind[] = array('nounyubasho',           $nounyubasho,       TYPE_STR);
                    $SQLBind[] = array('tel_no',                $telNo,             TYPE_STR);
                    $SQLBind[] = array('fax_no',                $faxNo,             TYPE_STR);
                    $SQLBind[] = array('senpou_renrakusaki',    $senpouRenrakusaki, TYPE_STR);
                    // データ処理開始
                    $master -> InsertMasterData($SQLBind, $nounyusakiCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
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
