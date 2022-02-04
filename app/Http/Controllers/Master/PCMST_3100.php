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
                  ,c.taishou_cd
                  ,to_char(c.taishou_date, 'yyyy/mm/dd') taishou_date
                  ,c.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,c.shift_cd
                  ,c.resource_kbn
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
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on c.jigyoubu_cd = j.jigyoubu_cd ";

            // SQL条件項目
            $SQLBodyText = "
            where  c.sakujo_dt is null
            and    c.resource_kbn = 0
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

            if(($request->dataResourceKbn) == 0){
                // 事業部CD
                //throw new Exception($request->dataJigyoubuCd,'事業部CD');
                // SQL条件文追加
                $SQLBodyText .= " and c.jigyoubu_cd = :jigyoubu_cd ";
                // バインドの設定
                $SQLBind[] = array('jigyoubu_cd', $request->dataJigyoubuCd, TYPE_STR);
                //throw new Exception($request->dataJigyoubuCd);
                // 対象CD
                //if (!is_null($request->dataTaishouCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and c.taishou_cd = :taishou_cd ";
                // バインドの設定
                $SQLBind[] = array('taishou_cd', $request->dataSentakuCd, TYPE_STR);
                //throw new Exception($request->dataSentakuCd);
                //}
                $taihsouCd = $request->dataSentakuCd;

                $taihsouCdJ = $request->dataJigyoubu2;
            
                $taihsouCdB = $request->dataBusho;
            }
            else{
                // 事業部CD
                //throw new Exception($request->dataJigyoubuCd,'事業部CD');
                // SQL条件文追加
                $SQLBodyText .= " and c.jigyoubu_cd = :jigyoubu_cd ";
                // バインドの設定
                $SQLBind[] = array('jigyoubu_cd', $request->dataJigyoubuCd, TYPE_STR);
                //throw new Exception($request->dataJigyoubuCd);
                // 対象CD
                //if (!is_null($request->dataTaishouCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and c.taishou_cd = :taishou_cd ";
                // バインドの設定
                $SQLBind[] = array('taishou_cd', $request->dataJigyoubuCd2, TYPE_STR);
                //throw new Exception($request->dataSentakuCd);
                //}
                $taihsouCd = $request->dataJigyoubuCd2;

            }

            // リソース区分
            //if (!is_null($request->dataResourceKbn)) {
            // SQL条件文追加
            //$SQLBodyText .= " and c.resource_kbn = :resource_kbn ";
            // バインドの設定
            //$SQLBind[] = array('resource_kbn', $request->dataResourceKbn, TYPE_INT);
            //}

            // 対象日（始）
            //if (!is_null($request->dataTaishouStartDate)) {
            // SQL条件文追加
            $SQLBodyText .= " and c.taishou_date >= :taishou_start_date ";
            $wkStartDate = $request->dataTaishouStartDate;
            //$wkStartDate = date("Y/m/d");

            // バインドの設定
            $SQLBind[] = array('taishou_start_date', $wkStartDate, TYPE_STR);
            //throw new Exception($wkStartDate);
            //}

            // 対象日（終）
            //if (!is_null($request->dataTaishouEndDate)) {
            // SQL条件文追加
            $SQLBodyText .= " and c.taishou_date < :taishou_end_date ";
            $wkEndDate = $request->dataTaishouEndDate;
            //$wkEndDate = date("Y/m/d");

            // バインドの設定
            $SQLBind[] = array('taishou_end_date', $wkEndDate, TYPE_STR);
            //}


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
            // throw new Exception($result,'result');
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

                foreach ($result as $value) {
                    // JSONオブジェクト用に配列に名前を付けてデータ格納
                    //date(j(日付),(対象日))＝対象日の日付を送る
                    $dataArray = array(
                        'dataTaishouDate' => date('j', strtotime($value['taishou_date'])),
                        'dataShiftCd' => $value['shift_cd'],
                        'dataId' => $value['id']
                    );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $data[] = $dataArray;
                }
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $data = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        } finally {
            $query -> CloseQuery();
        }
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
                  ,s.start_jikoku
                  ,s.end_jikoku_tsujou
                  ,s.end_jikoku_zangyou
                  ,s.keika_jikan_tsujou
                  ,s.keika_jikan_zangyou
                  ,to_char(s.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(s.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(s.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(s.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   shift_master s
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on s.jigyoubu_cd = j.jigyoubu_cd ";

            // SQL条件項目
            $SQLBodyText = "
            where  s.sakujo_dt is null
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
                $data2 = $result[0][0];
            } else {
                ///////////////////
                // データ取得のみ //
                ///////////////////
                $data2 = array();
                // 結果データの格納
                foreach ($result as $value) {
                    // JSONオブジェクト用に配列に名前を付けてデータ格納
                    $dataArray = array(
                        'dataId' => $value['id'],
                        'dataJigyoubuCd' => $value['jigyoubu_cd'],
                        'dataJigyoubuName' => $value['jigyoubu_name'],
                        'dataShiftCd' => $value['shift_cd'],
                        'dataShiftName' => $value['shift_name'],
                        'dataStartJikoku' => $value['start_jikoku'],
                        'dataEndJikokuTsujou' => $value['end_jikoku_tsujou'],
                        'dataEndJikokuZangyou' => $value['end_jikoku_zangyou'],
                        'dataKeikaJikanTsujou' => $value['keika_jikan_tsujou'],
                        'dataKeikaJikanZangyou' => $value['keika_jikan_zangyou'],
                        'dataStartDate' => $value['yukoukikan_start_date'],
                        'dataEndDate' => $value['yukoukikan_end_date'],
                        'dataTourokuDt' => $value['touroku_dt'],
                        'dataKoushinDt' => $value['koushin_dt']
                    );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $data2[] = $dataArray;
                }
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $data2 = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        } finally {
            $query->CloseQuery();
        }
        try {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            // SQL選択項目
            $SQLHeadText = "
            select c.id
                  ,c.taishou_cd
                  ,to_char(c.taishou_date, 'yyyy/mm/dd') taishou_date
                  ,c.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,c.shift_cd
                  ,c.end_jikoku_tsujou
                  ,c.end_jikoku_zangyou
                  ,c.keika_jikan_tsujou
                  ,c.keika_jikan_zangyou
                  ,to_char(c.taishou_date, 'yyyy/mm/dd') taishou_date
                  ,c.resource_kbn
                  ,c.end_jikoku_tsujou
                  ,c.end_jikoku_zangyou
                  ,c.keika_jikan_tsujou
                  ,c.keika_jikan_zangyou
                  ,to_char(c.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(c.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(c.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(c.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   calendar_master c
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on c.jigyoubu_cd = j.jigyoubu_cd ";

            // SQL条件項目
            $SQLBodyText = "
            where  c.sakujo_dt is null
            and    c.resource_kbn = 1
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

            if(($request->dataResourceKbn) == 1){
                // 事業部CD
                if (!is_null($request->dataJigyoubuCd)) {
                //throw new Exception($request->dataJigyoubuCd,'事業部CD');
                // SQL条件文追加
                $SQLBodyText .= " and c.jigyoubu_cd = :jigyoubu_cd ";
                // バインドの設定
                $SQLBind[] = array('jigyoubu_cd', $request->dataJigyoubuCd, TYPE_STR);
                //throw new Exception($request->dataJigyoubuCd);
                }
                // 対象CD
                //if (!is_null($request->dataTaishouCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and c.taishou_cd = :taishou_cd ";
                // バインドの設定
                $SQLBind[] = array('taishou_cd', $request->dataSentakuCd, TYPE_STR);
                //throw new Exception($request->dataSentakuCd);
                //}
                $taihsouCd = $request->dataSentakuCd;

                $taihsouCdJ = $request->dataJigyoubu2;
            
                $taihsouCdB = $request->dataBusho;
            }
            else{
                // 事業部CD
                if (!is_null($request->dataJigyoubuCd)) {
                    //throw new Exception($request->dataJigyoubuCd,'事業部CD');
                    // SQL条件文追加
                    $SQLBodyText .= " and c.jigyoubu_cd = :jigyoubu_cd ";
                    // バインドの設定
                    $SQLBind[] = array('jigyoubu_cd', $request->dataJigyoubuCd, TYPE_STR);
                    //throw new Exception($request->dataJigyoubuCd);
                }
                // 対象CD
                //if (!is_null($request->dataTaishouCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and c.taishou_cd = :taishou_cd ";
                // バインドの設定
                $SQLBind[] = array('taishou_cd', $request->dataBushoCd, TYPE_STR);
                //throw new Exception($request->dataSentakuCd);
                $taihsouCd = $request->dataBushoCd;
                //}
            }
            //throw new Exception($request->dataSentakuCd);
            //}

            // 対象日（始）
            //if (!is_null($request->dataTaishouStartDate)) {
            // SQL条件文追加
            $SQLBodyText .= " and c.taishou_date >= :taishou_start_date ";
            $wkStartDate = $request->dataTaishouStartDate;
            //$wkStartDate = date("Y/m/d");

            // バインドの設定
            $SQLBind[] = array('taishou_start_date', $wkStartDate, TYPE_STR);
            //throw new Exception($wkStartDate);
            //}

            // 対象日（終）
            //if (!is_null($request->dataTaishouEndDate)) {
            // SQL条件文追加
            $SQLBodyText .= " and c.taishou_date < :taishou_end_date ";
            $wkEndDate = $request->dataTaishouEndDate;
            //$wkEndDate = date("Y/m/d");

            // バインドの設定
            $SQLBind[] = array('taishou_end_date', $wkEndDate, TYPE_STR);
            //}


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
            // throw new Exception($result,'result');
            // データ取得条件別処理
            if ($cntFlg) {
                /////////////////
                // 件数取得のみ //
                /////////////////
                $data3 = $result[0][0];
            } else {
                ///////////////////
                // データ取得のみ //
                ///////////////////
                $data3 = array();

                foreach ($result as $value) {
                    // JSONオブジェクト用に配列に名前を付けてデータ格納
                    //date(j(日付),(対象日))＝対象日の日付を送る
                    $dataArray = array(
                        'dataTaishouDate' => date('j', strtotime($value['taishou_date'])),
                        'dataShiftCd' => $value['shift_cd'],
                        'dataId' => $value['id']
                    );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $data3[] = $dataArray;
                }
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $data3 = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        } finally {
            $query->CloseQuery();
        }
        try {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            // SQL選択項目
            $SQLHeadText = "
            select c.id
                  ,c.taishou_cd
                  ,to_char(c.taishou_date, 'yyyy/mm/dd') taishou_date
                  ,c.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,c.shift_cd
                  ,c.end_jikoku_tsujou
                  ,c.end_jikoku_zangyou
                  ,c.keika_jikan_tsujou
                  ,c.keika_jikan_zangyou
                  ,to_char(c.taishou_date, 'yyyy/mm/dd') taishou_date
                  ,c.resource_kbn
                  ,c.end_jikoku_tsujou
                  ,c.end_jikoku_zangyou
                  ,c.keika_jikan_tsujou
                  ,c.keika_jikan_zangyou
                  ,to_char(c.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(c.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(c.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(c.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   calendar_master c
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on c.jigyoubu_cd = j.jigyoubu_cd ";

            // SQL条件項目
            $SQLBodyText = "
            where  c.sakujo_dt is null
            and    c.resource_kbn = 3
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
            //if (!is_null($request->dataJigyoubuCd)) {
            //throw new Exception($request->dataJigyoubuCd,'事業部CD');
            // SQL条件文追加
            $SQLBodyText .= " and c.jigyoubu_cd = :jigyoubu_cd ";
            // バインドの設定
            $SQLBind[] = array('jigyoubu_cd', $request->dataJigyoubuCd2, TYPE_STR);
            //throw new Exception($request->dataJigyoubuCd);
            //}

            // リソース区分
            //if (!is_null($request->dataResourceKbn)) {
            // SQL条件文追加
            //$SQLBodyText .= " and c.resource_kbn = :resource_kbn ";
            // バインドの設定
            //$SQLBind[] = array('resource_kbn', $request->dataResourceKbn, TYPE_INT);
            //}

            // 対象CD
            //if (!is_null($request->dataTaishouCd)) {
            // SQL条件文追加
            $SQLBodyText .= " and c.taishou_cd = :taishou_cd ";
            // バインドの設定
            $SQLBind[] = array('taishou_cd', $request->dataSentakuCd, TYPE_STR);
            
            $taihsouCd = $request->dataSentakuCd;

            // 対象日（始）
            //if (!is_null($request->dataTaishouStartDate)) {
            // SQL条件文追加
            $SQLBodyText .= " and c.taishou_date >= :taishou_start_date ";
            $wkStartDate = $request->dataTaishouStartDate;
            //$wkStartDate = date("Y/m/d");

            // バインドの設定
            $SQLBind[] = array('taishou_start_date', $wkStartDate, TYPE_STR);
            //throw new Exception($wkStartDate);
            //}

            // 対象日（終）
            //if (!is_null($request->dataTaishouEndDate)) {
            // SQL条件文追加
            $SQLBodyText .= " and c.taishou_date < :taishou_end_date ";
            $wkEndDate = $request->dataTaishouEndDate;
            //$wkEndDate = date("Y/m/d");

            // バインドの設定
            $SQLBind[] = array('taishou_end_date', $wkEndDate, TYPE_STR);
            //}


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
            // throw new Exception($result,'result');
            // データ取得条件別処理
            if ($cntFlg) {
                /////////////////
                // 件数取得のみ //
                /////////////////
                $data4 = $result[0][0];
            } else {
                ///////////////////
                // データ取得のみ //
                ///////////////////
                $data4 = array();

                foreach ($result as $value) {
                    // JSONオブジェクト用に配列に名前を付けてデータ格納
                    //date(j(日付),(対象日))＝対象日の日付を送る
                    $dataArray = array(
                        'dataTaishouDate' => date('j', strtotime($value['taishou_date'])),
                        'dataShiftCd' => $value['shift_cd'],
                        'dataId' => $value['id']
                    );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $data4[] = $dataArray;
                }
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $data4 = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        } finally {
            $query->CloseQuery();
        }
        try {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            // SQL選択項目
            $SQLHeadText = "
            select c.id
                  ,c.taishou_cd
                  ,to_char(c.taishou_date, 'yyyy/mm/dd') taishou_date
                  ,c.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,c.shift_cd
                  ,c.end_jikoku_tsujou
                  ,c.end_jikoku_zangyou
                  ,c.keika_jikan_tsujou
                  ,c.keika_jikan_zangyou
                  ,to_char(c.taishou_date, 'yyyy/mm/dd') taishou_date
                  ,c.resource_kbn
                  ,c.end_jikoku_tsujou
                  ,c.end_jikoku_zangyou
                  ,c.keika_jikan_tsujou
                  ,c.keika_jikan_zangyou
                  ,to_char(c.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(c.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(c.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(c.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   calendar_master c
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on c.jigyoubu_cd = j.jigyoubu_cd ";

            // SQL条件項目
            $SQLBodyText = "
            where  c.sakujo_dt is null
            and    c.resource_kbn = 2
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
            //if (!is_null($request->dataJigyoubuCd)) {
            //throw new Exception($request->dataJigyoubuCd,'事業部CD');
            // SQL条件文追加
            $SQLBodyText .= " and c.jigyoubu_cd = :jigyoubu_cd ";
            // バインドの設定
            $SQLBind[] = array('jigyoubu_cd', $request->dataJigyoubuCd, TYPE_STR);
            //throw new Exception($request->dataJigyoubuCd);
            //}

            // リソース区分
            //if (!is_null($request->dataResourceKbn)) {
            // SQL条件文追加
            //$SQLBodyText .= " and c.resource_kbn = :resource_kbn ";
            // バインドの設定
            //$SQLBind[] = array('resource_kbn', $request->dataResourceKbn, TYPE_INT);
            //}

            // 対象CD
            //if (!is_null($request->dataTaishouCd)) {
            // SQL条件文追加
            $SQLBodyText .= " and c.taishou_cd = :taishou_cd ";
            // バインドの設定
            $SQLBind[] = array('taishou_cd', $request->dataSentakuCd, TYPE_STR);

            $taihsouCd = $request->dataSentakuCd;
            //throw new Exception($request->dataSentakuCd);
            //}

            // 対象日（始）
            //if (!is_null($request->dataTaishouStartDate)) {
            // SQL条件文追加
            $SQLBodyText .= " and c.taishou_date >= :taishou_start_date ";
            $wkStartDate = $request->dataTaishouStartDate;
            //$wkStartDate = date("Y/m/d");

            // バインドの設定
            $SQLBind[] = array('taishou_start_date', $wkStartDate, TYPE_STR);
            //throw new Exception($wkStartDate);
            //}

            // 対象日（終）
            //if (!is_null($request->dataTaishouEndDate)) {
            // SQL条件文追加
            $SQLBodyText .= " and c.taishou_date < :taishou_end_date ";
            $wkEndDate = $request->dataTaishouEndDate;
            //$wkEndDate = date("Y/m/d");

            // バインドの設定
            $SQLBind[] = array('taishou_end_date', $wkEndDate, TYPE_STR);
            //}

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
            // throw new Exception($result,'result');
            // データ取得条件別処理
            if ($cntFlg) {
                /////////////////
                // 件数取得のみ //
                /////////////////
                $data5 = $result[0][0];
            } else {
                ///////////////////
                // データ取得のみ //
                ///////////////////
                $data5 = array();

                foreach ($result as $value) {
                    // JSONオブジェクト用に配列に名前を付けてデータ格納
                    //date(j(日付),(対象日))＝対象日の日付を送る
                    $dataArray = array(
                        'dataTaishouDate' => date('j', strtotime($value['taishou_date'])),
                        'dataShiftCd' => $value['shift_cd'],
                        'dataId' => $value['id']
                    );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $data5[] = $dataArray;
                }
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $data5 = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        } finally {
            $query->CloseQuery();
        }
        try {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            // SQL選択項目
            $SQLHeadText = "
            select c.id
            from   calendar_master c
            ";

            // SQL条件項目
            $SQLBodyText = "";

            // SQL並び順
            $SQLTailText = "
            order by id desc limit 1";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from   calendar_master c ";

            // SQLバインド値
            $SQLBind = array();

            // 検索件数取得フラグ
            $cntFlg = false;
            if (!is_null($request->dataCntFlg)) $cntFlg = (bool)$request->dataCntFlg;

            ///////////////////
            // 送信データ作成 //
            ///////////////////
            //現在年月日
            //$nowDate = date("Y-m-d");
            // クエリの設定
            $SQLText = ($cntFlg ? $SQLCntText . $SQLBodyText : $SQLHeadText . $SQLBodyText . $SQLTailText);
            $query->StartConnect();
            $query->SetQuery($SQLText, SQL_SELECT);
            // バインド値のセット
            //$SQLBind[] = array('today', $nowDate, TYPE_DATE);
            $query->SetBindArray($SQLBind);
            // クエリの実行
            $result = $query->ExecuteSelect();
            // throw new Exception($result,'result');
            // データ取得条件別処理
            if ($cntFlg) {
                /////////////////
                // 件数取得のみ //
                /////////////////
                $data6 = $result[0][0];
            } else {
                ///////////////////
                // データ取得のみ //
                ///////////////////
                $data6 = array();

                foreach ($result as $value) {
                    // JSONオブジェクト用に配列に名前を付けてデータ格納
                    //date(j(日付),(対象日))＝対象日の日付を送る
                    $dataArray = array(
                        'dataId' => $value['id']
                    );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $data6[] = $dataArray;
                }
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $data6 = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        } finally {
            $query->CloseQuery();
        }
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

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // 送信データ作成 //
            ///////////////////
            //現在年月日
            $nowDate = date("Y-m-d");
            // クエリの設定
            $SQLText = ($SQLHeadText . $SQLBodyText . $SQLTailText);
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
                $data7 = $result[0][0];
            } else {
                ///////////////////
                // データ取得のみ //
                ///////////////////
                $data7 = array();
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
                    $data7[] = $dataArray;
                }
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $data7 = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        } finally {
            $query->CloseQuery();
        }
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
                $taihsouCdJ = $result[0][0];
            } else {
                ///////////////////
                // データ取得のみ //
                ///////////////////
                $taihsouCdJ = array();
                // 結果データの格納
                foreach ($result as $value) {
                    // JSONオブジェクト用に配列に名前を付けてデータ格納
                    $dataArray = array(
                        'dataJigyoubuCd' => $value['jigyoubu_oya_cd'],
                        'dataBushoCd' => $value['busho_cd']
                    );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $taihsouCdJ[] = $dataArray;
                }
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $taihsouCdJ = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        } finally {
            $query->CloseQuery();
        }
        try {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            // SQL選択項目
            $SQLHeadText = "
            select p.id
                  ,p.tantousha_cd
                  ,p.tantousha_name
                  ,p.busho_cd
                  ,b.busho_name
                  ,b.jigyoubu_cd
                  ,j.jigyoubu_oya_cd
                  ,p.kengen_kbn
                  ,p.menu_group_cd
                  ,m.menu_group_name
                  ,to_char(p.nyusha_date, 'yyyy/mm/dd') nyusha_date
                  ,to_char(p.taishoku_date, 'yyyy/mm/dd') taishoku_date
                  ,to_char(p.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,tn.tantousha_name tourokusha_name
                  ,to_char(p.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,kn.tantousha_name koushinsha_name
                  ,to_char(p.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(p.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   tantousha_master p
            left join ( select busho_cd
                              ,busho_name
                              ,jigyoubu_cd
                        from   busho_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) b
              on p.busho_cd = b.busho_cd
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
            left join ( select menu_group_cd
                              ,menu_group_name 
                        from   menu_group_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) m
              on p.menu_group_cd = m.menu_group_cd 
            left join tantousha_master tn
              on p.tourokusha_id = tn.id
            left join tantousha_master kn
              on p.koushinsha_id = kn.id ";

            // SQL条件項目
            $SQLBodyText = "
            where  p.sakujo_dt is null
            and    :today <= case when p.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else p.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by p.id ";

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
            ///////////////////
            // データ取得のみ //
            ///////////////////
            $taihsouCdB = array();
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                $dataArray = array(
                    'dataBushoCd' => $value['busho_cd'],
                    'dataJigyoubuCd' => $value['jigyoubu_oya_cd'],
                    'dataTantoushaCd' => $value['tantousha_cd']
                );
                // 1行ずつデータ配列をグリッドデータ用配列に格納
                $taihsouCdB[] = $dataArray;
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $taihsouCdB = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        } finally {
            $query->CloseQuery();
        }
        try {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            // SQL選択項目
            $SQLHeadText = "
            select k.id
                  ,k.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,k.busho_cd
                  ,b.busho_name
                  ,k.kikai_cd
                  ,k.kikai_name
                  ,k.bikou
                  ,k.std_kadou_min
                  ,k.main_koutei_cd
                  ,cast(k.mujinkadou_kbn as integer) mujinkadou_kbn
                  ,cast(k.sotodandori_kbn as integer) sotodandori_kbn
                  ,to_char(k.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(k.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(k.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(k.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   kikai_master k
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on k.jigyoubu_cd = j.jigyoubu_cd
            left join ( select busho_cd
                              ,busho_name
                        from   busho_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) b
              on k.busho_cd = b.busho_cd";

            // SQL条件項目
            $SQLBodyText = "
            where  k.sakujo_dt is null
            and    :today <= case when k.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else k.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by k.id ";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from   kikai_master k ";

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
            $taihsouCdK = array();
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                $dataArray = array(
                    'dataJigyoubuCd' => $value['jigyoubu_cd'],
                    'dataKikaiCd' => $value['kikai_cd']
                );
                // 1行ずつデータ配列をグリッドデータ用配列に格納
                $taihsouCdK[] = $dataArray;
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $taihsouCdK = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        } finally {
            $query->CloseQuery();
        }

        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        //事業部データ
        $resultData[] = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        //シフトマスタ
        $resultData[] = mb_convert_encoding($data2, 'UTF-8', 'UTF-8');
        //部署データ
        $resultData[] = mb_convert_encoding($data3, 'UTF-8', 'UTF-8');
        //担当者データ
        $resultData[] = mb_convert_encoding($data4, 'UTF-8', 'UTF-8');
        //機械データ
        $resultData[] = mb_convert_encoding($data5, 'UTF-8', 'UTF-8');
        //最後のid
        $resultData[] = mb_convert_encoding($data6, 'UTF-8', 'UTF-8');
        //対象コード
        $resultData[] = mb_convert_encoding($taihsouCd, 'UTF-8', 'UTF-8');
        //事業部マスタ
        $resultData[] = mb_convert_encoding($data7, 'UTF-8', 'UTF-8');
        //事業部対象コード用
        $resultData[] = mb_convert_encoding($taihsouCdJ, 'UTF-8', 'UTF-8');
        //部署対象コード用
        $resultData[] = mb_convert_encoding($taihsouCdB, 'UTF-8', 'UTF-8');
        //機械対象コード用
        $resultData[] = mb_convert_encoding($taihsouCdK, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}
