<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCMST_2701 extends Controller
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
        $tableName = 'hinmoku_shiiretanka_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'hinmoku_cd');
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

            // 品目CD
            $hinmokuCd = $request->dataHinmokuCd;
            // POSTデータチェックエラー
            if (is_null($hinmokuCd) || $hinmokuCd === '') {
                $resultMsg .= '「' . __('hinmoku_cd') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // 仕入外注先CD
            $shiiresakiCd = $request->dataShiiresakiCd;
            // POSTデータチェックエラー
            if (is_null($shiiresakiCd) || $shiiresakiCd === '') {
                $resultMsg .= '「' . __('shiiresaki_cd') . '」' . __('が正常に送信されていません。') . '\n';
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
                    $master->DeleteMasterData($hinmokuCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // 品目CDは新規登録の際、既に存在する品目コードの場合はエラー
                    $result = $common->GetCdCount($tableName, 'hinmoku_cd', $hinmokuCd);
                    if ($result > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('hinmoku_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataHinmokuCd';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    if ($result < 1) {
                        $resultMsg .= __('登録されていない') . '「' . __('hinmoku_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataHinmokuCd';
                        $resultFlg = false;
                    }

                    // 仕入外注先CDは新規登録の際、既に存在する仕入外注先コードの場合はエラー
                    $result = $common->GetCdCount($tableName, 'shiiresaki_cd', $shiiresakiCd);
                    if ($result > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('shiiresaki_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataShiiresakiCd';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    if ($result < 1) {
                        $resultMsg .= __('登録されていない') . '「' . __('shiiresaki_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataShiiresakiCd';
                        $resultFlg = false;
                    }

                    // 適用日付
                    $tekiyouDate = $request->dataTekiyouDate;

                    // 適用最小量（発注単位数）
                    $tekiyouSaishouQty = $request->dataTekiyouSaishouQty;

                    // 消費税区分
                    $shouhizeiKbn = empty((int)$request->dataShouhizeiKbn) ? 0 : (int)$request->dataShouhizeiKbn;

                    // 軽減税率提供区分
                    $keigenzeiritsuKbn = empty((int)$request->dataKeigenzeiritsuKbn) ? 0 : (int)$request->dataKeigenzeiritsuKbn;

                    // 仕入単価
                    $shiireTanka = $request->dataShiireTanka;

                    // 旧単価
                    $kyuTanka = $request->dataKyuTanka;

                    // 仮区分
                    $kariKbn = empty((int)$request->dataKariKbn) ? 0 : (int)$request->dataKariKbn;

                    // 未処理区分
                    $mishoriKbn = empty((int)$request->dataMishoriKbn) ? 0 : (int)$request->dataMishoriKbn;

                    // 備考
                    $bikou = $request->dataBikou;

                    if (!$resultFlg) throw new Exception($resultMsg);

                    // 有効期間終了の設定
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    // バインドの設定
                    $SQLBind = array();
                    $SQLBind[] = array('shiiresaki_cd', $shiiresakiCd, TYPE_STR);
                    $SQLBind[] = array('hinmoku_cd', $hinmokuCd, TYPE_STR);
                    $SQLBind[] = array('tekiyou_date', $tekiyouDate, TYPE_DATE);
                    $SQLBind[] = array('tekiyou_saishou_qty', $tekiyouSaishouQty, TYPE_INT);
                    $SQLBind[] = array('shouhizei_kbn', $shouhizeiKbn, TYPE_INT);
                    $SQLBind[] = array('keigenzeiritsu_kbn', $keigenzeiritsuKbn, TYPE_INT);
                    $SQLBind[] = array('shiire_tanka', $shiireTanka, TYPE_INT);
                    $SQLBind[] = array('kyu_tanka', $kyuTanka, TYPE_INT);
                    $SQLBind[] = array('kari_kbn', $kariKbn, TYPE_INT);
                    $SQLBind[] = array('mishori_kbn', $mishoriKbn, TYPE_INT);
                    $SQLBind[] = array('bikou', $bikou, TYPE_STR);
                    // データ処理開始
                    $master->InsertMasterData($SQLBind, $hinmokuCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
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
