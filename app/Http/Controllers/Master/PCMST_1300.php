<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_1300 extends Controller
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
            select a.id
                  ,a.jikaisou_level
                  ,a.bunrui_cd
                  ,a.bunrui_name
                  ,a.tsuikajouhou
                  ,a.bunrui_oya_cd
                  ,( select b.bunrui_name
                     from   kaisou_bunrui_master b
                     where  b.sakujo_dt is null
                     and    b.bunrui_cd = a.bunrui_oya_cd
                     and    :today <= case when b.yukoukikan_end_date is null
                                      then '2199-12-31' else b.yukoukikan_end_date end
                     group by b.bunrui_name ) bunrui_oya_name
                  ,to_char(a.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(a.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(a.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(a.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
                  ,( select count(*)
                     from   kaisou_bunrui_master c
                     where  c.sakujo_dt is null
                     and    a.bunrui_cd = c.bunrui_oya_cd
                     and    :today <= case when c.yukoukikan_end_date is null
                                        then '2199-12-31' else c.yukoukikan_end_date end ) ko_kaisou_count
            from   kaisou_bunrui_master a ";

            // SQL条件項目
            $SQLBodyText = "
            where  a.sakujo_dt is null
            and    :today <= case when a.yukoukikan_end_date is null
                                  then '2199-12-31' else a.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by id ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 分類管理CD
            if (!is_null($request->dataCategoryCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and a.bunrui_category_cd = :bunrui_category_cd ";
                // バインドの設定
                $SQLBind[] = array('bunrui_category_cd', $request->dataCategoryCd, TYPE_STR);
            }
            // 分類CD
            if (!is_null($request->dataBunruiCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and a.bunrui_cd ilike :bunrui_cd ";
                // バインドの設定
                $SQLBind[] = array('bunrui_cd', $query->GetLikeValue($request->dataBunruiCd), TYPE_STR);
            }
            // 分類名
            if (!is_null($request->dataBunruiName)) {
                // SQL条件文追加
                $SQLBodyText .= " and a.bunrui_name ilike :bunrui_name ";
                // バインドの設定
                $SQLBind[] = array('bunrui_name', $query->GetLikeValue($request->dataBunruiName), TYPE_STR);
            }

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
            $data = array();
            // 配列番号
            $index = 0;
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                $dataArray = array();
                $dataArray = $dataArray + array('dataId'              => $value['id']);
                $dataArray = $dataArray + array('dataJikaisouLevel'   => sprintf('%02d', $value['jikaisou_level']));
                $dataArray = $dataArray + array('dataBunruiCd'        => $value['bunrui_cd']);
                $dataArray = $dataArray + array('dataBunruiName'      => $value['bunrui_name']);
                $dataArray = $dataArray + array('dataTsuikajouhou'    => $value['tsuikajouhou']);
                $dataArray = $dataArray + array('dataOyaBunruiCd'     => $value['bunrui_oya_cd']);
                $dataArray = $dataArray + array('dataOyaBunruiName'   => $value['bunrui_oya_name']);
                $dataArray = $dataArray + array('dataStartDate'       => $value['yukoukikan_start_date']);
                $dataArray = $dataArray + array('dataEndDate'         => $value['yukoukikan_end_date']);
                $dataArray = $dataArray + array('dataTourokuDt'       => $value['touroku_dt']);
                $dataArray = $dataArray + array('dataKoushinDt'       => $value['koushin_dt']);
                $dataArray = $dataArray + array('dataKoKaisouCount'   => $value['ko_kaisou_count']);
                // 1行ずつデータ配列をグリッドデータ用配列に格納
                $data[] = $dataArray;
                // 配列番号を進める
                $index = $index + 1;
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
