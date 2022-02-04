<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class CalendarBusho extends Controller
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
            select b.id
                  ,b.busho_cd
                  ,b.busho_name
                  ,b.busho_ryaku_name
                  ,b.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,j.jigyoubu_oya_cd
                  ,b.seikyu_cd
                  ,s.seikyu_busho_name
                  ,b.keiri_cd
                  ,b.hyouji_seq
                  ,b.shukei_no
                  ,to_char(b.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(b.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(b.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(b.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   busho_master b
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                              ,jigyoubu_oya_cd
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on b.jigyoubu_cd = j.jigyoubu_cd
            left join ( select seikyu_cd
                              ,seikyu_busho_name
                        from   seikyu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) s
              on b.seikyu_cd = s.seikyu_cd";

            // SQL条件項目
            $SQLBodyText = "
            where  b.sakujo_dt is null
            and    :today <= case when b.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else b.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by b.id ";

            // SQLバインド値
            $SQLBind = array();



            ///////////////////
            // 送信データ作成 //
            ///////////////////
            //現在年月日
            $nowDate = date("Y-m-d");
            // クエリの設定
            $SQLText = $SQLHeadText . $SQLBodyText . $SQLTailText;
            $query->StartConnect();
            $query->SetQuery($SQLText, SQL_SELECT);
            // バインド値のセット
            $SQLBind[] = array('today', $nowDate, TYPE_DATE);
            $query->SetBindArray($SQLBind);
            // クエリの実行
            $result = $query->ExecuteSelect();
            // データ取得条件別処理
            $cntFlg = false;
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
                        'dataSentakuCd' => $value['busho_cd'],
                        'dataSentakuName' => $value['busho_name'],
                        'dataBushoRyakuName' => $value['busho_ryaku_name'],
                        'dataJigyoubuCd(k)' => $value['jigyoubu_cd'],
                        'dataJigyoubuCd' => $value['jigyoubu_oya_cd'],
                        'dataJigyoubuName' => $value['jigyoubu_name'],
                        'dataSeikyuCd' => $value['seikyu_cd'],
                        'dataSeikyuBushoName' => $value['seikyu_busho_name'],
                        'dataKeiriCd' => $value['keiri_cd'],
                        'dataHyoujiSeq' => $value['hyouji_seq'],
                        'dataShukeiNo' => $value['shukei_no'],
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
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}
