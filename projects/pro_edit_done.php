<?php

require_once '../common/database.php';

$pro_id = htmlspecialchars($_POST['pro_id']);
$type_id = htmlspecialchars($_POST['type_id']);
$pro_name =  htmlspecialchars($_POST['pro_name']);
$pro_add =  htmlspecialchars($_POST['pro_add']);
$cus_id =  htmlspecialchars($_POST['cus_id']);
$cus_name =  htmlspecialchars($_POST['cus_name']);
$co_id =  htmlspecialchars($_POST['co_id']);
$start =  htmlspecialchars($_POST['start']);
$end =  htmlspecialchars($_POST['end']);
$flag =  htmlspecialchars(mb_convert_kana($_POST['flag'], "a"));

$sql = <<<SQL
UPDATE projects SET pro_name=?, type_id=?, address=?, cus_id=?, cus_name=?, co_id=?, sd=?, ed=?, flag=?  WHERE pro_id=?
SQL;

try {
    $dbh = getDb();
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $pro_name, PDO::PARAM_STR);
    $stmt->bindValue(2, $type_id, PDO::PARAM_STR);
    $stmt->bindValue(3, $pro_add, PDO::PARAM_STR);
    $stmt->bindValue(4, $cus_id, PDO::PARAM_STR);
    $stmt->bindValue(5, $cus_name, PDO::PARAM_STR);
    $stmt->bindValue(6, $co_id, PDO::PARAM_STR);
    $stmt->bindValue(7, $start, PDO::PARAM_STR);
    $stmt->bindValue(8, $end, PDO::PARAM_STR);
    $stmt->bindValue(9, $flag, PDO::PARAM_INT);
    $stmt->bindValue(10, $pro_id, PDO::PARAM_INT);
    
    $stmt->execute(array(
        $pro_name,
        $type_id,
        $pro_add,
        $cus_id,
        $cus_name,
        $co_id,
        $start,
        $end,
        $flag,
        $pro_id
    ));
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
    header('Location: ./pro_list.php');
