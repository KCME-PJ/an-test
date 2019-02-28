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
require_once('common/database.php');

if (!isset($_SESSION['join'])) {
    header('Location: user_login.php');
    exit();
}

$member_email = $_SESSION['join']['email'];
$member_first = $_SESSION['join']['first_name'];
$member_last = $_SESSION['join']['last_name'];
$member_fkana = $_SESSION['join']['first_kana'];
$member_lkana = $_SESSION['join']['last_kana'];
$member_tel = $_SESSION['join']['tel'];
$member_pass = $_SESSION['join']['pass'];
$member_pass2 = $_SESSION['join']['pass2'];

$member_email = htmlspecialchars($member_email);
$member_first = htmlspecialchars($member_first);
$member_last = htmlspecialchars($member_last);
$member_fkana = htmlspecialchars(mb_convert_kana($member_fkana, "KVC"));
$member_lkana = htmlspecialchars(mb_convert_kana($member_lkana, "KVC"));
$member_tel = htmlspecialchars(mb_convert_kana($member_tel, "a"));
$member_pass = htmlspecialchars($member_pass);
$member_pass2 = htmlspecialchars($member_pass2);
$member_pass =  hash('sha256', $member_pass);

if (!empty($_POST)) {
    try {
        $dbh = getDb();
        $sql = <<<SQL
INSERT INTO members (email,first_name,last_name,first_kana,last_kana,tel,password) VALUES (?,?,?,?,?,?,?)
SQL;
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $member_email, PDO::PARAM_INT);
        $stmt->bindValue(2, $member_first, PDO::PARAM_STR);
        $stmt->bindValue(3, $member_last, PDO::PARAM_STR);
        $stmt->bindValue(4, $member_fkana, PDO::PARAM_STR);
        $stmt->bindValue(5, $member_lkana, PDO::PARAM_STR);
        $stmt->bindValue(6, $member_tel, PDO::PARAM_STR);
        $stmt->bindValue(7, $member_pass, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        print "ERR! : {$e->getMessage()}";
    } finally {
        $dbh = null;
    }
    session_destroy();
    header('Location: user_add_done.html');
    exit();
}
?>

<div class="login-box">
    <form id="loginForm" action="" method="POST">
        <div class="panel panel-default">
            <div class="panel-heading">
              <b>Sign in</b>
              <span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>
            </div>

            <div class="panel-body">
                <span class="regForm text-danger">入力した内容を確認して、「登録する」 ボタンを押してください。</span>
                <div class="form-group has-primary has-feedback">
                    <input type="hidden" name="action" value="submit"><br>
                    <label class="control-label" for="login">氏　名：</label><?php echo $member_last.$member_first; ?><br>
                    <label class="control-label" for="login">E-mail：</label><?php echo $member_email; ?>
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" class="btn btn-success" id="goToChat" value="登録する">
                <button type="button" onclick="history.back()"class="btn btn-warning pull-right">訂正する</button>
            </div>
        </div>
    </form>
</div>
<div class="text-center">
    <p>© 2017 KCCS MOBILE ENGINEERING Co., Ltd.</p>
</div>
</body>
</html>
