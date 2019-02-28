<?php
session_start();
require_once('../common/database.php');

if (!isset($_SESSION['join'])) {
    header('Location: ../user_login.php');
    exit();
}

$pro_id = htmlspecialchars($_GET["pid"]);
$flag = htmlspecialchars($_GET["flag"]);

require_once '../common/database.php';

try {
    $dbh = getDb();
    $sql = <<<SQL
  UPDATE projects SET w_flag=0, flag=? WHERE pro_id=?
SQL;
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $flag, PDO::PARAM_INT);
    $stmt->bindValue(2, $pro_id, PDO::PARAM_INT);

    $stmt->execute(array(
        $flag,
        $pro_id
    ));
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
    header('Location: ./receipt_ing-list.php');
