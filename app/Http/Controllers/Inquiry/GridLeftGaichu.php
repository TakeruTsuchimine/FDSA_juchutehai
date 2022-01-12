<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class GridLeftGaichu extends Controller
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
            ,s.keishou_kbn 
            ,s.shiire_kbn 
            ,s.gaichu_kbn 
            ,s.shiharai_kbn 
            ,s.shokuchi_kbn 
            ,s.shiharaisaki_cd 
            ,s.shiiresaki_zip 
            ,s.shiiresaki_jusho1 
            ,s.shiiresaki_jusho2 
            ,s.tel_no 
            ,s.fax_no 
            ,s.senpou_renrakusaki 
            ,s.gyoushu_cd 
            ,s.shihonkin 
            ,to_char(s.kakunin_date, 'yyyy/mm/dd hh24:mi:ss') kakunin_date 
            ,s.bikou1 
            ,s.bikou2 
            ,s.bikou3 
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
            ,to_char(s.torihiki_teishi_date, 'yyyy/mm/dd hh24:mi:ss') torihiki_teishi_date 
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
            on s.jigyoubu_cd = j.jigyoubu_cd ";

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
                     'dataShiiresakiCd' => $value['shiiresaki_cd'] ,
                     'dataShiiresakiRyaku' => $value['shiiresaki_ryaku'] ,
                     'dataShiiresakiName1' => $value['shiiresaki_name1'] ,
                     'dataShiiresakiName2' => $value['shiiresaki_name2'] ,
                     'dataShiiresakiKana' => $value['shiiresaki_kana'] ,
                     'dataKeishoKbn' => $value['keishou_kbn'] ,
                     'dataShiireKbn' => $value['shiire_kbn'] ,
                     'dataGaichuKbn' => $value['gaichu_kbn'] ,
                     'dataShiharaiKbn' => $value['shiharai_kbn'] ,
                     'dataShokuchiKbn' => $value['shokuchi_kbn'] ,
                     'dataShiharaisakiCd' => $value['shiharaisaki_cd'] ,
                     'dataShiiresakiZip' => $value['shiiresaki_zip'] ,
                     'dataShiiresakiJusho1' => $value['shiiresaki_jusho1'] ,
                     'dataShiiresakiJusho2' => $value['shiiresaki_jusho2'] ,
                     'dataTelNo' => $value['tel_no'] ,
                     'dataFaxNo' => $value['fax_no'] ,
                     'dataSenpoRenrakusaki' => $value['senpou_renrakusaki'] ,
                     'dataGyoushuCd' => $value['gyoushu_cd'] ,
                     'dataShihonkin' => $value['shihonkin'] ,
                     'dataKakuninDate' => $value['kakunin_date'] ,
                     'dataBikou1' => $value['bikou1'] ,
                     'dataBikou2' => $value['bikou2'] ,
                     'dataBikou3' => $value['bikou3'] ,
                     'dataShohizeiKeisanTani' => $value['shohizei_keisan_tani'] ,
                     'dataShohizeiKeisanHoushiki' => $value['shohizei_keisan_houshiki'] ,
                     'dataShohizeiKeisanMarume' => $value['shohizei_keisan_marume'] ,
                     'dataKingakuKeisanMarune' => $value['kingaku_keisan_marume'] ,
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
                     'dataShiharaikouzaKbn' => $value['shiharai_kouza_kbn'] ,
                     'dataShiharaikouzaNo' => $value['shiharai_kouza_no'] ,
                     'dataTorihikiTeishiDate' => $value['torihiki_teishi_date'] ,
                     'dataTorihikiTeishiRiyuu' => $value['torihiki_teishi_riyu'] ,
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
        try
        {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            // SQL選択項目
            $SQLHeadText = " select
            g.id
            ,j.jigyoubu_name
            ,g.jigyoubu_cd
            ,g.waritsuke_kouho_cd
            ,g.sub_seqno
            ,g.waritsuke_kouho_name
            ,g.setsumeibun
            ,s.shiiresaki_name1
            ,g.shiiresaki_cd
            ,g.kakou_skill
            ,s.shiharaisaki_cd
            ,to_char(g.touroku_dt, 'yyyy/mm/dd hh24:mi:ss') touroku_dt
            ,to_char(g.koushin_dt, 'yyyy/mm/dd hh24:mi:ss') koushin_dt
            ,to_char(g.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
            ,to_char(g.yukoukikan_end_date, 'yyyy/mm/dd') yukoukikan_end_date
            from  gaichu_kouho_master g
            left join ( select jigyoubu_cd
                                ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                                then '2199-12-31'
                                                else yukoukikan_end_date end )j
                on g.jigyoubu_cd = j.jigyoubu_cd
            left join ( select shiiresaki_cd
                                ,shiiresaki_name1
                                ,shiharaisaki_cd
                        from   shiiresaki_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                                then '2199-12-31'
                                                else yukoukikan_end_date end )s
                on g.shiiresaki_cd = s.shiiresaki_cd ";

            //,count(s.waritsuke_kouho_cd)

            // SQL条件項目
            $SQLBodyText = "
            where  g.sakujo_dt is null
            and    g.yukoukikan_end_date >= :today ";

            // SQL並び順
            $SQLTailText = "
            order by g.waritsuke_kouho_cd
                    ,g.sub_seqno asc";


            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 担当割付候補CD
            if(isset($_POST['dataWaritsukeKouhoCd']))
            {
                if($_POST['dataWaritsukeKouhoCd'] !== '')
                {
                    // SQL条件文追加
                    $SQLBodyText .= " and g.waritsuke_kouho_cd = :wc ";
                    // バインドの設定
                    $SQLBind[] = array('wc', $_POST['dataWaritsukeKouhoCd'], TYPE_STR);
                }
            }
            // 担当割付候補CD
            if(isset($_POST['dataWaritsukeKouhoName']))
            {
                if($_POST['dataWaritsukeKouhoName'] !== '')
                {
                    // SQL条件文追加
                    $SQLBodyText .= " and g.waritsuke_kouho_name = :wn ";
                    // バインドの設定
                    $SQLBind[] = array('wn', $_POST['dataWaritsukeKouhoName'], TYPE_STR);
                }
            }
            if(isset($_POST['dataSQLtype'])){
                $sqlType = $_POST['dataSQLtype'];
            }

            ///////////////////
            // 送信データ作成 //
            ///////////////////
            //現在年月日
            $nowDate = date("Y-m-d");
            // クエリの設定
            $SQLText = ($SQLHeadText.$SQLBodyText.$SQLTailText);
            $query -> StartConnect();
            $query -> SetQuery($SQLText, SQL_SELECT);
            // バインド値のセット
            $query -> SetBindArray($SQLBind);
            $query -> SetBindValue("today" , $nowDate, TYPE_DATE);
            // クエリの実行
            $result = $query -> ExecuteSelect();

                ///////////////////
                // データ取得のみ //
                ///////////////////
                $data2 = array();
                // 配列番号
                $index = 0;

                // 結果データの格納
                foreach($result as $value){
                    // JSONオブジェクト用に配列に名前を付けてデータ格納
                    $dataArray = array(
                     'dataId' => $value['id'] ,
                     'dataJigyoubuCd' => $value['jigyoubu_cd'] ,
                     'dataJigyoubuName' => $value['jigyoubu_name'] ,
                     'dataWaritsukeKouhoCd' => $value['waritsuke_kouho_cd'] ,
                     'dataSubNo' => $value['sub_seqno'] ,
                     'dataWaritsukeKouhoName' => $value['waritsuke_kouho_name'] ,
                     'dataSetsumeibun' => $value['setsumeibun'] ,
                     'dataShiiresakiCd' => $value['shiiresaki_cd'] ,
                     'dataShiiresakiName1' => $value['shiiresaki_name1'] ,
                     'dataKakouSkill' => $value['kakou_skill'] ,
                     'dataStartDate'     => $value['yukoukikan_start_date'] ,
                     'dataEndDate'       => $value['yukoukikan_end_date'] ,
                     'dataTourokuDt'     => $value['touroku_dt'] ,
                     'dataKoushinDt'     => $value['koushin_dt'] ,
                     'dataShiharaisakiCd'  => $value['shiharaisaki_cd'] ,
                     'dataIndex'        => $index
                    );
                    // 1行ずつデータ配列をグリッドデータ用配列に格納
                    $data2[] = $dataArray;
                    // 配列番号を進める
                    $index = $index + 1;
                }

        }
        catch ( \Throwable $e )
        {
            $resultFlg = false;
            $data2 = $e -> getMessage().' File：'.$e -> getFile().' Line：'.$e -> getLine();
        }
        finally
        {
            $query -> CloseQuery();
        }
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        $resultData[] = $sqlType;
        $resultData[] = mb_convert_encoding($data2, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}
