<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="siteimages/matchingNav.png">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/table.css" rel="stylesheet">
    <title>プロフィール</title>
    <script src="js/node_modules/chart.js/dist/Chart.min.js"></script>
</head>

<body background="siteimages/b094.jpg">
    <div class="left-column">
        <p class="icon"><img class="logo" src="siteimages/matchingNav.png" alt="マッチングナビロゴ"></p>
        <!--左サイドバー-->
        <ul class="sideBar">
            <li><a href="index.php">ホーム</a></li>
            <li><a href="serach.php">プロフ検索</a></li>
            <li><a href="chatInfo.php">メッセージ</a></li>
            <li><a href="profile.php">プロフィール</a></li>
            <li><a href="loginInfo.php">登録情報</a></li>
            <li><a href="confirmFootPrint.php">足跡</a></li>
            <li><a href="confirmGood.php">あなたへのいいね</a></li>
            <li><a href="confirmLove.php">あなたへのタイプ</a></li>
            <li><a href="confirmMyGood.php">いいねした相手</a></li>
            <li><a href="confirmMyLove.php">タイプした相手</a></li>
            <li><a href="info.php">お知らせ</a></li>
            <li><a href="news.php">最新情報</a></li>
            <li><a href="constant.php">お問い合わせ</a></li>
        </ul>
    </div>
    <div class="wrapper">
        <div class="right-column">
            <?php
            //ログイン状態
            session_start();
            session_regenerate_id(true);
            //変数がセットされているか
            if (isset($_SESSION['login']) == false) {
                header("Location: loginMove.php");
                exit();
            } else {
                print '<p id ="login">';
                print $_SESSION['nickname'] . '様-';
                print '<a href="logout.php"><b>ログアウト</b></a>';
                print '<br><p>';
            }
            ?>
            <header>
                <div class="top-header">
                    <nav>
                        <ul>
                            <li><a href="about.php" class="btn4">マッチングナビとは</a></li>
                            <li><a href="payment.php" class="btn4">ご利用料金</a></li>
                            <li><a href="howToPay.php" class="btn4">お支払い方法</a></li>
                            <li><a href="back.php" class="btn4">料金の払い戻し</a></li>
                            <li><a href="firm.php" class="btn4">会社情報</a></li>
                            <li><a href="contact.php" class="btn4">お問い合わせ</a></li>
                        </ul>
                    </nav>
                </div>
            </header>
            <div id="contenar">
                <div id="field">
                    <div id="home" class="top-image-area">
                        <a href="index.php"><img class="logo" src="siteimages/header.png" height="130" alt="マッチングナビロゴ"></a>
                        <div class="page-header">
                            <nav>
                                <ul class="main-nav">
                                    <li><a href="index.php" class="btn4"><i class="fas fa-home"></i>ホーム</a></li>
                                    <li><a href="search.php" class="btn4"><i class="fas fa-search"></i>プロフ検索</a></li>
                                    <li><a href="bulletinInfo.php" class="btn4"><i class="fas fa-clipboard"></i>掲示板</a></li>
                                    <li><a href="chatInfo.php" class="btn4"><i class="fas fa-comment-dots"></i>メッセージ</a></li>
                                    <li><a href="myPage.php" class="btn4"><i class="fas fa-address-card"></i>マイページ</a></li>
                                    <li><a href="contact.php" class="btn4"><i class="fas fa-phone"></i>お問い合わせ</a></li>
                                </ul>
                            </nav>
                        </div>
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
                                header("Location: fileError.php");
                                exit();
                            }
                        } else {
                            header("Location: fileError.php");
                            exit();
                        }
                        ?>
                        <!--画像の挿入-->
                        <?php
                        print '<p><a href="javascript:history.back();" class="btn-flat-simpleBack"><i class="fa fa-chevron-left"></i>戻る</a>';
                        print '<a href="profEdit.php" class="btn-flat-simple">編集</a></p>';
                        print '<br>';
                        $count = 0;
                        for ($i = 4; $i < count($content); $i++) {
                            if (strcmp($content[$i], '指定しない') != 0 && strcmp($content[$i], 'ヒミツ') != 0) {
                                $count++;
                            }
                        }
                        //プロフの項目数
                        $sum = 20;
                        ?>
                        <!--円グラフ-->
                        <canvas id="chart-area" width="200" height="150" class="chart"></canvas>
                        <script>
                            (function() {
                                var blue = 'rgb(54, 162, 235)';
                                var gray = 'rgb(99, 99, 99)';

                                var data = {
                                    datasets: [{
                                        data: [<?php echo ($count / $sum) * 100 ?>,
                                            <?php echo (($sum - $count) / $sum) * 100 ?>,
                                        ],
                                        backgroundColor: [blue, gray],
                                    }],
                                };

                                // グラフオプション
                                var options = {
                                    // グラフの太さ（中央部分を何％切り取るか）
                                    cutoutPercentage: 65,
                                    // 凡例を表示しない
                                    legend: {
                                        display: false
                                    },
                                    // 自動サイズ変更をしない
                                    responsive: false,
                                    // タイトル
                                    title: {
                                        display: true,
                                        fontSize: 16,
                                        text: 'プロフ充実度',
                                    },
                                    // マウスオーバー時に情報を表示しない
                                    tooltips: {
                                        enabled: false
                                    },
                                };

                                // グラフ描画
                                var ctx = document.getElementById('chart-area').getContext('2d');
                                new Chart(ctx, {
                                    type: 'doughnut',
                                    data: data,
                                    options: options
                                });
                            })();

                            var chartJsPluginCenterLabel = {
                                afterDatasetsDraw: function(chart) {
                                    // ラベルの X 座標と Y 座標
                                    var canvas = chart.ctx.canvas;
                                    var labelX = canvas.clientWidth / 2;
                                    var labelY = Math.round((canvas.clientHeight + chart.chartArea.top) / 2);
                                    // ラベルの値
                                    var value = chart.data.datasets[0].data[0] + '%';
                                    // ラベル描画
                                    var ctx = this.setTextStyle(chart.ctx);
                                    ctx.fillText(value, labelX, labelY);
                                },

                                /**
                                 * 書式設定
                                 */
                                setTextStyle: function(ctx) {
                                    var fontSize = 30;
                                    var fontStyle = 'normal';
                                    var fontFamily = '"Helvetica Neue", Helvetica, Arial, sans-serif';
                                    ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
                                    ctx.fillStyle = '#636363';
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'middle';

                                    return ctx;
                                }
                            };
                            // 上記プラグインの有効化
                            Chart.plugins.register(chartJsPluginCenterLabel);
                        </script>
                        <!--円グラフ終わり-->
                        <table>
                            <?php print "<tr><td colspan=\"2\">" . '<div class="center"><img border="0" src="' . $content[1] . '" width="500" height="500" alt="プロフィール画像"></div>' . "</td></tr>"; ?>
                            <?php print "<th colspan=\"2\">自己紹介</th>"; ?>
                            <?php print "<tr><td colspan=\"2\">" . $content[2] . "</td></tr>"; ?>
                            <?php print "<th colspan=\"2\">基本情報</th>"; ?>
                            <?php print "<tr><td>ニックネーム</td><td>" . $content[3] . "</td></tr>"; ?>
                            <?php print "<tr><td>年齢</td><td>" . $content[4] . "</td></tr>"; ?>
                            <?php print "<tr><td>居住地</td><td>" . $content[5] . "</td></tr>"; ?>
                            <?php print "<tr><td>出身地</td><td>" . $content[6] . "</td></tr>"; ?>
                            <?php print "<tr><td>血液型</td><td>" . $content[7] . "</td></tr>"; ?>
                            <?php print "<tr><td>星座</td><td>" . $content[8] . "</td></tr>"; ?>
                            <?php print "<th colspan=\"2\">外見</th>"; ?>
                            <?php print "<tr><td>身長</td><td>" . $content[9] . "</td></tr>"; ?>
                            <?php print "<tr><td>スタイル</td><td>" . $content[10] . "</td></tr>"; ?>
                            <?php print "<tr><td>ルックス</td><td>" . $content[11] . "</td></tr>"; ?>
                            <?php print "<th colspan=\"2\">仕事・学歴</th>"; ?>
                            <?php print "<tr><td>職業</td><td>" . $content[12] . "</td></tr>"; ?>
                            <?php print "<tr><td>年収</td><td>" . $content[13] . "</td></tr>"; ?>
                            <?php print "<th colspan=\"2\">ライフスタイル</th>"; ?>
                            <?php print "<tr><td>交際ステータス</td><td>" . $content[14] . "</td></tr>"; ?>
                            <?php print "<tr><td>子供</td><td>" . $content[15] . "</td></tr>"; ?>
                            <?php print "<tr><td>たばこ</td><td>" . $content[16] . "</td></tr>"; ?>
                            <?php print "<tr><td>お酒</td><td>" . $content[17] . "</td></tr>"; ?>
                            <?php print "<tr><td>クルマ</td><td>" . $content[18] . "</td></tr>"; ?>
                            <?php print "<tr><td>同居人</td><td>" . $content[19] . "</td></tr>"; ?>
                            <?php print "<tr><td>兄弟関係</td><td>" . $content[20] . "</td></tr>"; ?>
                            <?php print "<th colspan=\"2\">相手に求める条件</th>"; ?>
                            <?php print "<tr><td>出会うまでの希望</td><td>" . $content[21] . "</td></tr>"; ?>
                            <?php print "<tr><td>初回デート費用</td><td>" . $content[22] . "</td></tr>"; ?>
                        </table>
                        </br>
                    </div>
                </div>
            </div>
            <div class="footer-wrapper">
                <footer>
                    <div class="foot-wrap">
                        <div class="menu-left">
                            <h3>マッチングナビについて</h3>
                            <ul class="foot-left">
                                <li><a href="about.php">マッチングナビとは</a></li>
                                <li><a href="service.php">サービス</a></li>
                                <li><a href="rule.php">会員規約</a></li>
                            </ul>
                        </div>
                        <div class="menu-center">
                            <h3>決済</h3>
                            <ul class="foot-center">
                                <li><a href="payment.php">ご利用料金</a></li>
                                <li><a href="howToPay.php">お支払い方法</a></li>
                                <li><a href="back.php">料金の払い戻し</a></li>
                            </ul>
                        </div>
                        <div class="menu-right">
                            <h3>個人情報の取り扱い</h3>
                            <ul class="foot-right">
                                <li><a href="policy.php">プライバシーポリシー</a></li>
                                <li><a href="firm.php">特定商取引法に基づく表記</a></li>
                                <li><a href="contact.php">お問い合わせ</a></li>
                            </ul>
                        </div>
                        <small class="cmark">©️copyright マッチングナビ 2020
                        </small>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</body>

</html>