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
        $co_id1 = $row['co_id'];
    }
} catch (PDOException $e) {
    exit('ERR! : ' . $e->getMessage());
} finally {
    $pdo = null;
}
?>
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
                    <?php echo $user; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="../users/profile.php"> Profile</a></li>
                    <li><a href="../logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
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
                <h3>入局予定一覧</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>案件リスト</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <ul id="work-list"><h2>
<?php
require_once '../common/database.php';

$sql = <<<SQL
  SELECT * FROM projects WHERE co_id=$co_id1 AND w_flag="0";
SQL;

try {
    $dbh = getDb();
    $stmt = $dbh->query($sql);

    foreach ($stmt as $row) {
        $pro_id = $row['pro_id'];
        $pro_type = $row['type_id'];
        $pro_name = $row['pro_name'];
        
        if ($pro_type == 1){
        $link = "work_form_survey.php?id=$pro_id";
        }

        if ($pro_type == 2){
        $link = "work_form_const.php?id=$pro_id";
        }

          print <<<EOD
                    <li><a href="$link"
                    role="button">$pro_name</a></li>
EOD;
    }
} catch (PDOException $e) {
    exit('ERR! : ' . $e->getMessage());
} finally {
    $pdo = null;
}
?>

                    </h2></ul>
<style>
    ul#work-list li{
        margin-top: 7px;
        margin-bottom: 7px;
    }
</style>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- /page content -->
<?php require '../template/footer.html'; ?>