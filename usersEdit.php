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
    print $_SESSION['nickname'] . '様-';
    print '<a href="logout.php">ログアウト</a><br>';
    print '<br>';
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta http-equiv="content-type" charset="utf-8">
    <title>アカウント情報編集</title>
</head>

<body>
    <?php
    if (is_file("./csv/users.csv")) { //ファイルが存在するか
        if (is_readable("./csv/users.csv")) { //ファイルを読み込めるか
            $fp = fopen("./csv/users.csv", "r");
            flock($fp, LOCK_SH);
            //idが登録ユーザーと一致するまで一行ずつ取り出す
            while (!feof($fp)) {
                $content = fgetcsv($fp);
                //ログインしているユーザーの情報を取得
                if ($content[0] == $_SESSION['id']) {
                    break;
                }
            }
            //登録ファイルを閉じる
            flock($fp, LOCK_UN);
            fclose($fp);
        } else {
            echo "ファイルが開けません。";
            exit();
        }
    } else {
        echo "ファイルがありません。";
        exit();
    }
    ?>

    <form method="POST" action="./reEnroll.php"> 氏名<br>
        <input type="text" name="name" required><br>
        <input type="hidden" name="nickname" value=<?php echo $_SESSION['nickname']; ?>>
        <input type="hidden" name="id" value=<?php echo $_SESSION['id']; ?>>
        性別<br>
        <input type="radio" name="sex" value="男性" required>男性<br>
        <input type="radio" name="sex" value="女性">女性<br>
        メールアドレス<br>
        <input type="text" name="email" required><br>
        パスワード<br>
        <input type="password" name="pass1" pattern="[0-9a-zA-Z]+$" required><br>
        パスワードをもう一度入力してください。<br>
        <input type="password" name="pass2" required><br>
        <input type="submit" value="登録確認">
    </form>
</body>

<footer>
    <p><small>&copy; マッチングナビ 2020 仮</small></p>
</footer>

</html>