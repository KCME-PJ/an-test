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
                  <a href="javascript:;" class="user-profile dropdown-toggle"
                    data-toggle="dropdown" aria-expanded="false">
                    <img src="../images/img.jpg" alt=""><?php echo $user; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
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
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>ProAdd-page Example</h3>
              </div>              
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>ProAdd-page Example <small>other</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                        role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
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

                    <form class="form-horizontal" action="pro_add_done.php" method="post" name="form"
                    id="form" data-toggle="validator">
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">案件名</label>
                        <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                          <input type="text" name="pro_name" class="form-control has-feedback-left"
                          id="inputSuccess1" required>
                          <div class="help-block with-errors"></div>
                          <span class="fa fa-exclamation form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">案件住所</label>
                        <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                          <input type="text" name="pro_add" class="form-control has-feedback-left"
                          id="inputSuccess2" required>
                          <div class="help-block with-errors"></div>
                          <span class="fa fa-exclamation form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">案件種別</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <select name="type_id"class="select2_single form-control has-feedback-left"
                            tabindex="-1" required="required">
                            <option value=""></option>
<?php
require_once '../common/database.php';

$sql = <<<SQL
  SELECT * FROM pro_type ORDER BY type_id ASC;
SQL;

try {
    $dbh = getDb();
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
                          <div class="help-block with-errors"></div>
                          <span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">お客様名</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <select name="cus_id"class="select2_single form-control has-feedback-left"
                            tabindex="-1" required="required">
                            <option value=""></option>
<?php
require_once '../common/database.php';

$sql = <<<SQL
  SELECT * FROM customers ORDER BY cus_id ASC;
SQL;

try {
    $dbh = getDb();
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
                          <div class="help-block with-errors"></div>
                          <span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">協力会社</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <select name="co_id"class="select2_single form-control has-feedback-left"
                            tabindex="-1" required="required">
                            <option value=""></option>
<?php
require_once '../common/database.php';

$sql = <<<SQL
  SELECT * FROM companies ORDER BY co_name ASC;
SQL;

try {
    $dbh = getDb();
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
                          <div class="help-block with-errors"></div>
                          <span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">作業開始予定日</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                          <input type="date" name="start_d" class="form-control has-feedback-left"
                          id="inputSuccess3" placeholder="2018-04-01" required>
                          <div class="help-block with-errors"></div>
                          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">作業終了予定日</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                          <input type="date" name="end_d" class="form-control has-feedback-left"
                          id="inputSuccess4" placeholder="2018-04-01" required>
                          <div class="help-block with-errors"></div>
                          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="button" onclick="history.back()"
                          class="btn btn-primary">キャンセル</button>
                          <button type="submit" class="btn btn-success">登録</button>
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