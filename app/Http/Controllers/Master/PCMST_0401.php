<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

/**
 * マスターテーブルレコード更新クラス　「担当者マスター」
 */
class PCMST_0401 extends Controller
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
        $tableName = 'tantousha_master';
        /** App\Http\Controllers\Classes\class_Common 共通関数宣言 */
        $common = new class_Common();
        /** App\Http\Controllers\Classes\class_Database データベース接続クラス宣言 */
        $query = new class_Database();
        /** App\Http\Controllers\Classes\class_Master マスタ共通処理クラス宣言 */
        $master = new class_Master($tableName, 'tantousha_cd');
        try {
            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            //
            // 入力値のエラーチェック
            //
            /** int $SQLType トランザクション種別 */
            $SQLType = empty($request->dataSQLType) ? 0 : (int)$request->dataSQLType;
            if ($SQLType < 1)
            {
                $resultMsg .= '「' . __('データ') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }
            /** string $tantoushaCd 担当者CD */
            $tantoushaCd = $request->dataTantoushaCd;
            // POSTデータチェックエラー
            if (is_null($tantoushaCd) || $tantoushaCd === '')
            {
                $resultMsg .= '「' . __('tantousha_cd') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            /** string $yukoukikanStartDate 有効期間（自） */
            $yukoukikanStartDate = $request->dataStartDate;
            // POSTデータチェックエラー
            if (empty($yukoukikanStartDate))
            {
                $resultMsg .= '「' . __('yukoukikan_start_date') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            /** int $loginId 登録者ID */
            $loginId = empty($request->dataLoginId) ? 0 : (int)$request->dataLoginId;

            ///////////////////////////
            // Insert 及び Delete処理 //
            ///////////////////////////
            // トランザクション別処理
            switch ($SQLType)
            {
                ////////////////
                // DELETE処理 //
                ////////////////
                case SQL_DELETE:
                    /** int $dataId レコードID */
                    $dataId = $request->dataId;
                    if (empty($dataId))
                    {
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
                    /** int $cdCount 管理CDの登録数 */
                    $cdCount = $common->GetCdCount($tableName, 'tantousha_cd', $tantoushaCd);
                    if ($cdCount > 0 && $SQLType === SQL_INSERT)
                    {
                        $resultMsg .= __('既に登録されている') . '「' . __('tantousha_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataTantoushaCd';
                        $resultFlg = false;
                    }

                    /** string $tantoushaName 担当者名 */
                    $tantoushaName = $request->dataTantoushaName;

                    /** string $nyushaDate 入社日 */
                    $nyushaDate = $request->dataNyushaDate;

                    /** string $taishokuDate 退職日 */
                    $taishokuDate = $request->dataTaishokuDate;

                    /** int $kengenKbn 権限区分 */
                    $kengenKbn = empty($request->dataKengenKbn) ? 1 : $request->dataKengenKbn;

                    /** string $bushoCd 部署CD */
                    $bushoCd = $request->dataBushoCd;
                    // POSTデータチェックエラー
                    if (is_null($bushoCd) || $bushoCd === '') {
                        $resultMsg .= '「' . __('busho_cd') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    $cdCount = $common->GetCdCount('busho_master', 'busho_cd', $bushoCd);
                    if ($cdCount < 1) {
                        $resultMsg .= __('登録されていない') . '「' . __('busho_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataBushoCd';
                        $resultFlg = false;
                    }

                    /** string $menuGroupCd メニューGRCD */
                    $menuGroupCd = $request->dataMenuGroupCd;
                    // コードが存在しない場合はエラー
                    if (!is_null($menuGroupCd) && $menuGroupCd !== '') {
                        $cdCount = $common->GetCdCount('menu_group_master', 'menu_group_cd', $menuGroupCd);
                        if ($cdCount < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('menu_group_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataMenuGroup';
                            $resultFlg = false;
                        }
                    }

                    /** string $loginPass ログインパスワード */
                    $loginPass = '';
                    if (empty($request->dataLoginPass)) {
                        //
                        $loginPass = $common->GetCurrentPass($tantoushaCd);
                    } else {
                        //
                        $loginPass = password_hash($request->dataLoginPass, PASSWORD_DEFAULT);
                    }

                    // エラーがあった際は処理せずエラーメッセージを表示して終了
                    if (!$resultFlg) throw new Exception($resultMsg);

                    /** string $yukoukikanEndDate 有効期間（至） */
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));

                    // バインドの設定
                    /** array $SQLBind SQLバインド値 */
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
        /** array $resultData 出力データ */
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($resultMsg, 'UTF-8', 'UTF-8');
        $resultData[] = mb_convert_encoding($resultVal, 'UTF-8', 'UTF-8');
        // 処理結果送信
        return $resultData;
    }
}
