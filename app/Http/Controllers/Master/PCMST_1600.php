<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;

/**
 * グリッドデータ取得クラス　「得意先別納入先マスター」
 */
class PCMST_1600 extends Controller
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
            select n.id
                  ,n.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,n.tokuisaki_cd
                  ,t.tokuisaki_name1
                  ,n.nounyusaki_cd
                  ,n.nounyusaki_ryaku
                  ,n.nounyusaki_name1
                  ,n.nounyusaki_name2
                  ,n.nounyusaki_kana
                  ,n.nounyusaki_zip
                  ,n.nounyusaki_jusho1
                  ,n.nounyusaki_jusho2
                  ,n.nounyubasho
                  ,n.tel_no
                  ,n.fax_no
                  ,n.senpou_renrakusaki
                  ,to_char(n.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,tn.tantousha_name tourokusha_name
                  ,to_char(n.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,kn.tantousha_name koushinsha_name
                  ,to_char(n.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(n.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   tokui_nounyusaki_master n
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on j.jigyoubu_cd = n.jigyoubu_cd
              left join ( select tokuisaki_cd
                                ,tokuisaki_name1
                          from   tokuisaki_master
                          where  sakujo_dt is null
                          and    :today >= yukoukikan_start_date
                          and    :today <= case when yukoukikan_end_date is null
                                                then '2199-12-31'
                                                else yukoukikan_end_date end ) t
            on t.tokuisaki_cd = n.tokuisaki_cd
            left join tantousha_master tn
              on n.tourokusha_id = tn.id
            left join tantousha_master kn
              on n.koushinsha_id = kn.id ";

            /** string $SQLBodyText SQL条件項目 */
            $SQLBodyText = "
            where  n.sakujo_dt is null
            and    :today <= case when n.yukoukikan_end_date is null
                                  then '2199-12-31' else n.yukoukikan_end_date end ";

            /** string $SQLTailText SQL並び順 */
            $SQLTailText = "
            order by n.id ";

            /** array $SQLBind SQLバインド値 */
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 納入先CD
            if (!is_null($request->dataNounyusakiCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and n.nounyusaki_cd ilike :nounyusaki_cd ";
                // バインドの設定
                $SQLBind[] = array('nounyusaki_cd', $query->GetLikeValue($request->dataNounyusakiCd), TYPE_STR);
            }

            // 納入先名
            if (!is_null($request->dataNounyusakiName1)) {
                // SQL条件文追加
                $SQLBodyText .= " and n.nounyusaki_name1 ilike :nounyusaki_name1 ";
                // バインドの設定
                $SQLBind[] = array('nounyusaki_name1', $query->GetLikeValue($request->dataNounyusakiName1), TYPE_STR);
            }

            // 事業部CD
            if (!is_null($request->dataJigyoubuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and n.jigyoubu_cd ilike :jigyoubu_cd ";
                // バインドの設定
                $SQLBind[] = array('jigyoubu_cd', $query->GetLikeValue($request->dataJigyoubuCd), TYPE_STR);
            }

            // 得意先CD
            if (!is_null($request->dataTokuisakiCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and n.tokuisaki_cd ilike :tokuisaki_cd ";
                // バインドの設定
                $SQLBind[] = array('tokuisaki_cd', $query->GetLikeValue($request->dataTokuisakiCd), TYPE_STR);
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
                'dataId'            => $value['id'] ,
                'dataJigyoubuCd'       => $value['jigyoubu_cd'] ,
                'dataJigyoubuName' => $value['jigyoubu_name'] ,
                'dataTokuisakiCd'     => $value['tokuisaki_cd'] ,
                'dataTokuisakiName1'   => $value['tokuisaki_name1'] ,
                'dataNounyusakiCd'   => $value['nounyusaki_cd'] ,
                'dataNounyusakiRyaku'   => $value['nounyusaki_ryaku'] ,
                'dataNounyusakiName1'   => $value['nounyusaki_name1'] ,
                'dataNounyusakiName2'   => $value['nounyusaki_name2'] ,
                'dataNounyusakiKana'   => $value['nounyusaki_kana'] ,
                'dataNounyusakiZip'   => $value['nounyusaki_zip'] ,
                'dataNounyusakiJusho1'   => $value['nounyusaki_jusho1'] ,
                'dataNounyusakiJusho2'   => $value['nounyusaki_jusho2'] ,
                'dataNounyubasho'   => $value['nounyubasho'] ,
                'dataTelNo' => $value['tel_no'] ,
                'dataFaxNo' => $value['fax_no'] ,
                'dataSenpouRenrakusaki' => $value['senpou_renrakusaki'] ,
                'dataStartDate'     => $value['yukoukikan_start_date'] ,
                'dataEndDate'       => $value['yukoukikan_end_date'] ,
                'dataTourokuDt'     => $value['touroku_dt'] ,
                'dataTourokushaName'     => $value['tourokusha_name'] ,
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
