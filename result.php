<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="siteimages/matchingNav.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/gridstyle.css" rel="stylesheet">
    <link href="css/buttonSearch.css" rel="stylesheet">
    <link href="css/table.css" rel="stylesheet">
    <link href="css/posCenter.css" rel="stylesheet">
    <title>検索結果</title>
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
                header("Location: loginMove.php");
                exit();
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
                        </br>
                        <div class="wrapper grid">
                            <?php
                            //配列の要素が定義されているか
                            if (!empty($_POST["pref_name_live"]) && !empty($_POST["old"])) {
                                $old = htmlspecialchars($_POST["old"]);
                                $pref_name_live = htmlspecialchars($_POST["pref_name_live"]);
                                $pref_name_from = htmlspecialchars($_POST["pref_name_from"]);
                                $sign = htmlspecialchars($_POST["sign"]);
                                $height = htmlspecialchars($_POST["height"]);
                                $style = htmlspecialchars($_POST["style"]);
                                $job = htmlspecialchars($_POST["job"]);
                                $income = htmlspecialchars($_POST["income"]);
                                $marriage = htmlspecialchars($_POST["marriage"]);
                                $child = htmlspecialchars($_POST["child"]);
                                $cigarette = htmlspecialchars($_POST["cigarette"]);
                                $alcohol = htmlspecialchars($_POST["alcohol"]);
                                $car = htmlspecialchars($_POST["car"]);
                                $people = htmlspecialchars($_POST["people"]);
                                $brother = htmlspecialchars($_POST["brother"]);
                                $meet = htmlspecialchars($_POST["meet"]);
                                $cost = htmlspecialchars($_POST["cost"]);
                                //配列にした方が後で処理で楽
                                $array = array($old, $pref_name_live, $pref_name_from, $sign, $height, $style, $job, $income, $marriage, $child, $cigarette, $alcohol, $car, $people, $brother, $meet, $cost);
                                //他の異性ユーザーの顔写真を一つずつ載せる
                                $count = 0;
                                if (is_file("./csv/profile.csv") && is_file("./csv/users.csv")) { //登録ファイルが存在するか
                                    if (is_readable("./csv/profile.csv") && is_readable("./csv/users.csv")) { //登録ファイルを読み込めるか
                                        $fp1 = fopen("./csv/profile.csv", "r"); //プロフ情報
                                        $fp2 = fopen("./csv/users.csv", "r"); //ユーザー情報
                                        flock($fp1, LOCK_SH);
                                        flock($fp2, LOCK_SH);
                                        //サイズが一緒であるはず
                                        if (count($fp1) == count($fp2)) {
                                            while (!feof($fp1)) {
                                                $content = fgetcsv($fp1);
                                                $user = fgetcsv($fp2);
                                                if (strcmp($user[2], $_SESSION['sex']) == 0) continue;
                                                for ($i = 0; $i < 17; $i++) {
                                                    //条件指定をしている項目について
                                                    if (strcmp($array[$i], "指定しない") == 0) continue;
                                                    //条件指定をした項目のAND演算
                                                    else if (strcmp($array[$i], $content[$i + 4]) != 0) {
                                                        break;
                                                    }
                                                }
                                                //一致するユーザーを表示
                                                if ($i == 17) {
                                                    //URLパラメータ生成
                                                    print '<a href="userProfileSearch.php?id=' . $content[0] . '"><div class="item"><img src = ' . $content[1] . ' width="128" height="128" class="userImage" alt=""><p><b>' . $content[5] . '　' . $content[4] . '</b></p><p class="textOverflowTest3">' . $content[2] . '</p></div></a>';
                                                    $count++;
                                                }
                                            }
                                        }
                                        //登録ファイルを閉じる
                                        flock($fp2, LOCK_UN);
                                        flock($fp1, LOCK_UN);
                                        fclose($fp2);
                                        fclose($fp1);
                                    } else {
                                        header("Location: fileError.php");
                                        exit();
                                    }
                                } else {
                                    header("Location: fileError.php");
                                    exit();
                                }
                            }
                            ?>
                        </div>
                        <?php if ($count == 0) print '<p class="text-center">条件に一致するユーザーはいませんでした。</p>'; ?>
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