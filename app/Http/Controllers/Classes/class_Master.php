<?php
// Ver.20211104-01
namespace App\Http\Controllers\Classes;

use Exception;
use App\Http\Controllers\Classes\class_Database;

// クラス宣言
class class_Master
{
    private $tableName;
    private $cdColName;

    // コンストラクタ
    function __construct($tableName, $codeName)
    {
        $this->tableName = $tableName;
        $this->cdColName = $codeName;
    }

    //
    // レコード追加処理
    //
    function InsertMasterData($SQLBind, $masterCd, $startDate, $endDate, $loginId, $SQLType, $subCdCol = '', $subCd = '')
    {
        try {
            //
            $query = new class_Database();
            // 対象マスタテーブル名
            $tableValue = $this->tableName;
            // 対象コード行
            $colValue   = $this->cdColName;
            // 現在年月日
            $nowDate = date("Y/m/d");
            // 現在年月日時

            $nowDateTime = date("Y/m/d H:i:s");
            //
            // 新規レコードに設定する登録日の取得
            //
            // SQL文のセット
            $SQLText  = " select min( touroku_dt ) ";
            $SQLText .= " from " . $tableValue;
            $SQLText .= " where  sakujo_dt is null
                          and    touroku_dt is not null 
                          and " . $colValue . " = :code ";
            // メインCD以外にユニーク指定に必要な要素
            if(!empty($subCdCol) && !empty($subCd)) $SQLText .= " and " . $subCdCol . " = :subCode ";
            // クエリの設定
            $query->StartConnect();
            $query->SetQuery($SQLText, SQL_INSERT);
            // バインド値のセット
            $query->SetBindValue(':code', $masterCd, TYPE_STR);
            // メインCD以外にユニーク指定に必要な要素
            if(!empty($subCdCol) && !empty($subCd)) $query->SetBindValue(':subCode', $subCd, TYPE_STR);
            // クエリの実行
            $result = $query->ExecuteSelect();
            // 
            $tourokuDt = ((is_null($result[0][0]) || $SQLType === SQL_INSERT) ? $nowDateTime : $result[0][0]);
            //
            // 新規レコードに設定する登録者IDの取得
            //
            // SQL文のセット
            $SQLText  = " select tourokusha_id ";
            $SQLText .= " from " . $tableValue;
            $SQLText .= " where  sakujo_dt is null
                          and    touroku_dt = :touroku_dt
                          and " . $colValue . " = :code ";
            // メインCD以外にユニーク指定に必要な要素
            if(!empty($subCdCol) && !empty($subCd)) $SQLText .= " and " . $subCdCol . " = :subCode ";
            // クエリの設定
            $query->StartConnect();
            $query->SetQuery($SQLText, SQL_INSERT);
            // バインド値のセット
            $query->SetBindValue(':code', $masterCd, TYPE_STR);
            $query->SetBindValue(':touroku_dt', $tourokuDt, TYPE_STR);
            // メインCD以外にユニーク指定に必要な要素
            if(!empty($subCdCol) && !empty($subCd)) $query->SetBindValue(':subCode', $subCd, TYPE_STR);
            // クエリの実行
            $result = $query->ExecuteSelect();
            // 
            $tourokushaId = $loginId;
            if (!is_null($result)) {
                if (count($result) > 0) $tourokushaId = ($SQLType === SQL_INSERT) ? $loginId : $result[0][0];
            }
            //
            // 新規追加されたデータの有効期間開始日以降にデータがある場合の処理
            //
            // SQL文のセット
            $SQLText  = " update " . $tableValue;
            $SQLText .= " set    sakujo_dt  = :sakujo_dt
                                ,sakujosha_id = :sakujosha_id
                          where  sakujo_dt is null
                          and    yukoukikan_start_date >= :yukoukikan_start_date
                          and " . $colValue . " = :code ";
            // メインCD以外にユニーク指定に必要な要素
            if(!empty($subCdCol) && !empty($subCd)) $SQLText .= " and " . $subCdCol . " = :subCode ";
            // クエリの設定
            $query->StartConnect();
            // 手動コミットとして処理
            $query->StartTransaction();
            $query->SetQuery($SQLText, SQL_UPDATE);
            // バインド値のセット
            $query->SetBindValue(':code', $masterCd, TYPE_STR);
            $query->SetBindValue(':sakujo_dt',  $nowDateTime, TYPE_DATE);
            $query->SetBindValue(':sakujosha_id', $loginId, TYPE_INT);
            $query->SetBindValue(':yukoukikan_start_date', $startDate, TYPE_DATE);
            // メインCD以外にユニーク指定に必要な要素
            if(!empty($subCdCol) && !empty($subCd)) $query->SetBindValue(':subCode', $subCd, TYPE_STR);
            $query->Execute();

            //
            // 新規レコードの追加処理
            //
            // バインド値のセット
            $SQLBind[] = array('yukoukikan_start_date', $startDate, TYPE_DATE);
            $SQLBind[] = array('yukoukikan_end_date', $endDate, TYPE_DATE);
            $SQLBind[] = array('touroku_dt', $tourokuDt, TYPE_DATE);
            $SQLBind[] = array('tourokusha_id', $tourokushaId, TYPE_STR);
            $SQLBind[] = array('koushin_dt', $nowDateTime, TYPE_DATE);
            $SQLBind[] = array('koushinsha_id', $loginId, TYPE_INT);
            // SQL文のセット
            $query->SetQuery($query->CreateInsertSQL($tableValue, $SQLBind), SQL_INSERT);
            $query->SetBindArray($SQLBind);
            $query->Execute();

            //
            // 新しく追加したレコードの有効期間開始日より開始日が前のもので且つ終了日が後のレコードがある場合の処理
            //
            $endDate = date('Y/m/d', strtotime('-1 day', strtotime($startDate)));
            $SQLText  = " update " . $tableValue;
            $SQLText .= " set    yukoukikan_end_date = :yukoukikan_end_date
                                ,koushin_dt          = :koushin_dt
                                ,koushinsha_id       = :koushinsha_id
                          where  sakujo_dt is null
                          and    yukoukikan_end_date   >= :yukoukikan_start_date 
                          and    yukoukikan_start_date <= :yukoukikan_end_date 
                          and " . $colValue . " = :code ";
            // メインCD以外にユニーク指定に必要な要素
            if(!empty($subCdCol) && !empty($subCd)) $SQLText .= " and " . $subCdCol . " = :subCode ";
            // クエリの設定
            $query->SetQuery($SQLText, SQL_UPDATE);
            $query->SetBindValue(':code', $masterCd, TYPE_STR);
            $query->SetBindValue(':yukoukikan_start_date', $startDate, TYPE_DATE);
            $query->SetBindValue(':yukoukikan_end_date', $endDate, TYPE_DATE);
            $query->SetBindValue(':koushin_dt', $nowDateTime, TYPE_DATE);
            $query->SetBindValue(':koushinsha_id', $loginId, TYPE_INT);
            // メインCD以外にユニーク指定に必要な要素
            if(!empty($subCdCol) && !empty($subCd)) $query->SetBindValue(':subCode', $subCd, TYPE_STR);
            $query->Execute();
            // 全ての処理が正常に通ったところでコミット
            $query->Commit();
        } catch (\Throwable $e) {
            // 処理エラー時には結果をロールバック
            $query->Rollback();
            // 異常処理結果
            throw new Exception('[class_Master] : '.$e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine());
        } finally {
            $query->CloseQuery();
        }
    }
    //
    // レコード削除処理
    //
    function DeleteMasterData($masterCd, $startDate, $loginId, $dataId, $subCdCol = '', $subCd = '')
    {
        try {
            //
            $query = new class_Database();
            // 対象マスタテーブル名
            $tableValue = $this->tableName;
            // 対象コード行
            $colValue   = $this->cdColName;
            // 対象コード行のバインドネーム
            $bindValue  = ":" . $colValue;
            // 現在年月日時
            $nowDateTime = date("Y/m/d H:i:s");
            //
            // 削除する担当者コードの有効期限終了より先に開始予定のデータがある場合の処理
            //
            // SQL文のセット
            $SQLText  = " select min(yukoukikan_start_date) ";
            $SQLText .= " from " . $tableValue;
            $SQLText .= " where sakujo_dt is null
                          and " . $colValue . " = :code
                          and   yukoukikan_start_date > ( select yukoukikan_end_date 
                                                          from " . $tableValue . "
                                                          where  id = :id )";
            // メインCD以外にユニーク指定に必要な要素
            if(!empty($subCdCol) && !empty($subCd)) $SQLText .= " and " . $subCdCol . " = :subCode ";
            // クエリの設定
            $query->StartConnect();
            $query->SetQuery($SQLText, SQL_INSERT);
            // バインド値のセット
            $query->SetBindValue(':code', $masterCd, TYPE_STR);
            $query->SetBindValue(':id', $dataId, TYPE_INT);
            // メインCD以外にユニーク指定に必要な要素
            if(!empty($subCdCol) && !empty($subCd)) $query->SetBindValue(':subCode', $subCd, TYPE_STR);
            // クエリの実行
            $result = $query->ExecuteSelect();

            //
            // 削除する対象レコードは有効期限終了日を実行日前日に設定する
            //
            $endDate = date('Y/m/d', strtotime('-1 day'));
            $SQLText  = " update " . $tableValue;
            $SQLText .= " set    yukoukikan_end_date = :yukoukikan_end_date
                                ,koushin_dt          = :koushin_dt
                                ,koushinsha_id       = :koushinsha_id
                          where  sakujo_dt is null
                          and    id = :id ";
            // クエリの設定
            $query->StartConnect();
            // 手動コミットとして処理
            $query->StartTransaction();
            $query->SetQuery($SQLText, SQL_UPDATE);
            $query->SetBindValue(":id", $dataId, TYPE_INT);
            $query->SetBindValue(":yukoukikan_end_date", $endDate, TYPE_DATE);
            $query->SetBindValue(":koushin_dt", $nowDateTime, TYPE_DATE);
            $query->SetBindValue(":koushinsha_id", $loginId, TYPE_INT);
            $query->Execute();

            //
            // 追加する担当者コードの有効期限終了より先に開始予定のデータがある場合は終了日を一日前に設定する 
            //   
            if (!is_null($result[0][0])) {
                // SQL文のセット
                $endDate = date('Y/m/d', strtotime('-1 day', strtotime($result[0][0])));
                $SQLText  = " update " . $tableValue;
                $SQLText .= " set    yukoukikan_end_date = :yukoukikan_end_date
                                    ,koushin_dt          = :koushin_dt
                                    ,koushinsha_id       = :koushinsha_id
                              where  sakujo_dt is null 
                              and " . $colValue . " = " . $bindValue . "
                              and    yukoukikan_end_date = ( select max(yukoukikan_end_date)
                                                             from " . $tableValue . "
                                                             where  sakujo_dt is null
                                                             and " . $colValue . " = :code
                                                             and yukoukikan_end_date < :yukoukikan_start_date )";
                // メインCD以外にユニーク指定に必要な要素
                if(!empty($subCdCol) && !empty($subCd)) $SQLText .= " and " . $subCdCol . " = :subCode ";
                // クエリの設定
                $query->SetQuery($SQLText, SQL_UPDATE);
                $query->SetBindValue(':code', $masterCd, TYPE_STR);
                $query->SetBindValue(':yukoukikan_start_date', $startDate, TYPE_DATE);
                $query->SetBindValue(':yukoukikan_end_date', $endDate, TYPE_DATE);
                $query->SetBindValue(':koushin_dt', $nowDateTime, TYPE_DATE);
                $query->SetBindValue(':koushinsha_id', $loginId, TYPE_INT);
                // メインCD以外にユニーク指定に必要な要素
                if(!empty($subCdCol) && !empty($subCd)) $query->SetBindValue(':subCode', $subCd, TYPE_STR);
                $query->Execute();
            }
            // 全ての処理が正常に通ったところでコミット
            $query->Commit();
        } catch (\Throwable $e) {
            // 処理エラー時には結果をロールバック
            $query->Rollback();
            // 異常処理結果
            throw new Exception($e->getMessage() . ' File：' . $e->getFile() . ' Line：' . $e->getLine());
        } finally {
            $query->CloseQuery();
        }
    }
}
