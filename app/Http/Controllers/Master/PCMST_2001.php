<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCMST_2001 extends Controller
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
        $tableName = 'maker_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common(); 
        // データベース接続宣言
        $query = new class_Database();
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'maker_cd');
        try {
            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            //
            // 入力値のエラーチェック
            //
            // トランザクション種別
            $SQLType = empty($request -> dataSQLType) ? 0 : (int)$request -> dataSQLType;
            if($SQLType < 1){
                $resultMsg .= '「'.__('データ').'」'.__('が正常に送信されていません。').'\n';
                $resultFlg = false;
            }

            // メーカーCD
            $makerCd = $request -> dataMakerCd;
            if(is_null($makerCd) || $makerCd === ''){
                $resultMsg .= '「'.__('maker_cd').'」'.__('が正常に送信されていません。').'\n';
                $resultFlg = false;
            }

            // 有効期間（自）
            $yukoukikanStartDate = $request -> dataStartDate;
            if(empty($yukoukikanStartDate))
            {
                $resultMsg .= '「'.__('yukoukikan_start_date').'」'.__('が正常に送信されていません。').'\n';
                $resultFlg = false;
            }

            // 登録者ID
            $loginId = empty($request -> dataLoginId) ? 0 : (int)$request -> dataLoginId;

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
                        $master->DeleteMasterData($makerCd, $yukoukikanStartDate, $loginId, $dataId);
                        break;
                        // DELETE処理終了 //
    
                        ////////////////
                        // INSERT処理 //
                        ////////////////
                default:
                    // メーカーCDは新規登録の際、既に存在するメーカーCDの場合はエラー
                    $result = $common -> GetCdCount($tableName, 'maker_cd', $makerCd);
                    if($result > 0 && $SQLType === SQL_INSERT){
                        $resultMsg .= __('既に登録されている').'「'.__('maker_cd').'」'.__('です。').'<br>';
                        $resultVal[] = 'dataMakerCd';
                        $resultFlg = false;
                    }
                    // 略称
                    $makerRyaku = $request -> dataMakerRyaku;
                    // メーカー名
                    $makerName = $request -> dataMakerName;
                    
                    if (!$resultFlg) throw new Exception($resultMsg);

                    // 有効期間終了の設定
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    // バインドの設定
                    $SQLBind = array();
                    $SQLBind[] = array('maker_cd',       $makerCd, TYPE_STR);
                    $SQLBind[] = array('maker_ryaku',       $makerRyaku, TYPE_STR);
                    $SQLBind[] = array('maker_name',       $makerName, TYPE_STR);
                    // データ処理開始
                    $master -> InsertMasterData($SQLBind, $makerCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
                    $resultVal[] = $common -> GetMaxId($tableName);
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
