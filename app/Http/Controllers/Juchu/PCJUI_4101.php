<?php

namespace App\Http\Controllers\Juchu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use App\Http\Controllers\Classes\class_Juchu;
use Exception;

use Log;

class PCJUI_4101 extends Controller
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
        $tableName = 'juchu_tehaiirai_data';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        // // マスタ共通処理クラス宣言
        // $master = new class_Master($tableName, 'juchu_no');
        // 受注共通処理クラス宣言
        $juchu = new class_Juchu($tableName, 'juchu_no');
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

            // 受注No.
            $juchuNo = $request->dataJuchuNo;
            // POSTデータチェックエラー
            if (is_null($juchuNo) || $juchuNo === '') {
                $resultMsg .= '「' . __('juchu_no') . '」' . __('が正常に送信されていません。') . '\n';
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
                // case SQL_DELETE:
                //     // レコードID
                //     $dataId = $request->dataId;
                //     if (empty($dataId)) {
                //         $resultMsg .= '「' . __('ID') . '」' . __('が正常に送信されていません。') . '<br>';
                //         $resultFlg = false;
                //     }
                //     // データ処理開始
                //     $master->DeleteMasterData($juchuNo, '', $loginId, $dataId);
                //     break;
                // DELETE処理終了 //

                ////////////////
                // INSERT処理 //
                ////////////////
                default:
                    // 手配回数

                    $tehaiKaisu = $juchu->GetTehaiCount($juchuNo);
                    // die("$tehaiKaisu");

                    // 新規リピート区分
                    $shinkiRepeatKbn = $request->dataShinkiRepeatKbn;

                    // 製作振分
                    $seisakuKbn = $request->dataSeisakuKbn;

                    // 手配ステータス
                    $tehaiStatus = $request->dataTehaiStatus;

                    if (!$resultFlg) throw new Exception($resultMsg);

                    // バインドの設定
                    $SQLBind = array();

                    $SQLBind[] = array('juchu_no', $juchuNo, TYPE_STR);
                    $SQLBind[] = array('tehai_kaisu', $tehaiKaisu, TYPE_INT);
                    $SQLBind[] = array('shinki_repeat_kbn', $shinkiRepeatKbn, TYPE_INT);
                    $SQLBind[] = array('seisaku_kbn', $seisakuKbn, TYPE_INT);
                    $SQLBind[] = array('tehai_status', $tehaiStatus, TYPE_INT);

                    // データ処理開始
                    // $master->InsertMasterData($SQLBind, $juchuNo, '1999/12/31', '1999/12/31', $loginId, $SQLType);
                    $juchu->InsertJuchuData($SQLBind, $juchuNo, '1999/12/31', '1999/12/31', $loginId, $SQLType);
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
        Log::debug(print_r($resultData, true));
        return $resultData;
    }
}
