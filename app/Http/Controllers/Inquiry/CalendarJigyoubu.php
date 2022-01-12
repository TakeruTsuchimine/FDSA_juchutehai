<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class CalendarJigyoubu extends Controller
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
            select j.id
                  ,j.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,j.jigyoubu_oya_cd
                  ,cast(cast(j.jigyoubu_oya_kbn as character varying) as integer) jigyoubu_oya_kbn
                  ,to_char(j.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(j.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(j.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(j.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   jigyoubu_master j";

            // SQL条件項目
            $SQLBodyText = "
            where  j.sakujo_dt is null
            and    j.jigyoubu_oya_kbn = 1
            and    :today <= case when j.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else j.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by j.id ";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from   jigyoubu_master j ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////

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
                    $dataArray = array(
                        'dataId' => $value['id'],
                        'dataSentakuCd' => $value['jigyoubu_cd'],
                        'dataSentakuName' => $value['jigyoubu_name'],
                        'dataJigyoubuOyaCd' => $value['jigyoubu_oya_cd'],
                        'dataJigyoubuOyaKbn' => $value['jigyoubu_oya_kbn'],
                        'dataStartDate' => $value['yukoukikan_start_date'],
                        'dataEndDate' => $value['yukoukikan_end_date'],
                        'dataTourokuDt' => $value['touroku_dt'],
                        'dataKoushinDt' => $value['koushin_dt']
                    );

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
        $jigyoubuCd = '事業部CD';
        $jigyoubuName = '事業部名';
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        $resultData[] = mb_convert_encoding($jigyoubuCd, 'UTF-8', 'UTF-8');
        $resultData[] = mb_convert_encoding($jigyoubuName, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}
