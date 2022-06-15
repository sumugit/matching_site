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
    print '<p id ="login">ようこそ';
    print $_SESSION['nickname'] . '様-';
    print '<a href="logout.php"><b>ログアウト</b></a>';
    print '<br><p>';
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>【素敵な出会い】マッチングナビ！</title>
    <meta name="description" content="異性とのマッチングを促すサイトです。">

    <!--CSS-->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
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
                <br><br><br>
                <a href="./enrollInfo.php" class="btn btn-c btn--green btn--cubic">新規会員登録</a>
                <a href="./login.php" class="btn2 btn-c btn--green btn--cubic">　ログイン　</a>
                <!-- 画面上部の帯 -->
                <div id="top_belt"></div>
                <!-- スライド表示枠 -->
                <div id="stage">
                    <!-- スライド切換えボタン用ラジオボタン -->
                    <input type="radio" id="r1" name="gal">
                    <input type="radio" id="r2" name="gal">
                    <input type="radio" id="r3" name="gal">
                    <!-- 送りボタン用ラジオボタン -->
                    <input type="radio" id="back1" name="gal"><input type="radio" id="next1" name="gal">
                    <input type="radio" id="back2" name="gal"><input type="radio" id="next2" name="gal">
                    <input type="radio" id="back3" name="gal"><input type="radio" id="next3" name="gal">
                    <!-- 現スライド標示ボタンのラジオボタンとの関連付け -->
                    <label for="r1" id="lb1" class="circ"><img src="siteimages/2.png"></label>
                    <label for="r2" id="lb2" class="circ"><img src="siteimages/2.png"></label>
                    <label for="r3" id="lb3" class="circ"><img src="siteimages/2.png"></label>
                    <!-- スライド群 -->
                    <div id="photos">
                        <!-- スライド1 -->
                        <div id="photo1" class="pic">
                            <!-- スライド写真と現スライド標示ボタン -->
                            <img src="siteimages/1.jpeg"><img src="siteimages/1.png">
                            <!-- 送りボタンの表示とラジオボタンとの関連付け -->
                            <label for="back1"><span class="pb">＜</span></label>
                            <label for="next1"><span class="nb">＞</span></label>
                        </div>
                        <div id="photo2" class="pic">
                            <img src="siteimages/2.jpg"><img src="siteimages/1.png">
                            <label for="back2"><span class="pb">＜</span></label>
                            <label for="next2"><span class="nb">＞</span></label>
                        </div>
                        <div id="photo3" class="pic">
                            <img src="siteimages/3.jpg"><img src="siteimages/1.png">
                            <label for="back3"><span class="pb">＜</span></label>
                            <label for="next3"><span class="nb">＞</span></label>
                        </div>
                    </div>
                    <!-- stageの高さの確保 -->
                    <div style="padding:28%;"></div>
                </div>

                <div class="home-content wrapper">
                    <!--<h2 class="page-title">素敵な出会いをここで</h2>
            <p>マッチングナビはあなたに相性の良い異性とのマッチングを促します。</p>-->
                </div><!-- /.home-content-->
            </div><!-- /#home -->
        </div>
    </div>
</body>
<div class="footer-wrapper">
    <footer>
        <p><small>&copy; マッチングナビ 2020</small></p>
    </footer>
</div>

</html>