<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class GridRightGaichu extends Controller
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
            g.id
            ,j.jigyoubu_name
            ,g.jigyoubu_cd
            ,g.waritsuke_kouho_cd
            ,g.sub_seqno
            ,g.waritsuke_kouho_name
            ,g.setsumeibun
            ,s.shiiresaki_name1
            ,g.shiiresaki_cd
            ,g.kakou_skill
            ,s.shiharaisaki_cd
            ,to_char(g.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
            ,to_char(g.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
            ,to_char(g.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
            ,to_char(g.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from  gaichu_kouho_master g
            left join ( select jigyoubu_cd
                                ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                                then '2199-12-31'
                                                else yukoukikan_end_date end )j
                on g.jigyoubu_cd = j.jigyoubu_cd
            left join ( select shiiresaki_cd
                                ,shiiresaki_name1
                                ,shiharaisaki_cd
                        from   shiiresaki_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                                then '2199-12-31'
                                                else yukoukikan_end_date end )s
                on g.shiiresaki_cd = s.shiiresaki_cd ";

            //,count(s.waritsuke_kouho_cd)

            // SQL条件項目
            $SQLBodyText = "
            where  g.sakujo_dt is null
            and    g.yukoukikan_end_date >= :today ";

            // SQL並び順
            $SQLTailText = "
            order by g.waritsuke_kouho_cd
                    ,g.sub_seqno asc";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 担当割付候補CD
            if (isset($_POST['dataWaritsukeKouhoCd'])) {
                if ($_POST['dataWaritsukeKouhoCd'] !== '') {
                    // SQL条件文追加
                    $SQLBodyText .= " and g.waritsuke_kouho_cd = :wc ";
                    // バインドの設定
                    $SQLBind[] = array('wc', $_POST['dataWaritsukeKouhoCd'], TYPE_STR);
                }
            }
            // 担当割付候補CD
            if (isset($_POST['dataWaritsukeKouhoName'])) {
                if ($_POST['dataWaritsukeKouhoName'] !== '') {
                    // SQL条件文追加
                    $SQLBodyText .= " and g.waritsuke_kouho_name = :wn ";
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
                    'dataId' => $value['id'] ,
                    'dataJigyoubuCd' => $value['jigyoubu_cd'] ,
                    'dataJigyoubuName' => $value['jigyoubu_name'] ,
                    'dataWaritsukeKouhoCd' => $value['waritsuke_kouho_cd'] ,
                    'dataSubNo' => $value['sub_seqno'] ,
                    'dataWaritsukeKouhoName' => $value['waritsuke_kouho_name'] ,
                    'dataSetsumeibun' => $value['setsumeibun'] ,
                    'dataShiiresakiCd' => $value['shiiresaki_cd'] ,
                    'dataShiiresakiName1' => $value['shiiresaki_name1'] ,
                    'dataKakouSkill' => $value['kakou_skill'] ,
                    'dataStartDate'     => $value['yukoukikan_start_date'] ,
                    'dataEndDate'       => $value['yukoukikan_end_date'] ,
                    'dataTourokuDt'     => $value['touroku_dt'] ,
                    'dataKoushinDt'     => $value['koushin_dt'] ,
                    'dataShiharaisakiCd'  => $value['shiharaisaki_cd'] ,
                    'dataIndex'        => $index
                    );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $data[] = $dataArray;
                    // 配列番号を進める
                    $index = $index + 1;
                }

        }
        catch ( \Throwable $e )
        {
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
