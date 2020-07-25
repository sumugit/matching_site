<?php
session_start();
$_SESSION = array();
if(isset($_COOKIE[session_name()])==true){
    setcookie(session_name(),'',time()-42000,'/');
}
session_destroy();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>マッチングナビ</title>
    </head>
    <body>
        ログアウトしました。<br>
        <br>
        <a href="index.php">ホームへ戻る</a>
    </body>
</html>