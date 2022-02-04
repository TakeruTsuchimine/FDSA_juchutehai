<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class GridRight extends Controller
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
            ";

            //,count(s.waritsuke_kouho_cd)

            // SQL条件項目
            $SQLBodyText = "
            where  s.sakujo_dt is null
            and    s.yukoukikan_end_date >= :today 
            ";

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
            $SQLText = ($SQLHeadText . $SQLBodyText . $SQLTailText);
            $query->StartConnect();
            $query->SetQuery($SQLText, SQL_SELECT);
            // バインド値のセット
            $query->SetBindArray($SQLBind);
            $query->SetBindValue("today", $nowDate, TYPE_DATE);
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
                    'dataSubNo'       => $value['sub_seqno'],
                    'dataWaritsukeKouhoName'     => $value['waritsuke_kouho_name'],
                    'dataSetsumeibun'   => $value['setsumeibun'],
                    'dataTantoushaId' => $value['tantousha_id'],
                    'dataTantoushaCd'      => $value['tantousha_cd'],
                    'dataTantoushaName'      => $value['tantousha_name'],
                    'dataKakouSkill'    => $value['kakou_skill'],
                    'dataKakouNouryokuKeisu'     => $value['kakou_nouryoku_keisu'],
                    'dataStartDate'     => $value['yukoukikan_start_date'],
                    'dataEndDate'       => $value['yukoukikan_end_date'],
                    'dataTourokuDt'     => $value['touroku_dt'],
                    'dataKoushinDt'     => $value['koushin_dt'],
                    'dataBumonCd'  => $value['busho_cd'],
                    'dataIndex'        => $index
                );
                // 1行ずつデータ配列をグリッドデータ用配列に格納
                $data[] = $dataArray;
                // 配列番号を進める
                $index = $index + 1;
            }
        } catch (\Throwable $e) {
            $resultFlg = false;
            $data = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
        } finally {
            $query->CloseQuery();
        }
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        $resultData[] = $sqlType;
        return $resultData;
    }
}
