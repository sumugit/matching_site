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
<html lang="ja">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/style3.css" rel="stylesheet">
    <link href="css/box.css" rel="stylesheet">
    <title>編集完了</title>
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
                if (!empty($_POST["name"]) && !empty($_POST["sex"]) && !empty($_POST["pass1"]) && !empty($_POST["pass2"]) && !empty($_POST['nickname'])) {
                    //入力データの書き込み
                    if (strlen($_POST["name"]) != 0) {
                        $id = htmlspecialchars($_POST["id"]);
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
                        if ($pass1 != $pass2) {
                            print 'パスワードが一致しません。<br>';
                            print '<form>';
                            print '<input type="button" onclick="history.back()" value="戻る">';
                            print '</form>';
                        }
                        $pass1 = md5(htmlspecialchars($_POST["pass1"]));
                        //ファイルへ書き込み
                        //r/w/a: 読み/書き/上書き
                        $fp = fopen("./csv/users.csv", "a+");
                        //ファイルの排他ロック
                        flock($fp, LOCK_EX);
                        //出力データ生成
                        $output = join(",", array($id, $nickname, $sex, $email, $pass1, $name)) . "\n";

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
                            if ($array[$i][0] == $id) {
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
                <?php if (!empty($_POST["name"])) : ?>
                    <div class="box30">
                        <div class="box-title">プロフィール編集完了！</div>
                        <p>
                            ニックネーム: <?php echo $nickname ?><br>
                            本名: <?php echo $name ?><br>
                            性別: <?php echo $sex ?><br>
                            メールアドレス: <?php echo $email ?>
                        </p>
                    </div>
                    <p>
                        <div class="containerbox"><a href="./loginInfo.php" class="btn-push" target="_self">アカウント情報</a><br></div>
                        <div class="containerbox"><a href="./usersEdit.php" class="btn-push" target="_self">編集に戻る</a></div>
                    </p>
                    <br>
                    <br>
                <?php else : ?>
                    <p>編集内容に不備があるようです。<br>再度登録内容を編集し直してください。</p>
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