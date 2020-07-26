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
        if($pass1 != $pass2){
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
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>編集完了</title>
</head>

<body>
    <?php if (!empty($_POST["name"])) : ?>
        <header>
            <h1>プロフィール編集完了</h1>
            編集内容は以下の通りです。
        </header>
        <p>
            ニックネーム: <?php echo $nickname ?><br>
            本名: <?php echo $name ?><br>
            性別: <?php echo $sex ?><br>
            メールアドレス: <?php echo $email ?>
        </p>
        <p>
            <a href="./loginInfo.php" target="_self">アカウント情報確認</a><br>
            <a href="./usersEdit.php" target="_self">編集に戻る</a>
        </p>
    <?php else : ?>
        <p>編集内容に不備があるようです。<br>再度登録内容を編集し直してください。</p>
    <?php endif; ?>
    <footer>
        <p><small>&copy; マッチングナビ 2020 仮</small></p>
    </footer>
</body>

</html>