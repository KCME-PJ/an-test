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
        $id = $row['id'];
        $user = $row['last_name'];
        $user1 = $row['first_name'];
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
date_default_timezone_set('Asia/Tokyo');
require_once '../common/database.php';
require_once '../template/tel_form.php';

$wo_id = htmlspecialchars($_GET['id']);
$sql = <<<SQL
SELECT * FROM works INNER JOIN members ON works.id = members.id 
  INNER JOIN companies ON works.co_id = companies.co_id
  INNER JOIN projects ON works.pro_id = projects.pro_id
  INNER JOIN weather ON works.wt_id = weather.wt_id
  WHERE wo_id=?
SQL;

try {
    $dbh = getDb();
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(
        $wo_id
    ));
    $row = $stmt->fetch();
    $sd = $row['sd'];
    $ed = $row['ed'];
    $receipt_date = $row['receipt_date'];
    $receipt_time = $row['receipt_time'];
    $re_id = $row['re_id'];
    $pro_name = $row['pro_name'];
    $address = $row['address'];
    $name1 = $row['last_name'];
    $name2 = $row['first_name'];
    $tel = format_phone_number($row['tel']);
    $co_name = $row['co_name'];
    $manager = $row['manager'];
    $visitors = $row['visitors'];
    $operator = $row['operator'];
    $work = $row['work'];
    $ky = $row['ky'];
    $wt_id = $row['wt_id'];
    $weather = $row['weather'];
    $created = $row['co_created'];
    $modified = $row['co_modified'];
    $comment = $row['end_comment'];
    $end_flag = $row['flag'];
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
                <h3>受付</h3>
              </div>              
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>電波測定</h2>
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
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li  role="presentation" class="active">
                          <a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab"
                          aria-expanded="true">本日の作業</a>
                        </li>
                        <li role="presentation" class="">
                          <a href="#tab_content2" id="profile-tab" role="tab" data-toggle="tab"
                          aria-expanded="false">写真確認</a>
                        </li>
                        <li role="presentation" class="">
                          <a href="#tab_content3" id="profile-tab2" role="tab" data-toggle="tab"
                          aria-expanded="false">現場責任者の履歴</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div id="tab_content1" class="tab-pane fade active in"
                          role="tabpanel" aria-labelledby="home-tab">
                          <form class="form-horizontal" action="receipt_ing-edit_done.php"
                            method="post" name="form" id="form" data-toggle="validator">
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">現場名</label>
                              <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                <input type="text" name="pro_name" class="form-control"
                                readonly="readonly" value="<?php echo $pro_name ?>">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">現場住所</label>
                              <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                <input type="text" name="address" class="form-control"
                                readonly="readonly" value="<?php echo $address ?>">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">事業所名</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="text" name="kari_01" class="form-control"
                                readonly="readonly" value="（仮）東京">
                              </div>
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">担当部署</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="text" name="kari_02" class="form-control"
                                readonly="readonly" value="（仮）東日本WI">
                              </div>
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">KCME担当者</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="text" name="kari_03" class="form-control"
                                readonly="readonly" value="（仮）KCME太郎">
                              </div>
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">部署コード</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="text" name="kari_04" class="form-control"
                                readonly="readonly" value="（仮）13E000000">
                              </div>
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">開始予定日</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="date" name="sd" class="form-control"
                                readonly="readonly" value="<?php echo $sd ?>">
                              </div>
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">終了予定日</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="date" name="ed" class="form-control"
                                readonly="readonly" value="<?php echo $ed ?>">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">協力会社名</label>
                              <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                <input type="text" name="co_name" class="form-control"
                                readonly="readonly" value="<?php echo $co_name ?>">
                              </div>
                            </div>
                            <div class="form-group row">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">受付日</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="date" name="receipt_date" class="form-control"
                                readonly="readonly" value="<?php echo $receipt_date ?>">
                              </div>
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">受付時間</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="time" name="receipt_time" class="form-control"
                                readonly="readonly" value="<?php echo $receipt_time ?>">
                              </div>
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">連絡者</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="text" name="contact" class="form-control"
                                readonly="readonly" value="<?php echo $fullname1 = $name1.$name2 ?>">
                              </div>
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">携帯電話</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="text" name="phone" class="form-control"
                                readonly="readonly" value="<?php echo $tel ?>">
                              </div>
