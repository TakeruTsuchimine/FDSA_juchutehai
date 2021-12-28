<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_2100 extends Controller
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
            select l.id
                  ,l.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,l.location_cd
                  ,l.location_name
                  ,l.oya_location_cd
                  ,cast(cast(l.structure_level as character varying) as integer) structure_level
                  ,to_char(l.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(l.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(l.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(l.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   location_master l
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_date is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on l.jigyoubu_cd = j.jigyoubu_cd ";

            // SQL条件項目
            $SQLBodyText = "
            where  l.sakujo_date is null
            and    :today <= case when l.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else l.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by l.id ";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from   location_master l ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 置場・棚番CD
            if (!is_null($request->dataLocationCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and l.location_cd ilike :location_cd ";
                // バインドの設定
                $SQLBind[] = array('location_cd', $query->GetLikeValue($request->dataLocationCd), TYPE_STR);
            }

            // 置場・棚番名
            if (!is_null($request->dataLocationName)) {
                // SQL条件文追加
                $SQLBodyText .= " and l.location_name ilike :location_name ";
                // バインドの設定
                $SQLBind[] = array('location_name', $query->GetLikeValue($request->dataLocationName), TYPE_STR);
            }

            // 棚番親置場CD
            if (!is_null($request->dataOyaLocationCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and l.oya_location_cd ilike :oya_location_cd ";
                // バインドの設定
                $SQLBind[] = array('oya_location_cd', $query->GetLikeValue($request->dataOyaLocationCd), TYPE_STR);
            }

            // 事業部CD
            if (!is_null($request->dataJigyoubuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and l.jigyoubu_cd ilike :jigyoubu_cd ";
                // バインドの設定
                $SQLBind[] = array('jigyoubu_cd', $query->GetLikeValue($request->dataJigyoubuCd), TYPE_STR);
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
                    $dataArray = $dataArray + array('dataId' => $value['id']);
                    $dataArray = $dataArray + array('dataJigyoubuCd' => $value['jigyoubu_cd']);
                    $dataArray = $dataArray + array('dataJigyoubuName' => $value['jigyoubu_name']);
                    $dataArray = $dataArray + array('dataLocationCd' => $value['location_cd']);
                    $dataArray = $dataArray + array('dataLocationName' => $value['location_name']);
                    $dataArray = $dataArray + array('dataOyaLocationCd' => $value['oya_location_cd']);
                    $dataArray = $dataArray + array('dataStructureLevel' => $value['structure_level']);
                    $dataArray = $dataArray + array('dataStartDate' => $value['yukoukikan_start_date']);
                    $dataArray = $dataArray + array('dataEndDate' => $value['yukoukikan_end_date']);
                    $dataArray = $dataArray + array('dataTourokuDt' => $value['touroku_dt']);
                    $dataArray = $dataArray + array('dataKoushinDt' => $value['koushin_dt']);
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
