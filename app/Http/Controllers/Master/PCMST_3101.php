<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCMST_3101 extends Controller
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
        $tableName = 'calendar_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'taishou_cd');
        try {
            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////

            $dataId = $request->dataId;
            $dataLastId = $request->dataLastId;
            $deleteFlg = $request->deleteFlg;

            if($dataLastId < $dataId){
                $SQLType = 1;
            }
            else{
                $SQLType = 2;
            }

            if($deleteFlg == 1){
                $SQLType = 3;
            }

            // 対象CD
            $taishouCd = $request->dataTaishouCd;
            // POSTデータチェックエラー
            if (is_null($taishouCd) || $taishouCd === '') {
                $resultMsg .= '「' . __('taishou_cd') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // 事業部CD
            $jigyoubuCd = $request->dataJigyoubuCd;
            // POSTデータチェックエラー
            if (is_null($jigyoubuCd) || $jigyoubuCd === '') {
                $resultMsg .= '「' . __('jigyoubu_cd') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // リソース区分
            $resourceKbn = $request->dataResourceKbn;
            // POSTデータチェックエラー
            if (is_null($resourceKbn) || $resourceKbn === '') {
                $resultMsg .= '「' . __('resource_kbn') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // コードが存在しない場合はエラー
            $result = $common->GetCdCount('jigyoubu_master', 'jigyoubu_cd', $jigyoubuCd);
            if ($result < 1) {
                $resultMsg .= __('登録されていない') . '「' . __('jigyoubu_cd') . '」' . __('です。') . '<br>';
                $resultVal[] = 'dataJigyoubuCd';
                $resultFlg = false;
            }

            // 登録者ID
            $loginId = empty($request->dataLoginId) ? 0 : (int)$request->dataLoginId;
            
            // 対象日
            $taishouDate = $request->dataTaishouDate;

            // シフトCD
            $shiftCd = $request->dataShiftCd;

            // 終了時刻（通常勤務）
            $endJikokuTsujou = $request->dataEndJikokuTsujou;

            // 終了時刻（残業）
            $endJikokuZangyou = $request->dataEndJikokuZangyou;

            // 指定範囲経過時間（通常勤務）
            $keikaJikanTsujou = $request->dataKeikaJikanTsujou;

            // 指定範囲経過時間（残業分）
            $keikaJikanZangyou = $request->dataKeikaJikanZangyou;

            $dateMax = $request->dateMax;

            $date = $request->date;

            if($endJikokuTsujou == ''){
                $endJikokuTsujou = 0;
            }
            if($endJikokuZangyou == ''){
                $endJikokuTsujou = 0;
            }
            if($keikaJikanTsujou == ''){
                $keikaJikanTsujou = 0;
            }
            if($keikaJikanZangyou == ''){
                $keikaJikanZangyou = 0;
            }

            if($shiftCd == ''){
                $shiftCd = '@';
            }
            if($shiftCd == '休'){
                $shiftCd = 'H';
            }

            if (!$resultFlg) throw new Exception($resultMsg);

            ////////////////
            // DELETE処理 //
            ////////////////
            switch ($SQLType) {
            case SQL_INSERT:

                ///////////////////
                // 送信データ作成 //
                ///////////////////
                // SQL選択項目
                $SQLHeadText = "
                    insert into 
                    " . $tableName . "( id, 
                                        jigyoubu_cd,
                                        resource_kbn, 
                                        taishou_cd, 
                                        taishou_date, 
                                        shift_cd, 
                                        end_jikoku_tsujou, 
                                        end_jikoku_zangyou, 
                                        keika_jikan_tsujou, 
                                        keika_jikan_zangyou) ";

                // SQL条件項目
                $SQLBodyText = "
                values ("   . $dataId . ",'"
                            . $jigyoubuCd . "',"
                            . $resourceKbn . ",'"
                            . $taishouCd . "','"
                            . $taishouDate . "','"
                            . $shiftCd . "',"
                            . $endJikokuTsujou . ","
                            . $endJikokuZangyou . ","
                            . $keikaJikanTsujou . ","
                            . $keikaJikanZangyou . ")";
                //現在年月日
                //$nowDate = date("Y-m-d");
                // クエリの設定
                $SQLText = ($SQLHeadText . $SQLBodyText);
                $query->StartConnect();
                $query->SetQuery($SQLText, SQL_SELECT);
                // バインド値のセット
                //$SQLBind[] = array('today', $nowDate, TYPE_DATE);
                //$query->SetBindArray($SQLBind);
                // クエリの実行
                $result = $query->ExecuteSelect();

                $resultVal[] = $common->GetMaxId($tableName);
                break;

            case SQL_UPDATE:

                ///////////////////
                // 送信データ作成 //
                ///////////////////
                //現在年月日
                //$nowDate = date("Y-m-d");
                $SQLHeadText = "
                update " . $tableName . " set ";
                $SQLBodyText = "( id, 
                                  jigyoubu_cd,
                                  resource_kbn, 
                                  taishou_cd, 
                                  taishou_date, 
                                  shift_cd, 
                                  end_jikoku_tsujou, 
                                  end_jikoku_zangyou, 
                                  keika_jikan_tsujou, 
                                  keika_jikan_zangyou) = ("
                                  . $dataId . ",'"
                                  . $jigyoubuCd . "',"
                                  . $resourceKbn . ",'"
                                  . $taishouCd . "','"
                                  . $taishouDate . "','"
                                  . $shiftCd . "',"
                                  . $endJikokuTsujou . ","
                                  . $endJikokuZangyou . ","
                                  . $keikaJikanTsujou . ","
                                  . $keikaJikanZangyou . ")";
                $SQLTailText = "where id =" . $dataId;
                // クエリの設定
                $SQLText = ($SQLHeadText . $SQLBodyText . $SQLTailText);
                $query->StartConnect();
                $query->SetQuery($SQLText, SQL_SELECT);
                // バインド値のセット
                //$SQLBind[] = array('today', $nowDate, TYPE_DATE);
                //$query->SetBindArray($SQLBind);
                // クエリの実行
                $result = $query->ExecuteSelect();

                $resultVal[] = $common->GetMaxId($tableName);
                break;

            case SQL_DELETE:

                // SQL選択項目
                $SQLHeadText = "
                delete from " . $tableName;

                // SQL条件項目
                $SQLBodyText = "
                where id = " . $dataId;

                ///////////////////
                // 送信データ作成 //
                ///////////////////
                //現在年月日
                //$nowDate = date("Y-m-d");
                // クエリの設定
                $SQLText = ($SQLHeadText . $SQLBodyText);
                $query->StartConnect();
                $query->SetQuery($SQLText, SQL_SELECT);
                // バインド値のセット
                //$SQLBind[] = array('today', $nowDate, TYPE_DATE);
                //$query->SetBindArray($SQLBind);
                // クエリの実行
                $result = $query->ExecuteSelect();

                $resultVal[] = $common->GetMaxId($tableName);

                break;
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $resultMsg = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        } finally {
            $query -> CloseQuery();
        }
        
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($resultMsg, 'UTF-8', 'UTF-8');
        $resultData[] = mb_convert_encoding($resultVal, 'UTF-8', 'UTF-8');
        $resultData[] = mb_convert_encoding($dateMax, 'UTF-8', 'UTF-8');
        $resultData[] = mb_convert_encoding($date, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}
