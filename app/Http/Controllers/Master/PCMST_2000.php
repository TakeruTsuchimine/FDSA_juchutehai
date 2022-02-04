<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

/**
 * グリッドデータ取得クラス　「メーカーマスター」
 */
class PCMST_2000 extends Controller
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
        $data;
        /** App\Http\Controllers\Classes\class_Database データベース接続クラス宣言 */
        $query = new class_Database();
        try {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            /** string $SQLHeadText SQL選択項目 */
            $SQLHeadText = "
            select m.id
                ,m.maker_cd
                ,m.maker_ryaku
                ,m.maker_name
                ,to_char(m.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                ,tn.tantousha_name tourokusha_name
                ,to_char(m.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                ,kn.tantousha_name koushinsha_name
                ,to_char(m.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                ,to_char(m.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from  maker_master m
            left join tantousha_master tn
              on m.tourokusha_id = tn.id
            left join tantousha_master kn
              on m.koushinsha_id = kn.id ";

            /** string $SQLBodyText SQL条件項目 */
            $SQLBodyText = "
            where  m.sakujo_dt is null
            and    :today <= case when m.yukoukikan_end_date is null
                                then '2199-12-31' else m.yukoukikan_end_date end ";

            /** string $SQLTailText SQL並び順 */
            $SQLTailText = "
            order by m.id ";

            /** array $SQLBind SQLバインド値 */
            $SQLBind = array();
            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // メーカーCD
            if (!is_null($request->makerCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and m.maker_cd ilike :maker_cd ";
                // バインドの設定
                $SQLBind[] = array('maker_cd', $query->GetLikeValue($request->dataMakerCd), TYPE_STR);
            }

            // メーカー名
            if (!is_null($request->makerName)) {
                // SQL条件文追加
                $SQLBodyText .= " and m.maker_name ilike :maker_name ";
                // バインドの設定
                $SQLBind[] = array('maker_name', $query->GetLikeValue($request->dataMakerName), TYPE_STR);
            }

            ///////////////////
            // 送信データ作成 //
            ///////////////////
            /** string $nowDate 現在年月日 */
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
            $data = array();
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                /** array $dataArray 取得レコードデータ */
                $dataArray = array(
                    'dataId' => $value['id'],
                    'dataMakerCd' => $value['maker_cd'],
                    'dataMakerRyaku' => $value['maker_ryaku'],
                    'dataMakerName' => $value['maker_name'],
                    'dataStartDate'     => $value['yukoukikan_start_date'],
                    'dataEndDate'       => $value['yukoukikan_end_date'],
                    'dataTourokuDt'     => $value['touroku_dt'],
                    'dataTourokushaName'     => $value['tourokusha_name'],
                    'dataKoushinDt'     => $value['koushin_dt'],
                    'dataKoushinshaName'     => $value['koushinsha_name']
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
