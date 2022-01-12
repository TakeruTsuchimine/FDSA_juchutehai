<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

/**
 * グリッドデータ取得クラス　「部署マスター」
 */
class PCMST_0300 extends Controller
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
        $data;
        /** App\Http\Controllers\Classes\class_Database データベース接続クラス宣言 */
        $query = new class_Database();
        try {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            /** string $SQLHeadText SQL選択項目 */
            $SQLHeadText = "
            select b.id
                  ,b.busho_cd
                  ,b.busho_name
                  ,b.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,b.seikyu_cd
                  ,s.seikyu_busho_name
                  ,b.keiri_cd
                  ,bm.bunrui_name
                  ,b.hyouji_seq
                  ,b.shukei_no
                  ,b.busho_ryaku_name
                  ,cast(cast(b.soshiki_kaisou_level as character varying) as integer) soshiki_kaisou_level
                  ,b.kaisou_level1_bushi_cd
                  ,b.kaisou_level2_bushi_cd
                  ,b.kaisou_level3_bushi_cd
                  ,b.kaisou_level4_bushi_cd
                  ,b.kaisou_level5_bushi_cd
                  ,b.oya_busho_cd
                  ,to_char(b.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,tn.tantousha_name tourokusha_name
                  ,to_char(b.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,kn.tantousha_name koushinsha_name
                  ,to_char(b.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(b.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   busho_master b
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
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
              on b.seikyu_cd = s.seikyu_cd
            left join ( select bunrui_cd
                              ,bunrui_name
                        from   kaisou_bunrui_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) bm
              on b.keiri_cd = bm.bunrui_cd
            left join tantousha_master tn
              on b.tourokusha_id = tn.id
            left join tantousha_master kn
              on b.koushinsha_id = kn.id ";

            /** string $SQLBodyText SQL条件項目 */
            $SQLBodyText = "
            where  b.sakujo_dt is null
            and    :today <= case when b.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else b.yukoukikan_end_date end ";

            /** string $SQLTailText SQL並び順 */
            $SQLTailText = "
            order by b.id ";

            /** array $SQLBind SQLバインド値 */
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 部署CD
            if (!is_null($request->dataBushoCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and b.busho_cd ilike :busho_cd ";
                // バインドの設定
                $SQLBind[] = array('busho_cd', $query->GetLikeValue($request->dataBushoCd), TYPE_STR);
            }

            // 部署名
            if (!is_null($request->dataBushoName)) {
                // SQL条件文追加
                $SQLBodyText .= " and b.busho_name ilike :busho_name ";
                // バインドの設定
                $SQLBind[] = array('busho_name', $query->GetLikeValue($request->dataBushoName), TYPE_STR);
            }

            // 事業部CD
            if (!is_null($request->dataJigyoubuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and b.jigyoubu_cd ilike :jigyoubu_cd ";
                // バインドの設定
                $SQLBind[] = array('jigyoubu_cd', $query->GetLikeValue($request->dataJigyoubuCd), TYPE_STR);
            }

            ///////////////////
            // 送信データ作成 //
            ///////////////////
            /** string $nowDate 現在年月日 */
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
            ///////////////////
            // データ取得のみ //
            ///////////////////
            $data = array();
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                /** array $dataArray 取得レコードデータ */
                $dataArray = array(
                    'dataId' => $value['id'],
                    'dataBushoCd' => $value['busho_cd'],
                    'dataBushoName' => $value['busho_name'],
                    'dataBushoRyakuName' => $value['busho_ryaku_name'],
                    'dataJigyoubuCd' => $value['jigyoubu_cd'],
                    'dataJigyoubuName' => $value['jigyoubu_name'],
                    'dataHyoujiSeq' => $value['hyouji_seq'],
                    'dataShukeiNo' => $value['shukei_no'],
                    'dataSeikyuCd' => $value['seikyu_cd'],
                    'dataSeikyuBushoName' => $value['seikyu_busho_name'],
                    'dataKeiriCd' => $value['seikyu_cd'],
                    'dataBunruiName' => $value['bunrui_name'],
                    'dataStartDate' => $value['yukoukikan_start_date'],
                    'dataEndDate' => $value['yukoukikan_end_date'],
                    'dataTourokuDt' => $value['touroku_dt'],
                    'dataTourokushaName' => $value['tourokusha_name'],
                    'dataKoushinDt' => $value['koushin_dt'],
                    'dataKoushinshaName' => $value['koushinsha_name']
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
