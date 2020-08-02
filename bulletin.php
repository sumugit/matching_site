<?php
//ログイン状態
session_start();
session_regenerate_id(true);
//変数がセットされているか
if (isset($_SESSION['login']) == false) {
    print 'ログインされていません。<br>';
    print '<a href="login.php">ログイン画面へ</a><br>';
    print '<br>';
    exit();
} else {
    print '<p id ="login">';
    print $_SESSION['nickname'] . '様-';
    print '<a href="logout.php"><b>ログアウト</b></a>';
    print '<br><p>';
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="css/linestyle.css" rel="stylesheet">
    <link href="css/style3.css" rel="stylesheet">
    <link href="css/bulletinButton.css" rel="stylesheet">
    <title>スレッド</title>
</head>

<body>
    <div id="contenar">
        <div id="field">
            <div id="home" class="top-image-area">
                <a href="index.php"><img class="logo" src="siteimages/header2.png" alt="マッチングナビロゴ"></a>
                <header class="page-header wrapper">
                    <nav>
                        <ul class="main-nav">
                            <li><a href="index.php" class="btn4">ホーム</a></li>
                            <li><a href="search.php" class="btn4">プロフ検索</a></li>
                            <li><a href="bulletinInfo.php" class="btn4">掲示板</a></li>
                            <li><a href="chatInfo.php" class="btn4">メッセージ</a></li>
                            <li><a href="myPage.php" class="btn4">マイページ</a></li>
                            <li><a href="contact.html" class="btn4">お問い合わせ</a></li>
                        </ul>
                    </nav>
                </header>
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
                <h1><?php echo $content[3] ?></h1><br>
                <!--ここに投稿内容が表示される-->
                <div id="result"></div>
                <p id="pad">
                    <b class="c">投稿フォーム</b><br>
                    <?php echo 'ニックネーム: ' . $_SESSION['nickname'] ?><br>
                    <textarea name="content" rows="4" cols="60" id="message" placeholder="投稿内容" required></textarea><br>
                    <input type="button" id="greet" value="投稿" class="submit" onclick="addText();">
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
            </div>
        </div>
    </div>
</body>
<div class="footer-wrapper">
    <footer>
        <p><small>&copy; マッチングナビ 2020</small></p>
    </footer>
</div>

</html>