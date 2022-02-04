<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

/**
 * マスターテーブルレコード更新クラス　「部署マスター」
 */
class PCMST_0301 extends Controller
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
        $tableName = 'busho_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        /** App\Http\Controllers\Classes\class_Common 共通関数宣言 */
        $common = new class_Common();
        /** App\Http\Controllers\Classes\class_Database データベース接続クラス宣言 */
        $query = new class_Database();
        /** App\Http\Controllers\Classes\class_Master マスタ共通処理クラス宣言 */
        $master = new class_Master($tableName, 'busho_cd');
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

            /** string $bushoCd 部署CD */
            $bushoCd = $request->dataBushoCd;
            // POSTデータチェックエラー
            if (is_null($bushoCd) || $bushoCd === '') {
                $resultMsg .= '「' . __('busho_cd') . '」' . __('が正常に送信されていません。') . '\n';
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
                    $master->DeleteMasterData($bushoCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // 部署CDは新規登録の際、既に存在する部署コードの場合はエラー
                    /** int $cdCount 管理CDの登録数 */
                    $cdCount = $common->GetCdCount($tableName, 'busho_cd', $bushoCd);
                    if ($cdCount > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('busho_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataBushoCd';
                        $resultFlg = false;
                    }

                    /** string $bushoName 部署名 */
                    $bushoName = $request->dataBushoName;

                    /** string $bushoRyakuName 表示名 */
                    $bushoRyakuName = $request->dataBushoRyakuName;

                    /** int $hyoujiSeq 順序 */
                    $hyoujiSeq = $request->dataHyoujiSeq;

                    /** int $shukeiNo 集計No */
                    $shukeiNo = $request->dataShukeiNo;

                    /** string $seikyuCd 請求CD */
                    $seikyuCd = $request->dataSeikyuCd;
                    // POSTデータチェックエラー
                    if (is_null($seikyuCd) || $seikyuCd === '') {
                        $resultMsg .= '「' . __('seikyu_cd') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    $cdCount = $common->GetCdCount('seikyu_master', 'seikyu_cd', $seikyuCd);
                    if ($cdCount < 1) {
                        $resultMsg .= __('登録されていない') . '「' . __('seikyu_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataSeikyuCd';
                        $resultFlg = false;
                    }

                    /** string $keiriCd 経理CD */
                    $keiriCd = $request->dataKeiriCd;
                    // POSTデータチェックエラー
                    if (is_null($keiriCd) || $keiriCd === '') {
                        $resultMsg .= '「' . __('keiri_cd') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    $cdCount = $common->GetCdCount('kaisou_bunrui_master', 'keiri_cd', $keiriCd);
                    if ($cdCount < 1) {
                        $resultMsg .= __('登録されていない') . '「' . __('keiri_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataKeiriCd';
                        $resultFlg = false;
                    }

                    /** string $jigyoubuCd 事業部CD */
                    $jigyoubuCd = $request->dataJigyoubuCd;
                    // POSTデータチェックエラー
                    if (is_null($jigyoubuCd) || $jigyoubuCd === '') {
                        $resultMsg .= '「' . __('jigyoubu_cd') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    $cdCount = $common->GetCdCount('jigyoubu_master', 'jigyoubu_cd', $jigyoubuCd);
                    if ($cdCount < 1) {
                        $resultMsg .= __('登録されていない') . '「' . __('jigyoubu_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataJigyoubuCd';
                        $resultFlg = false;
                    }

                    if (!$resultFlg) throw new Exception($resultMsg);

                    /** string $yukoukikanEndDate 有効期間（至） */
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    // バインドの設定
                    /** array $SQLBind SQLバインド値 */
                    $SQLBind = array();
                    $SQLBind[] = array('busho_cd', $bushoCd, TYPE_STR);
                    $SQLBind[] = array('busho_name', $bushoName, TYPE_STR);
                    $SQLBind[] = array('busho_ryaku_name', $bushoRyakuName, TYPE_STR);
                    $SQLBind[] = array('jigyoubu_cd', $jigyoubuCd, TYPE_STR);
                    $SQLBind[] = array('hyouji_seq', $hyoujiSeq, TYPE_INT);
                    $SQLBind[] = array('shukei_no', $shukeiNo, TYPE_INT);
                    // データ処理開始
                    $master->InsertMasterData($SQLBind, $bushoCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
                    $resultVal[] = $common->GetMaxId($tableName);
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
