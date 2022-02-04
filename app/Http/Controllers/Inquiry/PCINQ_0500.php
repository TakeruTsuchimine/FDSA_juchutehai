<?php
namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;

class PCINQ_0500 extends Controller
{
    public function index(Request $request)
    {
        // 処理成功フラグ
        $resultFlg = true;
        // グリッドデータ用データ格納用変数宣言
        $data;
        // データベース接続宣言
        $query = new class_Database();
        try
        {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            // SQL選択項目
            $SQLHeadText = "
            select s.id
                  ,s.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,s.waritsuke_kouho_cd
                  ,s.sub_seqno
                  ,s.waritsuke_kouho_name
                  ,s.setsumeibun
                  ,s.tantosha_id
                  ,p.tantousha_cd
                  ,p.tantousha_name
                  ,s.kakou_skill
                  ,s.kakou_nouryoku_keisu
                  ,s.touroku_dt
                  ,s.tourokusha_id
                  ,s.koushin_dt
                  ,s.koushinsha_id
                  ,s.yukoukikan_start_date
                  ,s.yukoukikan_end_date 
                  ,p.busho_cd
                        ,to_char(s.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                        ,to_char(s.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                        ,to_char(s.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                        ,to_char(s.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
                  from   tantousha_kouho_master s  
                  left join ( select jigyoubu_cd
                                    ,jigyoubu_name 
                              from   jigyoubu_master 
                              where  sakujo_dt is null
                              and    :today >= yukoukikan_start_date
                              and    :today <= case when yukoukikan_end_date is null
                                                    then '2199-12-31'
                                                    else yukoukikan_end_date end ) j
                    on s.jigyoubu_cd = j.jigyoubu_cd  
                  left join ( select tantousha_cd 
                                    ,tantousha_name
                                    ,busho_cd
                              from   tantousha_master
                              where  sakujo_dt is null
                              and    :today >= yukoukikan_start_date
                              and    :today <= case when yukoukikan_end_date is null
                                                    then '2199-12-31'
                                                    else yukoukikan_end_date end ) p
                    on s.tantousha_cd = p.tantousha_cd 
                  left join ( select  waritsuke_kouho_cd,count(*) cnt
                              from tantousha_kouho_master 
                              where  sakujo_dt is null
                              and    :today >= yukoukikan_start_date
                              and    :today <= case when yukoukikan_end_date is null
                                                    then '2199-12-31'
                                                    else yukoukikan_end_date end
                              group by waritsuke_kouho_cd) c 
                    on s.waritsuke_kouho_cd = c.waritsuke_kouho_cd";
            // SQL条件項目
            $SQLBodyText = "
            where  sakujo_dt is null
            and    s.sub_seqno=1
            and    :today >= yukoukikan_start_date
            and    :today <= case when yukoukikan_end_date is null
                                  then '2199-12-31' else yukoukikan_end_date end ";
            $SQLTailText = "
            order by s.waritsuke_kouho_cd,s.sub_seqno asc ";
            // SQLバインド値
            $SQLBind = array();
            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 検索CD
            if(!is_null($request -> dataKensakuCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and waritsuke_kouho_cd ilike :kensaku_cd ";
                // バインドの設定
                $SQLBind[] = array('kensaku_cd', $query -> GetLikeValue($request -> dataKensakuCd), TYPE_STR);
            }
            // 検索名
            if(!is_null($request -> dataKensakuName))
            {
                // SQL条件文追加
                $SQLBodyText .= " and waritsuke_kouho_name ilike :kensaku_name ";
                // バインドの設定
                $SQLBind[] = array('kensaku_name', $query -> GetLikeValue($request -> dataKensakuName), TYPE_STR);
            }
            ///////////////////
            // 送信データ作成 //
            ///////////////////
            //現在年月日
            $nowDate = date("Y-m-d");
            // クエリの設定
            $SQLText = $SQLHeadText.$SQLBodyText.$SQLTailText;
            $query -> StartConnect();
            $query -> SetQuery($SQLText, SQL_SELECT);
            // バインド値のセット
            $query -> SetBindArray($SQLBind);
            $query -> SetBindValue("today" , $nowDate, TYPE_DATE);
            // クエリの実行
            $result = $query -> ExecuteSelect();
            ///////////////////
            // データ取得のみ //
            ///////////////////
            $data = array();
            // 結果データの格納
            foreach($result as $value)
            {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                $dataArray = array();
                $dataArray = $dataArray + array( 'dataSentakuCd'   => $value['waritsuke_kouho_cd'] );
                $dataArray = $dataArray + array( 'dataSentakuName' => $value['waritsuke_kouho_name'] );
                // 1行ずつデータ配列をグリッドデータ用配列に格納
                $data[] = $dataArray;
            }  
        }
        catch ( PDOException $e )
        {
            $resultFlg = false;
            $data =  $e -> getMessage();
        }
        finally
        {
            $query -> CloseQuery();
        }
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}