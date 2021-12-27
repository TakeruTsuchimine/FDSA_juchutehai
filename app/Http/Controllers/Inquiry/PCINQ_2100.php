<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;

class PCINQ_2100 extends Controller
{
    public function index(Request $request)
    {
        // 処理成功フラグ
        $resultFlg = true;
        // 検索対象テーブル
        $targetTable = 'location_master';
        // 対象CD列
        $targetRowCd = 'location_cd';
        // 対象名称列
        $targetRowName = 'location_name';

        // グリッドデータ用データ格納用変数宣言
        $data;
        // データベース接続宣言
        $query = new class_Database();
        try {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            // SQL選択項目
            $SQLHeadText = " select ".$targetRowCd." , ".$targetRowName." from ".$targetTable;
            // SQL条件項目
            $SQLBodyText = "
            where  sakujo_dt is null
            and    :today >= yukoukikan_start_date
            and    :today <= case when yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else yukoukikan_end_date end ";
            $SQLTailText = " order by ".$targetRowCd;
            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 対象カテゴリー
            if (!is_null($request->dataTargetCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and Structure_level = :target_cd ";
                // バインドの設定
                $SQLBind[] = array('target_cd', $request->dataTargetCd, TYPE_STR);
            }
            // 検索CD
            if (!is_null($request->dataKensakuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and ".$targetRowCd." ilike :kensaku_cd ";
                // バインドの設定
                $SQLBind[] = array('kensaku_cd', $query->GetLikeValue($request->dataKensakuCd), TYPE_STR);
            }
            // 検索名
            if (!is_null($request->dataKensakuName)) {
                // SQL条件文追加
                $SQLBodyText .= " and ".$targetRowName." ilike :kensaku_name ";
                // バインドの設定
                $SQLBind[] = array('kensaku_name', $query->GetLikeValue($request->dataKensakuName), TYPE_STR);
            }
            ///////////////////
            // 送信データ作成 //
            ///////////////////
            //現在年月日
            $nowDate = date("Y-m-d");
            // 対象日
            if (!is_null($request->dataTargetDate)) {
                $nowDate = $request->dataTargetDate;
            }
            // クエリの設定
            $SQLText = $SQLHeadText . $SQLBodyText . $SQLTailText;
            $query->StartConnect();
            $query->SetQuery($SQLText, SQL_SELECT);
            // バインド値のセット
            $SQLBind[] = array('today', $nowDate, TYPE_DATE);
            $query->SetBindArray($SQLBind);
            // クエリの実行
            $result = $query->ExecuteSelect();
            ///////////////////
            // データ取得のみ //
            ///////////////////
            $data = array();
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                $dataArray = array();
                $dataArray = $dataArray + array('dataSentakuCd'   => $value[$targetRowCd]);
                $dataArray = $dataArray + array('dataSentakuName' => $value[$targetRowName]);
                // 1行ずつデータ配列をグリッドデータ用配列に格納
                $data[] = $dataArray;
            }
        } catch (PDOException $e) {
            $resultFlg = false;
            $data =  $e->getMessage();
        } finally {
            $query->CloseQuery();
        }
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}
