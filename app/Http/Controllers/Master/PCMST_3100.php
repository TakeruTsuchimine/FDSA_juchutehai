<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_3100 extends Controller
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
            select c.id
                  ,c.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,c.taishou_cd
                  ,c.resource_kbn
                  ,c.shift_cd
                  ,c.end_jikoku_tsujou
                  ,c.end_jikoku_zangyou
                  ,c.keika_jikan_tsujou
                  ,c.keika_jikan_zangyou
                  ,to_char(c.taishou_date, 'yyyy/mm/dd') taishou_date
                  ,to_char(c.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(c.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(c.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(c.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   calendar_master c
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_date is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on c.jigyoubu_cd = j.jigyoubu_cd ";

            // SQL条件項目
            $SQLBodyText = "
            where  c.sakujo_date is null
            and    :today <= case when c.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else c.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by c.id ";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from   calendar_master c ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 事業部CD
            if (!is_null($request->dataJigyoubuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and c.jigyoubu_cd ilike :jigyoubu_cd ";
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
                    $dataArray = $dataArray + array('dataResourceKbn' => $value['resource_kbn']);
                    $dataArray = $dataArray + array('dataTaishouCd' => $value['taishou_cd']);
                    $dataArray = $dataArray + array('dataTaishouDate' => $value['taishou_date']);
                    $dataArray = $dataArray + array('dataShiftCd' => $value['shift_cd']);
                    $dataArray = $dataArray + array('dataEndJikokuTsujou' => $value['end_jikoku_tsujou']);
                    $dataArray = $dataArray + array('dataEndJikokuZangyou' => $value['end_jikoku_zangyou']);
                    $dataArray = $dataArray + array('dataKeikaJikanTsujou' => $value['keika_jikan_tsujou']);
                    $dataArray = $dataArray + array('dataKeikaJikanZangyou' => $value['keika_jikan_zangyou']);
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
