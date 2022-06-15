<?php
//ログイン状態
session_start();
session_regenerate_id(true);
//変数がセットされているか
if (isset($_SESSION['login']) == false) {
    print '<p id="login">アプリに';
    print '<b><a href="login.php">ログイン</a></b>';
    print '<br><p>';
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
                    <a href="./profile.php"><div class="item"><p>プロフィール</p></br><img src="./siteimages/profile.png" width="110" height="110" alt="アイコン"></div></a>
                    <a href="./loginInfo.php"><div class="item"><p>登録情報</p><br><img src="./siteimages/user.jpg" width="120" height="120" alt="アイコン"></div></a>
                    <a href="./confirmFootPrint.php"><div class="item"><p>足あと</p><img src="./siteimages/trace.png" width="156" height="156" alt="アイコン"></div></a>
                    <a href="./confirmGood.php"><div class="item"><p>あなたへのいいね</p></br><img src="./siteimages/good.jpg" width="120" height="120" alt="アイコン"></div></a>
                    <a href="./confirmLove.php"><div class="item"><p>あなたへのタイプ</p></br><img src="./siteimages/heart.png" width="156" height="120" alt="アイコン"></div></a>
                    <a href="./confirmMyGood.php"><div class="item"><p>いいねした相手</p></br><img src="./siteimages/putGood.jpg" width="156" height="120" alt="アイコン"></div></a>
                    <a href="./confirmMyLove.php"><div class="item"><p>タイプした相手</p></br><img src="./siteimages/putLove.jpg" width="156" height="120" alt="アイコン"></div></a>
                    <a href="./info.php"><div class="item"><p>お知らせ</p></br><img src="./siteimages/info.png" width="130" height="130" alt="アイコン"></div></a>
                    <a href="./news.php"><div class="item"><p>最新情報</p></br></br><img src="./siteimages/news.png" width="100" height="100" alt="アイコン"></div></a>
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