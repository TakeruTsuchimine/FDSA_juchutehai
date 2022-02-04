<?php

namespace App\Http\Controllers\Juchu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCJUI_4111 extends Controller
{
    public function index(Request $request)
    {
        // 処理成功フラグ
        $resultFlg = true;
        //
        $resultMsg = '';
        //
        $resultVal = [];
        //
        $tableName = 'juchu_data';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'juchu_no');
        try {
            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            //
            // 入力値のエラーチェック
            //
            // トランザクション種別
            $SQLType = empty($request->dataSQLType) ? 0 : (int)$request->dataSQLType;
            if ($SQLType < 1) {
                $resultMsg .= '「' . __('データ') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // 受注日
            $juchuDate = $request->dataJuchuDate;
            // POSTデータチェックエラー
            if (empty($juchuDate)) {
                $resultMsg .= '「' . __('juchu_date') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // 受注No.
            $juchuNo = $request->dataJuchuNo;
            // POSTデータチェックエラー
            if (is_null($juchuNo) || $juchuNo === '') {
                $resultMsg .= '「' . __('juchu_no') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // 有効期間（自）
            $yukoukikanStartDate = $request->dataStartDate;
            // POSTデータチェックエラー
            if (empty($yukoukikanStartDate)) {
                $resultMsg .= '「' . __('yukoukikan_start_date') . '」' . __('が正常に送信されていません。') . '\n';
                $resultFlg = false;
            }

            // 登録者ID
            $loginId = empty($request->dataLoginId) ? 0 : (int)$request->dataLoginId;

            ///////////////////////////
            // Insert 及び Delete処理 //
            ///////////////////////////
            // トランザクション別処理
            switch ($SQLType) {

                    ////////////////
                    // DELETE処理 //
                    ////////////////
                case SQL_DELETE:
                    // レコードID
                    $dataId = $request->dataId;
                    if (empty($dataId)) {
                        $resultMsg .= '「' . __('ID') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // データ処理開始
                    $master->DeleteMasterData($juchuNo, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // 受注Noは新規登録の際、既に存在する場合はエラー
                    $result = $common->GetCdCount($tableName, 'juchu_no', $juchuNo);
                    if ($result > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('juchu_no') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataJuchuNo';
                        $resultFlg = false;
                    }

                    // 客先注番1
                    $chumonNo1 = $request->dataChumonNo1;

                    // 客先注番2
                    $chumonNo2 = $request->dataChumonNo2;

                    // 客先注番3
                    $chumonNo3 = $request->dataChumonNo3;

                    // 希望納期
                    $noukiDate = $request->dataNoukiDate;

                    // 出荷予定日
                    $shukkaDate = $request->dataShukkaDate;

                    // 受注数量
                    $juchuQty = $request->dataJuchuQty;

                    // 受注単価
                    $juchuTanka = $request->dataJuchuTanka;

                    // 受注金額
                    $juchuKin = $request->dataJuchuKin;

                    // 仮単価区分
                    $karitankaKbn = empty($request->dataKaritankaKbn) ? 0 : $request->dataKaritankaKbn;

                    // 受注区分
                    $juchuKbn = empty($request->dataJuchuKbn) ? 1 : $request->dataJuchuKbn;

                    // 備考1
                    $note1 = $request->dataNote1;

                    // 備考2
                    $note2 = $request->dataNote2;

                    // 備考3
                    $note3 = $request->dataNote3;

                    // 得意先CD
                    $tokuisakiCd = $request->dataTokuisakiCd;
                    // POSTデータチェックエラー
                    if (!is_null($tokuisakiCd) && $tokuisakiCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetCdCount('tokuisaki_master', 'tokuisaki_cd', $tokuisakiCd, $juchuDate);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('tokuisaki_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataTokuisakiCd';
                            $resultFlg = false;
                        }
                    }

                    // 納入先CD
                    $nounyusakiCd = $request->dataNounyusakiCd;
                    // POSTデータチェックエラー
                    if (!is_null($nounyusakiCd) && $nounyusakiCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetCdCount('tokui_nounyusaki_master', 'nounyusaki_cd', $nounyusakiCd, $juchuDate);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('nounyusaki_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataNounyusakiCd';
                            $resultFlg = false;
                        }
                    }

                    // 営業担当CD
                    $eigyouCd = $request->dataEigyouCd;
                    // POSTデータチェックエラー
                    if (!is_null($eigyouCd) && $eigyouCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetCdCount('tantousha_master', 'tantousha_cd', $eigyouCd, $juchuDate);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('eigyou_tantousha_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataEigyouCd';
                            $resultFlg = false;
                        }
                    }

                    // アシスタントCD
                    $assistantCd = $request->dataAssistantCd;
                    // POSTデータチェックエラー
                    if (!is_null($assistantCd) && $assistantCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetCdCount('tantousha_master', 'tantousha_cd', $eigyouCd, $juchuDate);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('assistant_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataAssistantCd';
                            $resultFlg = false;
                        }
                    }

                    // 品目CD
                    $hinmokuCd = $request->dataHinmokuCd;
                    // POSTデータチェックエラー
                    if (!is_null($hinmokuCd) && $hinmokuCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetCdCount('hinmoku_master', 'hinmoku_cd', $hinmokuCd, $juchuDate);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('hinmoku_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataHinmokuCd';
                            $resultFlg = false;
                        }
                    }

                    // 単位CD
                    $taniCd = $request->dataTaniCd;
                    // POSTデータチェックエラー
                    if (!is_null($taniCd) && $taniCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetBunruiCdCount('TANI', $taniCd, $juchuDate);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('tani_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataTaniCd';
                            $resultFlg = false;
                        }
                    }

                    // 配送便CD
                    $haisoubinCd = $request->dataHaisoubinCd;
                    // POSTデータチェックエラー
                    if (!is_null($haisoubinCd) && $haisoubinCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetBunruiCdCount('HAISOUBIN', $haisoubinCd, $juchuDate);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('haisoubin_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataHaisoubinCd';
                            $resultFlg = false;
                        }
                    }

                    if (!$resultFlg) throw new Exception($resultMsg);

                    // 有効期間終了の設定
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    // バインドの設定
                    $SQLBind = array();

                    // 事業部コード　※要改修
                    $SQLBind[] = array('jigyoubu_cd', '1', TYPE_STR);
                    // 業務取引区分ID　※要改修
                    $SQLBind[] = array('job_id', 1, TYPE_INT);

                    $SQLBind[] = array('juchu_date', $juchuDate, TYPE_DATE);
                    $SQLBind[] = array('juchu_no', $juchuNo, TYPE_STR);
                    $SQLBind[] = array('tokuisaki_cd', $tokuisakiCd, TYPE_STR);
                    $SQLBind[] = array('nounyusaki_cd', $nounyusakiCd, TYPE_STR);
                    $SQLBind[] = array('eigyou_tantousha_cd', $eigyouCd, TYPE_STR);
                    $SQLBind[] = array('assistant_cd', $assistantCd, TYPE_STR);
                    $SQLBind[] = array('tokuisaki_chumon_no1', $chumonNo1, TYPE_STR);
                    $SQLBind[] = array('tokuisaki_chumon_no2', $chumonNo2, TYPE_STR);
                    $SQLBind[] = array('tokuisaki_chumon_no3', $chumonNo3, TYPE_STR);
                    $SQLBind[] = array('hinmoku_cd', $hinmokuCd, TYPE_STR);
                    $SQLBind[] = array('nouki_date', $noukiDate, TYPE_DATE);
                    $SQLBind[] = array('shukka_date', $shukkaDate, TYPE_DATE);
                    $SQLBind[] = array('tani_cd', $taniCd, TYPE_STR);
                    $SQLBind[] = array('haisoubin_cd', $haisoubinCd, TYPE_STR);
                    $SQLBind[] = array('juchu_qty', $juchuQty, -1);
                    $SQLBind[] = array('juchu_tanka', $juchuTanka, -1);
                    $SQLBind[] = array('juchu_kin', $juchuKin, -1);
                    $SQLBind[] = array('karitanka_kbn', $karitankaKbn, TYPE_INT);
                    $SQLBind[] = array('juchu_kbn', $juchuKbn, TYPE_STR);
                    $SQLBind[] = array('notes1', $note1, TYPE_STR);
                    $SQLBind[] = array('notes2', $note2, TYPE_STR);
                    $SQLBind[] = array('notes3', $note3, TYPE_STR);
                    // データ処理開始
                    $master->InsertMasterData($SQLBind, $juchuNo, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
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
        // 処理結果送信
        $resultData = array();
        $resultData[] = $resultFlg;
        $resultData[] = mb_convert_encoding($resultMsg, 'UTF-8', 'UTF-8');
        $resultData[] = mb_convert_encoding($resultVal, 'UTF-8', 'UTF-8');
        return $resultData;
    }
}
