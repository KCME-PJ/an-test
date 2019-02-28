<?php
session_start();
require_once('../common/database.php');

if (!isset($_SESSION['join'])) {
    header('Location: ../user_login.php');
    exit();
}

$wo_id = htmlspecialchars($_POST['wo_id']);
$re_id = htmlspecialchars($_POST['re_id']);
$receipt_date = htmlspecialchars($_POST['receipt_date']);
$receipt_time = htmlspecialchars($_POST['receipt_time']);
$visitors = htmlspecialchars($_POST['visitors']);
$manager = htmlspecialchars($_POST['manager']);
$wt_id = htmlspecialchars($_POST['weather']);
$operator = htmlspecialchars($_POST['operator']);
$work = htmlspecialchars($_POST['work']);
$ky = htmlspecialchars($_POST['ky']);
$end_comment = htmlspecialchars($_POST['end_comment']);
$flag = htmlspecialchars($_POST['end_flag']);

try {
    $dbh = getDb();
    $sql = <<<SQL

UPDATE works
SET re_id=?, receipt_date=?, receipt_time=?, visitors=?, manager=?,
wt_id=?, operator=?, work=?, ky=?, do_flag=?, end_comment=?
WHERE wo_id=?
SQL;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $re_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $receipt_date, PDO::PARAM_STR);
    $stmt->bindValue(3, $receipt_time, PDO::PARAM_STR);
    $stmt->bindValue(4, $visitors, PDO::PARAM_STR);
    $stmt->bindValue(5, $manager, PDO::PARAM_STR);
    $stmt->bindValue(6, $wt_id, PDO::PARAM_INT);
    $stmt->bindValue(7, $operator, PDO::PARAM_STR);
    $stmt->bindValue(8, $work, PDO::PARAM_STR);
    $stmt->bindValue(9, $ky, PDO::PARAM_STR);
    $stmt->bindValue(10, 2, PDO::PARAM_INT);
    $stmt->bindValue(11, $end_comment, PDO::PARAM_STR);
    $stmt->bindValue(12, $wo_id, PDO::PARAM_INT);

    $stmt->execute();
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
    header("Location: ./receipt_end-edit_done01.php?id=$wo_id & flag=$flag");
