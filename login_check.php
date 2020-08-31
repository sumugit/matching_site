<!DOCTYPE heml>
<html lang="ja">

<head>
    <meta http-equiv="content-type" charset="utf-8">
    <title>ログインチェック</title>
</head>

<body>
    <?php
    //ユーザー名の一致フラグ
    if (!empty($_POST["userName"]) && !empty($_POST["pass"])) {
        //入力データの書き込み
        $userName = htmlspecialchars($_POST["userName"]);
        $pass = md5(htmlspecialchars($_POST["pass"]));
        //移動先のホームページ
        $dest = "./index.php";
        
        if (is_file("./csv/users.csv")) { //登録ファイルが存在するか
            if (is_readable("./csv/users.csv")) { //登録ファイルを読み込めるか
                $fp = fopen("./csv/users.csv", "r");
                flock($fp, LOCK_SH);
                //users.csvの中身を一行ずつ取得
                while (!feof($fp)) {
                    $content = fgetcsv($fp);
                    //エラー防止
                    if (count($content) == 6) {
                        //パスワードとメールアドレス認証処理
                        if(strcmp($content[1], $userName) == 0 && strcmp($content[4], $pass) == 0){
                            //全部のページに追加したい.
                            session_start();
                            session_regenerate_id(true);
                            $_SESSION['login'] = 1;
                            //ユーザーのid
                            $_SESSION['id'] = $content[0];
                            //ユーザーのニックネーム
                            $_SESSION['nickname'] = $content[1];
                            //ユーザーの性別
                            $_SESSION['sex'] = $content[2];
                            //ユーザーのemail
                            $_SESSION['email'] = $content[3];
                            //ユーザーのパスワード
                            $_SESSION['pass'] = $content[4];
                            //ユーザーの指名
                            $_SESSION['name'] = $content[5];
                            header("HTTP/1.1 301 Moved Permanetly");
                            header("Location: $dest");
                            exit;
                        } 
                    }
                }
                //登録ファイルを閉じる
                flock($fp, LOCK_UN);
                fclose($fp);
                header("Location: failed.php");
                exit();
            } else{
                header("Location: fileError.php");
                exit();
            }
        } else {
            header("Location: fileError.php");
            exit();
        }
    }
    ?>
</body>
</html>