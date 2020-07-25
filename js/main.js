$(function () {
    //sendボタンが押されたら(#はid)
    $('#greet').click(function () {
        //user idとmessage idが空かどうか
        if (!$('#message').val()) return;
        //phpファイルを呼び出す
        $.get('chatLog.php', {
            message: $('#message').val(),
            //mode=="0"で書き込み
            mode: "0" // 書き込み
        }, function (data) {
            //dataは$outputValueの文字列
            //result idの<div>内にlogの<div>要素をひとつずつ入れる
            $('#result').html(data);
        });
    });
    loadLog();
    //logAll();
});

// ログをロードする
function loadLog() {
    $.get('chatLog.php', {
        //mode=="1"で読み込み
        mode: "1" // 読み込み
    }, function (data) {
        $('#result').html(data);
        scTarget(); //画面最下部へ移動
    });
}

// 一定間隔でログをリロードする
/*function logAll(){
	setTimeout(function(){
		loadLog();
		logAll();
	},5000); //リロード時間はここで調整
}*/

/*
 * 画面を最下部へ移動させる
 */
function scTarget() {
    //end idの位置
    var pos = $("#end").offset().top;
    $("#talkField").animate({
        scrollTop: pos
    }, 1000, "swing"); //swingで1秒で画面下に遷移するアニメーション
    return false;
}