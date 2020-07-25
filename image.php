<?php
//配列の要素が定義されているか
    //画像ファイルの情報
    $tempfile = $_FILES['myImage']['tmp_name'];
    $filename = './image/' . $_FILES['myImage']['name'];

    //画像ファイルが本当にアップロードされたか
    if (is_uploaded_file($tempfile)) {
        if (move_uploaded_file($tempfile, $filename)) {
            echo $filename . "をアップロードしました。";
        } else {
            echo "ファイルをアップロードできません。";
        }
    } else {
        //男性か女性かで分けるようにしたい
        $filename = './image/unknown.jpg';
        echo "ファイルが選択されていません。";
    }

    //入力データの書き込み
    //ファイルへ書き込み
    //r/w/a: 読み/書き/上書き
    $fp = fopen("./profileImage.csv", "a+");
    //ファイルの排他ロック
    flock($fp, LOCK_EX);
    //出力データ生成
    $output = join(",", array($filename)) . "\n";
    //ファイルに書き込み
    fputs($fp, $output);
    //ロック解除
    flock($fp, LOCK_UN);
    fclose($fp);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>完了</title>
</head>

<body>
        <header>
            <h1>プロフィール編集完了</h1>
            編集内容は以下の通りです。
        </header>
        <p>
            画像: <?php echo $filename ?><br>
        </p>
        <p>
            <a href="./profile.php" target="_self">プロフィール確認</a><br>
            <a href="./profileImage.html" target="_self">もう一度画像を選択する</a>
        </p>
    <footer>
        <p><small>&copy; マッチングナビ 2020 仮</small></p>
    </footer>
</body>

</html>