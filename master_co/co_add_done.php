<?php
require_once '../common/database.php';

$co_name =  htmlspecialchars($_POST['co_name']);
$phone = htmlspecialchars(mb_convert_kana($_POST['phone'], "a"));

$sql = <<<SQL
INSERT INTO companies (co_name,phone) VALUES (?,?)
SQL;

try {
    $dbh = getDb();
    
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $co_name, PDO::PARAM_STR);
    $stmt->bindValue(2, $phone, PDO::PARAM_STR);
    $stmt->execute();
} catch (PDOException $e) {
    print "ERR! : {$e->getMessage()}";
} finally {
    $dbh = null;
}
    header('Location: ./co_list.php');
