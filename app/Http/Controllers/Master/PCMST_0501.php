<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCMST_0501 extends Controller
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
        $tableName = 'sagyosha_kouho_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'waritsukekouho_cd');
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

            // 割付CD
            $waritsukekouhoCd = $request -> dataWaritsukekouhoCd;
            // POSTデータチェックエラー
            if(is_null($waritsukekouhoCd) || $waritsukekouhoCd === ''){
                $resultMsg .= '「'.__('waritsukekouho_cd').'」'.__('が正常に送信されていません。').'\n';
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
            $master->DeleteMasterData($waritsukekouhoCd, $yukoukikanStartDate, $loginId, $dataId);
            break;
            // DELETE処理終了 //

            ////////////////
            // INSERT処理 //
            ////////////////
            default:
            // 担当者CDは新規登録の際、既に存在する担当者コードの場合はエラー
            $result = $common->GetCdCount($tableName, 'waritsukekouho_cd', $waritsukekouhoCd);

            $dataHantei = $request -> dataHantei;
            // 割付の場合、複数登録の回避用
            if($dataHantei=0){
                if($result > 0 && $SQLType === SQL_INSERT){ 
                    $resultMsg .= __('既に登録されている').'「'.__('waritsukekouho_cd').'」'.__('です。').'<br>';
                    $resultVal[] = 'dataWaritsukekouhoCd';
                    $resultFlg = false;
                }
            }

                // 割付名
            $waritsukekouhoName = $request -> dataWaritsukekouhoName;
        
            // 事業部CD
            $jigyoubuCd = $request -> dataJigyoubuCd;
            // POSTデータチェックエラー
            if(is_null($jigyoubuCd) || $jigyoubuCd === ''){
                $resultMsg .= '「'.__('jigyoubu_cd').'」'.__('が正常に送信されていません。').'<br>';
                $resultFlg = false;
            }
            /*
            // コードが存在しない場合はエラー
            $result = $common -> GetCdCount('jigyoubu_master', 'jigyoubu_cd', $jigyoubuCd);
            if($result < 1){
                $resultMsg .= __('登録されていない').'「'.__('jigyoubu_cd').'」'.__('です。').'<br>';
                $resultVal[] = 'dataJigyoubuCd';
                $resultFlg = false;
            }*/
        
            // 担当者CD
            $tantoushaCd = $request -> dataTantoushaCd;
            // POSTデータチェックエラー
            if(is_null($tantoushaCd) || $tantoushaCd === '')
            {
                $resultMsg .= '「'.__('tantousha_cd').'」'.__('が正常に送信されていません。').'<br>';
                $resultFlg = false;
            }
            // コードが存在しない場合はエラー
            $result = $common -> GetCdCount('tantousha_master', 'tantousha_cd', $tantoushaCd);
            if($result < 1)
            {
                $resultMsg .= __('登録されていない').'「'.__('tantousha_cd').'」'.__('です。').'<br>';
                $resultVal[] = 'dataTantoushaCd';
                $resultFlg = false;
            }
        
            // サブNO
            $subNo = $request -> dataSubNo;
                        
            // 説明文CD
            $setsumeibun = $request -> dataSetsumeibun;

            // 担当者ID
            $tantoushaId = $request -> dataTantoushaId;

            // 加工スキル     
            $kakouSkill = $request -> dataKakouSkill;

            // 加工入力係数
            $kakounouryoku_keisu = $request -> dataKakounouryoku_keisu;

            if (!$resultFlg) throw new Exception($resultMsg);

            // 有効期間終了の設定
            $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
            // バインドの設定
            $SQLBind = array();
            $SQLBind[] = array('jigyoubu_cd',          $jigyoubuCd,          TYPE_STR);
            $SQLBind[] = array('waritsukekouho_cd',    $waritsukekouhoCd,    TYPE_STR);
            $SQLBind[] = array('sub_seq',              $subNo,               TYPE_INT);
            $SQLBind[] = array('waritsukekouho_name',  $waritsukekouhoName,  TYPE_STR);
            $SQLBind[] = array('setsumeibun',          $setsumeibun,         TYPE_STR);
            $SQLBind[] = array('tantousha_id',         $tantoushaId,          TYPE_STR);
            $SQLBind[] = array('tantousha_cd',         $tantoushaCd,         TYPE_STR);
            $SQLBind[] = array('kakou_skill',          $kakouSkill,          TYPE_STR);
            $SQLBind[] = array('kakou_nouryoku_keisu', $kakounouryoku_keisu, TYPE_STR);
            // データ処理開始
            $master->InsertMasterData($SQLBind, $waritsukekouhoCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
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
