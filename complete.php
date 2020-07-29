<?php
//ログイン状態
session_start();
session_regenerate_id(true);
//変数がセットされているか
if (isset($_SESSION['login']) == false) {
    print 'ログインされていません。<br>';
    print '<a href="login.html">ログイン画面へ</a><br>';
    print '<br>';
    exit();
} else {
    print 'ようこそ';
    print "'" . $_SESSION['nickname'] . "'様-";
    print '<a href="logout.php">ログアウト</a><br>';
    print '<br>';
}

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
            if($array[$i][0] == $_SESSION['id']){
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
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>完了</title>
</head>

<body>
    <?php if (!empty($_POST["nickname"]) && strlen($_POST["nickname"]) != 0 && !empty($nickname) && !empty($_POST["old"])) : ?>
        <header>
            <h1>プロフィール編集完了</h1>
            編集内容は以下の通りです。
        </header>
        <p>
            画像: <?php echo $myimage ?><br>
            自己紹介: <?php echo $message ?><br>
            ニックネーム: <?php echo $nickname ?><br>
            年齢: <?php echo $old ?>
            居住地: <?php echo $pref_name_live ?><br>
            出身地: <?php echo $pref_name_from ?><br>
            星座: <?php echo $sign ?>
            身長: <?php echo $height ?><br>
            スタイル: <?php echo $style ?><br>
            職業: <?php echo $job ?>
            収入: <?php echo $income ?><br>
            結婚: <?php echo $marriage ?><br>
            子ども: <?php echo $child ?>
            タバコ: <?php echo $cigarette ?><br>
            アルコール: <?php echo $alcohol ?><br>
            クルマ: <?php echo $car ?>
            同居人: <?php echo $people ?><br>
            兄弟関係: <?php echo $brother ?><br>
            出会うまでの希望: <?php echo $meet ?><br>
            初回デート費用: <?php echo $cost ?><br>
        </p>
        <p>
            <a href="./profile.php" target="_self">プロフィール確認</a><br>
            <a href="./profile.html" target="_self">プロフィール編集に戻る</a>
        </p>
    <?php else : ?>
        <p>編集内容に不備があるようです。<br>再度プロフィールを編集し直してください。</p>
    <?php endif; ?>
    <footer>
        <p><small>&copy; マッチングナビ 2020 仮</small></p>
    </footer>
</body>

</html>