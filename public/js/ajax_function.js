// ajax処理の関数
function AjaxData(URL, sendData, callBackFunction) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        // 送信先ファイル名
        url: URL,
        // 受け取りデータの種類
        datatype: "json",
        // 送信データ
        data: sendData
    }).done(function (data) {
        // 通信成功時の処理
        callBackFunction(data, false);
    }).fail(function (data) {
        // 通信失敗時の処理
        callBackFunction(data, true);
    });
}