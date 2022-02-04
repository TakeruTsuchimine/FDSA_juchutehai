<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;

/**
 * グリッドデータ取得クラス　「階層分類マスター」
 */
class PCMST_1300 extends Controller
{
    /**
     * 一覧データ出力
     *
     * @param Request $request POST受信データ
     * 
     * @return array $resultData 一覧グリッドデータ
     */
    public function index(Request $request)
    {
        /** boolean $resultFlg      処理成功フラグ */
        $resultFlg = true;
        /** array   $data           グリッドデータ用データ格納配列変数 */
        $data = array();
        /** App\Http\Controllers\Classes\class_Database データベース接続クラス宣言 */
        $query = new class_Database();
        try {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            /** string $SQLHeadText SQL選択項目 */
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
            /** string $SQLBodyText SQL条件項目 */
            $SQLBodyText = "
            where  a.sakujo_dt is null
            and    :today <= case when a.yukoukikan_end_date is null
                                  then '2199-12-31' else a.yukoukikan_end_date end ";
            /** string $SQLTailText SQL並び順 */
            $SQLTailText = "
            order by id ";
            /** array $SQLBind SQLバインド値 */
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
            /** string $noeDate 現在年月日 */
            $nowDate = date("Y-m-d");
            /** string $SQLText 実行SQL文 */
            $SQLText = $SQLHeadText . $SQLBodyText . $SQLTailText;
            // DB接続
            $query->StartConnect();
             // SQL文セット
            $query->SetQuery($SQLText, SQL_SELECT);
            // バインド値のセット
            $SQLBind[] = array('today', $nowDate, TYPE_DATE);
            $query->SetBindArray($SQLBind);
            // SQLの実行
            /** array $result 実行結果データ */
            $result = $query->ExecuteSelect();
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                /** array $dataArray 取得レコードデータ */
                $dataArray = array(
                    'dataId'              => $value['id'],
                    'dataJikaisouLevel'   => sprintf('%02d', $value['jikaisou_level']),
                    'dataBunruiCd'        => $value['bunrui_cd'],
                    'dataBunruiName'      => $value['bunrui_name'],
                    'dataTsuikajouhou'    => $value['tsuikajouhou'],
                    'dataOyaBunruiCd'     => $value['bunrui_oya_cd'],
                    'dataOyaBunruiName'   => $value['bunrui_oya_name'],
                    'dataStartDate'       => $value['yukoukikan_start_date'],
                    'dataEndDate'         => $value['yukoukikan_end_date'],
                    'dataTourokuDt'       => $value['touroku_dt'],
                    'dataKoushinDt'       => $value['koushin_dt'],
                    'dataKoKaisouCount'   => $value['ko_kaisou_count']
                );
                // 1行ずつデータ配列をグリッドデータ用配列に格納
                $data[] = $dataArray;
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $data = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        } finally {
            $query->CloseQuery();
        }
        /** array $resultData 出力データ */
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        // 処理結果送信
        return $resultData;
    }
}
