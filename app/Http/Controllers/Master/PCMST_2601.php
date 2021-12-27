<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Classes\class_Common;
use App\Http\Controllers\Classes\class_Database;
use App\Http\Controllers\Classes\class_Master;
use Exception;

class PCMST_2601 extends Controller
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
        $tableName = 'hinmoku_master';
        // グリッドデータ用データ格納用変数宣言
        $data;
        // 共通関数宣言
        $common = new class_Common();
        // データベース接続宣言
        $query = new class_Database();
        // マスタ共通処理クラス宣言
        $master = new class_Master($tableName, 'hinmoku_cd');
        try {
            ///////////////////
            // POSTデータ受信 //
            ///////////////////
            //
            // 入力値のエラーチェック
            //
            // トランザクション種別
            $SQLType = empty($request -> dataSQLType) ? 0 : (int)$request -> dataSQLType;
            if($SQLType < 1) {
                $resultMsg .= '「'.__('データ').'」'.__('が正常に送信されていません。').'\n';
                $resultFlg = false;
            }

            // 事業部CD
            $jigyoubuCd = $request -> dataJigyoubuCd;
            if(is_null($jigyoubuCd) || $jigyoubuCd === '') {
                $resultMsg .= '「'.__('jigyoubu_cd').'」'.__('が正常に送信されていません。').'\n';
                $resultFlg = false;
            }

            // 品目CD
            $hinmokuCd = $request -> dataHinmokuCd;
            if(is_null($hinmokuCd) || $hinmokuCd === '') {
                $resultMsg .= '「'.__('hinmoku_cd').'」'.__('が正常に送信されていません。').'\n';
                $resultFlg = false;
            }

            // 有効期間（自）
            $yukoukikanStartDate = $request -> dataStartDate;
            if(empty($yukoukikanStartDate)) {
                $resultMsg .= '「'.__('yukoukikan_start_date').'」'.__('が正常に送信されていません。').'\n';
                $resultFlg = false;
            }

            // 登録者ID
            $loginId = empty($request -> dataLoginId) ? 0 : (int)$request -> dataLoginId;

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
                    $dataId = $request -> dataId;
                    if(empty($dataId)) {
                        $resultMsg .= '「'.__('id').'」'.__('が正常に送信されていません。').'<br>';
                        $resultFlg = false;
                    }
                    // データ処理開始
                    $master -> DeleteMasterData($hinmokuCd, $yukoukikanStartDate, $loginId, $dataId);
                    break;
                // DELETE処理終了 //


                ////////////////
                // INSERT処理 //
                ////////////////
                default:
                    // 選択
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

                    // 品目区分 
                    $hinmokuKbn = $request -> dataHinmokuKbn;
                    // POSTデータチェックエラー
                    if (!is_null($hinmokuKbn) && $hinmokuKbn !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetBunruiCdCount('HINMOKUKBN', $hinmokuKbn);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('hinmoku_kbn') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataHinmokuKbn';
                            $resultFlg = false;
                        }
                    }

                    // 材料手配区分
                    $zairyouTehaiKbn = $request -> dataZairyouTehaiKbn;
                    // POSTデータチェックエラー
                    if (!is_null($zairyouTehaiKbn) && $zairyouTehaiKbn !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetBunruiCdCount('ZAITEHAI', $zairyouTehaiKbn);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('zairyou_tehai_kbn') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataZairyouTehaiKbn';
                            $resultFlg = false;
                        }
                    }

                    // 単位CD
                    $tanniCd = $request -> dataTanniCd;
                    // POSTデータチェックエラー
                    if (!is_null($tanniCd) && $tanniCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetBunruiCdCount('TANI', $tanniCd);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('tanni_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataTanniCd';
                            $resultFlg = false;
                        }
                    }

                    // 材質CD
                    $zaishitsuCd = $request -> dataZaishitsuCd;
                    // POSTデータチェックエラー
                    if (!is_null($zaishitsuCd) && $zaishitsuCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetBunruiCdCount('ZAISHITSU', $zaishitsuCd);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('zaishitsu_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataZaishitsuCd';
                            $resultFlg = false;
                        }
                    }
                    // 材質名
                    $zaishitsuName = $request -> dataZaishitsuName;

                    // メーカーCD
                    $makerCd = $request -> dataMakerCd;
                    if (!is_null($makerCd) && $makerCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetCdCount('maker_master', 'maker_cd', $makerCd);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('maker_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataMakerCd';
                            $resultFlg = false;
                        }
                    }
                    // メーカー名
                    $makerName = $request -> dataMakerName;

                    // 色CD
                    $colorCd = $request -> dataColorCd;
                    // POSTデータチェックエラー
                    if (!is_null($colorCd) && $colorCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetBunruiCdCount('COLOR', $colorCd);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('color_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataColorCd';
                            $resultFlg = false;
                        }
                    }
                    // 色名
                    $colorName = $request -> dataColorName;

                    // グレードCD
                    $gradeCd = $request -> dataGradeCd;
                    // POSTデータチェックエラー
                    if (!is_null($gradeCd) && $gradeCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetBunruiCdCount('GRADE', $gradeCd);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('grade_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataGradeCd';
                            $resultFlg = false;
                        }
                    }

                    // 形状CD
                    $keijouCd = $request -> dataKeijouCd;
                    // POSTデータチェックエラー
                    if (!is_null($keijouCd) && $keijouCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetBunruiCdCount('SHAPE', $keijouCd);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('keijou_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataKeijouCd';
                            $resultFlg = false;
                        }
                    }

                    // 通常仕入先CD
                    $shiiresakiCd = $request -> dataShiiresakiCd;
                    if (!is_null($shiiresakiCd) && $shiiresakiCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetCdCount('shiiresaki_master', 'shiiresaki_cd', $shiiresakiCd);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('tsuujou_shiiresaki_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataShiiresakiCd';
                            $resultFlg = false;
                        }
                    }

                    // 入庫置場CD
                    $nyukoOkibaCd = $request -> dataNyukoOkibaCd;
                    if (!is_null($nyukoOkibaCd) && $nyukoOkibaCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetCdCount('location_master', 'location_cd', $nyukoOkibaCd);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('nyuko_okiba_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataNyukoOkibaCd';
                            $resultFlg = false;
                        }
                    }

                    // 入庫棚CD
                    $nyukoTanaCd = $request -> dataNyukoTanaCd;
                    if (!is_null($nyukoTanaCd) && $nyukoTanaCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetCdCount('location_master', 'location_cd', $nyukoTanaCd);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('nyuko_tana_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataNyukoTanaCd';
                            $resultFlg = false;
                        }
                    }

                    // 業種CD
                    $gyoushuCd = $request -> dataGyoushuCd;
                    // POSTデータチェックエラー
                    if (!is_null($gyoushuCd) && $gyoushuCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetBunruiCdCount('GYOUSHU', $gyoushuCd);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('gyoushu_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataGyoushuCd';
                            $resultFlg = false;
                        }
                    }

                    // 使用主材料CD
                    $shuZairyouCd = $request -> dataShuZairyouCd;
                    if (!is_null($shuZairyouCd) && $shuZairyouCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetCdCount('hinmoku_master', 'hinmoku_cd', $shuZairyouCd);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('shuzairyou_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataShuZairyouCd';
                            $resultFlg = false;
                        }
                    }

                    // 得意先CD
                    $tokuisakiCd = $request -> dataTokuisakiCd;
                    if (!is_null($tokuisakiCd) && $tokuisakiCd !== '') {
                        // コードが存在しない場合はエラー
                        $result = $common->GetCdCount('tokuisaki_master', 'tokuisaki_cd', $tokuisakiCd);
                        if ($result < 1) {
                            $resultMsg .= __('登録されていない') . '「' . __('tokuisaki_cd') . '」' . __('です。') . '<br>';
                            $resultVal[] = 'dataTokuisakiCd';
                            $resultFlg = false;
                        }
                    }

                    // 重複禁止
                    // 品目CDは新規登録の際、既に存在する品目CDの場合はエラー
                    $result = $common -> GetCdCount($tableName, 'hinmoku_cd', $hinmokuCd);
                    if($result > 0 && $SQLType === SQL_INSERT) {
                        $resultMsg .= __('既に登録されている').'「'.__('hinmoku_cd').'」'.__('です。').'<br>';
                        $resultVal[] = 'dataHinmokuCd';
                        $resultFlg = false;
                    }

                    // 品目名1
                    $hinmokuName1 = $request -> dataHinmokuName1;
                    // 品目名(ｶﾅ)
                    $hinmokuName2 = $request -> dataHinmokuName2;
                    // 材質名
                    $zaishitsuName = $request -> dataZaishitsuName;
                    // メーカー名
                    $makerName = $request -> dataMakerName;
                    // 色名
                    $colorName = $request -> dataColorName;
                    // 規格
                    $kikakuName = $request -> dataKikakuName;
                    // サイズ　(W)幅
                    $sizeW = $request -> dataSizeW;
                    // サイズ　(D)奥行
                    $sizeD = $request -> dataSizeD;
                    // サイズ　(H)高さ
                    $sizeH = $request -> dataSizeH;
                    // 材料規格
                    $kikaku = $request -> dataKikaku;
                    // 新規受注シート区分
                    $shinkiJuchuSheetKbn = $request -> dataShinkiJuchuSheetKbn;
                    // 製品寸法
                    $itemsize = $request -> dataItemSize;
                    // 切断寸法
                    $cuttingsize = $request -> dataCuttingSize;
                    // 客先品名番
                    $kyakusakiHinbanCd = $request -> dataKyakusakiHinbanCd;
                    // フォルダー名
                    $folderName = $request -> dataFolderName;
                    // ファイル名
                    $fileName = $request -> dataFileName;
                    // 材料費
                    $zairyouKin = $request -> dataZairyouKin;
                    // 図面番号
                    $zumen_no = $request -> dataZumenNo;
                    // 子図面1
                    $kozumen1 = $request -> dataKozumen1;  
                    // // 子図面2
                    // $kozumen2 = $request -> dataKozumen2;
                    // // 子図面3
                    // $kozumen3 = $request -> dataKozumen3;
                    // // 子図面4
                    // $kozumen4 = $request -> dataKozumen4;
                    // // 子図面5
                    // $kozumen5 = $request -> dataKozumen5;
                    // ネジゲージ
                    $nejiGeji = $request -> dataNejiGeji;
                    // 作業内訳1
                    $sagyouUchiwake1 = $request -> dataSagyouUchiwake1;
                    // 作業内訳2
                    $sagyouUchiwake2 = $request -> dataSagyouUchiwake2;
                    // 作業内訳3
                    $sagyouUchiwake3 = $request -> dataSagyouUchiwake3;
                    // 備考（営業）
                    $bikouEigyou = $request -> dataBikouEigyou;
                    // 備考
                    $bikou = $request -> dataBikou;
                    // 部品番号
                    $buban = $request -> dataBuban;
                    // 計画品目原価
                    $keikakuHinmokuGenkaKin = $request -> dataKeikakuHinmokuGenkaKin;

                    // ラジオ選択
                    // 材料区分
                    $zairyouKbn = $request -> dataZairyouKbn;
                    // 拠点材料区分
                    $kyotenZairyouKbn = $request -> dataKyotenZairyouKbn;
                    // 社内材料区分
                    $shanaiZairyouKbn = $request -> dataShanaiZairyouKbn;

                    // チェックボックス
                    // 受注品区分
                    $jhuchuhinKbn = $request -> dataJhuchuhinKbn;
                    // 中間仕掛区分
                    $shikakariKbn = $request -> dataShikakariKbn;
                    // 副資材区分
                    $fukushizaiKbn = $request -> dataFukushizaiKbn;

                    // ラジオボタン
                    // 諸口区分
                    $shokuchiKbn = (int)$request -> dataShokuchiKbn;
                    // 在庫管理対象外区分
                    $zaikokanriKbn = $request -> dataZaikokanriKbn;
                    // 単価入力区分
                    
                    $tankaInputKbn = $request -> dataTankaInputKbn;
                    // 消費税区分
                    $shouhizeiKbn = $request -> dataShouhizeiKbn;
                    // 軽減税率適用区分
                    $keigenzeiritsuKbn = $request -> dataKeigenzeiritsuKbn;
                    // 図面区分
                    $zumenKbn = $request -> dataZumenKbn;
                    // 検査区分
                    $kensaKbn = $request -> dataKensaKbn;
                    // 余剰在庫区分
                    $yojouzaikoKbn = $request -> dataYojouzaikoKbn;

                    if (!$resultFlg) throw new Exception($resultMsg);

                    // 有効期間終了の設定
                    $yukoukikanEndDate = date('Y/m/d', strtotime('2199-12-31'));
                    // バインドの設定
                    $SQLBind = array();
                    $SQLBind[] = array('jigyoubu_cd', $jigyoubuCd, TYPE_STR);
                    $SQLBind[] = array('hinmoku_cd', $hinmokuCd, TYPE_STR);
                    $SQLBind[] = array('hinmoku_name1', $hinmokuName1, TYPE_STR);
                    $SQLBind[] = array('hinmoku_name2', $hinmokuName2, TYPE_STR);
                    $SQLBind[] = array('hinmoku_kbn', $hinmokuKbn, TYPE_STR);
                    $SQLBind[] = array('zairyou_kbn', $zairyouKbn, TYPE_INT);
                    $SQLBind[] = array('kyoten_zairyou_kbn', $kyotenZairyouKbn, TYPE_INT);
                    $SQLBind[] = array('shanai_zairyou_kbn', $shanaiZairyouKbn, TYPE_INT);
                    $SQLBind[] = array('jhuchuhin_kbn', $jhuchuhinKbn, TYPE_INT);
                    $SQLBind[] = array('shikakari_kbn', $shikakariKbn, TYPE_INT);
                    $SQLBind[] = array('fukushizai_kbn', $fukushizaiKbn, TYPE_INT);
                    $SQLBind[] = array('tanni_cd', $tanniCd, TYPE_STR);
                    $SQLBind[] = array('shokuchi_kbn', $shokuchiKbn, TYPE_INT);
                    $SQLBind[] = array('zaikokanri_taishougai_kbn', $zaikokanriKbn, TYPE_INT);
                    $SQLBind[] = array('tanka_input_kbn', $tankaInputKbn, TYPE_INT);
                    $SQLBind[] = array('shouhizei_kbn', $shouhizeiKbn, TYPE_INT);
                    $SQLBind[] = array('keigenzeiritsu_kbn', $keigenzeiritsuKbn, TYPE_INT);
                    $SQLBind[] = array('zaishitsu_cd', $zaishitsuCd, TYPE_STR);
                    $SQLBind[] = array('zaishitsu_name', $zaishitsuName, TYPE_STR);
                    $SQLBind[] = array('maker_cd', $makerCd, TYPE_STR);
                    $SQLBind[] = array('maker_name', $makerName, TYPE_STR);
                    $SQLBind[] = array('color_cd', $colorCd, TYPE_STR);
                    $SQLBind[] = array('color_name', $colorName, TYPE_STR);
                    $SQLBind[] = array('grade_cd', $gradeCd, TYPE_STR);
                    $SQLBind[] = array('keijou_cd', $keijouCd, TYPE_STR);
                    $SQLBind[] = array('kikaku_name', $kikakuName, TYPE_STR);
                    $SQLBind[] = array('size_w', $sizeW, TYPE_STR);
                    $SQLBind[] = array('size_d', $sizeD, TYPE_STR);
                    $SQLBind[] = array('size_h', $sizeH, TYPE_STR);
                    $SQLBind[] = array('shiiresaki_cd', $shiiresakiCd, TYPE_STR);
                    $SQLBind[] = array('nyuko_okiba_cd', $nyukoOkibaCd, TYPE_STR);
                    $SQLBind[] = array('nyuko_tana_cd', $nyukoTanaCd, TYPE_STR);
                    $SQLBind[] = array('kikaku', $kikaku, TYPE_STR);
                    $SQLBind[] = array('gyoushu_cd', $gyoushuCd, TYPE_STR);
                    $SQLBind[] = array('zumen_kbn', $zumenKbn, TYPE_INT);
                    $SQLBind[] = array('kensa_kbn', $kensaKbn, TYPE_INT);
                    $SQLBind[] = array('shinki_juchu_sheet_kbn', $shinkiJuchuSheetKbn, TYPE_STR);
                    $SQLBind[] = array('yojouzaiko_kbn', $yojouzaikoKbn, TYPE_INT);
                    $SQLBind[] = array('item_Size', $itemsize, TYPE_STR);
                    $SQLBind[] = array('cutting_Size', $cuttingsize, TYPE_STR);
                    $SQLBind[] = array('shuzairyou_cd', $shuZairyouCd, TYPE_STR);
                    $SQLBind[] = array('kyakusaki_hinban_cd', $kyakusakiHinbanCd, TYPE_STR);
                    $SQLBind[] = array('folder_name', $folderName, TYPE_STR);
                    $SQLBind[] = array('file_name', $fileName, TYPE_STR);
                    $SQLBind[] = array('zairyou_kin', $zairyouKin, TYPE_STR);
                    $SQLBind[] = array('zumen_no', $zumen_no, TYPE_STR);
                    $SQLBind[] = array('kozumen1', $kozumen1, TYPE_STR);
                    // $SQLBind[] = array('kozumen2', $kozumen2, TYPE_STR);
                    // $SQLBind[] = array('kozumen3', $kozumen3, TYPE_STR);
                    // $SQLBind[] = array('kozumen4', $kozumen4, TYPE_STR);
                    // $SQLBind[] = array('kozumen5', $kozumen5, TYPE_STR);
                    $SQLBind[] = array('tokuisaki_cd', $tokuisakiCd, TYPE_STR);
                    $SQLBind[] = array('neji_geji', $nejiGeji, TYPE_STR);
                    $SQLBind[] = array('sagyou_uchiwake1', $sagyouUchiwake1, TYPE_STR);
                    $SQLBind[] = array('sagyou_uchiwake2', $sagyouUchiwake2, TYPE_STR);
                    $SQLBind[] = array('sagyou_uchiwake3', $sagyouUchiwake3, TYPE_STR);
                    $SQLBind[] = array('bikou_eigyou', $bikouEigyou, TYPE_STR);
                    $SQLBind[] = array('bikou', $bikou, TYPE_STR);
                    $SQLBind[] = array('buban', $buban, TYPE_STR);
                    $SQLBind[] = array('zairyou_tehai_kbn', $zairyouTehaiKbn, TYPE_INT);
                    $SQLBind[] = array('keikaku_hinmoku_genka_kin', $keikakuHinmokuGenkaKin, TYPE_STR);
                    // データ処理開始
                    $master -> InsertMasterData($SQLBind, $hinmokuCd, $yukoukikanStartDate, $yukoukikanEndDate, $loginId, $SQLType);
                    $resultVal[] = $common -> GetMaxId($tableName, $query);
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
