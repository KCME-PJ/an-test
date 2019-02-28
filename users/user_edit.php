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
    $dbh = null;
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
SELECT * FROM members INNER JOIN companies ON members.co_id=companies.co_id WHERE id=?
SQL;

try {
    $dbh = getDb();
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(
        $id
    ));
    $row = $stmt->fetch();
    $id = $row['id'];
    $first = $row['first_name'];
    $last = $row['last_name'];
    $tel = $row['tel'];
    $email = $row['email'];
    $co_id1 = $row['co_id'];
    $co_url = $row['co_url'];
    $co_name1 = $row['co_name'];
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
                <h3>Users-edit</h3>
              </div>              
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Design <small>different form elements</small></h2>
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
                    <form class="form-horizontal" action="user_edit_done.php" method="post" name="form" id="form">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">ID</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                          <input type="text" name="id" class="form-control has-feedback-left"
                          readonly="readonly" value="<?php echo $id ?>">
                          <span class="fa fa-barcode form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">First Nmae（名）</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                          <input type="text" name="first" class="form-control has-feedback-left"
                          id="inputSuccess2" value="<?php echo $first ?>">
                          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name（姓）</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                          <input type="text" name="last" class="form-control has-feedback-left"
                          id="inputSuccess3" value="<?php echo $last ?>">
                          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                          <input type="text" name="email" class="form-control has-feedback-left"
                          id="inputSuccess4" value="<?php echo $email ?>">
                          <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                          <input type="text" name="tel" class="form-control has-feedback-left"
                          id="inputSuccess5" value="<?php echo $tel ?>">
                          <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">会社名</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select name="co_id"class="select2_single form-control has-feedback-left" tabindex="-1">
                            <option value="<?php echo $co_id1 ?>"><?php echo $co_name1 ?></option>
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
    $dbh = null;
}
?>
                          </select>
                          <span class="fa fa-building-o form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">URL-Address</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="co_url" class="form-control has-feedback-left"
                          readonly="readonly" value="<?php echo $co_url ?>">
                          <span class="fa fa-external-link form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Create</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="created" class="form-control has-feedback-left"
                          readonly="readonly" value="<?php echo $created ?>">
                          <span class="fa fa-check-square form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Modify</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="modified" class="form-control has-feedback-left"
                          readonly="readonly" value="<?php echo $modified ?>">
                          <span class="fa fa-refresh form-control-feedback left" aria-hidden="true"></span>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <a href="users_list.php"
                          onclick="return confirm('操作をキャンセルして、リストに戻りますか？')"
                          role="button"
                          class="btn btn-primary">キャンセル</a>
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