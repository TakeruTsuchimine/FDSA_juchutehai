<?php
// Ver.20211210-01
namespace App\Http\Controllers\Classes;

use App\Http\Controllers\Classes\class_Database;
/**
 * PHP処理の共通関数クラス
 */
class class_Common
{

    /**
     * コンストラクタ
     */
    function __construct()
    {
    }

    /**
     * キーになるコードのレコードの数を取得する
     * @param string $tableName　対象のデータテーブル名
     * @param string $cdColumn　 対象CD列名
     * @param string $cdValue  　検査対象のCD値
     * @param string $date     　対象日（省略可）
     * 
     * @return int 取得件数
     */
    function GetCdCount($tableName, $cdColumn, $cdValue, $date = ''): int
    {
        // 対象日が無い場合は今日の日付を設定
        if (empty($date)) $date = date("Y/m/d");

        $query = new class_Database();
        // SQLテキストの設定
        $SQLText  = ' select count(*) ';
        $SQLText .= ' from ' . $tableName;
        $SQLText .= " where  sakujo_dt is null
                      and    :today >= yukoukikan_start_date
                      and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31' else yukoukikan_end_date end ";
        $SQLText .= ' and ' . $cdColumn . ' = :code';
        //throw new Exception($SQLText);
        // クエリの設定
        $query->StartConnect();
        $query->SetQuery($SQLText, SQL_SELECT);
        // バインド値のセット
        $query->SetBindValue(":code", $cdValue, TYPE_STR);
        $query->SetBindValue(":today",  $date, TYPE_DATE);
        // クエリの実行
        $result = $query->ExecuteSelect();
        return $result[0][0];
    }

    /**
     * キーになる分類コードのレコードの数を取得する
     * @param string $category　対象の分類コード
     * @param string $cdValue   検査対象のCD値
     * @param string $date      対象日（省略可）
     *
     * @return int 取得件数
     */
    function GetBunruiCdCount($category, $cdValue, $date = ''): int
    {
        // 対象日が無い場合は今日の日付を設定
        if (empty($date)) $date = date("Y/m/d");
        
        $query = new class_Database();
        // SQLテキストの設定s
        $SQLText  = " select count(*)
                      from   kaisou_bunrui_master
                      where  sakujo_dt is null
                      and    :today >= yukoukikan_start_date
                      and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31' else yukoukikan_end_date end
                      and    bunrui_cd = :code
                      and    bunrui_category_cd = :category ";
        // クエリの設定
        $query->StartConnect();
        $query->SetQuery($SQLText, SQL_SELECT);
        // バインド値のセット
        $query->SetBindValue(":code", $cdValue, TYPE_STR);
        $query->SetBindValue(":category", $category, TYPE_STR);
        $query->SetBindValue(":today", $date, TYPE_DATE);
        // クエリの実行
        $result = $query->ExecuteSelect();
        return $result[0][0];
    }

    /**
     * データ挿入時の最新のID取得
     * @param string $tableName　対象のデータテーブル名
     *
     * @return int 取得ID
     */
    function GetMaxId($tableName): int
    {
        //
        $query = new class_Database();
        // SQLテキストの設定s
        $SQLText  = ' select max(id) ';
        $SQLText .= ' from ' . $tableName;
        // クエリの設定
        $query->StartConnect();
        $query->SetQuery($SQLText, SQL_SELECT);
        // クエリの実行
        $result = $query->ExecuteSelect();
        return is_null($result[0][0]) ? 0 : $result[0][0];
    }

    /**
     * 最新のパスワード取得取得
     * @param string $cdValue　検査対象のCD値
     *
     * @return string 取得Pass
     */
    function GetCurrentPass($cdValue): string
    {
        //
        $query = new class_Database();
        $resultPass = '';
        // SQLテキストの設定s
        $SQLText  = ' select login_pass ';
        $SQLText .= ' from   tantousha_master';
        $SQLText .= " where  sakujo_dt is null
                      and    :today >= yukoukikan_start_date
                      and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31' else yukoukikan_end_date end ";
        $SQLText .= ' and    tantousha_cd = :tantousha_cd';
        // クエリの設定
        $query->StartConnect();
        $query->SetQuery($SQLText, SQL_SELECT);
        // バインド値のセット
        $query->SetBindValue(":tantousha_cd", $cdValue, TYPE_STR);
        $query->SetBindValue(":today",  date("Y/m/d"), TYPE_DATE);
        // クエリの実行
        $result = $query->ExecuteSelect();
        if (count($result) < 1) return $resultPass;
        if (is_null($result[0][0])) return $resultPass;
        return $result[0][0];
    }
}
