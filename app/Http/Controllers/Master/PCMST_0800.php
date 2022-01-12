<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

/**
 * グリッドデータ取得クラス　「機械マスター」
 */
class PCMST_0800 extends Controller
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
            select k.id
                  ,k.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,k.busho_cd
                  ,b.busho_name
                  ,k.kikai_cd
                  ,k.kikai_name
                  ,k.bikou
                  ,k.hyoujun_kadou_min
                  ,k.main_koutei_cd
                  ,case k.mujin_kadou_kbn
                  when 0 then '0:有人稼働'
                  when 1 then '1:無人稼働'
                  end mujin_kadou_kbn
                  ,case k.soto_dandori_kbn
                  when 0 then '0:機上段取'
                  when 1 then '1:外段取（段取工数は機械不可集計しない）'
                  end soto_dandori_kbn
                  ,to_char(k.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,tn.tantousha_name tourokusha_name
                  ,to_char(k.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,kn.tantousha_name koushinsha_name
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
              on k.busho_cd = b.busho_cd
            left join tantousha_master tn
              on k.tourokusha_id = tn.id
            left join tantousha_master kn
              on k.koushinsha_id = kn.id ";

            /** string $SQLBodyText SQL条件項目 */
            $SQLBodyText = "
            where  k.sakujo_dt is null
            and    :today <= case when k.yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else k.yukoukikan_end_date end ";

            /** string $SQLTailText SQL並び順 */
            $SQLTailText = "
            order by k.id ";

            /** array $SQLBind SQLバインド値 */
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 機械CD
            if (!is_null($request->dataKikaiCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and k.kikai_cd ilike :kikai_cd ";
                // バインドの設定
                $SQLBind[] = array('kikai_cd', $query->GetLikeValue($request->dataKikaiCd), TYPE_STR);
            }

            // 機械名
            if (!is_null($request->dataKikaiName)) {
                // SQL条件文追加
                $SQLBodyText .= " and k.kikai_name ilike :kikai_name ";
                // バインドの設定
                $SQLBind[] = array('kikai_name', $query->GetLikeValue($request->dataKikaiName), TYPE_STR);
            }

            // 事業部CD
            if (!is_null($request->dataJigyoubuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and k.jigyoubu_cd ilike :jigyoubu_cd ";
                // バインドの設定
                $SQLBind[] = array('jigyoubu_cd', $query->GetLikeValue($request->dataJigyoubuCd), TYPE_STR);
            }

            // 部署CD
            if (!is_null($request->dataBushoCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and k.busho_cd ilike :busho_cd ";
                // バインドの設定
                $SQLBind[] = array('busho_cd', $query->GetLikeValue($request->dataBushoCd), TYPE_STR);
            }

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
            $data = array();
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                /** array $dataArray 取得レコードデータ */
                $dataArray = array(
                    'dataId' => $value['id'],
                    'dataJigyoubuCd' => $value['jigyoubu_cd'],
                    'dataJigyoubuName' => $value['jigyoubu_name'],
                    'dataBushoCd' => $value['busho_cd'],
                    'dataBushoName' => $value['busho_name'],
                    'dataKikaiCd' => $value['kikai_cd'],
                    'dataKikaiName' => $value['kikai_name'],
                    'dataBikou' => $value['bikou'],
                    'dataHyoujunKadouMin' => $value['hyoujun_kadou_min'],
                    'dataMainKouteiCd' => $value['main_koutei_cd'],
                    'dataMujinKadouKbn' => $value['mujin_kadou_kbn'],
                    'dataSotoDandoriKbn' => $value['soto_dandori_kbn'],
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
