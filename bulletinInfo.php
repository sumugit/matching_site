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
    <title>掲示板</title>
</head>

<body>
    <div class="container">
        <?php
        //掲示板があるかどうか
        $flag = false;
        //作成された掲示板の確認
        if (is_file("./csv/bulletinLog.csv")) { //ファイルが存在するか
            if (is_readable("./csv/bulletinLog.csv")) { //ファイルを読み込めるか
                $fp1 = fopen("./csv/bulletinLog.csv", "r");
                flock($fp1, LOCK_SH);
                while (!feof($fp1)) {
                    $content = fgetcsv($fp1);
                    //作成された掲示板を一つずつ読み込む
                        if (is_file("./csv/profile.csv")) { //ファイルが存在するか
                            if (is_readable("./csv/profile.csv")) { //ファイルを読み込めるか
                                $fp2 = fopen("./csv/profile.csv", "r");
                                flock($fp2, LOCK_SH);
                                while (!feof($fp2)) {
                                    $profile = fgetcsv($fp2);
                                    //掲示板の作成者検索
                                    if ($content[1] == $profile[0] && !empty($content[1])) {
                                        $flag = true;
                                        print '<div class="item">';
                                        //URLパラメータ生成
                                        print '<a href="bulletin.php?index=' . $content[0] . '"><img src = ' . $profile[1] . '  width="128" height="128" alt=""></a>';
                                        print '<p>' . $content[3] . '</p>';
                                        print '<input type="button" value="プロフィール" onclick="location.href=\'userPlofile.php?id=' . $profile[0] . '\'">';
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
                flock($fp1, LOCK_UN);
                fclose($fp1);
                if ($flag == false) {
                    print "誰も掲示板を投稿していません。<br><br>";
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

    <hr>
    <p>
        <b>スレッドを作成する</b>
        <form method="POST" action="./createBulletin.php">
            タイトル:<input type="text" name="title"><br>
            <!-- idも渡す(createBulletinに$_SESSION['id]の情報がない) -->
            <input type="hidden" name="id" value=<?php echo $_SESSION['id'] ?>>
            <input type="hidden" name="nickname" value=<?php echo $_SESSION['nickname'] ?>>
            <input type="submit" value="作成">
        </form>
    </p>
    <hr>

</body>

</html>