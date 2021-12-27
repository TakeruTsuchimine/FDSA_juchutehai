<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_2000 extends Controller
{
    public function index(Request $request)
    {
        // 処理成功フラグ
        $resultFlg = true;
        // グリッドデータ用データ格納用変数宣言
        $data;
        // データベース接続宣言
        $query = new class_Database();
        try {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            // SQL選択項目
            $SQLHeadText = "
            select m.id 
                ,m.maker_cd 
                ,m.maker_ryaku 
                ,m.maker_name 
                ,to_char(m.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                ,to_char(m.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                ,to_char(m.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                ,to_char(m.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from  maker_master m  ";

            // SQL条件項目
            $SQLBodyText = "
            where  m.sakujo_date is null
            and    :today <= case when m.yukoukikan_end_date is null
                                then '2199-12-31' else m.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by m.id ";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from maker_master m ";

            // SQLバインド値
            $SQLBind = array();
            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // メーカーCD
            if(!is_null($request -> makerCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and m.maker_cd ilike :maker_cd ";
                // バインドの設定
                $SQLBind[] = array('maker_cd', $query -> GetLikeValue($request -> dataMakerCd), TYPE_STR);
            }

            // メーカー名
            if(!is_null($request -> makerName))
            {
                // SQL条件文追加
                $SQLBodyText .= " and m.maker_name ilike :maker_name ";
                // バインドの設定
                $SQLBind[] = array('maker_name', $query -> GetLikeValue($request -> dataMakerName), TYPE_STR);
            }

            // 検索件数取得フラグ
            $cntFlg = false;
            if (!is_null($request->dataCntFlg)) $cntFlg = (bool)$request->dataCntFlg;

            ///////////////////    
            // 送信データ作成 //
            ///////////////////
            //現在年月日
            $nowDate = date("Y-m-d");
            // クエリの設定
            $SQLText = ($cntFlg ? $SQLCntText . $SQLBodyText : $SQLHeadText . $SQLBodyText . $SQLTailText);
            $query->StartConnect();
            $query->SetQuery($SQLText, SQL_SELECT);
            // バインド値のセット
            $SQLBind[] = array('today', $nowDate, TYPE_DATE);
            $query->SetBindArray($SQLBind);
            // クエリの実行
            $result = $query->ExecuteSelect();
            // データ取得条件別処理
            if ($cntFlg) {
                /////////////////
                // 件数取得のみ //
                /////////////////
                $data = $result[0][0];
            } else {
                ///////////////////
                // データ取得のみ //
                ///////////////////
                $data = array();
                // 配列番号
                $index = 0;
                // 結果データの格納
                foreach ($result as $value) {
                    // JSONオブジェクト用に配列に名前を付けてデータ格納
                    $dataArray = array();
                    $dataArray = $dataArray + array( 'dataId' => $value['id'] );
                    $dataArray = $dataArray + array( 'dataMakerCd' => $value['maker_cd'] );
                    $dataArray = $dataArray + array( 'dataMakerRyaku' => $value['maker_ryaku'] );
                    $dataArray = $dataArray + array( 'dataMakerName' => $value['maker_name'] );
                    $dataArray = $dataArray + array( 'dataStartDate'     => $value['yukoukikan_start_date'] );
                    $dataArray = $dataArray + array( 'dataEndDate'       => $value['yukoukikan_end_date'] );
                    $dataArray = $dataArray + array( 'dataTourokuDt'     => $value['touroku_dt'] );
                    $dataArray = $dataArray + array( 'dataKoushinDt'     => $value['koushin_dt'] );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $data[] = $dataArray;
                    // 配列番号を進める
                    $index = $index + 1;
                }
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $data = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
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
