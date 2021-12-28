<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCMST_0601 extends Controller
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
        $tableName = 'koutei_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'koutei_cd');
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

            // 工程CD
            $kouteiCd = $request->dataKouteiCd;
            // POSTデータチェックエラー
            if (is_null($kouteiCd) || $kouteiCd === '') {
                $resultMsg .= '「' . __('koutei_cd') . '」' . __('が正常に送信されていません。') . '\n';
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
                    $master->DeleteMasterData($kouteiCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                    // DELETE処理終了 //

                    ////////////////
                    // INSERT処理 //
                    ////////////////
                default:
                    // 工程CDは新規登録の際、既に存在する工程コードの場合はエラー
                    $result = $common->GetCdCount($tableName, 'koutei_cd', $kouteiCd);
                    if ($result > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている') . '「' . __('koutei_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataKouteiCd';
                        $resultFlg = false;
                    }

                    // 工程名
                    $kouteiName = $request->dataKouteiName;

                    // 工程略名
                    $kouteiRyakuName = $request->dataKouteiRyakuName;

                    // 作業機械候補CD
                    $sagyouKikaiKouhoCd = $request->dataSagyouKikaiKouhoCd;

                    // 作業担当者候補CD
                    $sagyouTantoushaKouhoCd = $request->dataSagyouTantoushaKouhoCd;

                    // 作業治具候補CD
                    $sagyouJiguKouhoCd = $request->dataSagyouJiguKouhoCd;

                    // 加工先候補CD
                    $kakousakiKouhoCd = $request->dataKakousakiKouhoCd;

                    // 工程単価
                    $kouteiTanka = $request->dataKouteiTanka;

                    // 工程段取単価
                    $kouteiDandoriTanka = $request->dataKouteiDandoriTanka;

                    // 工程区分
                    $kouteiKbn = $request->dataKouteiKbn;

                    // 初回のみ有効区分
                    $shokaiKbn = $request->dataShokaiKbn;

                    // 報告区分
                    $houkokuKbn = $request->dataHoukokuKbn;

                    // 図面配布
                    $zumenHaifuKbn = $request->dataZumenHaifuKbn;

                    // 事業部CD
                    $jigyoubuCd = $request->dataJigyoubuCd;
                    // POSTデータチェックエラー
                    if (is_null($jigyoubuCd) || $jigyoubuCd === '') {
                        $resultMsg .= '「' . __('jigyoubu_cd') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    $result = $common->GetCdCount('jigyoubu_master', 'jigyoubu_cd', $jigyoubuCd);
                    if ($result < 1) {
                        $resultMsg .= __('登録されていない') . '「' . __('jigyoubu_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataJigyoubuCd';
                        $resultFlg = false;
                    }

                    // 部署CD
                    $bushoCd = $request->dataBushoCd;
                    // POSTデータチェックエラー
                    if (is_null($bushoCd) || $bushoCd === '') {
                        $resultMsg .= '「' . __('busho_cd') . '」' . __('が正常に送信されていません。') . '<br>';
                        $resultFlg = false;
                    }
                    // コードが存在しない場合はエラー
                    $result = $common->GetCdCount('busho_master', 'busho_cd', $bushoCd);
                    if ($result < 1) {
                        $resultMsg .= __('登録されていない') . '「' . __('busho_cd') . '」' . __('です。') . '<br>';
                        $resultVal[] = 'dataBushoCd';
                        $resultFlg = false;
                    }

                    if (!$resultFlg) throw new Exception($resultMsg);

                    // 有効期間終了の設定
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    // バインドの設定
                    $SQLBind = array();
                    $SQLBind[] = array('jigyoubu_cd', $jigyoubuCd, TYPE_STR);
                    $SQLBind[] = array('busho_cd', $bushoCd, TYPE_STR);
                    $SQLBind[] = array('koutei_cd', $kouteiCd, TYPE_STR);
                    $SQLBind[] = array('koutei_name', $kouteiName, TYPE_STR);
                    $SQLBind[] = array('koutei_ryaku_name', $kouteiRyakuName, TYPE_STR);
                    $SQLBind[] = array('sagyou_kikai_kouho_cd', $sagyouKikaiKouhoCd, TYPE_STR);
                    $SQLBind[] = array('sagyou_tantousha_kouho_cd', $sagyouTantoushaKouhoCd, TYPE_STR);
                    $SQLBind[] = array('sagyou_jigu_kouho_cd', $sagyouJiguKouhoCd, TYPE_STR);
                    $SQLBind[] = array('kakousaki_kouho_cd', $kakousakiKouhoCd, TYPE_STR);
                    $SQLBind[] = array('koutei_tanka', $kouteiTanka, TYPE_INT);
                    $SQLBind[] = array('koutei_dandori_tanka', $kouteiDandoriTanka, TYPE_INT);
                    $SQLBind[] = array('koutei_kbn', $kouteiKbn, TYPE_INT);
                    $SQLBind[] = array('shokai_kbn', $shokaiKbn, TYPE_INT);
                    $SQLBind[] = array('houkoku_kbn', $houkokuKbn, TYPE_INT);
                    $SQLBind[] = array('zumen_haifu_kbn', $zumenHaifuKbn, TYPE_INT);
                    // データ処理開始
                    $master->InsertMasterData($SQLBind, $kouteiCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
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
