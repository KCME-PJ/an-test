<?php require '../template/header.html'; ?>
<?php
session_start();
if (!isset($_SESSION['join'])) {
    header('Location: ../login.php');
    exit();
}
?>
<?php
require_once '../common/database.php';
$email=$_SESSION['join']['email'];
$sql = <<<SQL
SELECT * FROM members WHERE email="$email";
SQL;
try {
    $dbh = getDb();
    $stmt = $dbh->query($sql);
    foreach ($stmt as $row) {
        $user = $row['last_name'];
    }
} catch (PDOException $e) {
    exit('ERR! : ' . $e->getMessage());
} finally {
    $pdo = null;
}
?>
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="../images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome!</span>
                <h2><?php echo $user; ?>さん</h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />
<?php require '../template/menu.html'; ?>
        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;"
                    class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="../images/img.jpg" alt=""><?php echo $user; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="../users/profile.php"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><a href="members_logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
        <!-- page content -->
<?php
require_once '../common/database.php';
$pro_id = htmlspecialchars($_GET['id']);
$sql = <<<SQL
SELECT * FROM projects
 INNER JOIN companies ON projects.co_id=companies.co_id
 INNER JOIN customers ON projects.cus_id=customers.cus_id
 INNER JOIN pro_type ON projects.type_id=pro_type.type_id
 WHERE pro_id=?
SQL;

try {
    $dbh = getDb();
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(
      $pro_id
    ));
    $row = $stmt->fetch();
    $pro_id = ($row['pro_id']);
    $pro_name = ($row['pro_name']);
    $address = ($row['address']);
    $type_id1 = ($row['type_id']);
    $type_name1 = ($row['type_name']);
    $co_id1 = ($row['co_id']);
    $co_name1 = ($row['co_name']);
    $cus_id1 = ($row['cus_id']);
    $cus_name1 = ($row['cus_name']);
    $start = ($row['sd']);
    $end = ($row['ed']);
    $flag = ($row['flag']);
    $created = ($row['created']);
    $modified = ($row['modified']);
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
?>

        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>案件編集</h3>
              </div>              
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Project-edit</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle"
                          data-toggle="dropdown" role="button"
                          aria-expanded="false">
                          <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form class="form-horizontal" action="pro_edit_done.php" method="post" name="form" id="form">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">ID</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                          <input type="text" name="pro_id" class="form-control has-feedback-left"
                          readonly="readonly" value="<?php echo $pro_id ?>">
                          <span class="fa fa-barcode form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">案件名</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                          <input type="text" name="pro_name" class="form-control has-feedback-left"
                          id="inputSuccess1" value="<?php echo $pro_name ?>">
                          <span class="fa fa-exclamation form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">住所</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                          <input type="text" name="pro_add" class="form-control has-feedback-left"
                          id="inputSuccess2" value="<?php echo $address ?>">
                          <span class="fa fa-exclamation form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">案件種別</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select name="type_id"class="select2_single form-control has-feedback-left" tabindex="-1">
                            <option value="<?php echo $type_id1 ?>"><?php echo $type_name1 ?></option>
<?php
require_once '../common/database.php';
try {
    $dbh = getDb();
    $sql = <<<SQL
  SELECT * FROM pro_type ORDER BY type_id ASC;
SQL;
    $stmt = $dbh->query($sql);
    foreach ($stmt as $row) {
        $type_id = $row['type_id'];
        $type_name = $row['type_name'];
        print <<<EOD
                            <option value="$type_id">$type_name</option>
EOD;
    }
} catch (PDOException $e) {
    exit('ERR! : ' . $e->getMessage());
} finally {
    $pdo = null;
}
?>
                          </select>
                          <span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">お客様名</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select name="cus_id"class="select2_single form-control has-feedback-left" tabindex="-1">
                            <option value="<?php echo $cus_id1 ?>"><?php echo $cus_name1 ?></option>
<?php
require_once '../common/database.php';
try {
    $dbh = getDb();
    $sql = <<<SQL
  SELECT * FROM customers ORDER BY cus_id ASC;
SQL;
    $stmt = $dbh->query($sql);
    foreach ($stmt as $row) {
        $cus_id = $row['cus_id'];
        $cus_name = $row['cus_name'];
        print <<<EOD
                            <option value="$cus_id">$cus_name</option>
EOD;
    }
} catch (PDOException $e) {
    exit('ERR! : ' . $e->getMessage());
} finally {
    $pdo = null;
}
?>
                          </select>
                          <span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">協力会社</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select name="co_id"class="select2_single form-control has-feedback-left" tabindex="-1">
                            <option value="<?php echo $co_id1 ?>"><?php echo $co_name1 ?></option>
<?php
require_once '../common/database.php';
try {
    $dbh = getDb();
    $sql = <<<SQL
  SELECT * FROM companies ORDER BY co_name ASC;
SQL;
    $stmt = $dbh->query($sql);
    foreach ($stmt as $row) {
        $co_id = $row['co_id'];
        $co_name = $row['co_name'];
        print <<<EOD
                            <option value="$co_id">$co_name</option>
EOD;
    }
} catch (PDOException $e) {
    exit('ERR! : ' . $e->getMessage());
} finally {
    $pdo = null;
}
?>
                          </select>
                          <span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">作業開始予定</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                          <input type="date" name="start" class="form-control has-feedback-left"
                          id="inputSuccess3" value="<?php echo $start ?>">
                          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">作業終了予定</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="date" name="end" class="form-control has-feedback-left"
                          id="inputSuccess4" value="<?php echo $end ?>">
                          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">完了フラグ</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                          <input type="text" name="flag" class="form-control has-feedback-left"
                          id="inputSuccess5" maxlength="1" value="<?php echo $flag ?>">
                          <span class="fa fa-exclamation form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">登録日</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="created" class="form-control has-feedback-left"
                          readonly="readonly" value="<?php echo $created ?>">
                          <span class="fa fa-flag-checkered form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">更新日</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="modified" class="form-control has-feedback-left"
                          readonly="readonly" value="<?php echo $modified ?>">
                          <span class="fa fa-flag-checkered form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="button" onclick="history.back()" class="btn btn-primary">キャンセル</button>
                          <a class="btn btn-success"
                          href="javascript:document.form.submit()"
                          onclick="return confirm('更新してよろしいですか？')"
                          role="button">更新</a>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
<?php require '../template/footer.html'; ?>