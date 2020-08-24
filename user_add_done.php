<!DOCTYPE heml>
<html lang="ja">

<head>
    <meta http-equiv="content-type" charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="icon" type="image/png" href="siteimages/matchingNav.png">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/table.css" rel="stylesheet">
    <link href="css/posCenter.css" rel="stylesheet">
    <title>登録完了</title>
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
                        <?php
                        //配列の要素が定義されているか
                        if (!empty($_POST["name"]) && !empty($_POST["sex"]) && !empty($_POST["nickname"]) && !empty($_POST["email"]) && !empty($_POST["pass"])) {
                            //入力データの書き込み
                            $count = htmlspecialchars($_POST["count"]);
                            $name = htmlspecialchars($_POST["name"]);
                            $sex = htmlspecialchars($_POST["sex"]);
                            $nickname = htmlspecialchars($_POST["nickname"]);
                            $email = htmlspecialchars($_POST["email"]);
                            $pass = htmlspecialchars($_POST["pass"]);
                            try {
                                //登録ファイルへ書き込み
                                //r/w/a: 読み/書き/上書き
                                $fp = fopen("./csv/users.csv", "a+");
                                //ファイルの排他ロック
                                flock($fp, LOCK_EX);
                                //出力データ生成
                                $output = join(",", array($count, $nickname, $sex, $email, $pass, $name)) . "\n";
                                //ファイルに書き込み
                                fputs($fp, $output);
                                //ロック解除
                                flock($fp, LOCK_UN);
                                fclose($fp);
                                print '<p><a href="index.php" class="btn-flat-simpleBack">ホームへ戻る</a>';
                                print '<a href="login.php" class="btn-flat-simple">ログインする</a></p>';
                                print '<br>';
                                print '<div class="text-center">登録が完了しました！</div><br>';

                                //プロフィールファイルへの書き込み
                                //r/w/a: 読み/書き/上書き
                                $fp = fopen("./csv/profile.csv", "a+");
                                //ファイルの排他ロック
                                flock($fp, LOCK_EX);
                                //出力データ生成
                                //登録ユーザーが男性なら
                                if ($sex == "男性")
                                    $output = join(",", array($count, "./image/unknown.jpg", "よろしくお願いします。", $nickname, "20代前半", "東京都", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない")) . "\n";
                                //登録ユーザーが女性なら
                                else $output = join(",", array($count, "./image/unknown_w.png", "よろしくお願いします。", $nickname, "20代前半", "東京都", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない")) . "\n";
                                //ファイルに書き込み
                                fputs($fp, $output);
                                //ロック解除
                                flock($fp, LOCK_UN);
                                fclose($fp);
                            } catch (Exception $e) {
                                header("Location: fileError.php");
                                exit();
                            }
                        } else {
                            print '<p><a href="enrollInfo.php" class="btn-flat-BackAll">新規会員登録する</a></p>';
                            print '<br>';
                            print '<div class="text-center">登録が完了していません。</div>';
                        }
                        ?>
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