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
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/style3.css" rel="stylesheet">
    <link href="css/table.css" rel="stylesheet">
    <title>プロフィール</title>
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
                if (is_file("./csv/profile.csv")) { //登録ファイルが存在するか
                    if (is_readable("./csv/profile.csv")) { //登録ファイルを読み込めるか
                        $fp = fopen("./csv/profile.csv", "r");
                        flock($fp, LOCK_SH);
                        //idが登録ユーザーと一致するまで一行ずつ取り出す
                        while (!feof($fp)) {
                            $content = fgetcsv($fp);
                            //ログインしているユーザーの情報を取得
                            if ($content[0] == $_SESSION['id']) {
                                break;
                            }
                        }
                        //登録ファイルを閉じる
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
                <!--画像の挿入-->
                <?php
                print '<br>';
                print '<a href="profEdit.php" class="btn btn-c btn--green btn--cubic">編集</a><br>';
                print '<br>';
                ?>
                <table>
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