<?php
require_once '../common/database.php';
try {
    $dbh = getDb();
    $sql = <<<SQL
  SELECT * FROM members WHERE id=$re_id;
SQL;
    $stmt = $dbh->query($sql);
    foreach ($stmt as $row) {
        $re_name1 = $row['last_name'];
        $re_name2 = $row['first_name'];
    }
} catch (PDOException $e) {
    exit('ERR! : ' . $e->getMessage());
} finally {
    $dbh = null;
}
?>

                              <label class="control-label col-md-3 col-sm-3 col-xs-12">受付者</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="text" name="receptionist" class="form-control"
                                readonly="readonly" value="<?php echo $fullname = $re_name1.$re_name2 ?>">
                              </div>
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">総入場者数</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="number" name="visitors" class="form-control"
                                readonly="readonly" value="<?php echo $visitors ?>" >
                              </div>
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">現場責任者</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="text" name="manager" class="form-control"
                                readonly="readonly" value="<?php echo $manager ?>">
                              </div>
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">天候</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="text" name="manager" class="form-control"
                                readonly="readonly" value="<?php echo $weather ?>">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">作業員名</label>
                              <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                <textarea name="operator" class="form-control"
                                readonly="readonly" rows="3" align="left"><?php echo $operator ?></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">作業内容</label>
                              <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                <textarea name="work" class="form-control"
                                readonly="readonly" rows="3" align="left"><?php echo $work ?></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">KYポイント</label>
                              <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                <textarea name="ky" class="form-control"
                                readonly="readonly" rows="3" align="left"><?php echo $ky ?></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">修了確認事項</label>
                              <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                <textarea name="ky" class="form-control"
                                readonly="readonly" rows="3" align="left"><?php echo $comment ?></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">修了フラグ</label>
                              <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                                <input type="text" name="end_flag" class="form-control"
                                readonly="readonly" value="<?php echo $end_flag ?>">
                              </div>
                            </div>
                            <div class="ln_solid"></div>
                            <input type="hidden" name="wo_id" value="<?php echo $wo_id ?>">
                            <input type="hidden" name="re_id" value="<?php echo $id ?>">
                            <div class="form-group">
                              <div class="col-md-6 col-md-offset-3">
                                <button type="button" onclick="history.back()"
                                class="btn btn-primary">戻る</button>                                
                              </div>
                            </div>
                          </form>
                        </div>
                        <div id="tab_content2" class="tab-pane fade" role="tabpanel" aria-labelledby="profile-tab">
                          <p>ここに、現場からの写真を表示する</p>
                          <link href="../css/jquery.magnify.css" rel="stylesheet">
                          <script src="../vendors/jquery/dist/jquery.js"></script>
                          <script src="../js/jquery.magnify.js"></script>
                          <div class="container">
                            <div class="image-set">
                              <a data-magnify="gallery" href="../images/picture-5.jpg">
                                <img src="../images/picture-5.jpg" alt="" height="150">
                              </a>
                              <a data-magnify="gallery" href="../images/picture-6.jpg">
                                <img src="../images/picture-6.jpg" alt="" height="150">
                              </a>
                              <a data-magnify="gallery" href="../images/picture-7.jpg">
                                <img src="../images/picture-7.jpg" alt="" height="150">
                              </a>
                              <a data-magnify="gallery" href="../images/picture-8.jpg">
                                <img src="../images/picture-8.jpg" alt="" height="150">
                              </a>
                              <a data-magnify="gallery" href="../images/picture-9.jpg">
                                <img src="../images/picture-9.jpg" alt="" height="150">
                              </a>
                              <a data-magnify="gallery" href="../images/picture-10.jpg">
                                <img src="../images/picture-10.jpg" alt="" height="150">
                              </a>
                              <a data-magnify="gallery" href="../images/picture-11.jpg">
                                <img src="../images/picture-11.jpg" alt="" height="150">
                              </a>
                              <a data-magnify="gallery" href="../images/picture-12.jpg">
                                <img src="../images/picture-12.jpg" alt="" height="150">
                              </a>
                            </div>
                          </div>
                        </div>
                        <div id="tab_content3" class="tab-pane fade" role="tabpanel" aria-labelledby="profile-tab">
                          <p>現場責任者：<?php echo $manager ?>さんの履歴</p>
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