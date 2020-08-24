<?php
$testFile = "./csv/bulletinLog.csv";
$index = filter_input(INPUT_POST, 'index');
$mine = filter_input(INPUT_POST, 'mine');
$message = filter_input(INPUT_POST, 'message');
$mode = filter_input(INPUT_POST, 'mode');
//投稿時間はここで取得する
date_default_timezone_get('Asia/Tokyo');
$time = date("Y/m/j H:i:s");
if ($mode == "0") {
    if (is_file("./csv/profile.csv")) { //登録ファイルが存在するか
        if (is_readable("./csv/profile.csv")) { //登録ファイルを読み込めるか
            $fp = fopen("./csv/profile.csv", "r");
            flock($fp, LOCK_SH);
            //idが自分のアカウントと一致するまで一行ずつ取り出す
            while (!feof($fp)) {
                $content = fgetcsv($fp);
                //閲覧しているユーザーの情報を取得
                if ($content[0] == $mine) {
                    break;
                }
            }
            //ファイルを閉じる
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


    // ファイルにデータを書き込み
    if (!empty($content)) {
        // ファイルをオープンできたか(a+にする必要あり)
        if (!$fp = fopen($testFile, "a+")) {
            echo "could not open";
            exit;
        }
        //ファイルロック
        flock($fp, LOCK_SH);
        $array = array();
        while (!feof($fp)) {
            array_push($array, fgetcsv($fp));
        }
        //一旦ファイルを空にする
        ftruncate($fp, 0);
        //もう一度呼ぶ必要あり
        $fp = fopen($testFile, "a+");
        //新たなメッセージを追加する
        for ($i = 0; $i < count($array) - 1; $i++) {
            //編集した情報を更新(ユニークなidが一致すればよい)
            if ($array[$i][0] == $index) {
                //投稿の連番
                $array[$i][4] = $array[$i][4] + 1;
                //投稿内容
                $inputValue = "<div class='left-margin'><p>" . $array[$i][4] . ": <strong>名前 : " . $content[3] . "</strong><br><img src = '$content[1]' align='left' width='64' height='64' class='userImage' alt=''>投稿日時 : <time>" . $time . "</time><br>" . $message . "<br><br></p></div><hr color='#00bfff'>";
                //正規表現で改行コードを置換(複数行入力できるようにする)
                $inputValue = preg_replace("/\r|\n|\r\n/", "<br>", $inputValue);
                //csvなので,は、に変換
                $inputValue = preg_replace("/,/", "、", $inputValue);
                //メッセージ追加(文字列の連結)
                $array[$i][5] = $array[$i][5] . $inputValue;
            }
            //ファイルに書き込み
            fputcsv($fp, array($array[$i][0], $array[$i][1], $array[$i][2], $array[$i][3], $array[$i][4], $array[$i][5]));
        }
        //ロック解除
        // 書き込み終了
        flock($fp, LOCK_UN);
        fclose($fp);
    } else {
        echo "not writable";
        exit;
    }

    //参照しているindexのメッセージだけ取り出す
    if (is_file($testFile)) { //登録ファイルが存在するか
        if (is_readable($testFile)) { //登録ファイルを読み込めるか
            $fp = fopen($testFile, "r");
            flock($fp, LOCK_SH);
            //indexが一致するまで一行ずつ取り出す
            while (!feof($fp)) {
                $content = fgetcsv($fp);
                //閲覧しているindexの情報を取得
                if ($content[0] == $index) {
                    break;
                }
            }
            //ファイルを閉じる
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

    //最終的に返すテキスト
    echo $content[5];
    exit;
} else {
    //自分のidのメッセージだけ取り出す
    if (is_file($testFile)) { //登録ファイルが存在するか
        if (is_readable($testFile)) { //登録ファイルを読み込めるか
            $fp = fopen($testFile, "r");
            flock($fp, LOCK_SH);
            //idが相手のアカウントと一致するまで一行ずつ取り出す
            while (!feof($fp)) {
                $content = fgetcsv($fp);
                //閲覧しているユーザーの情報を取得
                if ($content[0] == $index) {
                    break;
                }
            }
            //ファイルを閉じる
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
    echo $content[5];
    exit;
}
