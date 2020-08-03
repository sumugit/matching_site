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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="css/style3.css" rel="stylesheet">
    <link rel="stylesheet" href="css/chat.css">
    <link href="css/chatStyle.css" rel="stylesheet">
    <title>メッセージ</title>
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
                //URLパラメータからid取得
                $id = htmlspecialchars($_GET['id']);
                if (is_file("./csv/profile.csv")) { //登録ファイルが存在するか
                    if (is_readable("./csv/profile.csv")) { //登録ファイルを読み込めるか
                        $fp = fopen("./csv/profile.csv", "r");
                        flock($fp, LOCK_SH);
                        //idが相手のアカウントと一致するまで一行ずつ取り出す
                        while (!feof($fp)) {
                            $content = fgetcsv($fp);
                            //閲覧しているユーザーの情報を取得
                            if ($content[0] == $id) {
                                break;
                            }
                        }
                        //ファイルを閉じる
                        flock($fp, LOCK_UN);
                        fclose($fp);
                    } else {
                        echo "ファイルが開けません。";
                        exit();
                    }
                } else {
                    echo "ファイルがありません。";
                    exit();
                }
                ?>
                <div id="container">
                    <?php print "<h1>$content[3]</h1>"; ?>
                    <div id="talkField">
                        <!--resultにチャットのログが入る-->
                        <div id="result"></div>
                        <br class="clear_balloon" />
                        <!--チャットの末尾記録用-->
                        <div id="end"></div>
                    </div>
                    <!--入力部分-->
                    <div id="inputField">
                        <p>
                            <?php echo 'ニックネーム: ' . $_SESSION['nickname'] ?><br>
                            <textarea name="message" id="message" placeholder="メッセージ本文" required></textarea><br>
                            <input type="button" id="greet" value="送信" class="submit" onclick="addText();">
                        </p>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
                <script type="text/javascript">
                    window.onload = function() {
                        loadLog();
                    }

                    function addText() {
                        // 入力されたID値を取得
                        $(function() {
                            if (!$('#message').val()) return;
                            //Ajax通信(いいね押して別のページに遷移するのは不便だから)
                            $.ajax({
                                type: "POST",
                                url: "chatLog.php",
                                data: {
                                    "mine": <?php echo $_SESSION['id']; ?>,
                                    "opponent": <?php echo $id; ?>,
                                    "nickname": <?php echo "'$_SESSION[nickname]'"; ?>,
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
                            url: "chatLog.php",
                            data: {
                                "mine": <?php echo $_SESSION['id']; ?>,
                                "opponent": <?php echo $id; ?>,
                                "mode": "1" // 書き込み
                            },
                            dataType: "text"
                        }).done(function(data) {
                            $('#result').html(data);
                            scTarget();
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