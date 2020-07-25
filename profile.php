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
    <title>プロフィール</title>
</head>

<body>
    <?php
    if (is_file("./csv/profile.csv")) { //登録ファイルが存在するか
        if (is_readable("./csv/profile.csv")) { //登録ファイルを読み込めるか
            $fp = fopen("./csv/profile.csv", "r");
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
    <!--画像の挿入-->
    <?php
    print '<a href="profEdit.php">編集</a><br>';
    print '<br>';
    ?>
    <?php print '<img border="0" src="' . $content[1] . '" width="128" height="128" alt="プロフィール画像">'; ?><br>
    <h2>自己紹介</h2>
    <?php print $content[2]; ?>
    <h2>基本情報</h2>
    <table>
        <?php print "<tr><td>ニックネーム</td><td>" . $content[3] . "</td></tr>"; ?>
        <?php print "<tr><td>年齢</td><td>" . $content[4] . "</td></tr>"; ?>
        <?php print "<tr><td>居住地</td><td>" . $content[5] . "</td></tr>"; ?>
        <?php print "<tr><td>出身地</td><td>" . $content[6] . "</td></tr>"; ?>
        <?php print "<tr><td>血液型</td><td>" . $content[7] . "</td></tr>"; ?>
        <?php print "<tr><td>星座</td><td>" . $content[8] . "</td></tr>"; ?>
    </table>
    <h2>外見</h2>
    <table>
        <?php print "<tr><td>身長</td><td>" . $content[9] . "</td></tr>"; ?>
        <?php print "<tr><td>スタイル</td><td>" . $content[10] . "</td></tr>"; ?>
        <?php print "<tr><td>ルックス</td><td>" . $content[11] . "</td></tr>"; ?>
    </table>
    <h2>仕事・学歴</h2>
    <table>
        <?php print "<tr><td>職業</td><td>" . $content[12] . "</td></tr>"; ?>
        <?php print "<tr><td>年収</td><td>" . $content[13] . "</td></tr>"; ?>
    </table>
    <h2>ライフスタイル</h2>
    <table>
        <?php print "<tr><td>交際ステータス</td><td>" . $content[14] . "</td></tr>"; ?>
        <?php print "<tr><td>子供</td><td>" . $content[15] . "</td></tr>"; ?>
        <?php print "<tr><td>たばこ</td><td>" . $content[16] . "</td></tr>"; ?>
        <?php print "<tr><td>お酒</td><td>" . $content[17] . "</td></tr>"; ?>
        <?php print "<tr><td>クルマ</td><td>" . $content[18] . "</td></tr>"; ?>
        <?php print "<tr><td>同居人</td><td>" . $content[19] . "</td></tr>"; ?>
        <?php print "<tr><td>兄弟関係</td><td>" . $content[20] . "</td></tr>"; ?>
    </table>
    <h2>相手に求める条件</h2>
    <table>
        <?php print "<tr><td>出会うまでの希望</td><td>" . $content[21] . "</td></tr>"; ?>
        <?php print "<tr><td>初回デート費用</td><td>" . $content[22] . "</td></tr>"; ?>
    </table>
</body>
<footer>
    <p><small>&copy; マッチングナビ 2020 仮</small></p>
</footer>

</html>