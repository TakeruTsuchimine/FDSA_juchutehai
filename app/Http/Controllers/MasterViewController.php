<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterViewController extends Controller
{
    public function index(Request $request)
    {
        // システム名
        $systemName = '生産管理システム';
        // ログイン者名
        $loginName = 'システム管理者';
        // マスタ画面の呼び出しエイリアス宣言
        $targetPage = $request->targetPage;
        //
        $categoryCd = '';
        // ページのタイトル
        $pageTitle = '';

        // 呼び出しページの場合分け
        switch ($targetPage) {
                // 「担当者マスタ」
            case '0400':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('担当者') . __('マスタ');
                break;
                // 「階層分類マスタ」
            case '1300':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('階層分類') . __('マスタ');
                break;
                // 「備考マスタ」
            case '1301':
                $pageTitle = __('備考') . __('マスタ');
                $categoryCd = 'BIKO';
                $targetPage = 'PVMST_1300';
                break;
                // 「不良マスタ」
            case '1302':
                $pageTitle = __('不良') . __('マスタ');
                $categoryCd = 'FURYO';
                $targetPage = 'PVMST_1300';
                break;
                // 「グレードマスタ」
            case '1303':
                $pageTitle = __('グレード') . __('マスタ');
                $categoryCd = 'GURED';
                $targetPage = 'PVMST_1300';
                break;
                // 「業種マスタ」
            case '1304':
                $pageTitle = __('業種') . __('マスタ');
                $categoryCd = 'GYOSHU';
                $targetPage = 'PVMST_1300';
                break;
                // 「業態マスタ」
            case '1305':
                $pageTitle = __('業態') . __('マスタ');
                $categoryCd = 'GYOTAI';
                $targetPage = 'PVMST_1300';
                break;
                // 「品目区分マスタ」
            case '1306':
                $pageTitle = __('品目区分') . __('マスタ');
                $categoryCd = 'HINMOKUKBN';
                $targetPage = 'PVMST_1300';
                break;
                // 「配送便マスタ」
            case '1307':
                $pageTitle = __('配送便') . __('マスタ');
                $categoryCd = 'HAISOUBIN';
                $targetPage = 'PVMST_1300';
                break;
                // 「色マスタ」
            case '1308':
                $pageTitle = __('色') . __('マスタ');
                $categoryCd = 'COLOR';
                $targetPage = 'PVMST_1300';
                break;
                // 「受注区分マスタ」
            case '1309':
                $pageTitle = __('受注区分') . __('マスタ');
                $categoryCd = 'JUCHUKBN';
                $targetPage = 'PVMST_1300';
                break;
                // 「クレームマスタ」
            case '1310':
                $pageTitle = __('クレーム') . __('マスタ');
                $categoryCd = 'CLAIM';
                $targetPage = 'PVMST_1300';
                break;
                // 「メーカーマスタ」
            case '1311':
                $pageTitle = __('メーカー') . __('マスタ');
                $categoryCd = 'MAKER';
                $targetPage = 'PVMST_1300';
                break;
                // 「見積区分マスタ」
            case '1312':
                $pageTitle = __('見積区分') . __('マスタ');
                $categoryCd = 'MITSUKBN';
                $targetPage = 'PVMST_1300';
                break;
                // 「納入場所マスタ」
            case '1313':
                $pageTitle = __('納入場所') . __('マスタ');
                $categoryCd = 'NOUNYU';
                $targetPage = 'PVMST_1300';
                break;
                // 「仕入区分マスタ」
            case '1314':
                $pageTitle = __('仕入区分') . __('マスタ');
                $categoryCd = 'SHIIREKBN';
                $targetPage = 'PVMST_1300';
                break;
                // 「材料手配マスタ」
            case '1315':
                $pageTitle = __('材料手配') . __('マスタ');
                $categoryCd = 'ZAITEKBN';
                $targetPage = 'PVMST_1300';
                break;
                // 「単位マスタ」
            case '1316':
                $pageTitle = __('単位') . __('マスタ');
                $categoryCd = 'TANI';
                $targetPage = 'PVMST_1300';
                break;
                // 「受注入力」
            case '3800':
                $pageTitle = __('受注入力');
                $targetPage = 'PVJUI_3800';
                break;
                // 「受注入力」
            case '4100':
                $pageTitle = __('受注手配');
                $targetPage = 'PVJUI_4100';
                break;

            // 真鍋対応分
                // 「部署マスタ」
            case '0300':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('部署') . __('マスタ');
                break;
                // 「工程マスタ」
            case '0600':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('工程') . __('マスタ');
                break;
                // 「機械マスタ」
            case '0800':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('機械') . __('マスタ');
                break;
                // 「業務マスタ」
            case '1310':
                $pageTitle = __('業務') . __('マスタ');
                $categoryCd = 'C001';
                if ($categoryCd == '') $pageTitle = __('階層分類') . __('マスタ');
                $targetPage = 'PVMST_1300';
                break;
                // 「色マスタ」
            case '1320':
                $pageTitle = __('色') . __('マスタ');
                $categoryCd = 'C002';
                if ($categoryCd == '') $pageTitle = __('階層分類') . __('マスタ');
                $targetPage = 'PVMST_1300';
                break;
                // 「置場・棚番マスタ」
            case '2100':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('置場・棚番') . __('マスタ');
                break;
                // 「シフトマスタ」
            case '2900':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('シフト') . __('マスタ');
                break;
                // 「カレンダーマスタ」
            case '3100':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('カレンダー') . __('マスタ');
                break;
                // 「メニュータブマスタ」
            case '6100':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('メニューグループ') . __('マスタ');
                break;
                // 「メニューマスタ」
            case '6200':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('メニュー') . __('マスタ');
                break;

                // 山下対応分
                 // 「担当割付候補マスタ」
            case '0500':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('担当割付候補') . __('マスタ');
                break;
                // 「機械割付候補マスタ」
            case '0900':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('機械割付候補') . __('マスタ');
                break;
                // 「得意先マスタ」
            case '1400':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('得意先') . __('マスタ');
                break;
                // 「得意先別納入先マスタ」
            case '1600':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('得意先別納入先') . __('マスタ');
                break;
                // 「仕入外注先マスタ」
            case '1800':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('仕入外注先') . __('マスタ');
                break;
                // 「外注先手配候補マスタ」
            case '1900':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('外注先手配候補') . __('マスタ');
                break;
            // 「メーカマスタ」
            case '2000':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('メーカ') . __('マスタ');
                break;
            // 「受注まとめ入力」
            case '4000':
                $pageTitle = __('受注まとめ入力');
                $targetPage = 'PVJUI_4000';
                break;

            // 工藤対応分
            // 「事業部マスタ」
            case '0100':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('事業部') . __('マスタ');
                break;
            // 「構成ヘッダマスタ」
            case '3200':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('構成ヘッダ') . __('マスタ');
                break;
            // 「請求マスタ」
            case '6300':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('請求書') . __('マスタ');
                break;

            // 土嶺対応分
            // 「品目マスタ」
            case '2600':
                $targetPage = 'PVMST_' . $targetPage;
                $pageTitle = __('品目') . __('マスタ');
                break;
        }


        // ページ呼び出し
        return view($targetPage, [
            "systemName" => $systemName,
            "loginName"  => $loginName,
            "kengenKbn"  => 9,
            "pageTitle"  => $pageTitle,
            "categoryCd" => $categoryCd
        ]);
    }
}
