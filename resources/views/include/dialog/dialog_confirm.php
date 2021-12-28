<div id="dlgConfirmMsg">
    <!--ダイアログヘッダー-->
    <div class="wj-dialog-header" style="padding :5px;">
        <?php echo __('確認'); ?>
    </div>
    <!--メッセージ-->
    <p id="confirmMsg" style="padding: 20px; overflow: auto;"></p>
    <!--ダイアログフッター-->
    <div class="flex-box flex-end" style="padding: 5px 10px;">
        <!--「はい」ボタン-->
        <button id="btnConfOk" class="btn btn-primary" type="button" style="margin-right:10px;" onclick="CloseConfirmDlgOk();">
            <?php echo __('F9').__('はい'); ?>
        </button>
        <!--「はい」ボタン-->
        <button id="btnConfNo" class="btn btn-primary" type="button" onclick="CloseConfirmDlgNo();">
            <?php echo __('F12').__('いいえ'); ?>
        </button>
    </div>
</div>