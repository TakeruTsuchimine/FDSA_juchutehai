<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_1400 extends Controller
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
                  ,t.eigyo_tantousha_cd
                  ,t.assistant_cd
                  ,t.keisho_kbn
                  ,t.shokuchi_kbn
                  ,t.nouhinsho_midashi_kbn
                  ,t.nouhinsho_hakkou_kbn
                  ,t.senyou_denpyou_hakko_kbn
                  ,t.seikyusho_hakkou_kbn
                  ,t.tokuisaki_torihiki_kbn
                  ,t.seikyusaki_torihiki_kbn
                  ,t.seikyusaki_cd
                  ,t.nyukin_oya_code
                  ,t.yubinbangou
                  ,t.jusyo1
                  ,t.jusyo2
                  ,t.tel_no
                  ,t.fax_no
                  ,t.senpou_renrakusaki
                  ,t.shohizei_keisan_tani
                  ,t.shohizei_keisan_houshiki
                  ,t.shohizei_keisan_marume
                  ,t.kingaku_keisan_marune
                  ,t.shime_day1
                  ,t.shime_day2
                  ,t.tekiyou_tsuki
                  ,t.nyukin_tsuki1
                  ,t.nyukin_day1
                  ,t.kaishuhouhou1
                  ,t.tegata_sate1
                  ,t.shiharai_kaishu_jougen_kin
                  ,t.kaishuhouhou2
                  ,t.nyukin_tsuki2
                  ,t.nyukin_day2
                  ,t.tegata_sate2
                  ,t.furikomi_tesuryou_kbn
                  ,t.ginkou_cd
                  ,t.shiten_cd
                  ,t.kaishukouza_kbn
                  ,t.kaishukouza_no
                  ,t.yoshingendogaku
                  ,t.bikou1
                  ,t.bikou2
                  ,t.bikou3
                  ,t.koum_zumen_hokanbasho
                  ,t.eigyo_zumen_hokanbasho
                  ,to_char(t.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
                  ,to_char(t.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
                  ,to_char(t.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                  ,to_char(t.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from   tokuisaki_master t 
            left join ( select jigyoubu_cd
                              ,jigyoubu_name 
                        from   jigyoubu_master 
                        where  sakujo_date is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                              then '2199-12-31'
                                              else yukoukikan_end_date end ) j
              on j.jigyoubu_cd = t.jigyoubu_cd ";

            // SQL条件項目
            $SQLBodyText = "
            where  t.sakujo_date is null
            and    :today <= case when t.yukoukikan_end_date is null
                                  then '2199-12-31' else t.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by t.id ";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from tokuisaki_master t ";

            // SQLバインド値
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

            // 拠点CD
            if (!is_null($request->dataKyotenCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and p.kyoten_cd ilike :kyoten_cd ";
                // バインドの設定
                $SQLBind[] = array('kyoten_cd', $query->GetLikeValue($request->dataKyotenCd), TYPE_STR);
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
                   $dataArray = $dataArray + array( 'dataId'            => $value['id'] );
                   $dataArray = $dataArray + array( 'dataJigyoubuCd'       => $value['jigyoubu_cd'] );
                   $dataArray = $dataArray + array( 'dataJigyoubuName' => $value['jigyoubu_name'] );
                   $dataArray = $dataArray + array( 'dataTokuisakiCd'     => $value['tokuisaki_cd'] );
                   $dataArray = $dataArray + array( 'dataTokuisakiRyaku'   => $value['tokuisaki_ryaku'] );
                   $dataArray = $dataArray + array( 'dataTokuisakiRyaku2' => $value['tokuisaki_ryaku2'] );
                   $dataArray = $dataArray + array( 'dataTokuisakiHyoujiName' => $value['tokuisaki_hyouji_name'] );
                   $dataArray = $dataArray + array( 'dataTokuisakiName1' => $value['tokuisaki_name1'] );
                   $dataArray = $dataArray + array( 'dataTokuisakiName2' => $value['tokuisaki_name2'] );
                   $dataArray = $dataArray + array( 'dataTokuisakiKana' => $value['tokuisaki_kana'] );
                   $dataArray = $dataArray + array( 'dataEigyoTantoushaCd' => $value['eigyo_tantousha_cd'] );
                   $dataArray = $dataArray + array( 'dataAssistantCd' => $value['assistant_cd'] );
                   $dataArray = $dataArray + array( 'datakeishoKbn' => $value['keisho_kbn'] );
                   $dataArray = $dataArray + array( 'dataShokuchikbn' => $value['shokuchi_kbn'] );
                   $dataArray = $dataArray + array( 'dataNouhinshoMidashiKbn' => $value['nouhinsho_midashi_kbn'] );
                   $dataArray = $dataArray + array( 'dataNouhinshoHakkouKbn' => $value['nouhinsho_hakkou_kbn'] );
                   $dataArray = $dataArray + array( 'dataSenyouDenpyouHakkoKbn' => $value['senyou_denpyou_hakko_kbn'] );
                   $dataArray = $dataArray + array( 'dataSeikyushoHakkouKbn' => $value['seikyusho_hakkou_kbn'] );
                   $dataArray = $dataArray + array( 'dataToukuisakiTorihikiKbn' => $value['tokuisaki_torihiki_kbn'] );
                   $dataArray = $dataArray + array( 'dataSeikyusakiTorihikiKbn' => $value['seikyusaki_torihiki_kbn'] );
                   $dataArray = $dataArray + array( 'dataSeikyusakiCd' => $value['seikyusaki_cd'] );
                   $dataArray = $dataArray + array( 'dataNyukinOyaCode' => $value['nyukin_oya_code'] );
                   $dataArray = $dataArray + array( 'dataYubinbangou' => $value['yubinbangou'] );
                   $dataArray = $dataArray + array( 'dataJusho1' => $value['jusyo1'] );
                   $dataArray = $dataArray + array( 'dataJusho2' => $value['jusyo2'] );
                   $dataArray = $dataArray + array( 'dataTelNo' => $value['tel_no'] );
                   $dataArray = $dataArray + array( 'dataFaxNo' => $value['fax_no'] );
                   $dataArray = $dataArray + array( 'dataSenpouRenrakusaki' => $value['senpou_renrakusaki'] );
                   $dataArray = $dataArray + array( 'dataShohizeiKeisanTani' => $value['shohizei_keisan_tani'] );
                   $dataArray = $dataArray + array( 'dataShohizeiKeisanHoushiki' => $value['shohizei_keisan_houshiki'] );
                   $dataArray = $dataArray + array( 'dataShohizeiKeisanMarume' => $value['shohizei_keisan_marume'] );
                   $dataArray = $dataArray + array( 'dataKingakuKeisanMarume' => $value['kingaku_keisan_marune'] );
                   $dataArray = $dataArray + array( 'dataShimeDay1' => $value['shime_day1'] );
                   $dataArray = $dataArray + array( 'dataShimeDay2' => $value['shime_day2'] );
                   $dataArray = $dataArray + array( 'dataTekiyouTsuki' => $value['tekiyou_tsuki'] );
                   $dataArray = $dataArray + array( 'dataNyukinTsuki1' => $value['nyukin_tsuki1'] );
                   $dataArray = $dataArray + array( 'dataNyukinDay1' => $value['nyukin_day1'] );
                   $dataArray = $dataArray + array( 'dataKaishuhouhou1' => $value['kaishuhouhou1'] );
                   $dataArray = $dataArray + array( 'datategataSate1' => $value['tegata_sate1'] );
                   $dataArray = $dataArray + array( 'dataShiharaiKaishuJoukenKin' => $value['shiharai_kaishu_jougen_kin'] );
                   $dataArray = $dataArray + array( 'dataKaishuhouhou2' => $value['kaishuhouhou2'] );
                   $dataArray = $dataArray + array( 'dataNyukinTsuki2' => $value['nyukin_tsuki2'] );
                   $dataArray = $dataArray + array( 'dataNyukinDay2' => $value['nyukin_day2'] );
                   $dataArray = $dataArray + array( 'dataTegataSate2' => $value['tegata_sate2'] );
                   $dataArray = $dataArray + array( 'dataFurikomiTesuryouKbn' => $value['furikomi_tesuryou_kbn'] );
                   $dataArray = $dataArray + array( 'dataGinkouCd' => $value['ginkou_cd'] );
                   $dataArray = $dataArray + array( 'dataShitenCd' => $value['shiten_cd'] );
                   $dataArray = $dataArray + array( 'dataKaishukouzaKbn' => $value['kaishukouza_kbn'] );
                   $dataArray = $dataArray + array( 'dataKaishukouzaNo' => $value['kaishukouza_no'] );
                   $dataArray = $dataArray + array( 'dataYoshingendogaku' => $value['yoshingendogaku'] );
                   $dataArray = $dataArray + array( 'dataBikou1' => $value['bikou1'] );
                   $dataArray = $dataArray + array( 'dataBikou2' => $value['bikou2'] );
                   $dataArray = $dataArray + array( 'dataBikou3' => $value['bikou3'] );
                   $dataArray = $dataArray + array( 'dataKoumZumenHokanbasho' => $value['koum_zumen_hokanbasho'] );
                   $dataArray = $dataArray + array( 'dataEigyoZumenHokanbasho' => $value['eigyo_zumen_hokanbasho'] );
                   $dataArray = $dataArray + array( 'dataStartDate'     => $value['yukoukikan_start_date'] );
                   $dataArray = $dataArray + array( 'dataEndDate'       => $value['yukoukikan_end_date'] );
                   $dataArray = $dataArray + array( 'dataTourokuDt'     => $value['touroku_dt'] );
                   $dataArray = $dataArray + array( 'dataKoushinDt'     => $value['koushin_dt'] );
                   $dataArray = $dataArray + array( 'dataIndex'        => $index );
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
