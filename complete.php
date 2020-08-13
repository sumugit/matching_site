<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="icon" type="image/png" href="siteimages/matchingNav.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/box.css" rel="stylesheet">
    <link href="css/posCenter.css" rel="stylesheet">
    <link href="css/table.css" rel="stylesheet">
    <title>プロフィール編集完了</title>
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
                        <?php
                        //配列の要素が定義されているか
                        if (!empty($_POST["nickname"]) && !empty($_POST["old"])) {
                            //画像ファイルの情報
                            $tempfile = $_FILES['myImage']['tmp_name'];
                            $filename = './image/' . $_FILES['myImage']['name'];

                            //画像ファイルが本当にアップロードされたか
                            if (is_uploaded_file($tempfile)) {
                                if (move_uploaded_file($tempfile, $filename)) {
                                    //echo "<div class='text-center'>" . $filename . "をアップロードしました。</div>";
                                } else {
                                    //echo "<div class='text-center'>ファイルをアップロードできません。</div>";
                                }
                            } else {
                                //男性か女性かで分けるようにしたい
                                $filename = './image/unknown.jpg';
                                //echo "<div class='text-center'>ファイルが選択されていません。</div>";
                            }

                            //入力データの書き込み
                            if (strlen($_POST["nickname"]) != 0) {
                                $myimage = htmlspecialchars($filename);
                                //画像名に,があれば_に変える(これだと画像を参照できない)
                                $myimage = preg_replace("/,/", "_", $myimage);
                                $message = htmlspecialchars($_POST["message"]);
                                //,は半角空白にする
                                $message = preg_replace("/,/", "、", $message);
                                //正規表現で改行コードを置換(複数行入力できるようにする)
                                $message = preg_replace("/\r|\n|\r\n/", "<br>", $message);
                                $nickname = htmlspecialchars($_POST["nickname"]);
                                //,は半角空白にする
                                $nickname = preg_replace("/,/", " ", $nickname);
                                $old = htmlspecialchars($_POST["old"]);
                                $pref_name_live = htmlspecialchars($_POST["pref_name_live"]);
                                $pref_name_from = htmlspecialchars($_POST["pref_name_from"]);
                                $bloodtype = htmlspecialchars($_POST["bloodtype"]);
                                $sign = htmlspecialchars($_POST["sign"]);
                                $height = htmlspecialchars($_POST["height"]);
                                $style = htmlspecialchars($_POST["style"]);
                                $looks = htmlspecialchars($_POST["looks"]);
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

                                //プロフファイルへ書き込み
                                //r/w/a: 読み/書き/上書き
                                $fp = fopen("./csv/profile.csv", "a+");
                                //ファイルの排他ロック
                                flock($fp, LOCK_EX);
                                //出力データ生成
                                $output = join(",", array($_SESSION['id'], $myimage, $message, $nickname, $old, $pref_name_live, $pref_name_from, $bloodtype, $sign, $height, $style, $looks, $job, $income, $marriage, $child, $cigarette, $alcohol, $car, $people, $brother, $meet, $cost)) . "\n";

                                //プロフィールファイルの一部を書き換えるため,
                                //一旦csvの中身を全て配列に保存し, ファイルの中を空にする
                                $array = array();
                                while (!feof($fp)) {
                                    array_push($array, fgets($fp));
                                }
                                ftruncate($fp, 0);
                                //配列の先頭から格納
                                for ($i = 0; $i < count($array); $i++) {
                                    //編集した情報を更新(ユニークなidが一致すればよい)
                                    if ($array[$i][0] == $_SESSION['id']) {
                                        $array[$i] = $output;
                                    }
                                    //ファイルに書き込み
                                    fputs($fp, $array[$i]);
                                }
                                //ロック解除
                                flock($fp, LOCK_UN);
                                fclose($fp);
                                $_SESSION['nickname'] = $nickname;

                                //ユーザーファイルへ書き込み
                                //r/w/a: 読み/書き/上書き
                                $fp = fopen("./csv/users.csv", "a+");
                                //ファイルの排他ロック
                                flock($fp, LOCK_EX);
                                //出力データ生成
                                $output = join(",", array($_SESSION['id'], $nickname, $_SESSION['sex'], $_SESSION['email'], $_SESSION['pass'], $_SESSION['name'])) . "\n";
                                //プロフィールファイルの一部を書き換えるため,
                                //一旦csvの中身を全て配列に保存し, ファイルの中を空にする
                                $array = array();
                                while (!feof($fp)) {
                                    array_push($array, fgets($fp));
                                }
                                ftruncate($fp, 0);
                                //配列の先頭から格納
                                for ($i = 0; $i < count($array); $i++) {
                                    //編集した情報を更新(ユニークなidが一致すればよい)
                                    if ($array[$i][0] == $_SESSION['id']) {
                                        $array[$i] = $output;
                                    }
                                    //ファイルに書き込み
                                    fputs($fp, $array[$i]);
                                }
                                //ロック解除
                                flock($fp, LOCK_UN);
                                fclose($fp);
                            }
                        }
                        ?>
                        <?php if (!empty($_POST["nickname"]) && strlen($_POST["nickname"]) != 0 && !empty($nickname) && !empty($_POST["old"])) : ?>
                            <?php print '<p><a href="./profEdit.php" class="btn-flat-simpleBack"><i class="fa fa-chevron-left"></i>編集に戻る</a>';
                                print '<a href="./profile.php" class="btn-flat-simple">プロフィール確認</a></p>'; ?>
                            <br>
                            <div class="box30">
                                <div class="box-title">プロフィール編集完了！</div>
                                <p>
                                    画像: <?php echo $myimage ?><br>
                                    自己紹介: <?php echo $message ?><br>
                                    ニックネーム: <?php echo $nickname ?><br>
                                    年齢: <?php echo $old ?><br>
                                    居住地: <?php echo $pref_name_live ?><br>
                                    出身地: <?php echo $pref_name_from ?><br>
                                    星座: <?php echo $sign ?><br>
                                    身長: <?php echo $height ?><br>
                                    スタイル: <?php echo $style ?><br>
                                    職業: <?php echo $job ?><br>
                                    収入: <?php echo $income ?><br>
                                    結婚: <?php echo $marriage ?><br>
                                    子ども: <?php echo $child ?><br>
                                    タバコ: <?php echo $cigarette ?><br>
                                    アルコール: <?php echo $alcohol ?><br>
                                    クルマ: <?php echo $car ?><br>
                                    同居人: <?php echo $people ?><br>
                                    兄弟関係: <?php echo $brother ?><br>
                                    出会うまでの希望: <?php echo $meet ?><br>
                                    初回デート費用: <?php echo $cost ?><br>
                                </p>
                            </div>
                        <?php else : ?>
                            <p><a href="javascript:history.back();" class="btn-flat-BackAll"><i class="fa fa-chevron-left"></i>戻る</a></p>
                            </br>
                            <div class="text-center">
                                <p>編集内容に不備があるようです。<br>再度プロフィールを編集し直してください。</p>
                            </div>
                        <?php endif; ?>
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