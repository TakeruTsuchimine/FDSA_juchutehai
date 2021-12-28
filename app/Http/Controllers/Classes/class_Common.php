<?php
// Ver.20210927-01
namespace App\Http\Controllers\Classes;

use App\Http\Controllers\Classes\class_Database;

// クラス宣言
class class_Common
{

    // コンストラクタ
    function __construct()
    {
    }

    // キーになるコードのレコード数取得
    function GetCdCount($tableName, $cdColumn, $cdValue, $date = '')
    {
        if (empty($date)) $date = date("Y/m/d");
        //
        $query = new class_Database();
        // SQLテキストの設定s
        $SQLText  = ' select count(*) ';
        $SQLText .= ' from ' . $tableName;
        $SQLText .= " where  sakujo_dt is null
                      and    :today >= yukoukikan_start_date
                      and    :today <= case when yukoukikan_end_date is null
                                            then '2199-12-31' else yukoukikan_end_date end ";
        $SQLText .= ' and ' . $cdColumn . ' = :code';
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

    // キーになる分類コードのレコード数取得
    function GetBunruiCdCount($category, $cdValue, $date = '')
    {
        if (empty($date)) $date = date("Y/m/d");
        //
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

    // 最新のID取得
    function GetMaxId($tableName)
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

    // 最新のパスワード取得取得
    function GetCurrentPass($cdValue)
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
