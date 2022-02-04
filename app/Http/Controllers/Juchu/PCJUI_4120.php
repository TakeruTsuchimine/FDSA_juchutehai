<?php

namespace App\Http\Controllers\Juchu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCJUI_4120 extends Controller
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
                ,j.juchu_date
                ,j.juchu_no
                ,jt.seisaku_kbn
                ,jtm.kaitou_status
                ,j.tokuisaki_cd
                ,j.tokuisaki_chumon_no1
                ,j.matome_kbn
                ,j.hinmoku_cd
                ,h.hinmoku_name1
                ,jtm.gaichusaki_cd
                ,s.shiiresaki_name1 as gaichusaki_name
                ,m.sum_qty as tsuki_kei_qty
                ,dm.sum_qty as kikann_kei_qty
                ,m.sum_kin as tsuki_kei_kin
                ,dm.sum_kin as kikann_kei_kin
                ,jtm.mitsumori_kaitou_kigen_date
                ,jtm.kibou_nouki_date
                ,j.tehai_qty
                ,j.juchu_qty
                
                ,j.juchu_kbn
                ,kbj.bunrui_name juchu_kbn_name
                
                ,to_char(j.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                ,to_char(j.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                ,to_char(j.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                ,to_char(j.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from juchu_data j
            inner join juchu_tehaiIrai_data jt
                on j.juchu_no = jt.juchu_no
                and jt.sakujo_dt is null
            inner join juchu_tehai_Irai_meisai_data jtm
                on jt.id = jtm.Juchu_tehai_irai_id
                and jtm.sakujo_dt is null
            left join hinmoku_master h
                on j.hinmoku_cd = h.hinmoku_cd
                and h.sakujo_dt is null
                and j.juchu_date >= h.yukoukikan_start_date
                and j.juchu_date <= 
                    case 
                        when h.yukoukikan_end_date is null
                            then '2199-12-31'
                        else h.yukoukikan_end_date 
                    end
            left join shiiresaki_master s
                on jtm.gaichusaki_cd = s.shiiresaki_cd
                and s.sakujo_dt is null
                and j.juchu_date >= s.yukoukikan_start_date
                and j.juchu_date <= 
                    case 
                        when s.yukoukikan_end_date is null
                            then '2199-12-31'
                        else s.yukoukikan_end_date 
                    end
            left join (
                select 
                    sum(j.juchu_qty) as sum_qty
                    ,sum(j.juchu_kin) as sum_kin
                    ,jtm.gaichusaki_cd
                from juchu_data j
                left join juchu_tehaiIrai_data jt
                    on j.juchu_no = jt.juchu_no
                    and jt.sakujo_dt is null
                left join juchu_tehai_Irai_meisai_data jtm
                    on jt.id = jtm.Juchu_tehai_irai_id
                    and jtm.sakujo_dt is null
                where jtm.gaichusaki_id is not null
                    and j.juchu_date >= date(date_trunc('month', cast('2008-11-30' as date)))
                    and j.juchu_date < date(date_trunc('month', cast('2008-11-30' as date))) + cast( '1 months' as interval )
                group by jtm.gaichusaki_cd
                ) m
                on jtm.gaichusaki_cd = m.gaichusaki_cd
            left join (
                select 
                    sum(j.juchu_qty) as sum_qty
                    ,sum(j.juchu_kin) as sum_kin
                    ,jtm.gaichusaki_cd
                from juchu_data j
                left join juchu_tehaiIrai_data jt
                    on j.juchu_no = jt.juchu_no
                    and jt.sakujo_dt is null
                left join juchu_tehai_Irai_meisai_data jtm
                    on jt.id = jtm.Juchu_tehai_irai_id
                    and jtm.sakujo_dt is null
                where jtm.gaichusaki_id is not null
                    and j.juchu_date >= date(date_trunc('month', cast('2008-11-30' as date)))
                    and j.juchu_date < date(date_trunc('month', cast('2008-11-30' as date))) + cast( '3 months' as interval )
                group by jtm.gaichusaki_cd
                ) dm
                on jtm.gaichusaki_cd = dm.gaichusaki_cd
            left join kaisou_bunrui_master kbj
                on j.juchu_kbn = kbj.bunrui_cd
                and kbj.sakujo_dt is null
                and j.juchu_date >= kbj.yukoukikan_start_date
                and j.juchu_date <= 
                    case 
                        when kbj.yukoukikan_end_date is null
                            then '2199-12-31'
                        else kbj.yukoukikan_end_date 
                    end
                and kbj.bunrui_category_cd = 'JUCHUKBN'
            ";

            // SQL条件項目
            $SQLBodyText = "
            where j.sakujo_dt is null
                and :today <= 
                    case 
                        when j.yukoukikan_end_date is null
                            then '2199-12-31'
                        else j.yukoukikan_end_date 
                    end 
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
                                        and    hn.sakujo_date is null
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
                // 配列番号
                $index = 0;
                // 結果データの格納
                foreach ($result as $value) {
                    // JSONオブジェクト用に配列に名前を付けてデータ格納
                    $dataArray = array();
                    $dataArray = $dataArray + array('dataId' => $value['id']);
                    $dataArray = $dataArray + array('dataJuchuNo' => $value['juchu_no']);
                    $dataArray = $dataArray + array('dataJuchuDate' => $value['juchu_date']);
                    // $dataArray = $dataArray + array('dataTokuisakiCd' => $value['tokuisaki_cd']);
                    // $dataArray = $dataArray + array('dataTokuisakiName' => $value['tokuisaki_name']);
                    // $dataArray = $dataArray + array('dataEigyouCd' => $value['eigyou_tantousha_cd']);
                    // $dataArray = $dataArray + array('dataEigyouName' => $value['eigyou_tantousha_name']);
                    // $dataArray = $dataArray + array('dataAssistantCd' => $value['assistant_cd']);
                    // $dataArray = $dataArray + array('dataAssistantName' => $value['assistant_name']);
                    // $dataArray = $dataArray + array('dataNounyusakiCd' => $value['nounyusaki_cd']);
                    // $dataArray = $dataArray + array('dataNounyusakiName' => $value['nounyusaki_name']);
                    // $dataArray = $dataArray + array('dataChumonNo1' => $value['tokuisaki_chumon_no1']);
                    // $dataArray = $dataArray + array('dataChumonNo2' => $value['tokuisaki_chumon_no2']);
                    // $dataArray = $dataArray + array('dataChumonNo3' => $value['tokuisaki_chumon_no3']);
                    // $dataArray = $dataArray + array('dataHinmokuCd' => $value['hinmoku_cd']);
                    // $dataArray = $dataArray + array('dataHinmokuName' => $value['hinmoku_name']);
                    // $dataArray = $dataArray + array('dataNoukiDate' => $value['nouki_date']);
                    // $dataArray = $dataArray + array('dataShukkaDate' => $value['shukka_date']);
                    // $dataArray = $dataArray + array('dataTaniCd' => $value['tani_cd']);
                    // $dataArray = $dataArray + array('dataTaniName' => $value['tani_name']);
                    // $dataArray = $dataArray + array('dataJuchuQty' => (double)$value['juchu_qty']);
                    // $dataArray = $dataArray + array('dataJuchuTanka' => (double)$value['juchu_tanka']);
                    // $dataArray = $dataArray + array('dataJuchuKin' => (double)$value['juchu_kin']);
                    // $dataArray = $dataArray + array('dataKaritankaKbn' => (int)$value['karitanka_kbn']);
                    // $dataArray = $dataArray + array('dataKaritankaKbnName' => $value['karitanka_kbn_name']);
                    // $dataArray = $dataArray + array('dataJuchuKbn' => $value['juchu_kbn']);
                    // $dataArray = $dataArray + array('dataJuchuKbnName' => $value['juchu_kbn_name']);
                    // $dataArray = $dataArray + array('dataHaisoubinCd' => $value['haisoubin_cd']);
                    // $dataArray = $dataArray + array('dataHaisoubinName' => $value['haisoubin_name']);
                    // $dataArray = $dataArray + array('dataNote1' => $value['notes1']);
                    // $dataArray = $dataArray + array('dataNote2' => $value['notes2']);
                    // $dataArray = $dataArray + array('dataNote3' => $value['notes3']);
                    // $dataArray = $dataArray + array('dataStartDate' => $value['yukoukikan_start_date']);
                    // $dataArray = $dataArray + array('dataEndDate' => $value['yukoukikan_end_date']);
                    // $dataArray = $dataArray + array('dataTourokuDt' => $value['touroku_dt']);
                    // $dataArray = $dataArray + array('dataKoushinDt' => $value['koushin_dt']);
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
