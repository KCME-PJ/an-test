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
        $user_l = $row['last_name'];
        $user_f = $row['first_name'];
    }
} catch (PDOException $e) {
    exit('ERR! : ' . $e->getMessage());
} finally {
    $dbh = null;
}
?>
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_info">
                <span>
                    <?php
                    date_default_timezone_set('Asia/Tokyo');
                    $time = intval(date('H'));
                    if (4 <= $time && $time <= 12) { // 4時～12時の時間帯のとき ?>
                  <p>Good morning!</p>
                    <?php } elseif (12 <= $time && $time <= 18) { // 12時〜18時の時間帯のとき ?>
                  <p>Hello!</p>
                    <?php } else { // それ以外の時間帯のとき ?>
                  <p>Good evening!</p>
                    <?php } ?>
                </span>
                <h2><?php echo $user_l,$user_f; ?>さん</h2>
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
                    <?php echo $user_l,$user_f; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="../users/profile.php"> Profile</a></li>
                    <li><a href="members_logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

<?php
require_once '../common/database.php';
try {
    $sql = <<<SQL
SELECT * FROM accident_record WHERE id=1;
SQL;

    $dbh = getDb();
    $stmt = $dbh->query($sql);
    foreach ($stmt as $row) {
        $injury = $row['injury'];
        $information = $row['information'];
        $traffic = $row['traffic'];
        $quality = $row['quality'];
        $rmn_pj = $row['rmn_pj'];
    }
} catch (PDOException $e) {
    exit('ERR! : ' . $e->getMessage());
} finally {
    $dbh = null;
}
?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>無事故継続記録</h3>
              </div>              
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <img src="../images/midori-cross.png" alt="緑十字" width="20" height="20" align="left">
                    <h2>　No Accident Record <small>Safety and quality</small></h2>
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
                    <p class="text-muted font-13 m-b-30">
                    Disaster record is displayed here.
                    </p>
                    <div class="row">
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4><b>人身災害</b></h4>
                            <p><b>目標日数：2000日</b></p>
                          </div>
                          <div class="panel-body">
                            <p>
                            <?php echo date('Y年m月d日', strtotime($injury)); ?>～
                            <br>
                            <?php echo( date("Y年m月d日現在　")); ?>
                            <br>
                            </p>
                            <p><b>
                            <?php
                              $s = strtotime("now") - strtotime($injury);
                              $d = floor($s/( 60 * 60 * 24));
                              echo "無事故継続：".$d."日";
                            ?>
                            </b></p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4><b>情報セキュリティ</b></h4>
                            <p><b>目標日数：500日</b></p>
                          </div>
                          <div class="panel-body">
                            <p>
                            <?php echo date('Y年m月d日', strtotime($information)); ?>～
                            <br>
                            <?php echo( date("Y年m月d日現在　")); ?>
                            <br>
                            </p>
                            <p><b>
                            <?php
                              $s = strtotime("now") - strtotime($information);
                              $d = floor($s/( 60 * 60 * 24));
                              echo "無事故継続：".$d."日";
                            ?>
                            </b></p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4><b>交通事故</b></h4>
                            <p><b>目標日数：500日</b></p>
                          </div>
                          <div class="panel-body">
                            <p>
                            <?php echo date('Y年m月d日', strtotime($traffic)); ?>～
                            <br>
                            <?php echo( date("Y年m月d日現在　")); ?>
                            <br>
                            </p>
                            <p><b>
                            <?php
                              $s = strtotime("now") - strtotime($traffic);
                              $d = floor($s/( 60 * 60 * 24));
                              echo "無事故継続：".$d."日";
                            ?>
                            </b></p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4><b>設備・品質事故</b></h4>
                            <p><b>目標日数：500日</b></p>
                          </div>
                          <div class="panel-body">
                            <p>
                            <?php echo date('Y年m月d日', strtotime($quality)); ?>～
                            <br>
                            <?php echo( date("Y年m月d日現在　")); ?>
                            <br>
                            </p>
                            <p><b>
                            <?php
                              $s = strtotime("now") - strtotime($quality);
                              $d = floor($s/( 60 * 60 * 24));
                              echo "無事故継続：".$d."日";
                            ?>
                            </b></p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4><b>RMN-PJ</b></h4>
                            <p><b>目標日数：500日</b></p>
                          </div>
                          <div class="panel-body">
                            <p>
                            <?php echo date('Y年m月d日', strtotime($rmn_pj)); ?>～
                            <br>
                            <?php echo( date("Y年m月d日現在　")); ?>
                            <br>
                            </p>
                            <p><b>
                            <?php
                              $s = strtotime("now") - strtotime($rmn_pj);
                              $d = floor($s/( 60 * 60 * 24));
                              echo "無事故継続：".$d."日";
                            ?>
                            </b></p>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- /page content -->
<?php require '../template/footer.html'; ?>