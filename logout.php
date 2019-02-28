<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>安全品質センター</title>

    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<?php
session_start();
$_SESSION=array();
if (isset($_COOKIE[session_name()])==true) {
    setcookie(session_name(), '', time()-1800, '/');
}
session_destroy();
?>

<div class="login-box">
    <div class="panel panel-warning">
        <div class="panel-heading" style="color:red;">
            <strong class="glyphicon glyphicon-warning-sign"> ログアウトしました</strong>
        </div>
        <div class="panel-body">
            <p>ご利用ありがとうございました。</p>
        </div>
        <div class="panel-footer">
            <a href="index/index1.php" class="btn btn-warning">Log in</a>
        </div>
    </div>
</div>
<div class="text-center">
    <p>© 2017 KCCS MOBILE ENGINEERING Co., Ltd.</p>
</div>
</body>
</html>
