<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_1800 extends Controller
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
            ,s.shiiresaki_cd 
            ,s.shiiresaki_ryaku 
            ,s.shiiresaki_name1 
            ,s.shiiresaki_name2 
            ,s.shiiresaki_kana 
            ,s.keisho_kbn 
            ,s.shiire_kbn 
            ,s.gaichu_kbn 
            ,s.shiharai_kbn 
            ,s.shokuchi_kbn 
            ,s.shiharaisaki_cd 
            ,s.shiiresaki_oya_code 
            ,s.shiiresaki_zip 
            ,s.shiiresaki_jusho1 
            ,s.shiiresaki_jusho2 
            ,s.tel_no 
            ,s.fax_no 
            ,s.senpo_renrakusaki 
            ,s.gyoushu_cd 
            ,s.shihonkin 
            ,to_char(s.kakunin_date, 'yyyy/mm/dd hh24:mi:ss') kakunin_date 
            ,s.bikou1 
            ,s.bikou2 
            ,s.bikou3 
            ,s.hinmoku_shiire_kbn 
            ,s.shohizei_keisan_tani 
            ,s.shohizei_keisan_houshiki 
            ,s.shohizei_keisan_marume 
            ,s.kingaku_keisan_marume 
            ,s.shime_day1 
            ,s.shime_day2 
            ,s.tekiyou_tsuki 
            ,s.shiharai_tsuki1 
            ,s.shiharai_day1 
            ,s.shiharaihouhou1 
            ,s.tegata_sate1 
            ,s.shiharai_kaishu_jougen_kin 
            ,s.shiharai_tsuki2 
            ,s.shiharai_day2 
            ,s.shiharaihouhou2 
            ,s.tegata_sate2 
            ,s.furikomi_tesuryou_kbn 
            ,s.ginkou_cd 
            ,s.shiten_cd 
            ,s.shiharaikouza_kbn 
            ,s.shiharaikouza_no 
            ,to_char(s.torihiki_teishi_date, 'yyyy/mm/dd hh24:mi:ss') torihiki_teishi_date 
            ,s.torihiki_teishi_riyuu 
            ,to_char(s.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
            ,to_char(s.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
            ,to_char(s.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
            ,to_char(s.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_end_date
            from  shiiresaki_master s 
            left join ( select jigyoubu_cd
                  ,jigyoubu_name
            from   jigyoubu_master
            where  sakujo_date is null
            and    :today >= yukoukikan_start_date
            and    :today <= case when yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else yukoukikan_end_date end ) j
            on s.jigyoubu_cd = j.jigyoubu_cd ";

            
            // SQL条件項目
            $SQLBodyText = "
            where  s.sakujo_date is null
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
            // 仕入先CD
            if(!is_null($request -> dataShiiresakiCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and s.shiiresaki_cd ilike :shiiresaki_cd ";
                // バインドの設定
                $SQLBind[] = array('shiiresaki_cd', $query -> GetLikeValue($request -> dataShiiresakiCd), TYPE_STR);
            }
            // 仕入先CD
            if(!is_null($request -> dataShiiresakiCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and s.shiiresaki_name1 ilike :shiiresaki_name1 ";
                // バインドの設定
                $SQLBind[] = array('shiiresaki_name1', $query -> GetLikeValue($request -> dataShiiresakiName1), TYPE_STR);
            }
            //事業部CD
            if(!is_null($request -> dataJigyoubuCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and j.jigyoubu_cd ilike :jigyoubu_cd ";
                // バインドの設定
                $SQLBind[] = array('jigyoubu_cd', $query -> GetLikeValue($request -> dataJigyoubuCd), TYPE_STR);
            }
            // 支払先CD
            if(!is_null($request -> shiharaisakiCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and s.shiharaisaki_cd ilike :shiharaisaki_cd ";
                // バインドの設定
                $SQLBind[] = array('shiharaisaki_cd', $query -> GetLikeValue($request -> dataShiharaisakiCd), TYPE_STR);
            }
            // 検索件数取得フラグ
            $cntFlg = false;
            if (!is_null($request->dataCntFlg)) $cntFlg = (bool)$request->dataCntFlg;

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
                    $dataArray = array();
                    $dataArray = $dataArray + array( 'dataId' => $value['id'] );
                    $dataArray = $dataArray + array( 'dataJigyoubuCd' => $value['jigyoubu_cd'] );
                    $dataArray = $dataArray + array( 'dataShiiresakiCd' => $value['shiiresaki_cd'] );
                    $dataArray = $dataArray + array( 'dataShiiresakiRyaku' => $value['shiiresaki_ryaku'] );
                    $dataArray = $dataArray + array( 'dataShiiresakiName1' => $value['shiiresaki_name1'] );
                    $dataArray = $dataArray + array( 'dataShiiresakiName2' => $value['shiiresaki_name2'] );
                    $dataArray = $dataArray + array( 'dataShiiresakiKana' => $value['shiiresaki_kana'] );
                    $dataArray = $dataArray + array( 'dataKeishoKbn' => $value['keisho_kbn'] );
                    $dataArray = $dataArray + array( 'dataShiireKbn' => $value['shiire_kbn'] );
                    $dataArray = $dataArray + array( 'dataGaichuKbn' => $value['gaichu_kbn'] );
                    $dataArray = $dataArray + array( 'dataShiharaiKbn' => $value['shiharai_kbn'] );
                    $dataArray = $dataArray + array( 'dataShokuchiKbn' => $value['shokuchi_kbn'] );
                    $dataArray = $dataArray + array( 'dataShiharaisakiCd' => $value['shiharaisaki_cd'] );
                    $dataArray = $dataArray + array( 'dataShiiresakiOyaCode' => $value['shiiresaki_oya_code'] );
                    $dataArray = $dataArray + array( 'dataShiiresakiZip' => $value['shiiresaki_zip'] );
                    $dataArray = $dataArray + array( 'dataShiiresakiJusho1' => $value['shiiresaki_jusho1'] );
                    $dataArray = $dataArray + array( 'dataShiiresakiJusho2' => $value['shiiresaki_jusho2'] );
                    $dataArray = $dataArray + array( 'dataTelNo' => $value['tel_no'] );
                    $dataArray = $dataArray + array( 'dataFaxNo' => $value['fax_no'] );
                    $dataArray = $dataArray + array( 'dataSenpoRenrakusaki' => $value['senpo_renrakusaki'] );
                    $dataArray = $dataArray + array( 'dataGyoushuCd' => $value['gyoushu_cd'] );
                    $dataArray = $dataArray + array( 'dataShihonkin' => $value['shihonkin'] );
                    $dataArray = $dataArray + array( 'dataKakuninDate' => $value['kakunin_date'] );
                    $dataArray = $dataArray + array( 'dataBikou1' => $value['bikou1'] );
                    $dataArray = $dataArray + array( 'dataBikou2' => $value['bikou2'] );
                    $dataArray = $dataArray + array( 'dataBikou3' => $value['bikou3'] );
                    $dataArray = $dataArray + array( 'dataHinmokuShiireKbn' => $value['hinmoku_shiire_kbn'] );
                    $dataArray = $dataArray + array( 'dataShohizeiKeisanTani' => $value['shohizei_keisan_tani'] );
                    $dataArray = $dataArray + array( 'dataShohizeiKeisanHoushiki' => $value['shohizei_keisan_houshiki'] );
                    $dataArray = $dataArray + array( 'dataShohizeiKeisanMarume' => $value['shohizei_keisan_marume'] );
                    $dataArray = $dataArray + array( 'dataKingakuKeisanMarune' => $value['kingaku_keisan_marume'] );
                    $dataArray = $dataArray + array( 'dataShimeDay1' => $value['shime_day1'] );
                    $dataArray = $dataArray + array( 'dataShimeDay2' => $value['shime_day2'] );
                    $dataArray = $dataArray + array( 'dataTekiyouTsuki' => $value['tekiyou_tsuki'] );
                    $dataArray = $dataArray + array( 'dataShiharaiTsuki1' => $value['shiharai_tsuki1'] );
                    $dataArray = $dataArray + array( 'dataShiharaiDay1' => $value['shiharai_day1'] );
                    $dataArray = $dataArray + array( 'dataShiharaihouhou1' => $value['shiharaihouhou1'] );
                    $dataArray = $dataArray + array( 'dataTegataSate1' => $value['tegata_sate1'] );
                    $dataArray = $dataArray + array( 'dataShiharaiKaishuJougenKin' => $value['shiharai_kaishu_jougen_kin'] );
                    $dataArray = $dataArray + array( 'dataShiharaiTsuki2' => $value['shiharai_tsuki2'] );
                    $dataArray = $dataArray + array( 'dataShiharaiDay2' => $value['shiharai_day2'] );
                    $dataArray = $dataArray + array( 'dataShiharaihouhou2' => $value['shiharaihouhou2'] );
                    $dataArray = $dataArray + array( 'dataTegataSate2' => $value['tegata_sate2'] );
                    $dataArray = $dataArray + array( 'dataFurikomiTesuryouKbn' => $value['furikomi_tesuryou_kbn'] );
                    $dataArray = $dataArray + array( 'dataGinkouCd' => $value['ginkou_cd'] );
                    $dataArray = $dataArray + array( 'dataShitenCd' => $value['shiten_cd'] );
                    $dataArray = $dataArray + array( 'dataShiharaikouzaKbn' => $value['shiharaikouza_kbn'] );
                    $dataArray = $dataArray + array( 'dataShiharaikouzaNo' => $value['shiharaikouza_no'] );
                    $dataArray = $dataArray + array( 'dataTorihikiTeishiDate' => $value['torihiki_teishi_date'] );
                    $dataArray = $dataArray + array( 'dataTorihikiTeishiRiyuu' => $value['torihiki_teishi_riyuu'] );
                    $dataArray = $dataArray + array( 'dataStartDate'     => $value['yukoukikan_start_date'] );
                    $dataArray = $dataArray + array( 'dataEndDate'       => $value['yukoukikan_end_date'] );
                    $dataArray = $dataArray + array( 'dataTourokuDt'     => $value['touroku_dt'] );
                    $dataArray = $dataArray + array( 'dataKoushinDt'     => $value['koushin_dt'] );
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
        return $resultData;
    }
}
