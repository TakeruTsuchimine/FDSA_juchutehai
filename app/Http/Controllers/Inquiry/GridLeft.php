<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class GridLeft extends Controller
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
            select p.id
                  ,p.tantousha_cd
                  ,p.tantousha_name
                  ,p.busho_cd
                  ,b.busho_name
                  ,p.kengen_kbn
                  ,p.menu_group_cd
                  ,m.menu_group_name
                  ,to_char(p.nyusha_date, 'yyyy/mm/dd') nyusha_date
                  ,to_char(p.taishoku_date, 'yyyy/mm/dd') taishoku_date
                  ,to_char(p.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,tn.tantousha_name tourokusha_name
                  ,to_char(p.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,kn.tantousha_name koushinsha_name
                  ,to_char(p.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(p.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   tantousha_master p
            left join ( select busho_cd
                              ,busho_name
                        from   busho_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) b
              on p.busho_cd = b.busho_cd
            left join ( select menu_group_cd
                              ,menu_group_name 
                        from   menu_group_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) m
              on p.menu_group_cd = m.menu_group_cd 
            left join tantousha_master tn
              on p.tourokusha_id = tn.id
            left join tantousha_master kn
              on p.koushinsha_id = kn.id ";

            // SQL条件項目
            $SQLBodyText = "
            where  p.sakujo_dt is null
            and    :today <= case when p.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else p.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by p.id ";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from   tantousha_master p ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 担当者CD
            if (!is_null($request->dataTantoushaCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and p.tantousha_cd ilike :tantousha_cd ";
                // バインドの設定
                $SQLBind[] = array('tantousha_cd', $query->GetLikeValue($request->dataTantoushaCd), TYPE_STR);
            }

            // 担当者名
            if (!is_null($request->dataTantoushaName)) {
                // SQL条件文追加
                $SQLBodyText .= " and p.tantousha_name ilike :tantousha_name ";
                // バインドの設定
                $SQLBind[] = array('tantousha_name', $query->GetLikeValue($request->dataTantoushaName), TYPE_STR);
            }

            // 部署CD
            if (!is_null($request->dataBushoCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and p.busho_cd ilike :busho_cd ";
                // バインドの設定
                $SQLBind[] = array('busho_cd', $query->GetLikeValue($request->dataBushoCd), TYPE_STR);
            }

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
                    $dataArray = array(
                        'dataId' => $value['id'],
                        'dataBushoCd' => $value['busho_cd'],
                        'dataBushoName' => $value['busho_name'],
                        'dataTantoushaCd' => $value['tantousha_cd'],
                        'dataTantoushaName' => $value['tantousha_name'],
                        'dataKengenKbn' => $value['kengen_kbn'],
                        'dataMenuGroupCd' => $value['menu_group_cd'],
                        'dataMenuGroupName' => $value['menu_group_name'],
                        'dataNyushaDate' => $value['nyusha_date'],
                        'dataTaishokuDate' => $value['taishoku_date'],
                        'dataStartDate' => $value['yukoukikan_start_date'],
                        'dataEndDate' => $value['yukoukikan_end_date'],
                        'dataTourokuDt' => $value['touroku_dt'],
                        'dataTourokushaName' => $value['tourokusha_name'],
                        'dataKoushinDt' => $value['koushin_dt'],
                        'dataKoushinshaName' => $value['koushinsha_name'],
                        'dataIndex'        => $index 
                    );
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
        try
        {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            // SQL選択項目
            $SQLHeadText = " select
            s.id
            ,s.jigyoubu_cd
            ,j.jigyoubu_name
            ,s.waritsuke_kouho_cd
            ,s.sub_seqno
            ,s.waritsuke_kouho_name
            ,s.setsumeibun
            ,p.tantousha_cd
            ,p.tantousha_name
            ,s.kakou_skill
            ,s.kakou_nouryoku_keisu
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
            ";

            //,count(s.waritsuke_kouho_cd)

            // SQL条件項目
            $SQLBodyText = "
            where  s.sakujo_dt is null
            and    s.yukoukikan_end_date >= :today ";

            // SQL並び順
            $SQLTailText = "
            order by s.waritsuke_kouho_cd,s.sub_seqno asc";


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
                    $SQLBodyText .= " and s.waritsuke_kouho_cd = :wc ";
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
                    $SQLBodyText .= " and s.waritsuke_kouho_name = :wn ";
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
                     'dataTantoushaCd'      => $value['tantousha_cd'] ,
                     'dataTantoushaName'      => $value['tantousha_name'] ,
                     'dataKakouSkill'    => $value['kakou_skill'] ,
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
