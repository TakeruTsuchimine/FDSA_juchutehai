<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

/**
 * グリッドデータ取得クラス　「仕入外注先マスター」
 */
class PCMST_1800 extends Controller
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
            select s.id
            ,s.jigyoubu_cd
            ,j.jigyoubu_name
            ,s.shiiresaki_cd
            ,s.shiiresaki_ryaku
            ,s.shiiresaki_name1
            ,s.shiiresaki_name2
            ,s.shiiresaki_kana
            ,s.keishou_kbn
            ,b.bunrui_name
            ,case s.shiire_kbn
            when 0 then '0:無し'
            when 1 then '1:有り'
            end shiire_kbn
            ,case s.gaichu_kbn
            when 0 then '0:無し'
            when 1 then '1:有り'
            end gaichu_kbn
            ,case s.shiharai_kbn
            when 0 then '0:無し'
            when 1 then '1:有り'
            end shiharai_kbn
            ,case s.shokuchi_kbn
            when 0 then '0:通常'
            when 1 then '1:諸口'
            end shokuchi_kbn
            ,s.shiharaisaki_cd
            ,s.shiharaisaki_oya_cd
            ,s.shiiresaki_zip
            ,s.shiiresaki_jusho1
            ,s.shiiresaki_jusho2
            ,s.tel_no
            ,s.fax_no
            ,s.senpou_renrakusaki
            ,s.gyoushu_cd
            ,bm.bunrui_name gyoushu_name
            ,s.shihonkin
            ,to_char(s.kakunin_date, 'yyyy/mm/dd') kakunin_date
            ,s.bikou1
            ,s.bikou2
            ,s.bikou3
            ,s.bikou4
            ,case s.shouhizei_keisan_tani
            when 0 then '0:未'
            when 1 then '1:締単位'
            when 2 then '2:伝票単位'
            when 3 then '3:明細単位'
            end shouhizei_keisan_tani
            ,case s.shouhizei_keisan_houshiki
            when 0 then '0:内税金'
            when 1 then '1:外税（請求単位）'
            when 2 then '2:外税（伝票単位）'
            when 3 then '3:外税（アイテム単位）'
            when 4 then '4:対象外'
            end shouhizei_keisan_houshiki
            ,case s.shouhizei_keisan_marume
            when 0 then '0:切り捨て'
            when 1 then '1:四捨五入'
            when 2 then '2:切上げ'
            end shouhizei_keisan_marume
            ,case s.kingaku_keisan_marume
            when 0 then '0:切り捨て'
            when 1 then '1:四捨五入'
            when 2 then '2:切上げ'
            end kingaku_keisan_marume
            ,s.shime_day1
            ,s.shime_day2
            ,s.tekiyou_tsuki
            ,case s.shiharai_tsuki1
            when 0 then '0:当月'
            when 1 then '1:翌月'
            when 2 then '2:翌々月'
            end shiharai_tsuki1
            ,s.shiharai_day1
            ,case s.shiharai_houhou1
            when 0 then '0:未設定'
            when 1 then '1:現金・小切手'
            when 2 then '2:振込'
            when 3 then '3:振込手数料'
            when 4 then '4:手形'
            when 5 then '5:電債'
            when 6 then '6:入金値引き'
            end shiharai_houhou1
            ,s.tegata_sate1
            ,case s.shiharai_kaishu_jougen_kin
            when 0 then '0:当該額未満'
            when 1 then '1:当該額以上'
            end shiharai_kaishu_jougen_kin
            ,case s.shiharai_tsuki2
            when 0 then '0:当月'
            when 1 then '1:翌月'
            when 2 then '2:翌々月'
            end shiharai_tsuki2
            ,s.shiharai_day2
            ,case s.shiharai_houhou2
            when 0 then '0:未設定'
            when 1 then '1:現金・小切手'
            when 2 then '2:振込'
            when 3 then '3:振込手数料'
            when 4 then '4:手形'
            when 5 then '5:電債'
            when 6 then '6:入金値引き'
            end shiharai_houhou2
            ,s.tegata_sate2
            ,case s.furikomi_tesuryou_kbn
            when 0 then '0:手数料自社払い'
            when 1 then '1:手数料相手払い'
            end furikomi_tesuryou_kbn
            ,s.ginkou_name
            ,s.shiten_name
            ,case s.shiharai_kouza_kbn
            when 0 then '0:普通'
            when 1 then '1:当座'
            end shiharai_kouza_kbn
            ,s.shiharai_kouza_no
            ,to_char(s.torihiki_teishi_date, 'yyyy/mm/dd') torihiki_teishi_date
            ,s.torihiki_teishi_riyu
            ,to_char(s.touroku_dt, 'yyyy /mm/dd hh24:mi:ss') touroku_dt
            ,tn.tantousha_name tourokusha_name
            ,to_char(s.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
            ,kn.tantousha_name koushinsha_name
            ,to_char(s.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
            ,to_char(s.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_end_date
            from  shiiresaki_master s
            left join ( select jigyoubu_cd
                              ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end ) j
             on s.jigyoubu_cd = j.jigyoubu_cd
            left join ( select bunrui_cd
                              ,bunrui_name
                         from   kaisou_bunrui_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                                then '2199-12-31'
                                                else yukoukikan_end_date end ) b
             on b.bunrui_cd = s.keishou_kbn
            left join ( select bunrui_cd
                              ,bunrui_name
                         from   kaisou_bunrui_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                                then '2199-12-31'
                                                else yukoukikan_end_date end ) bm
             on bm.bunrui_cd = s.gyoushu_cd
            left join tantousha_master tn
             on s.tourokusha_id = tn.id
            left join tantousha_master kn
             on s.koushinsha_id = kn.id ";


            /** string $SQLBodyText SQL条件項目 */
            $SQLBodyText = "
            where  s.sakujo_dt is null
            and    :today <= case when s.yukoukikan_end_date is null
                                  then '2199-12-31' else s.yukoukikan_end_date end ";

            /** string $SQLTailText SQL並び順 */
            $SQLTailText = "
            order by s.id ";

            /** array $SQLBind SQLバインド値 */
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 仕入先CD
            if(!is_null($request -> dataShiiresakiCd)){
                // SQL条件文追加
                $SQLBodyText .= " and s.shiiresaki_cd ilike :shiiresaki_cd ";
                // バインドの設定
                $SQLBind[] = array('shiiresaki_cd', $query -> GetLikeValue($request -> dataShiiresakiCd), TYPE_STR);
            }
            // 仕入先CD
            if(!is_null($request -> dataShiiresakiCd)){
                // SQL条件文追加
                $SQLBodyText .= " and s.shiiresaki_name1 ilike :shiiresaki_name1 ";
                // バインドの設定
                $SQLBind[] = array('shiiresaki_name1', $query -> GetLikeValue($request -> dataShiiresakiName1), TYPE_STR);
            }
            //事業部CD
            if(!is_null($request -> dataJigyoubuCd)){
                // SQL条件文追加
                $SQLBodyText .= " and j.jigyoubu_cd ilike :jigyoubu_cd ";
                // バインドの設定
                $SQLBind[] = array('jigyoubu_cd', $query -> GetLikeValue($request -> dataJigyoubuCd), TYPE_STR);
            }
            // 支払先CD
            if(!is_null($request -> shiharaisakiCd)){
                // SQL条件文追加
                $SQLBodyText .= " and s.shiharaisaki_cd ilike :shiharaisaki_cd ";
                // バインドの設定
                $SQLBind[] = array('shiharaisaki_cd', $query -> GetLikeValue($request -> dataShiharaisakiCd), TYPE_STR);
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
            // 配列番号
            $index = 0;
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                /** array $dataArray 取得レコードデータ */
                $dataArray = array(
                    'dataId' => $value['id'] ,
                    'dataJigyoubuCd' => $value['jigyoubu_cd'] ,
                    'dataJigyoubuName' => $value['jigyoubu_name'] ,
                    'dataShiiresakiCd' => $value['shiiresaki_cd'] ,
                    'dataShiiresakiRyaku' => $value['shiiresaki_ryaku'] ,
                    'dataShiiresakiName1' => $value['shiiresaki_name1'] ,
                    'dataShiiresakiName2' => $value['shiiresaki_name2'] ,
                    'dataShiiresakiKana' => $value['shiiresaki_kana'] ,
                    'dataKeishouKbn' => $value['keishou_kbn'] ,
                    'dataBunruiName' => $value['bunrui_name'] ,
                    'dataShiireKbn' => $value['shiire_kbn'] ,
                    'dataGaichuKbn' => $value['gaichu_kbn'] ,
                    'dataShiharaiKbn' => $value['shiharai_kbn'] ,
                    'dataShokuchiKbn' => $value['shokuchi_kbn'] ,
                    'dataShiharaisakiCd' => $value['shiharaisaki_cd'] ,
                    'dataShiharaisakiOyaCd' => $value['shiharaisaki_oya_cd'] ,
                    'dataShiiresakiZip' => $value['shiiresaki_zip'] ,
                    'dataShiiresakiJusho1' => $value['shiiresaki_jusho1'] ,
                    'dataShiiresakiJusho2' => $value['shiiresaki_jusho2'] ,
                    'dataTelNo' => $value['tel_no'] ,
                    'dataFaxNo' => $value['fax_no'] ,
                    'dataSenpouRenrakusaki' => $value['senpou_renrakusaki'] ,
                    'dataGyoushuCd' => $value['gyoushu_cd'] ,
                    'dataGyoushuName' => $value['gyoushu_name'] ,
                    'dataShihonkin' => $value['shihonkin'] ,
                    'dataKakuninDate' => $value['kakunin_date'] ,
                    'dataBikou1' => $value['bikou1'] ,
                    'dataBikou2' => $value['bikou2'] ,
                    'dataBikou3' => $value['bikou3'] ,
                    'dataBikou4' => $value['bikou4'] ,
                    'dataShouhizeiKeisanTani' => $value['shouhizei_keisan_tani'] ,
                    'dataShouhizeiKeisanHoushiki' => $value['shouhizei_keisan_houshiki'] ,
                    'dataShouhizeiKeisanMarume' => $value['shouhizei_keisan_marume'] ,
                    'dataKingakuKeisanMarume' => $value['kingaku_keisan_marume'] ,
                    'dataShimeDay1' => $value['shime_day1'] ,
                    'dataShimeDay2' => $value['shime_day2'] ,
                    'dataTekiyouTsuki' => $value['tekiyou_tsuki'] ,
                    'dataShiharaiTsuki1' => $value['shiharai_tsuki1'] ,
                    'dataShiharaiDay1' => $value['shiharai_day1'] ,
                    'dataShiharaiHouhou1' => $value['shiharai_houhou1'] ,
                    'dataTegataSate1' => $value['tegata_sate1'] ,
                    'dataShiharaiKaishuJougenKin' => $value['shiharai_kaishu_jougen_kin'] ,
                    'dataShiharaiTsuki2' => $value['shiharai_tsuki2'] ,
                    'dataShiharaiDay2' => $value['shiharai_day2'] ,
                    'dataShiharaiHouhou2' => $value['shiharai_houhou2'] ,
                    'dataTegataSate2' => $value['tegata_sate2'] ,
                    'dataFurikomiTesuryouKbn' => $value['furikomi_tesuryou_kbn'] ,
                    'dataGinkouName' => $value['ginkou_name'] ,
                    'dataShitenName' => $value['shiten_name'] ,
                    'dataShiharaiKouzaKbn' => $value['shiharai_kouza_kbn'] ,
                    'dataShiharaiKouzaNo' => $value['shiharai_kouza_no'] ,
                    'dataTorihikiTeishiDate' => $value['torihiki_teishi_date'] ,
                    'dataTorihikiTeishiRiyu' => $value['torihiki_teishi_riyu'] ,
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
