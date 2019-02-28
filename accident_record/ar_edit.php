<?php require '../template/header.html'; ?>
<?php
session_start();
if (!isset($_SESSION['join'])) {
    header('Location: members_login.php');
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
<?php
require_once '../common/database.php';
$id = htmlspecialchars($_GET['id']);
$sql = <<<SQL
SELECT * FROM accident_record WHERE id=?
SQL;

try {
    $dbh = getDb();
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(
        $id
    ));
    $row = $stmt->fetch();
    $id = $row['id'];
    $injury = $row['injury'];
    $information = $row['information'];
    $traffic = $row['traffic'];
    $quality = $row['quality'];
    $rmn_pj = $row['rmn_pj'];
    $created = $row['created'];
    $modified = $row['modified'];
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
                <h3>Accident_Record-edit</h3>
              </div>              
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Accident_Record <small>edit</small></h2>
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
                    <form class="form-horizontal form-label-left" action="ar_edit_done.php" method="post" name="form"
                      id="form" data-toggle="validator">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">ID</label>
                        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                          <input type="text" name="id" class="form-control has-feedback-left"
                          readonly="readonly" value="<?php echo $id ?>">
                          <span class="fa fa-barcode form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">人身災害</label>
                        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                          <input type="date" name="injury" class="form-control has-feedback-left"
                          id="inputSuccess1" value="<?php echo $injury ?>"
                          data-error="直近の人身災害発生日を記入！" required>
                          <div class="help-block with-errors"></div>
                          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">情報セキュリティ</label>
                        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                          <input type="date" name="information" class="form-control has-feedback-left"
                          id="inputSuccess2" value="<?php echo $information ?>"
                          data-error="直近の情報セキュリティ事故発生日を記入！" required>
                          <div class="help-block with-errors"></div>
                          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">交通事故</label>
                        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                          <input type="date" name="traffic" class="form-control has-feedback-left"
                          id="inputSuccess3" value="<?php echo $traffic ?>"
                          data-error="直近の交通事故発生日を記入！" required>
                          <div class="help-block with-errors"></div>
                          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">設備・品質事故</label>
                        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                          <input type="date" name="quality" class="form-control has-feedback-left"
                          id="inputSuccess4" value="<?php echo $quality ?>"
                          data-error="直近の設備・品質事故発生日を記入！" required>
                          <div class="help-block with-errors"></div>
                          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">RMN-PJ事故</label>
                        <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                          <input type="date" name="rmn" class="form-control has-feedback-left"
                          id="inputSuccess5" value="<?php echo $rmn_pj ?>"
                          data-error="直近のRMN-PJで発生した事故発生日を記入！" required>
                          <div class="help-block with-errors"></div>
                          <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Create</label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <input type="text" name="created" class="form-control has-feedback-left"
                          readonly="readonly" value="<?php echo $created ?>">
                          <span class="fa fa-check-square form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Modify</label>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                          <input type="text" name="modified" class="form-control has-feedback-left"
                          readonly="readonly" value="<?php echo $modified ?>">
                          <span class="fa fa-refresh form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="button" onclick="history.back()"
                          class="btn btn-primary">キャンセル</button>
                          <button type="submit" class="btn btn-success">更新</a>
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