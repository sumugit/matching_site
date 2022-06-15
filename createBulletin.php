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
    $line = $count . "," . $mine . "," . $time . "," . $title . "," . 1 . "," . "<p>1: <strong>名前 : " . $nickname . "</strong><br>投稿日時 : <time>" . $time . "</time><br>" . $nickname . "さんがスレッドを建てました。</p><hr color='#0bd'>" . "\n";
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
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="css/linestyle.css" rel="stylesheet">
    <link href="css/style3.css" rel="stylesheet">
    <link href="css/bulletinButton.css" rel="stylesheet">
    <title>スレッド作成</title>
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
                <h1>スレッドを立ち上げました。</h1>
                <?php
                if (!empty($title) && !empty($time)) {
                    //ログファイルの中身を出力
                    echo "<p><b>タイトル:" . $title . "</b><br>作成日時:<time>" . $time . "</time></p>";
                }
                ?>
                <p>
                    <?php echo '<a href="./bulletin.php?index=' . $count . '" target="_self">' . $title . 'のスレッドに行く</a><br>'; ?>
                    <a href="./bulletinInfo.php" target="_self">掲示板に戻る</a><br>
                </p>
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