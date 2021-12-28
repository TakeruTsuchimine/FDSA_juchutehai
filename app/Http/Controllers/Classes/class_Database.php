<?php
// Ver.2021104-01
namespace App\Http\Controllers\Classes;

use PDO;
use Exception;

// DBプロバイダ種別
define("PROV_ORACLE",   0);
define("PROV_MSSQL",    1);
define("PROV_POSTGRES", 2);
define("PROV_MYSQL",    3);

// トランザクション種別
define("SQL_SELECT", 0);
define("SQL_INSERT", 1);
define("SQL_UPDATE", 2);
define("SQL_DELETE", 3);

// バインド変数種別
define("TYPE_INT",  PDO::PARAM_INT);
define("TYPE_STR",  PDO::PARAM_STR);
define("TYPE_DATE", -1);

// LIKE文検索方法
define("SEARCH_LIKE_BOTH", 0);
define("SEARCH_LIKE_HEAD", 1);
define("SEARCH_LIKE_TAIL", 2);
define("SEARCH_LIKE_NONE", 3);

define("VALUE_LIKE_BOTH", '?0?');
define("VALUE_LIKE_HEAD", '?1?');
define("VALUE_LIKE_TAIL", '?2?');
define("VALUE_LIKE_NONE", '?3?');

// SQLエスケープ文字（LIKE文）
define("ESCAPE_CHAR", array('%', '_'));

// クラス宣言
class class_Database
{
    //
    public $typeSQL;
    //
    public $connect;
    //
    public $query;
    //
    public $bindCnt;

    // コンストラクタ
    function __construct()
    {
    }

    // DB接続
    function ConnectDatabase(): PDO
    {
        $connection = null;
        // DB種別毎の接続文字列の生成
        $connectionString = "";
        try {
            //
            switch (env('DB_CONNECTION')) {
                    // Oracleの処理
                case 'oracle':
                    break;

                    // MSSQLの処理        
                case 'sqlserver':
                    break;

                    // Postgresの処理
                case 'postgres':
                    //             ex : "pgsql:host=localhost;dbname=fdsa"
                    $connectionString = "pgsql:host=" . env('DB_HOST') . ";dbname=" . env('DB_DATABASE') . ";port=" . env('DB_PORT');
                    $connection = new PDO($connectionString, env('DB_USERNAME'), env('DB_PASSWORD'));
                    break;

                    // MYSQLの処理
                case 'mysql':
                    break;

                    // DB種別が判別できない場合
                default:
                    throw  new Exception('DBプロバイダ指定が正しくありません。 PROVIDER : ' . env('DB_CONNECTION'));
                    break;
            }
            // 
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\Throwable $e) {
            throw $e;
        }
        return $connection;
    }

    // DB接続処理
    function StartConnect()
    {
        $this->connect = null;
        try {
            $this->connect = $this->ConnectDatabase();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    // トランザクションの開始
    function StartTransaction()
    {
        $con = $this->connect;
        try {
            $con->beginTransaction();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    // クエリのセット  
    function SetQuery($text, $type)
    {
        $con = $this->connect;
        $this->query = null;
        $this->typeSQL = $type;
        $this->bindCnt = 0;
        try {
            $qry = $con->prepare($text);
            $this->query = $qry;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    // バインド関数のセット（項目ごと）
    function SetBindValue($name, $value, $type)
    {
        $qry = $this->query;
        try {
            if ($type > 0) {
                $qry->bindValue($name, $value, $type);
            } else {
                $qry->bindValue($name, $value);
            }
            $this->bindCnt++;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    // バインド関数のセット（配列）
    function SetBindArray($array)
    {
        $qry = $this->query;
        try {
            foreach ($array as $value) {
                $this->SetBindValue(':' . $value[0], $value[1], $value[2]);
            }
        } catch (PDOException $e) {
            throw $e;
        }
    }

    //
    function CreateInsertSQL($tableValue, $array)
    {
        $SQLText = 'insert into ' . $tableValue . '( ';
        foreach ($array as $value) {
            $SQLText .= $value[0] . ',';
        }
        $SQLText = substr($SQLText, 0, -1);
        $SQLText .= ' )values( ';
        foreach ($array as $value) {
            $SQLText .= ':' . $value[0] . ',';
        }
        $SQLText = substr($SQLText, 0, -1);
        $SQLText .= ' ) ';
        return $SQLText;
    }

    // SQL実行（Select）  
    function ExecuteSelect()
    {
        $result = array();
        $qry = $this->query;
        try {
            if ($this->bindCnt > 0) $this->connect->beginTransaction();
            $qry->execute();
            $result = $qry->fetchAll();
        } catch (PDOException $e) {
            throw $e;
        }
        return $result;
    }

    //　SQLの実行（Insert, Update, Delete）
    function Execute()
    {
        $qry = $this->query;
        try {
            $qry->execute();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    // commit処理
    function Commit()
    {
        $con = $this->connect;
        try {
            $con->commit();
        } catch (\Throwable $e) {
            $e = $e->getPrevious();
            throw $e;
        }
    }

    // rollback処理
    function Rollback()
    {
        $con = $this->connect;
        try {
            $con->rollback();
        } catch (\Throwable $e) {
            $e = $e->getPrevious();
            throw $e;
        }
    }

    // クエリの後処理
    function CloseQuery()
    {
        $this->query = null;
        $this->connect = null;
    }

    // LIKE検索用のエスケープ文字処理
    function GetLikeValue($value)
    {
        //
        $value = (string)$value;
        $type = SEARCH_LIKE_NONE;

        // 「～を含む」検索
        if (strpos($value, VALUE_LIKE_BOTH) !== false) {
            $value = str_replace(VALUE_LIKE_BOTH, '', $value);
            if ($value !== '') $type = SEARCH_LIKE_BOTH;
        }
        // 「～から始まる」検索
        else if (strpos($value, VALUE_LIKE_HEAD) !== false) {
            $value = str_replace(VALUE_LIKE_HEAD, '', $value);
            if ($value !== '') $type = SEARCH_LIKE_HEAD;
        }
        // 「～で終わる」検索
        else if (strpos($value, VALUE_LIKE_TAIL) !== false) {
            $value = str_replace(VALUE_LIKE_TAIL, '', $value);
            if ($value !== '')  $type = SEARCH_LIKE_TAIL;
        }

        // ワイルドカード制御文字（? , _）のエスケープ処理
        for ($i = 0; $i < count(ESCAPE_CHAR); $i++) {
            $value = str_replace(ESCAPE_CHAR[$i], '\\' . ESCAPE_CHAR[$i], $value);
        }

        // 検索方法
        switch ($type) {
                // 部分一致
            case SEARCH_LIKE_BOTH:
                $value = '%' . $value . '%';
                break;
                // 前方一致
            case SEARCH_LIKE_HEAD:
                $value = $value . '%';
                break;
                // 後方一致
            case SEARCH_LIKE_TAIL:
                $value = '%' . $value;
                break;
        }
        return $value;
    }
}
