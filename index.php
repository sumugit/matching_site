<?php
//ログイン状態
session_start();
session_regenerate_id(true);
//変数がセットされているか
if (isset($_SESSION['login']) == false) {
    print 'ようこそ';
    print "ゲスト様-";
    print '<a href="login.html">ログイン</a><br>';
    print '<br>';
} else {
    print 'ようこそ';
    print $_SESSION['nickname'] . '様-';
    print '<a href="logout.php">ログアウト</a><br>';
    print '<br>';
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>【素敵な出会い】マッチングナビ！</title>
    <meta name="description" content="異性とのマッチングを促すサイトです。">

    <!--CSS-->
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="siteimages/favicon.png">
</head>

<body>
    <div id="home" class="big-bg">
        <header class="page-header wrapper">
            <h1><a href="index.php"><img class="logo" src="siteimages/0-14.png" alt="マッチングナビロゴ"></a></h1>
            <nav>
                <ul class="main-nav">
                    <li><a href="index.php">ホーム</a></li>
                    <li><a href="search.php">プロフ検索</a></li>
                    <li><a href="bulletinInfo.php">掲示板</a></li>
                    <li><a href="chatInfo.php">メッセージ</a></li>
                    <li><a href="myPage.php">マイページ</a></li>
                    <li><a href="contact.html">お問い合わせ</a></li>
                </ul>
            </nav>
        </header>

        <div class="home-content wrapper">
            <h2 class="page-title">素敵な出会いをここで</h2>
            <p>マッチングナビはあなたに相性の良い異性とのマッチングを促します。</p>
            <a class="button" href="login.html">ログイン</a><br>
            <a class="button" href="enroll.html">新規会員登録</a>
        </div><!-- /.home-content-->
    </div><!-- /#home -->
</body>
<footer>
    <p><small>&copy; マッチングナビ 2020 仮</small></p>
</footer>

</html>