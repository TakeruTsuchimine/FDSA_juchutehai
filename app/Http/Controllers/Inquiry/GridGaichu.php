<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class GridGaichu extends Controller
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
            ,s.jigyoubu_cd
            ,j.jigyoubu_name
            ,s.shiiresaki_cd
            ,s.shiiresaki_ryaku
            ,s.shiiresaki_name1
            ,s.shiiresaki_name2
            ,s.shiiresaki_kana
            ,s.keishou_kbn
            ,s.shiire_kbn
            ,s.gaichu_kbn
            ,s.shiharai_kbn
            ,s.shokuchi_kbn
            ,s.shiharaisaki_cd
            ,s.shiiresaki_oya_cd
            ,s.shiiresaki_zip
            ,s.shiiresaki_jusho1
            ,s.shiiresaki_jusho2
            ,s.tel_no
            ,s.fax_no
            ,s.senpou_renrakusaki
            ,s.gyoushu_cd
            ,s.shihonkin
            ,to_char(s.kakunin_date, 'yyyy/mm/dd') kakunin_date
            ,s.bikou1
            ,s.bikou2
            ,s.bikou3
            ,s.bikou4
            ,s.shohizei_keisan_tani
            ,s.shohizei_keisan_houshiki
            ,s.shohizei_keisan_marume
            ,s.kingaku_keisan_marume
            ,s.shime_day1
            ,s.shime_day2
            ,s.tekiyou_tsuki
            ,s.shiharai_tsuki1
            ,s.shiharai_day1
            ,s.shiharai_houhou1
            ,s.tegata_sate1
            ,s.shiharai_kaishu_jougen_kin
            ,s.shiharai_tsuki2
            ,s.shiharai_day2
            ,s.shiharai_houhou2
            ,s.tegata_sate2
            ,s.furikomi_tesuryou_kbn
            ,s.ginkou_name
            ,s.shiten_name
            ,s.shiharai_kouza_kbn
            ,s.shiharai_kouza_no
            ,b.bunrui_name
            ,to_char(s.torihiki_teishi_date, 'yyyy/mm/dd') torihiki_teishi_date
            ,s.torihiki_teishi_riyu
            ,to_char(s.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
            ,to_char(s.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
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
             on b.bunrui_cd = s.gyoushu_cd";

            // SQL条件項目
            $SQLBodyText = "
            where  s.sakujo_dt is null
            and    :today <= case when s.yukoukikan_end_date is null
                                  then '2199-12-31' else s.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by s.id ";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from shiiresaki_master s ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////

            // 検索件数取得フラグ
            $cntFlg = false;
            if (!is_null($request->dataCntFlg)) $cntFlg = (bool)$request->dataCntFlg;

            if(isset($_POST['dataSQLtype'])){
                $sqlType = $_POST['dataSQLtype'];
            }

            ///////////////////
            // 送信データ作成 //
            ///////////////////
            //現在年月日
            $nowDate = date("Y-m-d");
            // クエリの設定
            $SQLText = ($cntFlg ? $SQLCntText . $SQLBodyText : $SQLHeadText . $SQLBodyText . $SQLTailText);
            $query->StartConnect();
            $query->SetQuery($SQLText, SQL_SELECT);
            // バインド値のセット
            $SQLBind[] = array('today', $nowDate, TYPE_DATE);
            $query->SetBindArray($SQLBind);
            // クエリの実行
            $result = $query->ExecuteSelect();
            // データ取得条件別処理
            if ($cntFlg) {
                /////////////////
                // 件数取得のみ //
                /////////////////
                $data = $result[0][0];
            } else {
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
                     'dataShiiresakiCd' => $value['shiiresaki_cd'] ,
                     'dataShiiresakiRyaku' => $value['shiiresaki_ryaku'] ,
                     'dataShiiresakiName1' => $value['shiiresaki_name1'] ,
                     'dataShiiresakiName2' => $value['shiiresaki_name2'] ,
                     'dataShiiresakiKana' => $value['shiiresaki_kana'] ,
                     'dataKeishouKbn' => $value['keishou_kbn'] ,
                     'dataShiireKbn' => $value['shiire_kbn'] ,
                     'dataGaichuKbn' => $value['gaichu_kbn'] ,
                     'dataShiharaiKbn' => $value['shiharai_kbn'] ,
                     'dataShokuchiKbn' => $value['shokuchi_kbn'] ,
                     'dataShiharaisakiCd' => $value['shiharaisaki_cd'] ,
                     'dataShiiresakiOyaCd' => $value['shiiresaki_oya_cd'] ,
                     'dataShiiresakiZip' => $value['shiiresaki_zip'] ,
                     'dataShiiresakiJusho1' => $value['shiiresaki_jusho1'] ,
                     'dataShiiresakiJusho2' => $value['shiiresaki_jusho2'] ,
                     'dataTelNo' => $value['tel_no'] ,
                     'dataFaxNo' => $value['fax_no'] ,
                     'dataSenpouRenrakusaki' => $value['senpou_renrakusaki'] ,
                     'dataGyoushuCd' => $value['gyoushu_cd'] ,
                     'dataGyoushuName' => $value['bunrui_name'] ,
                     'dataShihonkin' => $value['shihonkin'] ,
                     'dataKakuninDate' => $value['kakunin_date'] ,
                     'dataBikou1' => $value['bikou1'] ,
                     'dataBikou2' => $value['bikou2'] ,
                     'dataBikou3' => $value['bikou3'] ,
                     'dataBikou4' => $value['bikou4'] ,
                     'dataShohizeiKeisanTani' => $value['shohizei_keisan_tani'] ,
                     'dataShohizeiKeisanHoushiki' => $value['shohizei_keisan_houshiki'] ,
                     'dataShohizeiKeisanMarume' => $value['shohizei_keisan_marume'] ,
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
                     'dataKoushinDt'     => $value['koushin_dt'],
                     'dataIndex'        => $index
                    );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $data[] = $dataArray;
                    // 配列番号を進める
                    $index = $index + 1;
                }
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
        $resultData[] = $sqlType;
        return $resultData;
    }
}
