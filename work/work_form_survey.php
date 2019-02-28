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
require_once '../template/tel_form.php';
$email=$_SESSION['join']['email'];
$sql = <<<SQL
SELECT * FROM members INNER JOIN companies ON members.co_id=companies.co_id WHERE email="$email";
SQL;
try {
    $dbh = getDb();
    $stmt = $dbh->query($sql);
    foreach ($stmt as $row) {
        $id = $row['id'];
        $user = $row['last_name'];
        $user1 = $row['first_name'];
        $co_id = $row['co_id'];
        $co_name = $row['co_name'];
        $tel = format_phone_number($row['tel']);
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
<?php
require_once '../common/database.php';
$p_id = htmlspecialchars($_GET['id']);
$sql = <<<SQL
SELECT * FROM projects INNER JOIN customers ON projects.cus_id=customers.cus_id WHERE pro_id=?
SQL;

try {
    $dbh = getDb();
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(
        $p_id
    ));
    $row = $stmt->fetch();
    $pro_id = $row['pro_id'];
    $pro_name = $row['pro_name'];
    $pro_add = $row['address'];
    $cus_id = $row['cus_id'];
    $cus_name = $row['cus_name'];
    $sd = $row['sd'];
    $ed = $row['ed'];
    $flag = $row['flag'];
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
                <h3>電波測定</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>開始連絡</h2>
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
                    <form class="form-horizontal form-label-left"
                    action="work_form_done.php" enctype="multipart/form-data" method="post" name="form" id="form" data-toggle="validator">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">案件名</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" disabled="disabled" value="<?php echo $pro_name ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">案件住所</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" disabled="disabled" value="<?php echo $pro_add ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">お客様名</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" disabled="disabled" value="<?php echo $cus_name ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">開始予定日 </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="date" class="form-control" disabled="disabled" value="<?php echo $sd ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">終了予定日</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="date" class="form-control" disabled="disabled" value="<?php echo $ed ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">作業内容</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea name="sagyo" class="form-control" rows="3"
                          placeholder="作業内容を記載してください" required></textarea>
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">KYポイント</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea name="ky" class="form-control" rows="3"
                          placeholder="本日のKYポイントを記載してください" required></textarea>
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">写真添付</label>
                        <div id="dropzone" class="dropzone col-md-9 col-sm-9 col-xs-12">
                          <div class="dz-default dz-message"></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">現場責任者</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="manager" id="autocomplete-custom-append"
                          class="form-control col-md-10" value="<?php echo $fullname = $user.$user1 ?>" required>
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">総入場者数</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="number" name="workman" min="1" id="autocomplete-custom-append"
                          class="form-control col-md-10" required>
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">作業員名
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea name="workman-name" class="form-control" rows="3"
                          placeholder="京セラ太郎、京セラ花子、・・・" required></textarea>
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">天候</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select name="wether" class="form-control" required>
                            <option></option>
                            <option value="1">晴</option>
                            <option value="2">曇</option>
                            <option value="3">小雨</option>
                            <option value="4">雨</option>
                            <option value="5">大雨</option>
                            <option value="6">小雪</option>
                            <option value="7">雪</option>
                            <option value="8">吹雪</option>
                          </select>
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">使用機材</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea name="equipment" class="form-control" rows="2"
                          placeholder="端末○台、PC■台、・・・" required></textarea>
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">機材管理責任者</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" name="eq-manager" id="autocomplete-custom-append"
                          class="form-control col-md-10" value="<?php echo $fullname = $user.$user1 ?>" required>
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">落下/紛失/盗難防止対策</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea name="failsafe" class="form-control" rows="3" required></textarea>
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">作業種別
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="work_type1" value="1"> 走行測定
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="work_type2" value="2"> 歩行測定
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="work_type3" value="3"> 定点測定
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">移動手段</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="radio">
                            <label>
                              <input type="radio" checked="" value="1"
                              id="optionsRadios1" name="move" required> 車両で移動
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" value="2"
                              id="optionsRadios2" name="move"> 公共交通機関で移動
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">連絡者</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" disabled="disabled"
                          value="<?php echo $fullname = $user.$user1 ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">連絡先</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" disabled="disabled" value="<?php echo $tel ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">会社名</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" disabled="disabled" value="<?php echo $co_name ?>">
                        </div>
                      </div>
                      <input type="hidden" name="id" value="<?php echo $id ?>">
                      <input type="hidden" name="co_id" value="<?php echo $co_id ?>">
                      <input type="hidden" name="pro_id" value="<?php echo $pro_id ?>">
                      <input type="hidden" name="cus_id" value="<?php echo $cus_id ?>">
                      
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="reset" class="btn btn-primary">リセット</button>
                          <button type="submit" class="btn btn-success">入局情報を送信</button>
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
