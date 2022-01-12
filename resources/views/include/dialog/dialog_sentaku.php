<!--選択ダイアログ-->
<div id="dlgSentaku" style="width:50em; height:490px;">
    <!--選択フォーム-->
    <form id="frmSentaku" style="margin:0;">
        <!--ダイアログヘッダー-->
        <div class="wj-dialog-header" style="padding :5px;">
            <?php echo __('選択画面'); ?>
        </div>
        <!--フォーム-->
        <div style="padding:5px 10px;">
            <div class="flex-box flex-start">
                <div class="form-column" style="width:100%;">
                    <!--検索CD-->
                    <label>
                        <span id="captionKensakuCd"></span>
                        <input name="dataKensakuCd" class="form-control" type="text" autocomplete="off" maxlength="10" style="width:8em;" required>
                    </label>
                    <!--検索名-->
                    <label>
                        <span id="captionKensakuName"></span>
                        <input name="dataKensakuName" class="form-control" type="text" autocomplete="off" maxlength="30" style="width:22em;"  required>
                    </label>
                </div>
                <!--検索ボタン-->
                <button id="btnSentakuKensaku" class="btn btn-primary flex-right" type="button" onclick="ShowSentakuGrid();">
                    <?php echo __('F5').__('検索'); ?>
                </button>
            </div>
            <!--選択データ一覧-->
            <div id="gridSentaku" style="height:300px;"></div>
        </div>
    </form>
    <!--ダイアログフッター-->
    <div class="flex-box flex-end" style="padding:5px 10px">
        <!--選択ボタン-->
        <button id="frmSentakuFooter" id="btnSentaku" name="btnSentaku" class="btn btn-primary" type="button" style="margin-right:10px;" onclick="SetSentakuValue();">
            <?php echo __('F9').__('選択'); ?>
        </button>
        <!--戻るボタン-->
        <button id="btnSentakuCancel" class="btn btn-primary" type="button" onclick="CloseSentakuDlg();">
            <?php echo __('F12').__('戻る'); ?>
        </button>
    </div>
</div>
<!----------------->
