<div id="dlgAlertMsg">
    <!--ダイアログヘッダー-->
    <div class="wj-dialog-header" style="padding :5px;">
        <?php echo __('確認'); ?>
    </div>
    <!--メッセージ-->
    <p id="alertMsg" style="padding: 20px; overflow: auto;"></p>
    <!--ダイアログフッター-->
    <div class="flex-box flex-end" style="padding: 20px;">
        <!--確認ボタン-->
        <button id="btnKakunin" class="btn btn-primary" type="button" onclick="CloseAlertDlg();">
            <?php echo __('F9').__('確認'); ?>
        </button>
    </div>
</div>