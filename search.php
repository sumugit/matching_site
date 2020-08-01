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
    <link href="css/style3.css" rel="stylesheet">
    <link href="css/gridstyle.css" rel="stylesheet">
    <link href="css/buttonSearch.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <title>プロフ検索</title>
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
                </br>
                <a href="./detail.php" class="btn btn--green btn--radius btn--cubic"><i class="fas fa-angle-double-right fa-position-left"></i>条件を指定する<i class="fas fa-angle-double-left fa-position-right"></i></a>
                <div class="wrapper grid">
                    <?php
                    //他の異性ユーザーの顔写真を一つずつ載せる
                    if (is_file("./csv/profile.csv") && is_file("./csv/users.csv")) { //登録ファイルが存在するか
                        if (is_readable("./csv/profile.csv") && is_readable("./csv/users.csv")) { //登録ファイルを読み込めるか
                            $fp1 = fopen("./csv/profile.csv", "r"); //プロフ情報
                            $fp2 = fopen("./csv/users.csv", "r"); //ユーザー情報
                            flock($fp1, LOCK_SH);
                            flock($fp2, LOCK_SH);
                            //サイズが一緒であるはず
                            if (count($fp1) == count($fp2)) {
                                //一旦データを全て配列に収める
                                //登録ユーザーを取り出す.
                                while (!feof($fp2)) {
                                    $user = fgetcsv($fp2);
                                    $content = fgetcsv($fp1);
                                    //同性のユーザーは無視
                                    if (strcmp($user[2], $_SESSION['sex']) != 0 && $user[2] != "") {
                                        //URLパラメータ生成
                                        print '<a href="userPlofile.php?id=' . $content[0] . '"><div class="item"><img src = ' . $content[1] . ' width="128" height="128" alt=""><p><b>' . $content[5] . '　' . $content[4] . '</b></p><p>' . $content[2] . '</p></div></a>';
                                    }
                                }
                            }
                            //登録ファイルを閉じる
                            flock($fp2, LOCK_UN);
                            flock($fp1, LOCK_UN);
                            fclose($fp2);
                            fclose($fp1);
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