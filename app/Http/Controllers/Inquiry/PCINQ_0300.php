<?php

namespace App\Http\Controllers\Inquiry;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Database;

/**
 * 登録CD選択入力クラス　「部署マスター」
 */
class PCINQ_0300 extends Controller
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
        /** string  $targetTable    検索対象テーブル*/
        $targetTable = 'busho_master';
        /** string  $targetRowCd    対象CD列 */
        $targetRowCd = 'busho_cd';
        /** string  $targetRowName  対象名称列 */
        $targetRowName = 'busho_name';

        /** array   $data           グリッドデータ用データ格納配列変数 */
        $data;
        /** App\Http\Controllers\Classes\class_Database データベース接続クラス宣言 */
        $query = new class_Database();
        try {
            ///////////////////
            //   SQL文作成   //
            ///////////////////
            /** string $SQLHeadText SQL選択項目 */
            $SQLHeadText = " select ".$targetRowCd." , ".$targetRowName." from ".$targetTable;
            /** string $SQLBodyText SQL条件項目 */
            $SQLBodyText = "
            where  sakujo_dt is null
            and    :today >= yukoukikan_start_date
            and    :today <= case when yukoukikan_end_date is null
                                  then '2199-12-31'
                                  else yukoukikan_end_date end ";
            /** string $SQLTailText SQL並び順 */
            $SQLTailText = " order by ".$targetRowCd;
            /** array $SQLBind SQLバインド値 */
            $SQLBind = array();

            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            // 検索CD
            if (!is_null($request->dataKensakuCd)) {
                // SQL条件文追加
                $SQLBodyText .= " and ".$targetRowCd." ilike :kensaku_cd ";
                // バインドの設定
                $SQLBind[] = array('kensaku_cd', $query->GetLikeValue($request->dataKensakuCd), TYPE_STR);
            }
            // 検索名
            if (!is_null($request->dataKensakuName)) {
                // SQL条件文追加
                $SQLBodyText .= " and ".$targetRowName." ilike :kensaku_name ";
                // バインドの設定
                $SQLBind[] = array('kensaku_name', $query->GetLikeValue($request->dataKensakuName), TYPE_STR);
            }
            ///////////////////
            // 送信データ作成 //
            ///////////////////
            /** string $nowDate 現在年月日 */
            $nowDate = date("Y-m-d");
            // 対象日
            if (!is_null($request->dataTargetDate)) {
                $nowDate = $request->dataTargetDate;
            }
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
                    'dataSentakuCd'   => $value[$targetRowCd],
                    'dataSentakuName' => $value[$targetRowName]
                );
                // 1行ずつデータ配列をグリッドデータ用配列に格納
                $data[] = $dataArray;
            }
        } catch (PDOException $e) {
            $resultFlg = false;
            $data =  $e->getMessage();
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
