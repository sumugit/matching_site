<?php
//ログイン状態
session_start();
session_regenerate_id(true);
//変数がセットされているか
if (isset($_SESSION['login']) == false) {
    print 'ログインされていません。<br>';
    print '<a href="login.html">ログイン画面へ</a><br>';
    print '<br>';
    exit();
} else {
    print 'ようこそ';
    print $_SESSION['nickname'] . '様-';
    print '<a href="logout.php">ログアウト</a><br>';
    print '<br>';
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>マイページ</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/myPageStyle.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="item"><a href="./profile.php">プロフィール</a></div>
        <div class="item">お知らせ</div>
        <div class="item">最新情報</div>
        <div class="item"><a href="./confirmFootPrint.php">足あと</a></div>
        <div class="item"><a href="./confirmGood.php">いいね</a></div>
        <div class="item"><a href="./confirmLove.php">タイプ</a></div>
        <div class="item"><a href="./confirmMyGood.php">いいねした相手</a></div>
        <div class="item"><a href="./confirmMyLove.php">タイプした相手</a></div>
        <div class="item"><a href="./loginInfo.php">登録情報</a></div>
    </div>
</body>
<footer>
    <p><small>&copy; マッチングナビ 2020 仮</small></p>
</footer>

</html>