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
                <h3>KCME</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>メッセージ</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div align="center" class="x_content">
                    <h2>気象情報に注意！</h2><br>※気象情報は下記をタップ
                    <p><a href="https://tenki.jp/lite/bousai/warn/">
                    <img src="http://www.jma.go.jp/jp/warn/imgs/000/99.png" width="90%"></a></p>
                    <p>メッセージを確認したら、<br>入場連絡を行ってください。</p>
                    <a href="work_list.php" class="btn btn-xs btn-danger">入場</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- /page content -->
<?php require '../template/footer.html'; ?>