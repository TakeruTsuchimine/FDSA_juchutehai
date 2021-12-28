<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCMST_0401 extends Controller
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
        $tableName = 'tantousha_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'tantousha_cd');
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

            // 担当者CD
            $tantoushaCd = $request->dataTantoushaCd;
            // POSTデータチェックエラー
            if (is_null($tantoushaCd) || $tantoushaCd === '') {
                $resultMsg .= '「' . __('tantousha_cd') . '」' . __('が正常に送信されていません。') . '\n';
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
                    $master->DeleteMasterData($tantoushaCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // 担当者CDは新規登録の際、既に存在する担当者コードの場合はエラー
                    $result = $common->GetCdCount($tableName, 'tantousha_cd', $tantoushaCd);
                    if ($result > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('tantousha_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataTantoushaCd';
                        $resultFlg = false;
                    }

                    // 担当者名
                    $tantoushaName = $request->dataTantoushaName;

                    // 入社日
                    $nyushaDate = $request->dataNyushaDate;

                    // 退社日
                    $taishokuDate = $request->dataTaishokuDate;

                    // 権限区分
                    $kengenKbn = empty($request->dataKengenKbn) ? 1 : $request->dataKengenKbn;

                    // 部署CD
                    $bushoCd = $request->dataBushoCd;
                    // POSTデータチェックエラー
                    if (is_null($bushoCd) || $bushoCd === '') {
                        $resultMsg .= '「' . __('busho_cd') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    $result = $common->GetCdCount('busho_master', 'busho_cd', $bushoCd);
                    if ($result < 1) {
                        $resultMsg .= __('登録されていない') . '「' . __('busho_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataBushoCd';
                        $resultFlg = false;
                    }

                    // メニューGRCD
                    $menuGroupCd = $request->dataMenuGroupCd;
                    // コードが存在しない場合はエラー
                    if (!is_null($menuGroupCd) && $menuGroupCd !== '') {
                        $result = $common->GetCdCount('menu_group_master', 'menu_group_cd', $menuGroupCd);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('menu_group_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataMenuGroup';
                            $resultFlg = false;
                        }
                    }

                    // ログインパスワード
                    $loginPass = '';
                    if (empty($request->dataLoginPass)) {
                        //
                        $loginPass = $common->GetCurrentPass($tantoushaCd);
                    } else {
                        //
                        $loginPass = password_hash($request->dataLoginPass, PASSWORD_DEFAULT);
                    }

                    if (!$resultFlg) throw new Exception($resultMsg);

                    // 有効期間終了の設定
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    // バインドの設定
                    $SQLBind = array();
                    $SQLBind[] = array('busho_cd', $bushoCd, TYPE_STR);
                    $SQLBind[] = array('tantousha_cd', $tantoushaCd, TYPE_STR);
                    $SQLBind[] = array('tantousha_name', $tantoushaName, TYPE_STR);
                    $SQLBind[] = array('login_pass', $loginPass, TYPE_STR);
                    $SQLBind[] = array('kengen_kbn', $kengenKbn, TYPE_INT);
                    $SQLBind[] = array('menu_group_cd', $menuGroupCd, TYPE_STR);
                    $SQLBind[] = array('nyusha_date', $nyushaDate, TYPE_DATE);
                    $SQLBind[] = array('taishoku_date', $taishokuDate, TYPE_DATE);
                    // データ処理開始
                    $master->InsertMasterData($SQLBind, $tantoushaCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
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
