<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_6200 extends Controller
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
                  ,m.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,m.menu_group_cd
                  ,m.menu_group_seq
                  ,m.menu_seq
                  ,m.menu_title
                  ,m.menu_title_url
                  ,to_char(m.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(m.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(m.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(m.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   menu_master m
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_date is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on m.jigyoubu_cd = j.jigyoubu_cd ";

            // SQL条件項目
            $SQLBodyText = "
            where  m.sakujo_date is null
            and    :today <= case when m.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else m.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by m.id ";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from   menu_master m ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // メニューグループCD
            if (!is_null($request->dataMenuGroupCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and m.menu_group_cd ilike :menu_group_cd ";
                // バインドの設定
                $SQLBind[] = array('menu_group_cd', $query->GetLikeValue($request->dataMenuGroupCd), TYPE_STR);
            }

            // メニューグループSEQNO
            if (!is_null($request->dataMenuGroupSeq)) {
                // SQL条件文追加
                $SQLBodyText .= " and m.menu_group_seq ilike :menu_group_seq ";
                // バインドの設定
                $SQLBind[] = array('menu_group_seq', $query->GetLikeValue($request->dataMenuGroupSeq), TYPE_INT);
            }

            // メニューSEQNO
            if (!is_null($request->dataMenuSeq)) {
                // SQL条件文追加
                $SQLBodyText .= " and m.menu_seq ilike :menu_seq ";
                // バインドの設定
                $SQLBind[] = array('menu_seq', $query->GetLikeValue($request->dataMenuSeq), TYPE_INT);
            }

            // メニュータイトル
            if (!is_null($request->dataMenuTitle)) {
                // SQL条件文追加
                $SQLBodyText .= " and m.menu_title ilike :menu_title ";
                // バインドの設定
                $SQLBind[] = array('menu_title', $query->GetLikeValue($request->dataMenuTitle), TYPE_STR);
            }

            // 事業部CD
            if (!is_null($request->dataJigyoubuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and m.jigyoubu_cd ilike :jigyoubu_cd ";
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
                    $dataArray = $dataArray + array('dataMenuGroupCd' => $value['menu_group_cd']);
                    $dataArray = $dataArray + array('dataMenuGroupSeq' => $value['menu_group_seq']);
                    $dataArray = $dataArray + array('dataMenuSeq' => $value['menu_seq']);
                    $dataArray = $dataArray + array('dataMenuTitle' => $value['menu_title']);
                    $dataArray = $dataArray + array('dataMenuTitleUrl' => $value['menu_title_url']);
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
