<?php
session_start();
require_once('../common/database.php');

if (!isset($_SESSION['join'])) {
    header('Location: ../user_login.php');
    exit();
}

$wo_id = htmlspecialchars($_GET["id"]);

require_once '../common/database.php';

try {
    $dbh = getDb();
    $sql = <<<SQL
  SELECT * FROM works
  INNER JOIN projects ON works.pro_id=projects.pro_id
  WHERE wo_id=$wo_id
SQL;
    $stmt = $dbh->query($sql);
    foreach ($stmt as $row) {
        $wo_id = $row['wo_id'];
        $pro_id = $row['pro_id'];
    }
} catch (PDOException $e) {
    exit('ERR! : ' . $e->getMessage());
} finally {
    $pdo = null;
}
    header("Location: ./receipt_edit_done02.php?pid=$pro_id");
