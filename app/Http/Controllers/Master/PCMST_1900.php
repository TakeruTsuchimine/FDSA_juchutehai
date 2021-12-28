<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_1900 extends Controller
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
            $SQLHeadText = "select
            g.id
            ,j.jigyoubu_name 
            ,g.jigyoubu_cd 
            ,g.waritsukekouho_cd 
            ,g.sub_seq 
            ,g.waritsukekouho_name 
            ,g.setsumeibun 
            ,s.shiiresaki_name1
            ,s.shiharaisaki_cd
            ,g.shiiresaki_cd 
            ,g.kakou_skill 
            ,c.cnt
            ,to_char(g.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
            ,to_char(g.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
            ,to_char(g.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
            ,to_char(g.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from  gaichu_kouho_master g 
            left join ( select jigyoubu_cd
                                ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_date is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                                then '2199-12-31'
                                                else yukoukikan_end_date end )j 
                on g.jigyoubu_cd = j.jigyoubu_cd
            left join ( select shiiresaki_cd
                                ,shiiresaki_name1
                                ,shiharaisaki_cd
                        from   shiiresaki_master
                        where  sakujo_date is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                                then '2199-12-31'
                                                else yukoukikan_end_date end )s 
                on g.shiiresaki_cd = s.shiiresaki_cd 
                left join ( select  waritsukekouho_cd,count(*) cnt
                            from   gaichu_kouho_master 
                            where  sakujo_date is null
                            and    :today >= yukoukikan_start_date
                            and    :today <= case when yukoukikan_end_date is null
                                                then '2199-12-31'
                                                else yukoukikan_end_date end
                                                    group by waritsukekouho_cd) c 
                on g.waritsukekouho_cd = c.waritsukekouho_cd";
            
            // SQL条件項目
            $SQLBodyText = "
            where  g.sakujo_date is null
            and    g.sub_seq = 1
            and    :today <= case when g.yukoukikan_end_date is null
                                    then '2199-12-31' else g.yukoukikan_end_date end ";
            
            // SQL並び順
            $SQLTailText = "
            order by g.waritsukekouho_cd
                    ,g.sub_seq asc";
            
            // SQL件数取得
            $SQLCntText = "
            select count(distinct waritsukekouho_cd)
            from   gaichu_kouho_master g ";
            
            // SQLバインド値
            $SQLBind = array();
            ///////////////////
            // POSTデータ受信 //
            ///////////////////

            // 仕入外注先CD
            if(!is_null($request -> shiiresakiCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and g.shiiresaki_cd ilike :shiiresaki_cd ";
                // バインドの設定
                $SQLBind[] = array(':shiiresaki_cd', $query -> GetLikeValue($request -> dataShiiresakiCd), TYPE_STR);
            }
            
            //　割付CD
            if(!is_null($request -> dataWaritsukekouhoCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and g.waritsukekouho_cd  ilike :waritsukekouho_cd ";
                // バインドの設定
                $SQLBind[] = array(':waritsukekouho_cd ', $query -> GetLikeValue($request -> dataWaritsukekouhoCd), TYPE_STR);
            }

            // 割付名
            if(!is_null($request -> dataWaritsukekouhoName))
            {
                // SQL条件文追加
                $SQLBodyText .= " and g.waritsukekouho_name  ilike :waritsukekouho_name ";
                // バインドの設定
                $SQLBind[] = array(':waritsukekouhoname ', $query -> GetLikeValue($request -> dataWaritsukekouhoName), TYPE_STR);
            } 

            //事業部CD
            if(!is_null($request -> dataJigyoubuCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and g.jigyoubu_cd ilike :jigyoubu_cd ";
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
                    $dataArray = $dataArray + array( 'dataId' => $value['id'] );
                    $dataArray = $dataArray + array( 'dataJigyoubuCd' => $value['jigyoubu_cd'] );
                    $dataArray = $dataArray + array( 'dataJigyoubuName' => $value['jigyoubu_name'] );
                    $dataArray = $dataArray + array( 'dataWaritsukekouhoCd' => $value['waritsukekouho_cd'] );
                    $dataArray = $dataArray + array( 'dataSubNo' => $value['sub_seq'] );
                    $dataArray = $dataArray + array( 'dataWaritsukekouhoName' => $value['waritsukekouho_name'] );
                    $dataArray = $dataArray + array( 'dataSetsumeibun' => $value['setsumeibun'] );
                    $dataArray = $dataArray + array( 'dataShiiresakiCd' => $value['shiiresaki_cd'] );
                    $dataArray = $dataArray + array( 'dataShiiresakiName1' => $value['shiiresaki_name1'] );
                    $dataArray = $dataArray + array( 'dataKakouSkill' => $value['kakou_skill'] );
                    $dataArray = $dataArray + array( 'dataStartDate'     => $value['yukoukikan_start_date'] );
                    $dataArray = $dataArray + array( 'dataEndDate'       => $value['yukoukikan_end_date'] );
                    $dataArray = $dataArray + array( 'dataTourokuDt'     => $value['touroku_dt'] );
                    $dataArray = $dataArray + array( 'dataKoushinDt'     => $value['koushin_dt'] );
                    $dataArray = $dataArray + array( 'dataCntWaritsukeCd'  => $value['cnt'] );
                    $dataArray = $dataArray + array( 'dataShiharaisakiCd'  => $value['shiharaisaki_cd'] );
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
