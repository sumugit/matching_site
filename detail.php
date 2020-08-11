<!DOCTYPE html>
<html lang="ja">

<head>
    <meta http-equiv="content-type" charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="icon" type="image/png" href="siteimages/matchingNav.png">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/table.css" rel="stylesheet">
    <title>詳細検索</title>
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
                        <p><a href="javascript:history.back();" class="btn-flat-BackAll"><i class="fa fa-chevron-left"></i>戻る</a></p>
                        </br>
                        <?php
                        if (is_file("./csv/profile.csv")) { //プロフィールファイルが存在するか
                            if (is_readable("./csv/profile.csv")) { //プロフィールファイルを読み込めるか
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
                            } else
                                echo "ファイルが開けません。";
                        } else
                            echo "ファイルがありません。";
                        ?>
                        <!--form part-->
                        <form method="POST" action="./result.php">
                            <table>
                                <th colspan="2">基本情報</th>
                                <!--以下セレクトボックス-->
                                <tr>
                                    <td>年齢</td>
                                    <td><select name="old">
                                            <!-- デフォルトではログインユーザーと同じ年齢を指定する -->
                                            <option value="18~19" <?= $content[4] == '18~19' ? 'selected' : "" ?>>18~19</option>
                                            <option value="20代前半" <?= $content[4] == '20代前半' ? 'selected' : "" ?>>20代前半</option>
                                            <option value="20代後半" <?= $content[4] == '20代後半' ? 'selected' : "" ?>>20代後半</option>
                                            <option value="30代前半" <?= $content[4] == '30代前半' ? 'selected' : "" ?>>30代前半</option>
                                            <option value="30代後半" <?= $content[4] == '30代後半' ? 'selected' : "" ?>>30代後半</option>
                                            <option value="40代前半" <?= $content[4] == '40代前半' ? 'selected' : "" ?>>40代前半</option>
                                            <option value="40代後半" <?= $content[4] == '40代後半' ? 'selected' : "" ?>>40代後半</option>
                                            <option value="50代前半" <?= $content[4] == '50代前半' ? 'selected' : "" ?>>50代前半</option>
                                            <option value="50代後半" <?= $content[4] == '50代後半' ? 'selected' : "" ?>>50代後半</option>
                                            <option value="60代以上" <?= $content[4] == '60代以上' ? 'selected' : "" ?>>60代以上</option>
                                            <option value="ヒミツ" <?= $content[4] == 'ヒミツ' ? 'selected' : "" ?>>ヒミツ</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>居住地</td>
                                    <td>
                                        <!-- デフォルトではログインユーザーと同じ地域を指定する -->
                                        <select name="pref_name_live">
                                            <option value="北海道" <?= $content[5] == '北海道' ? 'selected' : "" ?>>北海道</option>
                                            <option value="青森県" <?= $content[5] == '青森県' ? 'selected' : "" ?>>青森県</option>
                                            <option value="岩手県" <?= $content[5] == '岩手県' ? 'selected' : "" ?>>岩手県</option>
                                            <option value="宮城県" <?= $content[5] == '宮城県' ? 'selected' : "" ?>>宮城県</option>
                                            <option value="秋田県" <?= $content[5] == '秋田県' ? 'selected' : "" ?>>秋田県</option>
                                            <option value="山形県" <?= $content[5] == '山形県' ? 'selected' : "" ?>>山形県</option>
                                            <option value="福島県" <?= $content[5] == '福島県' ? 'selected' : "" ?>>福島県</option>
                                            <option value="茨城県" <?= $content[5] == '茨城県' ? 'selected' : "" ?>>茨城県</option>
                                            <option value="栃木県" <?= $content[5] == '栃木県' ? 'selected' : "" ?>>栃木県</option>
                                            <option value="群馬県" <?= $content[5] == '群馬県' ? 'selected' : "" ?>>群馬県</option>
                                            <option value="埼玉県" <?= $content[5] == '埼玉県' ? 'selected' : "" ?>>埼玉県</option>
                                            <option value="千葉県" <?= $content[5] == '千葉県' ? 'selected' : "" ?>>千葉県</option>
                                            <option value="東京都" <?= $content[5] == '東京都' ? 'selected' : "" ?>>東京都</option>
                                            <option value="神奈川県" <?= $content[5] == '神奈川県' ? 'selected' : "" ?>>神奈川県</option>
                                            <option value="新潟県" <?= $content[5] == '新潟県' ? 'selected' : "" ?>>新潟県</option>
                                            <option value="富山県" <?= $content[5] == '富山県' ? 'selected' : "" ?>>富山県</option>
                                            <option value="石川県" <?= $content[5] == '石川県' ? 'selected' : "" ?>>石川県</option>
                                            <option value="福井県" <?= $content[5] == '福井県' ? 'selected' : "" ?>>福井県</option>
                                            <option value="山梨県" <?= $content[5] == '山梨県' ? 'selected' : "" ?>>山梨県</option>
                                            <option value="長野県" <?= $content[5] == '長野県' ? 'selected' : "" ?>>長野県</option>
                                            <option value="岐阜県" <?= $content[5] == '岐阜県' ? 'selected' : "" ?>>岐阜県</option>
                                            <option value="静岡県" <?= $content[5] == '静岡県' ? 'selected' : "" ?>>静岡県</option>
                                            <option value="愛知県" <?= $content[5] == '愛知県' ? 'selected' : "" ?>>愛知県</option>
                                            <option value="三重県" <?= $content[5] == '三重県' ? 'selected' : "" ?>>三重県</option>
                                            <option value="滋賀県" <?= $content[5] == '滋賀県' ? 'selected' : "" ?>>滋賀県</option>
                                            <option value="京都府" <?= $content[5] == '京都府' ? 'selected' : "" ?>>京都府</option>
                                            <option value="大阪府" <?= $content[5] == '大阪府' ? 'selected' : "" ?>>大阪府</option>
                                            <option value="兵庫県" <?= $content[5] == '兵庫県' ? 'selected' : "" ?>>兵庫県</option>
                                            <option value="奈良県" <?= $content[5] == '奈良県' ? 'selected' : "" ?>>奈良県</option>
                                            <option value="和歌山県" <?= $content[5] == '和歌山県' ? 'selected' : "" ?>>和歌山県</option>
                                            <option value="鳥取県" <?= $content[5] == '鳥取県' ? 'selected' : "" ?>>鳥取県</option>
                                            <option value="島根県" <?= $content[5] == '島根県' ? 'selected' : "" ?>>島根県</option>
                                            <option value="岡山県" <?= $content[5] == '岡山県' ? 'selected' : "" ?>>岡山県</option>
                                            <option value="広島県" <?= $content[5] == '広島県' ? 'selected' : "" ?>>広島県</option>
                                            <option value="山口県" <?= $content[5] == '山口県' ? 'selected' : "" ?>>山口県</option>
                                            <option value="徳島県" <?= $content[5] == '徳島県' ? 'selected' : "" ?>>徳島県</option>
                                            <option value="香川県" <?= $content[5] == '香川県' ? 'selected' : "" ?>>香川県</option>
                                            <option value="愛媛県" <?= $content[5] == '愛知県' ? 'selected' : "" ?>>愛媛県</option>
                                            <option value="高知県" <?= $content[5] == '高知県' ? 'selected' : "" ?>>高知県</option>
                                            <option value="福岡県" <?= $content[5] == '福岡県' ? 'selected' : "" ?>>福岡県</option>
                                            <option value="佐賀県" <?= $content[5] == '佐賀県' ? 'selected' : "" ?>>佐賀県</option>
                                            <option value="長崎県" <?= $content[5] == '長崎県' ? 'selected' : "" ?>>長崎県</option>
                                            <option value="熊本県" <?= $content[5] == '熊本県' ? 'selected' : "" ?>>熊本県</option>
                                            <option value="大分県" <?= $content[5] == '大分県' ? 'selected' : "" ?>>大分県</option>
                                            <option value="宮崎県" <?= $content[5] == '宮崎県' ? 'selected' : "" ?>>宮崎県</option>
                                            <option value="鹿児島県" <?= $content[5] == '鹿児島県' ? 'selected' : "" ?>>鹿児島県</option>
                                            <option value="沖縄県" <?= $content[5] == '沖縄県' ? 'selected' : "" ?>>沖縄県</option>
                                            <option value="その他" <?= $content[5] == 'その他' ? 'selected' : "" ?>>その他</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>出身地</td>
                                    <td>
                                        <select name="pref_name_from">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="北海道">北海道</option>
                                            <option value="青森県">青森県</option>
                                            <option value="岩手県">岩手県</option>
                                            <option value="宮城県">宮城県</option>
                                            <option value="秋田県">秋田県</option>
                                            <option value="山形県">山形県</option>
                                            <option value="福島県">福島県</option>
                                            <option value="茨城県">茨城県</option>
                                            <option value="栃木県">栃木県</option>
                                            <option value="群馬県">群馬県</option>
                                            <option value="埼玉県">埼玉県</option>
                                            <option value="千葉県">千葉県</option>
                                            <option value="東京都">東京都</option>
                                            <option value="神奈川県">神奈川県</option>
                                            <option value="新潟県">新潟県</option>
                                            <option value="富山県">富山県</option>
                                            <option value="石川県">石川県</option>
                                            <option value="福井県">福井県</option>
                                            <option value="山梨県">山梨県</option>
                                            <option value="長野県">長野県</option>
                                            <option value="岐阜県">岐阜県</option>
                                            <option value="静岡県">静岡県</option>
                                            <option value="愛知県">愛知県</option>
                                            <option value="三重県">三重県</option>
                                            <option value="滋賀県">滋賀県</option>
                                            <option value="京都府">京都府</option>
                                            <option value="大阪府">大阪府</option>
                                            <option value="兵庫県">兵庫県</option>
                                            <option value="奈良県">奈良県</option>
                                            <option value="和歌山県">和歌山県</option>
                                            <option value="鳥取県">鳥取県</option>
                                            <option value="島根県">島根県</option>
                                            <option value="岡山県">岡山県</option>
                                            <option value="広島県">広島県</option>
                                            <option value="山口県">山口県</option>
                                            <option value="徳島県">徳島県</option>
                                            <option value="香川県">香川県</option>
                                            <option value="愛媛県">愛媛県</option>
                                            <option value="高知県">高知県</option>
                                            <option value="福岡県">福岡県</option>
                                            <option value="佐賀県">佐賀県</option>
                                            <option value="長崎県">長崎県</option>
                                            <option value="熊本県">熊本県</option>
                                            <option value="大分県">大分県</option>
                                            <option value="宮崎県">宮崎県</option>
                                            <option value="鹿児島県">鹿児島県</option>
                                            <option value="沖縄県">沖縄県</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>血液型</td>
                                    <td><select name="bloodtype">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="O">O</option>
                                            <option value="AB">AB</option>
                                            <option value="不明">不明</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>星座</td>
                                    <td><select name="sign">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="牡羊座">牡羊座</option>
                                            <option value="牡牛座">牡牛座</option>
                                            <option value="双子座">双子座</option>
                                            <option value="蟹座">蟹座</option>
                                            <option value="獅子座">獅子座</option>
                                            <option value="乙女座">乙女座</option>
                                            <option value="天秤座">天秤座</option>
                                            <option value="蠍座">蠍座</option>
                                            <option value="射手座">射手座</option>
                                            <option value="山羊座">山羊座</option>
                                            <option value="水瓶座">水瓶座</option>
                                            <option value="魚座">魚座</option>
                                            <option value="ナイショ">ナイショ</option>
                                        </select>
                                    </td>
                                </tr>
                                <th colspan="2">外見</th>
                                <tr>
                                    <td>身長</td>
                                    <td><select name="height">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="~149">~149</option>
                                            <option value="150~154">150~154</option>
                                            <option value="155~159">155~159</option>
                                            <option value="160~164">160~164</option>
                                            <option value="165~169">165~169</option>
                                            <option value="170~174">170~174</option>
                                            <option value="175~179">175~179</option>
                                            <option value="180~184">180~184</option>
                                            <option value="185~">185~</option>
                                            <option value="ヒミツ">ヒミツ</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>スタイル</td>
                                    <td><select name="style">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="細型">細型</option>
                                            <option value="やや細型">やや細型</option>
                                            <option value="普通">普通</option>
                                            <option value="ややぽっちゃり">ややぽっちゃり</option>
                                            <option value="ぽっちゃり">ぽっちゃり</option>
                                            <option value="ヒミツ">ヒミツ</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>ルックス</td>
                                    <td><select name="looks">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="さわやか系">さわやか系</option>
                                            <option value="かわいい系">かわいい系</option>
                                            <option value="ワイルド系">ワイルド系</option>
                                            <option value="いやし系">いやし系</option>
                                            <option value="カジュアル系">カジュアル系</option>
                                            <option value="ギャル系">ギャル系</option>
                                            <option value="ヒミツ">ヒミツ</option>
                                        </select></td>
                                </tr>
                                <th colspan="2">仕事・学歴</th>
                                <tr>
                                    <td>職業</td>
                                    <td><select name="job">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="公務員">公務員</option>
                                            <option value="経営者・役員">経営者・役員</option>
                                            <option value="会社員">会社員</option>
                                            <option value="自営業">自営業</option>
                                            <option value="自由業">自由業</option>
                                            <option value="専業主婦">専業主婦</option>
                                            <option value="パート・アルバイト">パート・アルバイト</option>
                                            <option value="学生">学生</option>
                                            <option value="その他">その他</option>
                                            <option value="ヒミツ">ヒミツ</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>年収</td>
                                    <td><select name="income">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="100万円以下">100万円以下</option>
                                            <option value="100~300万円">100~300万円</option>
                                            <option value="300~600万円">300~600万円</option>
                                            <option value="600~1000万円">600~1000万円</option>
                                            <option value="1000~2000万円">1000~2000万円</option>
                                            <option value="2000~5000万円">2000~5000万円</option>
                                            <option value="5000万円以上">5000万円以上</option>
                                            <option value="ヒミツ">ヒミツ</option>
                                        </select></td>
                                </tr>
                                <th colspan="2">ライフスタイル</th>
                                <tr>
                                    <td>交際ステータタス</td>
                                    <td><select name="marriage">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="独身">独身</option>
                                            <option value="既婚">既婚</option>
                                            <option value="バツあり">バツあり</option>
                                            <option value="交際中">交際中</option>
                                            <option value="複雑な関係">複雑な関係</option>
                                            <option value="別居中">別居中</option>
                                            <option value="ヒミツ">ヒミツ</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>子ども</td>
                                    <td><select name="child">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="いる">いる</option>
                                            <option value="いない">いない</option>
                                            <option value="ヒミツ">ヒミツ</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>タバコ</td>
                                    <td><select name="cigarette">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="吸う">吸う</option>
                                            <option value="吸わない">吸わない</option>
                                            <option value="ヒミツ">ヒミツ</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>お酒</td>
                                    <td><select name="alcohol">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="飲む">飲む</option>
                                            <option value="時々飲む">時々飲む</option>
                                            <option value="たしなむ程度">たしなむ程度</option>
                                            <option value="飲まない">飲まない</option>
                                            <option value="ヒミツ">ヒミツ</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>クルマ</td>
                                    <td><select name="car">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="ある">ある</option>
                                            <option value="ない">ない</option>
                                            <option value="ヒミツ">ヒミツ</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>同居人</td>
                                    <td><select name="people">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="一人暮らし">一人暮らし</option>
                                            <option value="実家暮らし">実家暮らし</option>
                                            <option value="友達と一緒">友達と一緒</option>
                                            <option value="ペットと一緒">ペットと一緒</option>
                                            <option value="兄弟と一緒">兄弟と一緒</option>
                                            <option value="家族と一緒">兄弟と一緒</option>
                                            <option value="その他">その他</option>
                                            <option value="ヒミツ">ヒミツ</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>兄弟関係</td>
                                    <td><select name="brother">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="長男">長男</option>
                                            <option value="間っ子">間っ子</option>
                                            <option value="末っ子">末っ子</option>
                                            <option value="一人っ子">一人っ子</option>
                                            <option value="ヒミツ">ヒミツ</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>出会うまでの希望</td>
                                    <td><select name="meet">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="まずは会いたい">まずは会いたい</option>
                                            <option value="気が合えば会いたい">気が合えば会いたい</option>
                                            <option value="メッセージ交換を重ねてから">メッセージ交換を重ねてから</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>初回デート費用</td>
                                    <td><select name="cost">
                                            <option value="指定しない" selected>指定しない</option>
                                            <option value="男性が全て払う">男性が全て払う</option>
                                            <option value="男性が多めに払う">男性が多めに払う</option>
                                            <option value="割り勘">割り勘</option>
                                            <option value="持っている人が払う">持っている人が払う</option>
                                            <option value="相手と相談して決める">相手と相談して決める</option>
                                        </select></td>
                                </tr>
                            </table>
                            </br>
                            <div class="button"><input type="submit" value="検索"></div>
                        </form>
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
                                <li><a href="payment">ご利用料金</a></li>
                                <li><a href="howToPay">お支払い方法</a></li>
                                <li><a href="back.php">料金の払い戻し</a></li>
                            </ul>
                        </div>
                        <div class="menu-right">
                            <h3>個人情報の取り扱い</h3>
                            <ul class="foot-right">
                                <li><a href="policy.php">プライバシーポリシー</a></li>
                                <li><a href="law.php">特定商取引法に基づく表記</a></li>
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

<div class="footer-wrapper">
    <footer>
        <p><small>&copy; マッチングナビ 2020</small></p>
    </footer>
</div>

</html>