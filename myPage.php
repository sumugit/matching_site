<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>マイページ</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="icon" type="image/png" href="siteimages/matchingNav.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/myPageStyle3.css" rel="stylesheet">
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
            <li><a href="constant.php">お問い合わせ</a></li>
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
                        <div id="pad"></div>
                        <div class="container">
                            <a href="./profile.php">
                                <div class="item">
                                    <p>プロフィール</p></br><img src="./siteimages/profile.png" width="110" height="110" alt="アイコン">
                                </div>
                            </a>
                            <a href="./loginInfo.php">
                                <div class="item">
                                    <p>登録情報</p><br><img src="./siteimages/user.jpg" width="120" height="120" alt="アイコン">
                                </div>
                            </a>
                            <a href="./confirmFootPrint.php">
                                <div class="item">
                                    <p>足あと</p><img src="./siteimages/trace.png" width="156" height="156" alt="アイコン">
                                </div>
                            </a>
                            <a href="./confirmGood.php">
                                <div class="item">
                                    <p>あなたへのいいね</p></br><img src="./siteimages/good.jpg" width="120" height="120" alt="アイコン">
                                </div>
                            </a>
                            <a href="./confirmLove.php">
                                <div class="item">
                                    <p>あなたへのタイプ</p></br><img src="./siteimages/heart.png" width="156" height="120" alt="アイコン">
                                </div>
                            </a>
                            <a href="./confirmMyGood.php">
                                <div class="item">
                                    <p>いいねした相手</p></br><img src="./siteimages/putGood.jpg" width="156" height="120" alt="アイコン">
                                </div>
                            </a>
                            <a href="./confirmMyLove.php">
                                <div class="item">
                                    <p>タイプした相手</p></br><img src="./siteimages/putLove.jpg" width="156" height="120" alt="アイコン">
                                </div>
                            </a>
                            <a href="./info.php">
                                <div class="item">
                                    <p>お知らせ</p></br><img src="./siteimages/info.png" width="130" height="130" alt="アイコン">
                                </div>
                            </a>
                            <a href="./news.php">
                                <div class="item">
                                    <p>最新情報</p></br></br><img src="./siteimages/news.png" width="100" height="100" alt="アイコン">
                                </div>
                            </a>
                        </div>
                    </div>
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
                                <li><a href="payment">ご利用料金</a></li>
                                <li><a href="howToPay">お支払い方法</a></li>
                                <li><a href="back.php">料金の払い戻し</a></li>
                            </ul>
                        </div>
                        <div class="menu-right">
                            <h3>個人情報の取り扱い</h3>
                            <ul class="foot-right">
                                <li><a href="policy.php">プライバシーポリシー</a></li>
                                <li><a href="law.php">特定商取引法に基づく表記</a></li>
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