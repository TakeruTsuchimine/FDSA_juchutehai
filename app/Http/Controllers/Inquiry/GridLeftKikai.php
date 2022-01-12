<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class GridLeftKikai extends Controller
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
                  ,b.busho_cd
                  ,b.busho_name
                  ,k.kikai_cd
                  ,k.kikai_name
                  ,k.bikou
                  ,k.std_kadou_min
                  ,k.main_koutei_cd
                  ,cast(cast(k.mujinkadou_kbn as character varying) as integer) mujinkadou_kbn
                  ,cast(cast(k.sotodandori_kbn as character varying) as integer) sotodandori_kbn
                  ,to_char(k.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(k.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(k.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(k.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   kikai_master k
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on k.jigyoubu_cd = j.jigyoubu_cd
            left join ( select busho_cd
                              ,busho_name
                        from   busho_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) b
              on k.busho_cd = b.busho_cd";

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

            // 検索件数取得フラグ
            $cntFlg = false;
            if (!is_null($request->dataCntFlg)) $cntFlg = (bool)$request->dataCntFlg;

            if(isset($_POST['dataSQLtype'])){
                $sqlType = $_POST['dataSQLtype'];
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
                    $dataArray = array(
                        'dataId' => $value['id'],
                        'dataJigyoubuCd' => $value['jigyoubu_cd'],
                        'dataJigyoubuName' => $value['jigyoubu_name'],
                        'dataBushoCd' => $value['busho_cd'],
                        'dataBushoName' => $value['busho_name'],
                        'dataKikaiCd' => $value['kikai_cd'],
                        'dataKikaiName' => $value['kikai_name'],
                        'dataBikou' => $value['bikou'],
                        'dataStdKadouMin' => $value['std_kadou_min'],
                        'dataMainKouteiCd' => $value['main_koutei_cd'],
                        'dataMujinkadouKbn' => $value['mujinkadou_kbn'],
                        'dataSotodandoriKbn' => $value['sotodandori_kbn'],
                        'dataStartDate' => $value['yukoukikan_start_date'],
                        'dataEndDate' => $value['yukoukikan_end_date'],
                        'dataTourokuDt' => $value['touroku_dt'],
                        'dataKoushinDt' => $value['koushin_dt'],
                        'dataIndex'        => $index 
                    );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $data[] = $dataArray;
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
            ,k.waritsuke_kouho_cd
            ,k.sub_seqno
            ,k.waritsuke_kouho_name
            ,k.setsumeibun
            ,ki.kikai_cd
            ,k.kakou_nouryoku
            ,k.kakou_nouryoku_keisu
            ,ki.kikai_name
            ,ki.busho_cd
            ,to_char(k.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
            ,to_char(k.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
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
            ";

            //,count(s.waritsuke_kouho_cd)

            // SQL条件項目
            $SQLBodyText = "
            where  k.sakujo_dt is null
            and    k.yukoukikan_end_date >= :today ";

            // SQL並び順
            $SQLTailText = "
            order by k.waritsuke_kouho_cd,k.sub_seqno asc";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 担当割付候補CD
            if(isset($_POST['dataWaritsukeKouhoCd']))
            {
                if($_POST['dataWaritsukeKouhoCd'] !== '')
                {
                    // SQL条件文追加
                    $SQLBodyText .= " and k.waritsuke_kouho_cd = :wc ";
                    // バインドの設定
                    $SQLBind[] = array('wc', $_POST['dataWaritsukeKouhoCd'], TYPE_STR);
                }
            }
            // 担当割付候補CD
            if(isset($_POST['dataWaritsukeKouhoName']))
            {
                if($_POST['dataWaritsukeKouhoName'] !== '')
                {
                    // SQL条件文追加
                    $SQLBodyText .= " and k.waritsuke_kouho_name = :wn ";
                    // バインドの設定
                    $SQLBind[] = array('wn', $_POST['dataWaritsukeKouhoName'], TYPE_STR);
                }
            }
            if(isset($_POST['dataSQLtype'])){
                $sqlType = $_POST['dataSQLtype'];
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
                $data2 = array();
                // 配列番号
                $index = 0;

                // 結果データの格納
                foreach($result as $value){
                    // JSONオブジェクト用に配列に名前を付けてデータ格納
                    $dataArray = array(
                     'dataId'            => $value['id'] ,
                     'dataJigyoubuCd'    => $value['jigyoubu_cd'] ,
                     'dataJigyoubuName'    => $value['jigyoubu_name'] ,
                     'dataWaritsukeKouhoCd'  => $value['waritsuke_kouho_cd'] ,
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
                     'dataKoushinDt'     => $value['koushin_dt'] ,
                     'dataBushoCd'  => $value['busho_cd'] ,
                     'dataIndex'        => $index
                    );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $data2[] = $dataArray;
                    // 配列番号を進める
                    $index = $index + 1;
                }

        }
        catch ( \Throwable $e )
        {
            $resultFlg = false;
            $data2 = $e -> getMessage().' File：'.$e -> getFile().' Line：'.$e -> getLine();
        }
        finally
        {
            $query -> CloseQuery();
        }
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        $resultData[] = $sqlType;
        $resultData[] = mb_convert_encoding($data2, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}
