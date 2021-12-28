<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCMST_1301 extends Controller
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
        $tableName = 'kaisou_bunrui_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'bunrui_cd');
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

            // 階層レベル
            $kaisouLevel = (int)$request->dataKaisouLevel;
            // POSTデータチェックエラー
            if (is_null($kaisouLevel) || $kaisouLevel === '' || $kaisouLevel > 3 || $kaisouLevel < 1) {
                $resultMsg .= '「' . __('jikaisou_level') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // 分類CD
            $bunruiCd = $request->dataBunruiCd;
            // POSTデータチェックエラー
            if (is_null($bunruiCd) || $bunruiCd === '') {
                $resultMsg .= '「' . __('コード') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // 分類カテゴリーCD
            $bunruiCategoryCd = $request->dataCategoryCd;
            // POSTデータチェックエラー
            if (is_null($bunruiCategoryCd) || $bunruiCategoryCd === '') {
                $resultMsg .= '「' . __('カテゴリー') . '」' . __('が正常に送信されていません。') . '\n';
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
                    $master->DeleteMasterData($bunruiCd, $yukoukikanStartDate, $loginId, $dataId, 'bunrui_category_cd', $bunruiCategoryCd);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // 分類CDは新規登録の際、既に存在する担当者コードの場合はエラー
                    $result = $common -> GetBunruiCdCount($bunruiCategoryCd, $bunruiCd);
                    if ($result > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('コード') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataBunruiCd';
                        $resultFlg = false;
                    }

                    // 分類名
                    $bunruiName = $request->dataBunruiName;

                    // 親分類CD
                    $oyaBunruiCd = is_null($request->dataOyaBunruiCd) ? '' : $request->dataOyaBunruiCd;
                    //
                    // 親分類コードが有効かどうかの判定
                    // 
                    if ($kaisouLevel > 1) // 階層レベルが2以上の場合
                    {
                        // SQLテキストの設定
                        $SQLText  = ' select count(*) ';
                        $SQLText .= ' from ' . $tableName;
                        $SQLText .= " where  sakujo_dt is null
                                      and    :today <= case when yukoukikan_end_date is null
                                                       then '2199-12-31'
                                                       else yukoukikan_end_date end ";
                        $SQLText .= ' and    bunrui_cd      = :oyabunrui_cd 
                                      and    jikaisou_level = :jikaisou_level ';
                        // クエリの設定
                        $query->StartConnect();
                        $query->SetQuery($SQLText, SQL_SELECT);
                        // バインド値のセット
                        $query->SetBindValue(":oyabunrui_cd", $oyaBunruiCd, TYPE_STR);
                        $query->SetBindValue(":jikaisou_level", ($kaisouLevel - 1), TYPE_INT);
                        $query->SetBindValue(":today", date("Y/m/d"), TYPE_DATE);
                        // クエリの実行
                        $result = $query->ExecuteSelect();
                        if ($result < 1) {
                            $resultMsg .= __('指定できない') . '「' . __('親') . __('コード') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataOyaBunruiCd';
                            $resultFlg = false;
                        }
                    }
                    // 追加情報
                    $tsuikajouhou = is_null($request->dataTsuikajouhou) ? '' : $request->dataTsuikajouhou;

                    if (!$resultFlg) throw new Exception($resultMsg);

                    // 有効期間終了の設定
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    // バインドの設定
                    $SQLBind = array();
                    $SQLBind[] = array('bunrui_category_cd', $bunruiCategoryCd, TYPE_STR);
                    $SQLBind[] = array('jikaisou_level', $kaisouLevel, TYPE_INT);
                    $SQLBind[] = array('bunrui_cd', $bunruiCd, TYPE_STR);
                    $SQLBind[] = array('bunrui_name', $bunruiName, TYPE_STR);
                    $SQLBind[] = array('bunrui_oya_cd', $oyaBunruiCd, TYPE_STR);
                    $SQLBind[] = array('tsuikajouhou', $tsuikajouhou, TYPE_STR);
                    // データ処理開始
                    $master->InsertMasterData($SQLBind, $bunruiCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType, 'bunrui_category_cd', $bunruiCategoryCd);
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
