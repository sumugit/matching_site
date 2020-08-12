<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="icon" type="image/png" href="siteimages/matchingNav.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/chat.css">
    <link href="css/chatStyle.css" rel="stylesheet">
    <link href="css/table.css" rel="stylesheet">
    <title>メッセージ</title>
</head>

<body background="siteimages/b094.jpg">
    <div class="left-column">
        <p class="icon"><img class="logo" src="siteimages/matchingNav.png" alt="マッチングナビロゴ"></p>
        <!--左サイドバー-->
        <ul class="sideBar">
            <li><a href="index.php">ホーム</a></li>
            <li><a href="serach.php">プロフ検索</a></li>
            <li><a href="chatInfo.php">メッセージ</a></li>
            <li><a href="profile.php">プロフィール</a></li>
            <li><a href="loginInfo.php">登録情報</a></li>
            <li><a href="confirmFootPrint.php">足跡</a></li>
            <li><a href="confirmGood.php">あなたへのいいね</a></li>
            <li><a href="confirmLove.php">あなたへのタイプ</a></li>
            <li><a href="confirmMyGood.php">いいねした相手</a></li>
            <li><a href="confirmMyLove.php">タイプした相手</a></li>
            <li><a href="info.php">お知らせ</a></li>
            <li><a href="news.php">最新情報</a></li>
            <li><a href="constant.php">お問い合わせ</a></li>
        </ul>
    </div>
    <div class="wrapper">
        <div class="right-column">
            <?php
            //ログイン状態
            session_start();
            session_regenerate_id(true);
            //変数がセットされているか
            if (isset($_SESSION['login']) == false) {
                header("Location: loginMove.php");
                exit();
            } else {
                print '<p id ="login">';
                print $_SESSION['nickname'] . '様-';
                print '<a href="logout.php"><b>ログアウト</b></a>';
                print '<br><p>';
            }
            ?>
            <header>
                <div class="top-header">
                    <nav>
                        <ul>
                            <li><a href="about.php" class="btn4">マッチングナビとは</a></li>
                            <li><a href="payment.php" class="btn4">ご利用料金</a></li>
                            <li><a href="howToPay.php" class="btn4">お支払い方法</a></li>
                            <li><a href="back.php" class="btn4">料金の払い戻し</a></li>
                            <li><a href="firm.php" class="btn4">会社情報</a></li>
                            <li><a href="contact.php" class="btn4">お問い合わせ</a></li>
                        </ul>
                    </nav>
                </div>
            </header>
            <div id="contenar">
                <div id="field">
                    <div id="home" class="top-image-area">
                        <a href="index.php"><img class="logo" src="siteimages/header.png" height="130" alt="マッチングナビロゴ"></a>
                        <div class="page-header">
                            <nav>
                                <ul class="main-nav">
                                    <li><a href="index.php" class="btn4"><i class="fas fa-home"></i>ホーム</a></li>
                                    <li><a href="search.php" class="btn4"><i class="fas fa-search"></i>プロフ検索</a></li>
                                    <li><a href="bulletinInfo.php" class="btn4"><i class="fas fa-clipboard"></i>掲示板</a></li>
                                    <li><a href="chatInfo.php" class="btn4"><i class="fas fa-comment-dots"></i>メッセージ</a></li>
                                    <li><a href="myPage.php" class="btn4"><i class="fas fa-address-card"></i>マイページ</a></li>
                                    <li><a href="contact.php" class="btn4"><i class="fas fa-phone"></i>お問い合わせ</a></li>
                                </ul>
                            </nav>
                        </div>
                        <p><a href="javascript:history.back();" class="btn-flat-BackAll"><i class="fa fa-chevron-left"></i>戻る</a></p>
                        </br>
                        <?php
                        //URLパラメータから相手のid取得
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
                                header("Location: fileError.php");
                                exit();
                            }
                        } else {
                            header("Location: fileError.php");
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
            <div class="footer-wrapper">
                <footer>
                    <div class="foot-wrap">
                        <div class="menu-left">
                            <h3>マッチングナビについて</h3>
                            <ul class="foot-left">
                                <li><a href="about.php">マッチングナビとは</a></li>
                                <li><a href="service.php">サービス</a></li>
                                <li><a href="rule.php">会員規約</a></li>
                            </ul>
                        </div>
                        <div class="menu-center">
                            <h3>決済</h3>
                            <ul class="foot-center">
                                <li><a href="payment.php">ご利用料金</a></li>
                                <li><a href="howToPay.php">お支払い方法</a></li>
                                <li><a href="back.php">料金の払い戻し</a></li>
                            </ul>
                        </div>
                        <div class="menu-right">
                            <h3>個人情報の取り扱い</h3>
                            <ul class="foot-right">
                                <li><a href="policy.php">プライバシーポリシー</a></li>
                                <li><a href="firm.php">特定商取引法に基づく表記</a></li>
                                <li><a href="contact.php">お問い合わせ</a></li>
                            </ul>
                        </div>
                        <small class="cmark">©️copyright マッチングナビ 2020
                        </small>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</body>

</html>