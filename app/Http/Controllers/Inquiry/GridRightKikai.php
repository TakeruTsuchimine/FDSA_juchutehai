<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class GridRightKikai extends Controller
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
            ,z.kikai_name
            ,z.busho_cd
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
            ";

            //,count(s.waritsukekouho_cd)

            // SQL条件項目
            $SQLBodyText = "
            where  k.sakujo_date is null
            and    k.yukoukikan_end_date >= :today 
            ";

            // SQL並び順
            $SQLTailText = "
            order by k.waritsukekouho_cd,k.sub_seq asc";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 担当割付候補CD
            if(isset($_POST['dataWaritsukekouhoCd']))
            {
                if($_POST['dataWaritsukekouhoCd'] !== '')
                {
                    // SQL条件文追加
                    $SQLBodyText .= " and k.waritsukekouho_cd = :wc ";
                    // バインドの設定
                    $SQLBind[] = array('wc', $_POST['dataWaritsukekouhoCd'], TYPE_STR);
                }
            }
            // 担当割付候補CD
            if(isset($_POST['dataWaritsukekouhoName']))
            {
                if($_POST['dataWaritsukekouhoName'] !== '')
                {
                    // SQL条件文追加
                    $SQLBodyText .= " and k.waritsukekouho_name = :wn ";
                    // バインドの設定
                    $SQLBind[] = array('wn', $_POST['dataWaritsukekouhoName'], TYPE_STR);
                }
            }


            ///////////////////
            // 送信データ作成 //
            ///////////////////
            //現在年月日
            $nowDate = date("Y-m-d");
            // クエリの設定
            $SQLText = ($SQLHeadText.$SQLBodyText.$SQLTailText);
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
                // 配列番号
                $index = 0;
                
                // 結果データの格納
                foreach($result as $value){

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
                    $dataArray = $dataArray + array( 'dataKoushinDt'     => $value['koushin_dt'] );
                    $dataArray = $dataArray + array( 'dataBumonCd'  => $value['busho_cd'] );
                    $dataArray = $dataArray + array( 'dataIndex'        => $index );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $data[] = $dataArray;
                    // 配列番号を進める
                    $index = $index + 1;
                }
            
        }
        catch ( \Throwable $e )
        {
            $resultFlg = false;
            $data = $e -> getMessage().' File：'.$e -> getFile().' Line：'.$e -> getLine();
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