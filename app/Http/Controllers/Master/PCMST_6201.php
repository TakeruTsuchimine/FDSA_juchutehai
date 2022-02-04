<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCMST_6201 extends Controller
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
        $tableName = 'menu_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'menu_group_cd');
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

            // メニューグループCD
            $menuGroupCd = $request->dataMenuGroupCd;
            // POSTデータチェックエラー
            if (is_null($menuGroupCd) || $menuGroupCd === '') {
                $resultMsg .= '「' . __('menu_group_cd') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // メニュータイトル
            $menuTitle = $request->dataMenuTitle;
            // POSTデータチェックエラー
            if (is_null($menuTitle) || $menuTitle === '') {
                $resultMsg .= '「' . __('menu_title') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // メニュー機能URL
            $menuTitleUrl = $request->dataMenuTitleUrl;
            // POSTデータチェックエラー
            if (is_null($menuTitleUrl) || $menuTitleUrl === '') {
                $resultMsg .= '「' . __('menu_title_url') . '」' . __('が正常に送信されていません。') . '\n';
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
                    $master->DeleteMasterData($menuGroupCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // メニューグループCDは新規登録の際、既に存在するメニューグループCDの場合はエラー
                    $result = $common->GetCdCount($tableName, 'menu_group_cd', $menuGroupCd);
                    if ($result > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('menu_group_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataMenuGroupCd';
                        $resultFlg = false;
                    }

                    // メニュータイトルは新規登録の際、既に存在するメニュータイトルの場合はエラー
                    $result = $common->GetCdCount($tableName, 'menu_title', $menuTitle);
                    if ($result > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('menu_title') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataMenuTitle';
                        $resultFlg = false;
                    }

                    // メニュー機能URLは新規登録の際、既に存在するメニュー機能URLの場合はエラー
                    $result = $common->GetCdCount($tableName, 'menu_title_url', $menuTitleUrl);
                    if ($result > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('menu_title_url') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataMenuTitleUrl';
                        $resultFlg = false;
                    }

                    // メニューグループSEQNO
                    $menuGroupSeqno = $request->dataMenuGroupSeqno;

                    // メニューSEQNO
                    $menuSeqno = $request->dataMenuSeqno;

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
                    $SQLBind[] = array('menu_group_cd', $menuGroupCd, TYPE_STR);
                    $SQLBind[] = array('menu_group_seqno', $menuGroupSeqno, TYPE_INT);
                    $SQLBind[] = array('menu_seqno', $menuSeqno, TYPE_INT);
                    $SQLBind[] = array('menu_title', $menuTitle, TYPE_STR);
                    $SQLBind[] = array('menu_title_url', $menuTitleUrl, TYPE_STR);
                    // データ処理開始
                    $master->InsertMasterData($SQLBind, $menuGroupCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
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
