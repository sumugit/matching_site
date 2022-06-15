<?php
$testFile = "./csv/chatLog.csv";
$mine = filter_input(INPUT_POST, 'mine');
$opponent = filter_input(INPUT_POST, 'opponent');
$nickname = filter_input(INPUT_POST, 'nickname');
$message = filter_input(INPUT_POST, 'message');
$mode = filter_input(INPUT_POST, 'mode');
if ($mode == "0") {
    if (is_file("./csv/profile.csv")) { //登録ファイルが存在するか
        if (is_readable("./csv/profile.csv")) { //登録ファイルを読み込めるか
            $fp = fopen("./csv/profile.csv", "r");
            flock($fp, LOCK_SH);
            //idが相手のアカウントと一致するまで一行ずつ取り出す
            while (!feof($fp)) {
                $content = fgetcsv($fp);
                //閲覧しているユーザーの情報を取得
                if ($content[0] == $opponent) {
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

    //自分から相手(メッセージは右側)
    $inputValueMine = "<div class='right'>" . $nickname . "</div><div class='right_balloon'>" . $message . "</div>";
    //csvなので,は、に変換
    $inputValueMine = preg_replace("/,/", "、", $inputValueMine);
    //相手から自分(メッセージは左側)
    $inputValueOpponent = "<div class='left'>" . $nickname . "</div><div class='left_balloon'>" . $message . "</div>";
    $inputValueOpponent = preg_replace("/,/", "、", $inputValueOpponent);
    //以前にメッセージをやり取りした履歴があるか
    $flag = false;

    // ファイルにデータを書き込み
    if ($inputValueMine) {
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
        //もし以前にやり取りがあれば,新たなメッセージを追加する
        for ($i = 0; $i < count($array)-1; $i++) {
            //編集した情報を更新(ユニークなidが一致すればよい)
            if ($array[$i][0] == $mine) {
                $flag = true;
                //メッセージ追加(文字列の連結)(自分側)
                $array[$i][2] = $array[$i][2] . $inputValueMine;
            }
            else if ($array[$i][0] == $opponent) {
                $flag = true;
                //メッセージ追加(文字列の連結)(相手側)
                $array[$i][2] = $array[$i][2] . $inputValueOpponent;
            }
            //ファイルに書き込み
            fputcsv($fp, array($array[$i][0], $array[$i][1], $array[$i][2]));
        }
        if ($flag == false) {
            print count($array);
            //ファイルに書き込み
            //自分から相手
            fputcsv($fp, array($mine, $opponent, $inputValueMine));
            //相手から自分
            fputcsv($fp, array($opponent, $mine, $inputValueOpponent));
        }
        //ロック解除
        // 書き込み終了
        flock($fp, LOCK_UN);
        fclose($fp);
    } else {
        echo "not writable";
        exit;
    }



    //自分のidのメッセージだけ取り出す
    if (is_file($testFile)) { //登録ファイルが存在するか
        if (is_readable($testFile)) { //登録ファイルを読み込めるか
            $fp = fopen($testFile, "r");
            flock($fp, LOCK_SH);
            //idが相手のアカウントと一致するまで一行ずつ取り出す
            while (!feof($fp)) {
                $content = fgetcsv($fp);
                //閲覧しているユーザーの情報を取得
                if ($content[0] == $mine && $content[1] == $opponent) {
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
    echo $content[2];
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
                if ($content[0] == $mine && $content[1] == $opponent) {
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
    echo $content[2];
    exit;
}
