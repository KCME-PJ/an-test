<?php
session_start();
require_once('../common/database.php');

if (!isset($_SESSION['join'])) {
    header('Location: ../user_login.php');
    exit();
}

$id = htmlspecialchars($_POST['id']);
$co_id = htmlspecialchars($_POST['co_id']);
$pro_id = htmlspecialchars($_POST['pro_id']);
$work = htmlspecialchars($_POST['sagyo']);
$ky = htmlspecialchars($_POST['ky']);
$manager = htmlspecialchars($_POST['manager']);
$visitors = htmlspecialchars($_POST['workman']);
$operator = htmlspecialchars($_POST['workman-name']);
$weather = htmlspecialchars($_POST['wether']);
$equip = htmlspecialchars($_POST['equipment']);
$eq_manager = htmlspecialchars($_POST['eq_manager']);
$failsafe = htmlspecialchars($_POST['failsafe']);
$aerial_work = htmlspecialchars($_POST['aerial_work']);
$aerial_route = htmlspecialchars($_POST['aerial_route']);
$singi_date = htmlspecialchars($_POST['sinngi_date']);
$singi_member = htmlspecialchars($_POST['sinngi_member']);
$tachiai = htmlspecialchars($_POST['tachiai']);
$tachiai_name = htmlspecialchars($_POST['tachiai_name']);

if (isset($_POST['work_type1']) == "1") {
    $w_1 = "1";
} else {
    $w_1 = "0";
}

if (isset($_POST['work_type2']) == "2") {
    $w_2 = "2";
} else {
    $w_2 = "0";
}

if (isset($_POST['work_type3']) == "3") {
    $w_3 = "3";
} else {
    $w_3 = "0";
}

$move = htmlspecialchars($_POST['move']);

try {
    $dbh = getDb();
    $sql = <<<SQL

INSERT INTO works (
    id,co_id,pro_id,work,ky,manager,visitors,operator,wt_id,equipment,eq_manager,failsafe,w_1,w_2,w_3,move,aerial_work,aerial_route,sinngi_date,sinngi_member,tachiai,tachiai_name
    )VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
SQL;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->bindValue(2, $co_id, PDO::PARAM_INT);
    $stmt->bindValue(3, $pro_id, PDO::PARAM_INT);
    $stmt->bindValue(4, $work, PDO::PARAM_STR);
    $stmt->bindValue(5, $ky, PDO::PARAM_STR);
    $stmt->bindValue(6, $manager, PDO::PARAM_STR);
    $stmt->bindValue(7, $visitors, PDO::PARAM_INT);
    $stmt->bindValue(8, $operator, PDO::PARAM_STR);
    $stmt->bindValue(9, $weather, PDO::PARAM_INT);
    $stmt->bindValue(10, $equip, PDO::PARAM_INT);
    $stmt->bindValue(11, $eq_manager, PDO::PARAM_INT);
    $stmt->bindValue(12, $failsafe, PDO::PARAM_INT);
    $stmt->bindValue(13, $w_1, PDO::PARAM_INT);
    $stmt->bindValue(14, $w_2, PDO::PARAM_INT);
    $stmt->bindValue(15, $w_3, PDO::PARAM_INT);
    $stmt->bindValue(16, $move, PDO::PARAM_INT);
    $stmt->bindValue(17, $aerial_work, PDO::PARAM_INT);
    $stmt->bindValue(18, $aerial_route, PDO::PARAM_INT);
    $stmt->bindValue(19, $sinngi_date, PDO::PARAM_INT);
    $stmt->bindValue(20, $sinngi_member, PDO::PARAM_INT);
    $stmt->bindValue(21, $tachiai, PDO::PARAM_INT);
    $stmt->bindValue(22, $tachiai_name, PDO::PARAM_INT);

    $stmt->execute();
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
    header("Location: ./work_form_done01.php?id=$pro_id");
