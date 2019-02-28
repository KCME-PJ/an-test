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
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>案件一覧</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Project-list</h2>
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
                    <p><a class="btn btn-primary"href="pro_add.php">作業予定登録</a>
                       <a class="btn btn-primary" 
                        href="testxlsx_export.php"
                        onclick="return confirm('作業予定リストを出力しますYo !')">作業予定リスト出力</a>
                    </p>                  

                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>flag</th>
                          <th>案件名</th>
                          <th>作業開始</th>
                          <th>作業終了</th>
                          <th>編集</th>
                        </tr>
                      </thead>
                      <tbody>

<?php
require_once '../common/database.php';
require_once '../template/tel_form.php';

$sql = <<<SQL
  SELECT *
   FROM projects
   INNER JOIN customers ON projects.cus_id=customers.cus_id
   ORDER BY pro_id ASC;
SQL;

try {
    $dbh = getDb();

    $stmt = $dbh->query($sql);

    foreach ($stmt as $row) {
        $pro_id = $row['pro_id'];
        $pro_name = $row['pro_name'];
        $pro_type = $row['type_id'];
        $cus_id = $row['cus_id'];
        $start = $row['sd'];
        $end = $row['ed'];
        $w_flag = $row['w_flag'];
        $flag = $row['flag'];
        if ($w_flag == 0) {
            $uke = "未";
            $bt = "btn-danger";
        }
        if ($w_flag == 1) {
            $uke = "待";
            $bt = "btn-warning";
        }
        if ($w_flag == 2) {
            $uke = "受";
            $bt = "btn-info";
        }
        if ($flag == 1) {
            $eflag = " 終了";
            $ebt = "btn-default";
        }
        if ($flag == 2) {
            $eflag = " 継続";
            $ebt = "btn-success";
        }


        print <<<EOD

                        <tr>
                          <td>
                            <div class="text-center">
                              <p class="btn btn-xs $bt">$uke</p>
                            </div>
                          </td>
                          <td>$pro_name</td>
                          <td>$start</td>
                          <td>$end</td>
                          <td>
                            <div class="text-center">
                              <a href="pro_edit.php?id=$pro_id"
                                role="button"
                                class="btn btn-xs $ebt"><em class="fa fa-pencil">$eflag</em>              
                              </a>
                              <a href="pro_delete.php?id=$pro_id"
                                onclick="return confirm('削除してよろしいですか？')"
                                role="button"
                                class="btn btn-xs btn-danger"><em class="fa fa-trash"> 削除</em>
                              </a>
                            </div>
                          </td>
                        </tr>
EOD;
    }
} catch (PDOException $e) {
    exit('ERR! : ' . $e->getMessage());
} finally {
    $pdo = null;
}
                  
?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- /page content -->
<?php require '../template/footer.html'; ?>
