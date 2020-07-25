<!DOCTYPE heml>
<html lang="ja">

<head>
    <meta http-equiv="content-type" charset="utf-8">
    <title>登録完了</title>
</head>

<body>
    <?php
    //配列の要素が定義されているか
    if (!empty($_POST["name"]) && !empty($_POST["sex"]) && !empty($_POST["nickname"]) && !empty($_POST["email"]) && !empty($_POST["pass"])) {
        //入力データの書き込み
        $count = htmlspecialchars($_POST["count"]);
        $name = htmlspecialchars($_POST["name"]);
        $sex = htmlspecialchars($_POST["sex"]);
        $nickname = htmlspecialchars($_POST["nickname"]);
        $email = htmlspecialchars($_POST["email"]);
        $pass = htmlspecialchars($_POST["pass"]);
        try {
            //登録ファイルへ書き込み
            //r/w/a: 読み/書き/上書き
            $fp = fopen("./csv/users.csv", "a+");
            //ファイルの排他ロック
            flock($fp, LOCK_EX);
            //出力データ生成
            $output = join(",", array($count, $nickname, $sex, $email, $pass, $name)) . "\n";
            //ファイルに書き込み
            fputs($fp, $output);
            //ロック解除
            flock($fp, LOCK_UN);
            fclose($fp);
            print '登録が完了しました！<br>';
            print '<form method="post" action="index.php">';
            print '<input type="submit" value="ホームへ戻る">';
            print '</form>';

            //プロフィールファイルへの書き込み
            //r/w/a: 読み/書き/上書き
            $fp = fopen("./csv/profile.csv", "a+");
            //ファイルの排他ロック
            flock($fp, LOCK_EX);
            //出力データ生成
            //登録ユーザーが男性なら
            if($sex == "男性")
                $output = join(",", array($count, "./image/unknown.jpg", "よろしくお願いします。", $nickname, "20代前半", "東京都", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない")) . "\n";
            //登録ユーザーが女性なら
            else $output = join(",", array($count, "./image/unknown_w.png", "よろしくお願いします。", $nickname, "20代前半", "東京都", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない", "指定しない")) . "\n";
            //ファイルに書き込み
            fputs($fp, $output);
            //ロック解除
            flock($fp, LOCK_UN);
            fclose($fp);

        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑おかけしています。';
            print '<form>';
            print '<input type="button" onclick="history.back()" value="戻る">';
            print '</form>';
        }
    }
    else {
        print '新規登録が完了していません。';
        print '<a href="login.html">ログイン画面へ</a><br>';
        print '<br>';
        exit();
    }
    ?>
</body>
</html>