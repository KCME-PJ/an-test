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

try {
    $dbh = getDb();
    $sql = <<<SQL

UPDATE works
SET receipt_date=?, receipt_time=?, visitors=?, manager=?, wt_id=?, operator=?, work=?, ky=?
WHERE wo_id=?
SQL;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $receipt_date, PDO::PARAM_STR);
    $stmt->bindValue(2, $receipt_time, PDO::PARAM_STR);
    $stmt->bindValue(3, $visitors, PDO::PARAM_STR);
    $stmt->bindValue(4, $manager, PDO::PARAM_STR);
    $stmt->bindValue(5, $wt_id, PDO::PARAM_INT);
    $stmt->bindValue(6, $operator, PDO::PARAM_STR);
    $stmt->bindValue(7, $work, PDO::PARAM_STR);
    $stmt->bindValue(8, $ky, PDO::PARAM_STR);
    $stmt->bindValue(9, $wo_id, PDO::PARAM_INT);

    $stmt->execute();
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
    header('Location: ./receipt_ing-list.php');
