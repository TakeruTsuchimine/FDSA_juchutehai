<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;

/**
 * グリッドデータ取得クラス　「得意先別納入先マスター」
 */
class PCMST_1400 extends Controller
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
            select t.id
                  ,t.jigyoubu_cd
                  ,j.jigyoubu_name
                  ,t.tokuisaki_cd
                  ,t.tokuisaki_ryaku
                  ,t.tokuisaki_ryaku2
                  ,t.tokuisaki_hyouji_name
                  ,t.tokuisaki_name1
                  ,t.tokuisaki_name2
                  ,t.tokuisaki_kana
                  ,t.eigyou_tantousha_cd
                  ,t.assistant_cd
                  ,p.tantousha_name
                  ,a.tantousha_name2
                  ,t.keishou_kbn
                  ,bm.bunrui_name
                  ,case t.shokuchi_kbn
                  when 0 then '0:通常'
                  when 1 then '1:諸口'
                  end shokuchi_kbn
                  ,case t.nouhinsho_midashi_kbn
                  when 0 then '0:無'
                  when 1 then '1:見出しを請求書とする'
                  end nouhinsho_midashi_kbn
                  ,case t.nouhinsho_hakkou_kbn
                  when 0 then '0:無し'
                  when 1 then '1:注番1で並び替えて伝票を発行する（加賀産業）'
                  end nouhinsho_hakkou_kbn
                  ,case t.senyou_denpyou_hakkou_kbn
                  when 0 then '0:未発行'
                  when 1 then '1:発行'
                  end senyou_denpyou_hakkou_kbn
                  ,case t.seikyusho_hakkou_kbn
                  when 0 then '0:未発行'
                  when 1 then '1:発行'
                  end seikyusho_hakkou_kbn
                  ,case t.tokuisaki_torihiki_kbn
                  when 0 then '0:無し'
                  when 1 then '1:有り'
                  end tokuisaki_torihiki_kbn
                  ,case t.seikyusaki_torihiki_kbn
                  when 0 then '0:無し'
                  when 1 then '1:有り'
                  end seikyusaki_torihiki_kbn
                  ,t.seikyusaki_cd
                  ,t.nyukin_oya_cd
                  ,t.yubinbangou
                  ,t.jusho1
                  ,t.jusho2
                  ,t.tel_no
                  ,t.fax_no
                  ,t.senpou_renrakusaki
                  ,t.shohizei_keisan_tani
                  ,case t.shohizei_keisan_tani
                  when 0 then '0:未'
                  when 1 then '1:締単位'
                  when 2 then '2:伝票単位'
                  when 3 then '3:明細単位'
                  end shohizei_keisan_tani
                  ,case t.shohizei_keisan_houshiki
                  when 0 then '0:内税金'
                  when 1 then '1:外税（請求単位）'
                  when 2 then '2:外税（伝票単位）'
                  when 3 then '3:外税（アイテム単位）'
                  when 4 then '4:対象外'
                  end shohizei_keisan_houshiki
                  ,case t.shohizei_keisan_marume
                  when 0 then '0:切り捨て'
                  when 1 then '1:四捨五入'
                  when 2 then '2:切上げ'
                  end shohizei_keisan_marume
                  ,case t.kingaku_keisan_marume
                  when 0 then '0:切り捨て'
                  when 1 then '1:四捨五入'
                  when 2 then '2:切上げ'
                  end kingaku_keisan_marume
                  ,t.shime_day1
                  ,t.shime_day2
                  ,t.tekiyou_tsuki
                  ,case t.nyukin_tsuki
                  when 0 then '0:当月'
                  when 1 then '1:翌月'
                  when 2 then '2:翌々月'
                  end nyukin_tsuki
                  ,t.nyukin_day
                  ,case t.kaishu_houhou
                  when 0 then '0:未設定'
                  when 1 then '1:現金・小切手'
                  when 2 then '2:振込'
                  when 3 then '3:振込手数料'
                  when 4 then '4:手形'
                  when 5 then '5:入金値引き'
                  end kaishu_houhou
                  ,case t.tegata_sate
                  when 0 then '0:30日'
                  when 1 then '1:60日'
                  when 2 then '2:90日'
                  when 3 then '3:120日'
                  end tegata_sate
                  ,case t.furikomi_tesuryou_kbn
                  when 0 then '0:手数料自社払い'
                  when 1 then '1:手数料相手払い'
                  end furikomi_tesuryou_kbn
                  ,t.yoshingendogaku
                  ,t.bikou1
                  ,t.bikou2
                  ,t.bikou3
                  ,t.koum_zumen_hokanbasho
                  ,t.eigyo_zumen_hokanbasho
                  ,to_char(t.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,tn.tantousha_name tourokusha_name
                  ,to_char(t.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,kn.tantousha_name koushinsha_name
                  ,to_char(t.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(t.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   tokuisaki_master t
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                              ,jigyoubu_oya_kbn
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on j.jigyoubu_cd = t.jigyoubu_cd
            left join ( select bunrui_cd
                              ,bunrui_name
                        from   kaisou_bunrui_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end ) bm
              on t.keishou_kbn = bm.bunrui_cd
            left join ( select tantousha_cd
                              ,tantousha_name
                            from   tantousha_master
                            where  sakujo_dt is null
                            and    :today >= yukoukikan_start_date
                            and    :today <= case when yukoukikan_end_date is null
                                                then '2199-12-31'
                                                else yukoukikan_end_date end ) p
              on t.eigyou_tantousha_cd = p.tantousha_cd
            left join ( select tantousha_cd
                              ,tantousha_name as tantousha_name2
                            from   tantousha_master
                            where  sakujo_dt is null
                            and    :today >= yukoukikan_start_date
                            and    :today <= case when yukoukikan_end_date is null
                                                then '2199-12-31'
                                                else yukoukikan_end_date end ) a
              on t.assistant_cd = a.tantousha_cd
            left join tantousha_master tn
              on t.tourokusha_id = tn.id
            left join tantousha_master kn
              on t.koushinsha_id = kn.id ";

            /** string $SQLBodyText SQL条件項目 */
            $SQLBodyText = "
            where  t.sakujo_dt is null
            and    j.jigyoubu_oya_kbn = 1
            and    :today <= case when t.yukoukikan_end_date is null
                                  then '2199-12-31' else t.yukoukikan_end_date end ";

            /** string $SQLTailText SQL並び順 */
            $SQLTailText = "
            order by t.id ";

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
                'dataTokuisakiRyaku'   => $value['tokuisaki_ryaku'] ,
                'dataTokuisakiRyaku2' => $value['tokuisaki_ryaku2'] ,
                'dataTokuisakiHyoujiName' => $value['tokuisaki_hyouji_name'] ,
                'dataTokuisakiName1' => $value['tokuisaki_name1'] ,
                'dataTokuisakiName2' => $value['tokuisaki_name2'] ,
                'dataTokuisakiKana' => $value['tokuisaki_kana'] ,
                'dataEigyouTantoushaCd' => $value['eigyou_tantousha_cd'] ,
                'dataAssistantCd' => $value['assistant_cd'] ,
                'dataEigyouTantoushaName' => $value['tantousha_name'] ,
                'dataAssistantName' => $value['tantousha_name2'] ,
                'dataKeishouKbn' => $value['keishou_kbn'] ,
                'dataBunruiName' => $value['bunrui_name'] ,
                'dataShokuchiKbn' => $value['shokuchi_kbn'] ,
                'dataNouhinshoMidashiKbn' => $value['nouhinsho_midashi_kbn'] ,
                'dataNouhinshoHakkouKbn' => $value['nouhinsho_hakkou_kbn'] ,
                'dataSenyouDenpyouHakkouKbn' => $value['senyou_denpyou_hakkou_kbn'] ,
                'dataSeikyushoHakkouKbn' => $value['seikyusho_hakkou_kbn'] ,
                'dataTokuisakiTorihikiKbn' => $value['tokuisaki_torihiki_kbn'] ,
                'dataSeikyusakiTorihikiKbn' => $value['seikyusaki_torihiki_kbn'] ,
                'dataSeikyusakiCd' => $value['seikyusaki_cd'] ,
                'dataNyukinOyaCd' => $value['nyukin_oya_cd'] ,
                'dataJusho1' => $value['jusho1'] ,
                'dataJusho2' => $value['jusho2'] ,
                'dataTelNo' => $value['tel_no'] ,
                'dataFaxNo' => $value['fax_no'] ,
                'dataSenpouRenrakusaki' => $value['senpou_renrakusaki'] ,
                'dataShohizeiKeisanTani' => $value['shohizei_keisan_tani'] ,
                'dataShohizeiKeisanHoushiki' => $value['shohizei_keisan_houshiki'] ,
                'dataShohizeiKeisanMarume' => $value['shohizei_keisan_marume'] ,
                'dataKingakuKeisanMarume' => $value['kingaku_keisan_marume'] ,
                'dataShimeDay1' => $value['shime_day1'] ,
                'dataShimeDay2' => $value['shime_day2'] ,
                'dataTekiyouTsuki' => $value['tekiyou_tsuki'] ,
                'dataNyukinTsuki' => $value['nyukin_tsuki'] ,
                'dataNyukinDay' => $value['nyukin_day'] ,
                'dataKaishuHouhou' => $value['kaishu_houhou'] ,
                'dataTegataSate' => $value['tegata_sate'] ,
                'dataFurikomiTesuryouKbn' => $value['furikomi_tesuryou_kbn'] ,
                'dataYoshingendogaku' => $value['yoshingendogaku'] ,
                'dataBikou1' => $value['bikou1'] ,
                'dataBikou2' => $value['bikou2'] ,
                'dataBikou3' => $value['bikou3'] ,
                'dataBikou4' => $value['bikou4'] ,
                'dataKoumuZumenHokanbasho' => $value['koumu_zumen_hokanbasho'] ,
                'dataEigyouZumenHokanbasho' => $value['eigyou_zumen_hokanbasho'] ,
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
