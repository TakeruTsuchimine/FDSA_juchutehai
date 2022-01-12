<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_6300 extends Controller
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
            select s.id
                  ,s.seikyu_cd
                  ,s.seikyu_busho_name
                  ,s.seikyu_zip
                  ,s.seikyu_jusho
                  ,s.tel_no
                  ,s.fax_no
                  ,s.ginkou1
                  ,s.ginkou2
                  ,s.ginkou3
                  ,to_char(s.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,tn.tantousha_name tourokusha_name
                  ,to_char(s.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,kn.tantousha_name koushinsha_name
                  ,to_char(s.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(s.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   seikyu_master s
            left join tantousha_master tn
              on s.tourokusha_id = tn.id
            left join tantousha_master kn
              on s.koushinsha_id = kn.id ";

            // SQL条件項目
            $SQLBodyText = "
            where  s.sakujo_dt is null
            and    :today <= case when s.yukoukikan_end_date is null
                                  then '2199/12/31'
                                  else s.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by s.id ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 請求CD
            if(!is_null($request -> dataSeikyuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and s.seikyu_cd ilike :seikyu_cd ";
                // バインドの設定
                $SQLBind[] = array('seikyu_cd', $query->GetLikeValue($request->dataSeikyuCd), TYPE_STR);
            }

            // 請求部署名
            if(!is_null($request->dataSeikyuBushoName)) {
                // SQL条件文追加
                $SQLBodyText .= " and s.seikyu_busho_name ilike :seikyu_busho_name ";
                // バインドの設定
                $SQLBind[] = array('seikyu_busho_name', $query->GetLikeValue($request->dataSeikyuBushoName), TYPE_STR);
            }

            ///////////////////
            // 送信データ作成 //
            ///////////////////
            //現在年月日
            $nowDate = date("Y-m-d");
            // クエリの設定
            $SQLText = ($cntFlg ? $SQLCntText.$SQLBodyText : $SQLHeadText.$SQLBodyText.$SQLTailText);
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
            // 結果データの格納
            foreach($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                $dataArray = array(
                    'dataId' => $value['id'],
                    'dataSeikyuCd'     => $value['seikyu_cd'],
                    'dataSeikyuBushoName'   => $value['seikyu_busho_name'],
                    'dataSeikyuZip' => $value['seikyu_zip'],
                    'dataSeikyuJusho'  => $value['seikyu_jusho'],
                    'dataTelNo' => $value['tel_no'],
                    'dataFaxNo'  => $value['fax_no'],
                    'dataGinkou1' => $value['ginkou1'],
                    'dataGinkou2'  => $value['ginkou2'],
                    'dataGinkou3' => $value['ginkou3'],
                    'dataStartDate'      => $value['yukoukikan_start_date'],
                    'dataEndDate'        => $value['yukoukikan_end_date'],
                    'dataTourokuDt'      => $value['touroku_dt'],
                    'dataTourokushaName'      => $value['tourokusha_name'],
                    'dataKoushinDt'      => $value['koushin_dt'],
                    'dataKoushinshaName'      => $value['koushinsha_name']
                );
                // 1行ずつデータ配列をグリッドデータ用配列に格納
                $data[] = $dataArray;
            }
        }
        catch ( \Throwable $e )
        {
            if($resultFlg)
            {
                $resultFlg = false;
                $data = $e -> getMessage().' File：'.$e -> getFile().' Line：'.$e -> getLine();
            }
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