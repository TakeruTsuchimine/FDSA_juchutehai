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
            ,g.waritsuke_kouho_cd
            ,g.sub_seqno
            ,g.waritsuke_kouho_name
            ,g.setsumeibun
            ,s.shiiresaki_name1
            ,s.shiharaisaki_cd
            ,g.shiiresaki_cd
            ,g.kakou_skill
            ,c.cnt
            ,to_char(g.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
            ,tn.tantousha_name tourokusha_name
            ,to_char(g.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
            ,kn.tantousha_name koushinsha_name
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
                on g.shiiresaki_cd = s.shiiresaki_cd
                left join ( select  waritsuke_kouho_cd,count(*) cnt
                            from   gaichu_kouho_master
                            where  sakujo_dt is null
                            and    :today >= yukoukikan_start_date
                            and    :today <= case when yukoukikan_end_date is null
                                                then '2199-12-31'
                                                else yukoukikan_end_date end
                                                    group by waritsuke_kouho_cd) c
                on g.waritsuke_kouho_cd = c.waritsuke_kouho_cd
            left join tantousha_master tn
                on g.tourokusha_id = tn.id
            left join tantousha_master kn
                on g.koushinsha_id = kn.id ";

            // SQL条件項目
            $SQLBodyText = "
            where  g.sakujo_dt is null
            and    g.sub_seqno = 1
            and    :today <= case when g.yukoukikan_end_date is null
                                    then '2199-12-31' else g.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by g.waritsuke_kouho_cd
                    ,g.sub_seqno asc";

            // SQLバインド値
            $SQLBind = array();
            ///////////////////
            // POSTデータ受信 //
            ///////////////////

            // 仕入外注先CD
            if (!is_null($request->shiiresakiCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and g.shiiresaki_cd ilike :shiiresaki_cd ";
                // バインドの設定
                $SQLBind[] = array(':shiiresaki_cd', $query->GetLikeValue($request->dataShiiresakiCd), TYPE_STR);
            }

            //　割付CD
            if (!is_null($request->dataWaritsukeKouhoCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and g.waritsuke_kouho_cd  ilike :waritsuke_kouho_cd ";
                // バインドの設定
                $SQLBind[] = array(':waritsuke_kouho_cd ', $query->GetLikeValue($request->dataWaritsukeKouhoCd), TYPE_STR);
            }

            // 割付名
            if (!is_null($request->dataWaritsukeKouhoName)) {
                // SQL条件文追加
                $SQLBodyText .= " and g.waritsuke_kouho_name  ilike :waritsuke_kouho_name ";
                // バインドの設定
                $SQLBind[] = array(':waritsukekouhoname ', $query->GetLikeValue($request->dataWaritsukeKouhoName), TYPE_STR);
            }

            //事業部CD
            if (!is_null($request->dataJigyoubuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and g.jigyoubu_cd ilike :jigyoubu_cd ";
                // バインドの設定
                $SQLBind[] = array(':jigyoubu_cd', $query->GetLikeValue($request->dataJigyoubuCd), TYPE_STR);
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
                    'dataId' => $value['id'],
                    'dataJigyoubuCd' => $value['jigyoubu_cd'],
                    'dataJigyoubuName' => $value['jigyoubu_name'],
                    'dataWaritsukeKouhoCd' => $value['waritsuke_kouho_cd'],
                    'dataSubNo' => $value['sub_seqno'],
                    'dataWaritsukeKouhoName' => $value['waritsuke_kouho_name'],
                    'dataSetsumeibun' => $value['setsumeibun'],
                    'dataShiiresakiCd' => $value['shiiresaki_cd'],
                    'dataShiiresakiName1' => $value['shiiresaki_name1'],
                    'dataShiharaisakiCd' => $value['shiharaisaki_cd'],
                    'dataKakouSkill' => $value['kakou_skill'],
                    'dataStartDate'     => $value['yukoukikan_start_date'],
                    'dataEndDate'       => $value['yukoukikan_end_date'],
                    'dataTourokuDt'     => $value['touroku_dt'],
                    'dataTourokushaName'     => $value['tourokusha_name'],
                    'dataKoushinDt'     => $value['koushin_dt'],
                    'dataKoushinshaName'     => $value['koushinsha_name'],
                    'dataCntWaritsukeCd'  => $value['cnt'],
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
