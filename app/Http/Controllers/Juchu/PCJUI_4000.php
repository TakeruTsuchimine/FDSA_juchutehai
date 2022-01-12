<?php

namespace App\Http\Controllers\Juchu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCJUI_4000 extends Controller
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
                  ,ji.jigyoubu_name
                  ,j.job_cd
                  ,jo.job_name
                  ,j.juchu_no
                  ,to_char(j.juchu_date, 'yyyy/mm/dd') juchu_date
                  ,j.tokuisaki_cd
                  ,t.tokuisaki_name1 tokuisaki_name
                  ,j.eigyou_tantousha_cd
                  ,et.tantousha_name eigyou_tantousha_name
                  ,j.assistant_cd
                  ,ji.jigyoubu_oya_kbn
                  ,at.tantousha_name assistant_name
                  ,j.nounyusaki_cd
                  ,n.nounyusaki_name1 nounyusaki_name
                  ,j.tokuisaki_chumon_no1
                  ,j.tokuisaki_chumon_no2
                  ,j.tokuisaki_chumon_no3
                  ,j.hinmoku_cd
                  ,h.hinmoku_name1 hinmoku_name
                  ,to_char(j.nouki_date, 'yyyy/mm/dd') nouki_date
                  ,to_char(j.shukka_date, 'yyyy/mm/dd') shukka_date
                  ,j.tani_cd
                  ,bt.bunrui_name tani_name
                  ,j.juchu_qty
                  ,j.juchu_tanka
                  ,j.juchu_kin
                  ,j.karitanka_kbn
                  ,case when j.karitanka_kbn = 0 then '確定単価' else '仮単価' end karitanka_kbn_name
                  ,j.juchu_kbn
                  ,bj.bunrui_name juchu_kbn_name
                  ,j.haisoubin_cd
                  ,bh.bunrui_name haisoubin_name
                  ,to_char(j.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(j.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(j.yukoukikan_start_date, 'yyyy/mm/dd hh24:mi:ss') yukoukikan_start_date
                  ,to_char(j.yukoukikan_end_date, 'yyyy/mm/dd hh24:mi:ss') yukoukikan_end_date
            from   juchu_data j
            left join ( select * from jigyoubu_master ) ji
                   on j.jigyoubu_cd = ji.jigyoubu_cd
                  and ji.sakujo_dt is null
                  and j.juchu_date >= ji.yukoukikan_start_date
                  and j.juchu_date <= case when ji.yukoukikan_end_date is null
                                           then '2199-12-31'
                                           else ji.yukoukikan_end_date end
            left join ( select * from job_master ) jo
                   on j.job_cd = jo.job_cd
                  and jo.sakujo_dt is null
            left join ( select * from tokuisaki_master ) t
                   on j.tokuisaki_cd = t.tokuisaki_cd
                  and t.sakujo_dt is null
                  and j.juchu_date >= t.yukoukikan_start_date
                  and j.juchu_date <= case when t.yukoukikan_end_date is null
                                           then '2199-12-31'
                                           else t.yukoukikan_end_date end
            left join ( select * from tantousha_master ) et
                   on j.eigyou_tantousha_cd = et.tantousha_cd
                  and et.sakujo_dt is null
                  and j.juchu_date >= et.yukoukikan_start_date
                  and j.juchu_date <= case when et.yukoukikan_end_date is null
                                           then '2199-12-31'
                                           else et.yukoukikan_end_date end
            left join ( select * from tantousha_master ) at
                   on j.assistant_cd = at.tantousha_cd
                  and at.sakujo_dt is null
                  and j.juchu_date >= at.yukoukikan_start_date
                  and j.juchu_date <= case when at.yukoukikan_end_date is null
                                           then '2199-12-31'
                                           else at.yukoukikan_end_date end
            left join ( select * from tokui_nounyusaki_master ) n
                   on j.nounyusaki_cd = n.nounyusaki_cd
                  and n.sakujo_dt is null
                  and j.juchu_date >= n.yukoukikan_start_date
                  and j.juchu_date <= case when n.yukoukikan_end_date is null
                                           then '2199-12-31'
                                           else n.yukoukikan_end_date end
            left join ( select * from hinmoku_master ) h
                   on j.hinmoku_cd = h.hinmoku_cd
                  and h.sakujo_dt is null
                  and j.juchu_date >= h.yukoukikan_start_date
                  and j.juchu_date <= case when h.yukoukikan_end_date is null
                                           then '2199-12-31'
                                           else h.yukoukikan_end_date end
            left join ( select * from kaisou_bunrui_master ) bj
                   on j.juchu_kbn = bj.bunrui_cd
                  and bj.sakujo_dt is null
                  and j.juchu_date >= bj.yukoukikan_start_date
                  and j.juchu_date <= case when bj.yukoukikan_end_date is null
                                           then '2199-12-31'
                                           else bj.yukoukikan_end_date end
                  and bj.bunrui_category_cd = 'JUCHUKBN'
            left join ( select * from kaisou_bunrui_master ) bt
                   on j.tani_cd = bt.bunrui_cd
                  and bt.sakujo_dt is null
                  and j.juchu_date >= bt.yukoukikan_start_date
                  and j.juchu_date <= case when bt.yukoukikan_end_date is null
                                           then '2199-12-31'
                                           else bt.yukoukikan_end_date end
                  and bt.bunrui_category_cd = 'TANI'
            left join ( select * from kaisou_bunrui_master ) bh
                   on j.haisoubin_cd = bh.bunrui_cd
                  and bh.sakujo_dt is null
                  and j.juchu_date >= bh.yukoukikan_start_date
                  and j.juchu_date <= case when bh.yukoukikan_end_date is null
                                           then '2199-12-31'
                                           else bh.yukoukikan_end_date end
                  and bh.bunrui_category_cd = 'HAISOUBIN' ";

            // SQL条件項目
            $SQLBodyText = "
            where  j.sakujo_dt is null
            and    :today <= case when j.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else j.yukoukikan_end_date end 
            ";

            // SQL並び順
            $SQLTailText = "
            order by j.id ";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from   juchu_data j ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 開始受注日
            if (!is_null($request->dataJuchuStartDate)) {
                // SQL条件文追加
                $SQLBodyText .= " and j.juchu_date >= :juchu_start_date ";
                // バインドの設定
                $SQLBind[] = array('juchu_start_date', $request->dataJuchuStartDate, TYPE_DATE);
            }

            // 終了受注日
            if (!is_null($request->dataJuchuEndDate)) {
                // SQL条件文追加
                $SQLBodyText .= " and j.juchu_date <= :juchu_end_date ";
                // バインドの設定
                $SQLBind[] = array('juchu_end_date', $request->dataJuchuEndDate, TYPE_DATE);
            }

            // 開始希望納期
            if (!is_null($request->dataNoukiStartDate)) {
                // SQL条件文追加
                $SQLBodyText .= " and j.nouki_date >= :nouki_start_date ";
                // バインドの設定
                $SQLBind[] = array('nouki_start_date', $request->dataNoukiStartDate, TYPE_DATE);
            }

            // 終了希望納期
            if (!is_null($request->dataNoukiEndDate)) {
                // SQL条件文追加
                $SQLBodyText .= " and j.nouki_date <= :nouki_end_date ";
                // バインドの設定
                $SQLBind[] = array('nouki_end_date', $request->dataNoukiEndDate, TYPE_DATE);
            }

            // 開始受注No
            if (!is_null($request->dataStartJuchuNo)) {
                // SQL条件文追加
                $SQLBodyText .= " and j.juchu_no >= :start_juchu_no ";
                // バインドの設定
                $SQLBind[] = array('start_juchu_no', $request->dataStartJuchuNo, TYPE_STR);
            }

            // 終了受注No
            if (!is_null($request->dataEndJuchuNo)) {
                // SQL条件文追加
                $SQLBodyText .= " and j.juchu_no <= :end_juchu_no ";
                // バインドの設定
                $SQLBind[] = array('end_juchu_no', $request->dataEndJuchuNo, TYPE_STR);
            }

            // 客先注文番号
            if (!is_null($request->dataChumonNo)) {
                // SQL条件文追加
                $SQLBodyText .= " and j.tokuisaki_chumon_no1 ilike :chumon_no ";
                // バインドの設定
                $SQLBind[] = array('chumon_no', $query->GetLikeValue($request->dataChumonNo), TYPE_STR);
            }

            // 得意先CD
            if (!is_null($request->dataTokuisakiCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and j.tokuisaki_cd ilike :tokuisaki_cd ";
                // バインドの設定
                $SQLBind[] = array('tokuisaki_cd', $query->GetLikeValue($request->dataTokuisakiCd), TYPE_STR);
            }

            // 品目CD
            if (!is_null($request->dataHinmokuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and j.hinmoku_cd ilike :hinmoku_cd ";
                // バインドの設定
                $SQLBind[] = array('hinmoku_cd', $query->GetLikeValue($request->dataHinmokuCd), TYPE_STR);
            }

            // 品目名
            if (!is_null($request->dataHinmokuName)) {
                // SQL条件文追加
                $SQLBodyText .= " and ( select hinmoku_name1
                                        from   hinmoku_master hn
                                        where  j.hinmoku_cd = hn.hinmoku_cd
                                        and    hn.sakujo_dt is null
                                        and    j.juchu_date >= hn.yukoukikan_start_date
                                        and    j.juchu_date <= case when hn.yukoukikan_end_date is null
                                                                    then '2199-12-31'
                                                                    else hn.yukoukikan_end_date end ) ilike :hinmoku_name ";
                // バインドの設定
                $SQLBind[] = array('hinmoku_name', $query->GetLikeValue($request->dataHinmokuName), TYPE_STR);
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
                // 結果データの格納
                foreach ($result as $value) {
                    // JSONオブジェクト用に配列に名前を付けてデータ格納
                    $dataArray = array(
                        'dataId' => $value['id'],
                        'dataJigyoubuCd' => $value['jigyoubu_cd'],
                        'dataJigyoubuName' => $value['jigyoubu_name'],
                        'dataJobCd' => $value['job_cd'],
                        'dataJobName' => $value['job_name'],
                        'dataJuchuNo' => $value['juchu_no'],
                        'dataJuchuDate' => $value['juchu_date'],
                        'dataTokuisakiCd' => $value['tokuisaki_cd'],
                        'dataTokuisakiName' => $value['tokuisaki_name'],
                        'dataEigyouCd' => $value['eigyou_tantousha_cd'],
                        'dataEigyouName' => $value['eigyou_tantousha_name'],
                        'dataAssistantCd' => $value['assistant_cd'],
                        'dataAssistantName' => $value['assistant_name'],
                        'dataNounyusakiCd' => $value['nounyusaki_cd'],
                        'dataNounyusakiName' => $value['nounyusaki_name'],
                        'dataChumonNo1' => $value['tokuisaki_chumon_no1'],
                        'dataChumonNo2' => $value['tokuisaki_chumon_no2'],
                        'dataChumonNo3' => $value['tokuisaki_chumon_no3'],
                        'dataHinmokuCd' => $value['hinmoku_cd'],
                        'dataHinmokuName' => $value['hinmoku_name'],
                        'dataNoukiDate' => $value['nouki_date'],
                        'dataShukkaDate' => $value['shukka_date'],
                        'dataTaniCd' => $value['tani_cd'],
                        'dataTaniName' => $value['tani_name'],
                        'dataJuchuQty' => (double)$value['juchu_qty'],
                        'dataJuchuTanka' => (double)$value['juchu_tanka'],
                        'dataJuchuKin' => (double)$value['juchu_kin'],
                        'dataKaritankaKbn' => (int)$value['karitanka_kbn'],
                        'dataKaritankaKbnName' => $value['karitanka_kbn_name'],
                        'dataJuchuKbn' => $value['juchu_kbn'],
                        'dataJuchuKbnName' => $value['juchu_kbn_name'],
                        'dataHaisoubinCd' => $value['haisoubin_cd'],
                        'dataHaisoubinName' => $value['haisoubin_name'],
                        'dataStartDate' => $value['yukoukikan_start_date'],
                        'dataEndDate' =>   $value['yukoukikan_end_date'],
                        'dataTourokuDt' => $value['touroku_dt'],
                        'dataKoushinDt' => $value['koushin_dt']
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
            $query->CloseQuery();
        }
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}
