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
<html>

<head>
    <meta charset="utf-8">
    <title>アカウント情報</title>
</head>

<body>
    <?php
    if (is_file("./csv/users.csv")) { //登録ファイルが存在するか
        if (is_readable("./csv/users.csv")) { //登録ファイルを読み込めるか
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
    <?php
    print '<a href="usersEdit.php">編集</a><br>';
    print '<br>';
    ?>
    <h2>アカウント情報</h2>
    <table>
        <?php print "<tr><td>ニックネーム</td><td>" . $content[1] . "</td></tr>"; ?>
        <?php print "<tr><td>本名</td><td>" . $content[5] . "</td></tr>"; ?>
        <?php print "<tr><td>性別</td><td>" . $content[2] . "</td></tr>"; ?>
        <?php print "<tr><td>メールアドレス</td><td>" . $content[3] . "</td></tr>"; ?>
    </table>
</body>
<footer>
    <p><small>&copy; マッチングナビ 2020 仮</small></p>
</footer>

</html>