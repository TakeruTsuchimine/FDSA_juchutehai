<?php
// Ver.20211210-01
namespace App\Http\Controllers\Classes;

use PDO;
use Exception;
/**
 * クラス定数
 */

/**
 * DBプロバイダ種別
 */
/** DB種別：Oracle */
define("PROV_ORACLE",   0);
/** DB種別：SQLServer */
define("PROV_MSSQL",    1);
/** DB種別：Postgres */
define("PROV_POSTGRES", 2);
/** DB種別：MySQL */
define("PROV_MYSQL",    3);

/**
 * トランザクション種別
 */
/** 処理フラグ：SELECT */
define("SQL_SELECT", 0);
/** 処理フラグ：INSERT */
define("SQL_INSERT", 1);
/** 処理フラグ：UPDATE */
define("SQL_UPDATE", 2);
/** 処理フラグ：DELETE */
define("SQL_DELETE", 3);

/**
 * バインド変数のデータ型
 */
define("TYPE_INT",  PDO::PARAM_INT);
define("TYPE_STR",  PDO::PARAM_STR);
define("TYPE_DATE", -1);

/**
 * LIKE文検索方法
 */
/** 「～を含む」検索 */
define("SEARCH_LIKE_BOTH", 0);
/** 「～をから始まる」検索 */
define("SEARCH_LIKE_HEAD", 1);
/** 「～で終わる」検索 */
define("SEARCH_LIKE_TAIL", 2);
/** 指定無し */
define("SEARCH_LIKE_NONE", 3);

/**
 * LIKE文検索フラグ
 */
/** 「～を含む」検索 */
define("VALUE_LIKE_BOTH", '?0?');
/** 「～をから始まる」検索 */
define("VALUE_LIKE_HEAD", '?1?');
/** 「～で終わる」検索 */
define("VALUE_LIKE_TAIL", '?2?');
/** 指定無し */
define("VALUE_LIKE_NONE", '?3?');

/**
 * SQLエスケープ文字（LIKE文）
 */
define("ESCAPE_CHAR", array('%', '_'));

/**
 * データベースアクセスクラス
 */
class class_Database
{
    /** PDO $connect 接続情報 */
    public $connect;
    /** PDOStatement $query プリペアドステートメント*/
    public $query;

    /**
     * コンストラクタ
     */
    function __construct()
    {
    }

    /**
     * envファイルからDB接続情報を取得してPDOオブジェクトを生成する
     *
     * @return PDO PDOオブジェクト
     */
    function ConnectDatabase(): PDO
    {
        /** PDO $connection PDOオブジェクト */
        $connection = null;
        /** string $connectionString DB種別毎の接続文字列 */
        $connectionString = "";
        try {
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
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\Throwable $e) {
            throw $e;
        }
        return $connection;
    }

    /**
     * DB接続処理
     */
    function StartConnect()
    {
        $this->connect = null;
        try {
            $this->connect = $this->ConnectDatabase();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * トランザクションの開始
     */
    function StartTransaction()
    {
        try {
            $this->connect->beginTransaction();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * SQL文の設定
     * @param string $text SQLコマンド文
     */
    function SetQuery($text, $type)
    {
        try {
            $this->query = $this->connect->prepare($text);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * バインド変数のセット（項目ごと）
     * @param string $name  バインド変数名（:value）
     * @param mixed  $value バインドする値
     * @param int    $type  バンド変数のデータ型
     */
    function SetBindValue($name, $value, $type)
    {
        try {
            if ($type > 0) {
                $this->query->bindValue($name, $value, $type);
            } else {
                $this->query->bindValue($name, $value);
            }
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * バインド変数のセット（配列）
     * @param array $array バインド変数の配列
     */
    function SetBindArray($array)
    {
        try {
            foreach ($array as $value) {
                $this->SetBindValue(':' . $value[0], $value[1], $value[2]);
            }
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * SQL実行（返り値有り Select）
     *
     * @return array $result 取得データ
     */
    function ExecuteSelect()
    {
        $result = array();
        try {
            $this->query->execute();
            $result = $this->query->fetchAll();
        } catch (PDOException $e) {
            throw $e;
        }
        return $result;
    }

    /**
     * SQLの実行（返り値無し Insert・Update・Delete）
     */
    function Execute()
    {
        try {
            $this->query->execute();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    /**
     * commit処理
     */
    function Commit()
    {
        try {
            $this->connect->commit();
        } catch (\Throwable $e) {
            $e = $e->getPrevious();
            throw $e;
        }
    }

    /**
     * rollback処理
     */
    function Rollback()
    {
        try {
            $this->connect->rollback();
        } catch (\Throwable $e) {
            $e = $e->getPrevious();
            throw $e;
        }
    }

    /**
     * PDOオブジェクトの終了処理
     */
    function CloseQuery()
    {
        $this->query = null;
        $this->connect = null;
    }

    /**
     * ILIKE検索用のエスケープ文字処理
     * @param string $value 検索値
     *
     * @return string ILIKE検索用ワイルドカード付き検索値
     */
    function GetLikeValue($value)
    {
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

    /**
     * 配列データからINSERT文を作成する
     * @param string $tableName 対象のデータテーブル名
     * @param array  $array     挿入対象のデータ列名
     *
     * @return string INSERT処理用のSQL文
     */
    function CreateInsertSQL($tableName, $array)
    {
        $SQLText = 'insert into ' . $tableName . '( ';
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
}
