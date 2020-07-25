<!DOCTYPE heml>
<html lang="ja">

<head>
    <meta http-equiv="content-type" charset="utf-8">
    <title>登録確認</title>
</head>

<body>
    <?php
    //配列の要素が定義されているか
    if (!empty($_POST["name"]) && !empty($_POST["sex"]) && !empty($_POST["nickname"]) && !empty($_POST["email"]) && !empty($_POST["pass1"]) && !empty($_POST["pass2"])) {
        //入力データの書き込み
        if (strlen($_POST["name"]) != 0) {
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
            //ユーザーにユニークなidを割り振る
            if (is_file("./csv/users.csv")) { //登録ファイルが存在するか
                if (is_readable("./csv/users.csv")) { //登録ファイルを読み込めるか
                    $fp = fopen("./csv/users.csv", "r");
                    flock($fp, LOCK_SH);
                    $count = 0;
                    //users.csvの中身を一行ずつカウント
                    while (!feof($fp)) {
                        $content = fgetcsv($fp);
                        $count++;
                    }
                    //登録ファイルを閉じる
                    flock($fp, LOCK_UN);
                    fclose($fp); 
                } else
                    echo "ファイルがありません。";
            } else
                echo "ファイルが開けません。";
            //パスワードが一致しないときの処理
            if ($pass1 != $pass2) {
                print 'パスワードが一致しません。<br>';
                print '<form>';
                print '<input type="button" onclick="history.back()" value="戻る">';
                print '</form>';
            } else {
                //登録確認画面へ
                $pass = md5($pass1);
                //入力内容の確認
                echo "<p><b>名前:'" . $name . "'</b>";
                echo "<p><b>性別:'" . $sex . "'</b>";
                echo "<p><b>ニックネーム:'" . $nickname . "'</b>";
                echo "<p><b>メールアドレス:'" . $email . "'</b>";
                //変数の維持
                print '<form method="post" action="user_add_done.php">';
                print '<input type="hidden" name="count" value="' .$count. '">';
                print '<input type="hidden" name="name" value="'.$name.'">';
                print '<input type="hidden" name="sex" value="'.$sex.'">';
                print '<input type="hidden" name="nickname" value="'.$nickname.'">';
                print '<input type="hidden" name="email" value="'.$email.'">';
                print '<input type="hidden" name="pass" value="'.$pass.'">';
                print '<br>';
                print '<input type="button" onclick="history.back()" value="戻る">';
                print '<input type="submit" value="登録完了！">';
                print '</form>';
            }
        }
    }
    else {
        echo "もう一度やり直してください。";
    }
    ?>
</body>
</html>