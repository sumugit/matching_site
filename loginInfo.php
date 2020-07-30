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
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/style3.css" rel="stylesheet">
    <link href="css/table.css" rel="stylesheet">
    <link href="css/box.css" rel="stylesheet">
    <title>アカウント情報</title>
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
                if (is_file("./csv/users.csv")) { //登録ファイルが存在するか
                    if (is_readable("./csv/users.csv")) { //登録ファイルを読み込めるか
                        $fp = fopen("./csv/users.csv", "r");
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
                <br><br><br>
                <table>
                    <th colspan="2">アカウント情報</th>
                    <?php print "<tr><td>ニックネーム</td><td>" . $content[1] . "</td></tr>"; ?>
                    <?php print "<tr><td>本名</td><td>" . $content[5] . "</td></tr>"; ?>
                    <?php print "<tr><td>性別</td><td>" . $content[2] . "</td></tr>"; ?>
                    <?php print "<tr><td>メールアドレス</td><td>" . $content[3] . "</td></tr>"; ?>
                </table>
                <div class="containerbox"><a href="usersEdit.php" class="btn-push">編集</a></div>
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