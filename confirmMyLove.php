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
    <link href="css/linestyle.css" rel="stylesheet">
    <title>タイプ確認</title>
</head>

<body>
    <div class="container">
        <?php
        //タイプが送られたかどうか
        $flag = false;
        //タイプを送ったユーザーの確認
        if (is_file("./csv/love.csv")) { //ファイルが存在するか
            if (is_readable("./csv/love.csv")) { //ファイルを読み込めるか
                $fp1 = fopen("./csv/love.csv", "r"); //タイプ情報
                flock($fp1, LOCK_SH);
                while (!feof($fp1)) {
                    $content = fgetcsv($fp1);
                    //自分のidの検索
                    if ($content[0] == $_SESSION['id']) {
                        $flag = true;
                        if (is_file("./csv/profile.csv")) { //ファイルが存在するか
                            if (is_readable("./csv/profile.csv")) { //ファイルを読み込めるか
                                $fp2 = fopen("./csv/profile.csv", "r"); //タイプ情報
                                flock($fp2, LOCK_SH);
                                while (!feof($fp2)) {
                                    $profile = fgetcsv($fp2);
                                    //送った相手のid検索
                                    if ($content[1] == $profile[0]) {
                                        print '<div class="item">';
                                        //URLパラメータ生成
                                        print '<a href="userPlofile.php?id=' . $profile[0] . '"><img src = ' . $profile[1] . ' alt=""></a>';
                                        print '<p>' . $profile[2] . '</p>';
                                        print '</div>';
                                        break;
                                    }
                                }
                                flock($fp2, LOCK_UN);
                                fclose($fp2);
                            } else {
                                echo "ファイルが開けません。";
                                exit();
                            }
                        } else {
                            echo "ファイルがありません。";
                        }
                    }
                }
                flock($fp1, LOCK_UN);
                fclose($fp1);
                if ($flag == false) {
                    print "まだ誰にもタイプしていません。<br><br>";
                    print '<form>';
                    print '<input type="button" onclick="history.back()" value="戻る">';
                    print '</form>';
                }
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