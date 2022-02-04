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
                  ,k.koutei_cd
                  ,k.koutei_name
                  ,k.koutei_ryaku_name
                  ,case k.koutei_kbn
                  when 0 then '0:未設定'
                  when 1 then '1:社内加工'
                  when 2 then '2:外注加工'
                  when 3 then '3:材料手配'
                  end koutei_kbn
                  ,k.sagyou_kikai_kouho_cd
                  ,k.sagyou_tantousha_kouho_cd
                  ,k.kakousaki_kouho_cd
                  ,k.koutei_tanka
                  ,k.koutei_dandori_tanka
                  ,case k.shokai_kbn
                  when 0 then '0:無効'
                  when 1 then '1:初回製造のみ有効（手配）'
                  end shokai_kbn
                  ,case k.houkoku_kbn
                  when 0 then '0:無'
                  when 1 then '1:報告'
                  end houkoku_kbn
                  ,case k.zumen_haifu_kbn
                  when 0 then '0:無'
                  when 1 then '1:配布'
                  end zumen_haifu_kbn
                  ,to_char(k.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,tn.tantousha_name tourokusha_name
                  ,to_char(k.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,kn.tantousha_name koushinsha_name
                  ,to_char(k.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(k.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   koutei_master k
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on k.jigyoubu_cd = j.jigyoubu_cd
            left join tantousha_master tn
              on k.tourokusha_id = tn.id
            left join tantousha_master kn
              on k.koushinsha_id = kn.id ";

            // SQL条件項目
            $SQLBodyText = "
            where  k.sakujo_dt is null
            and    :today <= case when k.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else k.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by k.id ";

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
            $data = array();
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                $dataArray = array(
                    'dataId' => $value['id'],
                    'dataJigyoubuCd' => $value['jigyoubu_cd'],
                    'dataJigyoubuName' => $value['jigyoubu_name'],
                    'dataKouteiCd' => $value['koutei_cd'],
                    'dataKouteiName' => $value['koutei_name'],
                    'dataKouteiRyakuName' => $value['koutei_ryaku_name'],
                    'dataKouteiKbn' => $value['koutei_kbn'],
                    'dataSagyouKikaiKouhoCd' => $value['sagyou_kikai_kouho_cd'],
                    'dataSagyouTantoushaKouhoCd' => $value['sagyou_tantousha_kouho_cd'],
                    'dataKakousakiKouhoCd' => $value['kakousaki_kouho_cd'],
                    'dataKouteiTanka' => $value['koutei_tanka'],
                    'dataKouteiDandoriTanka' => $value['koutei_dandori_tanka'],
                    'dataShokaiKbn' => $value['shokai_kbn'],
                    'dataHoukokuKbn' => $value['houkoku_kbn'],
                    'dataZumenHaifuKbn' => $value['zumen_haifu_kbn'],
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
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}
