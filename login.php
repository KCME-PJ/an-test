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
if (!empty($_POST)) {
    if ($_POST['email'] == '') {
        $error['email'] = 'blank';
    }
 
    if ($_POST['pass'] == '') {
        $error['pass'] = 'blank';
    }

    $member_email = htmlspecialchars($_POST['email']);
    $member_pass = htmlspecialchars($_POST['pass']);

    if (empty($error)) {
        $_SESSION['join'] = $_POST;

        header('Location:login_check.php');
        exit();
    }
}
?>

<div class="login-box">
    <form id="loginForm" action="" method="POST">
        <div class="panel panel-default">
            <div class="panel-heading">
              <b>Login</b>
              <span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>
            </div>

            <div class="panel-body">
                <div class="form-group has-primary has-feedback">
                    <label class="control-label" for="login">E-mail</label>
                    <input type="text" class="form-control" name="email" id="login" aria-describedby="login" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-primary has-feedback">
                    <label class="control-label" for="password">Password</label>
                    <input type="password" class="form-control" name="pass"
                    id="password" aria-describedby="password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>

            <div class="panel-footer">
                <input type="submit" class="btn btn-success" id="goToChat" value="Log in" />
                <a href="user_add.php" class="btn btn-warning pull-right">Registration</a>
            </div>
        </div>
    </form>
</div>
<div class="text-center">
<p>© 2017 KCCS MOBILE ENGINEERING Co., Ltd.</p>

</div>

<?php
$_SESSION = array();
if (isset($_COOKIE["PHPSESSID"])) {
    setcookie("PHPSESSID", '', time() - 1800, '/');
}
session_destroy();
?>
</body>
</html>
