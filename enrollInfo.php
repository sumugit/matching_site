<?php
//ログイン状態
session_start();
session_regenerate_id(true);
//変数がセットされているか
if (isset($_SESSION['login']) == false) {
    print '<p id="login">新規会員登録';
    print '<br><p>';
} else {
    print '<p id ="login">';
    print $_SESSION['nickname'] . '様-';
    print '<a href="logout.php"><b>ログアウト</b></a>';
    print '<br><p>';
}
?>


<!DOCTYPE heml>
<html lang="ja">

<head>
    <meta http-equiv="content-type" charset="utf-8">
    <!--CSS-->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="css/style3.css" rel="stylesheet">
    <link href="css/input.css" rel="stylesheet">
    <title>会員登録</title>
</head>

<body>
    <div id="contenar">
        <div id="field">
            <div id="home" class="top-image-area">
                <a href="index.php"><img class="logo" src="siteimages/header.png" alt="マッチングナビロゴ"></a>
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
                <div class="form-wrapper">
                    <h1>新規会員登録</h1>
                    <form method="POST" action="./enroll.php" enctype=multipart/form-data> <br>
                        <div class="form-item">
                            <input type="text" name="name" placeholder="氏名" required><br>
                        </div>
                        性別<br>
                        <input type="radio" name="sex" value="男性" required>男性
                        <input type="radio" name="sex" value="女性">女性<br>
                        <div class="form-item">
                            <input type="text" name="nickname" placeholder="ニックネーム" required><br>
                        </div>
                        <div class="form-item">
                            <input type="email" name="email" placeholder="メールアドレス" required><br>
                        </div>
                        <div class="form-item">
                            <input type="password" name="pass1" pattern="[0-9a-zA-Z]+$" placeholder="パスワード" required><br>
                        </div>
                        <div class="form-item">
                            <input type="password" name="pass2" placeholder="確認用" required><br>
                        </div>
                        <div class="button-panel">
                            <input type="submit" class="submitButton" value="登録確認">
                        </div>
                        <div class="form-footer"></div>
                    </form>
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