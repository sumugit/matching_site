<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>【素敵な出会い】マッチングナビ！</title>
    <meta name="description" content="異性とのマッチングを促すサイトです。">

    <!--CSS-->
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="siteimages/matchingNav.png">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="css/style.css" rel="stylesheet">
</head>

<body background="siteimages/b094.jpg">
    <div class="left-column">
        <p class="icon"><img class="logo" src="siteimages/matchingNav.png" alt="マッチングナビロゴ"></p>
        <!--左サイドバー-->
        <ul class="sideBar">
            <li><a href="index.php">ホーム</a></li>
            <li><a href="serach.php">プロフ検索</a></li>
            <li><a href="chatInfo.php">メッセージ</a></li>
            <li><a href="profile.php">プロフィール</a></li>
            <li><a href="loginInfo.php">登録情報</a></li>
            <li><a href="confirmFootPrint.php">足跡</a></li>
            <li><a href="confirmGood.php">あなたへのいいね</a></li>
            <li><a href="confirmLove.php">あなたへのタイプ</a></li>
            <li><a href="confirmMyGood.php">いいねした相手</a></li>
            <li><a href="confirmMyLove.php">タイプした相手</a></li>
            <li><a href="info.php">お知らせ</a></li>
            <li><a href="news.php">最新情報</a></li>
            <li><a href="contact.php">お問い合わせ</a></li>
        </ul>
    </div>
    <div class="wrapper">
        <div class="right-column">
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
            <header>
                <!--<p>マッチングナビはあなたに相性の良い異性とのマッチングを促します。</p>-->
                <div class="top-header">
                    <nav>
                        <ul>
                            <li><a href="about.php" class="btn4">マッチングナビとは</a></li>
                            <li><a href="payment.php" class="btn4">ご利用料金</a></li>
                            <li><a href="howToPay.php" class="btn4">お支払い方法</a></li>
                            <li><a href="back.php" class="btn4">料金の払い戻し</a></li>
                            <li><a href="firm.php" class="btn4">会社情報</a></li>
                            <li><a href="contact.php" class="btn4">お問い合わせ</a></li>
                        </ul>
                    </nav>
                </div>
            </header>
            <div id="contenar">
                <div id="field">
                    <div id="home" class="top-image-area">
                        <a href="index.php"><img class="logo" src="siteimages/header.png" height="130" alt="マッチングナビロゴ"></a>
                        <div class="page-header">
                            <nav>
                                <ul class="main-nav">
                                    <li><a href="index.php" class="btn4"><i class="fas fa-home"></i>ホーム</a></li>
                                    <li><a href="search.php" class="btn4"><i class="fas fa-search"></i>プロフ検索</a></li>
                                    <li><a href="bulletinInfo.php" class="btn4"><i class="fas fa-clipboard"></i>掲示板</a></li>
                                    <li><a href="chatInfo.php" class="btn4"><i class="fas fa-comment-dots"></i>メッセージ</a></li>
                                    <li><a href="myPage.php" class="btn4"><i class="fas fa-address-card"></i>マイページ</a></li>
                                    <li><a href="contact.php" class="btn4"><i class="fas fa-phone"></i>お問い合わせ</a></li>
                                </ul>
                            </nav>
                        </div>
                        <br><br><br>
                        <a href="./enrollInfo.php" class="btn btn-c btn--blue btn--cubic">新規会員登録</a>
                        <a href="./login.php" class="btn2 btn-c btn--blue btn--cubic">　ログイン　</a>
                        <br><br><br>
                        <h2 class="page-title">素敵な出会いを、ここで</h2>
                        <p class="sentence">マッチングナビはあなたの異性との出会いを促します</p>
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
                                    <img src="siteimages/1.jpg"><img src="siteimages/1.png">
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
                        </div><!-- /.home-content-->
                    </div><!-- /#home -->
                    <br><br><br>
                </div>
            </div>
            <div class="footer-wrapper">
                <footer>
                    <div class="foot-wrap">
                        <div class="menu-left">
                            <h3>マッチングナビについて</h3>
                            <ul class="foot-left">
                                <li><a href="about.php">マッチングナビとは</a></li>
                                <li><a href="service.php">サービス</a></li>
                                <li><a href="rule.php">会員規約</a></li>
                            </ul>
                        </div>
                        <div class="menu-center">
                            <h3>決済</h3>
                            <ul class="foot-center">
                                <li><a href="payment.php">ご利用料金</a></li>
                                <li><a href="howToPay.php">お支払い方法</a></li>
                                <li><a href="back.php">料金の払い戻し</a></li>
                            </ul>
                        </div>
                        <div class="menu-right">
                            <h3>個人情報の取り扱い</h3>
                            <ul class="foot-right">
                                <li><a href="policy.php">プライバシーポリシー</a></li>
                                <li><a href="firm.php">特定商取引法に基づく表記</a></li>
                                <li><a href="contact.php">お問い合わせ</a></li>
                            </ul>
                        </div>
                        <small class="cmark">©️copyright マッチングナビ 2020
                        </small>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</body>

</html>