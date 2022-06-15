<?php
//配列の要素が定義されているか
if (!empty($_POST["title"])) {
    //自分のid
    $mine = htmlspecialchars($_POST["id"]);
    //自分のニックネーム
    $nickname = htmlspecialchars($_POST["nickname"]);
    //入力データの書き込み
    if (strlen($_POST["title"]) != 0) {
        $title = htmlspecialchars($_POST["title"]);
        $title = preg_replace("/,/", " ", $title);
    } else
        $title = "名無しスレッド";
    date_default_timezone_get('Asia/Tokyo');
    //年/月/日/時:分:秒の形式で時間を取得
    $time = date("Y/m/j H:i:s");
    //r/w/a: 読み/書き/上書き
    $fp = fopen("./csv/bulletinLog.csv", "a+");
    //ファイルの排他ロック
    flock($fp, LOCK_EX);
    //連番用(掲示板は同じidの人が別々のスレッドを立ち上げることができるため,これがユニークなidとなる)
    $count = 0;
    while (!feof($fp)) {
        $content = fgetcsv($fp);
        $count++;
    }
    $line = $count . "," . $mine . "," . $time . "," . $title . "," . 1 . "," . "<div class='left-margin'><p>1: <strong>名前 : " . $nickname . "</strong><br>投稿日時 : <time>" . $time . "</time><br>" . $nickname . "さんがスレッドを建てました。</p></div><hr color='#0bd'>" . "\n";
    //ファイルへ書き込み
    fputs($fp, $line);
    //ロック解除
    flock($fp, LOCK_UN);
    fclose($fp);
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
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
    <title>スレッド作成</title>
</head>

<body background="siteimages/b094.jpg">
    <div class="left-column">
        <p class="icon"><img class="logo" src="siteimages/matchingNav.png" alt="マッチングナビロゴ"></p>
        <!--左サイドバー-->
        <ul class="sideBar">
            <li><a href="index.php">ホーム</a></li>
            <li><a href="search.php">プロフ検索</a></li>
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
                        <?php
                        print '<p><a href="./bulletinInfo.php" class="btn-flat-simpleBack"><i class="fa fa-chevron-left"></i>戻る</a>';
                        print '<a href="./bulletin.php?index=' . $count . '" target="_self" class="btn-flat-simple">スレッドに行く</a></p><br>';
                        ?>
                        </br>
                        <h1>スレッドを立ち上げました。</h1>
                        <?php
                        if (!empty($title) && !empty($time)) {
                            //ログファイルの中身を出力
                            echo "<p><b>タイトル:" . $title . "</b><br>作成日時:<time>" . $time . "</time></p>";
                        }
                        ?>
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