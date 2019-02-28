<?php
require_once '../common/database.php';

$pro_name =  htmlspecialchars($_POST['pro_name']);
$pro_add =  htmlspecialchars($_POST['pro_add']);
$type_id =  htmlspecialchars($_POST['type_id']);
$cus_id =  htmlspecialchars($_POST['cus_id']);
$cus_name =  htmlspecialchars($_POST['cus_name']);
$co_id =  htmlspecialchars($_POST['co_id']);
$start_d =  htmlspecialchars($_POST['start_d']);
$end_d =  htmlspecialchars($_POST['end_d']);

$sql = <<<SQL
INSERT INTO projects (pro_name,address,type_id,cus_id,co_id,sd,ed,flag) VALUES (?,?,?,?,?,?,?,?)
SQL;

try {
    $dbh = getDb();
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $pro_name, PDO::PARAM_STR);
    $stmt->bindValue(2, $pro_add, PDO::PARAM_STR);
    $stmt->bindValue(3, $type_id, PDO::PARAM_STR);
    $stmt->bindValue(4, $cus_id, PDO::PARAM_STR);
    $stmt->bindValue(5, $co_id, PDO::PARAM_STR);
    $stmt->bindValue(6, $start_d, PDO::PARAM_STR);
    $stmt->bindValue(7, $end_d, PDO::PARAM_STR);
    $stmt->bindValue(8, 2, PDO::PARAM_STR);
    $stmt->execute();
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
    header('Location: ./pro_list.php');
