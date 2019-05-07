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
require_once 'common/database.php';

if (!isset($_SESSION['join'])) {
    header('Location: members_login.php');
    exit();
}

$member_email = htmlspecialchars($_SESSION['join']['email']);
$member_pass =  htmlspecialchars($_SESSION['join']['pass']);

$member_pass =  hash('sha256', $member_pass);

try {
    $dbh = getDb();

    $sql = <<<SQL
SELECT email, password 
FROM members 
WHERE email=? 
AND password=? 
AND power_user=1
SQL;
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $member_email, PDO::PARAM_INT);
    $stmt->bindValue(2, $member_pass, PDO::PARAM_INT);
    $stmt->execute();

    $rec=$stmt->fetch(PDO::FETCH_ASSOC);

    if ($rec==false) {
        $error['pass'] = 'wrong';
    } else {
        header('Location:index/index1.php');
        exit();
    }
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
?>

<?php if (isset($error['pass']) && $error['pass'] =='wrong') : ?>
<div class="login-box">
        <div class="panel panel-warning">
            <div class="panel-heading" style="color:red;">
                <strong class="glyphicon glyphicon-warning-sign"> 認証エラー</strong>
            </div>

            <div class="panel-body">
                <p>入力情報を確認してください。</p>           
                <p>メールアドレスまたは、パスワードが間違っています。</p>
            </div>

            <div class="panel-footer">
            <button type="button" onclick="history.back()"class="btn btn-warning">戻る</button>
            </div>

        </div>

</div>

    <?php
    $_SESSION=array();
    if (isset($_COOKIE[session_name()])==true) {
        setcookie(session_name(), '', time()-1800, '/');
    }
    session_destroy();
    ?>

<?php endif; ?>
<div class="text-center">

<p>© 2017 KCCS MOBILE ENGINEERING Co., Ltd.</p>

</div>
</body>
</html>
