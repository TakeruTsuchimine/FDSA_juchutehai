<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

/**
 * マスターテーブルレコード更新クラス　「階層分類マスター」
 */
class PCMST_1301 extends Controller
{
    /**
     * テーブルレコード更新
     *
     * @param Request $request POST受信データ
     * 
     * @return array $resultData 更新結果データ
     */
    public function index(Request $request)
    {
        /** boolean $resultFlg 処理成功フラグ */
        $resultFlg = true;
        /** string  $resultMsg 処理結果メッセージ */
        $resultMsg = '';
        /** array   $resultMsg 処理結果データ */
        $resultVal = [];
        /** string  $tableName 対象テーブル名 */
        $tableName = 'kaisou_bunrui_master';
        /** App\Http\Controllers\Classes\class_Common 共通関数宣言 */
        $common = new class_Common();
        /** App\Http\Controllers\Classes\class_Database データベース接続クラス宣言 */
        $query = new class_Database();
        /** App\Http\Controllers\Classes\class_Master マスタ共通処理クラス宣言 */
        $master = new class_Master($tableName, 'bunrui_cd');
        try {
            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            //
            // 入力値のエラーチェック
            //
            /** int $SQLType トランザクション種別 */
            $SQLType = empty($request->dataSQLType) ? 0 : (int)$request->dataSQLType;
            if ($SQLType < 1)
            {
                $resultMsg .= '「' . __('データ') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            /** int $kaisouLevel 階層レベル */
            $kaisouLevel = (int)$request->dataKaisouLevel;
            // POSTデータチェックエラー
            if (is_null($kaisouLevel) || $kaisouLevel === '' || $kaisouLevel > 3 || $kaisouLevel < 1)
            {
                $resultMsg .= '「' . __('jikaisou_level') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            /** string $bunruiCd 分類CD */
            $bunruiCd = $request->dataBunruiCd;
            // POSTデータチェックエラー
            if (is_null($bunruiCd) || $bunruiCd === '')
            {
                $resultMsg .= '「' . __('コード') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            /** string $bunruiCategoryCd 分類カテゴリーCD */
            $bunruiCategoryCd = $request->dataCategoryCd;
            // POSTデータチェックエラー
            if (is_null($bunruiCategoryCd) || $bunruiCategoryCd === '')
            {
                $resultMsg .= '「' . __('カテゴリー') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            /** string $yukoukikanStartDate 有効期間（自） */
            $yukoukikanStartDate = $request->dataStartDate;
            // POSTデータチェックエラー
            if (empty($yukoukikanStartDate))
            {
                $resultMsg .= '「' . __('yukoukikan_start_date') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            /** int $loginId 登録者ID */
            $loginId = empty($request->dataLoginId) ? 0 : (int)$request->dataLoginId;

            ///////////////////////////
            // Insert 及び Delete処理 //
            ///////////////////////////
            // トランザクション別処理
            switch ($SQLType)
            {
                ////////////////
                // DELETE処理 //
                ////////////////
                case SQL_DELETE:
                    /** int $dataId レコードID */
                    $dataId = $request->dataId;
                    if (empty($dataId))
                    {
                        $resultMsg .= '「' . __('ID') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // データ処理開始
                    $master->DeleteMasterData($bunruiCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                // DELETE処理終了 //

                ////////////////
                // INSERT処理 //
                ////////////////
                default:
                    // 分類CDは新規登録の際、既に存在する担当者コードの場合はエラー
                    /** int $cdCount 管理CDの登録数 */
                    $cdCount = $common->GetBunruiCdCount($bunruiCategoryCd, $bunruiCd);
                    if ($cdCount > 0 && $SQLType === SQL_INSERT)
                    {
                        $resultMsg .= __('既に登録されている') . '「' . __('コード') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataBunruiCd';
                        $resultFlg = false;
                    }

                    /** string $bunruiName 分類名 */
                    $bunruiName = $request->dataBunruiName;

                    /** string $oyaBunruiCd 親分類CD */
                    $oyaBunruiCd = is_null($request->dataOyaBunruiCd) ? '' : $request->dataOyaBunruiCd;
                    //
                    // 親分類コードが有効かどうかの判定
                    //
                    if ($kaisouLevel > 1) // 階層レベルが2以上の場合
                    {
                        /** string $SQLHeadText SQL選択項目 */
                        $SQLHeadText  = " select count(*) from " . $tableName;
                        /** string $SQLBodyText SQL条件項目 */
                        $SQLBodyText .= " where  sakujo_dt is null
                                          and    :today <= case when yukoukikan_end_date is null
                                                                then '2199-12-31'
                                                                else yukoukikan_end_date end
                                          and    bunrui_cd      = :oyabunrui_cd
                                          and    jikaisou_level = :jikaisou_level ";
                        /** string $SQLText 実行SQL文 */
                        $SQLText = $SQLHeadText . $SQLBodyText . $SQLTailText;
                        // DB接続
                        $query->StartConnect();
                        // SQL文セット
                        $query->SetQuery($SQLText, SQL_SELECT);
                        // バインド値のセット
                        $query->SetBindValue(":oyabunrui_cd", $oyaBunruiCd, TYPE_STR);
                        $query->SetBindValue(":jikaisou_level", ($kaisouLevel - 1), TYPE_INT);
                        $query->SetBindValue(":today", date("Y/m/d"), TYPE_DATE);
                        // SQLの実行
                        /** array $result 実行結果データ */
                        $result = $query->ExecuteSelect();
                        if ($result < 1)
                        {
                            $resultMsg .= __('指定できない') . '「' . __('親') . __('コード') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataOyaBunruiCd';
                            $resultFlg = false;
                        }
                    }
                    /** string $tsuikajouhou 追加情報 */
                    $tsuikajouhou = is_null($request->dataTsuikajouhou) ? '' : $request->dataTsuikajouhou;

                    // エラーがあった際は処理せずエラーメッセージを表示して終了
                    if (!$resultFlg) throw new Exception($resultMsg);

                    /** string $yukoukikanEndDate 有効期間（至） */
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));

                    // バインドの設定
                    /** array $SQLBind SQLバインド値 */
                    $SQLBind = array();
                    $SQLBind[] = array('bunrui_category_cd', $bunruiCategoryCd, TYPE_STR);
                    $SQLBind[] = array('jikaisou_level', $kaisouLevel, TYPE_INT);
                    $SQLBind[] = array('bunrui_cd', $bunruiCd, TYPE_STR);
                    $SQLBind[] = array('bunrui_name', $bunruiName, TYPE_STR);
                    $SQLBind[] = array('bunrui_oya_cd', $oyaBunruiCd, TYPE_STR);
                    $SQLBind[] = array('tsuikajouhou', $tsuikajouhou, TYPE_STR);
                    // データ処理開始
                    $master->InsertMasterData($SQLBind, $bunruiCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType, 'bunrui_category_cd', $bunruiCategoryCd);
                    $resultVal[] = $common->GetMaxId($tableName);
                    break;
                    // INSERT処理終了 //
            }
        } catch (\Throwable $e) {
            if ($resultFlg) {
                $resultFlg = false;
                $resultMsg = $e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine();
            }
        }
        /** array $resultData 出力データ */
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($resultMsg, 'UTF-8', 'UTF-8');
        $resultData[] = mb_convert_encoding($resultVal, 'UTF-8', 'UTF-8');
        // 処理結果送信
        return $resultData;
    }
}
