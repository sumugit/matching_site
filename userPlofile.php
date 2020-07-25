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
    <title>プロフィール閲覧</title>
</head>

<body>
    <?php
    //URLパラメータからid取得
    $id = htmlspecialchars($_GET['id']);
    //いいねボタンに用いる
    if (is_file("./csv/profile.csv")) { //登録ファイルが存在するか
        if (is_readable("./csv/profile.csv")) { //登録ファイルを読み込めるか
            $fp = fopen("./csv/profile.csv", "r");
            flock($fp, LOCK_SH);
            //idが登録ユーザーと一致するまで一行ずつ取り出す
            while (!feof($fp)) {
                $content = fgetcsv($fp);
                //閲覧しているユーザーの情報を取得
                if ($content[0] == $id) {
                    //足跡の記録
                    if (is_file("./csv/footPrint.csv")) { //ファイルが存在するか
                        if (is_readable("./csv/footPrint.csv")) { //ファイルを読み込めるか
                            $fp3 = fopen("./csv/footPrint.csv", "r");
                            flock($fp3, LOCK_SH);
                            $flagTrace = false;
                            //idが登録ユーザーと一致するまで一行ずつ取り出す
                            while (!feof($fp3)) {
                                $trace = fgetcsv($fp3);
                                //もし以前に足跡をそのアカウントに押していたら
                                if ($trace[0] == $_SESSION['id'] && $trace[1] == $id) {
                                    $flagTrace = true;
                                    break;
                                }
                            }
                            //ファイルを閉じる
                            flock($fp3, LOCK_UN);
                            fclose($fp3);
                            //そのアカウントにまだ足跡を付けたことが無い
                            if ($flagTrace == false) {
                                $fp3 = fopen("./csv/footPrint.csv", "a+");
                                //ファイルの排他ロック
                                flock($fp3, LOCK_EX);
                                //ファイルに書き込み
                                fputcsv($fp3, array($_SESSION['id'], $id));
                                //ロック解除
                                flock($fp3, LOCK_UN);
                                fclose($fp3);
                            }
                        } else {
                            echo "ファイルが開けません。";
                            exit();
                        }
                    } else {
                        echo "ファイルがありません。";
                        exit();
                    }
                    //ループを抜ける
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
    <!-- jQueryのAjaxでPOST送信してPHPで受け取る-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript">
        //いいねボタンが押された場合
        function good() {
            // 入力されたID値を取得
            $(function() {
                //Ajax通信(いいね押して別のページに遷移するのは不便だから)
                $.ajax({
                    type: "POST",
                    url: "addGood.php",
                    data: {
                        "mine": <?php echo $_SESSION['id']; ?>,
                        "opponent": <?php echo $id; ?>
                    },
                    dataType: "json"
                }).done(function(data) {
                    $("#res").text(data.mine + ' : ' + data.opponent);
                }).fail(function(XMLHttpRequest, textStatus, error) {
                    alert(error);
                });
            });
        }
        //タイプボタンが押された場合
        function love() {
            // 入力されたID値を取得
            $(function() {
                //Ajax通信(いいね押して別のページに遷移するのは不便だから)
                $.ajax({
                    type: "POST",
                    url: "addLove.php",
                    data: {
                        "mine": <?php echo $_SESSION['id']; ?>,
                        "opponent": <?php echo $id; ?>
                    },
                    dataType: "json"
                }).done(function(data) {
                    $("#res").text(data.mine + ' : ' + data.opponent);
                }).fail(function(XMLHttpRequest, textStatus, error) {
                    alert(error);
                });
            });
        }
    </script>
    <input type="button" value="いいね！" onclick="good();">
    <input type="button" value="タイプ！" onclick="love();"><br>
    <?php print '<input type="button" value="チャットをはじめる" onclick="location.href=\'chat.php?id=' . $id . '\' "><br>'; ?>
    <!--画像の挿入-->
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