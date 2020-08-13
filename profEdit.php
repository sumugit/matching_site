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
    <title>プロフィール編集</title>
    <!--入力画像のプレビューを行うjs-->
    <script>
        function previewImage(obj) {
            var fileReader = new FileReader();
            fileReader.onload = (function() {
                document.getElementById('preview').src = fileReader.result;
            });
            fileReader.readAsDataURL(obj.files[0]);
        }
    </script>
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
                            } else {
                                header("Location: fileError.php");
                                exit();
                            }
                        } else {
                            header("Location: fileError.php");
                            exit();
                        }
                        ?>
                        <!--form part-->
                        <p><a href="javascript:history.back();" class="btn-flat-BackAll"><i class="fa fa-chevron-left"></i>戻る</a></p>
                        <br><br><br>
                            <form method="POST" action="./complete.php" enctype=multipart/form-data> <!--画像ファイルの入力-->
                                <table>
                                    <th colspan="2">自分の写真</th>
                                    <div class="poscenter">
                                        <tr>
                                            <td colspan="2"><input type="file" name="myImage" accept='image/*' onchange="previewImage(this);">
                                                <p>
                                                    Preview:<br>
                                                    <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:200px;">
                                                </p>

                                            </td>
                                        </tr>
                                    </div>
                                    <!--テキスト入力-->
                                    <th colspan="2">自己紹介</th>
                                    <tr>
                                        <td colspan="2"><textarea name="message" rows="4" cols="60" maxlength="150"><?php echo $content[2] ?></textarea></td>
                                    </tr>
                                    <th colspan="2">基本情報</th>
                                    <tr>
                                        <!--テキスト入力-->
                                        <td>ニックネーム</td>
                                        <td>
                                            <div class="cp_iptxt">
                                                <label class="ef">
                                                    <input type="text" name="nickname" placeholder="マッチング太郎" value=<?php echo $content[3] ?> required>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <!--以下セレクトボックス-->
                                    <tr>
                                        <td>年齢</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="old">
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
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>居住地</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
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
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>出身地</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="pref_name_from">
                                                    <option value="指定しない" <?= $content[6] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="北海道" <?= $content[6] == '北海道' ? 'selected' : "" ?>>北海道</option>
                                                    <option value="青森県" <?= $content[6] == '青森県' ? 'selected' : "" ?>>青森県</option>
                                                    <option value="岩手県" <?= $content[6] == '岩手県' ? 'selected' : "" ?>>岩手県</option>
                                                    <option value="宮城県" <?= $content[6] == '宮城県' ? 'selected' : "" ?>>宮城県</option>
                                                    <option value="秋田県" <?= $content[6] == '秋田県' ? 'selected' : "" ?>>秋田県</option>
                                                    <option value="山形県" <?= $content[6] == '山形県' ? 'selected' : "" ?>>山形県</option>
                                                    <option value="福島県" <?= $content[6] == '福島県' ? 'selected' : "" ?>>福島県</option>
                                                    <option value="茨城県" <?= $content[6] == '茨城県' ? 'selected' : "" ?>>茨城県</option>
                                                    <option value="栃木県" <?= $content[6] == '栃木県' ? 'selected' : "" ?>>栃木県</option>
                                                    <option value="群馬県" <?= $content[6] == '群馬県' ? 'selected' : "" ?>>群馬県</option>
                                                    <option value="埼玉県" <?= $content[6] == '埼玉県' ? 'selected' : "" ?>>埼玉県</option>
                                                    <option value="千葉県" <?= $content[6] == '千葉県' ? 'selected' : "" ?>>千葉県</option>
                                                    <option value="東京都" <?= $content[6] == '東京都' ? 'selected' : "" ?>>東京都</option>
                                                    <option value="神奈川県" <?= $content[6] == '神奈川県' ? 'selected' : "" ?>>神奈川県</option>
                                                    <option value="新潟県" <?= $content[6] == '新潟県' ? 'selected' : "" ?>>新潟県</option>
                                                    <option value="富山県" <?= $content[6] == '富山県' ? 'selected' : "" ?>>富山県</option>
                                                    <option value="石川県" <?= $content[6] == '石川県' ? 'selected' : "" ?>>石川県</option>
                                                    <option value="福井県" <?= $content[6] == '福井県' ? 'selected' : "" ?>>福井県</option>
                                                    <option value="山梨県" <?= $content[6] == '山梨県' ? 'selected' : "" ?>>山梨県</option>
                                                    <option value="長野県" <?= $content[6] == '長野県' ? 'selected' : "" ?>>長野県</option>
                                                    <option value="岐阜県" <?= $content[6] == '岐阜県' ? 'selected' : "" ?>>岐阜県</option>
                                                    <option value="静岡県" <?= $content[6] == '静岡県' ? 'selected' : "" ?>>静岡県</option>
                                                    <option value="愛知県" <?= $content[6] == '愛知県' ? 'selected' : "" ?>>愛知県</option>
                                                    <option value="三重県" <?= $content[6] == '三重県' ? 'selected' : "" ?>>三重県</option>
                                                    <option value="滋賀県" <?= $content[6] == '滋賀県' ? 'selected' : "" ?>>滋賀県</option>
                                                    <option value="京都府" <?= $content[6] == '京都府' ? 'selected' : "" ?>>京都府</option>
                                                    <option value="大阪府" <?= $content[6] == '大阪府' ? 'selected' : "" ?>>大阪府</option>
                                                    <option value="兵庫県" <?= $content[6] == '兵庫県' ? 'selected' : "" ?>>兵庫県</option>
                                                    <option value="奈良県" <?= $content[6] == '奈良県' ? 'selected' : "" ?>>奈良県</option>
                                                    <option value="和歌山県" <?= $content[6] == '和歌山県' ? 'selected' : "" ?>>和歌山県</option>
                                                    <option value="鳥取県" <?= $content[6] == '鳥取県' ? 'selected' : "" ?>>鳥取県</option>
                                                    <option value="島根県" <?= $content[6] == '島根県' ? 'selected' : "" ?>>島根県</option>
                                                    <option value="岡山県" <?= $content[6] == '岡山県' ? 'selected' : "" ?>>岡山県</option>
                                                    <option value="広島県" <?= $content[6] == '広島県' ? 'selected' : "" ?>>広島県</option>
                                                    <option value="山口県" <?= $content[6] == '山口県' ? 'selected' : "" ?>>山口県</option>
                                                    <option value="徳島県" <?= $content[6] == '徳島県' ? 'selected' : "" ?>>徳島県</option>
                                                    <option value="香川県" <?= $content[6] == '香川県' ? 'selected' : "" ?>>香川県</option>
                                                    <option value="愛媛県" <?= $content[6] == '愛知県' ? 'selected' : "" ?>>愛媛県</option>
                                                    <option value="高知県" <?= $content[6] == '高知県' ? 'selected' : "" ?>>高知県</option>
                                                    <option value="福岡県" <?= $content[6] == '福岡県' ? 'selected' : "" ?>>福岡県</option>
                                                    <option value="佐賀県" <?= $content[6] == '佐賀県' ? 'selected' : "" ?>>佐賀県</option>
                                                    <option value="長崎県" <?= $content[6] == '長崎県' ? 'selected' : "" ?>>長崎県</option>
                                                    <option value="熊本県" <?= $content[6] == '熊本県' ? 'selected' : "" ?>>熊本県</option>
                                                    <option value="大分県" <?= $content[6] == '大分県' ? 'selected' : "" ?>>大分県</option>
                                                    <option value="宮崎県" <?= $content[6] == '宮崎県' ? 'selected' : "" ?>>宮崎県</option>
                                                    <option value="鹿児島県" <?= $content[6] == '鹿児島県' ? 'selected' : "" ?>>鹿児島県</option>
                                                    <option value="沖縄県" <?= $content[6] == '沖縄県' ? 'selected' : "" ?>>沖縄県</option>
                                                    <option value="その他" <?= $content[6] == 'その他' ? 'selected' : "" ?>>その他</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>血液型</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="bloodtype">
                                                    <option value="指定しない" <?= $content[7] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="A" <?= $content[7] == 'A' ? 'selected' : "" ?>>A</option>
                                                    <option value="B" <?= $content[7] == 'B' ? 'selected' : "" ?>>B</option>
                                                    <option value="O" <?= $content[7] == 'O' ? 'selected' : "" ?>>O</option>
                                                    <option value="AB" <?= $content[7] == 'AB' ? 'selected' : "" ?>>AB</option>
                                                    <option value="不明" <?= $content[7] == '不明' ? 'selected' : "" ?>>不明</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>星座</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="sign">
                                                    <option value="指定しない" <?= $content[8] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="牡羊座" <?= $content[8] == '牡羊座' ? 'selected' : "" ?>>牡羊座</option>
                                                    <option value="牡牛座" <?= $content[8] == '牡牛座' ? 'selected' : "" ?>>牡牛座</option>
                                                    <option value="双子座" <?= $content[8] == '双子座' ? 'selected' : "" ?>>双子座</option>
                                                    <option value="蟹座" <?= $content[8] == '蟹座' ? 'selected' : "" ?>>蟹座</option>
                                                    <option value="獅子座" <?= $content[8] == '獅子座' ? 'selected' : "" ?>>獅子座</option>
                                                    <option value="乙女座" <?= $content[8] == '乙女座' ? 'selected' : "" ?>>乙女座</option>
                                                    <option value="天秤座" <?= $content[8] == '天秤座' ? 'selected' : "" ?>>天秤座</option>
                                                    <option value="蠍座" <?= $content[8] == '蠍座' ? 'selected' : "" ?>>蠍座</option>
                                                    <option value="射手座" <?= $content[8] == '射手座' ? 'selected' : "" ?>>射手座</option>
                                                    <option value="山羊座" <?= $content[8] == '山羊座' ? 'selected' : "" ?>>山羊座</option>
                                                    <option value="水瓶座" <?= $content[8] == '水瓶座' ? 'selected' : "" ?>>水瓶座</option>
                                                    <option value="魚座" <?= $content[8] == '魚座' ? 'selected' : "" ?>>魚座</option>
                                                    <option value="ナイショ" <?= $content[8] == 'ナイショ' ? 'selected' : "" ?>>ナイショ</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <th colspan="2">外見</th>
                                    <tr>
                                        <td>身長</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="height">
                                                    <option value="指定しない" <?= $content[9] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="~149" <?= $content[9] == '~149' ? 'selected' : "" ?>>~149</option>
                                                    <option value="150~154" <?= $content[9] == '150~154' ? 'selected' : "" ?>>150~154</option>
                                                    <option value="155~159" <?= $content[9] == '155~159' ? 'selected' : "" ?>>155~159</option>
                                                    <option value="160~164" <?= $content[9] == '160~164' ? 'selected' : "" ?>>160~164</option>
                                                    <option value="165~169" <?= $content[9] == '165~169' ? 'selected' : "" ?>>165~169</option>
                                                    <option value="170~174" <?= $content[9] == '170~174' ? 'selected' : "" ?>>170~174</option>
                                                    <option value="175~179" <?= $content[9] == '175~179' ? 'selected' : "" ?>>175~179</option>
                                                    <option value="180~184" <?= $content[9] == '180~184' ? 'selected' : "" ?>>180~184</option>
                                                    <option value="185~" <?= $content[9] == '185~' ? 'selected' : "" ?>>185~</option>
                                                    <option value="ヒミツ" <?= $content[9] == 'ヒミツ' ? 'selected' : "" ?>>ヒミツ</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>スタイル</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="style">
                                                    <option value="指定しない" <?= $content[10] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="細型" <?= $content[10] == '細型' ? 'selected' : "" ?>>細型</option>
                                                    <option value="やや細型" <?= $content[10] == 'やや細型' ? 'selected' : "" ?>>やや細型</option>
                                                    <option value="普通" <?= $content[10] == '普通' ? 'selected' : "" ?>>普通</option>
                                                    <option value="ややぽっちゃり" <?= $content[10] == 'ややぽっちゃり' ? 'selected' : "" ?>>ややぽっちゃり</option>
                                                    <option value="ぽっちゃり" <?= $content[10] == 'ぽっちゃり' ? 'selected' : "" ?>>ぽっちゃり</option>
                                                    <option value="ヒミツ" <?= $content[10] == 'ヒミツ' ? 'selected' : "" ?>>ヒミツ</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>ルックス</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="looks">
                                                    <option value="指定しない" <?= $content[11] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="さわやか系" <?= $content[11] == 'さわやか系' ? 'selected' : "" ?>>さわやか系</option>
                                                    <option value="かわいい系" <?= $content[11] == 'かわいい系' ? 'selected' : "" ?>>かわいい系</option>
                                                    <option value="ワイルド系" <?= $content[11] == 'ワイルド系' ? 'selected' : "" ?>>ワイルド系</option>
                                                    <option value="いやし系" <?= $content[11] == 'いやし系' ? 'selected' : "" ?>>いやし系</option>
                                                    <option value="カジュアル系" <?= $content[11] == 'カジュアル系' ? 'selected' : "" ?>>カジュアル系</option>
                                                    <option value="ギャル系" <?= $content[11] == 'ギャル系' ? 'selected' : "" ?>>ギャル系</option>
                                                    <option value="ヒミツ" <?= $content[11] == 'ヒミツ' ? 'selected' : "" ?>>ヒミツ</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <th colspan="2">仕事・学歴</th>
                                    <tr>
                                        <td>職業</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="job">
                                                    <option value="指定しない" <?= $content[12] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="公務員" <?= $content[12] == '公務員' ? 'selected' : "" ?>>公務員</option>
                                                    <option value="経営者・役員" <?= $content[12] == '経営者・役員' ? 'selected' : "" ?>>経営者・役員</option>
                                                    <option value="会社員" <?= $content[12] == '会社員' ? 'selected' : "" ?>>会社員</option>
                                                    <option value="自営業" <?= $content[12] == '自営業' ? 'selected' : "" ?>>自営業</option>
                                                    <option value="自由業" <?= $content[12] == '自由業' ? 'selected' : "" ?>>自由業</option>
                                                    <option value="専業主婦" <?= $content[12] == '専業主婦' ? 'selected' : "" ?>>専業主婦</option>
                                                    <option value="パート・アルバイト" <?= $content[12] == 'パート・アルバイト' ? 'selected' : "" ?>>パート・アルバイト</option>
                                                    <option value="学生" <?= $content[12] == '学生' ? 'selected' : "" ?>>学生</option>
                                                    <option value="その他" <?= $content[12] == 'その他' ? 'selected' : "" ?>>その他</option>
                                                    <option value="ヒミツ" <?= $content[12] == 'ヒミツ' ? 'selected' : "" ?>>ヒミツ</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>年収</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="income">
                                                    <option value="指定しない" <?= $content[13] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="100万円以下" <?= $content[13] == '100万円以下' ? 'selected' : "" ?>>100万円以下</option>
                                                    <option value="100~300万円" <?= $content[13] == '100~300万円' ? 'selected' : "" ?>>100~300万円</option>
                                                    <option value="300~600万円" <?= $content[13] == '300~600万円' ? 'selected' : "" ?>>300~600万円</option>
                                                    <option value="600~1000万円" <?= $content[13] == '600~1000万円' ? 'selected' : "" ?>>600~1000万円</option>
                                                    <option value="1000~2000万円" <?= $content[13] == '1000~2000万円' ? 'selected' : "" ?>>1000~2000万円</option>
                                                    <option value="2000~5000万円" <?= $content[13] == '2000~5000万円' ? 'selected' : "" ?>>2000~5000万円</option>
                                                    <option value="5000万円以上" <?= $content[13] == '5000万円以上' ? 'selected' : "" ?>>5000万円以上</option>
                                                    <option value="ヒミツ" <?= $content[13] == 'ヒミツ' ? 'selected' : "" ?>>ヒミツ</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <th colspan="2">ライフスタイル</th>
                                    <tr>
                                        <td>交際ステータタス</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="marriage">
                                                    <option value="指定しない" <?= $content[14] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="独身" <?= $content[14] == '独身' ? 'selected' : "" ?>>独身</option>
                                                    <option value="既婚" <?= $content[14] == '既婚' ? 'selected' : "" ?>>既婚</option>
                                                    <option value="バツあり" <?= $content[14] == 'バツあり' ? 'selected' : "" ?>>バツあり</option>
                                                    <option value="交際中" <?= $content[14] == '交際中' ? 'selected' : "" ?>>交際中</option>
                                                    <option value="複雑な関係" <?= $content[14] == '複雑な関係' ? 'selected' : "" ?>>複雑な関係</option>
                                                    <option value="別居中" <?= $content[14] == '別居中' ? 'selected' : "" ?>>別居中</option>
                                                    <option value="ヒミツ" <?= $content[14] == 'ヒミツ' ? 'selected' : "" ?>>ヒミツ</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>子ども</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="child">
                                                    <option value="指定しない" <?= $content[15] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="いる" <?= $content[15] == 'いる' ? 'selected' : "" ?>>いる</option>
                                                    <option value="いない" <?= $content[15] == 'いない' ? 'selected' : "" ?>>いない</option>
                                                    <option value="ヒミツ" <?= $content[15] == 'ヒミツ' ? 'selected' : "" ?>>ヒミツ</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>タバコ</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="cigarette">
                                                    <option value="指定しない" <?= $content[16] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="吸う" <?= $content[16] == '吸う' ? 'selected' : "" ?>>吸う</option>
                                                    <option value="吸わない" <?= $content[16] == '吸わない' ? 'selected' : "" ?>>吸わない</option>
                                                    <option value="ヒミツ" <?= $content[16] == 'ヒミツ' ? 'selected' : "" ?>>ヒミツ</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>お酒</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="alcohol">
                                                    <option value="指定しない" <?= $content[17] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="飲む" <?= $content[17] == '飲む' ? 'selected' : "" ?>>飲む</option>
                                                    <option value="時々飲む" <?= $content[17] == '時々飲む' ? 'selected' : "" ?>>時々飲む</option>
                                                    <option value="たしなむ程度" <?= $content[17] == 'たしなむ程度' ? 'selected' : "" ?>>たしなむ程度</option>
                                                    <option value="飲まない" <?= $content[17] == '飲まない' ? 'selected' : "" ?>>飲まない</option>
                                                    <option value="ヒミツ" <?= $content[17] == 'ヒミツ' ? 'selected' : "" ?>>ヒミツ</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>クルマ</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="car">
                                                    <option value="指定しない" <?= $content[18] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="ある" <?= $content[18] == 'ある' ? 'selected' : "" ?>>ある</option>
                                                    <option value="ない" <?= $content[18] == 'ない' ? 'selected' : "" ?>>ない</option>
                                                    <option value="ヒミツ" <?= $content[18] == 'ヒミツ' ? 'selected' : "" ?>>ヒミツ</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>同居人</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="people">
                                                    <option value="指定しない" <?= $content[19] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="一人暮らし" <?= $content[19] == '一人暮らし' ? 'selected' : "" ?>>一人暮らし</option>
                                                    <option value="実家暮らし" <?= $content[19] == '実家暮らし' ? 'selected' : "" ?>>実家暮らし</option>
                                                    <option value="友達と一緒" <?= $content[19] == '友達と一緒' ? 'selected' : "" ?>>友達と一緒</option>
                                                    <option value="ペットと一緒" <?= $content[19] == 'ペットと一緒' ? 'selected' : "" ?>>ペットと一緒</option>
                                                    <option value="兄弟と一緒" <?= $content[19] == '兄弟と一緒' ? 'selected' : "" ?>>兄弟と一緒</option>
                                                    <option value="家族と一緒" <?= $content[19] == '家族と一緒' ? 'selected' : "" ?>>兄弟と一緒</option>
                                                    <option value="その他" <?= $content[19] == 'その他' ? 'selected' : "" ?>>その他</option>
                                                    <option value="ヒミツ" <?= $content[19] == 'ヒミツ' ? 'selected' : "" ?>>ヒミツ</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>兄弟関係</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="brother">
                                                    <option value="指定しない" <?= $content[20] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="長男" <?= $content[20] == '長男' ? 'selected' : "" ?>>長男</option>
                                                    <option value="間っ子" <?= $content[20] == '間っ子' ? 'selected' : "" ?>>間っ子</option>
                                                    <option value="末っ子" <?= $content[20] == '末っ子' ? 'selected' : "" ?>>末っ子</option>
                                                    <option value="一人っ子" <?= $content[20] == '一人っ子' ? 'selected' : "" ?>>一人っ子</option>
                                                    <option value="ヒミツ" <?= $content[20] == 'ヒミツ' ? 'selected' : "" ?>>ヒミツ</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <th colspan="2">相手に求める条件</th>
                                    <tr>
                                        <td>出会うまでの希望</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="meet">
                                                    <option value="指定しない" <?= $content[21] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="まずは会いたい" <?= $content[21] == 'まずは会いたい' ? 'selected' : "" ?>>まずは会いたい</option>
                                                    <option value="気が合えば会いたい" <?= $content[21] == '気が合えば会いたい' ? 'selected' : "" ?>>気が合えば会いたい</option>
                                                    <option value="メッセージ交換を重ねてから" <?= $content[21] == 'メッセージ交換を重ねてから' ? 'selected' : "" ?>>メッセージ交換を重ねてから</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>初回デート費用</td>
                                        <td>
                                            <div class="cp_ipselect cp_sl01">
                                                <select name="cost">
                                                    <option value="指定しない" <?= $content[22] == '指定しない' ? 'selected' : "" ?>>指定しない</option>
                                                    <option value="男性が全て払う" <?= $content[22] == '男性が全て払う' ? 'selected' : "" ?>>男性が全て払う</option>
                                                    <option value="男性が多めに払う" <?= $content[22] == '男性が多めに払う' ? 'selected' : "" ?>>男性が多めに払う</option>
                                                    <option value="割り勘" <?= $content[22] == '割り勘' ? 'selected' : "" ?>>割り勘</option>
                                                    <option value="持っている人が払う" <?= $content[22] == '持っている人が払う' ? 'selected' : "" ?>>持っている人が払う</option>
                                                    <option value="相手と相談して決める" <?= $content[22] == '相手と相談して決める' ? 'selected' : "" ?>>相手と相談して決める</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                </br>
                                <div class="button"><input type="submit" value="完了"></div>
                                </br>
                            </form>
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