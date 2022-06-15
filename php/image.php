<!DOCTYPE html>
<html lang="ja">

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
    <title>完了</title>
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
            if (empty($_GET['id'])) {
                header("Location: beyondExpectations.php");
                exit();
            }
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
                        //自分のid
                        $id = $_GET['id'];
                        //画像ファイルの情報
                        $tempfile = $_FILES['myImage']['tmp_name'];
                        $filename = './image/' . $_FILES['myImage']['name'];
                        //Windowsサーバーに保存する時は文字コード変更しないと文字化けする
                        //$filename = mb_convert_encoding($filename, "cp932", "utf8");

                        //画像ファイルが本当にアップロードされたか
                        if (is_uploaded_file($tempfile)) {
                            if (move_uploaded_file($tempfile, $filename)) {
                                //echo "<div class='text-center'>" . $filename . "をアップロードしました。</div>";
                            } else {
                                //echo "<div class='text-center'>ファイルをアップロードできません。</div>";
                            }
                        } else {
                            //男性か女性かで分けるようにしたい
                            if (strcmp($_SESSION['sex'], "男性") == 0)
                                $filename = './image/unknown.jpg';
                            else $filename = './image/unknown_w.png';
                            //echo "<div class='text-center'>ファイルが選択されていません。</div>";
                        }
                        //画像
                        $myimage = htmlspecialchars($filename);
                        //画像名に,があれば_に変える(これだと画像を参照できない)
                        $myimage = preg_replace("/,/", "_", $myimage);
                        //プロフファイルへ書き込み
                        //r/w/a: 読み/書き/上書き
                        $fp = fopen("./csv/profile.csv", "a+");
                        //ファイルの排他ロック
                        flock($fp, LOCK_EX);
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
                            //コンマ区切りで配列に渡す
                            $separete = explode(",", $array[$i]);
                            if ($separete[0] == $id) {
                                //出力データ生成
                                $separete[1] = $myimage;
                                //配列を,で連結
                                $output = implode(',', $separete);
                                $array[$i] = $output;
                            }
                            //ファイルに書き込み
                            fputs($fp, $array[$i]);
                        }
                        //ロック解除
                        flock($fp, LOCK_UN);
                        fclose($fp);
                        ?>
                        <?php if (!empty($myimage)) : ?>
                            <?php print '<p><a href="./profileImage.php" class="btn-flat-simpleBack"><i class="fa fa-chevron-left"></i>編集に戻る</a>';
                            print '<a href="./profile.php" class="btn-flat-simple">プロフィール確認</a></p>'; ?>
                            <br>
                            <div class="box30">
                                <div class="box-title">プロフィール画像編集完了！</div>
                                <p>
                                    画像: <?php echo $myimage ?><br>
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