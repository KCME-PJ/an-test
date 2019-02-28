<?php
session_start();
require_once('../common/database.php');

if (!isset($_SESSION['join'])) {
    header('Location: ../user_login.php');
    exit();
}

$pro_id = htmlspecialchars($_GET["id"]);

$sql = <<<SQL
UPDATE projects SET w_flag=1 WHERE pro_id=?
SQL;

try {
    $dbh = getDb();
    $stmt = $dbh->prepare($sql);

    $stmt->bindValue(1, $pro_id, PDO::PARAM_INT);

    $stmt->execute(array(
        $pro_id
    ));
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
    header('Location: ./work_list.php');
