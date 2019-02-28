<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>安全品質センター</title>

    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/validator.min.js"></script>
</head>
<body>
<?php
session_start();
require_once('common/database.php');

if (! empty($_POST)) {
    // validation

    if ($_POST['email'] == '') {
        $error['email'] = 'blank';
    }

    if ($_POST['first_name'] == '') {
        $error['first_name'] = 'blank';
    }

    if ($_POST['last_name'] == '') {
        $error['last_name'] = 'blank';
    }

    if ($_POST['first_kana'] == '') {
        $error['first_kana'] = 'blank';
    }

    if ($_POST['last_kana'] == '') {
        $error['last_kana'] = 'blank';
    }

    if ($_POST['tel'] == '') {
        $error['tel'] = 'blank';
    }

    if ($_POST['pass'] == '') {
        $error['pass'] = 'blank';
    }

    if ($_POST['pass2'] == '') {
        $error['pass2'] = 'blank';
    }

    // duplicate check
    try {
        $dbh = getDb();

        $sql = sprintf("SELECT COUNT(*) AS cnt FROM members WHERE email='%s' ", $_POST['email']);

        $stmt = $dbh->query($sql);

        while ($row = $stmt->fetch()) {
            $cnt = $row['cnt'];
            if ($cnt > 0) {
                $error['email'] = 'duplicate';
            }
        }
    } catch (PDOException $e) {
        print "ERR! : {$e->getMessage()}";
    } finally {
        $dbh = null;
    }

    if (empty($error)) {
        $_SESSION['join'] = $_POST;

        header('Location: user_add_check.php');
        exit();
    }
}

// rewrite
if (isset($_REQUEST['action']) == 'rewrite') {
    $_POST = $_SESSION['join'];
    $error['rewite'] = true;
}
?>
<?php
if (isset($_POST['email'])) {
    $member_email = $_POST['email'];
}

if (isset($_POST['first_name'])) {
    $member_first = $_POST['first_name'];
}

if (isset($_POST['last_name'])) {
    $member_last = $_POST['last_name'];
}

if (isset($_POST['first_kana'])) {
    $member_fkana = $_POST['first_kana'];
}

if (isset($_POST['last_name'])) {
    $member_lkana = $_POST['last_kana'];
}

if (isset($_POST['tel'])) {
    $member_tel = $_POST['tel'];
}

if (isset($_POST['pass'])) {
    $member_pass = $_POST['pass'];
}
if (isset($_POST['pass2'])) {
    $member_pass2 = $_POST['pass2'];
}

if (isset($member_email)) {
    $member_email = htmlspecialchars($member_email);
}
if (isset($member_first)) {
    $member_first = htmlspecialchars($member_first);
}
if (isset($member_last)) {
    $member_last = htmlspecialchars($member_last);
}
if (isset($member_fkana)) {
    $member_fkana = htmlspecialchars($member_fkana);
}
if (isset($member_lkana)) {
    $member_lkana = htmlspecialchars($member_lkana);
}
if (isset($member_tel)) {
    $member_tel = htmlspecialchars($member_tel);
}
if (isset($member_pass)) {
    $member_pass = htmlspecialchars($member_pass);
}
if (isset($member_pass2)) {
    $member_pass2 = htmlspecialchars($member_pass2);
}

?>

<div class="login-box">
    <form id="loginForm" action="#" data-toggle="validator" method="POST">
        <div class="panel panel-default">
            <div class="panel-heading">
              <b>Create your account</b>
              <span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true">
              </span>
            </div>
            <div class="panel-body">
                <div class="form-group has-primary has-feedback">
                    <label class="control-label" for="login">E-mail <span class="regForm text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" id="email"
                    data-error="メールアドレスの入力は必須です" placeholder="user@example.com" required>
                <div class="help-block with-errors"></div>
                    <span class="glyphicon glyphicon-envelope form-control-feedback" aria-hidden="true"></span>
                </div>

<?php if (isset($error['email']) && $error['email'] = 'duplicate') : ?>
<span class="regForm text-danger">指定されたメールアドレスは、すでに登録されています！</span>
<?php endif; ?>

                <div class="form-group has-primary has-feedback">
                    <label class="control-label" for="login">姓（Last Name）
                        <span class="regForm text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="last_name" id="last_name"
                    data-error="名字の入力は必須です" placeholder="京セラ" required>
                <div class="help-block with-errors"></div>
                    <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-primary has-feedback">
                    <label class="control-label" for="login">名（First Name）
                        <span class="regForm text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="first_name" id="first_name"
                    data-error="名前の入力は必須です" placeholder="太郎" required>
                <div class="help-block with-errors"></div>
                    <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-primary has-feedback">
                    <label class="control-label" for="login">姓（カナ）<span class="regForm text-danger">*</span></label>
                    <input type="text" class="form-control" name="last_kana" id="last_kana"
                    data-error="姓のカナ入力は必須です" placeholder="キョウセラ" required>
                <div class="help-block with-errors"></div>
                    <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-primary has-feedback">
                    <label class="control-label" for="login">名（カナ）<span class="regForm text-danger">*</span></label>
                    <input type="text" class="form-control" name="first_kana" id="first_kana"
                    data-error="名のカナ入力は必須です" placeholder="タロウ" required>
                <div class="help-block with-errors"></div>
                    <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-primary has-feedback">
                    <label class="control-label" for="login">Phone <span class="regForm text-danger">*</span></label>
                    <input type="text" minlength="10" maxlength="11"class="form-control" name="tel" id="tel"
                    data-error="電話番号の入力は必須です" placeholder="09012345678" required>
                <div class="help-block with-errors"></div>
                    <span class="glyphicon glyphicon-phone form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-primary has-feedback">
                    <label class="control-label" for="login">Password <span class="regForm text-danger">*</span></label>
                    <input type="password" minlength="4" class="form-control" name="pass" id="password"
                    data-required-error="パスワードの入力は必須です" placeholder="Password" required>
                <div class="help-block with-errors"></div>
                    <span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-primary has-feedback">
                    <label class="control-label" for="login">Confirm Password 
                        <span class="regForm text-danger">*</span>
                    </label>
                    <input type="password" minlength="4" class="form-control" name="pass2" id="password2"
                    data-match="#password" data-required-error="確認用パスワードの入力は必須です"
                    data-match-error="パスワードが一致しません" placeholder="Confirm Password" required>
                <div class="help-block with-errors"></div>
                    <span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" class="btn btn-success" id="goToChat" value="Create acount">
            </div>
        </div>
    </form>
</div>
<div class="text-center">
<p>© 2017 KCCS MOBILE ENGINEERING Co., Ltd.</p>
</div>
</body>
</html>
