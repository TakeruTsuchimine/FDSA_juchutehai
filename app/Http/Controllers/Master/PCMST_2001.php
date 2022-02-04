<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

/**
 * マスターテーブルレコード更新クラス　「メーカーマスター」
 */
class PCMST_2001 extends Controller
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
        $tableName = 'maker_master';
        /** App\Http\Controllers\Classes\class_Common 共通関数宣言 */
        $common = new class_Common();
        /** App\Http\Controllers\Classes\class_Database データベース接続クラス宣言 */
        $query = new class_Database();
        /** App\Http\Controllers\Classes\class_Master マスタ共通処理クラス宣言 */
        $master = new class_Master($tableName, 'maker_cd');
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

            /** string $makerCd メーカーCD */
            $makerCd = $request->dataMakerCd;
            // POSTデータチェックエラー
            if (is_null($makerCd) || $makerCd === '') {
                $resultMsg .= '「' . __('maker_cd') . '」' . __('が正常に送信されていません。') . '\n';
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
                    $master->DeleteMasterData($makerCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // メーカーCDは新規登録の際、既に存在するメーカーCDの場合はエラー
                    /** int $cdCount 管理CDの登録数 */
                    $cdCount  = $common->GetCdCount($tableName, 'maker_cd', $makerCd);
                    if ($cdCount  > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('maker_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataMakerCd';
                        $resultFlg = false;
                    }
                    /** string $makerRyaku 略称 */
                    $makerRyaku = $request->dataMakerRyaku;
                    /** string $makerName メーカー名 */
                    $makerName = $request->dataMakerName;

                    if (!$resultFlg) throw new Exception($resultMsg);

                    /** string $yukoukikanEndDate 有効期間（至） */
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    // バインドの設定
                    /** array $SQLBind SQLバインド値 */
                    $SQLBind = array();
                    $SQLBind[] = array('maker_cd',       $makerCd, TYPE_STR);
                    $SQLBind[] = array('maker_ryaku',       $makerRyaku, TYPE_STR);
                    $SQLBind[] = array('maker_name',       $makerName, TYPE_STR);
                    // データ処理開始
                    $master->InsertMasterData($SQLBind, $makerCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
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
