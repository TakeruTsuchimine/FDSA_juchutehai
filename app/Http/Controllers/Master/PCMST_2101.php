<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCMST_2101 extends Controller
{
    /**
     * キーになるコードのレコードの数を取得する
     * @param string $tableName　対象のデータテーブル名
     * @param string $cdColumn　 対象CD列名
     * @param string $cdValue  　検査対象のCD値
     * @param string $date     　対象日（省略可）
     *
     * @return int 取得件数
     */
    function GetLevelCount($tableName, $levelColumn, $levelValue, $date = ''): int
    {
        // 対象日が無い場合は今日の日付を設定
        if (empty($date)) $date = date("Y/m/d");

        $query = new class_Database();
        // SQLテキストの設定
        $SQLText  = ' select count(*) ';
        $SQLText .= ' from ' . $tableName;
        $SQLText .= " where  sakujo_dt is null
                      and    :today >= yukoukikan_start_date
                      and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31' else yukoukikan_end_date end ";
        $SQLText .= ' and ' . $levelColumn . ' = :level';
        // クエリの設定
        $query->StartConnect();
        $query->SetQuery($SQLText, SQL_SELECT);
        // バインド値のセット
        $query->SetBindValue(":level", $levelValue, TYPE_INT);
        $query->SetBindValue(":today",  $date, TYPE_DATE);
        // クエリの実行
        $result = $query->ExecuteSelect();
        return $result[0][0];
    }
    public function index(Request $request)
    {
        // 処理成功フラグ
        $resultFlg = true;
        //
        $resultMsg = '';
        //
        $resultVal = [];
        //
        $tableName = 'location_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'location_cd');
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

            // 置場・棚番CD
            $locationCd = $request->dataLocationCd;
            // POSTデータチェックエラー
            if (is_null($locationCd) || $locationCd === '') {
                $resultMsg .= '「' . __('location_cd') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // 階層レベル
            $structureLevel = $request->dataStructureLevel;
            // POSTデータチェックエラー
            if (is_null($structureLevel)) {
                $resultMsg .= '「' . __('structure_level') . '」' . __('が正常に送信されていません。') . '\n';
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
                    $master->DeleteMasterData($locationCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // 置場・棚番CDは新規登録の際、既に存在する置場・棚番コードの場合はエラー
                    $result = $common->GetCdCount($tableName, 'location_cd', $locationCd);
                    if ($result > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('location_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataLocationCd';
                        $resultFlg = false;
                    }

                    // 階層レベルは新規登録の際、既に存在する階層レベルの場合はエラー
                    $result = $common->GetCdCount($tableName, 'structure_level', $structureLevel);
                    if ($result > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('structure_level') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataStructureLevel';
                        $resultFlg = false;
                    }

                    // 置場・棚番名
                    $locationName = $request->dataLocationName;

                    // 棚番親置場CD
                    $locationOyaCd = $request->dataLocationOyaCd;

                    // 階層レベル
                    $structureLevel = empty((int)$request->dataStructureLevel) ? 0 : (int)$request->dataStructureLevel;

                    // 事業部CD
                    $jigyoubuCd = $request->dataJigyoubuCd;
                    // POSTデータチェックエラー
                    if (is_null($jigyoubuCd) || $jigyoubuCd === '') {
                        $resultMsg .= '「' . __('jigyoubu_cd') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    $result = $common->GetCdCount('jigyoubu_master', 'jigyoubu_cd', $jigyoubuCd);
                    if ($result < 1) {
                        $resultMsg .= __('登録されていない') . '「' . __('jigyoubu_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataJigyoubuCd';
                        $resultFlg = false;
                    }

                    if (!$resultFlg) throw new Exception($resultMsg);

                    // 有効期間終了の設定
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    // バインドの設定
                    $SQLBind = array();
                    $SQLBind[] = array('jigyoubu_cd', $jigyoubuCd, TYPE_STR);
                    $SQLBind[] = array('location_cd', $locationCd, TYPE_STR);
                    $SQLBind[] = array('location_name', $locationName, TYPE_STR);
                    $SQLBind[] = array('location_oya_cd', $locationOyaCd, TYPE_STR);
                    $SQLBind[] = array('structure_level', $structureLevel, TYPE_INT);
                    // データ処理開始
                    $master->InsertMasterData($SQLBind, $locationCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
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
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($resultMsg, 'UTF-8', 'UTF-8');
        $resultData[] = mb_convert_encoding($resultVal, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}
