<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;

/**
 * グリッドデータ取得クラス　「担当者マスター」
 */
class PCMST_0400 extends Controller
{
    /**
     * 一覧データ出力
     *
     * @param Request $request POST受信データ
     * 
     * @return array $resultData 一覧グリッドデータ
     */
    public function index(Request $request)
    {
        /** boolean $resultFlg      処理成功フラグ */
        $resultFlg = true;
        /** array   $data           グリッドデータ用データ格納配列変数 */
        $data = array();
        /** App\Http\Controllers\Classes\class_Database データベース接続クラス宣言 */
        $query = new class_Database();
        try {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            /** string $SQLHeadText SQL選択項目 */
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
            /** string $SQLBodyText SQL条件項目 */
            $SQLBodyText = "
            where  p.sakujo_dt is null
            and    :today <= case when p.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else p.yukoukikan_end_date end ";
            /** string $SQLTailText SQL並び順 */
            $SQLTailText = "
            order by p.id ";
            /** array $SQLBind SQLバインド値 */
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

            ///////////////////
            // 送信データ作成 //
            ///////////////////
            /** string $noeDate 現在年月日 */
            $nowDate = date("Y-m-d");
            /** string $SQLText 実行SQL文 */
            $SQLText = $SQLHeadText . $SQLBodyText . $SQLTailText;
            // DB接続
            $query->StartConnect();
             // SQL文セット
            $query->SetQuery($SQLText, SQL_SELECT);
            // バインド値のセット
            $SQLBind[] = array('today', $nowDate, TYPE_DATE);
            $query->SetBindArray($SQLBind);
            // SQLの実行
            /** array $result 実行結果データ */
            $result = $query->ExecuteSelect();
            ///////////////////
            // データ取得のみ //
            ///////////////////
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                /** array $dataArray 取得レコードデータ */
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
                    'dataKoushinshaName' => $value['koushinsha_name']
                );
                // 1行ずつデータ配列をグリッドデータ用配列に格納
                $data[] = $dataArray;
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $data = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        } finally {
            $query->CloseQuery();
        }
       /** array $resultData 出力データ */
       $resultData = array();
       $resultData[] = $resultFlg;
       $resultData[] = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
       // 処理結果送信
       return $resultData;
    }
}
