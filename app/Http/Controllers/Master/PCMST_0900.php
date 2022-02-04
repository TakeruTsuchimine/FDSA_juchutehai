<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_0900 extends Controller
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
            select
            k.id
            ,k.jigyoubu_cd
            ,j.jigyoubu_name
            ,k.waritsuke_kouho_cd
            ,k.sub_seqno
            ,k.waritsuke_kouho_name
            ,k.setsumeibun
            ,ki.kikai_cd
            ,k.kakou_nouryoku
            ,k.kakou_nouryoku_keisu
            ,k.touroku_dt
            ,k.tourokusha_id
            ,k.koushin_dt
            ,k.koushinsha_id
            ,k.yukoukikan_start_date
            ,k.yukoukikan_end_date
            ,ki.kikai_name
            ,ki.busho_cd
            ,c.cnt
                  ,to_char(k.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,tn.tantousha_name tourokusha_name
                  ,to_char(k.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,kn.tantousha_name koushinsha_name
                  ,to_char(k.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(k.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   kikai_kouho_master k
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on k.jigyoubu_cd = j.jigyoubu_cd
            left join ( select kikai_cd
                              ,kikai_name
                              ,busho_cd
                        from   kikai_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) ki
              on k.kikai_cd = ki.kikai_cd
            left join ( select  waritsuke_kouho_cd,count(*) cnt
                        from  kikai_kouho_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end
                        group by waritsuke_kouho_cd) c
              on k.waritsuke_kouho_cd = c.waritsuke_kouho_cd
            left join tantousha_master tn
              on k.tourokusha_id = tn.id
            left join tantousha_master kn
              on k.koushinsha_id = kn.id ";


            // SQL条件項目
            $SQLBodyText = "
            where  k.sakujo_dt is null
            and    k.sub_seqno=1
            and    :today <= case when k.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else k.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by k.waritsuke_kouho_cd,k.sub_seqno asc";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            //　割付CD
            if(!is_null($request -> dataWaritsukeKouhoCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and s.waritsuke_kouho_cd ilike :waritsuke_kouho_cd ";
                // バインドの設定
                $SQLBind[] = array(':waritsuke_kouho_cd', $query -> GetLikeValue($request -> dataWaritsukeKouhoCd), TYPE_STR);
            }

            // 割付名
            if(!is_null($request -> dataWaritsukeKouhoName))
            {
                // SQL条件文追加
                $SQLBodyText .= " and s.waritsuke_kouho_name ilike :waritsuke_kouho_name ";
                // バインドの設定
                $SQLBind[] = array(':waritsuke_kouho_name', $query -> GetLikeValue($request -> dataWaritsukeKouhoName), TYPE_STR);
            }

            // 機械CD
            if(!is_null($request -> dataKikaiCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and k.kikai_cd ilike :kikai_cd ";
                // バインドの設定
                $SQLBind[] = array(':kikai_cd', $query -> GetLikeValue($request -> dataKikaiCd), TYPE_STR);
            }

            //事業部CD
            if(!is_null($request -> dataJigyoubuCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and s.jigyoubu_cd ilike :jigyoubu_cd ";
                // バインドの設定
                $SQLBind[] = array(':jigyoubu_cd', $query -> GetLikeValue($request -> dataJigyoubuCd), TYPE_STR);
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
            // 配列番号
            $index = 0;
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                $dataArray = array(
                    'dataId'            => $value['id'],
                    'dataJigyoubuCd'    => $value['jigyoubu_cd'],
                    'dataJigyoubuName'    => $value['jigyoubu_name'],
                    'dataWaritsukeKouhoCd'  => $value['waritsuke_kouho_cd'],
                    'dataSubNo'       => $value['sub_seqno'] ,
                    'dataWaritsukeKouhoName'     => $value['waritsuke_kouho_name'] ,
                    'dataSetsumeibun'   => $value['setsumeibun'] ,
                    'dataKikaiCd'   => $value['kikai_cd'] ,
                    'dataKikaiName'   => $value['kikai_name'] ,
                    'dataKakouSkill'    => $value['kakou_nouryoku'] ,
                    'dataKakouNouryokuKeisu'     => $value['kakou_nouryoku_keisu'] ,
                    'dataStartDate'     => $value['yukoukikan_start_date'] ,
                    'dataEndDate'       => $value['yukoukikan_end_date'] ,
                    'dataTourokuDt'     => $value['touroku_dt'] ,
                    'dataTourokushaName'  => $value['tourokusha_name'] ,
                    'dataTourokushaId'  => $value['tourokusha_id'] ,
                    'dataKoushinDt'     => $value['koushin_dt'] ,
                    'dataKoushinshaName'  => $value['koushinsha_name'] ,
                    'dataKoushinshaId'  => $value['koushinsha_id'] ,
                    'dataBushoCd'  => $value['busho_cd'] ,
                    'dataCntWaritsukeCd'  => $value['cnt'] ,
                    'dataIndex'        => $index
                );
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
