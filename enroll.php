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
    <link href="css/box.css" rel="stylesheet">
    <link href="css/table.css" rel="stylesheet">
    <link href="css/posCenter.css" rel="stylesheet">
    <title>登録確認</title>
</head>


<body background="siteimages/b094.jpg">
    <div class="left-column">
        <p class="icon"><img class="logo" src="siteimages/matchingNav.png" alt="マッチングナビロゴ"></p>
        <!--左サイドバー-->
        <ul class="sideBar">
            <li><a href="index.php">ホーム</a></li>
            <li><a href="search.php">プロフ検索</a></li>
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
                print '<p id="login">新規会員登録';
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
                        <p><a href="javascript:history.back();" class="btn-flat-BackAll"><i class="fa fa-chevron-left"></i>戻る</a></p>
                        <br>
                        <?php
                        //配列の要素が定義されているか
                        if (!empty($_POST["name"]) && !empty($_POST["sex"]) && !empty($_POST["nickname"]) && !empty($_POST["email"]) && !empty($_POST["pass1"]) && !empty($_POST["pass2"])) {
                            //入力データの書き込み
                            if (strlen($_POST["name"]) != 0) {
                                $name = htmlspecialchars($_POST["name"]);
                                //,は半角空白にする
                                $name = preg_replace("/,/", " ", $name);
                                $sex = htmlspecialchars($_POST["sex"]);
                                $nickname = htmlspecialchars($_POST["nickname"]);
                                //,は半角空白にする
                                $nickname = preg_replace("/,/", " ", $nickname);
                                $email = htmlspecialchars($_POST["email"]);
                                //,は半角空白にする
                                $email = preg_replace("/,/", " ", $email);
                                $pass1 = htmlspecialchars($_POST["pass1"]);
                                $pass2 = htmlspecialchars($_POST["pass2"]);
                                //ユーザーにユニークなidを割り振る
                                if (is_file("./csv/users.csv")) { //登録ファイルが存在するか
                                    if (is_readable("./csv/users.csv")) { //登録ファイルを読み込めるか
                                        $fp = fopen("./csv/users.csv", "r");
                                        flock($fp, LOCK_SH);
                                        $count = 0;
                                        //users.csvの中身を一行ずつカウント
                                        while (!feof($fp)) {
                                            $content = fgetcsv($fp);
                                            $count++;
                                        }
                                        //登録ファイルを閉じる
                                        flock($fp, LOCK_UN);
                                        fclose($fp);
                                    } else {
                                        header("Location: fileError.php");
                                        exit();
                                    }
                                } else {
                                    header("Location: fileError.php");
                                    exit();
                                }
                                //パスワードが一致しないときの処理
                                if ($pass1 != $pass2) {
                                    print '<div class="text-center">パスワードが一致しません。</div><br>';
                                } else {
                                    //登録確認画面へ
                                    $pass = md5($pass1);
                                    echo '<div class="box30">';
                                    echo '<div class="box-title">内容登録確認</div>';
                                    //入力内容の確認
                                    echo "<p><b>名前:" . $name . "</b>";
                                    echo "<p><b>性別:" . $sex . "</b>";
                                    echo "<p><b>ニックネーム:" . $nickname . "</b>";
                                    echo "<p><b>メールアドレス:" . $email . "</b>";
                                    //変数の維持
                                    print '<form method="post" action="user_add_done.php">';
                                    print '<input type="hidden" name="count" value=' . $count . '>';
                                    print '<input type="hidden" name="name" value=' . $name . '>';
                                    print '<input type="hidden" name="sex" value=' . $sex . '>';
                                    print '<input type="hidden" name="nickname" value=' . $nickname . '>';
                                    print '<input type="hidden" name="email" value=' . $email . '>';
                                    print '<input type="hidden" name="pass" value=' . $pass . '>';
                                    print '<br>';
                                    print '</div>';
                                    print '</div>';
                                    print '<br>';
                                    print '<div class="button"><input type="submit" value="完了！"></div>';
                                    print '</form>';
                                }
                            }
                        } else {
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