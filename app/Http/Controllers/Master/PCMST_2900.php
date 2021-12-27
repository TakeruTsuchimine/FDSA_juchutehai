<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_2900 extends Controller
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
            select s.id
                  ,s.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,s.shift_cd
                  ,s.shift_name
                  ,substr(to_char(floor(s.start_jikoku / 60)+100, '999'),3,2) || ':' || substr(to_char(mod(s.start_jikoku,  60)+100, '999'),3,2)  start_jikoku
                  ,substr(to_char(floor(s.end_jikoku_tsujou / 60)+100, '999'),3,2) || ':' || substr(to_char(mod(s.end_jikoku_tsujou,  60)+100, '999'),3,2)  end_jikoku_tsujou
                  ,substr(to_char(floor(s.end_jikoku_zangyou / 60)+100, '999'),3,2) || ':' || substr(to_char(mod(s.end_jikoku_zangyou,  60)+100, '999'),3,2)  end_jikoku_zangyou
                  ,to_char(s.keika_jikan_tsujou, 'FM9999') keika_jikan_tsujou
                  ,to_char(s.keika_jikan_zangyou, 'FM9999') keika_jikan_zangyou
                  ,to_char(s.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(s.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(s.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(s.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   shift_master s
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_date is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on s.jigyoubu_cd = j.jigyoubu_cd ";

            // SQL条件項目
            $SQLBodyText = "
            where  s.sakujo_date is null
            and    :today <= case when s.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else s.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by s.id ";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from   shift_master s ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // シフトCD
            if (!is_null($request->dataShiftCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and s.shift_cd ilike :shift_cd ";
                // バインドの設定
                $SQLBind[] = array('shift_cd', $query->GetLikeValue($request->dataShiftCd), TYPE_STR);
            }

            // シフト名
            if (!is_null($request->dataShiftName)) {
                // SQL条件文追加
                $SQLBodyText .= " and s.shift_name ilike :shift_name ";
                // バインドの設定
                $SQLBind[] = array('shift_name', $query->GetLikeValue($request->dataShiftName), TYPE_STR);
            }

            // 事業部CD
            if (!is_null($request->dataJigyoubuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and s.jigyoubu_cd ilike :jigyoubu_cd ";
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
                    $dataArray = $dataArray + array('dataShiftCd' => $value['shift_cd']);
                    $dataArray = $dataArray + array('dataShiftName' => $value['shift_name']);
                    $dataArray = $dataArray + array('dataStartJikoku' => $value['start_jikoku']);
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
