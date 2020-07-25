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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/gridstyle.css" rel="stylesheet">
    <title>プロフ検索</title>
</head>

<body>
    <div class="wrapper grid">
        <?php
        //他の異性ユーザーの顔写真を一つずつ載せる
        if (is_file("./csv/profile.csv") && is_file("./csv/users.csv")) { //登録ファイルが存在するか
            if (is_readable("./csv/profile.csv") && is_readable("./csv/users.csv")) { //登録ファイルを読み込めるか
                $fp1 = fopen("./csv/profile.csv", "r"); //プロフ情報
                $fp2 = fopen("./csv/users.csv", "r"); //ユーザー情報
                flock($fp1, LOCK_SH);
                flock($fp2, LOCK_SH);
                //サイズが一緒であるはず
                if (count($fp1) == count($fp2)) {
                    //一旦データを全て配列に収める
                    //登録ユーザーを取り出す.
                    while (!feof($fp2)) {
                        $user = fgetcsv($fp2);
                        $content = fgetcsv($fp1);
                        //同性のユーザーは無視
                        if (strcmp($user[2], $_SESSION['sex']) != 0 && $user[2] != "") {
                            print '<div class="item">';
                            //URLパラメータ生成
                            print '<a href="userPlofile.php?id=' . $content[0] . '"><img src = ' . $content[1] . ' alt=""></a>';
                            print '<p>' . $content[2] . '</p>';
                            print '</div>';
                        }
                    }
                }
                //登録ファイルを閉じる
                flock($fp2, LOCK_UN);
                flock($fp1, LOCK_UN);
                fclose($fp2);
                fclose($fp1);
            } else {
                echo "ファイルが開けません。";
                exit();
            }
        } else {
            echo "ファイルがありません。";
            exit();
        }
        ?>
    </div>
</body>
<footer>
    <p><small>&copy; マッチングナビ 2020 仮</small></p>
</footer>

</html>