<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_0600 extends Controller
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
            select k.id
                  ,k.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,k.busho_cd
                  ,b.busho_name
                  ,k.koutei_cd
                  ,k.koutei_name
                  ,k.koutei_ryaku_name
                  ,k.koutei_kbn
                  ,k.sagyou_kikai_kouho_cd
                  ,k.sagyou_tantousha_kouho_cd
                  ,k.sagyou_jigu_kouho_cd
                  ,k.kakousaki_kouho_cd
                  ,k.koutei_tanka
                  ,k.koutei_dandori_tanka
                  ,cast(cast(k.shokai_kbn as character varying) as integer) shokai_kbn
                  ,cast(cast(k.houkoku_kbn as character varying) as integer) houkoku_kbn
                  ,cast(cast(k.zumen_haifu_kbn as character varying) as integer) zumen_haifu_kbn
                  ,to_char(k.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(k.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(k.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(k.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   koutei_master k
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_date is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on k.jigyoubu_cd = j.jigyoubu_cd
            left join ( select busho_cd
                              ,busho_name
                        from   busho_master
                        where  sakujo_date is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) b
              on k.busho_cd = b.busho_cd ";

            // SQL条件項目
            $SQLBodyText = "
            where  k.sakujo_date is null
            and    :today <= case when k.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else k.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by k.id ";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from   koutei_master k ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 工程CD
            if (!is_null($request->dataKouteiCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and k.koutei_cd ilike :koutei_cd ";
                // バインドの設定
                $SQLBind[] = array('koutei_cd', $query->GetLikeValue($request->dataKouteiCd), TYPE_STR);
            }

            // 工程名
            if (!is_null($request->dataKouteiName)) {
                // SQL条件文追加
                $SQLBodyText .= " and k.koutei_name ilike :koutei_name ";
                // バインドの設定
                $SQLBind[] = array('koutei_name', $query->GetLikeValue($request->dataKouteiName), TYPE_STR);
            }

            // 工程略名
            if (!is_null($request->dataKouteiRyakuName)) {
                // SQL条件文追加
                $SQLBodyText .= " and k.koutei_ryaku_name ilike :koutei_ryaku_name ";
                // バインドの設定
                $SQLBind[] = array('koutei_ryaku_name', $query->GetLikeValue($request->dataKouteiRyakuName), TYPE_STR);
            }

            // 事業部CD
            if (!is_null($request->dataJigyoubuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and k.jigyoubu_cd ilike :jigyoubu_cd ";
                // バインドの設定
                $SQLBind[] = array('jigyoubu_cd', $query->GetLikeValue($request->dataJigyoubuCd), TYPE_STR);
            }

            // 部署CD
            if (!is_null($request->dataBushoCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and k.busho_cd ilike :busho_cd ";
                // バインドの設定
                $SQLBind[] = array('busho_cd', $query->GetLikeValue($request->dataBushoCd), TYPE_STR);
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
                    $dataArray = $dataArray + array('dataBushoCd' => $value['busho_cd']);
                    $dataArray = $dataArray + array('dataBushoName' => $value['busho_name']);
                    $dataArray = $dataArray + array('dataKouteiCd' => $value['koutei_cd']);
                    $dataArray = $dataArray + array('dataKouteiName' => $value['koutei_name']);
                    $dataArray = $dataArray + array('dataKouteiRyakuName' => $value['koutei_ryaku_name']);
                    $dataArray = $dataArray + array('dataKouteiKbn' => $value['koutei_kbn']);
                    $dataArray = $dataArray + array('dataSagyouKikaiKouhoCd' => $value['sagyou_kikai_kouho_cd']);
                    $dataArray = $dataArray + array('dataSagyouTantoushaKouhoCd' => $value['sagyou_tantousha_kouho_cd']);
                    $dataArray = $dataArray + array('dataSagyouJiguKouhoCd' => $value['sagyou_jigu_kouho_cd']);
                    $dataArray = $dataArray + array('dataKakousakiKouhoCd' => $value['kakousaki_kouho_cd']);
                    $dataArray = $dataArray + array('dataKouteiTanka' => $value['koutei_tanka']);
                    $dataArray = $dataArray + array('dataKouteiDandoriTanka' => $value['koutei_dandori_tanka']);
                    $dataArray = $dataArray + array('dataShokaiKbn' => $value['shokai_kbn']);
                    $dataArray = $dataArray + array('dataHoukokuKbn' => $value['houkoku_kbn']);
                    $dataArray = $dataArray + array('dataZumenHaifuKbn' => $value['zumen_haifu_kbn']);
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
