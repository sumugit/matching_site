<?php
//ログイン状態
session_start();
session_regenerate_id(true);
//変数がセットされているか
if (isset($_SESSION['login']) == false) {
    print 'ログインされていません。<br>';
    print '<a href="login.php">ログイン画面へ</a><br>';
    print '<br>';
    exit();
} else {
    print '<p id ="login">';
    print $_SESSION['nickname'] . '様-';
    print '<a href="logout.php"><b>ログアウト</b></a>';
    print '<br><p>';
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/style3.css" rel="stylesheet">
    <link href="css/box.css" rel="stylesheet">
    <title>完了</title>
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
                <?php
                //配列の要素が定義されているか
                if (!empty($_POST["nickname"]) && !empty($_POST["old"])) {
                    //画像ファイルの情報
                    $tempfile = $_FILES['myImage']['tmp_name'];
                    $filename = './image/' . $_FILES['myImage']['name'];

                    //画像ファイルが本当にアップロードされたか
                    if (is_uploaded_file($tempfile)) {
                        if (move_uploaded_file($tempfile, $filename)) {
                            echo $filename . "をアップロードしました。";
                        } else {
                            echo "ファイルをアップロードできません。";
                        }
                    } else {
                        //男性か女性かで分けるようにしたい
                        $filename = './image/unknown.jpg';
                        echo "ファイルが選択されていません。";
                    }

                    //入力データの書き込み
                    if (strlen($_POST["nickname"]) != 0) {
                        $myimage = htmlspecialchars($filename);
                        //画像名に,があれば_に変える(これだと画像を参照できない)
                        $myimage = preg_replace("/,/", "_", $myimage);
                        $message = htmlspecialchars($_POST["message"]);
                        //,は半角空白にする
                        $message = preg_replace("/,/", "、", $message);
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

                        //ファイルへ書き込み
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
                    }
                }
                ?>
                <?php if (!empty($_POST["nickname"]) && strlen($_POST["nickname"]) != 0 && !empty($nickname) && !empty($_POST["old"])) : ?>
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
                    <p>
                        <div class="containerbox"><a href="./profile.php" class="btn-push" target="_self">プロフィール確認</a></div>
                        <div class="containerbox"><a href="./profEdit.php" class="btn-push" target="_self"> 　編集に戻る 　</a></div>
                        <br>
                        <br>
                    </p>
                <?php else : ?>
                    <p>編集内容に不備があるようです。<br>再度プロフィールを編集し直してください。</p>
                <?php endif; ?>
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