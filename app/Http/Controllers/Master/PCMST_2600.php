<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_2600 extends Controller
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
                ,j.jigyoubu_name 
                ,h.jigyoubu_cd 
                ,h.hinmoku_cd 
                ,h.hinmoku_name1 
                ,h.hinmoku_name2 
                ,h.hinmoku_kbn
				,hk.bunrui_name as hinmoku_kbn_name
                ,h.zairyou_kbn 
                ,h.kyoten_zairyou_kbn 
                ,h.shanai_zairyou_kbn 
                ,h.jhuchuhin_kbn 
                ,h.shikakari_kbn 
                ,h.fukushizai_kbn 
                ,h.tanni_cd 
				,t.bunrui_name as tanni_name
                ,h.shokuchi_kbn 
                ,h.zaikokanri_taishougai_kbn 
                ,h.tanka_input_kbn 
                ,h.shouhizei_kbn 
                ,h.keigenzeiritsu_kbn 
                ,h.zaishitsu_cd 
				,case
					when	h.zaishitsu_name is not null
					then	h.zaishitsu_name
					else	z.bunrui_name
				end as zaishitsu_name
                ,h.maker_cd 
                ,h.maker_name 
                ,h.color_cd 
				,case
					when	h.color_name is not null
					then	h.color_name
					else	c.bunrui_name
				end as color_name
                ,h.grade_cd 
				,g.bunrui_name as grade_name
                ,h.keijou_cd 
				,k.bunrui_name as keijou_name
                ,h.kikaku_name 
                ,h.size_w 
                ,h.size_d 
                ,h.size_h 
                ,h.shiiresaki_cd 
				,ss.shiiresaki_ryaku
                ,h.nyuko_okiba_cd 
                ,no.location_name as nyuko_okiba_name
				,h.nyuko_tana_cd 
                ,nt.location_name as nyuko_tana_name
				,h.kikaku 
                ,h.gyoushu_cd 
				,gs.bunrui_name as gyoushu_name
                ,h.zumen_kbn 
                ,h.kensa_kbn 
                ,h.shinki_juchu_sheet_kbn 
                ,h.yojouzaiko_kbn 
                ,h.item_size 
                ,h.cutting_size 
                ,h.shuzairyou_cd 
				,zk.hinmoku_name1 as shuzairyou_name
                ,h.kyakusaki_hinban_cd 
                ,h.folder_name 
                ,h.file_name 
                ,h.zairyou_kin 
                ,h.kozumen1 
                ,h.kozumen2 
                ,h.kozumen3 
                ,h.kozumen4 
                ,h.kozumen5 
                ,h.tokuisaki_cd 
				,ts.tokuisaki_hyouji_name as tokuisaki_name
                ,h.neji_geji 
                ,h.sagyou_uchiwake1 
                ,h.sagyou_uchiwake2 
                ,h.sagyou_uchiwake3 
                ,h.bikou_eigyou 
                ,h.bikou
                ,h.buban 
                ,h.zairyou_tehai_kbn 
				,zt.bunrui_name as zairyou_tehai_name
                ,h.keikaku_hinmoku_genka_kin 
                ,to_char(h.sakujo_dt, 'yyyy/mm/dd hh24:mm:ss') sakujo_dt 
                ,to_char(h.touroku_dt, 'yyyy/mm/dd hh24:mm:ss') touroku_dt
                ,to_char(h.koushin_dt, 'yyyy/mm/dd hh24:mm:ss') koushin_dt
                ,to_char(h.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_start_date
                ,to_char(h.yukoukikan_start_date, 'yyyy/mm/dd') yukoukikan_end_date
            from  hinmoku_master h 
            left join ( select jigyoubu_cd
                            ,jigyoubu_name
                        from   jigyoubu_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )j 
            on h.jigyoubu_cd = j.jigyoubu_cd 
            left join ( select bunrui_cd
                            ,bunrui_name
                        from   kaisou_bunrui_master
                        where  sakujo_dt is null
					    and    bunrui_category_cd = 'COLOR'
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )c
            on h.color_cd = c.bunrui_cd 
            left join ( select bunrui_cd
                            ,bunrui_name
                        from   kaisou_bunrui_master
                        where  sakujo_dt is null
					    and    bunrui_category_cd = 'ZAISHITSU'
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )z
            on h.zaishitsu_cd = z.bunrui_cd 
            left join ( select bunrui_cd
                            ,bunrui_name
                        from   kaisou_bunrui_master
                        where  sakujo_dt is null
					    and    bunrui_category_cd = 'HINMOKUKBN'
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )hk
            on h.hinmoku_kbn = hk.bunrui_cd 
            left join ( select bunrui_cd
                            ,bunrui_name
                        from   kaisou_bunrui_master
                        where  sakujo_dt is null
					    and    bunrui_category_cd = 'TANI'
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )t
            on h.tanni_cd = t.bunrui_cd 
            left join ( select bunrui_cd
                            ,bunrui_name
                        from   kaisou_bunrui_master
                        where  sakujo_dt is null
					    and    bunrui_category_cd = 'GRADE'
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )g
            on h.grade_cd = g.bunrui_cd 
            left join ( select bunrui_cd
                            ,bunrui_name
                        from   kaisou_bunrui_master
                        where  sakujo_dt is null
					    and    bunrui_category_cd = 'SHAPE'
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )k
            on h.keijou_cd = k.bunrui_cd 
			left join ( select bunrui_cd
                            ,bunrui_name
                        from   kaisou_bunrui_master
                        where  sakujo_dt is null
					    and    bunrui_category_cd = 'GYOUSHU'
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )gs
            on h.gyoushu_cd = gs.bunrui_cd 
			left join ( select bunrui_cd
                            ,bunrui_name
                        from   kaisou_bunrui_master
                        where  sakujo_dt is null
					    and    bunrui_category_cd = 'ZAITEHAI'
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )zt
            on h.zairyou_tehai_kbn = zt.bunrui_cd 
			left join ( select tokuisaki_cd
                            ,tokuisaki_hyouji_name
                        from   tokuisaki_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )ts
            on h.tokuisaki_cd = ts.tokuisaki_cd 
			left join ( select shiiresaki_cd
                            ,shiiresaki_ryaku
                        from   shiiresaki_master
                        where  sakujo_dt is null
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )ss
            on h.shiiresaki_cd = ss.shiiresaki_cd 
			left join ( select location_cd
                            ,location_name
                        from   location_master
                        where  sakujo_dt is null
					    and	   structure_level = 1
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )no
            on h.nyuko_okiba_cd = no.location_cd 
			left join ( select location_cd
                            ,location_name
                        from   location_master
                        where  sakujo_dt is null
					    and    structure_level = 2
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )nt
            on h.nyuko_tana_cd = nt.location_cd 
			left join ( select hinmoku_cd
                            ,hinmoku_name1
                        from   hinmoku_master
                        where  sakujo_dt is null
					    and    zairyou_kbn = 1
                        and    :today >= yukoukikan_start_date
                        and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31'
                                            else yukoukikan_end_date end )zk
            on h.shuzairyou_cd = zk.hinmoku_cd
            ";

            // SQL条件項目
            $SQLBodyText = "
            where  h.sakujo_dt is null
            and    :today <= case when h.yukoukikan_end_date is null
                                then '2199-12-31'
                                else h.yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by h.id ";

            // SQL件数取得
            $SQLCntText = "
            select count(*)
            from hinmoku_master h ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 品目CD
            if(!is_null($request->dataHinmokuCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and h.hinmoku_cd ilike :hinmoku_cd ";
                // バインドの設定
                $SQLBind[] = array('hinmoku_cd', $query->GetLikeValue($request->dataHinmokuCd), TYPE_STR);
            }

            // 品目名1
            if(!is_null($request->dataHinmokuName))
            {
                // SQL条件文追加
                $SQLBodyText .= " and h.hinmoku_name1 ilike :hinmoku_name1 ";
                // バインドの設定
                $SQLBind[] = array('hinmoku_name1', $query->GetLikeValue($request->dataHinmokuName), TYPE_STR);
            }

            // 事業部CD
            if(!is_null($request->dataJigyoubuCd))
            {
                // SQL条件文追加
                $SQLBodyText .= " and h.jigyoubu_cd ilike :jigyoubu_cd ";
                // バインドの設定
                $SQLBind[] = array('jigyoubu_cd', $query->GetLikeValue($request->dataJigyoubuCd), TYPE_STR);
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
                    $dataArray = array(
                        'dataId' => (int)$value['id'],
                        'dataJigyoubuCd' => $value['jigyoubu_cd'],
                        'dataJigyoubuName' => $value['jigyoubu_name'],
                        'dataHinmokuCd' => $value['hinmoku_cd'],
                        'dataHinmokuName1' => $value['hinmoku_name1'],
                        'dataHinmokuName2' => $value['hinmoku_name2'],
                        'dataHinmokuKbn' => $value['hinmoku_kbn'],
                        'dataHinmokuKbnName' => $value['hinmoku_kbn_name'],
                        'dataZairyouKbn' => (int)$value['zairyou_kbn'],
                        'dataKyotenZairyouKbn' => (int)$value['kyoten_zairyou_kbn'],
                        'dataShanaiZairyouKbn' => (int)$value['shanai_zairyou_kbn'],
                        'dataJhuchuhinKbn' => (int)$value['jhuchuhin_kbn'],
                        'dataShikakariKbn' => (int)$value['shikakari_kbn'],
                        'dataFukushizaiKbn' => (int)$value['fukushizai_kbn'],
                        'dataTanniCd' => $value['tanni_cd'],
                        'dataTanniName' => $value['tanni_name'],
                        'dataShokuchiKbn' => (int)$value['shokuchi_kbn'],
                        'dataZaikokanriKbn' => (int)$value['zaikokanri_taishougai_kbn'],
                        'dataTankaInputKbn' => (int)$value['tanka_input_kbn'],
                        'dataShouhizeiKbn' => (int)$value['shouhizei_kbn'],
                        'dataKeigenzeiritsuKbn' => (int)$value['keigenzeiritsu_kbn'],
                        'dataZaishitsuCd' => $value['zaishitsu_cd'],
                        'dataZaishitsuName' => $value['zaishitsu_name'],
                        'dataMakerCd' => $value['maker_cd'],
                        'dataMakerName' => $value['maker_name'],
                        'dataColorCd' => $value['color_cd'],
                        'dataColorName' => $value['color_name'],
                        'dataGradeCd' => $value['grade_cd'],
                        'dataGradeName' => $value['grade_name'],
                        'dataKeijouCd' => $value['keijou_cd'],
                        'dataKeijouName' => $value['keijou_name'],
                        'dataKikakuName' => $value['kikaku_name'],
                        'dataSizeW' => (double)$value['size_w'],
                        'dataSizeD' => (double)$value['size_d'],
                        'dataSizeH' => (double)$value['size_h'],
                        'dataShiiresakiCd' => $value['shiiresaki_cd'],
                        'dataShiiresakiName' => $value['shiiresaki_ryaku'],
                        'dataNyukoOkibaCd' => $value['nyuko_okiba_cd'],
                        'dataNyukoOkibaName' => $value['nyuko_okiba_name'],
                        'dataNyukoTanaCd' => $value['nyuko_tana_cd'],
                        'dataNyukoTanaName' => $value['nyuko_tana_name'],
                        'dataKikaku' => $value['kikaku'],
                        'dataGyoushuCd' => $value['gyoushu_cd'],
                        'dataGyoushuName' => $value['gyoushu_name'],
                        'dataZumenKbn' => (int)$value['zumen_kbn'],
                        'dataKensaKbn' => (int)$value['kensa_kbn'],
                        'dataShinkiJuchuSheetKbn' => (int)$value['shinki_juchu_sheet_kbn'],
                        'dataYojouzaikoKbn' => (int)$value['yojouzaiko_kbn'],
                        'dataItemSize' => $value['item_size'],
                        'dataCuttingSize' => $value['cutting_size'],
                        'dataShuZairyouCd' => $value['shuzairyou_cd'],
                        'dataShuZairyouName' => $value['shuzairyou_name'],
                        'dataKyakusakiHinbanCd' => $value['kyakusaki_hinban_cd'],
                        'dataFolderName' => $value['folder_name'],
                        'dataFileName' => $value['file_name'],
                        'dataZairyouKin' => (int)$value['zairyou_kin'],
                        'dataKozumen1' => $value['kozumen1'],
                        // 'dataKozumen2' => $value['kozumen2'],
                        // 'dataKozumen3' => $value['kozumen3'],
                        // 'dataKozumen4' => $value['kozumen4'],
                        // 'dataKozumen5' => $value['kozumen5'],
                        'dataTokuisakiCd' => $value['tokuisaki_cd'],
                        'dataTokuisakiName' => $value['tokuisaki_name'],
                        'dataNejiGeji' => $value['neji_geji'],
                        'dataSagyouUchiwake1' => $value['sagyou_uchiwake1'],
                        'dataSagyouUchiwake2' => $value['sagyou_uchiwake2'],
                        'dataSagyouUchiwake3' => $value['sagyou_uchiwake3'],
                        'dataBikouEigyou' => $value['bikou_eigyou'],
                        'dataBikou' => $value['bikou'],
                        'dataBuban' => $value['buban'],
                        'dataZairyouTehaiKbn' => $value['zairyou_tehai_kbn'],
                        'dataZairyouTehaiName' => $value['zairyou_tehai_name'],
                        'dataKeikakuHinmokuGenkaKin' => (double)$value['keikaku_hinmoku_genka_kin'],
                        'dataSakujoDt' => $value['sakujo_dt'],
                        'dataStartDate'     => $value['yukoukikan_start_date'],
                        'dataEndDate'       => $value['yukoukikan_end_date'],
                        'dataTourokuDt'     => $value['touroku_dt'],
                        'dataKoushinDt'     => $value['koushin_dt'],
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
        return $resultData;
    }
}
