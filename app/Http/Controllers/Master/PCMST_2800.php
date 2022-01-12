<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_2800 extends Controller
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
            select h.id
                  ,h.tokuisaki_cd
                  ,t.tokuisaki_name1
                  ,h.hinmoku_cd
                  ,to_char(h.tekiyou_date, 'yyyy/mm/dd') tekiyou_date
                  ,h.tekiyou_saishou_qty
                  ,case h.shouhizei_kbn
                  when 0 then '0:非課税'
                  when 1 then '1:外税'
                  when 2 then '2:内税'
                  end shouhizei_kbn
                  ,case h.keigenzeiritsu_kbn
                  when 0 then '0:未'
                  when 1 then '1:軽減税率適用'
                  end keigenzeiritsu_kbn
                  ,h.uri_tanka
                  ,h.kyu_tanka
                  ,case h.kari_kbn
                  when 0 then '0:未'
                  when 1 then '1:仮単価'
                  end kari_kbn
                  ,case h.mishori_kbn
                  when 0 then '0:未'
                  when 1 then '1:未設定'
                  end mishori_kbn
                  ,h.bikou
                  ,to_char(h.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,tn.tantousha_name tourokusha_name
                  ,to_char(h.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,kn.tantousha_name koushinsha_name
                  ,to_char(h.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(h.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   hinmoku_uriagetanka_master h
            left join ( select tokuisaki_cd
                              ,tokuisaki_name1
                        from   tokuisaki_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) t
              on h.tokuisaki_cd = t.tokuisaki_cd
            left join tantousha_master tn
              on h.tourokusha_id = tn.id
            left join tantousha_master kn
              on h.koushinsha_id = kn.id ";

            // SQL条件項目
            $SQLBodyText = "
            where  h.sakujo_dt is null
            and    :today <= case when h.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else h.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by h.id ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 得意先CD
            if (!is_null($request->dataTokuisakiCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and h.tokuisaki_cd ilike :tokuisaki_cd ";
                // バインドの設定
                $SQLBind[] = array('tokuisaki_cd!', $query->GetLikeValue($request->dataTokuisakiCd), TYPE_STR);
            }

            // 品目CD
            if (!is_null($request->dataHinmokuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and h.hinmoku_cd ilike :hinmoku_cd ";
                // バインドの設定
                $SQLBind[] = array('hinmoku_cd', $query->GetLikeValue($request->dataHinmokuCd), TYPE_STR);
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
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                $dataArray = array(
                    'dataId' => $value['id'],
                    'dataTokuisakiCd' => $value['tokuisaki_cd'],
                    'dataTokuisakiName1' => $value['tokuisaki_name1'],
                    'dataHinmokuCd' => $value['hinmoku_cd'],
                    'dataTekiyouDate' => $value['tekiyou_date'],
                    'dataTekiyouSaishouQty' => $value['tekiyou_saishou_qty'],
                    'dataShouhizeiKbn' => $value['shouhizei_kbn'],
                    'dataKeigenzeiritsuKbn' => $value['keigenzeiritsu_kbn'],
                    'dataUriTanka' => $value['uri_tanka'],
                    'dataKyuTanka' => $value['kyu_tanka'],
                    'dataKariKbn' => $value['kari_kbn'],
                    'dataMishoriKbn' => $value['mishori_kbn'],
                    'dataBikou' => $value['bikou'],
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
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}
