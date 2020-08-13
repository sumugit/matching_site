<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="icon" type="image/png" href="siteimages/matchingNav.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.10.2/css/all.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/table.css" rel="stylesheet">
    <link href="css/button.css" rel="stylesheet">
    <title>プロフィール閲覧</title>
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
            if(empty($_GET['id'])){
                header("Location: beyondExpectations.php");
                exit();
            }
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
                        //URLパラメータからid取得
                        $id = htmlspecialchars($_GET['id']);
                        //いいねボタンに用いる
                        if (is_file("./csv/profile.csv")) { //登録ファイルが存在するか
                            if (is_readable("./csv/profile.csv")) { //登録ファイルを読み込めるか
                                $fp = fopen("./csv/profile.csv", "r");
                                flock($fp, LOCK_SH);
                                //idが登録ユーザーと一致するまで一行ずつ取り出す
                                while (!feof($fp)) {
                                    $content = fgetcsv($fp);
                                    //閲覧しているユーザーの情報を取得
                                    if ($content[0] == $id) {
                                        //足跡の記録
                                        if (is_file("./csv/footPrint.csv")) { //ファイルが存在するか
                                            if (is_readable("./csv/footPrint.csv")) { //ファイルを読み込めるか
                                                $fp3 = fopen("./csv/footPrint.csv", "r");
                                                flock($fp3, LOCK_SH);
                                                $flagTrace = false;
                                                //idが登録ユーザーと一致するまで一行ずつ取り出す
                                                while (!feof($fp3)) {
                                                    $trace = fgetcsv($fp3);
                                                    //もし以前に足跡をそのアカウントに押していたら
                                                    if ($trace[0] == $_SESSION['id'] && $trace[1] == $id) {
                                                        $flagTrace = true;
                                                        break;
                                                    }
                                                }
                                                //ファイルを閉じる
                                                flock($fp3, LOCK_UN);
                                                fclose($fp3);
                                                //そのアカウントにまだ足跡を付けたことが無い
                                                if ($flagTrace == false) {
                                                    $fp3 = fopen("./csv/footPrint.csv", "a+");
                                                    //ファイルの排他ロック
                                                    flock($fp3, LOCK_EX);
                                                    //ファイルに書き込み
                                                    fputcsv($fp3, array($_SESSION['id'], $id));
                                                    //ロック解除
                                                    flock($fp3, LOCK_UN);
                                                    fclose($fp3);
                                                }
                                            } else {
                                                header("Location: fileError.php");
                                                exit();
                                            }
                                        } else {
                                            header("Location: fileError.php");
                                            exit();
                                        }
                                        //ループを抜ける
                                        break;
                                    }
                                }
                                //登録ファイルを閉じる
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
                        <!-- jQueryのAjaxでPOST送信してPHPで受け取る-->
                        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
                        <script type="text/javascript">
                            //いいねボタンが押された場合
                            function good() {
                                var obj = document.getElementById('good');
                                obj.style.color = '#ffffff'; //文字色を白にする
                                obj.style.backgroundColor = '#DEC031'; //背景色を黄色にする
                                // 入力されたID値を取得
                                $(function() {
                                    //Ajax通信(いいね押して別のページに遷移するのは不便だから)
                                    $.ajax({
                                        type: "POST",
                                        url: "addGood.php",
                                        data: {
                                            "mine": <?php echo $_SESSION['id']; ?>,
                                            "opponent": <?php echo $id; ?>
                                        },
                                        dataType: "json"
                                    }).done(function(data) {
                                        $("#res").text(data.mine + ' : ' + data.opponent);
                                    }).fail(function(XMLHttpRequest, textStatus, error) {
                                        alert(error);
                                    });
                                });
                            }
                            //タイプボタンが押された場合
                            function love() {
                                var obj = document.getElementById('love');
                                obj.style.color = '#ffffff'; //文字色を白にする
                                obj.style.backgroundColor = '#FE7F9C'; //背景色を黄色にする
                                // 入力されたID値を取得
                                $(function() {
                                    //Ajax通信(いいね押して別のページに遷移するのは不便だから)
                                    $.ajax({
                                        type: "POST",
                                        url: "addLove.php",
                                        data: {
                                            "mine": <?php echo $_SESSION['id']; ?>,
                                            "opponent": <?php echo $id; ?>
                                        },
                                        dataType: "json"
                                    }).done(function(data) {
                                        $("#res").text(data.mine + ' : ' + data.opponent);
                                    }).fail(function(XMLHttpRequest, textStatus, error) {
                                        alert(error);
                                    });
                                });
                            }
                        </script>
                        </br>
                        <input type="button" id="good" value="いいね！" class="btn-pushGood" onclick="good();">
                        <input type="button" id="love" value="タイプ！" class="btn-pushLove" onclick="love();"><br><br>
                        <?php print '<a href=\'chat.php?id=' . $id . '\' class="btn btn--blue btn--cubic"><i class="fa fas fa-envelope"></i>メッセージを送る</a>'; ?>
                        <table>
                            <!--画像の挿入-->
                            <?php print "<tr><td colspan=\"2\">" . '<div class="center"><img border="0" src="' . $content[1] . '" width="500" height="500" alt="プロフィール画像"></div>' . "</td></tr>"; ?>
                            <?php print "<th colspan=\"2\">自己紹介</th>"; ?>
                            <?php print "<tr><td colspan=\"2\">" . $content[2] . "</td></tr>"; ?>
                            <?php print "<th colspan=\"2\">基本情報</th>"; ?>
                            <?php print "<tr><td>ニックネーム</td><td>" . $content[3] . "</td></tr>"; ?>
                            <?php print "<tr><td>年齢</td><td>" . $content[4] . "</td></tr>"; ?>
                            <?php print "<tr><td>居住地</td><td>" . $content[5] . "</td></tr>"; ?>
                            <?php print "<tr><td>出身地</td><td>" . $content[6] . "</td></tr>"; ?>
                            <?php print "<tr><td>血液型</td><td>" . $content[7] . "</td></tr>"; ?>
                            <?php print "<tr><td>星座</td><td>" . $content[8] . "</td></tr>"; ?>
                            <?php print "<th colspan=\"2\">外見</th>"; ?>
                            <?php print "<tr><td>身長</td><td>" . $content[9] . "</td></tr>"; ?>
                            <?php print "<tr><td>スタイル</td><td>" . $content[10] . "</td></tr>"; ?>
                            <?php print "<tr><td>ルックス</td><td>" . $content[11] . "</td></tr>"; ?>
                            <?php print "<th colspan=\"2\">仕事・学歴</th>"; ?>
                            <?php print "<tr><td>職業</td><td>" . $content[12] . "</td></tr>"; ?>
                            <?php print "<tr><td>年収</td><td>" . $content[13] . "</td></tr>"; ?>
                            <?php print "<th colspan=\"2\">ライフスタイル</th>"; ?>
                            <?php print "<tr><td>交際ステータス</td><td>" . $content[14] . "</td></tr>"; ?>
                            <?php print "<tr><td>子供</td><td>" . $content[15] . "</td></tr>"; ?>
                            <?php print "<tr><td>たばこ</td><td>" . $content[16] . "</td></tr>"; ?>
                            <?php print "<tr><td>お酒</td><td>" . $content[17] . "</td></tr>"; ?>
                            <?php print "<tr><td>クルマ</td><td>" . $content[18] . "</td></tr>"; ?>
                            <?php print "<tr><td>同居人</td><td>" . $content[19] . "</td></tr>"; ?>
                            <?php print "<tr><td>兄弟関係</td><td>" . $content[20] . "</td></tr>"; ?>
                            <?php print "<th colspan=\"2\">相手に求める条件</th>"; ?>
                            <?php print "<tr><td>出会うまでの希望</td><td>" . $content[21] . "</td></tr>"; ?>
                            <?php print "<tr><td>初回デート費用</td><td>" . $content[22] . "</td></tr>"; ?>
                        </table>
                        </br>
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