<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="icon" type="image/png" href="siteimages/matchingNav.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="css/linestyle.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/bulletinButton.css" rel="stylesheet">
    <link href="css/table.css" rel="stylesheet">
    <title>メッセージ履歴</title>
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
            <li><a href="contact.php">お問い合わせ</a></li>
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
                        </br>
                        <div class="container">
                            <?php
                            //メッセージの履歴があるかどうか
                            $flag = false;
                            //メッセージの確認
                            if (is_file("./csv/chatLog.csv")) { //ファイルが存在するか
                                if (is_readable("./csv/chatLog.csv")) { //ファイルを読み込めるか
                                    $fp1 = fopen("./csv/chatLog.csv", "r");
                                    flock($fp1, LOCK_SH);
                                    while (!feof($fp1)) {
                                        $content = fgetcsv($fp1);
                                        //自分のidの検索
                                        if ($content[0] == $_SESSION['id']) {
                                            $flag = true;
                                            if (is_file("./csv/profile.csv")) { //ファイルが存在するか
                                                if (is_readable("./csv/profile.csv")) { //ファイルを読み込めるか
                                                    $fp2 = fopen("./csv/profile.csv", "r");
                                                    flock($fp2, LOCK_SH);
                                                    while (!feof($fp2)) {
                                                        $profile = fgetcsv($fp2);
                                                        //送った相手のid検索
                                                        if ($content[1] == $profile[0]) {
                                                            //URLパラメータ生成
                                                            print '<a href="chat.php?id=' . $profile[0] . '"><div class="item"><img src = ' . $profile[1] . ' align="left" width="128" height="128" class="userImage" alt=""><p>　' . $profile[4] . ' ' . $profile[5] . ' </p><p id="big">　' . $profile[3] . ' </p><hr  style="border:1px dashed #000000;"><p>　' . $profile[2] . ' </p></div></a>';
                                                            print '<a href="./userProfile.php?id=' . $profile[0] . '" class="Bulletinbtn Bulletinbtn--blue Bulletinbtn--cubic">プロフィール確認</a>';
                                                            break;
                                                        }
                                                    }
                                                    flock($fp2, LOCK_UN);
                                                    fclose($fp2);
                                                } else {
                                                    header("Location: fileError.php");
                                                    exit();
                                                }
                                            } else {
                                                header("Location: fileError.php");
                                                exit();
                                            }
                                        }
                                    }
                                    flock($fp1, LOCK_UN);
                                    fclose($fp1);
                                    if ($flag == false) {
                                        print "メッセージの履歴がありません。<br>";
                                    }
                                } else {
                                    header("Location: fileError.php");
                                    exit();
                                }
                            } else {
                                header("Location: fileError.php");
                                exit();
                            }
                            ?>
                        </div>
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