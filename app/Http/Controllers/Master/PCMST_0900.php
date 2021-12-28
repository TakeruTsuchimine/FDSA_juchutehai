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
            ,k.waritsukekouho_cd
            ,k.sub_seq
            ,k.waritsukekouho_name
            ,k.setsumeibun
            ,z.kikai_cd
            ,k.kakou_nouryoku
            ,k.kakou_nouryoku_keisu
            ,k.touroku_dt
            ,k.tourokusha_id
            ,k.koushin_dt
            ,k.koushinsha_id
            ,k.yukoukikan_start_date
            ,k.yukoukikan_end_date 
            ,z.kikai_name
            ,z.busho_cd
            ,c.cnt
                  ,to_char(k.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(k.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(k.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(k.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   kikai_kouho_master k  
            left join ( select jigyoubu_cd
                              ,jigyoubu_name 
                        from   jigyoubu_master 
                        where  sakujo_date is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on k.jigyoubu_cd = j.jigyoubu_cd  
            left join ( select kikai_cd 
                              ,kikai_name
                              ,busho_cd
                        from   kikai_master
                        where  sakujo_date is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) z
              on k.kikai_cd = z.kikai_cd 
            left join ( select  waritsukekouho_cd,count(*) cnt
                        from  kikai_kouho_master 
                        where  sakujo_date is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end
                        group by waritsukekouho_cd) c 
              on k.waritsukekouho_cd = c.waritsukekouho_cd";


            // SQL条件項目
            $SQLBodyText = "
            where  k.sakujo_date is null
            and    k.sub_seq=1
            and    :today <= case when k.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else k.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by k.waritsukekouho_cd,k.sub_seq asc";

            // SQL件数取得
            $SQLCntText = "
            select count(distinct waritsukekouho_cd)
            from   kikai_kouho_master k ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            //　割付CD
            if(!is_null($request -> dataWaritsukekouhoCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and s.waritsukekouho_cd ilike :waritsukekouho_cd ";
                // バインドの設定
                $SQLBind[] = array(':waritsukekouho_cd', $query -> GetLikeValue($request -> dataWaritsukekouhoCd), TYPE_STR);
            }

            // 割付名
            if(!is_null($request -> dataWaritsukekouhoName))
            {
                // SQL条件文追加
                $SQLBodyText .= " and s.waritsukekouho_name ilike :waritsukekouho_name ";
                // バインドの設定
                $SQLBind[] = array(':waritsukekouho_name', $query -> GetLikeValue($request -> dataWaritsukekouhoName), TYPE_STR);
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
                    $dataArray = $dataArray + array( 'dataId'            => $value['id'] );
                    $dataArray = $dataArray + array( 'dataJigyoubuCd'    => $value['jigyoubu_cd'] );
                    $dataArray = $dataArray + array( 'dataJigyoubuName'    => $value['jigyoubu_name'] );
                    $dataArray = $dataArray + array( 'dataWaritsukekouhoCd'  => $value['waritsukekouho_cd'] );
                    $dataArray = $dataArray + array( 'dataSubNo'       => $value['sub_seq'] );
                    $dataArray = $dataArray + array( 'dataWaritsukekouhoName'     => $value['waritsukekouho_name'] );
                    $dataArray = $dataArray + array( 'dataSetsumeibun'   => $value['setsumeibun'] );
                    $dataArray = $dataArray + array( 'dataKikaiCd'   => $value['kikai_cd'] );
                    $dataArray = $dataArray + array( 'dataKikaiName'   => $value['kikai_name'] );
                    $dataArray = $dataArray + array( 'dataKakouSkill'    => $value['kakou_nouryoku'] );
                    $dataArray = $dataArray + array( 'dataKakounouryoku_keisu'     => $value['kakou_nouryoku_keisu'] );
                    $dataArray = $dataArray + array( 'dataStartDate'     => $value['yukoukikan_start_date'] );
                    $dataArray = $dataArray + array( 'dataEndDate'       => $value['yukoukikan_end_date'] );
                    $dataArray = $dataArray + array( 'dataTourokuDt'     => $value['touroku_dt'] );
                    $dataArray = $dataArray + array( 'dataTourokushaId'  => $value['tourokusha_id'] );
                    $dataArray = $dataArray + array( 'dataKoushinDt'     => $value['koushin_dt'] );
                    $dataArray = $dataArray + array( 'dataKoushinshaId'  => $value['koushinsha_id'] );
                    $dataArray = $dataArray + array( 'dataBumonCd'  => $value['busho_cd'] );
                    $dataArray = $dataArray + array( 'dataCntWaritsukeCd'  => $value['cnt'] );
                    $dataArray = $dataArray + array( 'dataIndex'        => $index );
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
