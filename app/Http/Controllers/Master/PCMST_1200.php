<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;

/**
 * グリッドデータ取得クラス　「分類管理マスター」
 */
class PCMST_1200 extends Controller
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
            /** string $SQLBodyText SQL条件項目 */
            $SQLBodyText = "
            where  sakujo_dt is null
            and    :today >= yukoukikan_start_date
            and    :today <= case when yukoukikan_end_date is null
                                  then '2199-12-31' else yukoukikan_end_date end ";
            /** string $SQLTailText SQL並び順 */
            $SQLTailText = "
            order by bunrui_category_cd ";
            /** array $SQLBind SQLバインド値 */
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
            // データ取得条件別処理
            $data = array();
            // 結果データの格納
            foreach ($result as $value)
            {
                // JSONオブジェクト用に配列に名前を付けてデータ格納
                /** array $dataArray 取得レコードデータ */
                $dataArray = array(
                    'dataCategoryCd'    => $value['bunrui_category_cd'],
                    'dataCategoryName'  => $value['bunrui_category_name'],
                    'dataKanriLevel'    => $value['kanri_level'],
                    'dataKoumokuName1'  => $value['koumoku_name1'],
                    'dataKoumokuName2'  => $value['koumoku_name2'],
                    'dataKoumokuName3'  => $value['koumoku_name3'],
                    'dataKetaKoumoku1'  => $value['keta_koumoku1'],
                    'dataKetaKoumoku2'  => $value['keta_koumoku2'],
                    'dataKetaKoumoku3'  => $value['keta_koumoku3'],
                    'dataOyaKoumokuName1'  => __('親') . $value['koumoku_name1']
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
