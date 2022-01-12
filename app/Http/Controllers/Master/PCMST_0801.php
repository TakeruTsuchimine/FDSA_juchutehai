<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

/**
 * マスターテーブルレコード更新クラス　「機械マスター」
 */
class PCMST_0801 extends Controller
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
        $tableName = 'kikai_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        /** App\Http\Controllers\Classes\class_Common 共通関数宣言 */
        $common = new class_Common();
        /** App\Http\Controllers\Classes\class_Database データベース接続クラス宣言 */
        $query = new class_Database();
        /** App\Http\Controllers\Classes\class_Master マスタ共通処理クラス宣言 */
        $master = new class_Master($tableName, 'kikai_cd');
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

            /** string $kikaiCd 機械CD */
            $kikaiCd = $request->dataKikaiCd;
            // POSTデータチェックエラー
            if (is_null($kikaiCd) || $kikaiCd === '') {
                $resultMsg .= '「' . __('kikai_cd') . '」' . __('が正常に送信されていません。') . '\n';
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
                    $master->DeleteMasterData($kikaiCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // 機械CDは新規登録の際、既に存在する機械コードの場合はエラー
                    /** int $cdCount 管理CDの登録数 */
                    $cdCount = $common->GetCdCount($tableName, 'kikai_cd', $kikaiCd);
                    if ($cdCount > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('kikai_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataKikaiCd';
                        $resultFlg = false;
                    }

                    /** string $kikaiName 機械名 */
                    $kikaiName = $request->dataKikaiName;

                    /** string $bikou 備考 */
                    $bikou = $request->dataBikou;

                    /** int $hyoujunKadouMin 標準稼働時間（分） */
                    $hyoujunKadouMin = $request->dataHyoujunKadouMin;

                    /** string $mainKouteiCd 主工程CD */
                    $mainKouteiCd = $request->dataMainKouteiCd;

                    /** int $mujinKadouKbn 無人稼働区分 */
                    $mujinKadouKbn = empty((int)$request->dataMujinKadouKbn) ? 0 : (int)$request->dataMujinKadouKbn;

                    /** int $sotoDandoriKbn 外段取区分 */
                    $sotoDandoriKbn = empty((int)$request->dataSotoDandoriKbn) ? 0 : (int)$request->dataSotoDandoriKbn;

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

                    /** string $bushoCd 部署CD */
                    $bushoCd = $request->dataBushoCd;
                    // コードが存在しない場合はエラー
                    if (!is_null($bushoCd) && $bushoCd !== '') {
                        $cdCount = $common->GetCdCount('busho_master', 'busho_cd', $bushoCd);
                        if ($cdCount < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('bushop_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataBushoCd';
                            $resultFlg = false;
                        }
                    }

                    // エラーがあった際は処理せずエラーメッセージを表示して終了
                    if (!$resultFlg) throw new Exception($resultMsg);

                    /** string $yukoukikanEndDate 有効期間（至） */
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    // バインドの設定
                    /** array $SQLBind SQLバインド値 */
                    $SQLBind = array();
                    $SQLBind[] = array('busho_cd', $bushoCd, TYPE_STR);
                    $SQLBind[] = array('jigyoubu_cd', $jigyoubuCd, TYPE_STR);
                    $SQLBind[] = array('kikai_cd', $kikaiCd, TYPE_STR);
                    $SQLBind[] = array('kikai_name', $kikaiName, TYPE_STR);
                    $SQLBind[] = array('bikou', $bikou, TYPE_STR);
                    $SQLBind[] = array('hyoujun_kadou_min', $hyoujunKadouMin, TYPE_INT);
                    $SQLBind[] = array('main_koutei_cd', $mainKouteiCd, TYPE_STR);
                    $SQLBind[] = array('mujin_kadou_kbn', $mujinKadouKbn, TYPE_INT);
                    $SQLBind[] = array('soto_dandori_kbn', $sotoDandoriKbn, TYPE_INT);
                    // データ処理開始
                    $master->InsertMasterData($SQLBind, $kikaiCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
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
