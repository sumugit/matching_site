<?php
//ログイン状態
session_start();
session_regenerate_id(true);
//変数がセットされているか
if (isset($_SESSION['login']) == false) {
    print 'ログインされていません。<br>';
    print '<a href="login.html">ログイン画面へ</a><br>';
    print '<br>';
    exit();
} else {
    print 'ようこそ';
    print $_SESSION['nickname'] . '様-';
    print '<a href="logout.php">ログアウト</a><br>';
    print '<br>';
}
?>

<?php
//URLパラメータからindex取得
$index = htmlspecialchars($_GET['index']);
if (is_file("./csv/bulletinLog.csv")) { //ログファイルが存在するか
    if (is_readable("./csv/bulletinLog.csv")) { //ログファイルを読み込めるか
        $fp = fopen("./csv/bulletinLog.csv", "r");
        flock($fp, LOCK_SH);
        while (!feof($fp)) {
            $content = fgetcsv($fp);
            //参照しているindexが来たら抜ける
            if ($content[0] == $index) {
                break;
            }
        }
        //ログファイルを閉じる
        flock($fp, LOCK_UN);
        fclose($fp);
        //スレッドを立ち上げた人を取得
    } else {
        echo "ファイルが開けません";
        exit();
    }
} else {
    echo "スレッドが見当たりません。削除された可能性があります。";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $content[3] ?></title>
</head>

<body>
    <header>
        <h1><?php echo $content[3] ?></h1><br>
    </header>
    <!--投稿の境界を示す水平線-->
    <hr>
    <div id="result"></div>
    <p>
        <b>投稿フォーム</b><br>
        <?php echo 'ニックネーム: ' . $_SESSION['nickname'] ?><br>
        投稿内容:<br>
        <textarea name="content" size=50 id="message"></textarea><br>
        <input type="button" id="greet" value="投稿" onclick="addText();">
    </p>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            loadLog();
        }

        function addText() {
            // 入力されたテキストを取得
            $(function() {
                if (!$('#message').val()) return;
                //Ajax通信(別のページに遷移するのは不便だから)
                $.ajax({
                    type: "POST",
                    url: "bulletinLog.php",
                    data: {
                        "index": <?php echo $index; ?>,
                        "mine": <?php echo $_SESSION['id']; ?>,
                        "message": $('#message').val(),
                        "mode": "0" // 書き込み
                    },
                    dataType: "text"
                }).done(function(data) {
                    $('#result').html(data);
                }).fail(function(XMLHttpRequest, textStatus, error) {
                    alert(error);
                });
            });
            loadLog();
        }

        // ログをロードする
        function loadLog() {
            $.ajax({
                type: "POST",
                url: "bulletinLog.php",
                data: {
                    "index": <?php echo $index; ?>,
                    "mode": "1" // 書き込み
                },
                dataType: "text"
            }).done(function(data) {
                $('#result').html(data);
            });
        }
    </script>
</body>
<footer>
    <p><small>&copy; マッチングナビ 2020 仮</small></p>
</footer>

</html>