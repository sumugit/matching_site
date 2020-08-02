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
    <title>掲示板</title>
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
                <br>
                <hr color="#0bd">
                <p>
                    <b id="head">スレッドを作成する</b>
                    <form method="POST" action="./createBulletin.php">
                        <div class="c">タイトル:<input type="text" class="hoge" name="title"><br></div>
                        <!-- idも渡す(createBulletinに$_SESSION['id]の情報がない) -->
                        <input type="hidden" name="id" value=<?php echo $_SESSION['id'] ?>>
                        <input type="hidden" name="nickname" value=<?php echo $_SESSION['nickname'] ?>>
                        <input type="submit" class="submit" value="作成">
                    </form>
                </p>
                <hr color="#0bd">
                <div class="container">
                    <?php
                    //掲示板があるかどうか
                    $flag = false;
                    //作成された掲示板の確認
                    if (is_file("./csv/bulletinLog.csv")) { //ファイルが存在するか
                        if (is_readable("./csv/bulletinLog.csv")) { //ファイルを読み込めるか
                            $fp1 = fopen("./csv/bulletinLog.csv", "r");
                            flock($fp1, LOCK_SH);
                            while (!feof($fp1)) {
                                $content = fgetcsv($fp1);
                                //作成された掲示板を一つずつ読み込む
                                if (is_file("./csv/profile.csv")) { //ファイルが存在するか
                                    if (is_readable("./csv/profile.csv")) { //ファイルを読み込めるか
                                        $fp2 = fopen("./csv/profile.csv", "r");
                                        flock($fp2, LOCK_SH);
                                        while (!feof($fp2)) {
                                            $profile = fgetcsv($fp2);
                                            //掲示板の作成者検索
                                            if ($content[1] == $profile[0] && !empty($content[1])) {
                                                $flag = true;
                                                //URLパラメータ生成
                                                print '<a href="bulletin.php?index=' . $content[0] . '"><div class="item"><img src = ' . $profile[1] . ' align="left" width="128" height="128" alt=""><p>　' . $content[2] . ' </p><p id="big">　' . $content[3] . ' </p><hr  style="border:1px dashed #000000;"><p>　' . $profile[3] . ' </p><p>　' . $profile[4] . ' ' . $profile[5] . ' </p></div></a>';
                                                print '<a href="./userPlofile.php?id=' . $profile[0] . '" class="btn btn--yellow btn--cubic">プロフィール確認</a>';
                                                break;
                                            }
                                        }
                                        flock($fp2, LOCK_UN);
                                        fclose($fp2);
                                    } else {
                                        echo "ファイルが開けません。";
                                        exit();
                                    }
                                } else {
                                    echo "ファイルがありません。";
                                }
                            }
                            flock($fp1, LOCK_UN);
                            fclose($fp1);
                            if ($flag == false) {
                                print "誰も掲示板を投稿していません。<br><br>";
                                print '<form>';
                                print '<input type="button" onclick="history.back()" value="戻る">';
                                print '</form>';
                            }
                        } else {
                            echo "ファイルが開けません。";
                            exit();
                        }
                    } else {
                        echo "ファイルがありません。";
                        exit();
                    }
                    ?>
                </div>
                <br>
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