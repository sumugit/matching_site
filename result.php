<?php
//ログイン状態
session_start();
session_regenerate_id(true);
//変数がセットされているか
if (isset($_SESSION['login']) == false) {
    print 'ログインされていません。<br>';
    print '<a href="login.php">ログイン画面へ</a><br>';
    print '<br>';
    exit();
} else {
    print '<p id ="login">';
    print $_SESSION['nickname'] . '様-';
    print '<a href="logout.php"><b>ログアウト</b></a>';
    print '<br><p>';
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style3.css" rel="stylesheet">
    <link href="css/gridstyle.css" rel="stylesheet">
    <link href="css/buttonSearch.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <title>検索結果</title>
</head>

<body>
    <div id="contenar">
        <div id="field">
            <div id="home" class="top-image-area">
                <a href="index.php"><img class="logo" src="siteimages/header2.png" alt="マッチングナビロゴ"></a>
                <header class="page-header wrapper">
                    <nav>
                        <ul class="main-nav">
                            <li><a href="index.php" class="btn4">ホーム</a></li>
                            <li><a href="search.php" class="btn4">プロフ検索</a></li>
                            <li><a href="bulletinInfo.php" class="btn4">掲示板</a></li>
                            <li><a href="chatInfo.php" class="btn4">メッセージ</a></li>
                            <li><a href="myPage.php" class="btn4">マイページ</a></li>
                            <li><a href="contact.html" class="btn4">お問い合わせ</a></li>
                        </ul>
                    </nav>
                </header>
                <div class="wrapper grid">
                    <?php
                    //配列の要素が定義されているか
                    if (!empty($_POST["pref_name_live"]) && !empty($_POST["old"])) {
                        $old = htmlspecialchars($_POST["old"]);
                        $pref_name_live = htmlspecialchars($_POST["pref_name_live"]);
                        $pref_name_from = htmlspecialchars($_POST["pref_name_from"]);
                        $sign = htmlspecialchars($_POST["sign"]);
                        $height = htmlspecialchars($_POST["height"]);
                        $style = htmlspecialchars($_POST["style"]);
                        $job = htmlspecialchars($_POST["job"]);
                        $income = htmlspecialchars($_POST["income"]);
                        $marriage = htmlspecialchars($_POST["marriage"]);
                        $child = htmlspecialchars($_POST["child"]);
                        $cigarette = htmlspecialchars($_POST["cigarette"]);
                        $alcohol = htmlspecialchars($_POST["alcohol"]);
                        $car = htmlspecialchars($_POST["car"]);
                        $people = htmlspecialchars($_POST["people"]);
                        $brother = htmlspecialchars($_POST["brother"]);
                        $meet = htmlspecialchars($_POST["meet"]);
                        $cost = htmlspecialchars($_POST["cost"]);
                        //配列にした方が後で処理で楽
                        $array = array($old, $pref_name_live, $pref_name_from, $sign, $height, $style, $job, $income, $marriage, $child, $cigarette, $alcohol, $car, $people, $brother, $meet, $cost);
                        //他の異性ユーザーの顔写真を一つずつ載せる
                        if (is_file("./csv/profile.csv") && is_file("./csv/users.csv")) { //登録ファイルが存在するか
                            if (is_readable("./csv/profile.csv") && is_readable("./csv/users.csv")) { //登録ファイルを読み込めるか
                                $fp1 = fopen("./csv/profile.csv", "r"); //プロフ情報
                                $fp2 = fopen("./csv/users.csv", "r"); //ユーザー情報
                                flock($fp1, LOCK_SH);
                                flock($fp2, LOCK_SH);
                                //サイズが一緒であるはず
                                if (count($fp1) == count($fp2)) {
                                    while (!feof($fp1)) {
                                        $content = fgetcsv($fp1);
                                        $user = fgetcsv($fp2);
                                        if (strcmp($user[2], $_SESSION['sex']) == 0) continue;
                                        for ($i = 0; $i < 17; $i++) {
                                            //条件指定をしている項目について
                                            if (strcmp($array[$i], "指定しない") == 0) continue;
                                            //条件指定をした項目のAND演算
                                            else if (strcmp($array[$i], $content[$i + 4]) != 0) {
                                                break;
                                            }
                                        }
                                        //一致するユーザーを表示
                                        if ($i == 17) {
                                            //URLパラメータ生成
                                            print '<a href="userPlofile.php?id=' . $content[0] . '"><div class="item"><img src = ' . $content[1] . ' width="128" height="128" alt=""><p><b>' . $content[5] . '　' . $content[4] . '</b></p><p>' . $content[2] . '</p></div></a>';
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
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<div class="footer-wrapper">
    <footer>
        <p><small>&copy; マッチングナビ 2020</small></p>
    </footer>
</div>

</html>