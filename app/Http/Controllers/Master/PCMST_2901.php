<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCMST_2901 extends Controller
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
        $tableName = 'shift_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'shift_cd');
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

            // シフトCD
            $shiftCd = $request->dataShiftCd;
            // POSTデータチェックエラー
            if (is_null($shiftCd) || $shiftCd === '') {
                $resultMsg .= '「' . __('shift_cd') . '」' . __('が正常に送信されていません。') . '\n';
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
                    $master->DeleteMasterData($shiftCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // シフトCDは新規登録の際、既に存在するシフトコードの場合はエラー
                    $result = $common->GetCdCount($tableName, 'shift_cd', $shiftCd);
                    if ($result > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('shift_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataShiftCd';
                        $resultFlg = false;
                    }

                    // シフト名
                    $shiftName = $request->dataShiftName;

                    // 開始時刻
                    $startJikoku = $request->dataStartJikoku;

                    // 終了時刻（通常勤務）
                    $endJikokuTsujou = $request->dataEndJikokuTsujou;

                    // 終了時刻（残業）
                    $endJikokuZangyou = $request->dataEndJikokuZangyou;

                    // 指定範囲経過時間（通常勤務）
                    $keikaJikanTsujou = $request->dataKeikaJikanTsujou;

                    // 指定範囲経過時間（残業分）
                    $keikaJikanZangyou = $request->dataKeikaJikanZangyou;

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
                    $SQLBind[] = array('jigyoubu_cd',       $jigyoubuCd,       TYPE_STR);
                    // 追加（真鍋）
                    $SQLBind[] = array('shift_cd',   $shiftCd,   TYPE_STR);
                    $SQLBind[] = array('shift_name', $shiftName, TYPE_STR);
                    // HH:MM --> トータル分　(例 02:30 --> 150)
                    $startJikokuWk = intval((substr($startJikoku, 0, 2))) * 60;
                    $startJikokuWk = $startJikokuWk + intval(substr($startJikoku, 3, 2));
                    $SQLBind[] = array('start_jikoku', $startJikokuWk, TYPE_STR);   //  開始時刻
                    $endJikokuTsujouWk = intval((substr($endJikokuTsujou, 0, 2))) * 60;
                    $endJikokuTsujouWk = $endJikokuTsujouWk + intval(substr($endJikokuTsujou, 3, 2));
                    $SQLBind[] = array('end_jikoku_tsujou', $endJikokuTsujouWk, TYPE_STR);  // 終了時刻（通常勤務）
                    $endJikokuZangyouWk = intval((substr($endJikokuZangyou, 0, 2))) * 60;
                    $endJikokuZangyouWk = $endJikokuZangyouWk + intval(substr($endJikokuZangyou, 3, 2));
                    $SQLBind[] = array('end_jikoku_zangyou', $endJikokuZangyouWk, TYPE_STR);  // 終了時刻（残業）
                    /*if($endJikokuTsujouWk > $startJikokuWk)
                    {
                        $keikaJikanTsujou = $endJikokuTsujouWk - $startJikokuWk;
                    }
                    elseif($endJikokuTsujouWk < $startJikokuWk)
                    {
                        $keikaJikanTsujou = 1440 + ($endJikokuTsujouWk - $startJikokuWk);    // 指定範囲経過時間（通常勤務）
                    }
                    else{
                        $keikaJikanTsujou = 0;
                    }
                    */

                    if ($endJikokuTsujouWk > $startJikokuWk) {
                        $keikaJikanTsujou = $endJikokuTsujouWk - $startJikokuWk;
                    } elseif ($endJikokuZangyouWk < $startJikokuWk) {
                        $keikaJikanZangyou = 1440 + ($endJikokuZangyouWk - $startJikokuWk);    // 指定範囲経過時間（通常勤務）
                    }

                    if ($endJikokuZangyouWk > $startJikokuWk) {
                        $keikaJikanZangyou = $endJikokuZangyouWk - $startJikokuWk;
                    } elseif ($endJikokuZangyouWk < $startJikokuWk) {
                        $keikaJikanZangyou = 0;
                    }
                    $SQLBind[] = array('keika_jikan_tsujou', $keikaJikanTsujou, TYPE_STR);      // 指定範囲経過時間（通常勤務）
                    $SQLBind[] = array('keika_jikan_zangyou', $keikaJikanZangyou, TYPE_STR);    // 指定範囲経過時間（残業分）
                    // データ処理開始
                    $master->InsertMasterData($SQLBind, $shiftCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
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
