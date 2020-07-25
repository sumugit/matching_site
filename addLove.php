<?php
// 画面から送られたきた値
$mine = filter_input(INPUT_POST, 'mine');
$opponent = filter_input(INPUT_POST, 'opponent');

if (is_file("./csv/love.csv")) { //登録ファイルが存在するか
    if (is_readable("./csv/love.csv")) { //登録ファイルを読み込めるか
        $fp = fopen("./csv/love.csv", "r");
        flock($fp, LOCK_SH);
        $flagGood = false;
        //idが登録ユーザーと一致するまで一行ずつ取り出す
        while (!feof($fp)) {
            $content = fgetcsv($fp);
            //もし以前にいいねをそのアカウントに押していたら
            if ($content[0] == $mine && $content[1] == $opponent) {
                $flagGood = true;
                break;
            }
        }
        //登録ファイルを閉じる
        flock($fp, LOCK_UN);
        fclose($fp);
        //そのアカウントにまだいいねしたことが無い
        if ($flagGood == false) {
            $fp = fopen("./csv/love.csv", "a+");
            //ファイルの排他ロック
            flock($fp, LOCK_EX);
            //ファイルに書き込み
            fputcsv($fp, array($mine, $opponent));
            //ロック解除
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    } else {
        echo "ファイルが開けません。";
        exit();
    }
} else {
    echo "ファイルがありません。";
    exit();
}

$list = array("mine" => $mine, "opponent" => $opponent);
// 明示的に指定しない場合は、text/html型と判断される
header("Content-type: application/json; charset=UTF-8");
//JSONデータを出力
echo json_encode($list);
exit;
