<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;
use Exception;

class PCMST_1200 extends Controller
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
            select bunrui_category_cd
                  ,bunrui_category_name
                  ,kanri_level
                  ,koumoku_name1
                  ,koumoku_name2
                  ,koumoku_name3
                  ,keta_koumoku1
                  ,keta_koumoku2
                  ,keta_koumoku3
            from   bunruikanri_master ";

            // SQL条件項目
            $SQLBodyText = "
            where  sakujo_dt is null
            and    :today >= yukoukikan_start_date
            and    :today <= case when yukoukikan_end_date is null
                                  then '2199-12-31' else yukoukikan_end_date end ";

            // SQL並び順
            $SQLTailText = "
            order by bunrui_category_cd ";

            // SQLバインド値
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 分類管理CD
            if (!empty($request->dataCategoryCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and bunrui_category_cd = :bunrui_category_cd ";
                // バインドの設定
                $SQLBind[] = array('bunrui_category_cd', $request->dataCategoryCd, TYPE_STR);
            }

            ///////////////////    
            // 送信データ作成 //
            ///////////////////
            //現在年月日
            $nowDate = date("Y-m-d");
            // クエリの設定
            $SQLText = $SQLHeadText . $SQLBodyText . $SQLTailText;
            $query->StartConnect();
            $query->SetQuery($SQLText, SQL_SELECT);
            // バインド値のセット
            $SQLBind[] = array('today', $nowDate, TYPE_DATE);
            $query->SetBindArray($SQLBind);
            // クエリの実行
            $result = $query->ExecuteSelect();
            // データ取得条件別処理
            $data = array();
            // 配列番号
            $index = 0;
            // 結果データの格納
            foreach ($result as $value) {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                $dataArray = array();
                $dataArray = $dataArray + array('dataCategoryCd'    => $value['bunrui_category_cd']);
                $dataArray = $dataArray + array('dataCategoryName'  => $value['bunrui_category_name']);
                $dataArray = $dataArray + array('dataKanriLevel'    => $value['kanri_level']);
                $dataArray = $dataArray + array('dataKoumokuName1'  => $value['koumoku_name1']);
                $dataArray = $dataArray + array('dataKoumokuName2'  => $value['koumoku_name2']);
                $dataArray = $dataArray + array('dataKoumokuName3'  => $value['koumoku_name3']);
                $dataArray = $dataArray + array('dataKetaKoumoku1'  => $value['keta_koumoku1']);
                $dataArray = $dataArray + array('dataKetaKoumoku2'  => $value['keta_koumoku2']);
                $dataArray = $dataArray + array('dataKetaKoumoku3'  => $value['keta_koumoku3']);
                $dataArray = $dataArray + array('dataOyaKoumokuName1'  => __('親') . $value['koumoku_name1']);
                // 1行ずつデータ配列をグリッドデータ用配列に格納
                $data[] = $dataArray;
                // 配列番号を進める
                $index = $index + 1;
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
