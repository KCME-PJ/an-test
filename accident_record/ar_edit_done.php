<?php
session_start();
require_once('../common/database.php');

if (!isset($_SESSION['join'])) {
    header('Location: ../user_login.php');
    exit();
}

$id = htmlspecialchars($_POST['id']);
$injury =  htmlspecialchars($_POST['injury']);
$information =  htmlspecialchars($_POST['information']);
$traffic =  htmlspecialchars($_POST['traffic']);
$quality =  htmlspecialchars($_POST['quality']);
$rmn_pj =  htmlspecialchars($_POST['rmn']);

try {
    $dbh = getDb();
    $sql = <<<SQL

UPDATE accident_record
SET injury=?, information=?, traffic=?, quality=?, rmn_pj=?
WHERE id=?
SQL;

    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $injury, PDO::PARAM_STR);
    $stmt->bindValue(2, $information, PDO::PARAM_STR);
    $stmt->bindValue(3, $traffic, PDO::PARAM_STR);
    $stmt->bindValue(4, $quality, PDO::PARAM_STR);
    $stmt->bindValue(5, $rmn_pj, PDO::PARAM_STR);
    $stmt->bindValue(6, $id, PDO::PARAM_INT);
    
    $stmt->execute();
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
    header('Location: ./ar_list.php');
