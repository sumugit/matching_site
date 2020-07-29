<?php
//ログイン状態
session_start();
session_regenerate_id(true);
//変数がセットされているか
if (isset($_SESSION['login']) == false) {
    print '<p id="login">アプリに';
    print '<b><a href="login.php">ログイン</a></b>';
    print '<br><p>';
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
    <title>マイページ</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/myPageStyle3.css" rel="stylesheet">
    <link href="css/style3.css" rel="stylesheet">
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
                <div id="pad"></div>
                <div class="container">
                    <div class="item"><a href="./profile.php"><p>プロフィール</p></br><img src="./siteimages/profile.png" width="110" height="110" alt="アイコン"></a></div>
                    <div class="item"><a href="./loginInfo.php"><p>登録情報</p><br><img src="./siteimages/user.jpg" width="120" height="120" alt="アイコン"></a></div>
                    <div class="item"><a href="./confirmFootPrint.php"><p>足あと</p><img src="./siteimages/trace.png" width="156" height="156" alt="アイコン"></a></div>
                    <div class="item"><a href="./confirmGood.php"><p>あなたへのいいね</p></br><img src="./siteimages/good.jpg" width="120" height="120" alt="アイコン"></a></div>
                    <div class="item"><a href="./confirmLove.php"><p>あなたへのタイプ</p></br><img src="./siteimages/heart.png" width="156" height="120" alt="アイコン"></a></div>
                    <div class="item"><a href="./confirmMyGood.php"><p>いいねした相手</p><img src="./siteimages/good.jpg" width="156" height="156" alt="アイコン"></a></div>
                    <div class="item"><a href="./confirmMyLove.php"><p>タイプした相手</p><img src="./siteimages/heart.png" width="156" height="120" alt="アイコン"></a></div>
                    <div class="item"><a href="./info.php"><p>お知らせ</p><img src="./siteimages/info.png" width="140" height="140" alt="アイコン"></a></div>
                    <div class="item"><a href="./news.php"><p>最新情報</p></br><img src="./siteimages/news.png" width="110" height="110" alt="アイコン"></a></div>
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